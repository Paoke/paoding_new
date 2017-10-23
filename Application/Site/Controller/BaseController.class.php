<?php
/**
 * tpshop
 * ============================================================================
 * * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: IT宇宙人 2015-08-10 $
 */ 
namespace Site\Controller;
use Think\Controller;
class BaseController extends Controller {
    public $http_url;
    public $user = array();
    public $user_id = 0;    
    /**
     * 析构函数
     */
    function __construct() {       
        parent::__construct();
    }
    
    /*
     * 初始化操作
     */
    public function _initialize() {
    }

}