<?php

namespace Api\Model;

use Think\Model;

class ManageUsersRelationModel extends BaseModel
{



    /**
     * @param array $data 关注用户的信息
     * @return int -1 为取消关注，1 为关注，并添加关注用户信息
     */
    public function relation($data = array())
    {
        $info = $this->where("from_user_id={$data['from_user_id']} AND to_user_id={$data['to_user_id']}")->find();
        if ($info) {
            $this->where("from_user_id={$data['from_user_id']} AND to_user_id={$data['to_user_id']}")->delete();
            return -1;
        } else {
            $this->add($data);
            return 1;
        }
    }

    /**
     * @param array $id 传入被关注者(to_user_id)的id
     * @return array 返回粉丝的列表信息
     */
    public function fans($id)
    {
        $userInfo = array();
        $info = $this->where("to_user_id=$id")->select();
        foreach ($info as $item => $value) {
            $userInfo[] = D("ManageUsers")->getUserInfo($value["from_user_id"]);
        }
        return $userInfo;
    }
}