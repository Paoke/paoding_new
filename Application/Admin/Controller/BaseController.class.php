<?php

namespace Admin\Controller;

use Think\Controller;

class BaseController extends Controller
{

    /**
     * 构造函数
     */
    function __construct()
    {
        parent::__construct();
        $this->assign('action', ACTION_NAME);//ACTION_NAME,tp中获取当前操作名

        //过滤不需要登陆的行为
        //in_array（规定要在数组搜索的值，规定要搜索的数组）搜索数组中是否有相应的值
        if (!in_array(ACTION_NAME, array('login', 'logout', 'vertify'))) {
            if (session('?admin_id')) {
                $this->checkRole();//检查管理员菜单操作权限
            } else {
                header("Location:" . U('Admin/Admin/login'));
                die();
            }
        }
        $this->public_assign();
    }

    public function getRequestData(){
        $getData = I('get.');
        $postData = I('post.');
        $param = array_merge($getData, $postData);
        return $param;
    }

    /**
     * 权限检查
     * @return array 返回权限信息
     */
    public function checkRole()
    {
        $ctl = CONTROLLER_NAME; //哪个控制器
        $act = ACTION_NAME; //哪个方法
        $systemModule = M('SystemModule');
        $manageAdminRoleValue = M('ManageAdminRoleValue'); //角色对应的菜单操作权限表
        $getAction = $_GET["action"];

        $actList = session('act_list'); // 用户的权限列表
        $roleId = session('role_id'); // 用户所属角色列表
     
        $noCheck = array('login', 'logout', 'welcome');
        if (($ctl == "Index" && $act == 'index') || in_array($act, $noCheck) || $actList == 'all') {
            $returnArr = array("result" => 1, "msg" => "请求成功", "code" => 200, "data" => []);
        } else {
            $ctl = $ctl.'/';
            $url = strchr($_SERVER["REQUEST_URI"], $ctl);
            if($ctl == 'Admin/') {
                $url = substr($url,6);
            }
            $if_type = strstr($url,"type");
            $url2 = strstr($url,"action",true);
            if($ctl !="Channel/"){
                $url3 = strstr($url,"channel");
                $url4 = strstr($url,"type/");
                $urlMiddle = strstr($url3,"type/",1);
                $urlEnd = substr($url4,0,6);
                $need=$this->getNeedBetween($url4);
            }




            //将所有url都转为带page_list的url因为$systemModule中url只有带有page_list的url
            //然后获取对应的action值，1为显示（即有权限）0为不显示
            if($url3) {
                    if($need) {
                        $url6 = $url2 . 'action/page_list/' .$urlMiddle."type/".$need;
                    } else {
                     
                        $url6 = $url2 . 'action/page_list/' .$url3;
                    }
            } else {
                if($ctl=='User/') {
                    $url6 = $url2 . 'action/page_list' ;
                } else {
                    if($ctl!='System/' && $getAction !='page_list') {

                        $url6 = $url2 . 'action/page_list' ;

                    } else {
                        $url6 = $url;
                    }
                }
            }

            //如果不在规定的参数内，则直接查找方法。
            $mod_id = $systemModule->where("url='$url6'")->getField('mod_id');


            //判断是否已经查找到了菜单ID值。
            if ($mod_id) {
                //将获取到的权限session，给分解出来。

                //判断是否根据系统指定的参数操作。
                if (!$getAction) {
                    $returnArr = array("result" => 1, "msg" => "请求成功", "code" => 200, "data" => []);

                } else {
                    if ($getAction == "page_edit") $getAction = "edit";
                    if ($getAction == "page_add") $getAction = "add";
                    if ($getAction == "page_list" || $getAction == "page_info" || $getAction == "extends") {
                        $returnArr = array("result" => 1, "msg" => "请求成功", "code" => 200, "data" => []);
                    } else {
                        foreach ($roleId as $value){
                           $getRole = $manageAdminRoleValue->where("role_id={$value['role_id']}  AND module_id = $mod_id  AND action_type = '$getAction' ")
                               ->find();
                        }
                        if($getRole){
                            $returnArr = array("result" => 1, "msg" => "请求成功", "code" => 200, "data" => []);
                            } else {
                            $returnArr = array("result" => 0, "msg" => "请求失败，您没有操作权限", "code" => 400, "data" => []);
                            }
                    }

                }
            } else {
//                $this->error('4您的账号没有操作权限');
//                exit;
                $returnArr = array("result" => 0, "msg" => "请求失败,您没有操作权限", "code" => 400, "data" => []);
            }
        }
        return $returnArr;
    }


        function getNeedBetween($kw1){

            $start1=strpos($kw1,'/',0);
            $start2=strpos($kw1,'/',$start1+1);
            return substr($kw1,$start1+1,$start2-1-$start1);
         }
    /**
     * 日志记录，用于内容管理的各种操作进行记录
     * @param int $level 日志警告级别,1：特别严重警告，2：严重警告，3：较大警告，4：一般警告，5：日志预警，6：普通操作
     * @param string $str 拼接字符串
     * @param int $operate_type 操作类型，-1未知类型，0管理员登陆，1用户登陆、2查看、3新增、4修改、5删除、6审核
     * @param int $channel_id 频道名称id,-1为空，
     * @param int $data_id 被记录日志的数据的id，-1为空
     */
    public function logRecord($level = 6, $str = "",$operate_type=-1,$channel_id = -1,$data_id = -1)
    {
        if (is_numeric($level) && !empty($level)) {
            $data["log_ip"] = $_SERVER["REMOTE_ADDR"];
            $data["admin_id"] = $_SESSION["admin_id"];
            $data["admin_user_name"] = $_SESSION["admin_user_name"];
            $data["user_id"] = $_SESSION["user_id"];
            $data["log_time"] = date("Y-m-d H:i:s", time());
            $data["log_url"] = $_SERVER["REQUEST_URI"];
            $data["log_level"] = $level;

            $data["log_info"] = "用户" . $str;

            $data["log_info"] =  $str;

            $data["channel_id"] = $channel_id;
            $data["data_id"] = $data_id;
            $data["operate_type"] = $operate_type;//log类型：-1未知，0管理员登陆，1用户登陆、2新增、3修改、4删除、5审核
            $info = M("SystemLog")->add($data);

            if ($info) {
                $returnArr = array("result" => 1, "msg" => "日志添加数据成功", "code" => 200);
            } else {
                $returnArr = array("result" => 0, "msg" => "日志添加数据错误", "code" => 400);
            }
        } else {
            $returnArr = array("result" => 0, "msg" => "日志警告级别参数（1：特别严重警告，2：严重警告，3：较大警告，4：一般警告，5：日志预警，6：普通操作）", "code" => 400);
        }
        json_encode($returnArr);
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

    /**
     * 批量写参数到模板
     */
    public function batch_assign($data){
        foreach($data as $key=>$value){
            $this->assign($key, $value);
        }
    }

    /*
     * 获取表的名称
     * */
    public function getTableName($channel = "", $type = 0) {
        $tableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type=$type")->getField("table_format");
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
