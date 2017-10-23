<?php

namespace Mobile\Controller;


class CompanyUserController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        parent::checkUrl();
    }

    public function company_center(){

        $this->assign('account', $_COOKIE['company_account']);
        $this->display();
    }

    public function reset_pw(){

        $this->assign('channel', $_GET['channel']);
        $this->display('company_find_pw');
    }

    public function company_info(){

        $account = session('company_account');

        $this->assign('company_id', $account['data_id']);
        $this->assign('channel', $account['channel']);
        $this->display();
    }

    public function company_fans(){
        $account = session('company_account');

        $this->assign('account_id', $account['id']);
        $this->assign('company_id', $account['data_id']);
        $this->assign('channel', $account['channel']);
        $this->display();
    }
}
