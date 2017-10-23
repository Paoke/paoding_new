<?php

namespace Api\Model;

use Think\Model;

class CommonCollectModel extends BaseModel
{
    public function favoriteList($id = 0, $channel_id = 0, $likeNum = 0, $order = "")
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

    public function favorite($form = "",$data = array())
    {
        $data["id"] = 0;
        $info = $this->where("collect_user_id={$data["collect_user_id"]} AND data_id={$data["data_id"]}")->find();
        if ($info) {
            $this->where("collect_user_id={$data["collect_user_id"]} AND data_id={$data["data_id"]}")->delete();
            $articleLikesNum = M($form)->field("favorites")->where("id={$data["data_id"]}")->find();
            if ($articleLikesNum["favorites"] == 0) {
                return 0;
            } else {
                $info = M($form)->where("id={$data["data_id"]}")->setDec("favorites");
                if ($info) return 0;
            }
        } else {
            $this->add($data);
            $info = M($form)->where("id={$data["data_id"]}")->setInc("favorites");
        }
        return $info;
    }

    public function favoriteTop($getId = 0, $top = 0)
    {
        if ($getId) {
            $info = $this->where("data_id=$getId")->order("collect_time ASC")->limit($top)->select();
            foreach ($info as $item => $value) {
                $info2 = M("ManageUsers")->field("user_id,authentication,mobile,nickname,head_pic,desc")->where("user_id={$value['collect_user_id']}")->find();
                $info[$item]["userInfo"] = $info2;
            }
        }
        return $info;
    }
}
