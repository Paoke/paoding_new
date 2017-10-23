<?php

namespace Api\Logic;

use Think\Controller;

abstract class BaseRestLogic
{
    protected $channel = "";  //频道别名
    protected $channelId = 0;  //频道别名
    protected $tableName = "";  //获取本身频道表名，带前缀
    protected $tableFormat = "";  //获取本身频道双驼峰表名，不带前缀


    //动态获取表字段
    public function getField()
    {
        $sql = "SHOW FULL COLUMNS FROM __PREFIX__config";
        $info = M()->query($sql);
        foreach ($info as $item => $value) {
            $array[] = $value["field"];
        }
        return $array;
    }

    /**
     * 将表名赋值给父类的全局变量，返回布尔值
     * @param string $channel 频道名
     * @param int $type 1 为内容，2 为栏目
     * @return bool 有为真，无为假
     */
    public function setTable($channel = "", $type = 0)
    {
        $info = M()->table("{$_SESSION["site_name"]}_system_channel_table_config")->field("channel,table_format,table_name")->where("channel='$channel' AND type=$type")->find();
        if ($info) {
            $this->tableFormat = $info["table_format"];
            $this->tableName = $info["table_name"];
            $this->channel = $info["channel"];
            $this->channelId = M()->table("{$_SESSION["site_name"]}_system_channel")->where("call_index='{$this->channel}'")->getField("id");  //频道id
            return true;
        } else {
            return false;
        }

    }

    /**
     * @return array  返回表名参数
     */
    public function getTable()
    {
        return array("tableFormat" => $this->tableFormat, "tableName" => $this->tableName, "channel" => $this->channel, "channelId" => $this->channelId);
    }

    //获取全部频道的表名
    public function getAllTable()
    {
        $info = M()->table("{$_SESSION["site_name"]}_system_channel")->field("channel_title,call_index")->select();
        return $info ? $info : null;
    }

    //获取频道表
    public function getChannelTable($channel, $type)
    {
        $where['channel'] = $channel;
        $where['type'] = $type;
        $info = M('SystemChannelTableConfig')->field("id,channel,table_format,table_name")->where($where)->find();
        if($info){
            $prefix = get_site_name() . '_';
            $tableFormat2 = '__' . strtoupper(str_replace($prefix, '', $info['table_name'])) . '__';
            $info['table_format2'] = $tableFormat2;
        }
        return $info ? $info : null;
    }

}