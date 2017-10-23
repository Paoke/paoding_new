<?php

namespace Admin\Controller;

use Admin\Util\GetFirstCharterUtil;
use Think\Log;

class PaodingController extends BaseController
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
        $checkAction = array('article');
        if(in_array($act,$checkAction) && in_array($action,$check)) {
            $res = parent::checkRole();
            if ($res["result"] != 1) {
                $this->error("您的账号没有操作权限");
            }
        }
    }

    public function Paoding_list(){
        $get =I("get.");
        $post =I("post.");
        $categoryId = $_GET["category_id"];
        $action = $_GET["action"];//action/page_list
        if($categoryId>0){
            $categoryName = M("ArticleZtgl") ->where("id = '$categoryId'")->getField("title");
        }
        switch($action){
            case "page_list":
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $gotPage=I("gotPage");
                if($gotPage){
                    $page_now=$gotPage;
                }
                $info='A.sszt>0 AND A.sszt is not null ';
                if($categoryId>0) {
                    $info=$info.' AND sszt='.$categoryId;
                }
                $count=M("ArticleJs")->join("AS A LEFT JOIN __ARTICLE_ZTGL__ AS B ON A.sszt=B.id")->where($info)->count();
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页

                $where='A.sszt>0 AND A.sszt is not null ';
                if($categoryId>0) {
                    $where=$where.' AND sszt='.$categoryId;
                }
                $data=M("ArticleJs")
                    ->join("AS A LEFT JOIN __ARTICLE_ZTGL__ AS B ON A.sszt=B.id AND A.is_deleted=0 AND A.is_active=1 AND A.sszt>0")
                    ->page($page_now,$page_num)
                    ->where($where)
                    ->field("A.title,B.title name")
                    ->select();

                if($categoryId) {
                    $this->assign("category_id",$categoryId);
                } else{
                    $this->assign("category_id",0);
                }
                $this->assign("category_name",$categoryName);
                $this->assign("page",$page);
                $this->assign("count",$count);
                $this->assign("page_num",$page_num);
                $this->assign("page_now",$page_now);
                $this->assign("data",$data);
                $this->display();
                break;
            default:
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法");
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
                break;
        }
        json_return($returnArr);

    }
    public function category(){
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $channel = $_GET["channel"];
        $moduleType = $_GET['type'];

        switch($action){
            case "list":
                $keyword = trim(I("cat_name"));
                if($keyword) {
                    $where["title"] = array("exp", "LIKE '%$keyword%'");
                }
                $where['is_deleted']=0;
                //查找显示一级分类
                $page_num = I('post.page_num',8);   //$page_num 每页几条数据
                $page_now = I('post.page_now',1);   //$page_now 第几页

                $count=M("ArticleZtgl")->where($where)->count();    //$count    总共有多少条数据
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page  总共有几页
                $data = M("ArticleZtgl")->where($where)->page($page_now,$page_num)->field('id, title')->select();
                $arr['page_now']=$page_now;
                $arr['page']=$page;
                if($data)  {

                    $returnArr = array("result" => 1,"arr"=>$arr, "msg" => "获取数据成功", "code" => 200, "data" => $data);
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

}
