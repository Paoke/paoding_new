<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
/**
 * IndexController ：5U系统“首页”页面控制器
 */

class IndexController extends Controller {
    public function index(){
        $serverNameAll = $_SERVER['SERVER_NAME'];
        $serverNameOrder = strpos($serverNameAll,".");
        $serverName = substr($serverNameAll,0,$serverNameOrder);
        $siteName = D('Admin/SiteTemplateConfig')->field("site_name")->select();
        foreach ($siteName as $siteNamevalue1) {
            foreach ($siteNamevalue1 as $siteNamevalue2)
            $siteNamev[] = $siteNamevalue2;
        }
        foreach ($siteNamev as $siteNamevalue3) {
            if($serverName == $siteNamevalue3){
               // print_r($siteNamevalue2);
                
                $pcIndex=A('Pc/Index');
                $pcIndex->pcIndex($serverNameAll);
                exit();
            }
        }
        if($serverName == "www"){
            $this->display();
        } else {
            $this->display();
        }

    }
}