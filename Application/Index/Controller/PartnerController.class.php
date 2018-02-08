<?php

namespace Index\Controller;


class PartnerController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        parent::checkSite();
    }

    public function partner_show()
    {
        $this->display();
    }

    public function partner_asso()
    {
        $this->display();
    }

    public function partner_topic()
    {
        $this->display();
    }


}