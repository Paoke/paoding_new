<?php

namespace Api\Controller;

use Api\Logic\ChannelLogic;
use Api\Logic\CompanyLogic;
use Api\Logic\UserLogic;
use Think\Log;

class ChannelIndexController extends BaseRestController
{
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
            case "add": //添加数据
                R($baseModule. '/add');
                break;
            case "count"://根据条件统计总数
                $this->count();
                break;
            case "favourite"://收藏，这个是对频道数据进行收藏
                 R($baseModule."/favourite",'');
                break;
            case "cancelFavourite"://取消收藏，这个是对频道数据取消收藏
                R($baseModule."/cancelFavourite",'');
                break;
            case "like"://点赞
                $this->like();
                break;
            case "dislike"://取消点赞
                $this->dislike();
                break;
            case "numberCount"://统计
                R($baseModule."/numberCount",'');
                break;
            case "signup"://报名
                R($baseModule."/signup",'');
                break;
            case "cancalSignup"://取消报名
                R($baseModule."/cancalSignup",'');
                break;
            case "rebund"://退款
                R($baseModule."/rebund",'');
                break;
            case "toEmail"://发送邮件
                R($baseModule."/toEmail",'');
                break;
            case "collect"://发送邮件
                R($baseModule."/collect");
                break;
            case "updateField":
                R($baseModule."/updateField");
                break;
            case "getField":
                R($baseModule."/getField");
                break;
            default:
                $returnArr = array("result" => 0, "msg" => "没有找到对应的API", "code" => 400);
                json_return($returnArr);
                break;
        }
    }

    public function childDataList(){
        $parameterGet = I('get.');
    }
    /*
      * 根据条件统计总数
      */
    public function count(){
        $parameterGet = I('get.');
        $parameterPost = I('post.');
        $channelLogic = new ChannelLogic();
        $bool = $channelLogic->setTable($parameterGet['channel'],  $parameterGet['type']);
        if ($bool) {
//            Log::write(json_encode($parameterPost),"search>>>>>>>>");
            $info = $channelLogic->getCount($parameterPost);
            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
        } else {
            $returnArr = array("result" => 0, "msg" => "系统繁忙，请稍后再试", "code" => 400);
        }
        json_return($returnArr);
    }

    /*
     * 点赞
     */
    public function like(){
        $parameterGet = I('get.');
        $channelModel = M("SystemChannel")->where("call_index = '".$parameterGet["channel"]."'")->find();
        $data['channel_id'] = $channelModel["id"];
        $data['data_id'] = $parameterGet["data_id"];
        $data["zan_user_id"] = $_SESSION["userArr"]["user_id"];

        //*************判断是否点过赞
        $is_exist = M("CommonLike")->where($data)->find();
        if($is_exist){
            $returnArr = array("result" => 0, "msg" => "不能重复点赞", "code" => 400);
            json_return($returnArr);
        }
        //*************判断是否点过赞

        $data["zan_time"] = date("Y-m-d H:i:s", time());
        $result = M("CommonLike")->add($data);
        if($result){
            $returnArr = array("result" => 1, "msg" => "点赞成功", "code" => 200, "data" => $result);
        } else {
            $returnArr = array("result" => 0, "msg" => "点赞失败", "code" => 400);
        }
        json_return($returnArr);
    }

    /*
     * 取消点赞
     */
    public function dislike(){
        $parameterGet = I('get.');
        $channelModel = M("SystemChannel")->where("call_index = '".$parameterGet["channel"]."'")->find();
        $data['channel_id'] = $channelModel["id"];
        $data['data_id'] = $parameterGet["data_id"];
        $data["zan_user_id"] = $_SESSION["userArr"]["user_id"];
        $result = M("CommonLike")->where($data)->delete();
        if($result){
            $returnArr = array("result" => 1, "msg" => "取消点赞成功", "code" => 200, "data" => $result);
        } else {
            $returnArr = array("result" => 0, "msg" => "取消点赞失败", "code" => 400);
        }
        json_return($returnArr);
    }

    /*
     * 跳转地址
     */
    public function channelPage()
    {
        $getId = $_GET["id"];
        $channe =M("SystemChannel")->field("channel_title,call_index")->where("id = '$getId'")->find();
        $channel = $channe['call_index'];
        /*$html = M("MobileChannelPage")->where("channel = '$channel'") ->getField("html");
        $this->assign('page_html',$html);*/
        $this->assign('channelName',$channe['channel_title']);
        $this->assign('channel',$channel);
        $base_module = M("SystemChannel")->where("call_index = '$channel'")->getField("base_module");
        $site = get_site_name();
        $url = './Template/'.$site.'/mobile/'.$base_module.'/'.$channel.'_list.html';
        $this->display($url);
    }

    //收藏
    public function collect(){
        $action = $_GET['action'];
        $getData = I('get.');
        $postData = I('post.');
        $data = array_merge($getData, $postData);
        $user_id = session('userArr')['user_id'];

        if($user_id){
            switch($action){
                case "add":
                    $logic = new ChannelLogic();
                    $flag = $logic->collect($data, session('userArr'));
                    if($flag === false){
                        $returnArr = array("result" => 0, "msg" => "收藏失败，请稍后再试", "code" => 401);
                    }else{
                        $returnArr = array("result" => 1, "msg" => "收藏成功", "code" => 200);
                    }
                    break;
                case "del":
                    $logic = new ChannelLogic();
                    $flag = $logic->cancelCollect($data, $user_id);
                    if($flag === false){
                        $returnArr = array("result" => 0, "msg" => "取消收藏失败，请稍后再试", "code" => 401);
                    }else{
                        $returnArr = array("result" => 1, "msg" => "取消收藏成功", "code" => 200);
                    }
                    break;
                case "list":
                    $channel = $_GET['channel'];
                    $type = $_GET['type'];
                    $page = $_POST['page'] ? $_POST['page'] : 1;
                    $page_num = $_POST['page_num'] ? $_POST['page_num'] : 10;
                    $logic = new ChannelLogic();

                    $info = $logic->collectList($user_id, $channel, $type, $page, $page_num);
                    if($info === false){
                        $returnArr = array("result" => 0, "msg" => "获取收藏列表成功失败", "code" => 401);
                    }else{
                        $returnArr = array("result" => 1, "msg" => "获取收藏列表成功", "code" => 200, "data" => $info);
                    }


                    break;
                default:
                    $returnArr = array("result" => 0, "msg" => "参数错误", "code" => 404);
                    break;
            }

        }else{
            $returnArr = array("result" => 0, "msg" => "请先登录", "code" => 666);
        }
        json_return($returnArr);
    }

    //邮件
    public function email(){
        $action = $_GET['action'];
        $getData = I('get.');
        $postData = I('post.');
        $param = array_merge($getData, $postData);
        $user_id = session('userArr')['user_id'];
        $channel = $_GET['channel'];
        $type = $_GET['type'];
        if($user_id){
            switch($action){
                case "push":

                    $fileField = $param['file_field'];
                    $contentType = $param['content_type'];
                    //获取文件信息
                    $logic = new ChannelLogic();
                    $logic->setTable($channel, $type);
                    $info = $logic->getDetail($param);
                    if(!$info || empty($info[$fileField])){
                        $returnArr = array("result" => 0, "msg" => "发送邮件失败!没有找到资料文件!", "code" => 401);
                        json_return($returnArr);
                    }
                    $userLogic = new UserLogic();
                    $email = $userLogic->getUserEmail($user_id);
                    if(empty($email)){
                        $returnArr = array("result" => 0, "msg" => "您还没有绑定邮箱，请先到个人中填写邮箱资料!", "code" => 402);
                        json_return($returnArr);
                    }

                    $content = $logic->getPushContent($info, $contentType, $param);
                    $flag = send_email_asyn($email, $info['title'], $content);

                    if($flag){
                        $returnArr = array("result" => 1, "msg" => "邮件已经发送到[".$email."]，如果长时间未能收到，请重试!", "code" => 200);
                    }else{
                        $returnArr = array("result" => 0, "msg" => "发送邮件失败", "code" => 401);

                    }
                    break;

                default:
                    $returnArr = array("result" => 0, "msg" => "参数错误", "code" => 404);
                    break;
            }

        }else{
            $returnArr = array("result" => 0, "msg" => "请先登录", "code" => 666);
        }
        json_return($returnArr);
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

}
