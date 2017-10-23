<?php

namespace Mobile\Controller;

header("Content-Type: text/html;charset=utf-8");

class LoginController extends BaseController
{

    public $user_id = 0;
    public $user = array();

    public function __construct()
    {
        parent::__construct();
        //parent::checkUrl();
    }

    public function login()
    {
        $this->display();
    }

    /**
     * 用户注销(用户退出)
     */
    public function logout()
    {
        session_unset();
        session_destroy();
        setcookie('cn', '', time() - 3600, '/');
        setcookie('user_id', '', time() - 3600, '/');
        //$this->success("退出成功",U('Mobile/Index/index'));
        header("Location:" . U('Mobile/Login/login'));
    }

//    /**
//     * 绑定手机号 lsh更改2016.9.1
//     */
//    public function phone_add()
//    {
//        if (IS_POST) {
//            $logic = new ManageUsersLogic();
//            $username = I('post.username', '');
//            $password = I('post.password', '');
//            $password2 = I('post.password2', '');
//            $userid = I('post.userid', '');
//            $code = I('post.code', '');
//            $val = I('post.');
//            //检查用户输入短信函数，进行短信校验，检查是否注册，短信错误，短信失效等等
//            $switch_sms = M("config")->field("name,value")->where("name='switch_sms'")->select();
//            if ($switch_sms == 1) {
//                $res = check_mobile_code($username, $code);
//                // $res = array('status' =>1,'info'=>'bangding成功' );
//                if ($res['status'] == '1') {
//                    $data = $logic->bindPhone($userid, $username, $password, $password2);
//                    if ($data['status'] != 1)
//                        $this->error($data['msg']);
//                    else {
//                        session('user', $data['result']);
//                        setcookie('user_id', $data['result']['user_id'], null, '/');
//                        setcookie('is_distribut', $data['result']['is_distribut'], null, '/');
//                        $this->success($data['msg']);
//                    }
//                    exit;
//                } elseif ($res['status'] == '2') {
//                    $this->success($res['info']);
//                } elseif ($res['status'] == '3') {
//                    $this->success($res['info']);
//                }
//            } else {
//                $data = $logic->bindPhone($userid, $username, $password, $password2);
//                if ($data['status'] != 1)
//                    $this->error($data['msg']);
//                else {
//                    session('user', $data['result']);
//                    setcookie('user_id', $data['result']['user_id'], null, '/');
//                    setcookie('is_distribut', $data['result']['is_distribut'], null, '/');
//                    $this->success($data['msg']);
//                }
//                exit;
//            }
//
//        }
//        $userid = I('get.user_id');
//        $this->assign('userid', $userid);
//        $this->display();
//    }
//
//
//    /**
//     * 短信验证，前台发送短信的时候，直接跑到这里，然后生成短信验证码，发送短信，写入发送日志
//     */
//    public function verify()
//    {
//        $mobile = I('post.username');
//        //设置验证码位数
//        $code = get_mobile_code(6);
//        $add_time = time();
//        $session_id = session_id();
//        //保存短信验证码发送前的短信日志记录，通过该日志判断用户的发送情况
//        $data = save_sms_log($mobile, $code, $add_time, $session_id);
//        if ($data['status'] == '1') {
//            //日志记录后，发送短信，并返回结果
//            $res = sms_send($mobile, $code);
//            if ($res == true) {
//                $data = array('status' => '1', 'info' => '发送成功');
//                $this->success($data['info']);
//            } else {
//                $data = array('status' => '2', 'info' => '发送失败，请重试');
//                $this->success($data['info']);
//            }
//        } elseif ($data['status'] == '2') {
//            $data = array('status' => '3', 'info' => '发送失败，请重试');
//            $this->success($data['info']);
//        } elseif ($data['status'] == '3') {
//            $data = array('status' => '4', 'info' => '操作过于频繁，请稍后再试');
//            $this->success($data['info']);
//        }
//    }
//
//    //获取短信是否开启
//    public function verifyHandle()
//    {
//        $switch = M("config")->where("name='regis_sms_enable'")->find();
//        return $switch;
//    }
//
//    public function company_register(){
//        $this->assign('channel', $_GET['channel']);
//        $this->display();
//    }
}