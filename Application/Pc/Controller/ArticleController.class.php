<?php
/**
 * Created by PhpStorm.
 * User: huanggui
 */

namespace Pc\Controller;

use Think\Log;

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
    public function data_list(){
        $channel=$_GET['channel'];
        $this->assign("channel", $channel);
        //是否跳到合作企业（庖丁----合作机构）
        $if_hzqy=$_GET['if_hzqy'];
        $this->assign("if_hzqy", $if_hzqy);
        
        $code = $_GET['code'];
        $this->assign("code", $code);
        $ifWeChatLogin = $_GET['ifWeChatLogin'];
        $this->assign("ifWeChatLogin", $ifWeChatLogin);
        $this->display($channel."_list");
    }
    /*
     * 详细数据
     */
    public function detail(){
        $channel=$_GET['channel'];
        $data_id = $_GET["data_id"];
        $getSelfUserId = $_SESSION["userArr"]["mobile"];
        $this->assign("mobile", $getSelfUserId);
        $this->assign("data_id", $data_id);
        $this->assign("channel", $channel);
        $code = $_GET['code'];
        $this->assign("code", $code);
        $ifWeChatLogin = $_GET['ifWeChatLogin'];
        $this->assign("ifWeChatLogin", $ifWeChatLogin);
        $this->display($channel."_detail");
    }
    public function top(){
        $channel=$_GET['channel'];
        $data_id = $_GET["data_id"];
        $data=M("ArticleJs")->where("sszt = '$data_id'")->select();
        $this->assign("data",$data);
        $this->assign("data_id", $data_id);
        $this->assign("channel",$channel);
        $this->display();
    }
    public function tlist(){
        $channel=$_GET['channel'];
        $data_id = $_GET["data_id"];
        $data=M("ArticleJs")->where("sszt = '$data_id'")->select();
        $this->assign("data",$data);
        $this->assign("data_id", $data_id);
        $this->assign("channel",$channel);
        $this->display();
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


