<?php

namespace Admin\Controller;

use Think\Log;

header("Content-type: text/html; charset=utf-8");

class IndexController extends BaseController
{

    /**
     * 析构函数，判断权限等
     */
    public function __construct()
    {
        parent::__construct();
//        $res = parent::checkRole();
//        if ($res["result"] != 1) {
//            $this->error("您的账号没有操作权限");
//        }
    }

    public function index()
    {
        $act_list = session('act_list');
        //获取顶部菜单
        $top_menu = $this->getTopMenu($act_list);
        $this->assign('topmenu_list', $top_menu);
        $this->assign('first_menu', $top_menu[0]);

        //获取侧边栏菜单
        $menu_list = $this->getRoleMenu($act_list);
        $menu_list = json_encode($menu_list);
        $this->assign('menu_list', $menu_list);

        //获取管理员资料
        $user_info = getUserInfo(session('admin_id'));
        $this->assign('user_info', $user_info);

        //获取logo等配置、账号信息
        $logo = M('config')->where("name = 'store_logo'")->getField('value');
        $small_logo = M('config')->where("name = 'store_small_logo'")->getField('value');
        $site_left_logo = M('config')->where("name = 'site_left_logo'")->getField('value');
        $this->assign('logo', $logo);
        $this->assign('small_logo', $small_logo);
        $this->assign('site_left_logo', $site_left_logo);
        $this->display();
    }

    public function welcome()
    {
        $this->assign('sys_info', $this->get_sys_info());
        $nowTime = date("Y-m-d H:i:s", time());
        $today = strtotime("-1 day");
        $thisMonth = date("Y-m-01 00:00:00",strtotime($nowTime));
        $thisMonthStamp = strtotime($thisMonth);
        $thisYear = date("Y-01-01 00:00:00",strtotime($nowTime));
        $thisYearStamp = strtotime($thisYear);

        //获取统计信息
        //$count['handle_order'] = M('GoodsOrder')->where("add_time>$today " . C('WAITSEND'))->count();//待发货订单
        //$count['new_order'] = M('GoodsOrder')->where("add_time>$today")->count();//今天新增订单
        //$count['goods'] = M('goods')->where("1=1")->count();//商品总数
        $count['users'] = M('ManageUsers')->count();//会员总数
     //   $count['today_login'] = M('ManageUsers')->where("unix_timestamp(last_login)>$today")->count();//今日活跃量
        $count['today_login'] = M('ManageUserRecord')->where("unix_timestamp(create_time)>$today")->count();//今日活跃量
        $count['month_login'] = M('ManageUserRecord')->where("unix_timestamp(create_time)>$thisMonthStamp")->count();//本月活跃量
        $count['year_login'] = M('ManageUserRecord')->where("unix_timestamp(create_time)>$thisYearStamp")->count();//本年活跃量
        $count['today_users'] = M('ManageUsers')->where("unix_timestamp(reg_time)>$today")->count();//新增会员
        $count['month_users'] = M('ManageUsers')->where("unix_timestamp(reg_time)>$thisMonthStamp")->count();//新增会员
       // $count['comment'] = M('GoodsComment')->count();//最新评论
        //服务对接
        $where['clyj']='';
        $Handle['ycl'] = M("ArticleFwdj")->where("clyj='已处理' AND is_deleted=0")->count();
        $Handle['wcl'] = M("ArticleFwdj")->where("is_deleted=0")->count()- $Handle['ycl'];
        $this->assign("Handle",$Handle);

        $this->assign('count', $count);
        $act_list = session('act_list');
        $this->assign('act_list', $act_list);

        $this->display();
    }

    public function map()
    {
        $all_menu = $this->getRoleMenu('all');
        $this->assign('all_menu', $all_menu);
        $this->display();
    }

    public function get_sys_info()
    {
        $sys_info['os'] = PHP_OS;
        $sys_info['zlib'] = function_exists('gzclose') ? 'YES' : 'NO';//zlib
        $sys_info['safe_mode'] = (boolean)ini_get('safe_mode') ? 'YES' : 'NO';//safe_mode = Off
        $sys_info['timezone'] = function_exists("date_default_timezone_get") ? date_default_timezone_get() : "no_timezone";
        $sys_info['curl'] = function_exists('curl_init') ? 'YES' : 'NO';
        $sys_info['web_server'] = $_SERVER['SERVER_SOFTWARE'];
        $sys_info['phpv'] = phpversion();
        $sys_info['ip'] = GetHostByName($_SERVER['SERVER_NAME']);
        $sys_info['fileupload'] = @ini_get('file_uploads') ? ini_get('upload_max_filesize') : 'unknown';
        $sys_info['max_ex_time'] = @ini_get("max_execution_time") . 's'; //脚本最大执行时间
        $sys_info['set_time_limit'] = function_exists("set_time_limit") ? true : false;
        $sys_info['domain'] = $_SERVER['HTTP_HOST'];
        $sys_info['memory_limit'] = ini_get('memory_limit');
//        $sys_info['version']   	    = file_get_contents('./Application/Admin/Conf/version.txt');
//		$version_array = simplexml_load_file('Application/Admin/Conf/version.xml');
//
//		$sys_info['appversion'] = $version_array->appversion;
//		$sys_info['updatetime'] = $version_array->updatetime;
//		$sys_info['enterprise'] = $version_array->enterprise;

        $web_info = explode(" ", $sys_info['web_server']);
        $sys_info['apache'] = $web_info[0];
        $sys_info['win'] = $web_info[1];

        $xml = file_get_contents('./Application/Admin/Conf/version.xml');
        preg_match_all("/\<versioninfo\>(.*?)\<\/versioninfo\>/s", $xml, $versioninfo);
        //匹配最外层标签里面的内容
        foreach ($versioninfo[1] as $k => $versioninfo) {
            preg_match_all("/\<appversion\>(.*?)\<\/appversion\>/", $versioninfo, $_appversion);
            //匹配出版本
            preg_match_all("/\<updatetime\>(.*?)\<\/updatetime\>/", $versioninfo, $_updatetime);
            //匹配出更新时间
            preg_match_all("/\<enterprise\>(.*?)\<\/enterprise\>/", $versioninfo, $_enterprise);
            //匹配出企业
        }

        $sys_info['appversion'] = $_appversion[0][0];
        $sys_info['updatetime'] = $_updatetime[0][0];
        $sys_info['enterprise'] = $_enterprise[0][0];

        $mysqlinfo = M()->query("SELECT VERSION() as version");
        $sys_info['mysql_version'] = $mysqlinfo[0]['version'];
        if (function_exists("gd_info")) {
            $gd = gd_info();
            $sys_info['gdinfo'] = $gd['GD Version'];
        } else {
            $sys_info['gdinfo'] = "未知";
        }
        return $sys_info;
    }

    public function getTopMenu($act_list)
    {
        if($act_list && $act_list != 'all'){
            $condition['mod_id'] = array('IN', $act_list);
        }
        $condition['level'] = 1;
        $condition['visible'] = 1;
        $Module =  D('SystemModule');
        $topMenu = $Module->field("mod_id,title,icon")->where($condition)->order("orderby ASC,mod_id")->select();
        return $topMenu;
    }

    public function getRoleMenu($act_list)
    {
        $modules = $roleMenu = array();
        $rs = M('system_module')->field("mod_id,url,action,icon,title,level,parent_id")->where('level>1 AND visible=1')->order('orderby ASC,mod_id')->select();
        if ($act_list == 'all') {
            foreach ($rs as $row) {
                if ($row['level'] == 3) {
                    $modules[$row['parent_id']][] = $row;//子菜单分组
                }
                if ($row['level'] == 2) {
                    $pmenu[$row['mod_id']] = $row;//二级父菜单
                }
            }
        } else {
            $act_list = explode(',', $act_list);
            /* $parent_id_path = M('system_module')->where("level=2")->getField('parent_id_path');
       $array=explode(',',$act_list);
       $string=explode('_',$parent_id_path);
       foreach ($array as $val){
           if($string[2] == $val) {
               foreach ($array as $val){
                   if($string[3] == $val){
                       $mod_id = M('system_module')->where("url='$url6'")->getField('mod_id');
                       break;
                   }
               }
               break;
           }
       }*/
            foreach ($act_list as $val) {
                $parent_id_path[$val] = M('SystemModule')->where("level=2 AND mod_id =$val")->getField('parent_id_path');
            }
            
            $parent_id = array_filter($parent_id_path);
            foreach ($parent_id as $item=>$val) {
                $parent_id1[$item] =explode('_',$val)[2];
            }
            foreach ($act_list as $val) {
                foreach ($parent_id1 as $item=>$val2) {
                    if($val2 == $val ) {
                        $ee[$item] =$item;
                    }
                }
            }


            foreach ($rs as $row) {
                if (in_array($row['mod_id'], $act_list) && !($row['ctl'] == 'System' && $row['url'] == 'menu')) {
                    $modules[$row['parent_id']][] = $row;//子菜单分组
                }
               /* if ($row['level'] == 2) {
                    $pmenu[$row['mod_id']] = $row;//二级父菜单
                }*/
            }
        }
         foreach ($ee as $item=>$value) {
                       $pmenu[$item] = M('system_module')->field("mod_id,url,action,icon,title,level,parent_id")->where("mod_id=$value")->order('mod_id ASC')->select()[0];
                   }

        $keys = array_keys($modules);//导航菜单
        foreach ($pmenu as $k => $val) {
            if (in_array($k, $keys)) {
                $val['submenu'] = $modules[$k];//子菜单
                $roleMenu[] = $val;
            }
        }
        return $roleMenu;
    }

    /**
     * ajax 修改指定表数据字段  一般修改状态 比如 是否推荐 是否开启 等 图标切换的
     * table,id_name,id_value,field,value
     */
    public function changeTableVal()
    {
        $mod_id = I('mod_id'); // 模块id
        $act_list = session('act_list');
        $act_list = explode(',', $act_list);
//        if (($mod_id && in_array($mod_id, $act_list)) || $act_list[0] == 'all') {
            $table = I('table'); // 表名
            $id_name = I('id_name'); // 表主键id名
            $id_value = I('id_value'); // 表主键id值
            $field = I('field'); // 修改哪个字段
            $value = I('value'); // 修改字段值
            if ($table == 'Article_cat') {
                $parent_id = M($table)->where("$id_name = $id_value")->getField('parent_id');
                if ($parent_id == 0) {
                    M($table)->where("$id_name = $id_value")->save(array($field => $value)); // 根据条件保存修改的数据
                    M($table)->where("parent_id = $id_value")->save(array($field => $value)); // 根据条件保存修改的数据
                    exit(json_encode(array('status' => 1)));
                } else {
                    $show_in_nav = M($table)->where("$id_name = $parent_id")->getField('show_in_nav');
                    if ($show_in_nav == 1) {
                        M($table)->where("$id_name = $id_value")->save(array($field => $value));
                        exit(json_encode(2));
                    } else {
                        exit(json_encode(array('status' => 0, 'msg' => '请先更改其上级的显示设置!')));

                    }
                }
            } else {
                M($table)->where("$id_name = $id_value")->save(array($field => $value)); // 根据条件保存修改的数据
                exit(json_encode(2));
            }
//        } else {
//            exit(json_encode("您的账号没有操作权限"));
//        }
    }

    /**
     * ajax 指定表数据字段自加一  比如 点击量
     * table,id_name,id_value,field
     */
    public function changeClickVal()
    {
        $table = I('table'); // 表名
        $id_name = I('id_name'); // 表主键id名
        $id_value = I('id_value'); // 表主键id值
        $field = I('field'); // 修改哪个字段
        $count = M($table)->where("$id_name = $id_value")->getField($field);//取值
        $count++;//加1
        if (M($table)->where("$id_name = $id_value")->save(array($field => $count)))//更新
            exit(json_encode(array('status' => 1, 'msg' => '更新成功')));
        else
            exit(json_encode(array('status' => 0, 'msg' => '更新失败')));
    }
}
