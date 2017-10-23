<?php

namespace Api\Model;

use Think\Model;

class SystemChannelFormFieldModel extends BaseModel
{
    /*
     * 获取表字段
     * @param channel 频道
     * @param table_name 表配置
     * @param all 是否取全部数据(默认只取mobile_use=1)
     * **/
    public function formList($channel = "", $table_name = array(), $all=false)
    {
        $where['channel'] = $channel;
        $where['table_name'] = $table_name['table_name'];
        if(!$all){
            $where['mobile_use'] = 1;
        }

        $info = $this->where($where)->order("mobile_sort ASC")->select();
        return $info;
    }

    public function formAdd($data = array())
    {

    }

}