<?php
namespace Admin\Model;
use Common\Model\BaseModel;

class SystemChannelFormFieldModel extends BaseModel {

    /*
     * 获取频道表字段
     * **/
    public function getFields($filed, $where){
        return $this->field($filed)
                    ->where($where)
                    ->select();
    }
}
