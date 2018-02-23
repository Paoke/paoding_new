<?php

namespace Index\Controller;

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
        if($this->isMobile()){
            header('HTTP/1.1 301 Moved Permanently');//发出301头部
            header('Location:http://www.paoding.cc/index.php/Mobile/Index/index');
            exit;
        }
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
            return site_template_config($site_name, 2);
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

    public function isMobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA']))
        {
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT']))
        {
            $clientkeywords = array ('nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
            {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT']))
        {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
            {
                return true;
            }
        }
        return false;
    }

}
