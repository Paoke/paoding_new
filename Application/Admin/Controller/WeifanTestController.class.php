<?php
/**
 * Created by PhpStorm.
 * User: Sing
 * Date: 2016/10/20
 * Time: 14:58
 */

namespace Admin\Controller;


use Think\Log;
use Think\Model;
//应用配置
class WeifanTestController extends BaseController
{
    /**
     * 析构函数，判断权限等
     */
    public function __construct()
    {
        parent::__construct();
       /* $res = parent::checkRole();
        if ($res["result"] != 1) {
            $this->error("您的账号没有操作权限");
        }*/
    }

    /**
     * 问卷管理
     */
    public function test()
    {
        $action = $_GET["action"];
        $DAO = M('TestWeifan');
        $channel = $_GET['channel'];
        $channelId = M("SystemChannel")->where("call_index = '$channel'") ->getField("id");
        $type = $_GET['type'];
        $activityId = $_GET['activity_id'];
        switch ($action) {

            case "page_list":
                $keyword = trim(I("keyword"));
                if($keyword){
                    $where['title']=array("exp","LIKE '%$keyword%'");
                }
                $where['is_deleted'] = 0;
                $where['activity_id'] = $activityId;
                $where['channel_id'] = $channelId;
                $data = $DAO->where($where)->select();

                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $count = $DAO->where($where)->count();          //$count    总共有多少条数据
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                $this->assign('count', $count);
                $this->assign('page', $page);
                $this->assign('activity_id', $activityId);
                $this->assign('channel', $channel);
                $this->assign('type', $type);
                $this->assign('page_num', $page_num);
                $this->assign('page_now', $page_now);
                $this->assign('data', $data);

                $this->display('test_list');
                break;

            case "page_add":

                $topic_list = M('TopicWeifan')->field('id,title,topic_img')->where('is_deleted=0')->select();
                $this->assign('topic_list', $topic_list);
                $this->assign('activity_id', $activityId);
                $this->assign('channel', $channel);
                $this->assign('type', $type);
                $this->display('test_info');
                break;

            case "page_edit":

                $id = $_GET['id'];
                if($id){
                    $info = $DAO->where('is_deleted=0 AND id='.$id)->find();
                    $this->assign('info', $info);

                    $sql = "SELECT A.`id`,A.`title`,A.`topic_img`,IFNULL(B.`test_order`, 0) `check`, B.`test_order` FROM `__TOPIC_WEIFAN__` A ".
                        " LEFT JOIN `__TEST_TOPICS_WEIFAN__` B ON A.`id`=B.`topic_id` AND B.`test_id`=".$id.
                        " WHERE A.`is_deleted`=0 ";

                    $topic_list = M()->query($sql);

                    $this->assign('topic_list', $topic_list);

                    //是否已经在使用
                    $count = M('TestStudentResultWeifan')->where('test_id='.$id)->count();

                    if($count > 0){
                        $this->assign('is_use', $count);
                    }

                }

                $this->display('test_info');
                break;

            case "add":
                $data = I('post.');

                unset($data['__hash__']);
                $data['activity_id'] = $activityId;
                $data['channel_id'] = $channelId;
                $state = $DAO->add($data);
                if($state){
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "增加用户" . $data["cat_name"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => $state);
                }else{
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "新增用户" . $data["cat_name"] . "失败");
                    $returnArr = array("result" => 0, "msg" => "保存失败", "code" => 404, "data" => null);
                }

                break;

            case "edit":

                $data = I('post.');

                $test = $DAO->where('is_deleted=0 AND id='.$data['id'])->find();
                $test['title'] = $data['title'];
                $test['desc'] = $data['desc'];
                $test['icon'] = $data['icon'];

                $state = $DAO->save($test);
                if($state){
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "修改测试" . $test["title"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "修改成功", "code" => 200, "data" => null);
                }else{
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "修改测试" . $test["title"] . "失败");
                    $returnArr = array("result" => 0, "msg" => "修改失败", "code" => 404, "data" => null);
                }

                break;

            case "del":
                $id = $_GET['id'];
                if($id){

                    $count = M('TestStudentResultWeifan')->where('test_id='.$id)->count();
                    if($count > 0){
                        $returnArr = array("result" => 0, "msg" => "删除失败，测试已经在使用，不能再删除!", "code" => 401, "data" => null);
                    }else{
                        $DAO->where('id='.$id)->setField('is_deleted', 1);
                        $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);

                    }
                }else{
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "删除测试[id=".$id."]失败");
                    $returnArr = array("result" => 0, "msg" => "删除失败", "code" => 404, "data" => null);
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
     * 问卷分类
     */
    public function category()
    {
        $action = $_GET["action"];
        //获取id，id是给编辑页面用的
        $getId = $_GET["id"];
        $cstm = M("ArticleCategoryCstm");
        switch ($action) {

            case "page_list":
                $keyword = trim(I('keyword'));
                $where['cat_name'] = array('exp', "LIKE '%$keyword%'");
                $count = $cstm->count();// 查询满足要求的总记录数
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                $this->assign("count",$count);
                $this->assign("page_num",$page_num);
                $this->assign("page_now",$page_now);
                $this->assign("page",$page);

                $res = $cstm->page($page_now, $page_num)->where($where)->select();
                $this->assign("res",$res);

                $this->display('category_list');
                break;

            case "page_add":
                $this->display('category_info');
                break;

            case "page_edit":
                $user = $cstm->where(array('id' => $getId))->find();
                $this->assign('user', $user);
                $this->display('category_info');
                break;

            case "add":
                $postId=I("post.");
                $r=$cstm->add($postId);
                if ($r) {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(6, "添加文章分类" . $postId["cat_name"] . "成功");
                        $returnArr = array("result" => 1, "msg" => "提交成功", "code" => 200, "data" => null);
                    } else {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(6, "添加文章分类失败，数据库录入失败");
                        $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
                    }
                break;

            case "edit":
                    $data=I("post.");
                    $info=$cstm->save($data);
                    if($info){
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(6, "添加文章分类" . $data["cat_name"] . "成功");
                        $returnArr = array("result" => 1, "msg" => "修改成功", "code" => 200, "data" => null);
                    } else {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(6, "添加文章分类失败，数据库录入失败");
                        $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
                    }
                break;

            case "del":
                $logData =$cstm->field("cat_name")->where("id=$getId")->find();
                $row =$cstm->where(array('id' => $getId))->delete();
                if ($row) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "删除用户" . $logData["cat_name"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);
                    //$this->success('成功删除会员');die;
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5, "删除用户" . $logData["cat_name"] . "失败");
                    $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
                    //$this->error('操作失败');die;
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
     * 问卷题目
     */
    public function test_topics()
    {
        $action = $_GET["action"];
        $channel = $_GET['channel'];
        $channelId = M("SystemChannel")->where("call_index = '$channel'") ->getField("id");
        $type = $_GET['type'];
        $activityId = $_GET['activity_id'];
        switch ($action) {

            case "save":
                $postData = I('post.');
                $testId = $postData['test_id'];
                $items = $postData['items'];
                if(empty($testId) || empty($items)){
                    $returnArr = array("result" => 0, "msg" => "请求错误，缺少参数", "code" => 401, "data" => null);
                }else{

                    //删掉原来的
                    M("TestTopicsWeifan")->where("test_id=".$testId)->delete();

                    $itemIdArr = json_decode(urldecode($items), true);

                    $itemIdArr = $this->sortItemArr($itemIdArr);

                    $data = array();
                    $i = 0;
                    foreach($itemIdArr as $item){
                        $data[$i]['channel_id'] = $channelId;
                        $data[$i]['test_id'] = $testId;
                        $data[$i]['topic_id'] = $item['id'];
                        $data[$i]['test_order'] = $item['sort'];
                        $data[$i]['test_no'] = ($i + 1);
                        $i++;
                    }

                    $state = M("TestTopicsWeifan")->addAll($data);
                    if($state){
                        $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                    }else{
                        $returnArr = array("result" => 0, "msg" => "保存失败", "code" => 402, "data" => null);
                    }
                }
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
     * 测试结果
     */
    public function test_result()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $result=M("TestResultWeifan");
        switch ($action) {

            case "page_list":
                $where['1'] = '1';
                if($getId){
                    $where['H.test_student_id'] = $getId;
                }
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $data = $result
                    ->join("AS H LEFT JOIN __MANAGE_ADMIN__ AS A ON A.admin_id=H.doctor_id
                             LEFT JOIN  __WEIFAN_SCHOOL__ AS B ON B.id=H.school_id
                             LEFT JOIN  __WEIFAN_GRADE__ AS C ON C.id=H.grade_id
                             LEFT JOIN  __WEIFAN_CLASS__ AS D ON D.id=H.class_id
                             LEFT JOIN  __WEIFAN_STUDENT__ AS E ON E.id=H.student_id
                             LEFT JOIN  __TEST_WEIFAN__ AS F ON F.id=H.test_id
                             LEFT JOIN  __TOPIC_WEIFAN__ AS G ON G.id=H.topic_id
                             LEFT JOIN  __TOPIC_ANSWER_WEIFAN__ AS I ON I.id=H.answer_id
                    ")
                    ->field("H.id,A.name user_name,B.name schoolname,C.name gradename,D.name classname,E.name studentname,H.test_student_id,F.title,G.title as topic,I.title as answer,H.answer_status,H.answer_remark,H.answer_time")
                    ->page($page_now,$page_num)
                    ->where($where)
                    ->select();

                $where['test_student_id'] = $getId;
                unset($where['H.test_student_id']);
                $count = $result->where($where)->count();          //$count    总共有多少条数据
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                $this->assign('count', $count);
                $this->assign('page', $page);
                $this->assign('page_num', $page_num);
                $this->assign('page_now', $page_now);

                $this->assign("data",$data);
                $this->display("result_list");
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

    /**
     * 测试结果
     */
    public function records()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $records=M("WeifanRecords");
        switch ($action) {
            case "page_list":
                $keyword=trim(I("keyword"));
                $where['test_title']=array("exp","LIKE '%$keyword%'");
                $page_num=I("get.page_num",null) ? I("get.page_num") : I("post.page_num",25); //$page_num每页显示几条数据
                $page_now=I("get.page_now",1); //$page_now 第几页

                $info=$records->join("AS C LEFT JOIN __MANAGE_ADMIN__ AS A ON C.doctor_id=A.admin_id LEFT JOIN __WEIFAN_SCHOOL__ AS B ON B.id=C.school_id")
                    ->field("C.id,C.test_title,C.test_num,A.name user_name,B.name")
                    ->page($page_now,$page_num)
                    ->where($where,"C.is_deleted=0")
                    ->select();

                $count = count($info); //查询符合条件的总记录数

                $page= ($count / $page_num) >intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page总共几页
                $this->assign("count",$count);
                $this->assign("page_num",$page_num);
                $this->assign("page_now",$page_now);
                $this->assign("page",$page);
                $this->assign("info",$info);
                $this->display("records_list");
                break;

            case "page_add":
                $this->display("records_info");
                break;

            case "page_edit":
                $data = $records->where(array('id' => $getId))->find();
                $this->assign('data', $data);
                $this->display('records_info');
                break;

            case "add":
                $postId=I("post.");
                $r=$records->add($postId);
                if ($r) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加文章分类" . $postId["record_name"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "提交成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加文章分类失败，数据库录入失败");
                    $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
                }
                break;

            case "edit":
                $data=I("post.");
                $info=$records->save($data);
                if($info){
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加文章分类" . $data["test_title"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "修改成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加文章分类失败，数据库录入失败");
                    $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
                }
                break;

            case "del":
                $logData =$records->field("record_name")->where(array('id'=>$getId))->find();
                $row=$records->where(array('id'=>$getId))->delete();
                if ($row) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "删除用户" . $logData["test_title"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5, "删除用户" . $logData["test_title"] . "失败");
                    $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);

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
     * 测试记录
     */
    public function test_records()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $DAO=M("TestStudentResultWeifan");
        switch ($action) {

            case "page_list":
                $test=trim(I("test"));
                $doctor=trim(I("doctor"));
                $class=trim(I("class"));
                $school=trim(I("school"));
                $name=trim(I("name"));
                $test_time=I("post.test_time");
                $test_error=I("post.test_error");

                $where['E.name']=array("exp","LIKE '%$name%'");

                if($test_time!=''){
                    $test_time = strtotime($test_time);
                    $test_time = date('Y-m-d',$test_time);
                    $where['A.test_time']=array("LIKE","$test_time%");
                }
                if($test_error!=''){
                    if($test_error ==0) {
                        $where['A.test_error']=array("EQ","$test_error");
                    }else {
                        $where['A.test_error']=array("EGT","$test_error%");
                    }
                }

                if($test!=''){
                    $where['G.title']=array("exp","LIKE '%$test%'");
                }
                if($doctor!=''){
                    $where['H.name']=array("exp","LIKE '%$doctor%'");
                }
                if($class!=''){
                    $where['D.name']=array("exp","LIKE '%$class%'");
                }
                if($school!=''){
                    $where['B.name']=array("exp","LIKE '%$school%'");
                }







                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $data = $DAO->alias('A')
                    ->join("LEFT JOIN __WEIFAN_SCHOOL__ B ON A.`school_id`=B.`id`
                        LEFT JOIN __WEIFAN_GRADE__ C ON A.`grade_id`=C.`id`
                        LEFT JOIN __WEIFAN_CLASS__ D ON A.`class_id`=D.`id`
                        LEFT JOIN __WEIFAN_STUDENT__ E ON A.`student_id`=E.`id`
                        LEFT JOIN __WEIFAN_RECORDS__ F ON A.`record_id`=F.`id`
                        LEFT JOIN __TEST_WEIFAN__ G ON A.`test_id`=G.`id`
                        LEFT JOIN __MANAGE_ADMIN__ H ON A.`doctor_id`=H.`admin_id`
                    ")
                    ->field("A.`id`,A.`test_time`,A.`test_error`,B.`name` school,C.`name` grade,D.`name` class,E.`name` student,F.`name` record,G.`title` test,H.`name` doctor")
                    ->page($page_now,$page_num)
                    ->where($where,"A.is_deleted=0")
                    ->select();

                $where = array();
                $where['is_deleted'] = 0;

                $count = $DAO->where($where)->count();          //$count    总共有多少条数据
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                $this->assign('count', $count);
                $this->assign('page', $page);
                $this->assign('page_num', $page_num);
                $this->assign('page_now', $page_now);

                $this->assign("data",$data);
                $this->display("test_records");
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


    private function sortItemArr($itemArr){

        foreach($itemArr as $key=>$value){
            $sortArr[$key] = $value['sort'];
        }

        array_multisort($sortArr, SORT_ASC, $itemArr);

        return $itemArr;
    }

}