<?php

namespace Index\Controller;


class ActivityController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        parent::checkSite();
    }

    public function activity_show()
    {
        $this->display();
    }

}