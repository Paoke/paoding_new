<?php

namespace Wechat\Controller;

use Com\Wechat;
use Think\Controller;
use Think\Log;
class WechatController
{
    public function index($action = 0)
    {
        //这里有问题啊，这里应该要根据传过来的id来获取数据
        $wechatList = M("WxUser")->select();
        $wechatConf = $wechatList[0];
        $options = array(
            'token' => $wechatConf["token"], //填写你设定的key
            'appid' => $wechatConf["appid"], //填写高级调用功能的app id, 请在微信开发模式后台查询
            'appsecret' => $wechatConf["appsecret"], //填写高级调用功能的密钥
            'encodingaeskey' => $wechatConf["encodingaeskey"], //填写高级调用功能的密钥
        );
        $wechat = new Wechat($options);
        switch ($action) {
            case "code":
                $url = "http://" . $_SERVER["HTTP_HOST"] . "/index.php/Wechat/Wechat/index/action/redirect";
                $url = $wechat->getOauthRedirect($url, time(), "snsapi_userinfo");
                redirect($url);
                break;
            case "redirect":
                $res = $wechat->getOauthAccessToken();
                $info = $wechat->getOauthUserinfo($res["access_token"],$res["openid"]);
                if ($info) {
                    // R("Api/Wechat/index", array("login", $info));
                    $this->process($info);
                } else {
                    return false;
                }
                break;
            default:
                $returnArr = array("result" => 0, "msg" => "请求失败，参数设置错误", "code" => 402);
                break;
        }
        json_return($returnArr);
    }

    public function get_openid($action = 0)
    {
        $wechatList = M("WxUser")->select();
        $wechatConf = $wechatList[0];
        $options = array(
            'token' => $wechatConf["token"], //填写你设定的key
            'appid' => $wechatConf["appid"], //填写高级调用功能的app id, 请在微信开发模式后台查询
            'appsecret' => $wechatConf["appsecret"], //填写高级调用功能的密钥
            'encodingaeskey' => $wechatConf["encodingaeskey"], //填写高级调用功能的密钥
        );
        $wechat = new Wechat($options);
        switch ($action) {
            case "code":
                $url = "http://" . $_SERVER["HTTP_HOST"] . "/index.php/Wechat/Wechat/get_openid/action/redirect";
                $res = $wechat->getOauthRedirect($url, time(), "snsapi_base");
                redirect($res);
                break;
            case "redirect":
                $res = $wechat->getOauthAccessToken();
                if ($res["openid"]) {
                    session('openid', $res["openid"]);
                }
                break;
            default:
                break;
        }
        $intoURL = $_SESSION['intoUrl'];
        $http = 'http';
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'){
            $http = 'https';
        }
        $domain = $http . '://' . I('server.HTTP_HOST');
        $url = $domain . $intoURL;
        exit(redirect($url));
    }

    /*
     * 用于处理成功获取用户信息后的操作
     */
    private function process($data = array()){
        $intoURL = $_SESSION['intoUrl'];

        if($_SESSION["userArr"]["user_id"]){
            $data['user_id'] = $_SESSION["userArr"]["user_id"] ;
            $data['user_ip'] = get_client_ip();
            $data['create_time'] = date("Y-m-d H:i:s",time());
            M("ManageUserRecord")->add($data);
        }
        /*
         * $wxAutoRegister微信自动注册，0为不自动，1为只自动注册一次，2为每次登陆都重新注册一次（获取最新的用户信息）
         */
        if ($data) {//微信自动登录
            if($data['sex'] == null) {
                $data['sex'] = 0 ;
            }
            $openid =  $data['openid'];
            $userId = M("ManageUsersOauth")->where("oauth_openid='$openid'")->getField("user_id");

           if(empty($userId)) {
                $unionidUserId = M("ManageUsersOauth")->where("unionid='{$data['unionid']}'")->getField("user_id");
                if($unionidUserId) {
                    $userId = $unionidUserId;
                }
            }


            $addInfo = array(
                'openid' => $data['openid'],
                'oauth' => 'wechat_mp',
                'desc' => '该用户未填写简介',
                'nickname' => trim($data['nickname']),
                'sex' => $data['sex'],
                'province' => $data['province'],
                'city' => $data['city'],
                'head_pic' => $data['headimgurl'],
            );
            $addOauthInfo = array(
                'user_name' => trim($data['nickname']),
                'oauth_name' => 'wechat_mp',
                'oauth_openid' => $data['openid'],
                'unionid' => $data['unionid'],
                'oauth_access_token' => ''
            );
            //用户注册信息添加

            if (!empty($userId)) {
                //账号已经存在，存储用户基本信息
                if($unionidUserId) {
                    $addOauthInfo['add_time'] = date("Y-m-d H:i:s", time());
                    $addOauthInfo['user_id'] = $userId;
                     M("ManageUsersOauth")->add($addOauthInfo);
                }
                $info = M("ManageUsers")->field("user_id,authentication,mobile,nickname,desc,head_pic,sex,province,city,district")->where("user_id=$userId")->find();
                session("userArr", $info);
                $url = "http://" . $_SERVER["HTTP_HOST"] . "$intoURL";
                exit(redirect($url));
            } else {
                $addInfo['reg_time'] = date("Y-m-d H:i:s", time());
                //最后登录时间（一小时内算一次登录）
                $addInfo['last_login'] = date("Y-m-d H:i:s", time());
                //登录次数
                $addInfo['log_number'] = 1;
                $userId = M("ManageUsers")->add($addInfo);
                $addOauthInfo['add_time'] = date("Y-m-d H:i:s", time());
                $addOauthInfo['user_id'] = $userId;
                $oauthInfo = M("ManageUsersOauth")->add($addOauthInfo);
                //5u_manage_user_record表记录每次登录时间和IP
                $recordData['create_time'] = date("Y-m-d H:i:s", time());
                $recordData['user_id'] = $userId;
                $recordData['user_ip'] = getIP();
                M("ManageUserRecord") -> add($recordData);
                if ($userId) {
                    $res = M("ManageUsers")->field("user_id,authentication,mobile,nickname,desc,head_pic,sex,province,city,district")->where("user_id=".$userId)->find();
                    if ($res) {
                        //存储用户基本信息
                        session("userArr", $res);
                    }
                    $url = "http://" . $_SERVER["HTTP_HOST"] . "$intoURL";
                    exit(redirect($url));
                } else {
                    $returnArr = array("result" => 0, "msg" => "自动登录失败，系统繁忙", "code" => 500);
                }
            }
        } else {
            $returnArr = array("result" => 0, "msg" => "自动登录失败，请重试", "code" => 402);
        }
    }
}