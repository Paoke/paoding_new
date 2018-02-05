<?php


namespace Index\Controller;


class RegisterController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        parent::checkSite();
    }

    public function register()
    {
        $this->display();
    }

}