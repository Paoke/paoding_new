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

}