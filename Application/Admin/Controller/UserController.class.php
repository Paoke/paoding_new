<?php

namespace Admin\Controller;

use Think\AjaxPage;
use Think\Page;
use Think\Log;

class UserController extends BaseController
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
        $checkAction = array('user');
        if(in_array($act,$checkAction) && in_array($action,$check)) {
            $res = parent::checkRole();
            if ($res["result"] != 1) {
                $this->error("您的账号没有操作权限");
            }
        }
    }

    public function user()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $postData = I("post.");
        switch ($action) {
            case "page_list":
                $model = M('ManageUsers');
                $keyword = trim(I('keyword'));
                if($keyword){
                    $where["nickname|user_name|email|mobile"]=array("exp","LIKE '%$keyword%'");
                }
                $count = $model->where($where)->count();
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页

                $userList = $model->where($where)->page($page_now, $page_num)->order('reg_time DESC')->select();
                $user_id_arr = get_arr_column($userList, 'user_id');

                if (!empty($user_id_arr)) {
                    $first_leader = M('ManageUsers')->query("select first_leader,count(1) as count  from __PREFIX__manage_users where first_leader in(" . implode(',', $user_id_arr) . ")  group by first_leader");
                    $first_leader = convert_arr_key($first_leader, 'first_leader');

                    $second_leader = M('ManageUsers')->query("select second_leader,count(1) as count  from __PREFIX__manage_users where second_leader in(" . implode(',', $user_id_arr) . ")  group by second_leader");
                    $second_leader = convert_arr_key($second_leader, 'second_leader');

                    $third_leader = M('ManageUsers')->query("select third_leader,count(1) as count  from __PREFIX__manage_users where third_leader in(" . implode(',', $user_id_arr) . ")  group by third_leader");
                    $third_leader = convert_arr_key($third_leader, 'third_leader');
                }
                $this->assign('page', $page);
                $this->assign('page_num', $page_num);
                $this->assign('page_now', $page_now);
                $this->assign('count', $count);

                $this->assign('first_leader', $first_leader);
                $this->assign('second_leader', $second_leader);
                $this->assign('third_leader', $third_leader);
                $this->assign('userList', $userList);
                $this->display("user_list");
                break;
            case "page_edit":
                $user = D('ManageUsers')->where(array('user_id' => $getId))->find();
                $this->assign('user', $user);
                $this->display("user_info");
                break;
            case "add":
                $postData["reg_time"] = date("Y-m-d H:i:s", time());
                    //校验用户名
                    if( $postData['user_name']==""){
                        $returnArr = array("result" => 0, "msg" => "用户名不能为空", "code" => 402);
                        break;
                    }
                    //校验密码
                    if( $postData['password']==""){
                        $returnArr = array("result" => 0, "msg" => "密码不能为空", "code" => 402);
                        break;
                    }
                    if( $postData['password2']==""){
                        $returnArr = array("result" => 0, "msg" => "确认密码不能为空", "code" => 402);
                        break;
                    }
                    if( strlen($postData['password'])<6||strlen($postData['password'])>15) {
                        $returnArr = array("result" => 0, "msg" => "密码长度不正确", "code" => 402);
                        break;
                    }
                    if( strlen($postData['password2'])<6||strlen($postData['password2'])>15){
                        $returnArr = array("result" => 0, "msg" => "确认密码长度不正确", "code" => 402);
                        break;
                    }
                    if( $postData['password'] != $postData['password2']){
                        $returnArr = array("result" => 0, "msg" => "两次密码不正确", "code" => 402);
                        break;
                    }
                     //校验用户名
                     $where=array("user_name = '" . $postData['user_name'] . "'");
                     if(M("ManageUsers")->where($where)->count()){
                          $returnArr = array("result" => 0, "msg" => "用户名已存在！不能重复", "code" => 402, "data" => null);
                         break;
                     };
                    //密码加密
                    $postData['password'] = encrypt($postData['password']);
                    $res = M('ManageUsers')->add($postData);
                    if ($res ) {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(5, "账户" . $postData["nickname"] . "修改密码成功");
                        $returnArr = array("result" => 1, "msg" => "添加成功", "code" => 200);
                    } else {
                        $returnArr = array("result" => 0, "msg" => "添加失败", "code" => 402);
                    }
                //}
                break;
            case "edit":
                //校验密码
                if( $postData['password']!=""||$postData['password2']!=""){
                    if($postData['password']=="" ){
                        $returnArr = array("result" => 0, "msg" => "密码不能为空", "code" => 402);
                        break;
                    }
                    if( strlen($postData['password'])<6||strlen($postData['password'])>15) {
                        $returnArr = array("result" => 0, "msg" => "密码长度不正确", "code" => 402);
                        break;
                    }
                    //密码加密
                    $postData['password'] = encrypt($postData['password']);
                }else{
                    $userModel=M("ManageUsers")->where("user_id = ". $getId)->find();
                    if($userModel){
                        $postData['password']=$userModel['password'];
                    }else{
                        $returnArr = array("result" => 0, "msg" => "该用户不存在", "code" => 402);
                        break;
                    }
                }

                $info = M("ManageUsers")->where("user_id = ".$getId)->save($postData);
                if($info === false){
                    $this->logRecord(5,"修改用户【".$postData['nickname']."】失败");
                    $returnArr=array("result"=>0,"msg"=>"修改失败","code"=>402);
                }else {
                    $this->logRecord(6,"修改用户【".$postData['nickname']."】成功");
                    $returnArr=array("result"=>1,"msg"=>"修改成功","code"=>200);
                }
                break;
            //会员详细信息查看
//            case "edit":
//                if ($postId == '')
//                    $uid = $getId;
//                $user = D('ManageUsers')->where(array('user_id' => $uid))->find();
//                if (!$user)
//                $returnArr = array("result" => 0, "msg" => "会员不存在", "code" => 402);
//                if (IS_POST) {
//                    //  会员信息编辑
//                    $password = I('post.password');
//                    $password2 = I('post.password2');
//
//                    if (encrypt(I('post.password')) == $user['password']) {
//                        $returnArr = array("result" => 0, "msg" => "新密码和旧密码相同", "code" => 402);
//                    }
//                    if ($password == '' && $password2 == '') {
//                        unset($_POST['password']);
//                    } else {
//                        $_POST['password'] = encrypt($_POST['password']);
//                    }
////                    $returnArr = array("result" => 0, "msg" => "该昵称已存在！不能重复", "code" => 402, "data" => null);
////                    $where=array("nickname = '" . $_POST['nickname'] . "'");
////                    if(M("ManageUsers")->where($where)->count()){
////                        json_return($returnArr);
////                    };
//                    $row = M('ManageUsers')->where(array('user_id' => $uid))->save($_POST);
//                    if ($row !== false) {
//                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
//                        $this->logRecord(6, "账户" . $user["mobile"] . "修改密码成功");
//                        $returnArr = array("result" => 1, "msg" => "修改成功", "code" => 200);
//                    } else {
//                        $returnArr = array("result" => 0, "msg" => "修改失败", "code" => 402);
//                    }
//                }
//                $user['first_lower'] = M('ManageUsers')->where("first_leader = {$user['user_id']}")->count();
//                $user['second_lower'] = M('ManageUsers')->where("second_leader = {$user['user_id']}")->count();
//                $user['third_lower'] = M('ManageUsers')->where("third_leader = {$user['user_id']}")->count();
//                break;
            //删除会员
            case "del":
                $logData = M("ManageUsers")->field("user_name")->where("user_id=$getId")->find();
                $row = M('ManageUsers')->where(array('user_id' => $getId))->delete();
                if ($row) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "删除用户" . $logData["user_name"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);
                    //$this->success('成功删除会员');die;
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5, "删除用户" . $logData["user_name"] . "失败");
                    $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
                    //$this->error('操作失败');die;
                }
                break;
            //用户收货地址查看
            case "address":
                $lists = D('ManageUserAddress')->where(array('user_id' => $getId))->select();
                foreach ($lists as $key1 => $value1) {
                    foreach ($value1 as $key => $value) {
                        $lists[$key1]['province'] = M('SystemRegion')->where(array('id' => $value1['province']))->getField('name');
                        $lists[$key1]['city'] = M('SystemRegion')->where(array('id' => $value1['city']))->getField('name');
                        $lists[$key1]['district'] = M('SystemRegion')->where(array('id' => $value1['district']))->getField('name');
                        $lists[$key1]['twon'] = M('SystemRegion')->where(array('id' => $value1['twon']))->getField('name');
                    }
                }
                $this->assign('lists', $lists);
                $this->display("address_list");
                break;
            //用户收货地址修改
            case "address_add":
                $act = I('post.act', null);
                if (!empty($act)) {

                    $address['consignee'] = I('post.consignee');
                    $address['mobile'] = I('post.mobile');
                    $address['zipcode'] = I('post.zipcode');
                    $address['address'] = I('post.address');

                    $address['province'] = I('post.province');
                    $address['city'] = I('post.city');
                    $address['district'] = I('post.district');

                    $address_id = I('post.address_id');
                    $user_id = I('post.user_id');
                    $logData = M("ManageUsers")->field("user_name")->where("id=$getId")->find();
                    $addr = D('ManageUserAddress')->where("address_id = $address_id AND user_id = $user_id")->data($address)->save();
                    if ($addr) {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(5, "账户" . $logData["user_name"] . "收货地址添加成功");
                        $this->success('修改成功', U('Admin/User/address', array('id' => $user_id, 'address_id' => $address_id)));
                    } else {
                        $this->success('没有任何数据被修改', U('Admin/User/address', array('id' => $user_id, 'address_id' => $address_id)));
                    }

                } else {
                    $uid = I('get.id');
                    $address_id = I('get.address_id');
                    $lists = D('ManageUserAddress')->where("address_id = $address_id AND user_id = $uid")->select();
                    // 获取省份
                    $province = M('SystemRegion')->where(array('parent_id' => 0, 'level' => 1))->select();
                    //获取城市
                    $city = M('SystemRegion')->where(array('parent_id' => $lists[0]['province'], 'level' => 2))->select();
                    //获取地区
                    $area = M('SystemRegion')->where(array('parent_id' => $lists[0]['city'], 'level' => 3))->select();

                    $this->assign('province', $province);
                    $this->assign('city', $city);
                    $this->assign('area', $area);

                    $this->assign('lists', $lists);
                    $this->assign('user_id', $lists[0]['user_id']);
//            $this->assign('regionList',$regionList);
                    $this->display();
                }
                break;
            //账户资金记录
            case "account_log":
                $user_id = I('get.id');
                //获取类型
                $type = I('get.type');
                //获取记录总数
                $count = M('FundAccountLog')->where(array('user_id' => $user_id))->count();
                $page = new Page($count);
                $lists = M('FundAccountLog')->where(array('user_id' => $user_id))->order('change_time desc')->limit($page->firstRow . ',' . $page->listRows)->select();

                $this->assign('user_id', $user_id);
                $this->assign('page', $page->show());
                $this->assign('lists', $lists);
                $this->display("account_log");
                break;
            //账户资金调节
            case "account_edit":
                $user_id = I('get.id');
                $logData = M("ManageUsers")->field("user_name")->where("id=$user_id")->find();
                if (!$user_id > 0)
                    $this->error("参数有误");
                if (IS_POST) {
                    //获取操作类型
                    $m_op_type = I('post.money_act_type');
                    $user_money = I('post.user_money');
                    $user_money = $m_op_type ? $user_money : 0 - $user_money;

                    $p_op_type = I('post.point_act_type');
                    $pay_points = I('post.pay_points');
                    $pay_points = $p_op_type ? $pay_points : 0 - $pay_points;

                    $f_op_type = I('post.frozen_act_type');
                    $frozen_money = I('post.frozen_money');
                    $frozen_money = $f_op_type ? $frozen_money : 0 - $frozen_money;

                    $desc = I('post.desc');
                    if (!$desc)
                        $this->error("请填写操作说明");
                    if (accountLog($user_id, $user_money, $pay_points, $desc)) {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(6, "账户" . $logData["user_name"] . "资金调节成功");
                        $this->success("操作成功", U("Admin/User/userList/action/account_log", array('id' => $user_id)));
                    } else {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(5, "账户" . $logData["user_name"] . "资金调节失败");
                        $this->error("操作失败");
                    }
                    exit;
                }
                $this->assign('user_id', $user_id);
                $this->display("account_edit");
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法");
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }

    /*
 * 用户级别管理操作方法
 */
    public function level()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $postId = $_POST["id"];
        $getData = I("get.");
        $postData = I("post.");
        switch ($action) {
            case "page_list":
                $model = M('ManageUserLevel');
                $count = $model->count();          //$count    总共有多少条数据
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                $res = $model->page($page_now, $page_num)->order("level_id")->select();
                if ($res) {
                    foreach ($res as $val) {
                        $list[] = $val;
                    }
                }
                $this->assign('page', $page);
                $this->assign('page_num', $page_num);
                $this->assign('page_now', $page_now);
                $this->assign('count', $count);
                $this->assign('list', $list);
                $this->display("level_list");
                break;
            case "page_add":
                $this->display('level_info');
                break;
            case "page_edit":
                if ($getId) {
                    $level_info = D('ManageUserLevel')->where('level_id=' . $getId)->find();
                    $this->assign('info', $level_info);
                }
                $this->display('level_info');
                break;
            case "add":
                $r = D('ManageUserLevel')->add($postData);
                if ($r) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加用户等级" . $postData["level_name"] . "成功");
                    $this->success("操作成功", U('Admin/User/levelList/action/page_list'));
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5, "添加用户等级" . $postData["level_name"] . "失败");
                    $this->error("操作失败", U('Admin/User/levelList/action/page_add'));
                }
                break;
            case "edit":
                $r = D('ManageUserLevel')->where('level_id=' . $postData['level_id'])->save($data);
                if ($r) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "编辑用户等级" . $postData["level_name"] . "成功");
                    $this->success("操作成功", U('Admin/User/levelList/action/page_list'));
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5, "编辑用户等级" . $postData["level_name"] . "失败");
                    $this->error("操作失败", U('Admin/User/levelList/action/page_add'));
                }
                break;
            case "del":
                $logData = $r = D('ManageUserLevel')->where('level_id=' . $postData['level_id'])->find();
                $r = D('ManageUserLevel')->where('level_id=' . $postData['level_id'])->delete();
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(6, "删除用户等级" . $logData["level_name"] . "成功");
                if ($r) exit(json_encode(1));
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法");
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }
/*
 * 用户级别记录操作方法
 */
    public function levelVerify()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $postId = $_POST["id"];
        $getData = I("get.");
        $postData = I("post.");

        switch ($action) {
            case "page_list":
               break;
            case "page_add":
                break;
            case "page_edit":
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

    /*
 * 用户认证级别操作方法
 */
    public function identity()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $postId = $_POST["id"];
        $getData = I("get.");
        $postData = I("post.");

        switch ($action) {
            case "page_list"://展示数据列表
                break;
            case "page_add"://展示新增表单页面
                break;
            case "page_edit"://展示修改表单界面
                break;
            case "add"://新增保存动作
                break;
            case "edit"://修改保存动作
                break;
            case "del"://删除动作
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法");
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }
    /*
     * 用户认证级别记录操作方法
     */
    public function identityVerify()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $postId = $_POST["id"];
        $getData = I("get.");
        $postData = I("post.");
        $tables = "ManageUserAuthen";
        switch ($action) {
            case "page_list":
                if($_GET['tab']){
                    $this->assign('tab', $_GET['tab']);
                }
                $this->display("verify_list");
                break;
            case "page_info":
                $get = I("get.");
                $where['A.id']=$get['id'];
                $Authen=M("ManageUserAuthen")
                        ->join("AS A LEFT JOIN __MANAGE_USERS__ AS B ON A.user_id=B.user_id")
                        ->field("A.*,B.user_name,B.nickname,B.email,B.mobile,B.province,B.city")
                        ->where($where)->find();
                $this->assign('Authen',$Authen);
                $this->assign("id",$_GET['id']);
                $this->assign('tab', $_GET['tab']);
                $this->display("verify_info");
                break;
            case "audit":
                $data = $this->getArticleByStatus(1, $tables);
                if($data)  {
                    $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $data);
                } else {
                    $returnArr = array("result" => 0, "msg" => "获取数据失败", "code" => 402, "data" => null);
                }
                break;
            case "list":
                $data = $this->getArticleByStatus(false, $tables);
                if($data)  {
                    $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $data);
                } else {
                    $returnArr = array("result" => 0, "msg" => "获取数据失败", "code" => 402, "data" => null);
                }
                break;
            case "info":
                $data = $this->getArticleByStatus(0, $tables);
                if($data)  {
                    $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $data);
                } else {
                    $returnArr = array("result" => 0, "msg" => "获取数据失败", "code" => 402, "data" => null);
                }
                break;
            case "issue":
                $data = $this->getArticleByStatus(-1, $tables);
                if($data)  {
                    $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $data);
                } else {
                    $returnArr = array("result" => 0, "msg" => "获取数据失败", "code" => 402, "data" => null);
                }
                break;

            case "update_status":
                    $id = $_POST['id'];
                    $status = $_POST['status'];

                    if ($id) {
                        $tableName = $tables;
                        $article = M("$tableName")->where('id='.$id)->find();
                        $flag = M("$tableName")->where('id='.$id)->setField('status', $status);
                        if($flag === false){
                            $this->logRecord(5, "审核【".$article["company_code"]."】失败", 6, -2, $id);
                            $returnArr = array("result" => 0, "msg" => "审核失败，请重试", "code" => 405, "data" => null);
                        }else if($status==0){
                            $this->logRecord(6, "审核【".$article["company_code"]."】通过!", 6, -2, $id);
                            $returnArr = array("result" => 1, "msg" => "审核成功", "code" => 200, "data" => null);
                        }else if($status==-1){
                            $this->logRecord(6, "审核【".$article["company_code"]."】不通过!", 6, -2, $id);
                            $returnArr = array("result" => 1, "msg" => "审核成功", "code" => 200, "data" => null);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "审核失败，缺少参数", "code" => 402, "data" => null);
                    }
                break;

            case "record":

                $where['channel_id'] = -2; //-2表示用户认证的审核
                $where['operate_type'] = 6;
                $page_num = I('post.page_num', 25); // ? I('get.page_num') : I('post.page_num', 10);   //$page_num 每页几条数据
                $page_now = I('post.page_now', 1);   //$page_now 第几页
                $count=M("SystemLog")->where($where)->count();
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page  总共有几页
                $record = M("SystemLog")->where($where)
                    ->page($page_now,$page_num)
                    ->field("log_info,log_time,admin_user_name,operate_type")
                    ->order('log_time desc')->select();
                $arr['page_now']=$page_now;
                $arr['page']=$page;
                if($record)  {
                    $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $record,"arr"=>$arr);
                } else {
                    $returnArr = array("result" => 0, "msg" => "该频道不存在", "code" => 402, "data" => null);
                }
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法");
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }

    public function download(){

        $file = $_POST['image'];
        $file = substr($file,1);
        if(is_file($file)){
            $length = filesize($file);
            $type = mime_content_type($file);
            $showname =  ltrim(strrchr($file,'/'),'/');
            header("Content-Description: File Transfer");
            header('Content-type: ' . $type);
            header('Content-Length:' . $length);
            header('content-length:'. filesize($file));
            if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) { //for IE
               header('Content-Disposition: attachment; filename="' . rawurlencode($showname) . '"');
            } else {
                header('Content-Disposition: attachment; filename="' . $showname . '"');
            }
            /*header('content-disposition:attachment;filename='. basename($file));
            header('content-length:'. filesize($file));*/
            readfile($file);
            exit;
        } else {
            exit('文件已被删除！');
        }
    }

    public function attachments(){
        $file=$_POST['file'];
        $file = substr($file,1);
        if(is_file($file)){
            $length = filesize($file);
            $type = mime_content_type($file);
            $showname =  ltrim(strrchr($file,'/'),'/');
            header("Content-Description: File Transfer");
            header('Content-type: ' . $type);
            header('Content-Length:' . $length);
            if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) { //for IE
                header('Content-Disposition: attachment; filename="' . rawurlencode($showname) . '"');
            } else {
                header('Content-Disposition: attachment; filename="' . $showname . '"');
            }
            readfile($file);
            exit;
        } else {
            exit('文件已被删除！');
        }
    }

    public function patent(){
        $file=$_POST['files'];
        $file = substr($file,1);
        if(is_file($file)){
            $length = filesize($file);
            $type = mime_content_type($file);
            $showname =  ltrim(strrchr($file,'/'),'/');
            header("Content-Description: File Transfer");
            header('Content-type: ' . $type);
            header('Content-Length:' . $length);
            if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) { //for IE
                header('Content-Disposition: attachment; filename="' . rawurlencode($showname) . '"');
            } else {
                header('Content-Disposition: attachment; filename="' . $showname . '"');
            }
            readfile($file);
            exit;
        } else {
            exit('文件已被删除！');
        }
    }
    //用户认证审核的数据获取和改变
    private function getArticleByStatus($status, $table){

        if($status !== false){
            $where['status'] = $status;
        }

        $page_num = I('post.page_num', 8); // ? I('get.page_num') : I('post.page_num', 10);   //$page_num 每页几条数据
        $page_now = I('post.page_now', 1);   //$page_now 第几页
        $count = M("$table")->where($where)->count();
        $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page  总共有几页

        $info = M("$table")->where($where)->page($page_now,$page_num)->field("id,type,company_code,tech_field,company_pic,status,company_name")->select();
        $arr['page_now'] = $page_now;
        $arr['page'] = $page;
        $arr['count'] = $count;

        $data['data'] = $info;
        $data['arr'] = $arr;

        return $data;
    }
    



    /**
     * 意见反馈
     */
    public function feedback()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $postId = $_POST["id"];
        $getData = I("get.");
        $postData = I("post.");
        switch ($action) {
            case "page_list":
                $nickname = I('post.nickname', null);
                $content = I('post.content', null);
                $msg_status = I('post.msg_status_top', 9);
                if ($msg_status != 9) {
                    $where['msg_status'] = $msg_status;
                    $where['is_admin'] = 0;
                } else $where = array('is_admin' => 0);

                $model = M('SystemFeedback');
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页


                if ($nickname == null && $content == null) {
                    $feedback_list = $model->page($page_now, $page_num)->order('msg_time DESC')->where($where)->select(); //只查前20条
                    $count = $model->where($where)->count();          //$count    总共有多少条数据
                } else if ($nickname == null && $content != null) {
                    $where['msg_content'] = array('like', "%" . $content . "%");
                    $feedback_list = $model->page($page_now, $page_num)->where($where)->order('msg_time DESC')->select();
                    $count = $model->where($where)->count();          //$count    总共有多少条数据
                } else if ($nickname != null && $content == null) {
                    $where['user_name'] = array('like', "%" . $nickname . "%");
                    $feedback_list = $model->page($page_now, $page_num)->where($where)->order('msg_time DESC')->select();
                    $count = $model->where($where)->count();          //$count    总共有多少条数据
                } else if ($nickname != null && $content != null) {
                    $where['user_name'] = array('like', "%" . $nickname . "%");
                    $where['msg_content'] = array('like', "%" . $content . "%");
                    $feedback_list = $model->page($page_now, $page_num)->where($where)->order('msg_time DESC')->select();
                    $count = $model->where($where)->count();          //$count    总共有多少条数据

                }
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页

                $msg_type = array(1 => '产品建议', 2 => '程序错误', 3 => '其他');
                $msg_status = array(0 => '未处理', 1 => '已处理');

                $this->assign('page', $page);
                $this->assign('page_num', $page_num);
                $this->assign('page_now', $page_now);
                $this->assign('count', $count);
                $mod_id = get_mod_id('Comment', 'reply_feedback');
                $this->assign('mod_id', $mod_id);
                $this->assign('msg_type', $msg_type);
                $this->assign('msg_status', $msg_status);
                $this->assign('msg_status_top', $where['msg_status']);
                $this->assign('feedback_list', $feedback_list);
                $this->display("feedback_list");
                break;
            case "page_edit":
                $res = M('SystemFeedback')->where(array('msg_id' => $getId))->find();
                M('SystemFeedback')->where(array('msg_id' => $getId))->setField('msg_status', 1);
                $head_pic = M('ManageUsers')->where(array('username' => $res['username']))->getField('head_pic');

                if (!$res) {
                    exit($this->error('不存在该意见反馈'));
                }
                $reply = M('SystemFeedback')->where(array('parent_id' => $getId))->select(); // 评论回复列表
                $this->assign('feedback', $res);
                $this->assign('head_pic', $head_pic);
                $this->assign('reply', $reply);
                $this->display("feedback_info");
                break;
            case "edit":
                $res = M('SystemFeedback')->where(array('msg_id' => $postId))->find();
                M('SystemFeedback')->where(array('msg_id' => $postId))->setField('msg_status', 1);
                $head_pic = M('ManageUsers')->where(array('username' => $res['username']))->getField('head_pic');
                if (!$res) {
                    exit($this->error('不存在该意见反馈'));
                }
                if (IS_POST) {
                    $add['parent_id'] = $postId;
                    $add['is_admin'] = 1;
                    $add['msg_content'] = I('post.msg_content');
                    $add['msg_time'] = time();
                    $add['ip_address'] = getIP();
                    $add['msg_status'] = 1;
                    $admin_info = getUserInfo(session('admin_id'));
                    $admin_role = M('ManageAdminRole')->where(array('role_id' => $admin_info['role_id']))->find();
                    $add['user_name'] = $admin_info['name'] . ' [' . $admin_role['role_name'] . ']';

                    $row = M('SystemFeedback')->add($add);
                    if ($row) {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(6, "回复意见反馈" . $add["msg_title"] . "成功",3);
                        $this->success("回复成功", U('Comment/feedback_detail', array('id' => $postId)));
                    } else {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(6, "回复意见反馈" . $add["msg_title"] . "失败，数据库录入失败",3);
                        $this->error('回复失败');
                    }
                    exit;

                }
                $reply = M('SystemFeedback')->where(array('parent_id' => $postId))->select(); // 评论回复列表

                $this->assign('feedback', $res);
                $this->assign('head_pic', $head_pic);
                $this->assign('reply', $reply);
                $this->display("feedback_info");
                break;
            case "del":
                $logData = M('SystemFeedback')->where(array('msg_id' => $getId))->find();
                $row = M('SystemFeedback')->where(array('msg_id' => $getId))->delete();
                if ($row) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "删除意见反馈" . $logData["msg_title"] . "成功",5);
                    $this->success('删除成功');
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5, "删除意见反馈" . $logData["msg_title"] . "失败，数据库删除失败",5);
                    $this->error('删除失败');
                }
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }

    /**
     * 发送消息
     */
    public function message()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $postId = $_POST["id"];
        $getData = I("get.");
        $postData = I("post.");
        switch ($action) {
            case "page_list":
                $model = D('ManageUserMessage');
                $sort_order = 'id ASC';
                $count = $model->count();
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                $UMmodel = D('ManageUserMessage');
                $result=$UMmodel->alias('a')->field("a.*,b.user_name,c.nickname,d.user_name as accept_user_name,e.nickname as accept_nickname")->join('__MANAGE_USERS__ b on b.user_id=a.post_user_id','LEFT')->join('__MANAGE_USERS__ c on c.user_id=a.post_user_id','LEFT')->join('__MANAGE_USERS__ d on d.user_id=a.accept_user_id','LEFT')->join('__MANAGE_USERS__ e on e.user_id=a.accept_user_id','LEFT')->page($page_now, $page_num)->order($sort_order)->select();
                $messageList = string_str($result, 'content', 'contentall', 20);
                $this->assign('page', $page);
                $this->assign('page_num', $page_num);
                $this->assign('page_now', $page_now);
                $this->assign('count', $count);
                $this->assign('messageList', $messageList);
                $this->display("message_list");
                break;
            case "page_add":
                $this->display("message_info");
                break;
            case "add":
                if ($postData) {
                    $data['accept_user_id'] = I('post.user_id');
                    $data['content'] = I('post.content');
                    $data['post_user_id'] = session('admin_id');
                    $data['type'] = '0';
                    $data['is_sys'] = '1';
                    $data['post_time'] = date("Y-m-d H:i:s", time());
                    $r = M('ManageUserMessage')->add($data);
                    if ($r) {
                        $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                    } else {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(6, "添加消息失败，数据库录入失败",3);
                        $returnArr = array("result" => 0, "msg" => "保存失败", "code" => 402, "data" => null);
                    }
                } else {
                    $returnArr = array("result" => 0, "msg" => "保存失败，内容不能为空", "code" => 402, "data" => null);
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
     * 会员列表
     */
    public function ajaxindex()
    {
        // 搜索条件
        $condition = array();
        I('POST.mobile') ? $condition['mobile'] = I('POST.mobile') : false;
        I('POST.email') ? $condition['email'] = I('POST.email') : false;
        $sort_order = I('order_by', 'user_id') . ' ' . I('sort', 'desc');

        $model = M('ManageUsers');
        $count = $model->where($condition)->count();
        $Page = new AjaxPage($count, 10);
        //  搜索条件下 分页赋值
        foreach ($condition as $key => $val) {
            $Page->parameter[$key] = urlencode($val);
        }

        $userList = $model->where($condition)->order($sort_order)->limit($Page->firstRow . ',' . $Page->listRows)->select();

        $user_id_arr = get_arr_column($userList, 'user_id');
        if (!empty($user_id_arr)) {
            $first_leader = M('ManageUsers')->query("select first_leader,count(1) as count  from __PREFIX__manage_users where first_leader in(" . implode(',', $user_id_arr) . ")  group by first_leader");
            $first_leader = convert_arr_key($first_leader, 'first_leader');

            $second_leader = M('ManageUsers')->query("select second_leader,count(1) as count  from __PREFIX__manage_users where second_leader in(" . implode(',', $user_id_arr) . ")  group by second_leader");
            $second_leader = convert_arr_key($second_leader, 'second_leader');

            $third_leader = M('ManageUsers')->query("select third_leader,count(1) as count  from __PREFIX__manage_users where third_leader in(" . implode(',', $user_id_arr) . ")  group by third_leader");
            $third_leader = convert_arr_key($third_leader, 'third_leader');
        }
        $this->assign('first_leader', $first_leader);
        $this->assign('second_leader', $second_leader);
        $this->assign('third_leader', $third_leader);

        $show = $Page->show();
        $this->assign('userList', $userList);
        $this->assign('show', $show);// 赋值分页输出
        $this->display();
    }



    /**
     * 搜索用户名
     */
    public function search_user()
    {
        $search_key = trim(I('search_key'));
        if (strstr($search_key, '@')) {
            $list = M('ManageUsers')->where(" email like '%$search_key%' ")->select();
            foreach ($list as $key => $val) {
                echo "<option value='{$val['user_id']}'>{$val['email']}</option>";
            }
        } else {
            $list = M('ManageUsers')->where(" mobile like '%".$search_key."%' OR nickname like '%".$search_key."%' OR user_name like '%".$search_key."%'")->select();
            foreach ($list as $key => $val) {
                echo "<option value='{$val['user_id']}'>账号：{$val['user_name']}({$val['nickname']})</option>";
            }
        }
        exit;
    }

    /**
     * 分销树状关系
     */
    public function ajax_distribut_tree()
    {
        $list = M('ManageUsers')->where("first_leader = 1")->select();
        $this->display();
    }


}
