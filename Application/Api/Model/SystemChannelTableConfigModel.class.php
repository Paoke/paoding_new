<?php

namespace Api\Model;

use Think\Model;

class SystemChannelTableConfigModel extends BaseModel
{
    /**
     * @param string $channel 频道名
     * @param int $type 1 为内容，2 为分类
     * @return array|false|mixed|\PDOStatement|string|Model 返回有前缀的表名与无前缀的表名
     */
    public function checkChannel($channel = "", $type = 0)
    {
        $info = $this->field("id, channel,table_format,table_name")->where("channel='$channel' AND type=$type")->find();
        return $info;
    }
}
