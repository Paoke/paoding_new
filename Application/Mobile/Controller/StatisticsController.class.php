<?php
/**
 * Created by PhpStorm.
 * User: 吴邦
 * Date: 2016/7/27
 * Time: 18:06
 */

namespace Mobile\Controller;

class StatisticsController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        parent::checkUrl();
    }
    public function index(){
        $this->display();
    }

    public function view_record(){

        $account = session('company_account');
        $this->assign('channel', $account['channel']);

        $this->display();
    }
}