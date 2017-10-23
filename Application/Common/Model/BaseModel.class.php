<?php
namespace Common\Model;
use Think\Model;
/**
 * 基础model
 * 注意：1.所有where语句都使用数组形式
 */
class BaseModel extends Model{

    /**
     * 添加数据
     * @param  array $data  添加的数据
     * @return int          新增的数据id
     */
    public function addData($data){
        // 去除键值首尾的空格
        foreach ($data as $k => $v) {
            $data[$k]=trim($v);
        }
        $id=$this->add($data);
        return $id;
    }

    /**
     * 修改数据
     * @param   array   $map    where语句数组形式
     * @param   array   $data   数据
     * @return  boolean         操作是否成功
     */
    public function editData($map,$data){
        // 去除键值首位空格
        foreach ($data as $k => $v) {
            $data[$k]=trim($v);
        }
        $result=$this->where($map)->save($data);
        return $result;
    }

    /**
     * 删除数据
     * @param   array   $map    where语句数组形式
     * @return  boolean         操作是否成功
     */
    public function deleteData($map){
        if (empty($map)) {
            return false;
        }
        $result=$this->where($map)->delete();
        return $result;
    }

    /*
     * 获取数据
     * @param array $where
     * **/
    public function getData($where){
        $data = $this->where($where)->select();
        return $data;
    }

    /**
     * 数据排序
     * @param  array $data   数据源
     * @param  string $id    主键
     * @param  string $order 排序字段   
     * @return boolean       操作是否成功
     */
    public function orderData($data,$id='id',$order='order_number'){
        foreach ($data as $k => $v) {
            $v=empty($v) ? null : $v;
            $this->where(array($id=>$k))->save(array($order=>$v));
        }
        return true;
    }

    /**
     * 获取分页数据
     * @param  subject  $model  model对象
     * @param  array    $page   分页信息
     * @param  array    $map    where条件
     * @param  string   $order  排序规则
     * @param  integer  $field  字段
     * @return array            分页数据
     */
    public function getPageData($page, $map, $order='', $field=''){

        // 获取分页数据
        if (empty($field)) {
            $list=$this
                ->page($page['now'], $page['num'])
                ->where($map)
                ->order($order)
                ->select();
        }else{
            $list=$this
                ->page($page['now'], $page['num'])
                ->field($field)
                ->where($map)
                ->order($order)
                ->select();
        }

        return $list;
    }

}
