<?php

namespace Api\Controller;

use Think\Controller;

class SettingController extends BaseRestController
{
    public $userId = 0;
    public $userArr = array();

    public function _initialize()
    {
        parent::_initialize();
        if (session("?userArr")) {
            $this->userArr = session("userArr");
        }
    }
    //个人中心--设置--常见问题
    public function problem() {
        $info = M("SystemProblem")
            ->field("id,problem,answer")
            ->select();
        if($info) {
            $returnArr = array("result" => 1, "msg" => "请求成功", "code" => 200 , "data" => $info);
        } else {
            $returnArr = array("result" => 0, "msg" => "请求失败", "code" => 402);
        }
        json_return($returnArr);
    }

    //个人中心--设置--功能介绍
    public function introduction() {
        $info = M("SystemIntroduction")
            ->field("id,title,content")
            ->select();
        if($info) {
            $returnArr = array("result" => 1, "msg" => "请求成功", "code" => 200 , "data" => $info);
        } else {
            $returnArr = array("result" => 0, "msg" => "请求失败", "code" => 402);
        }
        json_return($returnArr);
    }

    //个人中心--设置--g关于
    public function settingAbout() {
        $info['company_name'] = M("Config")->where("name = 'store_name'")->getField("value");
        $info['company_logo'] = M("Config")->where("name = 'site_left_logo'")->getField("value");
        $info['company_address'] = M("Config")->where("name = 'address'")->getField("value");
        $info['company_phone'] = M("Config")->where("name = 'phone'")->getField("value");
        $info['company_smtp_user'] = M("Config")->where("name = 'smtp_user'")->getField("value");
        $info['company_store_name'] = M("Config")->where("name = 'store_name'")->getField("value");
        $info['company_record_no'] = M("Config")->where("name = 'record_no'")->getField("value");
        if($info) {
            $returnArr = array("result" => 1, "msg" => "请求成功", "code" => 200 , "data" => $info);
        } else {
            $returnArr = array("result" => 0, "msg" => "请求失败", "code" => 402);
        }
        json_return($returnArr);
    }

    //意见反馈
    public function getAdvice() {
        $postData = I('post.');
        $postData['user_id'] =  $_SESSION["userArr"]["user_id"];
        $postData['user_name'] = M("ManageUsers")
            ->where("user_id= '{$postData['user_id']}'")
            ->getField("nickname");
        $postData['ip_address'] = get_client_ip();
        $postData['msg_time'] = date("Y-m-d H:i:s",time());
       
        $info = M("SystemFeedback")->add($postData);
        if($info) {
            $returnArr = array("result" => 1, "msg" => "反馈成功", "code" => 200 , "data" => null);
        } else {
            $returnArr = array("result" => 0, "msg" => "反馈失败", "code" => 402);
        }
        json_return($returnArr);
    }

    //获取服务协议/注册条款
    public function getServiceLaw() {
        $info['introduction_service_law'] = M("Config")
            ->where("name = 'introduction_service_law'")
            ->getField("value");
        $info['introduction_register_law'] = M("Config")
            ->where("name = 'introduction_register_law'")
            ->getField("value");
        if($info) {
            $returnArr = array("result" => 1, "msg" => "获取成功成功", "code" => 200 , "data" => $info);
        } else {
            $returnArr = array("result" => 0, "msg" => "获取失败", "code" => 402);
        }
        json_return($returnArr);
    }


}
