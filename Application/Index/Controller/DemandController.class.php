<?php


namespace Index\Controller;


class DemandController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        parent::checkSite();
    }

    public function demand_show()
    {
        $this->display();
    }

    public function demand_detail()
    {
        $this->display();
    }

    public function demand_release()
    {
        $this->display();
    }
}