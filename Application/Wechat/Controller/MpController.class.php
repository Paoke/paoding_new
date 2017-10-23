<?php

namespace Wechat\Controller;

use Com\TPWechat;
use Com\WxpayAPI\Lib\WxPayApi;
use Common\Util\WxPayConfig;
use Com\WxpayAPI\Lib\WxPayOrderQuery;
use Com\WxpayAPI\Lib\PayNotifyCallBack;
use Think\Controller;
use Think\Log;
use Wechat\Logic\ChannelLogic;

/**
 * 微信交互控制器，中控服务器
 * 主要获取和反馈微信平台的数据，分析用户交互和系统消息分发。
 */
class MpController extends Controller
{

    private $options = array(
        'token' => APP_TOKEN, //填写你设定的key
        'encodingaeskey' => '', //填写加密用的EncodingAESKey
        'appid' => '', //填写高级调用功能的app id
        'appsecret' => '' //填写高级调用功能的密钥
    );

    private $member_public;   //公众号
    public $user = array();
    public $user_id = 0;
    public $session_id;
    public $wechatConfig;
    public $cateTrre = array();

    public function _initialize()
    {
        /* 读取数据库中的公众号信息初始化微信类 */
    }


    /**
     * 微信公众号验证入口
     * 微信公众平台后台填写的api地址则为该操作的访问地址
     *
     */
    public function valid()
    {
        //获取公众号
        //$site = $_GET["site"];
        $id = $_GET["id"];

        $this->member_public = M('WxUser')->where(array('id' => $id))->find();
        $this->options['appid'] = $this->member_public['appid'];    //初始化options信息
        $this->options['appsecret'] = $this->member_public['appsecret'];
        $this->options['token'] = $this->member_public['token'];
        $this->options['encodingaeskey'] = $this->member_public['encodingaeskey'];

        $weObj = new TPWechat($this->options);
        if ($weObj->valid()) {
            echo $_GET["echostr"];
            exit;
        } else {

        }
    }

    /**
     * 微信消息接口入口
     * 所有发送到微信的消息都会推送到该操作
     * 所以，微信公众平台后台填写的api地址则为该操作的访问地址
     * 在mp.weixin.qq.com 开发者中心配置的 URL(服务器地址)  http://域名/index.php/Wechat/Mp/index/site/站点名称/id/对应站点表的公众号id
     */
    public function index()
    {
        //设置当前上下文的公众号id
        $id = $_GET["id"];

        $this->member_public = M('WxUser')->where("id=".$id)->find();
        $this->options['appid'] = $this->member_public['appid'];    //初始化options信息
        $this->options['token'] = $this->member_public['token'];
        $this->options['appsecret'] = $this->member_public['appsecret'];
        $this->options['encodingaeskey'] = $this->member_public['encodingaeskey'];

        $weObj = new TPWechat($this->options);
        $weObj->valid();
        $weObj->getRev();
        $data = $weObj->getRevData();
        $type = $weObj->getRevType();
        $ToUserName = $weObj->getRevTo();
        $FromUserName = $weObj->getRevFrom();
        $params['weObj'] = &$weObj;
        $params['mp_id'] = $this->member_public['mp_id'];
        $params['weOptions'] = $this->options;

        //如果被动响应可获得用户信息就记录下
        if (!empty ($ToUserName)) {
            //get_token($ToUserName);
        }
        if (!empty ($FromUserName)) {
//            $oid = $this->getOpenid();
        }


        $map['mp_id'] = $params['mp_id'];
        $mpUser = D('ManageUsers');
        $user = $mpUser->where($map)->find();       //查询出公众号的粉丝
        $fsub = $user["subscribe"];               //记录首次关注状态

        //与微信交互的中控服务器逻辑可以自己定义，这里实现一个通用的
        switch ($type) {
            //事件
            case TPWechat::MSGTYPE_EVENT:         //先处理事件型消息
                $event = $weObj->getRevEvent();

                switch ($event['event']) {
                    //关注
                    case TPWechat::EVENT_SUBSCRIBE:
                        $model = M('wxUser');
                        $result = $model->where("id=". $id)->find();
                        if (isset($event['eventkey']) && isset($event['ticket'])) {//二维码关注
                            $weObj->text("谢谢您的关注(二维码扫描)!");
                            $weObj->reply();  //在addons中处理完业务逻辑，回复消息给用户
                        } else {//普通关注
                            //需要查询是哪种回复方式
                            $weObj->text('谢谢您的关注!');
                            $weObj->reply();  //在addons中处理完业务逻辑，回复消息给用户
                        }

                        break;
                    //扫描二维码
                    case TPWechat::EVENT_SCAN:

                        break;
                    //地理位置
                    case TPWechat::EVENT_LOCATION:

                        break;
                    //自定义菜单 - 点击菜单拉取消息时的事件推送
                    case TPWechat::EVENT_MENU_CLICK:
//                        $where['keywork'] = array('like', '%' . $data['Content'] . '%');
//                        $where['mtype'] = 3;
//                        $where['statu'] = 1;
//                        $where['mp_id'] = get_mpid();
//                        $model_re = M('replay_messages');
//                        $data_re = $model_re->where($where)->find();
//                        $params['type'] = $data_re['type'];
//                        $params['replay_msg'] = D('Mpbase/Autoreply')->get_type_data($data_re);
//                        D('Home/Wxmsg')->wxmsg($params);
//                        $weObj->reply();  //在addons中处理完业务逻辑，回复消息给用户
//                        break;

                        break;
                    //自定义菜单 - 点击菜单跳转链接时的事件推送
                    case TPWechat::EVENT_MENU_VIEW:
                        exit;
                        break;
                    //自定义菜单 - 扫码推事件的事件推送
                    case TPWechat::EVENT_MENU_SCAN_PUSH:

                        break;
                    //自定义菜单 - 扫码推事件且弹出“消息接收中”提示框的事件推送
                    case TPWechat::EVENT_MENU_SCAN_WAITMSG:

                        break;
                    //自定义菜单 - 弹出系统拍照发图的事件推送
                    case TPWechat::EVENT_MENU_PIC_SYS:

                        break;
                    //自定义菜单 - 弹出拍照或者相册发图的事件推送
                    case TPWechat::EVENT_MENU_PIC_PHOTO:

                        break;
                    //自定义菜单 - 弹出微信相册发图器的事件推送
                    case TPWechat::EVENT_MENU_PIC_WEIXIN:

                        break;
                    //自定义菜单 - 弹出地理位置选择器的事件推送
                    case TPWechat::EVENT_MENU_LOCATION:

                        break;
                    //取消关注
                    case TPWechat::EVENT_UNSUBSCRIBE:

                        break;
                    //群发接口完成后推送的结果
                    case TPWechat::EVENT_SEND_MASS:

                        break;
                    //模板消息完成后推送的结果
                    case TPWechat::EVENT_SEND_TEMPLATE:

                        break;
                    default:

                        break;
                }
                break;
            //文本
            case TPWechat::MSGTYPE_TEXT :
                $id = $_GET["id"];
                $where['keyword'] = array('like', '%' . $data['keyword'] . '%');
                //$where['type'] = "TEXT";
               //$where['text'] = $data['text'];
                $where['uid'] = $id;
                $model_re = M('wx_response');
                $data_re = $model_re->order('create_time desc')->where($where)->find();

                $model = M('wxResponse');
                $result = $model->where("uid=". $id. " AND keyword LIKE '%". $data['Content']. "%'")->order('create_time DESC')->limit(1)->find();


                 if($result){ //匹配成功
                    if($result['type']=="TEXT"){
                         $weObj->text($result['text'])->reply(); //在addons中处理完业务逻辑，回复消息给用户
                    }else if($result['type']=="IMG"){
                        //$weObj->text(json_encode($result))->reply();
                        $options = array(
                            'Title'=>'msg title',
                            'Description'=>'summary text',
                            'PicUrl'=>'http://www.domain.com/1.jpg',
                            'Url'=>'http://www.domain.com/1.html'
                        );
                        $weObj->news($options)->reply();
                    }
                 }else {//匹配失败，返回默认回复，若没有默认回复，不处理
                     $wxuser = M('wxUser');
                     $result = $wxuser->where("id=". $id)->find();
                     if($result['default_response']){
                         $weObj->text($result['default_response'])->reply();
                     }else{
                         $weObj->text("未找到关键字，请重试")->reply();
                     }
                 }
                break;
            //图像
            case TPWechat::MSGTYPE_IMAGE :
                $id = $_GET["id"];
                $where['keyword'] = array('like', '%' . $data['Content'] . '%');
                $where['type'] = "IMG";
                $where['title'] = $data['title'];
                $where['uid']=$id;
                $where['pic'] = $data['pic'];
                $where['desc']=$data['desc'];
                $model_re = M('wx_response');
                $data_re = $model_re->order('create_time desc')->where($where)->find();

                $model = M('wxResponse');
                $result = $model->where("uid=". $_GET["id"]. " AND keyword LIKE '%". $data['Content']. "%'")->order('create_time DESC')->limit(1)->find();

                if($result){ //匹配成功
                    if($result['type']=="IMG"){
                        $weObj->image($result['title'])->reply(); //在addons中处理完业务逻辑，回复消息给用户
                    }else if($result['type']=="TEXT"){
                        //$weObj->text(json_encode($result))->reply();
                        $data=array(
                        "options" => array(
                            'Title'=>'msg title',
                            'Description'=>'summary text',
                            'PicUrl'=>'http://www.domain.com/1.jpg',
                            'Url'=>'http://www.domain.com/1.html'
                        ));
                        $weObj->news($data)->reply();
                    }
                }else {//匹配失败，返回默认回复，若没有默认回复，不处理
                    $wxuser = M('wxUser');
                    $result = $wxuser->where("id=". $_GET["id"])->find();
                    if($result['default_response']){
                        $weObj->text($result['default_response'])->reply();
                    }else{
                        $weObj->text("未找到关键图文，请重试")->reply();
                    }
                }
                break;
            //语音
            case TPWechat::MSGTYPE_VOICE :

                break;
            //视频
            case TPWechat::MSGTYPE_VIDEO :

                break;
            //位置
            case TPWechat::MSGTYPE_LOCATION :

                break;
            //链接
            case TPWechat::MSGTYPE_LINK :

                break;
            default:

                break;
        }

        // 记录日志
        if (C('DEVELOP_MODE')) { // 是否开发者模式
            addWeixinLog($data, $GLOBALS ['HTTP_RAW_POST_DATA']);
        }
    }


    /**
     * 微信支付统一回调接口 后续逻辑可查看 PayNotifyCallBack 中 NotifyProcess() 说明
     */
    public function notify()
    {
        try{
            $rsv_data = $GLOBALS ['HTTP_RAW_POST_DATA'];
            $result = xml_to_array($rsv_data);
            //回复公众平台支付结果
            $notify = new PayNotifyCallBack();
            $cfg = $this->getWxConfig($result);
            WxPayConfig::setConfig($cfg);

            //变更订单状态
            $orderSn = $result['attach'];
            if($orderSn){
                $this->updateOrder($orderSn, $result);
            }else{
                Log::write("微信支付通知回调没有设置订单号!");
            }

            Log::write("订单状态通知处理完成!", "DEBUG");

            $notify->Handle(false);
        }catch(\Exception $e){
            Log::write("微信支付回调出错: ".$e->getMessage());
        }
    }

    private function getWxConfig($result){
        $map["appid"] = $result["appid"];
        $info = M('WxUser')->where($map)->find();
        //获取公众号信息，jsApiPay初始化参数
        $cfg = array(
            'APPID' => $info['appid'],
            'MCHID' => $info['mchid'],
            'KEY' => $info['paykey'],
            'APPSECRET' => $info['appsecret'],
            'NOTIFY_URL' => wechat_notify_url(),
        );

        return $cfg;
    }

    /*
     * 更新订单
     * @param orderSn 订单号
     * @param data 返回数据
     * **/
    private function updateOrder($orderSn, $data){
        //1.获取订单频道信息
        $unifyOrder = M('CommonUnifyOrder')->where("order_sn='".$orderSn."'")->find();
        //2.查询订单是否支付
        $logic = new ChannelLogic($unifyOrder['channel'], $unifyOrder['type']);
        $isPayed = $logic->isPayedOrder($unifyOrder['order_id']);
        if(!$isPayed){ //没有支付，才更新
            $flag = $logic->updateOrderStatus($unifyOrder['order_id'], 1, 1);
            if($flag === false){
                Log::write("订单[".$orderSn."]更新状态失败");
            }
        }

        //记录支付订单流水
        if(strtoupper($data['result_code']) == 'SUCCESS'){
            $flow = 3;//成功
            $remark = "微信支付成功,订单[".$orderSn."]";
        }else{
            $flow = 2;//失败
            $remark = "微信支付失败,订单[".$orderSn."]";
        }
        $order = $logic->getOrder($unifyOrder['order_id']);
        $user = M('ManageUsers')->where("user_id=".$order['user_id'])->find();

        $this->recordPaymentLog($user, $order, 1, 1, $flow, $remark);

    }

    /*
     * 记录支付订单流水
     * @param user 用户信息
     * @param order 订单信息
     * @param payType 支付类型 1：微信支付
     * @param payStatus 支付状态 0:未支付，1：已支付
     * @param flow 订单流程 1：生成订单，2：订单支付失败，3：订单完成
     * @param remark 备注
     * **/
    private function recordPaymentLog($user, $order, $payType, $payStatus, $flow, $remark){
        $log['user_id'] = $user['user_id'];
        $log['user_name'] = $user['nickname'];
        $log['order_sn'] = $order['order_sn'];
        $log['order_amount'] = $order['total_amount'];
        $log['pay_type'] = $payType;
        $log['pay_status'] = $payStatus;
        $log['flow'] = $flow;
        $log['remark'] = $remark;
        $log['create_time'] = date("Y-m-d H:i:s", time());
        M('ManageUserPaymentLog')->add($log);
    }

    /**
     * 查询微信支付的订单
     * 注意 这里未做权限判断
     */
    public function orderquery()
    {
        $id = I('id', '', 'intval');
        $order = M("Order");
        if (empty($id)
            || !($odata = $order->where('id = ' . $id)->find())
        ) {
            $this->error('该支付记录不存在');
        }
        $map["mp_id"] = $odata["mp_id"];
        $info = M('member_public')->where($map)->find();
        //获取公众号信息，jsApiPay初始化参数
        $cfg = array(
            'APPID' => $info['appid'],
            'MCHID' => $info['mchid'],
            'KEY' => $info['mchkey'],
            'APPSECRET' => $info['secret'],
            'NOTIFY_URL' => $info['notify_url'],
        );
        WxPayConfig::setConfig($cfg);
        $input = new WxPayOrderQuery();
        $input->SetOut_trade_no($odata['order_id']);
        $result = WxPayApi::orderQuery($input);
        if (array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && array_key_exists("trade_state", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS"
            && $result["trade_state"] == "SUCCESS"
        ) {
            // $odata['module'] = Shop 则在D('ShopOrder','Logic')->AfterPayOrder() 内处理后续逻辑
            $class = parse_res_name($odata['module'] . '/' . $odata['module'] . 'Order', 'Logic');
            if (class_exists($class) &&
                method_exists($class, 'AfterPayOrder')
            ) {
                $m = new $class();
                $m->AfterPayOrder($result, $odata);
            }
            $this->success('已支付');
        }
        $this->error((empty($result['trade_state_desc']) ? '未支付' : $result['trade_state_desc']));
    }

    //自动登录
    public function autoLogin()
    {
        $this->session_id = session_id(); // 当前的 session_id
        define('SESSION_ID', session_id()); //将当前的session_id保存为常量，供其它方法调用
        //微信浏览器
        if (strstr($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')) {
            //获取微信配置
            $wechatList = M('WxUser')->select();
            $wechatInfo = $wechatList[0];
            $this->wechatConfig = $wechatInfo;
            define('MP_CONFIG', $wechatInfo);
            if ($wechatInfo && !$_SESSION['openid']) {
                //去授权获取openid
//                $wxuser = $this->getOpenid();
                //获取用户昵称
                session('subscribe', $wxuser['subscribe']);// 当前这个用户是否关注了微信公众号
                //微信自动登录
                $data = array(
                    'openid' => $wxuser['openid'],
                    'oauth' => 'weixin',
                    'nickname' => trim($wxuser['nickname']) ? trim($wxuser['nickname']) : '微信用户',
                    'sex' => $wxuser['sex'] == 1 ? 2 : 1,
                    'city' => $wxuser['city'],
                    'province' => $wxuser['province'],
                    'head_pic' => $wxuser['headimgurl'],
                );
            }
        }
    }

}