<?php
/**
 * Created by PhpStorm.
 * User: SingHome
 * Date: 2016/11/15
 * Time: 10:18
 */

namespace Admin\Dao;


use Think\Log;

class ChannelFormFieldDao
{

    /**
     * 获取channel-module对应的列表字段
     * @param $channel 应用模块
     * @param $type 表类型
     * @param order 排序字段
     */
    public function getFormField($channel, $type, $order='id'){

        $condition['channel'] = $channel;
        $condition['type'] = $type;

        $files = M('SystemChannelFormField')->where($condition)->order($order)->select();

        return $files;
    }

}