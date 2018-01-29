<?php


namespace Index\Controller;


class TecController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        parent::checkSite();
    }

    public function tec_show()
    {
        $this->display();
    }

    public function tec_theme()
    {
        $this->display();
    }

    public function tec_list()
    {
        $this->display();
    }

    public function tec_release()
    {
        $this->display();
    }

    public function tec_detail()
    {
        $this->display();
    }

}