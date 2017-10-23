<?php

namespace Api\Logic;


use Com\WxpayAPI\Lib\WxRedPackOrder;
use Com\WxpayAPI\Lib\WxPayApi;
use Com\WxpayAPI\Lib\WxPayUnifiedOrder;
use Com\WxpayAPI\Lib\JsApiPay;
use Common\Util\WxPayConfig;
use Think\Log;

class WechatLogic extends BaseRestLogic
{
    /*
     * 发送现金红包
     *
     * **/
    public function sendRedPack($order, $userId){
        try{
            // 1.获取user openid
            $userLogic = new UserLogic();
            $user = $userLogic->getUser($userId);
            $wx = M('WxUser')->find();

            $cfg = $this->getWxConfig();
            WxPayConfig::setConfig($cfg);

            $redPack = new WxRedPackOrder();
            $mchBillno = C('WECHAT_RED_PACK_ORDER_PREFIX').$order['order_sn'];
            $redPack->SetMch_billno($mchBillno);
            $redPack->SetSend_name($wx['wxname']);
            $redPack->SetOpenid($user['openid']);
            if($order['discount'] < 1){
                $order['discount'] = 1;//discount为元，微信红包单位为分
            }
            $redPack->SetTotal_amount($order['discount'] * 100);//付款金额，单位分
            $redPack->SetTotal_num("1");
            $redPack->SetWishing("签到返现");
            $redPack->SetClient_ip(get_server_ip());
            $redPack->SetAct_name($order['activity_name']);
            $redPack->SetRemark($order['activity_name'].'签到返现红包');
            //记录流水
            $this->recordPaymentLog($user, $mchBillno, $order['discount'], 2, 0, 1, "现金红包生成,商户订单号[".$mchBillno."]");

            $result = WxPayApi::redPackOrder($redPack);
            Log::write("发放现金红包返回【".json_encode($result)."】", "DEBUG");
            if(strtoupper($result['result_code']) == 'SUCCESS'){
                $this->recordPaymentLog($user, $mchBillno, $order['discount'], 2, 1, 3, "现金红包发送成功,商户订单号[".$mchBillno."]");
                return true;
            }else{
                $this->recordPaymentLog($user, $mchBillno, $order['discount'], 2, 0, 2,
                            "现金红包发送失败,商户订单号[".$mchBillno."]，err_code[".$result['err_code']."],err_msg[".$result['err_code_des']."]");
                return false;
            }
        }catch(\Exception $e){
            $this->recordPaymentLog($user, $mchBillno, $order['discount'], 2, 0, 2, "现金红包发送失败,商户订单号[".$mchBillno."],错误信息:".$e->getMessage());
            Log::write("发放现金红包异常: ".$e->getMessage());
            return false;
        }
    }

    /*
     * 生成微信支付订单
     * **/
    public function genWechatPayOrder($channel, $type=3, $orderId, $data=null){
        try{
            $table = getTableStr($channel, $type, 'table_format');
            $order = M($table)->where('order_id='.$orderId)->find();
            if(!$order){
                return false;
            }
            $user = M('ManageUsers')->where('user_id='.$order['user_id'])->find();
            //生成支付订单流水
            $this->recordPaymentLog($user, $order['order_sn'], $order['total_amount'], 1, 0, 1, "微信支付订单生成,订单号[".$order['order_sn']."]");
            //替换微信配置
            $cfg = $this->getWxConfig();
            WxPayConfig::setConfig($cfg);
            //Log::write(json_encode($cfg),">>>>>>>>>>>>>>");
            $wxUnifiedOrder = new WxPayUnifiedOrder();
            $wxUnifiedOrder->SetBody($order['activity_name']);
            $wxUnifiedOrder->SetAttach($order['order_sn']);
            $wxUnifiedOrder->SetOut_trade_no($order['order_sn']);
            $wxUnifiedOrder->SetTotal_fee($order['total_amount']*100);
            $wxUnifiedOrder->SetTime_start(date("YmdHis"));
            $wxUnifiedOrder->SetTime_expire(date("YmdHis", time() + 600));
            $wxUnifiedOrder->SetGoods_tag($order['coupon_price']);
            $notifyUrl = wechat_notify_url();
            $wxUnifiedOrder->SetNotify_url($notifyUrl);
            $wxUnifiedOrder->SetTrade_type("JSAPI");
            $wxUnifiedOrder->SetOpenid($user['openid']);
            $wxPayOrder = WxPayApi::unifiedOrder($wxUnifiedOrder);
            $jsApiPay = new JsApiPay();
            $jsApiParameters = $jsApiPay->GetJsApiParameters($wxPayOrder);
            return $jsApiParameters;
        }catch(\Exception $e){
            Log::write("生成微信支付参数失败: " . $e->getMessage());
            return false;
        }
    }


    /*
     * 生成微信打赏演讲人支付订单
     * */
    public function genWechatReward($dataId,$user_id){
        try{
          /*  $dataId = 1;
            $user_id=53;*/
            $speechInfo = M("ActivityYjglHygl")->where('id='.$dataId)->find();
            $user = M('ManageUsers')->where('user_id='.$user_id)->find();
            //$order_sn，订单编号，随机字符串
            $order_sn =  get_rand_str(9,1,1);
            $order_sn = $order_sn.'';
            //生成支付订单流水
            $this->speechWechatLog($user,$order_sn, 1, 1, 0, 1, "微信打赏 <<".$speechInfo['yjzt'].">> 的演讲人：".$speechInfo['title'],$speechInfo);
            //替换微信配置
            $cfg = $this->getWxConfig();
            WxPayConfig::setConfig($cfg);

            //Log::write(json_encode($cfg),">>>>>>>>>>>>>>");

            $wxUnifiedOrder = new WxPayUnifiedOrder();
            $wxUnifiedOrder->SetBody($speechInfo['yjzt']);
            $wxUnifiedOrder->SetAttach($order_sn);
            $wxUnifiedOrder->SetOut_trade_no($order_sn);
            $wxUnifiedOrder->SetTotal_fee(1);
            $wxUnifiedOrder->SetTime_start(date("YmdHis"));
            $wxUnifiedOrder->SetTime_expire(date("YmdHis", time() + 600));
            $wxUnifiedOrder->SetGoods_tag('0');
            $notifyUrl = wechat_notify_url();
            $wxUnifiedOrder->SetNotify_url($notifyUrl);
            $wxUnifiedOrder->SetTrade_type("JSAPI");
            $wxUnifiedOrder->SetOpenid($user['openid']);
            $wxPayOrder = WxPayApi::unifiedOrder($wxUnifiedOrder);
            $jsApiPay = new JsApiPay();
            $jsApiParameters = $jsApiPay->GetJsApiParameters($wxPayOrder);
            return $jsApiParameters;
        }catch(\Exception $e){
            Log::write("生成微信支付参数失败: " . $e->getMessage());
            return false;
        }
    }
    
    /*
     * 获取微信配置
     * **/
    public function getWxConfig(){

        $info = M('WxUser')->where('id=1')->find();
        //获取公众号信息，jsApiPay初始化参数
        $cfg = array(
            'APPID' => $info['appid'],
            'MCHID' => $info['mchid'], //商户号
            'KEY' => $info['paykey'],
            'APPSECRET' => $info['appsecret'],
            'NOTIFY_URL' => wechat_notify_url(),
            'SSLCERT_PATH' => $info['apiclient_cert'],
            'SSLKEY_PATH'  => $info['apiclient_key'],
            'ROOTCA_PATH'  => $info['rootca'],
        );
        return $cfg;
    }

    /*
     * 微信支付流水
     * @param user 用户信息
     * @param order 订单信息
     * @param payType 支付类型[1：微信支付, 2: 现金红包]
     * @param payStatus 支付状态[0:未支付, 1:已支付]
     * @param flow 支付流程[1:生成订单, 2:支付失败, 3:支付成功]
     * **/
    public function recordPaymentLog($user, $orderSn, $totalAmount, $payType, $payStatus=0, $flow=1, $remark=''){
        $log['user_id'] = $user['user_id'];
        $log['user_name'] = $user['nickname'];
        $log['order_sn'] = $orderSn;
        $log['order_amount'] = $totalAmount;
        $log['pay_type'] = $payType;
        $log['pay_status'] = $payStatus;
        $log['flow'] = $flow;
        $log['remark'] = $remark;
        $log['create_time'] = date("Y-m-d H:i:s", time());
        M('ManageUserPaymentLog')->add($log);
    }

    public function speechWechatLog($user,$order_sn, $totalAmount, $payType, $payStatus=0, $flow=1, $remark='',$speechInfo){
        $log['user_id'] = $user['user_id'];
        $log['user_name'] = $user['nickname'];
        $log['user_mobile'] = $user['mobile'];
        $log['order_amount'] = $totalAmount;
        $log['order_sn'] = $order_sn;
        $log['pay_type'] = $payType;
        $log['pay_status'] = $payStatus;
        $log['activity_name'] = $speechInfo['yjzt'];
        $log['activity_id'] = $speechInfo['data_id'];

        $log['speech_people_name'] = $speechInfo['title'];
        $log['flow'] = $flow;
        $log['remark'] = $remark;
        $log['create_time'] = date("Y-m-d H:i:s", time());
        M('SpeechWechatLog')->add($log);
    }
}