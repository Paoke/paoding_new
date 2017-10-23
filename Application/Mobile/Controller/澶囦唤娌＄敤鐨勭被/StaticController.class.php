<?php
/**
 * Created by PhpStorm.
 * User: 吴邦
 * Date: 2016/7/27
 * Time: 18:06
 */

namespace Mobile\Controller;
use Think\Controller;

//header("Content-Type: text/html;charset=utf-8");

class StaticController extends BaseController
{
    /**
     * 尾部
     */
    public function footer()
    {
        $this->display();
    }

    /**
     * 头部
     */
    public function header()
    {
        $this->display();
    }
}

