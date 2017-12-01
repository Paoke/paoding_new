<?php


namespace Mobile\Controller;


class DemandController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        parent::checkUrl();
    }

    //需求列表页
    public function demand_list()
    {
        $this->display();
    }

    //需求详情页
    public function detail()
    {
        $this->display();
    }

    //发布需求页
    public function release()
    {
        $this->checkReg();
        $this->display();
    }

}