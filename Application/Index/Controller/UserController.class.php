<?php

namespace Index\Controller;


class UserController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        parent::checkSite();
        $this->checkReg();
        if(session('status')==""){
            $status = M('manage_user_authen')->where('user_id='.session('userId'))->field('status')->find();
            session("status", $status['status']);
        }

    }


    public function user_demand()
    {
        $this->display();
    }

    public function user_tec()
    {
        $this->display();
    }

    public function user_msg()
    {
        $this->display();
    }

    public function user_collect()
    {
        $this->display();
    }

    public function user_project()
    {
        $this->display();
    }

    public function user_info()
    {
        $this->display();
    }



}