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
        $where['is_deleted'] = 0;
        $where['is_active'] = 1;
        $where['status'] = 0;
        $count=M('article_js')->where($where)->count();
        $this->assign(compact('count'));
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