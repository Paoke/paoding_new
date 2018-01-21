<?php

namespace Index\Controller;
use Think\Controller;

class IndexController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        parent::checkSite();
    }

    public function index()
    {
        $this->display();
    }

}