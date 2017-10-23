<?php
namespace Home\Behaviors;
use Think\Model;

class siteBehavior extends \Think\Behavior{
    //行为执行入口
    public function run(&$param){
        if(empty(session('site_name'))){
            $site_name = get_site_name();
            session('site_name', $site_name);
        }
        //Log::write(">>>>>>>>>>>session.site_name【" .session('site_name'). "】");
    }
}