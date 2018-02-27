<?php

namespace Index\Controller;


class AboutController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->checkSite();
    }

    public function about()
    {
        $this->display();
    }

    public function contact()
    {
        $this->display();
    }

    public function service()
    {
        $this->display();
    }

    public function job()
    {
        $this->display();
    }

    public function jobDetail()
    {
        $this->display();
    }


}