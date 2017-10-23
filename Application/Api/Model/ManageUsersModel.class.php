<?php

namespace Api\Model;

use Think\Model;

class ManageUsersModel extends BaseModel
{

    /**
     * @param string $username 登录账号
     * @param string $password 登录密码
     * @param int $type 不设置为正常登录，1：微信自动登录
     * @return mixed  返回是否登录成功
     */
    public function login($username = "", $password = "")
    {

        $info = $this->field("user_id,authentication,mobile,nickname,desc,head_pic,sex,province,city,district")->where("mobile=$username AND password='$password'")->find();
        return $info;
    }

    /**
     * @param array $data 指定用户要注册的信息
     * @return int|mixed   返回是否注册成功
     */
    public function register($data = array())
    {

        $info = $this->where("mobile={$data['mobile']}")->find();
        if (!empty($info)) {
            return 0;   //账号已存在
        } else {
            $info = $this->add($data);
            if ($info) {
                return $info;   //注册成功，返回用户注册ID
            } else {
                return -1;   //注册异常
            }
        }
    }

    /**
     * @param int $id 指定要获取的用户信息ID
     * @return mixed 返回指定用户信息
     */
    public function getUserInfo($id = 0)
    {
        $info = $this->where("user_id=$id")->find();
        return $info;
    }

    /**
     * @param int $id 指定要修改的用户
     * @param array $data 传入要修改的数组
     * @return bool   返回是否编辑成功
     */
    public function editUserInfo($id = 0, $data = array())
    {
        $info = $this->where("user_id=$id")->save($data);
        return $info;
    }

    /**
     * @param int $id 指定对象ID
     * @param int $userId 指定本身ID
     * @param string $order 指定用户排序命令
     * @param int $limitNum 指定用户显示的数量
     * @param int $limitStart 指定需要从第几条开始显示
     * @return mixed   返回部分/全部用户信息
     */
    public function getUserList($getId = 0, $userId = 0, $order = "", $limitNum = 0, $limitStart = 0, $where = array())
    {
        if (count($where) == 0) {
            $where['1'] = '1';
        }

        if (!empty($getId)) {
            $info = $this->field("user_id,authentication,mobile,nickname,head_pic,desc")->where("user_id=$getId")->find();
            if ($info) {
                if (!$info["desc"]) {
                    $info["desc"] = "该用户未有简介";
                }
                $info2 = M("ManageUsersRelation")->where("from_user_id=$userId")->select();
                $info["relationNum"] = M("ManageUsersRelation")->where("to_user_id={$info['user_id']}")->count();
                foreach ($info2 as $value) {
                    if ($info["user_id"] == $value["to_user_id"]) {
                        $info["isRelation"] = 1;
                    }
                }
            } else {
                return 0;
            }
        } else {
            if (empty($limitStart)) {
                if (!empty($userId)) {
                    $info = $this->field("user_id,authentication,mobile,nickname,head_pic,desc")->where($where)->order($order)->limit($limitNum)->select();
                    $info2 = M("ManageUsersRelation")->where("from_user_id=$userId")->select();
                    foreach ($info as $item => $value) {
                        if (!$value["desc"]) {
                            $info[$item]["desc"] = "该用户未有简介";
                        }
                        foreach ($info2 as $item2 => $value2) {
                            $info[$item]["relationNum"] = M("ManageUsersRelation")->where("to_user_id={$value['user_id']}")->count();
                            if ($value["user_id"] == $value2["to_user_id"]) {
                                $info[$item]["isRelation"] = 1;
                            }
                        }
                    }
                } else {
                    $info = $this->field("user_id,authentication,mobile,nickname,head_pic,desc")->where($where)->order($order)->limit($limitNum)->select();
                    foreach ($info as $item => $value) {
                        if (!$value["desc"]) {
                            $info[$item]["desc"] = "该用户未有简介";
                        }
                        $info[$item]["relationNum"] = M("ManageUsersRelation")->where("to_user_id={$value['user_id']}")->count();
                    }
                }
            } else {
                if (!empty($userId)) {
                    $info = $this->field("user_id,authentication,mobile,nickname,head_pic,desc")->where($where)->order($order)->limit($limitStart, $limitNum)->select();
                    $info2 = M("ManageUsersRelation")->where("from_user_id=$userId")->select();
                    foreach ($info as $item => $value) {
                        if (!$value["desc"]) {
                            $info[$item]["desc"] = "该用户未有简介";
                        }
                        foreach ($info2 as $item2 => $value2) {
                            $info[$item]["relationNum"] = M("ManageUsersRelation")->where("to_user_id={$value['user_id']}")->count();
                            if ($value["user_id"] == $value2["to_user_id"]) {
                                $info[$item]["isRelation"] = 1;
                            }
                        }
                    }
                } else {
                    $info = $this->field("user_id,mobile,authentication,nickname,head_pic,desc")->where($where)->order($order)->limit($limitStart, $limitNum)->select();
                    foreach ($info as $item => $value) {
                        if (!$value["desc"]) {
                            $info[$item]["desc"] = "该用户未有简介";
                        }
                        $info[$item]["relationNum"] = M("ManageUsersRelation")->where("to_user_id={$value['user_id']}")->count();
                    }
                }
            }
        }
        return $info;
    }

    /**
     * @param array $data 用户要修改的密码
     * @return bool   返回是否重置成功
     */
    public function reset($data = array())
    {
        //将密码加密
        $data["password"] = encrypt($data["password"]);
        if ($data["user_id"]) {
            $info = $this->field("mobile")->where("user_id={$data['user_id']}")->find();
            if ($info["password"] == $data["password"]) {
                return -1;
            } else {
                $info = $this->where("user_id={$data['user_id']}")->save($data);
            }
        } elseif ($data["username"]) {
            $info = $this->field("password")->where("mobile={$data['username']}")->find();
            if ($info["password"] == $data["password"]) {
                return -1;
            } else {
                $info = $this->where("mobile={$data['username']}")->save($data);
            }
        }
        return $info;
    }

    /**
     * 判断用户是否存在
     * @param $id int 用户id
     * @param $username string 用户名
     * @param $mobile string 手机号
     * @return mixed 返回真假
     */
    public function isRegister($id, $username, $mobile)
    {
        if ($id) {
            $info = $this->where("user_id=$id")->count();
        } elseif ($username) {
            $info = $this->where("user_name=$username")->count();
        } else {
            $info = $this->where("mobile=$mobile")->count();
        }
        return $info;
    }

    public function getRelationUserList($getId)
    {
        $relationInfo = M("ManageUsersRelation")->where("to_user_id=$getId")->select();
        $array = array();
        foreach ($relationInfo as $item => $value) {
            $info = $this->getUserInfo($value["from_user_id"]);
            $array[] = $info;
        }
        foreach ($array as $item => $value) {
            if (empty($array[$item])) unset($array[$item]);
        }
        return $array;
    }

}