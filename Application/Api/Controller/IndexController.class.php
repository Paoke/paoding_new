<?php

namespace Api\Controller;

use Think\Controller;

class IndexController extends BaseRestController
{
    public function index()
    {
        $returnArr = array("result" => 0, "msg" => "页面待开发", "code" => '402');
        json_return($returnArr);
    }

    public function banner()
    {
        $module=$_GET['module'];
        $ad=M("Ad");
        $info=$ad->where("pid=".$module)->field("ad_code,ad_link")->order('orderby desc')->select();
        $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => $info);
        json_return($returnArr);
    }
//
//    public $user_id = 0;
//    public $user = array();
//
//    public function index()
//    {
//        $template_arr = include("./Application/Mobile/Conf/html.php");
//        $temple = $template_arr['DEFAULT_THEME'];//读取当前模版名称
//
//        if ($temple == 'Article') {  //根据不同模版启用不同index页面
//            $this->articleIndex();
//            die();
//        }
//        $keywords = trim(I('post.keywords'));
//        //工作页
//        $info = R('Mobile/WorkEnroll/enroll_info');
//        $this->assign('qb_info', $info['qb_info']);
//        $this->assign('jx_info', $info['jx_info']);
//        $this->assign('fl_info', $info['fl_info']);
//        $fl_id = $_GET['fl_id'];
//        $son_id = $_GET['son_id'];
//        if ($fl_id != null) {
//            $son_info = M('register_spec')->field('id,parent_id,title')->where("parent_id=$fl_id")->select();
//            $return_arr = array('status' => 1, 'data' => $son_info);
//            $this->assign('son_info', $son_info);
//            $this->ajaxReturn($return_arr);
//        } elseif ($info['fl_info'] != null) {
//            $son_info = M('register_spec')->field('id,parent_id,title')->where("parent_id={$info['fl_info'][0]['id']}")->select();
//            $this->assign('son_info', $son_info);
//        }
//        if ($son_id != null) {
//            $info = A("Mobile/WorkEnroll");
//            $res = $info->fl_search($son_id);
//            $this->assign('info', $res);
//            $this->assign('keyworks', $son_id);
//        }
////        $this->display();
//
//        $returnArr=array("result"=>0,"msg"=>"操作错误","code"=>"402");
//        json_return($returnArr);
//
//    }
//
//    public function articleIndex()
//    {
//        $this->display('index');
//    }
//
//    public function getArticleMenu()
//    {
//        $parentCat = D('article_cat')->where('parent_id = 0')->field('cat_id,cat_name')->select();
//        $cat = D('article_cat')->where('parent_id <> 0')->getField('cat_id,parent_id,cat_name');
//        $count = count($parentCat);
//        for ($i = 0; $i < $count; $i++) {
//            foreach ($cat as $val => $key) {
//                if ($key['parent_id'] == $parentCat[$i]['cat_id']) {
//                    $parentCat[$i]['son'][] = $key;
//                }
//            }
//
//        }
//
////        $data[0] = $parentCat[0];
////        $data[1] = $parentCat[8];
////        $data[2] = $parentCat[9];
////        $this->ajaxReturn($data);
//        //暂时只取这三个做测试
//
//        $this->ajaxReturn($parentCat);
//
//    }
//
//    public function getArticleList()
//    {
//        $Article = M('article');
//        $map['is_open'] = 1;
//        $data = $list = array();
//        $cat = D('article_cat')->getField('cat_id,cat_name');//文章分类
//        $pageNum = 20 ; //$pageNum 每页几条数据
//        $pageNow = I('post.pageNow', 1);   //$page_now 第几页
//        $count = $Article->where($map)->count();// 查询满足要求的总记录数
//        $article = $Article->order('publish_time desc')->where($map)->page($pageNow, $pageNum)->select();
//        $page = ($count / $pageNum) > intval($count / $pageNum) ? intval($count / $pageNum + 1) : intval($count / $pageNum);
//        //     总共有几页
//
//        if ($cat && $article) {
//            foreach ($article as $val) {
//                $val['cat_name'] = $cat[$val['cat_id']];
//                $val['publish_time'] = date('Y-m-d', $val['publish_time']);
//                $list[] = $val;
//            }
//        }
//        $data['articleList'] = $list;
//        $data['page'] = $page;
//        $data['pageNow'] = $pageNow;
//        $data['count'] = $count;
//        $this->ajaxReturn($data);
//
//    }
//
//    public function getDiscover()
//    {
//        $this->display("index_news");
//    }
//
//    public function getNews()
//    {
//        $article = M("article");
//
//        if (!$_GET['page']) {
//            $res = $article->field("article_id,title,description,thumb,add_time")->order("add_time DESC")->limit(0, 5)->select();
//            foreach ($res as $key => $val) {
//                if (strlen($res[$key]['description']) >= 20) {
//                    $res[$key]['description'] = mb_substr($res[$key]['description'], 0, 25) . "...";
//                }
//            }
////            $this->ajaxReturn($res,"JSON");
//            $this->assign("info",$res);
//        } elseif($_GET['page']) {
//            $res = $article->field("article_id,title,description,thumb,add_time")->order("add_time DESC")->limit($_GET['page'], 5)->select();
//            foreach ($res as $key => $val) {
//                if (strlen($res[$key]['description']) >= 20) {
//                    $res[$key]['description'] = mb_substr($res[$key]['description'], 0, 25) . "...";
//                }
//            }
//            $this->ajaxReturn($res);
//        }
//        $this->display("index_news");
//    }
//
//
//
//    //lsh: 显示活动列表    +搜索功能
//    public function index2()
//    {
//        $where = 'is_deleted=0 ';
//        $keywords = trim(I('post.keywords'));
//        $keywords && $where .= " and title like '%$keywords%'";
//
//        $Act = M('Activity');
//        $list = $Act->where($where)->order('id')->select();
//
//        $this->assign('activity_list', $list);
//        $this->display();
//    }
//
//    public function index3()
//    {
//        //行程列表
//        $info = R("WorkEnroll/getWorkItinerary");
//        $this->assign("info", $info);
//        $this->display();
//    }
//
//    public function index4()
//    {
//        //我的页
//        if (session('?user')) {
//            $user = session('user');
//            $user = M('ManageUsers')->where("user_id = " . $user['user_id'])->find();
//            session('user', $user);  //覆盖session 中的 user
//            $this->user = $user;
//            $this->user_id = $user['user_id'];
//            $this->assign('info', $user); //存储用户信息
//            $my_work_count = R('Mobile/WorkEnroll/my_work_count', array("uid" => $user['user_id']));
//            $this->assign('s_count', $my_work_count['s_count']);
//            $this->assign('i_count', $my_work_count['i_count']);
//            $this->assign('e_count', $my_work_count['e_count']);
//        }
//        $this->display();
//    }
//
//    public function search()
//    {
//        //搜索页 暂时只能搜索工作
//        $str = $_GET['keywords'];
//        $son_id = $_GET['son_id'];
//        $son_title = $_GET['title'];
//        if ($str != null) {
//            $info = A("Mobile/WorkEnroll");
//            $res = $info->word_search($str);
//            $this->assign('search_info', $res);
//            $str_msg = "很抱歉，没有找“" . $str . "”相关的信息。";
//            $msg = array("title" => $str, "msg" => $str_msg);
//            $this->assign('msg', $msg);
//        }
//        if ($son_id != null) {
//            $info = A("Mobile/WorkEnroll");
//            $res = $info->fl_search($son_id);
//            $this->assign('fl_info', $res);
//            $son_msg = "很抱歉，查询不到“" . $son_title . "”的分类信息。";
//            $msg = array("title" => $son_title, "msg" => $son_msg);
//            $this->assign('msg', $msg);
//        }
//        $this->display();
//    }

}