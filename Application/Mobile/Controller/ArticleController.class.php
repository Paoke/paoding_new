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
    public function data_list(){
        $channel = $_GET['channel'];
        $type = $_GET['type'];
        $this->assign("channel", $channel);
        $this->assign("type", $type);
        if($_GET['order_id']) {
            $this->assign("order_id", $_GET['order_id']);
        }
        $this->display($channel."_list");
    }

    /*
     * 子表列表
     */
    public function child_list(){
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
        if($_GET['order_id']) {
            $this->assign("order_id", $_GET['order_id']);
        }
        $this->display($child."_list");
    }

    /*
     * 详细数据
     */
    public function child_detail(){
        $channel=$_GET['channel'];
        $child = $_GET['child'];
        $data_id = $_GET["data_id"];
        $where['channel_index'] = $channel;
        $where['child_index'] = $child;
        $childInfo = M('SystemChannelChild')->where($where)->find();
        $this->assign("channel", $channel);
        $this->assign("type", $childInfo['type']);
        $this->assign("child", $child);
        $this->assign("data_id", $data_id);
        $this->display($child."_child_detail");
    }

    /*
     * 详细数据
     */
    public function detail(){
        $channel=$_GET['channel'];
        $data_id = $_GET["data_id"];
        $this->assign("data_id", $data_id);
        $this->assign("channel", $channel);
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

    /**
     * 发布技术
     */
    public function release()
    {
        $this->checkReg();
        if($_POST){

        }else{

            $this->display();
        }


    }


}


