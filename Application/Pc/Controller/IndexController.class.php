<?php

namespace Pc\Controller;

header("Content-Type: text/html;charset=utf-8");

class IndexController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        parent::checkSite();


    }

    public function index()
    {
        $ad=M("Ad");
        $list=$ad->where("pid=1")->field("ad_code")->select();
        $code = $_GET['code'];
        $this->assign("code", $code);
        $ifWeChatLogin = $_GET['ifWeChatLogin'];
        $this->assign("ifWeChatLogin", $ifWeChatLogin);
        $this->assign("list",$list);
//        $isMp = $_SERVER['HTTP_USER_AGENT'];
//        if (strpos($isMp, 'MicroMessenger') !== false) {
//            //记录微信用户登录次数
//            $log_number = M("ManageUsers")->where("user_id = {$_SESSION["userArr"]["user_id"]}") ->getField("log_number");
//            $log_number++;
//            M("ManageUsers")->where("user_id = {$_SESSION["userArr"]["user_id"]}")->setField('log_number',$log_number);
//        }
        $this->display();
    }
    public function header()
    {

        $this->display();
    }
    /*
     * 自定义页面
     * **/
    public function page(){
//
//        $id = $_GET['id'];
//        if($id){
//
//            $page = M('MobileDefinePage')->where('id='.$id)->find();
//            $html = $page['call_index'];
//            $this->display($html);
//        }else{
//
//            $this->display('index');
//        }
    }

    /*
    * 404错误页面
    * **/
    public function error(){
        $this->display('error');
    }
}
