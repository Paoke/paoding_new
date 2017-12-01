<?php

namespace Api\Controller;

use Api\Logic\ChannelLogic;
use Api\Logic\CompanyLogic;
use Api\Logic\UserLogic;
use Think\Log;

class PaodingController extends BaseRestController
{

    public function getData(){
        $_POST=I("post.");
        $Ztgl= M("ArticleZtgl");
        $where['A.is_deleted']=0;
        $where['A.is_active']=1;
        $where['A.sszt']=$_POST['sszt'];
        $sszt=$_POST['sszt']>0;
        $data = M("ArticleJs")->join("AS A LEFT JOIN __ARTICLE_ZTGL__ AS B ON A.sszt=B.id")
            ->field("B.title as t_name,A.*")
            ->where($where,"A.$sszt")
            ->select();
        if($data){
            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, 'data' =>$data);
        }else {
            $returnArr = array("result" => 0, "msg" => "获取失败", "code" => 402, 'data' =>null);
        }
        json_return($returnArr);
    }
    public function getIndex(){
        $where['is_deleted']=0;
        $where['is_active']=1;
        $page_num=$_GET['page_num'];
        $data = M("ArticleZtgl")->where($where)->field("id,title,cover_url,miaoshu")->order("create_time DESC")->limit("$page_num")->select();
        foreach($data as $key=>$val){
            $data[$key]['count']=M("ArticleJs")->where('sszt='.$val['id'])->count();
        }
        if($data){
            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, 'data' =>$data);
        }else {
            $returnArr = array("result" => 0, "msg" => "获取失败", "code" => 402, 'data' =>null);
        }
        json_return($returnArr);
    }
    public function index()
    {
        $channel = $_GET['channel']; //频道名
        $baseModule = M("SystemChannel")->where("call_index = '$channel'")->getField("base_module"); //频道的基础类型，基础类型名是相应的控制器名
        $action = $_GET['action'];
        switch($action){
            case "dataList"://数据列表
                R($baseModule."/dataList",'');
                break;
            case "dataDetail"://某条数据的具体详情
               R($baseModule . '/dataDetail');
                break;
            default:
                $returnArr = array("result" => 0, "msg" => "没有找到对应的API", "code" => 400);
                json_return($returnArr);
                break;
        }
    }
    public function field(){
        $action = $_GET['action'];
        $channel = $_GET['channel'];
        $type = $_GET['type'];
        $data = I('post.');
        $logic = new CompanyLogic();
        switch($action){

            case "update":

                $logic->setTable($channel, $type);

                $info = $logic->updateField($data['id'], $data['field'], $data['value']);

                if ($info === false) {
                    $returnArr = array("result" => 0, "msg" => "更新字段失败", "code" => 402, "data" => null);
                } else {
                    $returnArr = array("result" => 1, "msg" => "更新字段成功", "code" => 200, "data" => $info);

                }
                break;

            case "get":
                $logic->setTable($channel, $type);

                $info = $logic->getFieldValue($data['id'], $data['field']);

                if (!$info) {
                    $returnArr = array("result" => 0, "msg" => "获取字段失败", "code" => 402, "data" => null);
                } else {
                    $returnArr = array("result" => 1, "msg" => "获取字段成功", "code" => 200, "data" => $info);

                }

                break;
            default:
                $returnArr = array("result" => 0, "msg" => "参数错误", "code" => 404);
                break;
        }
        json_return($returnArr);
    }


    //个人中心提交咨询
    public function Consultation(){
        $post = I("post.");
        $where['is_deleted']=0;
        $where['is_active']=1;
        $where['sjh']=$post['mobile'];
        $data = M("ArticleFwdj")->where($where)->field("content,gfhf")->select();
        if($data){
            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, 'data' =>$data);
        }else {
            $returnArr = array("result" => 0, "msg" => "获取失败", "code" => 402, 'data' =>null);
        }
        json_return($returnArr);
    }


    //获取注册协议
    public function getZcxy(){
        $data = M("Config")->where("name = 'introduction_register_law'")->getField("value");
        //$data = htmlspecialchars($data);
        if($data){
            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, 'data' =>$data);
        }else {
            $returnArr = array("result" => 0, "msg" => "获取失败", "code" => 402, 'data' =>null);
        }
        json_return($returnArr);
    }

    //获取服务协议
    public function getFwxy(){
        $data = M("Config")->where("name = 'introduction_service_law'")->getField("value");
        //$data = htmlspecialchars($data);
        if($data){
            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, 'data' =>$data);
        }else {
            $returnArr = array("result" => 0, "msg" => "获取失败", "code" => 402, 'data' =>null);
        }
        json_return($returnArr);
    }

    //获取关于我们
    public function getAboutUs(){
        $data = M("Config")->where("name = 'introduction_aboutus'")->getField("value");
        //$data = htmlspecialchars($data);
        if($data){
            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, 'data' =>$data);
        }else {
            $returnArr = array("result" => 0, "msg" => "获取失败", "code" => 402, 'data' =>null);
        }
        json_return($returnArr);
    }
}
