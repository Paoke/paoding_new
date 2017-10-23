<?php

namespace Pc\Controller;

use Think\Controller;
use Think\Model;

class BaseController extends Controller
{
    public $user = array();
    public $user_id = 0;
    public $session_id;
    public $weixin_config;
    public $cateTrre = array();
   
    /**
     * 构造函数
     */
    function __construct()
    {
        parent::__construct();
        $this->public_assign();
    }

    /**
     * 检查是否登录的函数
     */
    public function checkReg()
    {
        if (empty($_SESSION["userArr"])) {
            $this->display("Login/login");
            exit;
        }
    }

    /**
     * 检查站点是否正确的函数
     */
    public function checkSite()
    {
        $site_name = session('site_name');

        if (!empty($site_name)) {
            return site_template_config($site_name, 0);
        }
        return false;
    }

    /**
     * 进来页面的时候，在子类调用
     * 判断是否注册。注册后根据传递的url前往不同的url
     */
    public function checkUrl()
    {
        //获取url
        $url =  $_SERVER['PHP_SELF'];
        $_SESSION['intoUrl'] = $url;

        //获取站点名
        $site_name = session('site_name');
        if (!empty($site_name)) {
            site_template_config($site_name, 0);
        }
    }

    /**
     * 保存公告变量到 smarty中 比如 导航
     */
    public function public_assign()
    {
        $gemmap_config = array();
        $tp_config = M('config')->select();
        foreach ($tp_config as $k => $v) {
            $gemmap_config[$v['inc_type'] . '_' . $v['name']] = $v['value'];
        }
        $this->assign('gemmap_config', $gemmap_config);
    }

    /*
     * 获取表的名称
     * */
    public function getTableName($channel = "", $type = 0) {
        $tableName = M()->table("{$_SESSION["site_name"]}_system_channel_table_config")->where("channel='$channel' AND type=$type")->getField("table_format");
        if($tableName) {
            return $tableName;
        } else {
            return false;
        }
    }

    public function getViewRecordTable($channelIndex){
        $channel = M('SystemChannel')->where("call_index='".$channelIndex."'")->find();
        $table = ucfirst($channel['base_module']) . ucfirst($channelIndex) . 'ViewRecord';
        return $table;
    }
}
