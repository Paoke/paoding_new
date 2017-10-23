<?php

namespace Api\Controller;

use Think\Controller;
use Think\Log;
use Common\common;




class SmsController extends BaseRestController
{
    /*
    * 发送短信
    */
    public function sendMessage() {
        $getData = $_GET;
        $postData = $_POST;
        $options = array(
            "mobile" => $postData["mobile"],
        );


        //把之前这个号码的短信全部设置为不可用
        $where=array("mobile = '" . $postData['mobile'] . "'");
        M("ManageSmsLog")->where($where)->setField('is_active',0);
        //验证今天发送的条数
        $count = M("ManageSmsLog")->where("date_format(add_time, '%Y-%m-%d') = date_format(now(), '%Y-%m-%d') AND mobile = '". $postData['mobile'] . "'")->count();

        if($count>=10)
        {
            $returnArr = array("result"=>0,"msg"=>"此手机号的短信操作过于频繁，请明天再试","code"=>402,"data"=>null);
            json_return($returnArr);
        }
        //设置验证码位数,发送短信
        $code = get_mobile_code(4);
        $msg = "【庖丁技术】您的验证码为 ".$code." 有效时间为五分钟";
        $add_time = date("Y-m-d H:i:s");
        //保存短信验证码发送前的短信日志记录，通过该日志判断用户的发送情况
        $info = save_sms_log($options["mobile"], $code, $add_time,"短信注册");

        if ($info["result"] == 1) {
            //可能有短信服务器白名单，本地可能无法调试。

            //日志记录后，发送短信，并返回结果
            $res=new \ChuanglanSmsApi();
            $result=$res->sendSMS($options["mobile"], $msg);
            $options=substr($result,-1);
            if ($options==0) {
                $returnArr = array("result" => 1, "msg" => "发送成功", "code" => 200);
            } else {
                $returnArr = array("result" => 0, "msg" => "发送失败，请重试", "code" => 402);
            }
        } elseif ($info["result"] == 2) {
            $returnArr = array("result" => 0, "msg" => "发送失败，请重试", "code" => 402);
        } elseif ($info["result"] == 3) {
            $returnArr = array("result" => 0, "msg" => "网络繁忙，请稍后再试", "code" => 402);
        }
        json_return($returnArr);
    }
}
