<?php

namespace Api\Model;

use Think\Model;

class CommonLikeModel extends BaseModel
{
    public function likeList($id = 0, $channel_id = 0, $likeNum = 0, $order = "")
    {
        $info = $this->where("channel_id=$channel_id AND data_id=$id")->count();
        if ($info) {
            if ($likeNum) {
                if ($info < $likeNum) {
                    return -1;
                } else {
                    $info = $this->where("channel_id=$channel_id AND data_id=$id")->order($order)->select();
                    return $info;
                }
            } else {
                $info = $this->where("channel_id=$channel_id AND data_id=$id")->order($order)->select();
                return $info;
            }
        } else {
            return 0;
        }
    }

    public function like($form = "", $data = array())
    {
        $data["id"] = 0;
        $info = $this->where("zan_user_id={$data["zan_user_id"]} AND data_id={$data["data_id"]}")->find();
        if ($info) {
            $this->where("zan_user_id={$data["zan_user_id"]} AND data_id={$data["data_id"]}")->delete();
            $articleLikesNum = M($form)->field("likes")->where("id={$data["data_id"]}")->find();
            if ($articleLikesNum["likes"] == 0) {
                return 0;
            } else {
                $info = M($form)->where("id={$data["data_id"]}")->setDec("likes");
                if ($info) return 0;
            }
        } else {
            $this->add($data);
            $info = M($form)->where("id={$data["data_id"]}")->setInc("likes");
        }
        return $info;
    }

    public function likeTop($getId = 0, $top = 0)
    {
        if (!empty($getId)) {
            $info = $this->where("data_id=$getId")->order("zan_time ASC")->limit($top)->select();
            foreach ($info as $item => $value) {
                $info2 = M("ManageUsers")->field("user_id,authentication,mobile,nickname,head_pic,desc")->where("user_id={$value['zan_user_id']}")->find();
                $info[$item]["userInfo"] = $info2;
            }
        }
        return $info;
    }
}
