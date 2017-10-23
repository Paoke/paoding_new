<?php

namespace Admin\Controller;


use Think\Controller;

header("Content-type: text/html; charset=utf-8");

class IeupdateController extends Controller
{

    /**
     * 析构函数
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->display("ieupdate");
    }
}
