<?php

namespace Mobile\Controller;

use Think\Controller;
use Think\Log;
use Think\Model;
use Com\Wechat;

class BaseController extends Controller
{
    public $user = array();
    public $user_id = 0;
    public $session_id;
    public $weixin_config;
    public $cateTrre = array();
   
    /**
     * 构造函数
     */
    function __construct()
    {
        parent::__construct();
        $this->public_assign();
    }

    /**
     * 检查是否登录的函数
     */
    public function checkReg()
    {

        if (empty($_SESSION["userArr"])) {
            $this->display("Login/login");
            exit;
        }
    }

    /**
     * 检查站点是否正确的函数
     */
    public function checkSite()
    {
        $site_name = session('site_name');

        if (!empty($site_name)) {
            return site_template_config($site_name, 1);
        }
        return false;
    }

    /**
     * 进来页面的时候，在子类调用
     * 判断是否注册。注册后根据传递的url前往不同的url
     */
    public function checkUrl()
    {
        //获取url
        $url =  $_SERVER['PHP_SELF'];
        $_SESSION['intoUrl'] = $url;

        //获取站点名
        $site_name = session('site_name');
        if (!empty($site_name)) {
            site_template_config($site_name, 1);
        }
        $isMp = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($isMp, 'MicroMessenger') === false) {// 非微信浏览器操作
            if( $_SESSION["userArr"]["user_id"] ) {//如果有缓存数据
                    $userIP = get_client_ip();
                    $data['user_id'] = $_SESSION["userArr"]["user_id"] ;
                    $data['user_ip'] = $userIP;
                    $data['create_time'] = date("Y-m-d H:i:s",time());
                    M("ManageUserRecord")->add($data);
            }else{//没有账号，所以强制修改地址到达登录页面
//                $url="/index.php/Mobile/Login/login";

                //特殊代码，发布前要处理掉，这里是用作强制获取用户信息的
                $info = M()
                    ->table("{$_SESSION["site_name"]}_manage_users")
                    ->field("user_id,authentication,mobile,nickname,desc,head_pic,sex,province,city,district")
                    ->where("user_name='admin' AND password='bd5c17290f71fb95d1fa6ffcb1807ea5'")
                    ->find();
                session("userArr", $info);
//                setcookie('user_id', $info["user_id"], null, '/');
            }
            //跳去对应的界面
            //Header("HTTP/1.1 303 See Other");
           // Header("Location: $url");
            //exit;
        } else {// 微信浏览器操作
            //if ($_SESSION["userArr"]["user_id"] != $_COOKIE["user_id"] || !$_SESSION["userArr"]) {
            if (!session('userArr')) {
                R("Wechat/Wechat/index", array("code"));
            } else {
                $oauthFlag = M("ManageUsers")->where("user_id=".session('userArr')['user_id'])->count();
                if($oauthFlag != 0 ) {
                    $lastTime = M('ManageUsers')->where("user_id=".session('userArr')['user_id'])->getField("last_login");
                    $lastTime = strtotime($lastTime);
                    $timeNow = time();
                    $timediff = $timeNow-$lastTime; //两者时间戳差
                    $remain = $timediff%86400;
                    $remain = $remain%3600;
                    $mins = intval($remain/60); //计算分钟数
                    if($mins >60) {
                        $logNum = M('ManageUsers')->where("user_id=".session('userArr')['user_id'])->getField("log_number");
                        M('ManageUsers')->where("user_id=".session('userArr')['user_id'])->setField("log_number",$logNum+1);
                        $recordData['create_time'] = date("Y-m-d H:i:s", time());
                        $recordData['user_id'] = session('userArr')['user_id'];
                        $recordData['user_ip'] = getIP();
                        M("ManageUserRecord") -> add($recordData);
                    }

                } else if ($oauthFlag == 0) {//如果没有数据的话，就跳过去重新获取。有缓存的的话就不再记录log
                    R("Wechat/Wechat/index", array("code"));
                }

//                else {
//                    if( $_SESSION["userArr"]["user_id"] ) {
//                        $userIP = get_client_ip();
//                        $data['user_id'] = $_SESSION["userArr"]["user_id"] ;
//                        $data['user_ip'] = $userIP;
//                        $data['create_time'] = date("Y-m-d H:i:s",time());
//                        M("ManageUserRecord")->add($data);
//                    }
//                    //2为每次登陆都重新注册一次（获取最新的用户信息）(这段if函数暂未验证，需要微信登录才能验证)
//                    //记录用户登录时间
//                    $data['last_login'] = date("Y-m-d H:i:s", time());
//                    M("ManageUsers")->where("user_id={$_SESSION["userArr"]["user_id"]}")->save($data);
//
//                }
            }
        }
    }

    /**
     * 保存公告变量到 smarty中 比如 导航
     */
    public function public_assign()
    {
        $gemmap_config = array();
        $tp_config = M('config')->select();
        foreach ($tp_config as $k => $v) {
            $gemmap_config[$v['inc_type'] . '_' . $v['name']] = $v['value'];
        }
        $this->assign('gemmap_config', $gemmap_config);
    }

    /*
     * 获取表的名称
     * */
    public function getTableName($channel = "", $type = 0) {
        $tableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type=$type")->getField("table_format");
        if($tableName) {
            return $tableName;
        } else {
            return false;
        }
    }

    public function getViewRecordTable($channelIndex){
        $channel = M('SystemChannel')->where("call_index='".$channelIndex."'")->find();
        $table = ucfirst($channel['base_module']) . ucfirst($channelIndex) . 'ViewRecord';
        return $table;
    }

    /*
     * 获取微信分享的相关参数
     * */
    public function getWxParameter(){
        $wechatList = M("WxUser")->select();
        $wechatConf = $wechatList[0];
        $logo = M("Config")->where("name = 'site_left_logo'")->getField("value");
        $data = array(
            'logo'=>'http://www.hitgl.com'.$logo,//logo地址
            'title'=>'医信微平台',//标题
        );
        $weixindata = array();
        $weixindata['appId'] = $wechatConf['appid'];//appid
        $weixindata['nonceStr'] = $this->createNonceStr(); //随机字符串
        $weixindata['timestamp'] = time();
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $weixindata['logo'] = $data['logo'];
        $weixindata['link'] = $url;
      
        $weixindata['title'] = $data['title'];

     //   $weixindata['description'] = mb_substr($data['description'], 0, 30, 'UTF-8');
        $weixindata['signature'] = $this->signature($weixindata['nonceStr'],$weixindata['timestamp'],$url);
        if($weixindata['signature']) {
            return $weixindata;
        } else {
            return false;
        }
    }

    //获取access_token
    public function accessToken()
    {
        $wechatList = M("WxUser")->select();
        $wechatConf = $wechatList[0];
        $nowTime = time();
        $takenTime = $wechatConf["authorizer_expires"];
       

        if($nowTime-$takenTime>7190){
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$wechatConf['appid']."&secret=".$wechatConf['appsecret'];
            $access_token1 = json_decode($this->httpGet($url),true);
            $data['authorizer_access_token'] = $access_token1['access_token'];
            $data['authorizer_expires'] = time();
            $access_token = $access_token1['access_token'];
            $info = M("WxUser")->where("id=2")->save($data);
        } else{
            $access_token = $wechatConf["authorizer_access_token"];
        }
        return $access_token;
    }
    //用第一步拿到的access_token 采用http GET方式请求获得jsapi_ticket
    public function jsapiTicket()
    {
        $access_token = $this->accessToken();
        $wechatList = M("WxUser")->select();
        $wechatConf = $wechatList[0];
        $nowTime = time();
        $ticketTime = $wechatConf["web_expires"];
        if($nowTime-$ticketTime>7190){
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$access_token."&type=jsapi";
            $jsapiTicketAll = json_decode($this->httpGet($url),true);
            $jsapiTicket = $jsapiTicketAll['ticket'];
            $data['web_access_token'] = $jsapiTicket;
            $data['web_expires'] = time();
            $info = M("WxUser")->where("id=1")->save($data);
        } else{
            $jsapiTicket = $wechatConf["web_access_token"];
        }
        return $jsapiTicket;
    }


    //获取signature
    public function signature($nonceStr,$timestamp,$url)
    {
        $wechatList = M("WxUser")->select();
        $wechatConf = $wechatList[0];
        $nowTime = time();
        $ticketTime = $wechatConf["web_expires"];
        if($nowTime-$ticketTime>7190){
            $jsapi_ticket = $this->jsapiTicket();
        } else {
            $jsapi_ticket = $wechatConf['share_ticket'];
        }
        $signature = '';
        if($jsapi_ticket) {
            $string = "jsapi_ticket=$jsapi_ticket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
            $signature = sha1($string);//对string1进行sha1签名，得到signature
        }else{
            return false;
        }
        return $signature;
    }
    //获取16位随机字符
    public function createNonceStr() {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < 16; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    public function httpGet($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }
}
