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

    public function activity_detail()
    {
        $this->display();
    }

    public function activity_release()
    {
        $this->display();
    }

    public function activity_meeting()
    {
        $this->display();
    }

    public function activity_salon()
    {
        $this->display();
    }

}