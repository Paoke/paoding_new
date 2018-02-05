<?php


namespace Index\Controller;


class LoginController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        parent::checkSite();
    }

    public function login()
    {
        $this->display();
    }

}