<?php
namespace Pc\Controller;

header("Content-Type: text/html;charset=utf-8");

class LoginController extends BaseController
{

    public $user_id = 0;
    public $user = array();

    public function __construct()
    {
        parent::__construct();
        parent::checkUrl();
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
        header("Location:" . U('Pc/Index/index'));
    }

}