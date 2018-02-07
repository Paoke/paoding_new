<?php


namespace Index\Controller;


class NewsController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        parent::checkSite();
    }

    public function news_index()
    {
        $this->display();
    }

}