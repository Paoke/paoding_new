<?php
/**
 * Created by PhpStorm.
 * User: huanggui
 */

namespace Pc\Controller;

class ActivityController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        parent::checkUrl();
    }
    /*
     * 数据列表
     */
    public function data_list(){

        $channel=$_GET['channel'];
        //获取首页置顶数据,庖丁专用
        $ad=M("Activity_".$channel);
        $where['is_deleted']=0;
        $where['is_active']=1;
        $top=$ad->where($where)->order("is_red desc,create_time desc")->select();
        $this->assign("top",$top);
        //结束
        $code = $_GET['code'];
        $this->assign("code", $code);
        $ifWeChatLogin = $_GET['ifWeChatLogin'];
        $this->assign("ifWeChatLogin", $ifWeChatLogin);
        $this->assign("channel", $channel);
        $this->display($channel."_list");
    }
    /*
     * 详细数据
     */
    public function detail(){
        $channel=$_GET['channel'];
        $data_id = $_GET["data_id"];
        $getSelfUserId = $_SESSION["userArr"]["user_id"];
        $this->assign("userId", $getSelfUserId);
        $this->assign("data_id", $data_id);
        $this->assign("channel", $channel);
        $code = $_GET['code'];
        $this->assign("code", $code);
        $ifWeChatLogin = $_GET['ifWeChatLogin'];
        $this->assign("ifWeChatLogin", $ifWeChatLogin);
        $this->display($channel."_detail");
    }

    /*
     * 新增数据
     */
    public function add(){
        $channel=$_GET['channel'];
        $data_id = $_GET["data_id"];
        $this->assign("data_id", $data_id);
        $this->assign("channel", $channel);
        $this->display($channel."_add");
    }

    /*
     * 编辑数据
     */
    public function edit(){
        $channel=$_GET['channel'];
        $data_id = $_GET["data_id"];
        $this->assign("data_id", $data_id);
        $this->assign("channel", $channel);
        $this->display($channel."_edit");
    }

    /*
     * 删除数据
     */
    public function del(){
        $channel=$_GET['channel'];
        $data_id = $_GET["data_id"];
        $this->assign("data_id", $data_id);
        $this->assign("channel", $channel);
        $this->display($channel."_del");
    }

    /*
     * 查询数据
     */
    public function search(){
        $search = $_POST['search'];
        $channel=$_GET['channel'];
        $this->assign("channel", $channel);
        $this->assign("search",$search);
        $this->display($channel."_search");
    }
}


