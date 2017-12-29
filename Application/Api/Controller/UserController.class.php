<?php

namespace Api\Controller;

use Api\Logic\UserLogic;
use Com\Wechat;
use Think\Controller;
use Think\Log;
class UserController extends BaseRestController
{
    public $userId = 0;
    public $userArr = array();

    public function _initialize()
    {
        parent::_initialize();
        if (session("?userArr")) {
            //将用户基本信息存放于$this->userArr中
            $this->userArr = session("userArr");
        }
    }

    public function index( $userParameter  = array())
    {
        $getData = $_GET;
        $postData = $_POST;

        $getAction = $_GET["action"];  //操作参数
        if($getAction == null) {
            $getAction = $userParameter['action'];  //操作参数
        }
        $getSelfUserId = $_SESSION["userArr"]["user_id"];  //自身的用户id
        $getSelfUserName = $_SESSION["userArr"]["mobile"];  //自身的用户名
        $getOrderUserId = $_GET["id"];  //别人的用户id
        $relationType = 0; //为0 表明是同一类型的用户（在同一张表里），ID不可相同。例如人与人。
        if($getOrderUserId == null) {
            $getOrderUserId = $userParameter['company_id'];
            $getData["rel_type"] = 2 ; //为2 为关注
            $relationType = 1;  //为1 表明不是同一类型的用户，ID可相同。例如人与公司。
        }
        $getChannel = $_GET["channel"];  //频道别名

        //以下为暂定的
        $getChannelId = M("SystemChannel")->where("call_index='$getChannel'")->getField("id");  //频道id
        $getForm = $_GET["from"];  //频道表名
        $getType = $_GET["type"];  // 获取要查找的表名的类别，1，获取内容，2，获取分类
        $getDataId = $_GET["id"];  //获取文章id
        $getOrderUserName = $_GET["orderUserName"];  //别人的用户名
        $userType = $getData["userType"];  //获取指定用户群，0/其他，默认全部，1，普通用户，2，认证用户，3，企业认证用户
        $getTop = $_GET["top"];  //获取头几条数据
        $getKeywords = $_GET["keywords"];  //搜索的关键字
        $getOrderMode = $_GET["orderMode"];  //排序的方式，1，为（ASC）正序，2，为（DESC）倒序
        $getLimitNum = $_GET["limitNum"];  //查询的的时候，每次获取的条数
        $getLimitStart = $_GET["limitStart"];  //查询的时候，从第几条查询
        $getCount = $getData["count"];  //获取用户数量，1，全部男，2，全部女，3，会员，4，男会员，5，女会员，all，全部
        //调用用户类
        $user = new UserLogic();
        //需要登录才能操作的，不需要登录的暂时停掉
        if (!empty($getSelfUserId)) {
            switch ($getAction) {
                //获取部分、全部会员信息
                case "list":
                    //设置参数
                    $options = array(
                        "selfUserId" => $_SESSION["userArr"]["user_id"],  //自身的用户id
                        "orderUserId" => $getData["
                        "],  //传入的其他用户的id
                        "userType" => $getData["userType"], //获取指定用户群，0/其他，默认全部，1，普通用户，2，认证用户，3，企业认证用户
                    );
                    //传入参数
                    $user->__invoke($options);
                    //获取全部、部分用户信息，参数：selfRelationNum，orderRelationNum
                    $info = $user->getUserList();
                    if ($info) {
                        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
                    } else {
                        $returnArr = array("result" => 0, "msg" => "获取成功，但未获取到数据", "code" => 402, "data" => $info);
                    }
                    break;
                //获取用户的
                case "my_foot":
                    //设置参数
                    $options = array(
                        "selfUserId" => $getSelfUserId,  //自身的用户id
                    );
                    //传入参数
                    $user->__invoke($options);

                    //获取全部、部分用户信息，参数：selfRelationNum，orderRelationNum
                    $info = $user->getMyFoot();
                    if ($info) {
                        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
                    } else {
                        $returnArr = array("result" => 0, "msg" => "获取成功，但未获取到数据", "code" => 402, "data" => $info);
                    }
                    break;
                //获取指定会员详细信息
                case "detail":
                    //获取用详细信息
                    $info = $user->getUserDetail();
                    if ($info) {
                        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
                    } else {
                        $returnArr = array("result" => 0, "msg" => "获取成功，但未获取到数据", "code" => 402, "data" => $info);
                    }
                    break;
                //注册
                case "register":
                    //设置参数
                    $options = array(
                        "username" => $postData["username"],
                        "password" => encrypt($postData["password"]),
                        "password2" => encrypt($postData["password2"]),
                    );
                    //传入参数
                    $user->__invoke($options);
                    //验证表单不能为空
                    $returnArr = array("result" => 0, "msg" => "账号不能为空", "code" => 402, "data" => null);
                    if (empty($options["username"])) json_return($returnArr);
                    $returnArr = array("result" => 0, "msg" => "密码不能为空", "code" => 402, "data" => null);
                    if (empty($options["password"])) json_return($returnArr);
                    if (isset($options["password2"])) {
                        $returnArr = array("result" => 0, "msg" => "确认密码不能为空", "code" => 402, "data" => null);
                        if (empty($options["password2"])) json_return($returnArr);
                        $returnArr = array("result" => 0, "msg" => "密码不一致", "code" => 402, "data" => null);
                        if ($options["password"] != $options["password2"]) json_return($returnArr);
                    }
                    //将注册用户注册信息进行封装
                    $data = array(
                        "mobile" => $options["username"],  //手机号码
                        "password" => encrypt($options["password"]),  //用户密码
                        "sex" => 1,  //性别，默认为男
                        "desc" => "该用户未有简介",  //简介
                        "reg_time" => date("Y-m-d H:i:s", time()),   //注册时间
                        "head_pic" => "/Public/images/m_pic.png", //默认头像
                        "nickname" => $options["username"],  //用户名，默认为用户注册的手机
                    );
                    //用户注册信息添加
                    $info = $user->register($data);
                    //判断用户是否注册成功，0 表示存在用户，-1 表示提交数据系统未知错误，注册id 代表用户注册成功
                    if ($info == true) {
                        $returnArr = array("result" => 0, "msg" => "账号已经存在", "code" => 402);
                    } elseif ($info == -1) {
                        $returnArr = array("result" => 0, "msg" => "注册失败，系统繁忙", "code" => 500);
                    } else {
                        $returnArr = array("result" => 1, "msg" => "注册成功", "code" => 200);
                    }
                    break;
                //编辑信息
                case "edit":
                    if (!empty($getSelfUserName)) {
                        //给传送过来的值进行指定
                        $postNickname = $postData["nickname"];
                        $postDesc = $postData["desc"];
                        $postSex = $postData["sex"];
                        $postProvince = $postData["province"];
                        $postCity = $postData["city"];
                        $postDistrict = $postData["district"];
                        $postAddress = $postData["address"];
                        $postCompany = $postData["company"];
                        $postJob = $postData["job"];
                        $postTel = $postData["tel"];
                        //获取传送过来的键，通过键判断用户修改的是什么
                        foreach (array_keys($postData) as $value) {
                            //通过用户发送的键进行判断
                            switch ($value) {
                                //修改昵称
                                case"nickname":
                                    //如果设置为空的话不让修改
                                    if (!empty($postNickname)) {
                                        $data["nickname"] = $postNickname;
                                        //设置昵称长度不能超过15个字符
                                        if (mb_strlen($postNickname) <= 15) {
                                            //进入model进行编辑
                                            $info = $user->editUserInfo($getSelfUserName, $data);
                                            if ($info) {
                                                setcookie('nickname', $data["nickname"], null, '/');
                                                $returnArr = array("result" => 1, "msg" => "修改成功", "code" => 200);
                                            } else {
                                                $returnArr = array("result" => 0, "msg" => "修改失败，请重试", "code" => 404);
                                            }
                                        } else {
                                            $returnArr = array("result" => 0, "msg" => "请求错误，昵称最长为15个字符", "code" => 402);
                                        }
                                    } else {
                                        $returnArr = array("result" => 0, "msg" => "修改失败", "code" => 402);
                                    }
                                    json_return($returnArr);
                                    break; //修改昵称
                                case"desc":
                                    $data["desc"] = $postDesc;
                                    //设置昵称长度不能超过100个字符
                                    if (mb_strlen($postNickname) <= 100) {
                                        //进入model进行编辑
                                        $info = $user->editUserInfo($getSelfUserName, $data);
                                        if ($info) {
                                            $returnArr = array("result" => 1, "msg" => "修改成功", "code" => 200);
                                        } else {
                                            $returnArr = array("result" => 0, "msg" => "修改失败", "code" => 404);
                                        }
                                    } else {
                                        $returnArr = array("result" => 0, "msg" => "请求错误，简介最长为100个字符", "code" => 402);
                                    }
                                    json_return($returnArr);
                                    break;
                                case"company":
                                    $data["company"] = $postCompany;
                                    //设置昵称长度不能超过100个字符
                                    if (mb_strlen($postCompany) <= 50) {
                                        //进入model进行编辑
                                        $info = $user->editUserInfo($getSelfUserName, $data);
                                        if ($info) {
                                            $returnArr = array("result" => 1, "msg" => "修改成功", "code" => 200);
                                        } else {
                                            $returnArr = array("result" => 0, "msg" => "修改失败", "code" => 404);
                                        }
                                    } else {
                                        $returnArr = array("result" => 0, "msg" => "请求错误，公司名称最长为100个字符", "code" => 402);
                                    }
                                    json_return($returnArr);
                                    break;
                                case"job":
                                    $data["job"] = $postJob;
                                    //设置昵称长度不能超过100个字符
                                    if (mb_strlen($postJob) <= 50) {
                                        //进入model进行编辑
                                        $info = $user->editUserInfo($getSelfUserName, $data);
                                        if ($info) {
                                            $returnArr = array("result" => 1, "msg" => "修改成功", "code" => 200);
                                        } else {
                                            $returnArr = array("result" => 0, "msg" => "修改失败", "code" => 404);
                                        }
                                    } else {
                                        $returnArr = array("result" => 0, "msg" => "请求错误，所在职位最长为100个字符", "code" => 402);
                                    }
                                    json_return($returnArr);
                                    break;
                                case"tel":
                                    $data["tel"] = $postTel;
                                    //设置昵称长度不能超过100个字符
                                    if (mb_strlen($postTel) <= 50) {
                                        //进入model进行编辑
                                        $info = $user->editUserInfo($getSelfUserName, $data);
                                        if ($info) {
                                            $returnArr = array("result" => 1, "msg" => "修改成功", "code" => 200);
                                        } else {
                                            $returnArr = array("result" => 0, "msg" => "修改失败", "code" => 404);
                                        }
                                    } else {
                                        $returnArr = array("result" => 0, "msg" => "请求错误，办公电话最长为100个字符", "code" => 402);
                                    }
                                    json_return($returnArr);
                                    break;
                                //修改性别
                                case "sex":
                                    //如果设置为空的话不让修改
                                    if ((!empty($postSex)) && ($postSex == 1 || $postSex == 2)) {
                                        $data["sex"] = $postSex;
                                        //进入model进行编辑
                                        $info = $user->editUserInfo($getSelfUserName, $data);
                                        if ($info) {
                                            setcookie('sex', $data["sex"], null, '/');
                                            $returnArr = array("result" => 1, "msg" => "修改成功", "code" => 200);
                                        } else {
                                            $returnArr = array("result" => 0, "msg" => "修改失败，请重试", "code" => 404);
                                        }
                                    } else {
                                        $returnArr = array("result" => 0, "msg" => "修改失败", "code" => 402);
                                    }
                                    json_return($returnArr);
                                    break;
                                //修改省市区地址
                                case "province":
                                case "city":
                                case "district":
                                case "address":
                                    //如果设置为空的话不让修改
                                    if (!empty($postProvince) && !empty($postCity) && !empty($postDistrict)) {
                                        $data["province"] = $postProvince;
                                        $data["city"] = $postCity;
                                        $data["district"] = $postDistrict;
                                        $data["address"] = $postAddress;
                                        //进入model进行编辑
                                        $info = $user->editUserInfo($getSelfUserName, $data);
                                        if ($info) {
                                            setcookie('province', $data["province"], null, '/');
                                            setcookie('city', $data["city"], null, '/');
                                            setcookie('district', $data["district"], null, '/');
                                            setcookie('address', $data["address"], null, '/');
                                            $returnArr = array("result" => 1, "msg" => "修改成功", "code" => 200);
                                        } else {
                                            $returnArr = array("result" => 0, "msg" => "修改失败，服务器繁忙", "code" => 404);
                                        }
                                    } else {
                                        $returnArr = array("result" => 0, "msg" => "请求错误，地址设置错误", "code" => 402);
                                    }
                                    break;
                                default:
                                    $returnArr = array("result" => 0, "msg" => "请求错误，没有该编辑项", "code" => 402);
                                    break;
                            }
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "非法操作", "code" => 402);
                    }
                    break;
                //会员关注、黑名单接口
                case "relation":

                    //被关注的的用户
                    if (!empty($getOrderUserId)) {
                        $data["rel_type"] = $getData["rel_type"];  //设置关注类型，1，黑名单，2，关注
                        $data["from_user_id"] = $getSelfUserId;  //用户本人id
                        $data["to_user_id"] = $getOrderUserId;  //被关注拉黑人id
                        $data["add_time"] = date("Y-m-d H:i:s", time());

                        if ($data["rel_type"] == 1) {
                            //判断黑名单、关注用户是否是用户本人
                            if ($getOrderUserId == $getSelfUserId) {
                                $returnArr = array("result" => 0, "msg" => "不能将自己作为黑名单对象", "code" => 402);
                                break;
                            }
                            //将用户进行拉黑，加关注或者解除黑名单，取消关注
                            $info = $user->relation($data);
                            if ($info == 1) {
                                $returnArr = array("result" => 1, "msg" => "已拉入黑名单", "code" => 200, "data" => $info);
                            } elseif ($info == -1) {
                                $returnArr = array("result" => -1, "msg" => "取消成功", "code" => 200, "data" => $info);
                            }
                        } elseif ($data["rel_type"] == 2) {
                            //判断黑名单、关注用户是否是用户本人

                            if($relationType == 0) {
                                if ($getOrderUserId == $getSelfUserId) {
                                    $returnArr = array("result" => 0, "msg" => "不能将自己作为关注对象", "code" => 402);
                                    break;
                                }
                            }

                            //将用户进行拉黑，加关注或者解除黑名单，取消关注

                            $info = $user->relation($data);

                            if ($info == 1) {
                                $returnArr = array("result" => 1, "msg" => "关注成功", "code" => 200, "data" => $info);
                            } elseif ($info == -1) {
                                $returnArr = array("result" => -1, "msg" => "取消成功", "code" => 200, "data" => $info);
                            }
                        } else {
                            $returnArr = array("result" => 0, "msg" => "请求错误，请求参数设置有误", "code" => 402);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "请求错误，请求参数设置有误", "code" => 402);
                    }
                    break;
                //我的粉丝用户信息
                case "fansList":
                    $options = array("orderUserId" => $getOrderUserId, "userType" => $getData["userType"],);
                    $user->__invoke($options);
                    if (!empty($options["orderUserId"])) {
                        $info = $user->fansList();
                        if ($info) {
                            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
                        } else {
                            $returnArr = array("result" => 0, "msg" => "还未有粉丝关注您，请加油哦！", "code" => 402);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "请求错误，请求参数设置有误", "code" => 402);
                    }
                    break;
                //我的关注用户信息
                case "relationList":
                    $options = array("selfUserId" => $getSelfUserId, "userType" => $getData["userType"],);
                    $user->__invoke($options);
                    if (!empty($options["selfUserId"])) {
                        $info = $user->relationList();
                        if ($info) {
                            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
                        } else {
                            $returnArr = array("result" => 0, "msg" => "您还未有关注任何用户，请加油哦！", "code" => 402);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "请求错误，请求参数设置有误", "code" => 402);
                    }
                    break;
                //意见反馈
                case "feedback":
                    //验证表单不能为空
                    $returnArr = array("result" => 0, "msg" => "内容不能为空", "code" => 402);
                    if (empty($postData["feedback"])) {
                        json_return($returnArr);
                    } else {
                        $options = array(
                            "user_id" => $getSelfUserId,  //反馈人id
                            "user_name" => $getSelfUserName,  //反馈人名
                            "msg_title" => mb_substr($postData["feedback"], 0, 10),  //反馈人反馈信息截取前10个字为标题
                            "msg_content" => $postData["feedback"],  //反馈人的反馈信息
//                        "msg_type" => "mobile",  //通过什么客户端反馈
                            "msg_status" => 0,  //反馈默认状态
                            "msg_time" => time(),  //反馈时间
                            "ip_address" => $_SERVER['REMOTE_ADDR'],  //反馈人ip地址
                            "max" => is_numeric($postData["max"]),  //设置每天最多发几条反馈
                        );
                        //录入反馈信息，1，发送成功，-1，超出设定的最大量，0，系统繁忙
                        $info = $user->feedback($options);
                        if ($info == 1) {
                            $returnArr = array("result" => 1, "msg" => "发送成功", "code" => 200);
                        } elseif ($info == -1) {
                            $returnArr = array("result" => 0, "msg" => "客官，小墨每天只能接受" . $options["max"] . "条反馈信息哟", "code" => 402);
                        } else {
                            $returnArr = array("result" => 0, "msg" => "系统繁忙，请稍后再试", "code" => 402);
                        }
                    }
                    break;
                //获取所有意见反馈信息
                case "feedbackList":
                    $info = $user->feedbackList();
                    if ($info) {
                        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
                    } else {
                        $returnArr = array("result" => 0, "msg" => "网络繁忙", "code" => 402);
                    }
                    break;
                //获取自身用户反馈的所有意见
                case "myFeedback":
                    $info = $user->myFeedback();
                    if ($info) {
                        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
                    } else {
                        $returnArr = array("result" => 0, "msg" => "您未反馈任何意见哦，请多多支持我们！！", "code" => 402);
                    }
                    break;
                //系统消息
                case "systemMsg":
                    $info = $user->getSystemMsg($getSelfUserId);
                    if ($info) {
                        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
                    } else {
                        $returnArr = array("result" => 0, "msg" => "消息为空哟！", "code" => 402);
                    }
                    break;
                //其他
                default:
                    $returnArr = array("result" => 0, "msg" => "请求错误，请求参数设置有误", "code" => 402);
            }
        }
            json_return($returnArr);

    }

    /*
     * 检查登录状态,session存在返回true，不存在返回false
     */
    private function checkLoginStatus(){
        $getSelfUserId = $_SESSION["userArr"]["user_id"];  //自身的用户id
        if (!empty($getSelfUserId)) {
            return true;
        }
        return false;
    }

    /*
     * 登录
     */
    public function login(){
        $getData = $_GET;
        $postData = $_POST;
        $user = new UserLogic();
        //设置参数
        $options = array(
            "mobile" => $postData["mobile"],//新版改为mobile
            "password" => encrypt($postData["password"]),
//            "password2" => encrypt($postData["password2"]),
        );

        //传入参数
        $user->__invoke($options);
        //验证表单不能为空
        $returnArr = array("result" => 0, "msg" => "账号不能为空", "code" => 402);
        if (empty($options["mobile"])) json_return($returnArr);
        $returnArr = array("result" => 0, "msg" => "密码不能为空", "code" => 402);
        if (empty($options["password"])) json_return($returnArr);
        //判断是否登录，参数：orderUserId，username
        $bool = $user->isRegister();

        if ($bool) {
            //用户登录，参数：username，password
            $info = $user->login();
            if ($info) {
                session_unset();
                //存储用户基本信息
                session("userArr", $info);
                session("nickName", $info['nickname']);
                session("userId", $info['user_id']);
                session("userName", $info['user_name']);
                session("headPic", $info['head_pic']);
                //记录用户登录次数
                $log_number = M("ManageUsers")->where("user_id = {$_SESSION["userArr"]["user_id"]}") ->getField("log_number");
                $log_number++;
                M("ManageUsers")->where("user_id = {$_SESSION["userArr"]["user_id"]}")->setField('log_number',$log_number);
                //记录用户登录时间
                M("ManageUsers")->where("user_name='".$options["username"]."'")->save(array("last_login" => date("Y-m-d H:i:s", time())));
                if( $_SESSION["userArr"]["user_id"] ) {
                        $userIP = get_client_ip();
                        $data['user_id'] = $_SESSION["userArr"]["user_id"] ;
                        $data['user_ip'] = $userIP;
                        $data['create_time'] = date("Y-m-d H:i:s",time());
                        M("ManageUserRecord")->add($data);
                }
                $returnArr = array("result" => 1, "msg" => "登录成功", "code" => 200, "data" => $info);
            } else {
                $returnArr = array("result" => 0, "msg" => "账号或密码输入错误", "code" => 402);
            }
        } else {
            $returnArr = array("result" => 0, "msg" => "账号或密码输入错误", "code" => 402);
        }
        json_return($returnArr);
    }

    /*
     * 获取appid,area_name
     * */
    public function getAppIdData(){
        $config = M("Config");
        $options = array(
            'appid' => $config->where("name = 'appid'")->getField("value"), //微信开放平台appid
            'area_name' => $config->where("name = 'area_name'")->getField("value"), //微信开放台回调地址
        );
        if($options['appid']) {
            $returnArr = array("result" => 1, "msg" => "登录成功", "code" => 200, "data" => $options);
        }
        else {
            $returnArr = array("result" => 0, "msg" => "系统繁忙，请稍后再试。。。", "code" => 402);
        }
        json_return($returnArr);
    }


    /*
     * 网页微信扫码自动登录
     * */
    public function WeChatLogin(){
        $manageUsers = M("ManageUsers");
        $manageUsersOauth = M("ManageUsersOauth");
        $config = M("Config");
        $options = array(
            'appid' => $config->where("name = 'appid'")->getField("value"), //微信开放平台appid
            'appsecret' => $config->where("name = 'appsecret'")->getField("value"), //微信开放平台appsecret
            'encodingaeskey' => "", //填写高级调用功能的密钥
        );
        $wechat = new Wechat($options);
        $res = $wechat->getOauthAccessToken();
        $info = $wechat->getOauthUserinfo($res["access_token"],$res["openid"]);
        //判断此微信账号有没有unionid，
        if($info['unionid']){
            //根据wechat_pc和unionid获取user_id
            $userId = $manageUsersOauth->where("oauth_name ='wechat_pc' AND unionid  ='".$info['unionid']."'")->getField("user_id");
            //若user_id为空则根据uniodid去查找有没有相应的user_id，若没有则
            if(empty($userId)) {
                $unionId = $info['unionid'];
                $userId = $manageUsersOauth->where("unionid  = '$unionId'")->getField("user_id");
                //可以根据uniodid找到user_id，在user_oauth表建一条数据，
                if($userId) {
                    $this->WeChatRegister($info,$userId);
                } else {
                    //在user表和user_oauth表各建一条数据
                    $userId =  $this->WeChatRegister($info,'0');
                }
            }
        } else {
            //根据openid查找user_id
            $userId = $manageUsersOauth->where("oauth_name = 'wechat_pc' AND oauth_openid = '{$info['openid']}'")->getField("user_id");
            //如果user_id为空则在user表和user_oauth表都创建一条数据
            if(!$userId) {
                $userId =  $this->WeChatRegister($info,'0');
            }
        }
        //根据user_id获取user的基本信息
        $userInfo = $manageUsers->field("user_id,user_name,authentication,mobile,nickname,desc,head_pic,sex,province,city,district")
            ->where("user_id = ".$userId)
            ->find();
        if($userInfo) {
            //判断是否登录，参数：orderUserId，usernam
            session_unset();
            //存储用户基本信息
            session("userArr", $userInfo);
            session("nickName", $userInfo['nickname']);
            session("userId", $userInfo['user_id']);
            session("userName", $userInfo['user_name']);
            session("headPic", $userInfo['head_pic']);
            //记录用户登录次数
            $log_number = M("ManageUsers")->where("user_id = {$_SESSION["userArr"]["user_id"]}") ->getField("log_number");
            $log_number++;
            M("ManageUsers")->where("user_id = {$_SESSION["userArr"]["user_id"]}")->setField('log_number',$log_number);
            //记录用户登录时间
            M("ManageUsers")->where("user_name='".$options["username"]."'")->save(array("last_login" => date("Y-m-d H:i:s", time())));
            if( $_SESSION["userArr"]["user_id"] ) {
                $userIP = get_client_ip();
                $data['user_id'] = $_SESSION["userArr"]["user_id"] ;
                $data['user_ip'] = $userIP;
                $data['create_time'] = date("Y-m-d H:i:s",time());
                M("ManageUserRecord")->add($data);
            }
            $returnArr = array("result" => 1, "msg" => "登录成功", "code" => 200, "data" => $userInfo);
        } else {
            $returnArr = array("result" => 0, "msg" => "系统繁忙，请稍后再试。。。", "code" => 402);
        }
        json_return($returnArr);
    }

    /*
    * 网页微信登录时注册
    */
    public function WeChatRegister($data,$userId){
       //user_id为0，表示数据库里没有这个用户，需要在user表里创建这个用户
      if($userId ==0) {
          if($data['sex'] =='') {
              $data['sex'] = 0;
          }
          //将注册用户注册信息进行封装
          $addInfo = array(
              'openid' => $data['openid'],
              'oauth' => 'wechat_pc',
              'desc' => '该用户未填写简介',
              'nickname' => trim($data['nickname']),
              'sex' => $data['sex'],
              'province' => $data['province'],
              'city' => $data['city'],
              'head_pic' => $data['headimgurl'],
              "reg_time" => date("Y-m-d H:i:s", time()),   //注册时间
          );

          $userId = M("ManageUsers")->add($addInfo);
      }

        $addOauthInfo = array(
            'user_name' => trim($data['nickname']),
            'oauth_name' => 'wechat_pc ',
            'oauth_openid' => $data['openid'],
            'unionid' => $data['unionid'],
            'oauth_access_token' => ''
        );

        $addOauthInfo['add_time'] = date("Y-m-d H:i:s", time());
        $addOauthInfo['user_id'] = $userId;
        $oauthInfo = M("ManageUsersOauth")->add($addOauthInfo);
       if($oauthInfo) {
           return $userId;
       } else {
           return false;
       }
    }
    
    /*
     * 注销
     */
    public function logout(){
        $this->clean_session();
        foreach ($_COOKIE as $key => $value) {
            setcookie($key, '', time() - 3600, '/');   //删除cookie
        }
        $returnArr = array("result" => 1, "msg" => "成功绑定，请重新登录！", "code" => 200);
        json_return($returnArr);
    }


    /*
     * 注册
     */
    public function register(){
        //获取表单内容
        $username=$_POST["mobile"];
        $pwd=encrypt($_POST["password"]);
        $code=$_POST["code"];
        $nickname=$_POST['nickname'];
        //验证表单不能为空
        $returnArr = array("result" => 0, "msg" => "手机号不能为空", "code" => 402, "data" => null);
        if (empty($username)) json_return($returnArr);
        $returnArr = array("result" => 0, "msg" => "密码不能为空", "code" => 402, "data" => null);
        if (empty($pwd)) json_return($returnArr);

        //校验验证码
        $checkResult=check_mobile_code($username,$code);
        if($checkResult['result']!=1){
            json_return($checkResult);
        }
        //将注册用户注册信息进行封装
        $data = array(
            "user_name" =>$username,  //用户名，默认为用户注册的手机
            "mobile" =>$username, //手机号码
            "password" => $pwd,  //用户密码
            "sex" => 1,  //性别，默认为男
            "desc" => "该用户未有简介",  //简介
            "reg_time" => date("Y-m-d H:i:s", time()),   //注册时间
            "head_pic" => "/Public/images/m_pic.png", //默认头像
            "nickname" =>$nickname,  //昵称
        );
        //用户注册信息添加;
        $user = new UserLogic();
        $info = $user->register($data);
        //判断用户是否注册成功，0 表示存在用户，-1 表示提交数据系统未知错误，注册id 代表用户注册成功
        if ($info == false) {
            $returnArr = array("result" => 0, "msg" => "账号已经存在", "code" => 402);
        } else {
            M("ManageSmsLog")->where("mobile='".$username."'")->setField('is_active',0);
            //自动登陆
            $options = array(
                "username" => $username,
                "password" => $pwd,
            );
            $user->__invoke($options);
            $info = $user->login();
            //存储用户基本信息
            session("userArr", $info);
            session("userId", $info['user_id']);
            session("nickName", $info['nickname']);
            session("headPic", $info['head_pic']);
            //记录用户登录次数
            $log_number = M("ManageUsers")->where("user_id = {$_SESSION["userArr"]["user_id"]}") ->getField("log_number");
            $log_number++;
            M("ManageUsers")->where("user_id = {$_SESSION["userArr"]["user_id"]}")->setField('log_number',$log_number);
            //记录用户登录时间
            M("ManageUsers")->where("user_name='".$options["username"]."'")->save(array("last_login" => date("Y-m-d H:i:s", time())));
            if( $_SESSION["userArr"]["user_id"] ) {
                $userIP = get_client_ip();
                $data['user_id'] = $_SESSION["userArr"]["user_id"] ;
                $data['user_ip'] = $userIP;
                $data['create_time'] = date("Y-m-d H:i:s",time());
                M("ManageUserRecord")->add($data);
            }
            $content = "【庖丁众包】尊敬的用户，恭喜您加入庖丁众包平台，我们将竭力为您推荐最优质的技术/需求对接项目服务，获取更多的项目资讯！";
            send_note($content, $_SESSION['userArr']['mobile']);
            sendNotice($content,'');
            $returnArr = array("result" => 1, "msg" => "注册成功", "code" => 200);

        }
        json_return($returnArr);
    }

    /*
     * 重设密码
     */
    public function reset_by_code(){
        $getData = $_GET;
        $postData = $_POST;
        $user = new UserLogic();
        $options = array(
            "username" => $postData["mobile"],
            "password" => encrypt($postData["password"])
        );

        //校验验证码
        $checkResult=check_mobile_code($options['username'],$postData["code"]);
        if($checkResult['result']!=1){
            json_return($checkResult);
        }

        //校验输入
        $returnArr = array("result" => 0, "msg" => "账号不能为空", "code" => 402, "data" => null);
        if (empty($options["username"])) json_return($returnArr);
        $returnArr = array("result" => 0, "msg" => "密码不能为空", "code" => 402, "data" => null);
        if (empty($options["password"])) json_return($returnArr);

        //执行重置逻辑代码
        $info = $user->ResetCode($options);
            if ($info) {
                //判断用户是否修改成功
                if ($info == false) {
                    $returnArr = array("result" => 0, "msg" => "网络繁忙，修改失败", "code" => 402);
                } else {
                    M("ManageSmsLog")->where($options['username'])->setField('is_active',0);
                    $returnArr = array("result" => 1, "msg" => "修改成功，请重新登陆", "code" => 200);
                }
            } else {
                $returnArr = array("result" => 0, "msg" => "该账号未注册", "code" => 402);
            }
        json_return($returnArr);
    }

//    /*
//     * 重设密码 获取验证码
//     */
//    public function sendMessage() {
//        $getData = $_GET;
//        $postData = $_POST;
//        $options = array(
//            "mobile" => $postData["mobile"],
//        );
//
//        //判断手机号是否存在
//        $where=array("mobile = '" . $postData['mobile'] . "'");
//        $data=M("ManageUsers")->where($where)->count();
//        if(!$data){
//            $returnArr=array("result"=>0,"msg"=>"该账号不存在","code"=>402,"data"=>null);
//            json_return($returnArr);
//        }
//
//        //把之前这个号码的短信全部设置为不可用
//        M("ManageSmsLog")->where($where)->setField('is_active',0);
//        //验证今天发送的条数
//        $count = M("ManageSmsLog")->where("date_format(add_time, '%Y-%m-%d') = date_format(now(), '%Y-%m-%d')")->count();
//        if($count>=5)
//        {
//            $returnArr = array("result"=>0,"msg"=>"短信操作过于频繁，请明天再试","code"=>402,"data"=>null);
//            json_return($returnArr);
//        }
//        //设置验证码位数,发送短信
//        $code = get_mobile_code(4);
//        $msg = "【庖丁技术】您的验证码为 ".$code." 有效时间为五分钟";
//        $add_time = date("Y-m-d H:i:s");
//        //保存短信验证码发送前的短信日志记录，通过该日志判断用户的发送情况
//        $info = save_sms_log($options["mobile"], $code, $add_time);
//        if ($info["result"] == 1) {
//            //可能有短信服务器白名单，本地可能无法调试。
//
//            //日志记录后，发送短信，并返回结果
//            // $res=new \ChuanglanSmsApi();
//            //$res->sendSMS($options["mobile"], $msg);
//            $res=true;
//            if ($res == true) {
//                $returnArr = array("result" => 1, "msg" => "发送成功", "code" => 200);
//            } else {
//                $returnArr = array("result" => 0, "msg" => "发送失败，请重试", "code" => 402);
//            }
//        } elseif ($info["result"] == 2) {
//            $returnArr = array("result" => 0, "msg" => "发送失败，请重试", "code" => 402);
//        } elseif ($info["result"] == 3) {
//            $returnArr = array("result" => 0, "msg" => "操作过于频繁，请稍后再试", "code" => 402);
//        }
//        json_return($returnArr);
//    }

    /*
        * 用户绑定微信
        * */
    public function WeChatBind(){
        $manageUsers = M("ManageUsers");
        $manageUsersOauth = M("ManageUsersOauth");
        $config = M("Config");
        $options = array(
            'appid' => $config->where("name = 'appid'")->getField("value"), //微信开放平台appid
            'appsecret' => $config->where("name = 'appsecret'")->getField("value"), //微信开放平台appsecret
            'encodingaeskey' => "", //填写高级调用功能的密钥
        );
        $wechat = new Wechat($options);
        $res = $wechat->getOauthAccessToken();
        $info = $wechat->getOauthUserinfo($res["access_token"],$res["openid"]);
        $userId= $_SESSION["userArr"]["user_id"];
        $userData = array(
            'wechatmp_bind' => 1,
            'oauth' => "wechat_pc",
            'openid' => $info['openid']
        );
        $userOauthData = array(
            'user_id' => $userId,
            'oauth_openid' => $info['openid'],
            'oauth_name' =>  "wechat_pc ",
            'unionid' => $info['unionid'],
            'add_time' =>  date("Y-m-d H:i:s", time())
        );
        if($info['openid']) {
            $manageUsers->where("user_id= '$userId'")->save($userData);
            $user = $manageUsersOauth->where("user_id = '$userId' AND oauth_name = 'wechat_pc' AND oauth_openid = '{$info['openid']}'")->find();
            if($user) {
                $info = $manageUsersOauth->where("user_id= '$userId' AND oauth_name = 'wechat_pc' AND oauth_openid = '{$info['openid']}'")->save($userOauthData);
            } else {
                $info =  $manageUsersOauth->add($userOauthData);
            }
            if($info) {
                $returnArr = array("result" => 1, "msg" => "绑定成功！", "code" => 200);
            } else {
                $returnArr = array("result" => 0, "msg" => "绑定失败，请重新绑定！", "code" => 402);
            }
        }else {
            $returnArr = array("result" => 0, "msg" => "绑定失败，请重新绑定！", "code" => 402);
        }

        json_return($returnArr);
    }

    /*
       * 用户解除绑定微信
       * */
    public function WeChatUnBind(){
        $manageUsers = M("ManageUsers");
        $manageUsersOauth = M("ManageUsersOauth");
        $userId= $_SESSION["userArr"]["user_id"];
        $openid =  $manageUsers->where("user_id= '$userId'")->getField("openid");
        $userData = array(
            'wechatmp_bind' => 0,
            'oauth' => "",
            'openid' => ''
        );
        $manageUsers->where("user_id= '$userId'")->save($userData);
        $yesOrNo = $manageUsersOauth->where("user_id = '$userId' AND oauth_name = 'wechat_pc' AND oauth_openid = '$openid'")->delete();
        if($yesOrNo) {
            $returnArr = array("result" => 1, "msg" => "解除微信绑定成功！", "code" => 200);
        } else {
            $returnArr = array("result" => 0, "msg" => "解除绑定失败，请重新解除！", "code" => 402);
        }
        json_return($returnArr);
    }
    /*
     * 绑定手机
     */
    public function binding(){
       
        $getData = $_GET;
        $postData = $_POST;
        //调用用户类
        $user = new UserLogic();
        $options = array (
            "mobile" => $postData["bindMob"],
//            "paswd" => encrypt($postData["paswd"]),
            "code" => $postData["bindMobCode"],
            "user_id"=>$postData['userId']
        );
        

        //验证五分钟内验证码有效
        $date=M("ManageSmsLog")->where("add_time between date_add(now(), interval - 5 minute) and now() AND is_active=1")->count();
        if(!$date){
            $returnArr=array("result"=>0,"msg"=>"验证码已过期，请重新发送","code"=>402,"data"=>null);
            json_return($returnArr);
        }

        //校验验证码的正误
        $count = M("ManageSmsLog")->where(array("code = '" . $postData['bindMobCode'] . "'","is_active=1"))->count();
        if(!$count){
            $returnArr = array("result" => 0, "msg" => "验证码不正确,请重新输入", "code" => 200, "data" => null);
            json_return($returnArr);
        }

        //验证表单不能为空
        $returnArr = array("result" => 0, "msg" => "手机号不能为空", "code" => 402, "data" => null);
        if (empty($options["mobile"])) json_return($returnArr);
        $returnArr = array("result" => 0, "msg" => "验证码不能为空", "code" => 402, "data" => null);
        if (empty($options["code"])) json_return($returnArr);

        //将用户手机进行绑定
        $data = array(
            "user_id"=>$options["user_id"],
            "mobile" => $options["mobile"]  //手机号码
        );
        //用户信息绑定
        $info = $user->binbang($data);
        //判断用户是否绑定成功
        if ($info === false) {
            $returnArr = array("result" => 0, "msg" => "绑定失败", "code" => 402);
        } else {
            M("ManageSmsLog")->where($options['mobile'])->setField('is_active',0);
            $returnArr = array("result" => 1, "msg" => "绑定成功", "code" => 200);
        }
        json_return($returnArr);
    }

    /*
     * （庖丁手机端）绑定手机
     */
    public function bundling(){
      
        $getData = $_GET;
        $postData = $_POST;
        //调用用户类
        $user = new UserLogic();
        $options = array (
            "mobile" => $postData["mobile"],
            "code" => $postData["code"],
            "user_id"=>$postData['userId'],
            "paswd" => encrypt($postData["paswd"]),
        );
        
        //验证五分钟内验证码有效
        $date=M("ManageSmsLog")->where("add_time between date_add(now(), interval - 5 minute) and now() AND is_active=1")->count();
        if(!$date){
            $returnArr=array("result"=>0,"msg"=>"验证码已过期，请重新发送","code"=>402,"data"=>null);
            json_return($returnArr);
        }

        //校验验证码的正误
        $count = M("ManageSmsLog")->where(array("code = '" . $postData['code'] . "'","is_active=1"))->count();
        if(!$count){
            $returnArr = array("result" => 0, "msg" => "验证码不正确,请重新输入", "code" => 200, "data" => null);
            json_return($returnArr);
        }
        //验证表单不能为空
        $returnArr = array("result" => 0, "msg" => "手机号不能为空", "code" => 402, "data" => null);
        if (empty($options["mobile"])) json_return($returnArr);
        $returnArr = array("result" => 0, "msg" => "验证码不能为空", "code" => 402, "data" => null);
        if (empty($options["code"])) json_return($returnArr);

        //此手机号码曾经注册过没有
        $mobile = $options["mobile"];
        $userId =$options["user_id"];
        $phoneUser = M("ManageUsers")->where("mobile = '$mobile'")->getField("user_id");
        if($phoneUser) {
            $WeChatData = array(
                'oauth' => M("ManageUsers")->where("user_id = '$userId'")->getField("oauth"),
                'openid' =>M("ManageUsers")->where("user_id = '$userId'")->getField("openid"),
            );
            M("ManageUsers")->where("user_id = '$phoneUser'")->save($WeChatData);
            $useridToPhoneid['user_id'] = $phoneUser;
            $info = M("ManageUsersOauth")
                ->where("user_id = '$userId'")
                ->save($useridToPhoneid);
            $this->logout();
        } else {
            //将用户手机进行绑定
            $data = array(
                "user_id"=>$options["user_id"],
                "user_name"=>$options["mobile"],
                "mobile" => $options["mobile"]  //手机号码
            );
            if($options["paswd"]){
                $data['password'] = $options["paswd"];
            }
            //用户信息绑定
            $info = $user->binbang($data);
        }
       
        //判断用户是否绑定成功
        if ($info === false) {
            $returnArr = array("result" => 0, "msg" => "绑定失败", "code" => 402);
        } else {
            M("ManageSmsLog")->where($options['mobile'])->setField('is_active',0);
            $returnArr = array("result" => 1, "msg" => "绑定成功", "code" => 200);
        }
        json_return($returnArr);
    }

    /*
     * 用户认证(庖丁)
     */
    public function user_authen(){

        $action = $_GET['action'];
        $id = $_GET['id'] ? $_GET['id'] : $_POST['id'];
        $DAO = M('ManageUserAuthen');

        switch($action){
            case 'detail':
                $where['user_id'] = $id;
                $field = 'user_id,type,company_name,tech_field,desc,has_patent,company_pic,tech_file,patent_file,status';
                $info = $DAO->where($where)->field($field)->find();
//                $info['area'] = $info['province'] . '-' . $info['city'];
                if(empty($info['company_name'])) {
                    $info['company_name'] = M("ManageUsers")->where($where)->getField("company");
                }
                if ($info) {
                    $returnArr = array("result" => 1, "msg" => "请求成功", "code" => 200, "data" => $info);
                } else {
                    $returnArr = array("result" => 0, "msg" => "请求错误，获取数据出错", "code" => 402, "data" => null);
                }
                break;
            case 'edit':
                $where['user_id'] = $_SESSION["userArr"]["user_id"];
                $data = I('post.');
                $ifHaveUser = $DAO->where($where)->getField("user_id");
                if($ifHaveUser) {
                    $flag = $DAO->where($where)->save($data);

                } else {
                    $data['user_id'] = $_SESSION["userArr"]["user_id"];
                    $data['status'] = '1';
                    $data['add_time'] = date("Y-m-d H:i:s", time());
                    $flag = $DAO->where($where)->add($data);
                }
                M('manage_users')->where($where)->save($data);
                if ($flag === false) {
                    $returnArr = array("result" => 0, "msg" => "请求错误，获取数据出错", "code" => 402, "data" => null);
                } else {
                    $this->logRecord(6, "审核【".$data["company_code"]."】重新认证!", 6, -2, $id);
                    $admin_mobile=M('manage_users')->where('user_id=2')->field('mobile')->find();
                    $content = "【庖丁众包】才华与美貌并重的管理员，您好！有用户在线上提交了实名认证，请您尽快查看审核。您辛苦了！";
                    send_note($content,$admin_mobile['mobile']);
                    $returnArr = array("result" => 1, "msg" => "请求成功", "code" => 200, "data" => null);

                }
                break;
            case 'Upload_files':
                $userId = $_SESSION["userArr"]["user_id"];
                if($userId){
                    //获取文件
                    $headPic = $_POST['file'];
                    $type = $_POST['zip'];
                    $flag = 'base64,';
                    $index = strpos($headPic, $flag) + strlen($flag);
                    $base64Img = substr($headPic, $index);


                    //获取后缀名
                    $flag = 'text/';
                    $begin = strpos($headPic, $flag) + strlen($flag);
                    $flag = ';';
                    $end = strpos($headPic, $flag, $begin) - $begin;
                    $suffix = $type;

                    //保存文件到本地
                    $site = get_site_name();
                    $imgDiv = UPLOAD_PATH . $site. '/extend_file/' . date('Ymd', time()) . '/';
                    $imgName = time() . '.' . $suffix;

                    if(!is_dir($imgDiv)){
                        mkdir($imgDiv, 0777, true);
                    }
                    $imgPath = $imgDiv . $imgName;
                    file_put_contents($imgPath, base64_decode($base64Img));

                    //保存数据库
                    $data['tech_file'] = '/' . $imgPath;
                    $where['user_id'] = $userId;
                    $ifHaveUser = $DAO->where($where)->getField("user_id");
                    if($ifHaveUser) {
                        $flag = $DAO->where($where)->save($data);
                    } else {
                        $data['user_id'] = $id;
                        $data['add_time'] = date("Y-m-d H:i:s", time());
                        $flag = $DAO->where($where)->add($data);
                    }
                    if ($flag) {
                        $returnArr = array("result" => 1, "msg" => "请求成功", "code" => 200, "data" => $data);

                    } else {
                        $returnArr = array("result" => 0, "msg" => "请求错误，获取数据出错", "code" => 402, "data" => null);
                    }
                }else{
                    $returnArr = array("result" => 0, "msg" => "请求错误，没有登录", "code" => 666, "data" => null);
                }
                break;
            case 'patent_files':
                $userId = $_SESSION["userArr"]["user_id"];
                if($userId){
                    //获取文件
                    $headPic = $_POST['file'];
                    $type= $_POST['zip'];

                    $flag = 'base64,';
                    $index = strpos($headPic, $flag) + strlen($flag);
                    $base64Img = substr($headPic, $index);

                    //获取后缀名
                    $flag = 'text/';
                    $begin = strpos($headPic, $flag) + strlen($flag);
                    $flag = ';';
                    $end = strpos($headPic, $flag, $begin) - $begin;
                    $suffix = $type;


                    //保存文件到本地
                    $site = get_site_name();
                    $imgDiv = UPLOAD_PATH . $site. '/extend_file/' . date('Ymd', time()) . '/';
                    $imgName = time() . '.' . $suffix;

                    if(!is_dir($imgDiv)){
                        mkdir($imgDiv, 0777, true);
                    }
                    $imgPath = $imgDiv . $imgName;
                    file_put_contents($imgPath, base64_decode($base64Img));

                    //保存数据库
                    $data['patent_file'] = '/' . $imgPath;
                    $where['user_id'] = $userId;
                    $ifHaveUser = $DAO->where($where)->getField("user_id");
                    if($ifHaveUser) {
                        $flag = $DAO->where($where)->save($data);
                    } else {
                        $data['user_id'] = $id;
                        $data['add_time'] = date("Y-m-d H:i:s", time());
                        $flag = $DAO->where($where)->add($data);
                    }
                    if ($flag) {
                        $returnArr = array("result" => 1, "msg" => "请求成功", "code" => 200, "data" => $data);
                    } else {
                        $returnArr = array("result" => 0, "msg" => "请求错误，获取数据出错", "code" => 402, "data" => null);
                    }
                }else{
                    $returnArr = array("result" => 0, "msg" => "请求错误，没有登录", "code" => 666, "data" => null);
                }
                break;
            case 'update_head':
                $userId = $_SESSION["userArr"]["user_id"];
                if($userId){
                    //获取图片
                    $headPic = $_POST['head_pic'];

                    $flag = 'base64,';
                    $index = strpos($headPic, $flag) + strlen($flag);
                    $base64Img = substr($headPic, $index);

                    //获取后缀名
                    $flag = 'image/';
                    $begin = strpos($headPic, $flag) + strlen($flag);
                    $flag = ';';
                    $end = strpos($headPic, $flag, $begin) - $begin;
                    $suffix = substr($headPic, $begin, $end);

                    //保存图片到本地
                    $site = get_site_name();
                    $imgDiv = UPLOAD_PATH . $site. '/head_img/' . date('Ymd', time()) . '/';
                    $imgName = time() . '.' . $suffix;
                    if(!is_dir($imgDiv)){
                        mkdir($imgDiv, 0777, true);
                    }
                    $imgPath = $imgDiv . $imgName;
                    file_put_contents($imgPath, base64_decode($base64Img));

                    //保存数据库
                    $data = '/' . $imgPath;
//                    $where['user_id'] = $userId;
//                    $ifHaveUser = $DAO->where($where)->getField("user_id");
//                    if($ifHaveUser) {
//                        $flag = $DAO->where($where)->save($data);
//                    } else {
//                        $data['user_id'] = $id;
//                        $data['add_time'] = date("Y-m-d H:i:s", time());
//                        $flag = $DAO->where($where)->add($data);
//                    }

                    if ($data) {
                        $returnArr = array("result" => 1, "msg" => "请求成功", "code" => 200, "data" => $data);
                    } else {
                        $returnArr = array("result" => 0, "msg" => "请求错误，获取数据出错", "code" => 402, "data" => null);
                    }
                }else{
                    $returnArr = array("result" => 0, "msg" => "请求错误，没有登录", "code" => 666, "data" => null);
                }
                break;
            default:
                $returnArr = array("result" => 0, "msg" => "请求错误，参数设置错误", "code" => 401);
                break;
        }
        json_return($returnArr);
    }

    /*
     * 修改绑定
     */
    public function Modify(){
        $getData = $_GET;
        $postData = $_POST;
        //调用用户类
        $user = new UserLogic();
        $options = array (
            "mobile" => $postData["bindMob"],
            "oldMobile" =>  $postData["oldMobile"],
            "paswd" => encrypt($postData["paswd"]),
            "code" => $postData["bindMobCode"],
            "oldCode" => $postData["oldMobCode"],
            "user_id"=>$postData['userId']
        );
        //验证五分钟内验证码有效
        $date=M("ManageSmsLog")->where("add_time between date_add(now(), interval - 5 minute) and now() AND is_active=1")->count();
        if(!$date){
            $returnArr=array("result"=>0,"msg"=>"验证码已过期，请重新发送","code"=>402,"data"=>null);
            json_return($returnArr);
        }

        //校验验证码的正误
        if($postData['bindMobCode']){
            $count = M("ManageSmsLog")->where(array("code = '" . $postData['bindMobCode'] . "'","is_active=1"))->count();
        } else {
            $count = M("ManageSmsLog")->where(array("code = '" . $postData['oldMobCode'] . "'","is_active=1"))->count();
        }

        if(!$count){
            $returnArr = array("result" => 0, "msg" => "验证码不正确,请重新输入", "code" => 200, "data" => null);
            json_return($returnArr);
        }
        //旧手机号码不为空，获取旧手机号码的验证码
        if($options["oldMobile"]) {
            $returnArr = array("result" => 1, "msg" => "验证成功", "code" => 200);
        } else {
            $returnArr = array("result" => 0, "msg" => "手机号不能为空", "code" => 402, "data" => null);
            if (empty($options["mobile"])) json_return($returnArr);
            $returnArr = array("result" => 0, "msg" => "验证码不能为空", "code" => 402, "data" => null);
            if (empty($options["code"])) json_return($returnArr);

            //此手机号码曾经注册过没有
            $mobile = $options["mobile"];
            $userId =$options["user_id"];
            $phoneUser = M("ManageUsers")->where("mobile = '$mobile'")->getField("user_id");
            //手机号码已经存在，账户变为手机账户
            if($phoneUser) {
                $WeChatData = array(
                    'oauth' => M("ManageUsers")->where("user_id = '$userId'")->getField("oauth"),
                    'openid' =>M("ManageUsers")->where("user_id = '$userId'")->getField("openid"),
                );
                M("ManageUsers")->where("user_id = '$phoneUser'")->save($WeChatData);
                $useridToPhoneid['user_id'] = $phoneUser;
                $info = M("ManageUsersOauth")
                   ->where("user_id = '$userId'")
                   ->save($useridToPhoneid);
                $this->logout();
            } else {
                $data = array(
                    "user_id"=>$options["user_id"],
                    "mobile" => $options["mobile"],
                    //"user_name" => $options["mobile"]
                );
                if($postData["paswd"]){
                    $data['password'] = $options["paswd"];
                }
                //用户信息绑定
                $info = $user->Modify($data);
            }
            //将用户手机进行绑定

            //判断用户是否绑定成功
            if ($info == false) {
                $returnArr = array("result" => 0, "msg" => "绑定失败", "code" => 402);
            } else {
                M("ManageSmsLog")->where($options['mobile'])->setField('is_active',0);
                $returnArr = array("result" => 1, "msg" => "绑定成功", "code" => 200);
            }

        }
        //验证表单不能为空
        json_return($returnArr);
    }

    


    /*
     * 关于我们
     */
    public function about(){
        $action = $_GET['action'];
        $userId = $_SESSION["userArr"]["user_id"];
        if ($userId) {
            switch ($action) {
                case "info":
                    $data = M('Config')->field('name, value')->select();
                    $info = array();
                    foreach ($data as $item) {
                        $info[$item['name']] = $item['value'];
                    }
                    if ($info) {
                        $returnArr = array("result" => 1, "msg" => "请求成功", "code" => 200, "data" => $info);
                    } else {
                        $returnArr = array("result" => 0, "msg" => "请求错误，获取数据出错", "code" => 402);
                    }
                    break;
                default:
                    $returnArr = array("result" => 0, "msg" => "请求错误，参数设置错误", "code" => 401);
                    break;
            }
        } else {
            $returnArr = array("result" => 0, "msg" => "请求错误，请先登陆!", "code" => 403);
        }
        json_return($returnArr);
    }

    /*
     * 获取验证码
     */
    public function getVerifyCode(){
        $getData = $_GET;
        $postData = $_POST;
        $options = array(
            "username" => $postData["username"],
        );
        $user = new UserLogic();
        //传入参数
        $user->__invoke($options);
        //验证表单不能为空
        $returnArr = array("result" => 0, "msg" => "账号不能为空", "code" => 402, "data" => null);
        if (empty($options["username"])) json_return($returnArr);
        //判断账号是否存在
        $info = $user->isRegister();
        if (!$info) {
            //设置验证码位数
            $code = get_mobile_code(6);
            $add_time = time();
            $session_id = session_id();
            //保存短信验证码发送前的短信日志记录，通过该日志判断用户的发送情况
            $info = save_sms_log($options["username"], $code, $add_time, $session_id);
            if ($info["result"] == 1) {
                //日志记录后，发送短信，并返回结果
                $res = sms_send($options["username"], $code);
                if ($res == true) {
                    $returnArr = array("result" => 1, "msg" => "发送成功", "code" => 200);
                } else {
                    $returnArr = array("result" => 0, "msg" => "发送失败，请重试", "code" => 402);
                }
            } elseif ($info["result"] == 2) {
                $returnArr = array("result" => 0, "msg" => "发送失败，请重试", "code" => 402);
            } elseif ($info["result"] == 3) {
                $returnArr = array("result" => 0, "msg" => "操作过于频繁，请稍后再试", "code" => 402);
            }
        } else {
            $returnArr = array("result" => 0, "msg" => "该账号已注册", "code" => 402);
        }
        json_return($returnArr);
    }

    /*
     * 用户个人信息
     */
    public function user_info(){

        $action = $_GET['action'];
        $id = $_GET['id'] ? $_GET['id'] : $_POST['id'];
        $DAO = M('ManageUsers');

        switch($action){
            case 'detail':
                $where['user_id'] = $_SESSION["userArr"]["user_id"];
                $field = 'A.user_id,A.mobile,A.nickname,A.user_name,A.password,A.head_pic,A.email,A.sex,A.birthday,A.province,A.company,A.city,A.job,B.idcard,B.status';
                $info = $DAO->table('5u_manage_users A')->join('LEFT JOIN 5u_manage_user_authen B ON A.user_id=B.user_id')->where('A.user_id='.$_SESSION["userArr"]["user_id"])->find();
                $info['area'] = $info['province'] . '-' . $info['city'];
                //密码置为1 代表有密码
                if($info['password']) {
                    $info['password'] = 1;
                } else {
                    $info['password'] = 0;
                }
                if ($info) {
                    $returnArr = array("result" => 1, "msg" => "请求成功", "code" => 200, "data" => $info);
                } else {
                    $returnArr = array("result" => 0, "msg" => "请求错误，获取数据出错", "code" => 402, "data" => null);
                }
                break;
            case "title":
                $Config=M("Config")->select();
                foreach ($Config as $key => $value) {
                    $vo[$value['name']] = $value['value'];
                }
                $this->vo = $vo;
               if($vo){
                   $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $vo);
               }else {
                   $returnArr = array("result" => 0, "msg" => "获取失败", "code" => 402, "data" => null);
               }
                break;
            case 'edit':
                $data = $_POST;
                $where['user_id'] = $_SESSION["userArr"]["user_id"];
                $flag = $DAO->where($where)->save($data);

                if ($flag === false) {
                    $returnArr = array("result" => 0, "msg" => "请求错误，获取数据出错", "code" => 402, "data" => null);
                } else {
                    $returnArr = array("result" => 1, "msg" => "请求成功", "code" => 200, "data" => null);

                }
                break;
            case 'update_pw':
                $oldPw = encrypt($_POST['old']);
                $newPw = $_POST['new'];
                $reNewPw = $_POST['re_new'];
                $userId = $_SESSION["userArr"]["user_id"];
                if(!$userId){
                    $returnArr = array("result" => 0, "msg" => "请求错误，没有登录", "code" => 666, "data" => null);
                }else{
                    $where['user_id'] = $userId;
                    $info = $DAO->where($where)->find();

                    if($oldPw != $info['password']){
                        $returnArr = array("result" => 0, "msg" => "旧密码错误，请检查", "code" => 402, "data" => null);
                    }else{
                        if($newPw != $reNewPw){
                            $returnArr = array("result" => 0, "msg" => "两次密码不一致，请检查", "code" => 402, "data" => null);
                        }else{
                            $newPw = encrypt($newPw);
                            $flag = $DAO->where($where)->setField('password', $newPw);
                            if ($flag === false) {
                                $returnArr = array("result" => 0, "msg" => "修改密码出错", "code" => 402, "data" => null);
                            } else {
                                $returnArr = array("result" => 1, "msg" => "修改密码成功", "code" => 200, "data" => null);

                            }
                        }
                    }
                }
                break;
            case 'update_head':
                $userId = $_SESSION["userArr"]["user_id"];
                if($userId){
                    //获取图片
                    $headPic = $_POST['head_pic'];

                    $flag = 'base64,';
                    $index = strpos($headPic, $flag) + strlen($flag);
                    $base64Img = substr($headPic, $index);

                    //获取后缀名
                    $flag = 'image/';
                    $begin = strpos($headPic, $flag) + strlen($flag);
                    $flag = ';';
                    $end = strpos($headPic, $flag, $begin) - $begin;
                    $suffix = substr($headPic, $begin, $end);

                    //保存图片到本地
                    $site = get_site_name();
                    $imgDiv = UPLOAD_PATH . $site. '/head_img/' . date('Ymd', time()) . '/';
                    $imgName = time() . '.' . $suffix;
                    if(!is_dir($imgDiv)){
                        mkdir($imgDiv, 0777, true);
                    }
                    $imgPath = $imgDiv . $imgName;
                    file_put_contents($imgPath, base64_decode($base64Img));

                    //保存数据库
                    $data['head_pic'] = '/' . $imgPath;
                    $where['user_id'] = $userId;
                    $flag = $DAO->where($where)->save($data);

                    if ($flag === false) {
                        $returnArr = array("result" => 0, "msg" => "请求错误，获取数据出错", "code" => 402, "data" => null);
                    } else {
                        $returnArr = array("result" => 1, "msg" => "请求成功", "code" => 200, "data" => null);
                    }
                }else{
                    $returnArr = array("result" => 0, "msg" => "请求错误，没有登录", "code" => 666, "data" => null);
                }
                break;
            default:
                $returnArr = array("result" => 0, "msg" => "请求错误，参数设置错误", "code" => 401);
                break;
        }
        json_return($returnArr);
    }

    /*
     * 获取统计数据,1，全部男，2，全部女，3，会员，4，男会员，5，女会员，all，全部
     */
    public function getCount(){
        $getData = $_GET;
        $user = new UserLogic();

        $options = array(
            "count" => $getData["count"],
        );
        //传入参数
        $user->__invoke($options);
        //获取会员数
        $info = $user->getUserNum();
        if ($info) {
            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
        } else {
            $returnArr = array("result" => 0, "msg" => "获取成功，但未获取到数据", "code" => 402, "data" => $info);
        }
    }
    //我的关注
    public function myFollow() {
        $userId = $_SESSION["userArr"]["user_id"];
        if ($userId) {
           $company = M("ManageUsersRelation")
               ->field("to_user_id")
               ->where("from_user_id = '$userId' AND rel_type = 2")
               ->select();
           $info = $this->getFollowCompany($company);
            if ($info) {
                $returnArr = array("result" => 1, "msg" => "请求成功", "code" => 200, "data" => $info);
            } else {
                $returnArr = array("result" => 0, "msg" => "请求错误，获取数据出错", "code" => 402);
            }
        }else {
            $returnArr = array("result" => 0, "msg" => "请求错误，请先登陆!", "code" => 403);
        }
        json_return($returnArr);
    }

    //我的关注
    public function myLike() {
        $parameterGet = I('get.');
        $channelModel = M("SystemChannel")->where("call_index = '".$parameterGet["channel"]."'")->find();
        $userId=$_SESSION["userArr"]["user_id"];

        $where['channel_id'] = $channelModel["id"];
        $where["zan_user_id"] = $userId;

        if ($userId) {
            $companyIds = M("CommonLike")->field("data_id")->where($where)->select();
            $info = $this->getLikeCompany($companyIds);
            if ($info) {
                $returnArr = array("result" => 1, "msg" => "请求成功", "code" => 200, "data" => $info);
            } else {
                $returnArr = array("result" => 0, "msg" => "请求错误，获取数据出错", "code" => 402);
            }
        }else {
            $returnArr = array("result" => 0, "msg" => "请求错误，请先登陆!", "code" => 403);
        }
        json_return($returnArr);
    }

    public function  getLikeCompany($companyIds) {
        $channel =$_GET['channel'];
        $companyTable = getTable($channel,1);
        $recruitTable = getTable($channel,6);
        $activityTable = getTable('jhjj',1);

        $i = 0;
        foreach ($companyIds as $item) {

            $activityCount = M($activityTable['table_format'])
                ->where("create_user_id=" . $item['data_id'])
                ->count();
            $recruitCount = M($recruitTable['table_format'])
                ->where("data_id=" . $item['data_id'] . " AND is_deleted=0")
                ->count();
            $companyInfo = M($companyTable['table_format'])
                ->field("id,title,logo_img")
                ->where("is_deleted=0 AND id=".$item['data_id']." AND is_active =1"  )
                ->find();
            if($companyInfo){
                $info[$i]['activityCount'] = $activityCount;
                $info[$i]['recruitCount'] = $recruitCount;
                $info[$i]['companyInfo'] = $companyInfo;
                $i ++;
            }
        }
        $data[0] = $i; //该用户关注的公司量
        $data[1] = $info; 
       return $data;
    }

    public function user_news()
    {
        $parameterGet = I('get.');
        $parameterPost = I('post.');
        $param = array_merge($parameterGet, $parameterPost);
        if($param['action']){
            switch($param['action']){
                //未读信息
                case "count":

                    $data=M('notice_relation_user')->where('user_id='.$_SESSION["userArr"]["user_id"].' and status=0')->count();

                    break;

                case "data_list":

                    if($param['page'] && $param['page_num']){
                        $page = $param['page'];
                        $page_num = $param['page_num'];
                    }
                    if($param['order_field']&&$param['order_by']){
                        $orderBy = $param['order_field']. " ". $param['order_by'];
                    }
                    $info=M('notice_relation_user')
                        ->where('user_id='.$_SESSION["userArr"]["user_id"])
                        ->page($page, $page_num)
                        ->order($orderBy)
                        ->select();

                    if($param['get_page']){
                        $count = M('notice_relation_user')->where('user_id='.$_SESSION["userArr"]["user_id"])->count();
                        $pageTotal = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num);
                        $pageInfo['page'] = $page;
                        $pageInfo['page_total'] = $pageTotal;
                        $data['info'] = $info;
                        $data['page'] = $pageInfo;
                    }else{
                        $data = $info;
                    }

                    break;

                case "data_detail":
                    $status['status']='1';
                    $data=M('notice_relation_user')->where('id='.$param['data_id'])->find();
                    M('notice_relation_user')->where('id='.$param['data_id'])->save($status);
                    break;

                default:
                    $returnArr = array("result" => 0, "msg" => "参数有误", "code" => 400);


            }
            if ($data) {
                $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $data);
            } else {
                $returnArr = array("result" => 0, "msg" => "没有数据或该用户不存在，否则为栏目不存在", "code" => 400);
            }
        }else{
            $returnArr = array("result" => 0, "msg" => "参数有误", "code" => 400);
        }

        json_return($returnArr);
    }

    private function clean_session(){
        session_unset();   //删除session变量
        session_destroy();   //销毁session
    }
}
