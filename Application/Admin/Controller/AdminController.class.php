<?php

namespace Admin\Controller;

use Think\Verify;

header("Content-type: text/html; charset=utf-8");

class AdminController extends BaseController
{
    /**
     * 析构函数，判断权限等
     */
    public function __construct()
    {
        parent::__construct();
        $act = ACTION_NAME; //哪个方法
        $action = $_GET["action"];//action/page_list
        $check = array('page_list', 'page_add', 'page_edit','del');
        $checkAction = array('role');
        if(in_array($act,$checkAction) && in_array($action,$check)) {
            $res = parent::checkRole();
            if ($res["result"] != 1) {
                $this->error("您的账号没有操作权限");
            }
        }
    }

    /**
     * 角色管理 - 入口函数
     * page_list，page_add，page_edit 编辑页面显示
     * add，edit,del，编辑动作
     */
    public function role()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $systemModel = M('SystemModule');
        $manageAdminRole = M('ManageAdminRole');
        $manageAdminRoleValue = M('ManageAdminRoleValue');
        C('TOKEN_ON',false);
        switch ($action) {
            case "page_list":
                $count = $manageAdminRole->count();          //$count    总共有多少条数据
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页

                //特殊处理，属于超级管理员角色的用户能够看到超级管理员的角色，并进行编辑
                $admin_info=getUserInfo(session('admin_id'));
                if($admin_info['role_id']>1){
                    $where="role_id>1";
                }
                $list = $manageAdminRole->page($page_now, $page_num)->where($where)->order('role_id asc')->select();

                $this->assign('page', $page);
                $this->assign('page_num', $page_num);
                $this->assign('page_now', $page_now);
                $this->assign('count', $count);
                $this->assign('list', $list);
                $this->display("role_list");
                break;
            case "page_add":
                $info = $systemModel->field("mod_id,parent_id,title,action,(level * 2) as level,concat(parent_id_path, mod_id, '_') as a")->order("a ASC,mod_id ASC")->select();
                foreach ($info as $item => $value) {
                    $value["action"] = json_decode($value["action"], true);
                    $list[] = $value;
                }
                $info = json_encode($list);
                $this->assign("menuTree", $info);
                $this->display("role_info");
                break;
            case "page_edit":
                if ($getId == 1) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(2, "非法操作，试图改变超级管理员权限");
                    $this->error('请求失败,超级管理员不能修改操作权限');
                    exit;
//                    $returnArr = array("result" => 0, "msg" => "请求失败,超级管理员不能修改操作权限", "code" => 400, "data" => []);
                } else {
                    if ($getId) {
                        $infoRole = $manageAdminRole->where("role_id = $getId")->find();
                        $infoRoleValue = $manageAdminRoleValue->where("role_id = $getId")->select();
                        //将角色的权限转换成可显示格式
                        $roleActionType = $this->roleToJson($infoRoleValue);
                        $info = $systemModel->field("mod_id,parent_id,title,action,(level * 2) as level,concat(parent_id_path, mod_id, '_') as a")->order("a ASC,mod_id ASC")->select();
                        //   $info1 = json_encode($info);

                        foreach ($info as $item => $value) {
                            $defaultActions = json_decode($value["action"], true);


                            $roleManu = $roleActionType[$value['mod_id']];
                            if(!$defaultActions){
                                $defaultActions = $roleManu;
                            }

                            if($roleManu){
                                foreach($defaultActions as $k => $v){
                                    //if($defaultActions[$k] == 1){
                                    if($roleManu[$k] == 1){
                                        $defaultActions[$k] = 1;
                                    }else{
                                        $defaultActions[$k] = 0;
                                    }
                                    // }
                                }

                            }else{

                                foreach($defaultActions as $k => $v){
                                    $defaultActions[$k] = 0;
                                }
                            }
                            $value["action"] = $defaultActions;
                            $list[] = $value;
                        }
                        $info = json_encode($list);

                        $this->assign("menuTree", $info);

                    } else {
                        $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
                    }
                    $this->assign("info", $infoRole);
                    $this->assign("page_title", $action);
                    $this->display("role_info");
                }
                break;
            case "add"://用户权限新增保存
                $postData = I("post.");
                //设置需要填写的input。
                $returnArr = array("result" => 0, "msg" => "提交失败，角色名称与角色描述为必填项", "code" => 402, "data" => null);
                if (empty($postData["role_name"])) json_return($returnArr);
                if (empty($postData["role_desc"])) json_return($returnArr);

                $info = $this->addRoleValue($postData);
                if ($info) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加" . $postData["role_name"] . "角色成功");
                    $returnArr = array("result" => 1, "msg" => "提交成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5, "添加角色失败，数据库录入失败");
                    $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
                }
                break;
            case "edit"://用户权限编辑保存
                $postData = I("post.");
                //设置需要填写的input。
                $returnArr = array("result" => 0, "msg" => "提交失败，角色名称与角色描述为必填项", "code" => 402, "data" => null);
                if (empty($postData["role_name"])) json_return($returnArr);
                if (empty($postData["role_desc"])) json_return($returnArr);

                $info = $this->editRoleValue($postData);
                if ($info) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "更新" . $postData["role_name"] . "角色成功");
                    $returnArr = array("result" => 1, "msg" => "提交成功", "code" => 402, "data" => null);

                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5, "更新" . $postData["role_name"] . "角色失败，数据库录入失败");
                    $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 200, "data" => null);
                }
                break;
            case "del":
                $logData = $manageAdminRole->where("role_id = $getId")->find();
                $result1 = $manageAdminRole->where("role_id = $getId")->delete();
                $result2 = $manageAdminRoleValue->where("role_id = $getId")->delete();
                if ($result1 && $result2) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "删除角色" . $logData["role_name"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5, "删除角色" . $logData["role_name"] . "失败，数据库删除失败");
                    $returnArr = array("result" => 0, "msg" => "系统繁忙，请联系管理员", "code" => 402, "data" => null);
                }
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法");
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }

    /*
     * 将权限变为json
     * */
    public function roleToJson($value){

        foreach ($value as $value1) {
            $roleList[$value1['module_id']][$value1['action_type']] = 1;
            $roleJson[$value1['module_id']] = $roleList[$value1['module_id']];
        }
        return $roleJson;
    }

    /**
     * 角色用户管理 - 入口函数
     * page_list编辑页面显示
     * add,del，编辑动作
     */
    public function role_user()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $user=M("ManageUsers");
        $role=M("ManageAdminRoleRelation");
        $admin=M("ManageAdminRole");
        C('TOKEN_ON',false);
        switch ($action) {

            case "page_list"://角色用户列表

                $count=$user->where("user_id=1")->count();
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                //$data=$user->where("user_id=1")->field("user_name,user_id,nickname")->select();

                $into=$user->field("user_id,user_name")->limit(10)->order("reg_time ASC")->select();

                $sql="SELECT USER_ID,USER_NAME FROM 5u_manage_users A WHERE USER_ID NOT IN(SELECT USER_ID FROM 5u_manage_admin_role_relation B WHERE B.USER_ID=A.USER_ID AND B.role_id =". $getId.") AND A.user_name !=''";
                $info=M()->query($sql);
//                $info=M("manage_admin_role_relation")->join("AS A LEFT JOIN __MANAGE_USERS__ AS B ON B.user_id=A.user_id")
//                    ->field("B.user_name")
//                    ->select();

                $where['A.is_sys']=1;
                $where['A.role_id']=$getId;
                $data=M("manage_admin_role_relation")
                    ->join("AS A LEFT JOIN __MANAGE_USERS__ AS B ON B.user_id=A.user_id LEFT JOIN __MANAGE_ADMIN_ROLE__ AS C ON C.role_id=A.role_id")
                    ->field("A.role_id,A.user_id,B.user_name,C.role_name")
                    ->where($where)
                    ->select();

                $this->assign("into",$info);
                $this->assign("info",$info);
                $this->assign("page_num",$page_num);
                $this->assign("page_now",$page_now);
                $this->assign("page",$page);
                $this->assign("count",$count);
                $this->assign("data",$data);
                $this->assign("role_id",$getId);
                $this->display("role_user_list");
                break;
            case "add"://角色用户新增

                break;
            case "del"://角色用户删除
                /*   $logData = M("ManageAdminRole")->field("role_name")->where("role_id=$getId")->find();
                   $row = M('ManageAdminRole')->where(array('role_id' => $getId))->delete();*/
                $logData = M("ManageUsers")->field("user_name")->where("user_id=$getId")->find();
                $row = M('ManageAdminRoleRelation')->where(array('user_id' => $getId))->delete();
                if($row){
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "删除超级管理员" . $logData["role_name"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);
                }else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5, "删除超级管理员" . $logData["role_name"] . "失败");
                    $returnArr = array("result" => 0, "msg" => "删除失败", "code" => 402, "data" => null);
                }
                break;
            case "list":
                $keyword=trim(I("user_name"));
                if($keyword){
                    $where['user_name']=array("EXP","LIKE '%$keyword%'");
                    $data=M("ManageUsers")->where($where )->field("user_id,user_name")->select();
                } else {
                    $data=M("ManageUsers")->where("user_name !=''")->field("user_id,user_name")->select();
                }

                if($data){
                    $returnArr=array("result"=>1,"msg"=>"获取数据成功","code"=>200,"data"=>$data);
                }else {
                    $returnArr=array("result"=>0,"msg"=>"获取数据失败","code"=>402,"data"=>null);
                }
                break;
            case "confirm":
                $post=I("post.");
                $info=explode(',',$post['id']);
                $role_id=$post['role_id'];

                /*  $returnArr = array("result" => 0, "msg" => "已存在", "code" => 402, "data" => null);
                  $where=array("user_id = '" . $post['id'] . "'");
                  if(M("ManageAdminRoleRelation")->where($where)->count()){
                      json_return($returnArr);
                  }*/

                $i=0;
                foreach($info as $key=>$value){
                    $data[$i]['user_id']=$value;
                    $data[$i]['role_id']=$role_id;
                    $data[$i]['is_sys']=1;
                    $i++;
                }

                $data=M("ManageAdminRoleRelation")->addAll($data);

                if($data){
                    $this->logRecord(6,"添加成功",3);
                    $returnArr=array("result"=>1,"msg"=>"添加成功","code"=>200,"data"=>null);
                }else {
                    $this->logRecord(5,"添加失败",3);
                    $returnArr=array("result"=>0,"msg"=>"添加失败","code"=>402,"data"=>null);
                }


                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法");
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }

    /**
     * 组织机构 - 入口函数
     * page_list，page_add，page_edit 编辑页面显示
     * add，edit,del，编辑动作
     */
    public function department()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $manageDepartmentModel = M("ManageDepartment");
        switch ($action) {
            case "page_list":
                $manageDepartmentModel = M("ManageDepartment");
                //查找组织数据
                $info = $manageDepartmentModel->field("id,logo,name,full_name,parent_id,parent_id_path,level,sort,create_user_id,create_time,is_out")->where("level=1 AND is_deleted != 1")->order("sort ASC")->select();
                //判断是否有id传进来
                if ($getId) {
                    $info = $manageDepartmentModel->field("id,logo,name,full_name,parent_id,level,sort,create_user_id,create_time,is_out")->where("parent_id=$getId")->order("sort ASC")->select();
                    //判断是否有子节点，有则添加infoSon键值
                    foreach ($info as $item => $value) {
                        $infoSon = $manageDepartmentModel->where("parent_id={$value['id']}")->count();
                        $info[$item]["create_user"] = M("manageUsers")->where("user_id={$value['create_user_id']}")->getField("user_name");
                        $info[$item]["infoSon"] = $infoSon;
                    }
                    //判断是否该节点是否点击，获取点击的id下面的所有子id
                    if ($_GET["getTreeSon"] == "1") {
                        $manageDepartmentModel = M("ManageDepartment");
                        $info = $manageDepartmentModel->field("id,parent_id,level")->select();
                        //获取所有子id的函数
                        $info = $this->getTreeSon($info, $getId, 1);
                    }
                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
                    json_return($returnArr);
                }
                //判断该分级下面是否还有分级，有分级则给 infoSon 作为标记。
                foreach ($info as $item => $value) {
                    $infoSon = $manageDepartmentModel->where("parent_id={$value['id']}")->count();
                    $info[$item]["create_user"] = M("manageUsers")->where("user_id={$value['create_user_id']}")->getField("user_name");
                    $info[$item]["infoSon"] = $infoSon;
                }
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $count =  $manageDepartmentModel->where("parent_id=0")->count();          //$count    总共有多少条数据
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                $this->assign('count', $count);
                $this->assign('page', $page);
                $this->assign('page_num', $page_num);
                $this->assign('page_now', $page_now);
                $this->assign("infoSon", $infoSon);
                $this->assign("info", $info);
                $this->display("department_list");
                break;
            case "page_add":
                $manageDepartmentModel = M("ManageDepartment");
                $info = $manageDepartmentModel->field("id,name,(level*2) as level,concat(parent_id_path,id,'_') as a")->order("a ASC,sort ASC")->select();
                $this->assign("departmentTree", $info);
                $this->display("department_info");
                break;
            case "page_edit":
                $manageDepartmentModel = M("ManageDepartment");
                //有编辑id值则显示页面。
                if ($getId) {
                    $info = $manageDepartmentModel->field("id,name,parent_id,(level*2) as level,concat(parent_id_path,id,'_') as a")->order("a ASC,sort ASC")->select();
                    $this->assign("departmentTree", $info);
                    $info = $manageDepartmentModel->where("id=$getId")->find();
                    $this->assign("info", $info);
                    $this->display("department_info");
                } else {
                    $returnArr = array("result" => 0, "msg" => "提交失败，没有指定编辑信息", "code" => 402, "data" => null);
                }
                break;
            case "add":
                $postData = I("post.");
                //设置需要填写的input。
                $returnArr = array("result" => 0, "msg" => "提交失败，请填写除了备注与logo的所有内容", "code" => 402, "data" => null);
                if (empty($postData["name"])) json_return($returnArr);
                if (empty($postData["full_name"])) json_return($returnArr);
                if (empty($postData["sort"])) json_return($returnArr);
                $info = $this->addDepartment($postData);
                if ($info) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加组织机构" . $postData["name"] . "失败，数据库删除失败",3);
                    $returnArr = array("result" => 1, "msg" => "提交成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5, "添加组织机构失败，数据库录入失败",3);
                    $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
                }
                break;
            case "edit":
                $postData = I("post.");
                //设置需要填写的input。
                $returnArr = array("result" => 0, "msg" => "提交失败，请填写除了备注与logo的所有内容", "code" => 402, "data" => null);
                if (empty($postData["name"])) json_return($returnArr);
                if (empty($postData["full_name"])) json_return($returnArr);
                if (empty($postData["sort"])) json_return($returnArr);
                if ($postData["id"] == $postData["parent_id"]) {
                    $returnArr = array("result" => 0, "msg" => "提交失败，不能将自己作为上级", "code" => 402, "data" => null);
                } else {
                    $info = $this->editDepartment($postData);
                    if ($info) {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(6, "编辑组织机构" . $postData["name"] . "成功",4);
                        $returnArr = array("result" => 1, "msg" => "提交成功", "code" => 200, "data" => null);
                    } else {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(5, "编辑组织机构" . $postData["name"] . "失败，数据库录入失败",4);
                        $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
                    }
                }
                break;
            case "del":
                //查找删除的id是否有子级
                $res = $manageDepartmentModel->where("parent_id=$getId")->count();
                if ($res) {
                    $returnArr = array("result" => 0, "msg" => "要删除的菜单中含有子项目,请先移动或删除子项目", "code" => 402, "data" => null);
                } else {
                    $logData = $manageDepartmentModel->where("id=$getId")->find();
                    $result = $manageDepartmentModel->where("id=$getId")->delete();
                    if ($result) {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(6, "删除组织机构" . $logData["name"] . "成功",5);
                        $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);
                    } else {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(6, "删除组织机构" . $logData["name"] . "失败，数据库删除失败",5);
                        $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
                    }
                }
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法");
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }

    /*
     * 工作组- 入口函数
     * page_list，page_add，page_edit 编辑页面显示
     * add，edit,del，编辑动作
     */
    public function group()
    {
        $action = $_GET["action"];
        //$getId = $_GET["id"];
        //$manageDepartmentModel = M("ManageGroup");
        switch ($action) {
            case "page_list":
                $this->display("group_list");
                break;
            case "page_add":
                $this->display("group_info");
                break;
            case "page_edit":
                $this->display("group_info");
                break;
            case "add":

                break;
            case "edit":

                break;
            case "del":

                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法");
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }

    /**
     * @param array $data 要添加的机构的数据
     * @return bool|mixed 返回是否添加成功
     * 添加机构函数
     */
    private function addDepartment($data)
    {
        $manageDepartmentModel = M("ManageDepartment");
        //判断添加的组织机构是否有上级
        $parent_id = isset($data["parent_id"]) ? $data["parent_id"] : 0;
        //没有上级，则默认为顶级，并赋值创建时间与创建人。
        if (empty($parent_id)) {
            $data["level"] = 1;
            $data["parent_id_path"] = "_0_";
            $data["create_user_id"] = $_SESSION["admin_id"];
            $data["create_time"] = date("Y-m-d H:i:s", time());

        } else {
            //有上级，则附属到上级去。
            $info = $manageDepartmentModel->where("id=$parent_id")->find();
            $data["create_user_id"] = $_SESSION["admin_id"];
            $data["create_time"] = date("Y-m-d H:i:s", time());
            $data["level"] = count(explode("_", $info["parent_id_path"])) - 1;
            $data["parent_id_path"] = $info["parent_id_path"] . $info["id"] . "_";
        }
        $info = $manageDepartmentModel->add($data);
        return $info;
    }

    /**
     * @param array $data 要编辑的机构的数据
     * @return bool 返回是否编辑成功
     * 编辑机构函数
     */
    private function editDepartment($data)
    {
        $manageDepartmentModel = M("ManageDepartment");
        $parent_id = isset($data["parent_id"]) ? $data["parent_id"] : 0;
        //没有上级，则默认为顶级，并赋值创建时间与创建人。
        if (empty($parent_id)) {
            $data["level"] = 1;
            $data["parent_id_path"] = "_0_";
            $data["update_user_id"] = $_SESSION["admin_id"];
            $data["update_time"] = date("Y-m-d H:i:s", time());
        } else {
            $info = $manageDepartmentModel->where("id=$parent_id")->find();
            $data["update_user_id"] = $_SESSION["admin_id"];
            $data["update_time"] = date("Y-m-d H:i:s", time());
            $data["level"] = count(explode("_", $info["parent_id_path"])) - 1;
            $data["parent_id_path"] = $info["parent_id_path"] . $info["id"] . "_";
        }
        $info = $manageDepartmentModel->where("id={$data['id']}")->save($data);
        return $info;
    }

    /**
     * 角色权限添加
     * @param array $data
     */
    private function addRoleValue($data = array())
    {
        $manageAdminRole = M('ManageAdminRole');
        $manageAdminRoleValue = M('ManageAdminRoleValue');
        $info = $manageAdminRole->add($data);
        $json = $data['roleAction'];
        $i=0;
        foreach ($json as $key=>$value0){

            foreach($value0 as $key2=>$value2){
                $roleValArr[$i]['role_id']=$info;
                $roleValArr[$i]['module_id']=$key;
                $roleValArr[$i]['action_type']=$key2;
                $i++;
            }
        }
        $manageAdminRoleValue->addAll($roleValArr);
        return $info;
    }
    /**
     * 角色权限编辑
     * @param array $data
     * @return bool
     */
    private function editRoleValue($data = array())
    {
        $manageAdminRole = M('ManageAdminRole');
        $manageAdminRoleValue = M('ManageAdminRoleValue');
        $systemModule = M('SystemModule');
        $post=I("post.");
        //删除原有的数据
        $manageAdminRoleValue->where(array("role_id"=>$post['id']))->delete();
        $manageAdminRole->save($data);

        $json = $data['roleAction'];
        $i=0;
        foreach ($json as $key=>$value0){
            foreach ($value0 as $key2=>$value2){
                $roleValArr[$i]['role_id']=$post['id'];
                $roleValArr[$i]['module_id']=$key;
                $roleValArr[$i]['action_type']=$key2;
                $i++;
            }
        }
        $info = $manageAdminRoleValue->addAll($roleValArr);
        return $info;
    }

    /**
     * 日志入口函数
     */
    public function log()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $postId = $_POST["id"];
        $getData = I("get.");
        $postData = I("post.");
        $model = M('SystemLog');

        switch ($action) {
            case "page_list":
                $keyword = trim(I('keyword'));
                $start1=I('post.start1');
                $start2=I('post.start2');

                $where['user_name'] = array('exp', "LIKE '%$keyword%'");
                if($start1!=''&&$start2!=''){
                    $start1 = strtotime($start1);
                    $start2=strtotime($start2);
                    $start1 = date('Y-m-d',$start1).' 00:00:00';
                    $start2 = date('Y-m-d',$start2).' 23:59:59';
                    $where['log_time'] = array('BETWEEN', "$start1,$start2");
                }
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据

                $page_now = I('get.page_now', 1);   //$page_now 第几页

                $list = $model->page($page_now, $page_num)->join('__MANAGE_USERS__ ON __MANAGE_USERS__.user_id=__SYSTEM_LOG__.admin_id')->where($where)->order('log_time DESC')->select();
                $count = $model->join('__MANAGE_USERS__ ON __MANAGE_USERS__.user_id =__SYSTEM_LOG__.admin_id')->count();          //$count    总共有多少条数据
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                $this->assign('page', $page);
                $this->assign('page_num', $page_num);
                $this->assign('page_now', $page_now);
                $this->assign('count', $count);
                $this->assign('list', $list);
                $this->display("log_list");
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法");
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }

        json_return($returnArr);
    }





    /*
     * 修改密码
     */
    public function admin_alter()
    {
        if($_GET['action'] && $_GET['action']=='edit'){
            $admin_id = session('admin_id');

            $Admin = M('ManageUsers');
            $postData=I("post.");

            $oldPw = encrypt($postData['password'] );

            $where['user_id'] = $admin_id;
            $pwd = $Admin->where($where)->field('password')->find();

            if($pwd['password'] != $oldPw){
                $returnArr = array("result" => 0, "msg" => "旧密码错误，请检查", "code" => 402, "data" => null);
                json_return($returnArr);
            }

            if(IS_POST){
                // dump($_POST);die;
                $new1= I('post.new_password');
                $new2=I('post.new_password2');
                if($new1==$new2){

                    $pw = encrypt($new1);
                    $admin_info = $Admin->where(array('user_id' => $admin_id))->setField('password', $pw);
                    if($admin_info === false){
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(5, "修改管理员密码失败，数据库录入失败",4);
                        $returnArr = array("result" => 0, "msg" => "系统繁忙，请联系管理员", "code" => 402, "data" => null);

                    }else {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(5, "修改管理员密码成功",4);
                        $returnArr = array("result" => 1, "msg" => "修改成功", "code" => 402, "data" => null);
                    }
                }
            }
            json_return($returnArr);
        }else{
            $this->display();
        }

    }

    /*
     * 修改管理员信息
     */
    public function admin_update()
    {
        $Admin = M('ManageUsers');
        $action = $_GET["action"];
        $admin_id = session('user_id');
        $admin_info = M('ManageUsers')->where(array('user_id' => $admin_id))->find();
        $post = I('post.');
        switch($action){
            case "page_list":
                $info = $Admin->where(array('admin_id' => $admin_id))->find();
                $this->info = $info;
                $this->display("admin_update");
                break;

            case "edit":
                if($post){
                    unset($post['__hash__']);
                    $data['nickname']=I('post.nickname');
                    $data['user_id']=I("post.id");
                    $data['email']=I("post.email");
                    $data['mobile']=I("post.phone");
                    $data['head_pic']=I("post.avatar");

                    $info=$Admin->save($data);
                    if($info){
                        $this->logRecord(6,"修改[".$post['user_name'],"]个人信息成功",4);
                        $returnArr=array("result"=>1,"msg"=>"修改成功","code"=>200,"data"=>null);
                    }else {
                        $this->logRecord(5,"修改".$post['user_name']."个人信息失败",4);
                        $returnArr=array("result"=>0,"msg"=>"修改失败","code"=>402,"data"=>null);
                    }
                }
                break;
//        case "edit":
//            if ($post) {
//                //提交了表单
//                $old_password = I("post .password");
//                if (empty($old_password)) {
//
//                    $data = $admin_info;
//                    $data['email'] = I('post.email');
//                    $data['mobile'] = I("post.mobile");
//                    $data['user_name'] = I("post.user_name");
//                    $data['head_pic'] = I("post.head_pic");
//
//                    $info = $Admin->where(array('user_id' => $admin_id))->save($data);
//                    if($info){
//                        $this->logRecord(6,"修改个人信息成功",2);
//                        $returnArr=array("result"=>1,"msg"=>"修改成功","code"=>200,"data"=>null);
//                    }else {
//                        $this->logRecord(5,"修改个人信息失败",2);
//                        $returnArr=array("result"=>0,"msg"=>"修改失败","code"=>402,"data"=>null);
//                    }
////                adminLog('修改个人信息');
////                $this->success('修改成功', U('Admin/Index/welcome.html'));
//                }
//
//            }
//            break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
                break;
        }
        json_return($returnArr);
    }
    /**
     * 管理员登陆
     */
    public function login()
    {
        //获取配置信息
        $login_leftlogo = M('Config')->where(array('name' => 'login_leftlogo'))->getField('value');
        $store_name = M('Config')->where(array('name' => 'store_name'))->getField('value');
        $record_no = M('Config')->where(array('name' => 'record_no'))->getField('value');
        $website = M('Config')->where(array('name' => 'website'))->getField('value');
        $wx_scanning = M('Config')->where(array('name' => 'wx_scanning'))->getField('value');
        $login_code = M('Config')->where(array('name' => 'login_code'))->getField('value');
        //$link = M('SystemFriendLink')->order('link_id desc')->select();
        $pid = M('AdPosition')->where("position_name = '后台登录界面广告位'")->getField('position_id');
        $adList = M('Ad')->where(array('pid' => $pid, 'enabled' => 1))->select();

        $this->assign('adList', $adList);
        $this->assign('login_leftlogo', $login_leftlogo);
        $this->assign('store_name', $store_name);
        $this->assign('website', $website);
        $this->assign('record_no', $record_no);
        $this->assign('wx_scanning', $wx_scanning);
        $this->assign('login_code', $login_code);
        //$this->assign('friend_link', $link[0]['link_url']);

        //接收提交上来的登录信息
        if (IS_POST) {
            $condition['user_name'] = I('post.username');
            $condition['password'] = I('post.password');

            //*******输入错误三次时，校验是否需要验证码*********
            if (session('account_time') >= 3 && $login_code == 1) {
                $verify = new Verify();
                if (!$verify->check(I('post.vertify'), "Admin / Login")) {
                    exit(json_encode(array('status' => 5, 'msg' => '验证码错误')));
                }
            }

            //*******下面是帐号登录的动作*********
            if (!empty($condition['user_name']) && !empty($condition['password'])) {
                $condition['password'] = encrypt($condition['password']);
                // $user_info = M('ManageAdmin')->join('__MANAGE_ADMIN_ROLE__ ON __MANAGE_ADMIN__.role_id=__MANAGE_ADMIN_ROLE__.role_id')->where($condition)->find();
                $user_info = M('ManageUsers')->where($condition)->find();
                if (empty($user_info)) {
                    exit(json_encode(array('status' => 3, 'msg' => '账号/密码输入有误!')));
                }
                if ($user_info['is_lock'] == 1) {
                    $this->logRecord(6, "用户登录后台失败，原因：账号被禁用，登录账号为：" . $user_info['user_name'],0);
                    exit(json_encode(array('status' => 0, 'msg' => '账号被禁用，请联系管理员!')));
                }
                if (is_array($user_info)) {
                    //用户信息设置缓存
                    session('admin_id', $user_info['user_id']);
                    session('admin_name', $user_info['nickname']);
                    session('admin_user_name', $user_info['user_name']);
                    //获取所属角色
                    $roleRelation = M('ManageAdminRoleRelation')
                        ->field("role_id")
                        ->where('user_id = ' . $user_info['user_id'])->select();
                    session('role_id', $roleRelation);  //一个用户可对应多个角色，role_id为数组
                    $ifSuperAdmin = 0 ; // 0为否，1为是
                    //设置角色缓存
                    foreach ($roleRelation as $value) {
                        if($value['role_id'] == 1) {
                            $ifSuperAdmin = 1;
                        }

                        $roleList[] = M('ManageAdminRoleValue')
                            ->field("module_id")
                            ->where("role_id = ".$value['role_id'])
                            ->select();
                    }
                    foreach ($roleList as $value) {
                        foreach ($value as $value1) {
                            $role[] = $value1['module_id'];
                        }
                    }
                    $role = array_unique($role);
                    $roleStr = implode(',',$role);
                    if ($ifSuperAdmin == 1) {
                        session('act_list', 'all');
                    } else {
                        session('act_list', $roleStr);
                    }

                    /* $role = M('ManageAdminRole')->where('role_id = ' . $roleRelation['role_id'])->find();
                     session('act_list', $role['act_list']);*/

                    //将每一次登录记录下来
                    $recordData['create_time'] = date("Y-m-d H:i:s", time());
                    $recordData['user_id'] = $user_info['user_id'];
                    $recordData['user_ip'] = getIP();
                    M("ManageUserRecord") -> add($recordData);

                    //记录最近一次登陆的时间和登录次数
                    $loginNum = M('ManageUsers')->where("user_id = " . $user_info['user_id'])->getField("log_number");
                    $lastTimeData = array(
                        'last_login' => date("Y-m-d H:i:s",time()),
                        'last_ip' => getIP(),
                        'log_number' => $loginNum+1,
                    );
                    M('ManageUsers')->where("user_id = " . $user_info['user_id'])->save($lastTimeData);
                    $last_login_time = M('SystemLog')->where("admin_id = " . $user_info['user_id'] . " and operate_type = 0")->order('log_id desc')->limit(1)->getField('log_time');
                    session('last_login_time', $last_login_time);
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "用户登录后台成功，用户账号为：" . $user_info['user_name'],0);
                    $url = session('from_url') ? session('from_url') : U('Admin/Index/index');
                    exit(json_encode(array('status' => 1, 'url' => $url)));
                } else {
                    $ip = getIP();
                    if (session('?admin_ip')) {
                        if ($ip == session('admin_ip')) {
                            session('account_time', session('account_time') + 1);
                            if (session('account_time') > 2) {
//                                $this->assign('account_time',session('account_time'));
                                exit(json_encode(array('status' => 3, 'msg' => '账号/密码输入有误!')));
                            }
                        }
                    } else {
                        session('admin_ip', $ip);
                        session('account_time', 1);
                    }
                    exit(json_encode(array('status' => 3, 'msg' => '账号/密码输入有误!')));
                }
            } else {
                exit(json_encode(array('status' => 4, 'msg' => '网络繁忙，请重试!')));
            }
        }
        if (session('?admin_id') && session('admin_id') > 0) {
            $this->error("您已登录", U('Admin/Index/index'));
        }
        $this->display("/Public/login");
    }

    /**
     * 退出登陆
     */
    public function logout()
    {
        $this->logRecord(6, "用户退出后台成功,用户账号：" .  session('admin_user_name'),0);
        session_unset();
        session_destroy();
        $this->success("退出成功", U('Admin/Admin/login'));
    }

    /**
     * 验证码获取
     */
    public function vertify()
    {
        $config = array(
            'fontSize' => 30,
            'length' => 4,
            'useCurve' => true,
            'useNoise' => false,
        );
        $Verify = new Verify($config);
        $Verify->entry("Admin / Login");
    }

    /**
     * 递归无限级分类【先序遍历算】，获取任意该节点下所有的孩子
     * @param array $data 待排序的数组
     * @param int $parent_id 父级节点
     * @param int $level 层级数
     * @return array $arrTree 排序后的数组
     */
    private function getTreeSon($data, $parent_id = 0, $level = 0)
    {
        static $arr = array(); //使用static代替global
        if (empty($data)) return false;
        $level++;
        foreach ($data as $item => $value) {
            if ($value['parent_id'] == $parent_id) {
                $value['level'] = $level;
                $arr[] = $value;
                unset($data[$item]); //注销当前节点数据，减少已无用的遍历
                $this->getTreeSon($data, $value['id'], $level);
            }
        }
        return $arr;
    }
}
