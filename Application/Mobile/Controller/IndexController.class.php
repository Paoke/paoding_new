<?php

namespace Mobile\Controller;

header("Content-Type: text/html;charset=utf-8");

class IndexController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        if(parent::checkSite()){
//            parent::checkUrl();
        }
    }
    public function index()
    {
//        $isMp = $_SERVER['HTTP_USER_AGENT'];
//        if (strpos($isMp, 'MicroMessenger') !== false) {
//            //记录微信用户登录次数
//            $log_number = M("ManageUsers")->where("user_id = {$_SESSION["userArr"]["user_id"]}") ->getField("log_number");
//            $log_number++;
//            M("ManageUsers")->where("user_id = {$_SESSION["userArr"]["user_id"]}")->setField('log_number',$log_number);
//        }
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
