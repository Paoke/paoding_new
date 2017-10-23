<?php

namespace Api\Controller;

use Api\Logic\UserLogic;
use Think\Controller;
use Think\Log;

class MessageController extends BaseRestController
{
    public function _initialize()
    {
        parent::_initialize();
    }

    /*
   * 获取系统消息统计
   */
    public function getMessageCount() {
        $count = M("ManageUserMessage")
            ->where("is_read=0 AND accept_user_id = {$_SESSION["userArr"]["user_id"]}")
            ->count();
        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" =>$count);
        json_return($returnArr);
    }

    /*
    * 获取系统消息
    */
    public function getMessageList() {
        $info = M("ManageUserMessage")
            ->field("id,title,content,post_time,is_read")
            ->where("accept_user_id = {$_SESSION["userArr"]["user_id"]}")
            ->order("is_read ASC,post_time DESC")
            ->select();
        $i = 0;
        foreach ($info as $value) {
            $info[$i]['post_time'] = date_to_timestamp($info[$i]['post_time']);
            $i ++;
        }
        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" =>$info);
        json_return($returnArr);
    }

    /*
    * 获取系统消息详细
    */
    public function getMessageDetail() {
        $getData = I("get.");
        $Model=M("ManageUserMessage");
        $info = $Model->field("id,title,content,post_time,is_read")->where("id = ".$getData['id'])->find();
        if($info){//设置为已读
            $info['is_read']=1;
            $Model->save($info);
        }
        $info['post_time'] = date_to_timestamp($info['post_time']);
        $info['content'] = htmlspecialchars_decode($info['content']);
        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" =>$info);
        json_return($returnArr);
    }

}
