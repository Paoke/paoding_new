<?php
namespace Admin\Logic;
use Common\Logic\BaseLogic;
use Think\Log;

/**
 * 广告逻辑
 * @package Admin\Logic
 */
class AdPositionLogic extends BaseLogic
{

    private $DAO = null;//当前表操作对象
    private $assign = null;//输出模板的变量
    private $is_assign = true;//是否输出模式

    public function __construct()
    {
        parent::__construct();
        $this->DAO = D('AdPosition');
        $this->assign = array();
    }

    /*
     * 改变输出模式
     * ajax请求不需要输出
     * **/
    public function setIsAssign($flag=true){
        $this->is_assign = $flag;
    }

    /*
     * 获取分页列表数据
     * @param $param 请求参数
     * **/
    public function getList($param){


        $where['is_open'] = 1;

        $count = $this->DAO->where($where)->count();
        $page = $this->getPage($param['page_num'], $param['page_now']);
        $page_total = ($count / $page['num']) > intval($count / $page['num']) ? intval($count / $page['num'] + 1) : intval($count / $page['num']); //$page     总共有几页
        $list = $this->DAO->getPageData($page, $where);

        if($this->is_assign){
            $this->assign['page']= $page_total;
            $this->assign['page_num'] = $page['num'];
            $this->assign['page_now'] = $page['now'];
            $this->assign['count'] = $count;
            $this->assign['list'] = $list;
            return $this->assign;
        }

        return $list;
    }

    public function getDataById($id){
        $where['id'] = $id;
        $data = $this->DAO->where($where)->find();
        return $data;
    }

    public function getData($where){
        $data = $this->DAO->where($where)->select();
        return $data;
    }

    public function addData($data){

        $data['start_time'] = strtotime($data['start_time']);
        $data['end_time'] = strtotime($data['end_time']);
        $data["add_user_id"] = $_SESSION["admin_id"];
        $data["add_time"] = date("Y-m-d H:i:s", time());

        return $this->DAO->addData($data);

    }

    public function saveData($data){
        return $this->editData(null, $data);
    }

    public function editData($where, $data){

        $data['start_time'] = strtotime($data['start_time']);
        $data['end_time'] = strtotime($data['end_time']);
        $data["add_user_id"] = $_SESSION["admin_id"];
        $data["add_time"] = date("Y-m-d H:i:s", time());


        return $this->DAO->editData($where, $data);
    }

    public function deleteDataById($id){
        $where['id'] = $id;
        return $this->deleteData($where);
    }

    public function deleteData($where){
        return $this->DAO->deleteData($where);
    }

    public function getAdPosition(){

        $fields = "position_id,position_name,is_open";
        $positionList = $this->DAO->getList(null, $fields);
        return $positionList;
    }

}