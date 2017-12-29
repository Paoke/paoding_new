<?php
/**
 * Created by PhpStorm.
 * User: huanggui
 */

namespace Mobile\Controller;

class ArticleController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        parent::checkUrl();
    }

    /*
     * 数据列表
     */
    public function data_list()
    {
        $channel = $_GET['channel'];
        $type = $_GET['type'];
        $this->assign("channel", $channel);
        $this->assign("type", $type);
        if ($_GET['order_id']) {
            $this->assign("order_id", $_GET['order_id']);
        }
        $this->display($channel . "_list");
    }

    /*
     * 子表列表
     */
    public function child_list()
    {
        $channel = $_GET['channel'];
        $child = $_GET['child'];
        $dataId = $_GET['data_id'];
        $where['channel_index'] = $channel;
        $where['child_index'] = $child;
        $childInfo = M('SystemChannelChild')->where($where)->find();
        $this->assign("channel", $channel);
        $this->assign("type", $childInfo['type']);
        $this->assign("child", $child);
        $this->assign("data_id", $dataId);
        if ($_GET['order_id']) {
            $this->assign("order_id", $_GET['order_id']);
        }
        $this->display($child . "_list");
    }

    /*
     * 详细数据
     */
    public function child_detail()
    {
        $channel = $_GET['channel'];
        $child = $_GET['child'];
        $data_id = $_GET["data_id"];
        $where['channel_index'] = $channel;
        $where['child_index'] = $child;
        $childInfo = M('SystemChannelChild')->where($where)->find();
        $this->assign("channel", $channel);
        $this->assign("type", $childInfo['type']);
        $this->assign("child", $child);
        $this->assign("data_id", $data_id);
        $this->display($child . "_child_detail");
    }

    /*
     * 详细数据
     */
    public function detail()
    {
        $channel = $_GET['channel'];
        $data_id = $_GET["data_id"];
        $this->assign("data_id", $data_id);
        $this->assign("channel", $channel);
        $this->display($channel . "_detail");
    }

    /*
     * 新增数据
     */
//    public function add(){
//        $channel=$_GET['channel'];
//        $data_id = $_GET["data_id"];
//        $this->assign("data_id", $data_id);
//        $this->assign("channel", $channel);
//        $this->display($channel."_add");
//    }

    /*
     * 编辑数据
     */
    public function edit()
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
    public function del()
    {
        $channel = $_GET['channel'];
        $data_id = $_GET["data_id"];
        $this->assign("data_id", $data_id);
        $this->assign("channel", $channel);
        $this->display($channel . "_del");
    }

    /*
     * 查询数据
     */
    public function search()
    {
        $search = $_POST['search'];
        $channel = $_GET['channel'];
        $this->assign("channel", $channel);
        $this->assign("search", $search);
        $this->display($channel . "_search");
    }


    /*
     * 新增数据
     */

    public function add()
    {
        $this->checkReg();
        $channel = $_GET["channel"];
        $moduleType = $_GET['type'];
        $tableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("table_format");
        $systemChannel = M("SystemChannel")->field("id,is_export_data")->where("call_index='$channel'")->find();
        if ($channel) {
            $postData = I("post.");
            $isCopy = $_GET["iscopy"];
            $tags = $postData['tag_name'];
            $tagsTable = M("SystemChannelTableConfig")->where("channel='$channel' AND type='4'")->getField("table_format");
            $tagsRelationTable = M("SystemChannelTableConfig")->where("channel='$channel' AND type='5'")->getField("table_format");

            //判断是否置顶数据
            if ($postData['is_red'] != "1") {
                $postData['is_red'] = 0;
            }
            //检查用户是否绑定过
//                    if(M('SystemRelation')->where("channel_id=".$channelId." AND user_id=".$postData['bind_user_id'])->count()>0) {
//                        $this->logRecord(5, "新增数据【" . $postData["title"] . "】失败，用户重复绑定",3);
//                        $returnArr = array("result" => 0, "msg" => "保存失败，用户重复绑定", "code" => 402, "data" => null);
//                        break;
//                    }
            //添加函数
            $dataId = $this->addArticle($channel, $tableName, $postData, $isCopy);
            if ($dataId) {
                //根据绑定用户id，记录绑定关系
                //$this->bindUser($channelId,$postData['bind_user_id'],$dataId);

                //处理tag
                if ($tags) {
                    foreach ($tags as $value) {
                        $tagInfo = M("$tagsTable")->field("remark,tag_name")->where("id = '$value'")->find();
                        $relationData['channel_id'] = $systemChannel['id'];
                        $relationData['tag_id'] = $value;
                        $relationData['data_id'] = $dataId;
                        $relationData['remark'] = $tagInfo['remark'];
                        $relationData['tag_name'] = $tagInfo['tag_name'];
                        $relationData["create_time"] = date("Y-m-d H:i:s", time());
                        M("$tagsRelationTable")->add($relationData);
                    }
                }
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $dataid = M("$tableName")->order('id desc')->limit(0)->getField("id");
                $channel_id = M("$tableName")->getField("channel_id");

                //记录操作日志
                $this->logRecord(6, "发布" . $postData["title"] . "成功", 3, $channel_id, $dataid, $postData['user_id']);
                $admin_mobile=M('manage_users')->where('user_id=2')->field('mobile')->find();
                $content = "【庖丁众包】尊敬的用户，您于".date('Y')."年".date('m')."月".date('d')."日成功提交的技术/需求资料到庖丁众包平台，平台将以两个工作日内以站内信形式发送审核结果，届时请留意，谢谢！";
                $content_admin="【庖丁众包】才华与美貌并重的管理员，您好！有用户在线上提交了技术/需求项目，请您尽快查看审核。您辛苦了！";
                send_note($content_admin,$admin_mobile['mobile']);
                sendNotice($content);

                $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
            } else {
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "发布" . $postData["title"] . "失败");
                $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
            }
        } else {
            $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }


    private function addArticle($channelIndex, $tableName, $data = array(), $isCopy)
    {
        $con['call_index'] = $channelIndex;
        $con['is_active'] = 1;
        $channel = M("SystemChannel")->where($con)->find();
        //将建立的用户名与建立时间赋值给数组。
        /*  if($isCopy == 1) {
              $data = $this->getCopyImage($data);
          }*/
        $data['channel_id'] = $channel['id'];
        $data["create_user_id"] = $data["user_id"];
        $data["create_user"] = M("ManageUsers")->where("user_id=" . $data['create_user_id'])->getField("user_name");
        $data["create_time"] = date("Y-m-d H:i:s", time());
        $data['is_active'] = 0;
        $data['is_delete'] = 0;
        $data["status"] = 1;

        //***********************判断是否自动审核**********************/

        $info = M("$tableName")->add($data);
        return $info;
    }


    /**
     * 日志记录，用于内容管理的各种操作进行记录
     * @param int $level 日志警告级别,1：特别严重警告，2：严重警告，3：较大警告，4：一般警告，5：日志预警，6：普通操作
     * @param string $str 拼接字符串
     * @param int $operate_type 操作类型，-1未知类型，0管理员登陆，1用户登陆、2查看、3新增、4修改、5删除、6审核
     * @param int $channel_id 频道名称id,-1为空，
     * @param int $data_id 被记录日志的数据的id，-1为空
     */
    public function logRecord($level = 6, $str = "", $operate_type = -1, $channel_id = -1, $data_id = -1, $user_id)
    {
        if (is_numeric($level) && !empty($level)) {
            $data["log_ip"] = $_SERVER["REMOTE_ADDR"];
            $data["admin_id"] = $user_id;
            $data["admin_user_name"] = M("ManageUsers")->where("user_id=" . $user_id)->getField("user_name");
            $data["user_id"] = $user_id;
            $data["log_time"] = date("Y-m-d H:i:s", time());
            $data["log_url"] = $_SERVER["REQUEST_URI"];
            $data["log_level"] = $level;

            $data["log_info"] = "用户" . $str;

            $data["log_info"] = $str;

            $data["channel_id"] = $channel_id;
            $data["data_id"] = $data_id;
            $data["operate_type"] = $operate_type;//log类型：-1未知，0管理员登陆，1用户登陆、2新增、3修改、4删除、5审核
            $info = M("SystemLog")->add($data);

            if ($info) {
                $returnArr = array("result" => 1, "msg" => "日志添加数据成功", "code" => 200);
            } else {
                $returnArr = array("result" => 0, "msg" => "日志添加数据错误", "code" => 400);
            }
        } else {
            $returnArr = array("result" => 0, "msg" => "日志警告级别参数（1：特别严重警告，2：严重警告，3：较大警告，4：一般警告，5：日志预警，6：普通操作）", "code" => 400);
        }
        json_encode($returnArr);
    }


    /**
     * 收藏/取消收藏
     */
    public function like()
    {
        $channel = $_GET['channel'];
        $id = $_GET['id'];
        $action = $_GET['action'];
        if (empty($_SESSION["userArr"])) {
            $returnArr = array("result" => 0, "msg" => "请先登录", "code" => 402);
        }else{
            if($channel=='js'){
                $tableName='article_user_relation_js';
                $data['js_id']=$_GET['id'];
                $data['col']='js_id';
            }elseif($channel=='hz'){
                $tableName='article_user_relation_hz';
                $data['article_id']=$_GET['id'];
                $data['col']='article_id';
                $data['type']=$_GET['type'];
            } else{
                $tableName='article_user_relation_xq';
                $data['xq_id']=$_GET['id'];
                $data['col']='xq_id';
            }
            if($action=='1'){
                $data['user_id'] = $_SESSION["userArr"]["user_id"];
                M($tableName)->add($data);
            }else{
                M($tableName)->where('user_id=' . $_SESSION["userArr"]["user_id"] . ' and '.$data['col'].'=' .$data[$data['col']] )->delete();
            }
            $returnArr = array("result" => 1, "msg" => "操作成功", "code" => 200);

        }
        json_return($returnArr);
    }

    /**
     * 收藏列表
     */
    public function collect_list()
    {
        if (empty($_SESSION["userArr"])) {
            $returnArr = array("result" => 0, "msg" => "请先登录", "code" => 402);
        }else{
            $channel = $_GET['channel'];
            if($channel=='js'){
                $info=M('article_user_relation_js')
                    ->table('5u_article_user_relation_js A')
                    ->join('5u_article_js B ON A.js_id=B.id')
                    ->join("LEFT JOIN __ARTICLE_CATEGORY_JS__ AS C ON B.category_id=C.id")
                    ->field('A.*,B.*,C.cat_name')
                    ->where('A.user_id='.$_SESSION["userArr"]["user_id"])
                    ->select();
            }elseif($channel=='hz'){
                $type=$_GET['type'];
                if($type=='jtgs'){
                    $info=M('article_user_relation_hz')
                        ->table('5u_article_user_relation_hz A')
                        ->join('5u_article_jtgs B ON A.article_id=B.id')
                        ->field('B.*')
                        ->where('A.user_id='.$_SESSION["userArr"]["user_id"]." and A.type='$type'")
                        ->select();
                }else{
                    $info=M('article_user_relation_hz')
                        ->table('5u_article_user_relation_hz A')
                        ->join('5u_article_hzjg B ON A.article_id=B.id')
                        ->field('B.*')
                        ->where('A.user_id='.$_SESSION["userArr"]["user_id"]." and A.type='$type'")
                        ->select();
                }

            }else{
                $info=M('article_user_relation_xq')
                    ->table('5u_article_user_relation_xq A')
                    ->join('5u_article_xq B ON A.xq_id=B.id')
                    ->join('5u_article_category_xq C ON B.category_id=C.id')
                    ->field('B.*,C.cat_name')
                    ->where('A.user_id='.$_SESSION["userArr"]["user_id"])
                    ->select();
            }
            if ($info) {
                $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
            }else{
                $returnArr = array("result" => 0, "msg" => "没有数据或该用户不存在，否则为栏目不存在", "code" => 400);
            }
        }

        json_return($returnArr);
    }

    /**
     * 查看是否收藏
     */
    public function is_like()
    {
        $channel=$_GET['channel'];
        $data_id=$_GET['data_id'];

        if($channel=='js'){
            $tableName='article_user_relation_js';
            $column='js_id';
        }elseif ($channel=='hd'){
            $tableName='activity_user_relation_hd';
            $column='hd_id';
        }elseif($channel=='hz'){
            $tableName='article_user_relation_hz';
            $column='article_id';
        }else{
            $tableName='article_user_relation_xq';
            $column='xq_id';
        }

        $count=M($tableName)->where($column . '=' .$data_id . ' and user_id=' .$_SESSION["userArr"]["user_id"])->count();
        if($count){
            $returnArr = array("result" => 1, "msg" => "已收藏", "code" => 200);
        }else{
            $returnArr = array("result" => 0, "msg" => "未收藏", "code" => 402);
        }

        json_return($returnArr);
    }

    /**
     * 统计企业的技术项目
     */
    public function count_js()
    {
        $data_id=$_GET['data_id'];
        $action=$_GET['action'];
        if($action=='count'){
            $info=M('article_js')->where('is_deleted=0 and is_active=1 and status=0 and hzjg_id=' .$data_id)->count();
        }else{
            $info= M("ArticleJs")->join("AS A LEFT JOIN __ARTICLE_CATEGORY_JS__ AS B ON A.category_id=B.id")
                ->where('A.is_deleted=0 and A.is_active=1 and A.status=0 and A.hzjg_id=' .$data_id)
                ->field("B.cat_name,A.*")
                ->order('create_time DESC')
                ->select();
        }
        if($info){
            $returnArr = array("result" => 1, "msg" => "请求成功", "code" => 200,"data" => $info);
        }else{
            $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
        }

        json_return($returnArr);
    }

    /**
     * 企业应用事例
     */
    public function example()
    {
        $data_id=$_GET['data_id'];
        $action=$_GET['action'];
        if($action=='datalist'){
            $info=M('article_relation_yysl')
                ->where('hzjg_id='.$data_id)
                ->select();
        }else{
            $info=M('article_relation_yysl')->where('id='.$data_id)->select();
        }
        if($info){
            $returnArr = array("result" => 1, "msg" => "请求成功", "code" => 200,"data" => $info);
        }else{
            $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
        }

        json_return($returnArr);
    }

    /**
     * 我的技术/需求
     */
    public function my_project()
    {
        $channel=$_GET['channel'];
        $action=$_GET['action'];
        if($action=='datalist'){
            if($channel=='js'){
                $info=M('article_js')->where('create_user_id='.$_SESSION["userArr"]["user_id"].' and is_deleted=0')->order('create_time desc')->select();
            }else{
                $info=M('article_xq')->where('create_user_id='.$_SESSION["userArr"]["user_id"].' and is_deleted=0')->order('create_time desc')->select();
            }
            foreach($info as $k=>$v){
                $info[$k]['content']=htmlspecialchars_decode($info[$k]['content']);
            }
        }else{
            $data_id=$_GET['data_id'];
            if($channel=='js'){
                $info=M('article_js')->where('id='.$data_id)->find();
            }else {
                $info = M('article_xq')->where('id=' . $data_id)->find();
            }
            $info['content']=htmlspecialchars_decode($info['content']);
        }
        if($info){

            $returnArr = array("result" => 1, "msg" => "请求成功", "code" => 200,"data" => $info);
        }else{
            $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
        }

        json_return($returnArr);

    }

    /**
     * 合作机构收藏
     */


}


