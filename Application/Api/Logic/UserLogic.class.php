<?php

namespace Api\Logic;

use Think\Controller;
use Think\Log;

class UserLogic extends BaseRestLogic
{
    private $dataId = 0;  //获取文章id
    private $selfUserId = 0;  //自身的用户id
    private $selfUserName = "";  //自身的用户名
    private $orderUserId = 0;  //传入的其他用户的id
    private $orderUserName = "";  //传入的其他用户的用户名
    private $userType = 0;  //获取指定用户群，0/其他，默认全部，1，普通用户，2，认证用户，3，企业认证用户
    private $username = "";  //用户账号
    private $password = "";  //用户密码
    private $count = 0;  //获取用户数量，1，全部男，2，全部女，3，会员，4，男会员，5，女会员，all，全部
    private $top = 0;  //获取头几条数据
    private $keywords = "";  //搜索的关键字
    private $orderMode = 0;  //排序的方式，1，为（ASC）正序，2，为（DESC）倒序
    private $limitNum = 0;  //查询的的时候，每次获取的条数
    private $limitStart = 0;  //查询的时候，从第几条查询
    private $mobile = "";  //手机号码

    //动态配置变量
    public function __invoke($options = array())
    {
        $this->form = $options["form"] ? $options["form"] : "";
        $this->dataId = $options["dataId"] ? $options["dataId"] : 0;
        $this->selfUserId = $options["selfUserId"] ? $options["selfUserId"] : 0;
        $this->selfUserName = $options["selfUserName"] ? $options["selfUserName"] : "";
        $this->orderUserId = $options["orderUserId"] ? $options["orderUserId"] : 0;
        $this->orderUserName = $options["orderUserName"] ? $options["orderUserName"] : "";
        $this->userType = $options["userType"] ? $options["userType"] : "";
        $this->username = $options["username"] ? $options["username"] : "";
        $this->password = $options["password"] ? $options["password"] : "";
        $this->count = $options["count"] ? $options["count"] : 0;
        $this->channel = $options["channel"] ? $options["channel"] : "";
        $this->channelId = $options["channel_id"] ? $options["channel_id"] : 0;
        $this->top = $options["top"] ? $options["top"] : 0;
        $this->keywords = $options["keywords"] ? $options["keywords"] : "";
        $this->orderMode = $options["orderMode"] ? $options["orderMode"] : 0;
        $this->limitNum = $options["limitNum"] ? $options["limitNum"] : 0;
        $this->limitStart = $options["limitStart"] ? $options["limitStart"] : 0;
        $this->mobile = $options["mobile"] ? $options["mobile"] : "";
    }

    //----------------------获取信息 start
    //获取全部、部分用户信息，参数：selfRelationNum，orderRelationNum
    public function getUserList()
    {
        if ($this->userType == 0) {
            $info = M()
                ->table("{$_SESSION["site_name"]}_manage_users")
                ->field("user_id,user_name,mobile,nickname,email,head_pic,sex,birthday,desc,province,city,district,openid,authentication")
                ->select();
        } elseif ($this->userType >= 1 && $this->userType <= 3) {
            $info = M()
                ->table("{$_SESSION["site_name"]}_manage_users")
                ->field("user_id,user_name,mobile,nickname,email,head_pic,sex,birthday,desc,province,city,district,openid,authentication")
                ->where("authentication={$this->userType}")
                ->select();
        }
        if ($info) {
            foreach ($info as $item => $value) {
                //获取用户关注数量
                $info[$item]["selfRelationNum"] = self::getUserSelfRelationNum($value["user_id"]);
                //获取用户粉丝数量
                $info[$item]["orderRelationNum"] = self::getUserSelfFansNum($value["user_id"]);
                $info[$item]["orderRelationNum"] = self::getUserSelfFansNum($value["user_id"]);
                //判断用户是否登录
                if ($_SESSION["userArr"]) {
                    //获取登录用户是否被关注
                    $info[$item]["isRelation"] = $this->isRelation($value["user_id"]);
                }
            }
            return $info;
        } else {
            return null;
        }
    }

//    //获取myfoot我的足迹
//    //----------------------获取信息 start
//    //获取全部、部分用户信息，参数：selfRelationNum，orderRelationNum
//    public function getMyFoot()
//    {
//        //动态获取文章表名
//        $tableArticleName = M("SystemChannelTableConfig")->field("table_format")->where("base_module = 'Article' AND type = '1'")->select();
//        //动态获取活动表名
//        $tableActivityName = M("SystemChannelTableConfig")->field("table_format")->where("base_module = 'Activity' AND type = '1'")->find();
//        $tableActivityName = $tableActivityName["table_format"];
//        $info = M("ManageUsers")->field("reg_time,log_number")->where("user_id = {$this->selfUserId}")->select()[0];//注册时间,登录次数
//        $info["join_activity_count"] = M("ActivityOrder")->where("user_id = {$this->selfUserId}")->count();  //参与的活动总数
//        $info_count = 0;
//        foreach ($tableArticleName as $value) {
//            foreach ($value as $value1) {
//                $info_count +=M("$value1")->where("create_user_id = {$this->selfUserId}")->count();
//            }
//        }
//        $info["info_count"] = $info_count; //发布消息的总数
//        $info["follow_people_count"] = M("ManageUsersRelation")->where("from_user_id = {$this->selfUserId} AND rel_type = '2'")->count();
//        $info["my_fans_count"] = M("ManageUsersRelation")->where("to_user_id = {$this->selfUserId} AND rel_type = '2'")->count();
//        $info_activity = M("ActivityOrder")->field("add_time,activity_id")->where("user_id = {$this->selfUserId}")->order("order_id")->find();
//        $activity_id = $info_activity["activity_id"];
//        $info["first_time"] = $info_activity["add_time"];
//        if($info["first_time"]) {
//            $info["first_time"] = substr($info_activity["add_time"],0,16);
//        }
//        $info["first_title"] = M("$tableActivityName")->where("id='$activity_id'")->getField("title");
//
//        return $info;
//
//    }

    //获取指定用户信息
    public function getUserDetail()
    {
        $info = M()
            ->table("{$_SESSION["site_name"]}_manage_users")
            ->field("user_id,user_name,mobile,nickname,email,head_pic,sex,birthday,desc,province,city,district,openid,authentication")
            ->where("user_id={$this->orderUserId}")
            ->find();
        if ($info) {
            //获取用户关注数量
            $info["selfRelationNum"] = self::getUserSelfRelationNum($info["user_id"]);
            //获取用户粉丝数量
            $info["orderRelationNum"] = self::getUserSelfFansNum($info["user_id"]);
            //判断用户是否登录
            if ($_SESSION["userArr"]) {
                //获取登录用户是否被关注
                $info["isRelation"] = $this->isRelation($info["user_id"]);
            }
            return $info;
        } else {
            return null;
        }
    }

    //获取指定用户信息
    public function getDetail()
    {
        $info = M()
            ->table("{$_SESSION["site_name"]}_manage_users")
            ->field("user_id,user_name,mobile,nickname,email,head_pic,sex,birthday,desc,province,city,district,openid,authentication")
            ->where("user_id={$this->orderUserId}")
            ->find();
            return $info;
    }

    //用户登录，参数：username，password，返回用户信息
    public function login()
    {
        $info = M()
            ->table("{$_SESSION["site_name"]}_manage_users")->field("user_id,user_name,authentication,mobile,nickname,desc,head_pic,sex,province,city,district")
            ->where("mobile='{$this->mobile}' AND password='{$this->password}'")
            ->find();
        return $info ? $info : null;
    }

    //用户注册，参数：username，password，返回布尔值，是为真，否为假，录入异常返回 -1
    public function register($data = array())
    {
        $info = M()
            ->table("{$_SESSION["site_name"]}_manage_users")
            ->where("user_name={$data["user_name"]}")
            ->find();
        if ($info) {
            //账号已存在
            return false;
        } else {
            //账号不存在
            $info = M()
                ->table("{$_SESSION["site_name"]}_manage_users")
                ->add($data);
            //注册失败，返回 false，成功返回 true
            return $info ? true : false;

        }
    }
    //用户绑定
    public function binbang($data = array())
    {
        $info = M()
            ->table("{$_SESSION["site_name"]}_manage_users")
            ->where("user_id={$data['user_id']}")
            ->save($data);
        return $info ? true:false;
    }

    //修改绑定
    public function Modify($data = array())
    {
        $info = M()
            ->table("{$_SESSION["site_name"]}_manage_users")
            ->where("user_id={$data['user_id']}")
            ->save($data);
        return $info ? true : false;

    }

    //重置密码
    public function reset($data = array())
    {
        //判断用户是否是已经登录的
        if ($data["user_id"]) {
            $info = M()
                ->table("{$_SESSION["site_name"]}_manage_users")
                ->field("password")
                ->where("user_id={$data["user_id"]}")
                ->find();
            if ($info["password"] == $data["password"]) {
                return false;
            } else {
                $info = M()
                    ->table("{$_SESSION["site_name"]}_manage_users")
                    ->where("user_id={$data["user_id"]}")
                    ->save($data);
                return $info ? true : -1;
            }
        } elseif ($data["username"]) {
            $info = M()
                ->table("{$_SESSION["site_name"]}_manage_users")
                ->field("password")
                ->where("mobile={$data['username']}")
                ->find();
            if ($info["password"] == $data["password"]) {
                return false;
            } else {
                $info = M()
                    ->table("{$_SESSION["site_name"]}_manage_users")
                    ->where("mobile={$data['username']}")
                    ->save($data);
                return $info ? true : -1;
            }
        }
    }

    /**
     * @param array $data 关注用户的信息
     * @return int -1 为取消关注，1 为关注，并添加关注用户信息
     */
    public function relation($data = array())
    {
        $info = M()
            ->table("{$_SESSION["site_name"]}_manage_users_relation")
            ->where("from_user_id={$data['from_user_id']} AND to_user_id={$data['to_user_id']}")
            ->find();
        if ($info) {
            M()->table("{$_SESSION["site_name"]}_manage_users_relation")
                ->where("from_user_id={$data['from_user_id']} AND to_user_id={$data['to_user_id']}")
                ->delete();
            return -1;
        } else {
            M()->table("{$_SESSION["site_name"]}_manage_users_relation")
                ->add($data);
            return 1;
        }
    }

    /**
     * @param array $id 传入被关注者(to_user_id)的id
     * @return array 返回粉丝的列表信息
     */
    public function fansList()
    {
        $userInfo = array();
        //获取该用户的所有粉丝
        $info = M()
            ->table("{$_SESSION["site_name"]}_manage_users_relation")
            ->where("to_user_id={$this->orderUserId}")
            ->select();
        foreach ($info as $item => $value) {
            //将获取的粉丝的id值重新传入，获取粉丝信息
            $this->orderUserId = $value["from_user_id"];
            $userInfo[] = $this->getUserDetail();
        }
        return $userInfo;
    }

    /**
     * @param array $id 传入自身(from_user_id)的id
     * @return array 返回关注用户的列表信息
     */
    public function relationList()
    {
        $userInfo = array();
        //获取该用户的所有关注用户
        $info = M()
            ->table("{$_SESSION["site_name"]}_manage_users_relation")
            ->where("from_user_id={$this->selfUserId}")
            ->select();
        foreach ($info as $item => $value) {
            //将获取的关注用户的id值重新传入，获取关注用户信息
            $this->orderUserId = $value["to_user_id"];
            $userInfo[] = $this->getUserDetail();
        }
        return $userInfo;
    }

    /**
     * @param array $data 录入反馈信息
     * @return int  返回是否录入成功，1，成功，0，失败，-1，超过一天设定的最多数量
     */
    public function feedback($data = array())
    {
        $today = strtotime(date("Y-m-d", time()));
        $count = M()
            ->table("{$_SESSION["site_name"]}_system_feedback")
            ->where("msg_time>$today")
            ->count();
        if ($count > $data["max"]) {
            return -1;
        } else {
            $info = M()
                ->table("{$_SESSION["site_name"]}_system_feedback")
                ->add($data);
            return $info ? 1 : 0;
        }
    }

    //获取所有反馈用户信息
    public function feedbackList()
    {
        $userInfo = array();
        //获取所有反馈用户信息
        $info = M()
            ->table("{$_SESSION["site_name"]}_system_feedback")
            ->select();
        foreach ($info as $item => $value) {
            //将获取的关注用户的id值重新传入，获取关注用户信息
            $this->orderUserId = $value["user_id"];
            $userInfo[] = $this->getUserDetail();
        }
        return $userInfo;
    }

    //获取自身用户所有意见反馈
    public function myFeedback()
    {
        //获取所有反馈用户信息
        $info = M()
            ->table("{$_SESSION["site_name"]}_system_feedback")
            ->where("user_id={$this->selfUserId}")
            ->select();
        return $info ? $info : false;
    }

    //获取系统消息
    public function getSystemMsg($myselfId)
    {
        $info = M()
            ->table("{$_SESSION["site_name"]}_manage_user_message")
            ->field("id,type,title,content,post_user_id,post_time")
            ->where("accept_user_id= $myselfId")
            ->select();
        foreach ($info as $item => $value) {
            $info[$item]["post_time"] = date_to_timestamp($value["post_time"]);
        }
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
    //----------------------获取信息 end


    //---------------------获取数量  start
    /**
     * @return int 返回会员人数
     */
    public function getUserNum()
    {
        if ($this->count == 1) {
            //返回全部男用户人数
            $info = M()
                ->table("{$_SESSION["site_name"]}_manage_users")
                ->where("sex = 1")
                ->count();
        } elseif ($this->count == 2) {
            //返回全部女用户人数
            $info = M()
                ->table("{$_SESSION["site_name"]}_manage_users")->where("sex = 2")
                ->count();
        } elseif ($this->count == 3) {
            //返回系统中的会员
            $info = M()
                ->table("{$_SESSION["site_name"]}_manage_users")->where("authentication>1")
                ->count();
        } elseif ($this->count == 4) {
            //返回系统中的男会员
            $info = M()
                ->table("{$_SESSION["site_name"]}_manage_users")->where("sex = 1 AND authentication>1")
                ->count();
        } elseif ($this->count == 5) {
            //返回系统中的女会员
            $info = M()
                ->table("{$_SESSION["site_name"]}_manage_users")
                ->where("sex = 2 AND authentication>1")
                ->count();
        } elseif ($this->count == "all" && $this->count) {
            //返回全部会员人数
            $info = M()
                ->table("{$_SESSION["site_name"]}_manage_users")
                ->count();
        } else {
            return 0;
        }
        return $info;
    }

    //返回是否关注该用户(状态)
    public function getUserIsRelationNum($selfUserId)
    {
        $myselfId = $_SESSION["userArr"]["user_id"];
        $info = M()
            ->table("{$_SESSION["site_name"]}_manage_users_relation")
            ->where("to_user_id = $selfUserId AND from_user_id = $myselfId")
            ->count();
        if($info) {
            return true;
        } else {
            return false;
        }
    }
    //返回是否关注该用户（文字）
    public function getUserIsRelation($selfUserId)
    {
        $myselfId = $_SESSION["userArr"]["user_id"];
        $info = M()
            ->table("{$_SESSION["site_name"]}_manage_users_relation")
            ->where("to_user_id = $selfUserId AND from_user_id = $myselfId")
            ->count();
        if($info) {
            $wenzi = '已关注';
            return $wenzi;
        } else {
            $wenzi = '加关注';
            return $wenzi;
        }
    }
    //返回用户关注的数量
    public function getUserSelfRelationNum($selfUserId)
    {
        $info = M()
            ->table("{$_SESSION["site_name"]}_manage_users_relation")
            ->where("from_user_id = $selfUserId")
            ->count();
        return $info;
    }

    //返回用户粉丝的数量
    public function getUserSelfFansNum($selfUserId)
    {
        $info = M()
            ->table("{$_SESSION["site_name"]}_manage_users_relation")
            ->where("to_user_id = $selfUserId")
            ->count();
        return $info;
    }
    //---------------------获取数量  end


    //-------------------判断方法 start
    //判断是否已关注，参数：selfUserId，$userId（被关注的用户ID），返回布尔值，是为真，否为假
    public function isRelation($userId)
    {
        $info = M()
            ->table("{$_SESSION["site_name"]}_manage_users_relation")
            ->where("from_user_id ={$this->selfUserId} AND to_user_id = $userId")
            ->count();
        return $info ? true : false;
    }

    //判断是否用户注册，参数：orderUserId，username，返回布尔值，是为真，否为假
    public function isRegister()
    {
        //判断该id是否存在
        if ($this->orderUserId) {
            //查找是否有这个用户id
            $info = M('ManageUsers')
                ->where("user_id={$this->orderUserId}")
                ->count();
            return $info ? true : false;
        } elseif ($this->mobile) {
            //查找是否有这个用户账号
            $info = M('ManageUsers')
                ->where("mobile='".$this->mobile."'")
                ->count();
            return $info ? true : false;
        } else {
            return false;
        }
    }
    //重设密码 判断用户是否存在
    public function ResetCode($data=array())
    {
        //查找是否有这个用户账号
        $info = M('ManageUsers')
            ->where("user_name='".$data['username']."'")
            ->find();
        if(!$info){
            //该账号不存在
            return false;
        }else {
            $info = M('ManageUsers')
                ->where("user_name='".$data['username']."'")
                ->save($data);
            return $info ? true : false;
        }

    }
    //-------------------判断方法 end

    /*
     * 获取用户邮箱
     * **/
    public function getUserEmail($userId){
        $where['user_id'] = $userId;
        return M('ManageUsers')->where($where)->getField('email');
    }

    /*
     * 获取用户邮箱
     * **/
    public function getUserOpenid($userId){
        $where['user_id'] = $userId;
        return M('ManageUsers')->where($where)->getField('openid');
    }

    /*
     * 获取用户邮箱
     * **/
    public function getUser($userId){
        $where['user_id'] = $userId;
        return M('ManageUsers')->where($where)->find();
    }
}