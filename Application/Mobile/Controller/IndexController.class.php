<?php

namespace Mobile\Controller;

header("Content-Type: text/html;charset=utf-8");

class IndexController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        parent::checkUrl();
    }
    public function index()
    {
        $isMp = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($isMp, 'MicroMessenger') !== false) {
//            //记录微信用户登录次数
//            $log_number = M("ManageUsers")->where("user_id = {$_SESSION["userArr"]["user_id"]}") ->getField("log_number");
//            $log_number++;
//            M("ManageUsers")->where("user_id = {$_SESSION["userArr"]["user_id"]}")->setField('log_number',$log_number);
            if($_SESSION["userArr"]['user_id']){
                if(!$_SESSION['userArr']['mobile']){
                    $this->assign('nickname',$_SESSION["userArr"]['nickname']);
                    $this->assign('head_pic',$_SESSION["userArr"]['head_pic']);
                    $this->display('/User/binding');
                    return false;
                }
            }
        }
       $this->display('/User/binding');
    }

    public function choose()
    {
        $this->checkReg();
        $this->display();
    }

    public function release()
    {
        $this->checkReg();
        $this->display();
    }

    public function theme_list()
    {
        $this->display();
    }

    public function theme_tec()
    {
        $this->display();
    }

    public function tec_list()
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
