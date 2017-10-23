<?php

namespace Api\Model;

use Think\Model;

class ManageUserMessageModel extends BaseModel
{
    public function getSystemMsg($order, $limitNum, $limitStart)
    {
        if (empty($limitStart)) {
            $info = $this->field("id,type,title,content,post_user_id,post_time")->order($order)->limit($limitNum)->select();
        } else {
            $info = $this->field("id,type,title,content,post_user_id,post_time")->order($order)->limit($limitStart, $limitNum)->select();
        }
        return $info;
    }
}