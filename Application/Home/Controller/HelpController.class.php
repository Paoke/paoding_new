<?php
namespace Home\Controller;
use Think\Controller;
/**
 * HelpController ：5U系统“帮助”页面控制器
 */
class HelpController extends Controller {
    public function helpshow(){
        $this-> display();
    }
}