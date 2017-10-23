<?php
namespace Common\Logic;
use Think\Model;
/**
 * 基础logic
 */
class BaseLogic extends Model{

    /**
     * 获取分页信息
     * @param $page_num 每页条数
     * @param $page_now 当前页数
     * **/
    public function getPage($page_num, $page_now){
        $page['num'] = $page_num ? $page_num : 25;//$page_num 每页几条数据
        $page['now'] = $page_now ? $page_now : 1;

        return $page;
    }

    /*
     * 分页获取列表数据
     * **/
    public function getList($param){}

    /*
     * 根据条件获取数据
     * **/
    public function getData($where){}

    /*
     * 添加数据
     * **/
    public function addData($data){}

    /*
     * 根据条件保存数据
     * **/
    public function editData($where, $data){}

    /*
     * 根据条件删除数据
     * **/
    public function deleteData($where){}
}
