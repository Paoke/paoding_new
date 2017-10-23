<?php
/**
 * Created by PhpStorm.
 * User: 吴邦
 * Date: 2016/7/27
 * Time: 18:19
 */
namespace Mobile\Controller;

header("Content-Type: text/html;charset=utf-8");

class EnrollerController extends BaseController{
    public function __construct()
    {
        parent::__construct();
        parent::checkMp();
    }
    
    //
    
}