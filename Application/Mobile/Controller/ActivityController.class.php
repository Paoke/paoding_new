<?php

namespace Mobile\Controller;

use Think\Controller;
use Think\Log;

class ActivityController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        parent::checkUrl();
    }

    public function activity()
    {
        $this->display();
    }

    public function share()
    {
        $this->display();
    }

    public function theme()
    {
        $this->display();
    }

    public function abutment()
    {
        $this->display();
    }

    /**
     * 收藏/取消收藏活动
     * @param $hd_id 活动序号id
     * @param $action 收藏/取消收藏
     */

    public function like($hd_id, $action)
    {
        if (empty($_SESSION["userArr"])) {
            $returnArr = array("result" => 0, "msg" => "请先登录", "code" => 402);
        } else {
            if ($action == '1') {
                $data['user_id'] = $_SESSION['userId'];
                $data['hd_id'] = $hd_id;
                M('activity_user_relation_hd')->add($data);
            } else {
                M('activity_user_relation_hd')->where('user_id=' . $_SESSION['userId'] . ' and hd_id=' . $hd_id)->delete();
            }
            $returnArr = array("result" => 1, "msg" => "操作成功", "code" => 200);

        }
        json_return($returnArr);
    }

    /**
     * 报名活动
     */

    public function enter()
    {
        if (IS_POST) {
            if (empty($_SESSION["userArr"])) {
                $returnArr = array("result" => 0, "msg" => "请先登录", "code" => 402);
            } else {
                $data = I('post.');
                $data['user_id'] = $_SESSION['userId'];
                $data['create_time'] = date("Y-m-d H:i:s");
                $result = M('activity_enter_hd')->add($data);
                if ($result) {
                    $activity = M('activity_hd')->where('id=' . $data['hd_id'])->field('title,plan_start_time,address')->find();
                    $content = "【庖丁众包】尊敬的用户，感谢您一直以来对庖丁众包平台的支持，平台致力于推送优质项目资源，我们将举行" . $activity['title'] . "活动，报名时间：" . $activity['plan_start_time'] . "；活动地点：" . $activity['address'] . "；诚邀您的参与！";
                    send_note($content, $_SESSION['userArr']['mobile']);
                    sendNotice($content);

                    $returnArr = array("result" => 1, "msg" => "操作成功", "code" => 402);
                } else {
                    $returnArr = array("result" => 0, "msg" => "报名失败", "code" => 402);
                }
            }

            json_return($returnArr);
        } else {
            $this->checkReg();
            $this->display();
        }

    }


    /*
        * 数据列表
        */
    public
    function data_list()
    {
        $action = $_GET['action'];
        if ($action == 'company') {
            $channel = $_GET['channel'];
            $account = session('company_account');

            $this->assign("channel", $channel);
            $this->assign('user_id', $account['user_id']);
            $this->display("company_" . $channel . "_list");
        } else if ($action == 'user') {
            $channel = $_GET['channel'];
            $this->assign("channel", $channel);
            $this->assign('user_id', session('userArr')['user_id']);
            $this->display("user_" . $channel . "_list");
        } else {
            $channel = $_GET['channel'];
            $this->assign("channel", $channel);
            $this->display($channel . "_list");
        }

    }

    /*
     * 子表列表
     */
    public
    function child_list()
    {
        $where['channel_index'] = $_GET['channel'];
        $where['child_index'] = $_GET['child'];
        $childInfo = M('SystemChannelChild')->where($where)->find();
        $param = I('post.');
        foreach ($param as $key => $val) {
            $this->assign($key, $val);
        }

        $this->assign("channel", $_GET['channel']);
        $this->assign("data_id", $_GET['data_id']);
        if ($_GET['order_id']) {
            $this->assign("order_id", $_GET['order_id']);
        }
        $this->assign("type", $childInfo['type']);
        $this->assign("child", $childInfo);
        $this->display($childInfo['child_index'] . "_list");
    }

    /*
        * 详细数据
        */
//    public function detail(){
//        $channel=$_GET['channel'];
//        $data_id = $_GET["data_id"];
//        $this->assign("data_id", $data_id);
//        $this->assign("channel", $channel);
//        $this->display($channel."_detail");
//    }
    public
    function detail()
    {
        $this->display();
    }


    /*
     * 新增数据
     */
    public
    function add()
    {
        $channel = $_GET['channel'];
        $data_id = $_GET["data_id"];
        $this->assign("data_id", $data_id);
        $this->assign("channel", $channel);
        $this->display($channel . "_add");
    }

    /*
    * 编辑数据
    */
    public
    function edit()
    {
        $channel = $_GET['channel'];
        $data_id = $_GET["data_id"];
        $this->assign("data_id", $data_id);
        $this->assign("channel", $channel);
        $this->display($channel . "_edit");
    }

    /*
     * 删除数据
     */
    public
    function del()
    {
        $channel = $_GET['channel'];
        $data_id = $_GET["data_id"];
        $this->assign("data_id", $data_id);
        $this->assign("channel", $channel);
        $this->display($channel . "_del");
    }

    public
    function info()
    {
        $action = $_GET['action'];
        if ($action == 'company') {
            $channel = $_GET['channel'];
            $id = $_GET["id"];
            $account = session('company_account');

            $this->assign('company_channel', $account['channel']);
            $this->assign('data_id', $account['data_id']);
            $this->assign("id", $id);
            $this->assign("channel", $channel);
            $this->display("company_" . $channel . "_info");

        } else {
            $channel = I('channel');
            $id = I('id');
            $this->assign("id", $id);
            $this->assign("channel", $channel);
            $this->display($channel . "_info");
        }

    }

    public
    function questionnaire()
    {
        $activity_id = $_GET['activity_id'];
        $channel = I('channel');
        $id = I('company_id');
        $this->assign("company_id", $id);
        $test_count = M("TestTopicsWeifan")->where("test_id ='$id'")->count();
        $this->assign("activity_id", $activity_id);
        $this->assign("test_count", $test_count);
        $this->assign("channel", $channel);
        $this->display("questionnaire_list");
    }

    public
    function companyList()
    {
        $action = $_GET['action'];
        $channel = I('channel');
        $id = I('activity_id');
        $this->assign("activity_id", $id);
        $this->assign('user_id', session('userArr')['user_id']);
        $this->assign("channel", $channel);
        $this->display("company_list");
    }

    public
    function result()
    {

        $channel = $_GET['channel'];
        $tag_id = $_GET["tag_id"];
        $search = $_POST['search'];
        if ($search) {
            $this->assign('search', $search);
        }
        $this->assign("tag_id", $tag_id);
        $this->assign("channel", $channel);
        $this->display($channel . "_result");
    }

//    //企业活动
//    public function release(){
//        $action = $_GET['action'];
//        $channel = $_GET['channel'];
//        if($action == 'company'){
//            $account= session('company_account');
//
//            $table = $this->getTableName($account['channel'], 1);
//            $accountInfo = M("$table")->where('id='.$account['data_id'])->field('title, logo_img')->find();
//            $account = array_merge($account, $accountInfo);
//
//            $this->assign('account', $account);
//            $this->assign('user_id', $account['user_id']);
//            $this->assign('channel', $channel);
//            $this->assign('company_channel', $account['channel']);
//            $this->assign('company_id', $_GET['data_id']);
//            $this->display('company_' . $channel . '_release');
//        }else{
//            $id = $_GET["id"];
//            $this->assign("id", $id);
//            $this->assign('channel', $channel);
//            $this->assign('user_id', session('userArr')['user_id']);
//            $this->display($channel . '_release');
//        }
//
//    }

//子表录入
    public
    function child_release()
    {
        $channel = $_GET['channel'];
        $type = $_GET['type'];

        $where['channel'] = $channel;
        $where['type'] = $type;
        $child = M('SystemChannelChild')->where($where)->find();
        $this->assign('channel', $channel);
        $this->assign('type', $type);
        $this->assign('data_id', $_GET['data_id']);
        if ($_GET['order_id']) {
            $this->assign('order_id', $_GET['order_id']);
        }

        $this->assign('child', $child);
        $this->display($child['child_index'] . '_release');

    }

    /*
     * 查询数据
     */
    public
    function search()
    {
        $search = $_POST['search'];
        $city = $_GET['city'];
        $channel = $_GET['channel'];

        $this->assign('city', urldecode($city));
        $this->assign("search", $search);
        $this->assign('category_id', $_GET['category_id']);
        $this->assign("channel", $channel);
        $this->display($channel . "_search");
    }

    public
    function order()
    {
        $channel = $_GET['channel'];
        $title = M('SystemChannel')->where("call_index='" . $channel . "'")->getField('channel_title');
        $this->assign("channel", $_GET['channel']);
        $this->assign("title", $title);
        $this->assign("tab_id", $_GET['tab_id']);
        $this->display($channel . '_order');
    }

    public
    function evaluate()
    {
        $channel = $_GET['channel'];
        $this->assign("channel", $_GET['channel']);
        $this->assign("id", $_GET['id']);
        $this->assign("order_id", $_GET['order_id']);
        $this->display($channel . '_evaluate');
    }

    public
    function collect()
    {
        $channel = $_GET['channel'];
        $this->assign("channel", $_GET['channel']);
        $this->assign("type", $_GET['type']);
        $this->display($channel . '_collect');
    }
}
