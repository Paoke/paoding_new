<?php

namespace Pc\Controller;

header("Content-type: text/html; charset=utf-8");

class UserController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        parent::checkUrl();
    }

    public function user_center()
    {

        $code = $_GET['code'];
        $this->assign("code", $code);
        $getSelfUserId = $_SESSION["userArr"]['mobile'];
        $this->assign("mobile", $getSelfUserId);
        $userId = $_SESSION["userArr"]['user_id'];
        $this->assign("user_id", $userId);
        $ifWeChatLogin = $_GET['ifWeChatLogin'];
        $this->assign("ifWeChatLogin", $ifWeChatLogin);
        $this->display();
    }

    /*
     * 个人中心
     */
    public function user()
    {
        $userId = $_SESSION["userArr"]["user_id"];
        $this->assign("user_id",$userId);
        $this->display();
    }

    /*
     * 企业用户个人中心
     */
    public function company_user()
    {
        //$this->assign("user_id",$userId);
        $this->display();
    }

    /*
    * 用户评价
    * */
    public function comment()
    {
        $channel_id = $_GET["channel_id"];
        $order_id = $_GET["order_id"];
        $if_see = $_GET["if_see"];
        $id = $_GET["id"];
        $this->assign("id", $id);
        $this->assign("channel_id", $channel_id);
        $this->assign("order_id", $order_id);
        $this->assign("if_see", $if_see);
        $this->display();
    }
    /*
      * 我的订单（待付款，待参与，待评价）
      *
      * 订单状态，0为待付款（生成订单），1为待参与，2为待评价（已确认订单），3为已评价（完成订单），4取消订单，5为作废订单，6为退款中，7为已退款
      * */
    public function my_order()
    {
        $order_sta= $_GET["order_sta"];
        $getSelfUserId = $_SESSION["userArr"]["user_id"];
        $this->assign("userId", $getSelfUserId);
        $this->assign("order_sta", $order_sta);
        $this->display();
    }
    
    public function about()
    {
        $this->display();
    }

    public function account_list()
    {
        $this->display();
    }

    public function account_record()
    {
        $this->display();
    }

    public function arrival()
    {
        $this->display();
    }

    public function coupon()
    {
        $this->display();
    }

    public function edit_name()
    {
        $this->display();
    }

    public function edit_desc()
    {
        $this->display();
    }

    public function feedback()
    {
        $this->display();
    }

    public function message_list()
    {
        $this->display();
    }

    public function my_fans_info()
    {
        $this->display();
    }

    public function my_friend()
    {
        $id = $_GET["id"];
        $this->assign("id", $id);
        $this->display();
    }

    public function my_friend_info()
    {
        $id = $_GET["id"];
        $this->assign("id", $id);
        $this->display();
    }

    public function my_help()
    {
        $this->display();
    }

    public function my_follow()
    {
        $this->display();
    }
    /*
     * 退款/售后
     * */
    public function reimburse()
    {
        $this->display();
    }

    public function recharge()
    {
        $this->display();
    }

    public function setting()
    {
        $this->display();
    }
    public function user_authen()
    {
        $getSelfUserId = $_SESSION["userArr"]["user_id"];
        $this->assign("userId", $getSelfUserId);
        $this->display();
    }

    public function user_info()
    {
        $getSelfUserId = $_SESSION["userArr"]["user_id"];
        $this->assign("userId", $getSelfUserId);
        $code = $_GET['code'];
        $this->assign("code", $code);
        $ifWeChatLogin = $_GET['ifWeChatLogin'];
        $this->assign("ifWeChatLogin", $ifWeChatLogin);
        $this->display();
    }
   
    public function msg_sys()
    {
        $msg_id = $_GET['msg_id'];
        $this->assign("msg_id",$msg_id);
        $this->display();
    }

    public function user_security()
    {
        $getSelfUserId = $_SESSION["userArr"]["user_id"];
        $this->assign("userId", $getSelfUserId);
        $code = $_GET['code'];
        $this->assign("code", $code);
        $ifWeChatLogin = $_GET['ifWeChatLogin'];
        $this->assign("ifWeChatLogin", $ifWeChatLogin);
        $ifWeChatBind = $_GET['ifWeChatBind'];
        $this->assign("ifWeChatBind", $ifWeChatBind);
        $this->display();
    }
}
