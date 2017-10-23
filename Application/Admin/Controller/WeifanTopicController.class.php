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
class WeifanTopicController extends BaseController
{
    /**
     * 析构函数，判断权限等
     */
    public function __construct()
    {
        parent::__construct();
        $res = parent::checkRole();
        if ($res["result"] != 1) {
            $this->error("您的账号没有操作权限");
        }
    }

    /**
     * 题目管理
     */
    public function topic()
    {
        $action = $_GET["action"];
        $DAO  = M('TopicWeifan');
        switch ($action) {

            case "page_list":
                $keyword=trim(I("keyword"));
                if($keyword){
                    $where['title']=array("exp","LIKE '%$keyword%'");
                }
                $where['is_deleted'] = 0;
                $data = $DAO->where($where)->select();
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $count = $DAO->where($where)->count();          //$count    总共有多少条数据
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                $this->assign('count', $count);
                $this->assign('page', $page);
                $this->assign('page_num', $page_num);
                $this->assign('page_now', $page_now);
                $this->assign('list', $data);

                $this->display('topic_list');
                break;

            case "page_add":
                $this->display('topic_info');
                break;

            case "page_edit":

                $id = $_GET['id'];
                $topic = $DAO->where('id='.$id)->find();
                $this->assign('topic', $topic);

                $answers = M('TopicAnswerWeifan')->where('topic_id='.$id)->select();
                $this->assign('answers', $answers);

                //是否已经在使用
                $count = M('TestTopicsWeifan')->where('topic_id='.$id)->count();
                if($count > 0){
                    $this->assign('is_use', $count);
                }

                $this->display('topic_info');
                break;

            case "add":
                $data = I('post.');
                $topic['category_id'] = $data['category_id'] ? $data['category_id'] : 0;
                $topic['title'] = $data['title'];
                $topic['desc'] = $data['desc'];
               /* $topic['topic_img'] = $data['topic_img'];
                $topic['icon'] = $data['icon'];*/
                $topic['create_time'] = date('Y-m-d H:i:s', time());
                $topic['create_user_id'] = $_SESSION["admin_id"];
                $topic['update_time'] = date('Y-m-d H:i:s', time());
                $topic['update_user_id'] = $_SESSION["admin_id"];
                $topic['answer_count'] = $data['goodnum'];
                $topic['topic_type'] = $data['type_id'];
                $id = $DAO->add($topic);
                $Letter = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
                if($id && $data['type_id']<2 ){
                    for($i=0; $i<$data['goodnum']; $i++){
                        $title = $Letter[$i];
                        $answer[$i]['title'] = $title;
                        $answer[$i]['topic_id'] = $id;
                        $answer[$i]['desc'] = $data["as_desc_$i"];
                        $answer[$i]['remarks'] = $data["as_remark_$i"];
                        if($data['type_id'] == 0) {
                            $answer[$i]['status'] = $data["as_status_$i"];
                        }
                        $answer[$i]['create_time'] = date('Y-m-d H:i:s', time());
                        $answer[$i]['create_user_id'] = $_SESSION["admin_id"];
                    }

                    $state =  M('TopicAnswerWeifan')->addAll($answer);

                    if($state) {
                        $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                    }else{
                        $returnArr = array("result" => 0, "msg" => "保存错误", "code" => 403, "data" => null);
                    }

                }
                else if($id && $data['type_id']==2 ){
                    $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                } else {
                    $returnArr = array("result" => 0, "msg" => "保存错误", "code" => 404, "data" => null);
                }
                break;

            case "edit":

                $data = I('post.');
                $id = $data['id'];
                $topic = $DAO->where('id='.$id)->find();

                $topic['category_id'] = $data['category_id'] ? $data['category_id'] : 0;
                $topic['title'] = $data['title'];
                $topic['desc'] = $data['desc'];
                $topic['topic_img'] = $data['topic_img'];
                $topic['icon'] = $data['icon'];
                $topic['update_time'] = date('Y-m-d H:i:s', time());
                $topic['update_user_id'] = $_SESSION["admin_id"];

                $flag = $DAO->save($topic);

                if($flag){

                    M('TopicAnswerWeifan')->where('topic_id='.$id)->delete();

                    for($i=0; $i<4; $i++){

                        if($i == 0){
                            $title = 'A';
                        }elseif($i == 1){
                            $title = 'B';
                        }elseif($i == 2){
                            $title = 'C';
                        }elseif($i == 3){
                            $title = 'D';
                        }

                        $answer[$i]['title'] = $title;
                        $answer[$i]['topic_id'] = $id;
                        $answer[$i]['desc'] = $data["as_desc_$i"];
                        $answer[$i]['remarks'] = $data["as_remark_$i"];
                        $answer[$i]['status'] = $data["as_status_$i"];
                        $answer[$i]['create_time'] = date('Y-m-d H:i:s', time());
                        $answer[$i]['create_user_id'] = $_SESSION["admin_id"];
                    }

                    $state =  M('TopicAnswerWeifan')->addAll($answer);

                    if($state) {
                        $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                    }else{
                        $returnArr = array("result" => 0, "msg" => "保存错误", "code" => 403, "data" => null);
                    }

                }else{
                    $returnArr = array("result" => 0, "msg" => "保存错误", "code" => 404, "data" => null);
                }

                break;

            case "del":
                $id = $_GET['id'];
                if($id){

                    $count = M('TestTopicsWeifan')->where('topic_id='.$id)->count();
                    if($count > 0){
                        $returnArr = array("result" => 0, "msg" => "删除失败，题目已经在测试中使用，不能再删除!", "code" => 401, "data" => null);
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
     * 题目分类
     */
    public function category()
    {
        $action = $_GET["action"];
        //获取id，id是给编辑页面用的
        $getId = $_GET["id"];
        $cswj = M("ArticleCategoryCswj");
        switch ($action) {

            case "page_list":
                $keyword = trim(I('keyword'));
                $where['cat_name'] = array('exp', "LIKE '%$keyword%'");
                $count = $cswj->count();// 查询满足要求的总记录数
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                $this->assign("count",$count);
                $this->assign("page_num",$page_num);
                $this->assign("page_now",$page_now);
                $this->assign("page",$page);

                $res = $cswj->page($page_now, $page_num)->where($where)->select();
                $this->assign("res",$res);

                $this->display('category_list');
                break;

            case "page_add":
                $this->display('category_info');
                break;

            case "page_edit":
                $user = $cswj->where(array('id' => $getId))->find();
                $this->assign('user', $user);
                $this->display('category_info');
                break;

            case "add":
                $postId=I("post.");
                $r=$cswj->add($postId);
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
                $info=$cswj->save($data);
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
                $logData =$cswj->field("cat_name")->where("id=$getId")->find();
                $row =$cswj->where(array('id' => $getId))->delete();
                if ($row) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "删除用户" . $logData["cat_name"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);
                    //$this->success('成功删除会员');die;
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5, "删除用户" . $logData["cat_name"] . "失败");
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
     * 答案
     */
    public function answer()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
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

   

}