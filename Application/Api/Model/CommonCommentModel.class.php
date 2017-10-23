<?php

namespace Api\Model;

use Think\Model;

class CommonCommentModel extends BaseModel
{
    public function comment($data = array())
    {
        $info = $this->add($data);
        return $info;
    }

    public function commentList($getId = 0, $userId = 0, $channel_id = 0, $order = "", $limitNum = 0, $limitStart = 0)
    {
        if (empty($limitStart)) {
            $info = $this->where("data_id=$getId")->order($order)->limit($limitNum)->select();
            foreach ($info as $item => $value) {
                $info2 = D("ManageUsers")->getUserInfo($value["comment_user_id"]);
                $info[$item]["userInfo"] = $info2;
                $str = date_to_timestamp($value["comment_time"]);
                $info[$item]["comment_time"] = $str;
            }
        } else {
            $info = $this->where("data_id=$getId")->order($order)->limit($limitStart, $limitNum)->select();
            foreach ($info as $item => $value) {
                $info2 = D("ManageUsers")->getUserInfo($value["comment_user_id"]);
                $info[$item]["userInfo"] = $info2;
                $str = date_to_timestamp($value["comment_time"]);
                $info[$item]["comment_time"] = $str;
            }
        }
        return $info;
    }

    public function commentTop($getId = 0, $top = 0)
    {
        if ($getId) {
            $info = $this->where("data_id=$getId")->order("comment_time ASC")->limit($top)->select();
            foreach ($info as $item => $value) {
                $info2 = M("ManageUsers")->field("user_id,authentication,mobile,nickname,head_pic,desc")->where("user_id={$value['comment_user_id']}")->find();
                $info[$item]["userInfo"] = $info2;
            }
        }
        return $info;
    }
}












