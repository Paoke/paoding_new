<?php
namespace Admin\Model;
use Common\Model\BaseModel;

class AdPositionModel extends BaseModel {

    public function getList($where, $field, $order=''){
        if(!$where){
            $where['1'] = '1';
        }
        if($field){
           $list = $this->field($field)
                ->where($where)
                ->order($order)
                ->select();
        }else{
            $list = $this->where($where)
                ->order($order)
                ->select();
        }

        return $list;
    }
}
