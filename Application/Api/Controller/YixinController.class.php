<?php

namespace Api\Controller;

use Think\Controller;
use Think\Log;
use Api\Logic\WechatLogic;

class YixinController extends BaseRestController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        $action = $_GET["action"];
        $channel = $_GET['channel'];
        $channelId = M("SystemChannel")->where("call_index = '$channel'") ->getField("id");
        $type = $_GET['type'];
        $activityId = $_GET['activity_id'];
        $DAO = M('TestWeifan');
        switch($action){
            case  'company_list':
                $where['is_deleted'] = 0;
                $where['activity_id'] = $activityId;
                $where['channel_id'] = $channelId;
                $data = $DAO->where($where)->select();
                if ($data) {
                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $data);
                } else {
                    $returnArr = array("result" => 0, "msg" => "没有数据或该用户不存在，否则为栏目不存在", "code" => 400);
                }
                break;
            case  'ifFillIn':
                $company_id = $_GET['company_id'];
                $userId =  session('userArr')['user_id'];
                $where['user_id'] = $userId;
                $where['test_id'] = $company_id;
                $where['activity_id'] = $activityId;
                $where['fill_in'] = 1;
                $fillIn =  M("UserTest")->where($where)->find();
                if($fillIn) {
                    $returnArr = array("result" => 0, "msg" => "此企业调查问卷已经做了", "code" => 400);
                } else {
                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => '');
                }
                break;
            case  4:

                break;
//                case  5:暂时废弃，查tag的时候理论上可以用1的方法
//                    $info = $articleLogic->getTagArticleList($parameterGet);
//                    break;
            default:

                break;
        }

        json_return($returnArr);
    }

    public function getPeopleDetail(){
        $parameterGet = I('get.');
        $parameterPost = I('post.');
        $getSelfUserId = $_SESSION["userArr"]["user_id"];  //自身的用户id
        $param = array_merge($parameterGet, $parameterPost);
        $info=M("ActivityYjglHygl")->where("id=".$param['id'])->select();
        $ifComment = M("CommonCommentYjgl")->where("yjgl_hygl_id =".$param['id']." AND comment_user_id = '$getSelfUserId'")->find();
        if($ifComment) {
            $info[0]['if_comment'] = 1;
        } else {
            $info[0]['if_comment'] = -1;
        }
        if ($info) {
            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
        } else {
            $returnArr = array("result" => 0, "msg" => "没有数据或该用户不存在，否则为栏目不存在", "code" => 400);
        }
        json_return($returnArr);
    }

    //评价演讲人
    public function yjglEvaluate(){
        $dataId = $_GET['data_id']; //演讲管理会议管理id
        $getSelfUserId = $_SESSION["userArr"]["user_id"];  //自身的用户id
        $postEvaluate = $_POST['txtContent'];//获取评论内容
        $yjData = M("ActivityYjglHygl")->where("id = '$dataId'")->find();
        $peopleId = $yjData['relation_data_id'];
        $activityId = $yjData['data_id'];
        $comment_user_nickname = M("ManageUsers")->where("user_id='$getSelfUserId'")->getField("nickname");  //频道id
        $data["comment_user_id"] = $getSelfUserId;
        $data["comment_user_nickname"] = $comment_user_nickname;
        $data["comment_time"] = date("Y-m-d H:i:s", time());
        $data["comment_level"] = $_GET['comment_level'];
        $data["content"] = $postEvaluate ;
        $data["yjgl_hygl_id"] = $dataId ;
        $data["people_id"] = $peopleId ;
        $data["activity_id"] = $activityId;
        $info = M("CommonCommentYjgl")->add($data);
        if ($info) {
            $returnArr = array("result" => 1, "msg" => "评论成功", "code" => 200, "data" => null);
        } else {
            $returnArr = array("result" => 0, "msg" => "评价失败", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }

    public function getZwglList(){
        $parameterGet = I('get.');
        $parameterPost = I('post.');
        $param = array_merge($parameterGet, $parameterPost);
        $info=M("ActivityZwglHygl")->where("relation_data_id=".$param['id'])->select();
        if ($info) {
            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
        } else {
            $returnArr = array("result" => 0, "msg" => "没有数据或该用户不存在，否则为栏目不存在", "code" => 400);
        }
        json_return($returnArr);
    }
//获取会议参与人员列表
    public function getParticipantList(){
        $activity_id = $_GET['activity_id'];
        $channel =$_GET['channel'];
        $orderTable  = getTable($channel,3);
        $dataList = M($orderTable['table_format'])->field("name,mobile,company,job")->where("activity_id = '$activity_id'")->select();
        if ($dataList) {
            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $dataList);
        } else {
            $returnArr = array("result" => 0, "msg" => "没有数据", "code" => 400);
        }
        json_return($returnArr);
    }

//获取会议参与人员列表
    public function getCommentList(){
        $user_id = $_GET['user_id'];
        $channel =$_GET['channel'];
        $dataList = M("CommonComment")->alias('a')->
        field("a.comment_level,a.content,b.title,b.cover_url")->
        join('__ACTIVITY_HYGL__ b on b.id=a.data_id','LEFT')->
        where("a.comment_user_id = '$user_id'")->select();
        if ($dataList) {
            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $dataList);
        } else {
            $returnArr = array("result" => 0, "msg" => "没有数据", "code" => 400);
        }
        json_return($returnArr);
    }

    //获取打赏记录列表
    public function getRewardRecordList(){
        $user_id = $_GET['user_id'];
        $dataList = M("SpeechWechatLog")
            ->where("user_id = '$user_id'")
            ->select();
        if ($dataList) {
            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $dataList);
        } else {
            $returnArr = array("result" => 0, "msg" => "没有数据", "code" => 400);
        }
        json_return($returnArr);
    }
//邮件
    public function email(){
        $getData = I('get.');
        $postData = I('post.');
        $param = array_merge($getData, $postData);
        $user_id = session('userArr')['user_id'];
        if($user_id){
            $info=M("ActivityYjglHygl")->where("id=".$param['id'])->select();
            if(!$info || empty($info['yjnr'])){
                $returnArr = array("result" => 0, "msg" => "发送邮件失败!没有找到资料文件!", "code" => 401);
                json_return($returnArr);
            }
            //检查邮箱
            $userLogic = new UserLogic();
            $email = $userLogic->getUserEmail($user_id);
            if(empty($email)){
                $returnArr = array("result" => 0, "msg" => "您还没有绑定邮箱，请先到个人中填写邮箱资料!", "code" => 402);
                json_return($returnArr);
            }
            $flag = send_email_asyn($email, $info['yjnr']."的内容", $info['yjnr']);
            if($flag){
                $returnArr = array("result" => 1, "msg" => "邮件已经发送到[".$email."]，如果长时间未能收到，请重试!", "code" => 200);
            }else{
                $returnArr = array("result" => 0, "msg" => "发送邮件失败", "code" => 401);
            }
        }else{
            $returnArr = array("result" => 0, "msg" => "请先登录", "code" => 666);
        }
        json_return($returnArr);
    }

    public function get_selected_data(){
        $channel = $_GET['channel'];
        $type = $_GET['type'];
        if($_GET['child']){
            $childIndex = $_GET['child'];
            $where['channel_index'] = $channel;
            $where['child_index'] = $childIndex;

            $child = M('SystemChannelChild')->where($where)->find();
            $type = $child['type'];
        }

        $table = getTableStr($channel, $type, 'table_format');

        $where = array(
            'is_deleted' => 0
        );
        if($_POST['where_key']){
            $where[$_POST['where_key']] = $_POST['where_val'];
        }
        $filed = $_POST['field'];
        $data = M($table)->where($where)->field($filed)->group($filed)->select();
        $set = array();
        $i = 0;
        foreach($data as $item){
            $set[$i] = $item[$filed];
        }
        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $set);
        json_return($returnArr);
    }


    //微信打赏演讲人
    public function wechatReward(){
        $dataId = $_GET['data_id'];
        $user_id =  $user_id = session('userArr')['user_id'];
        $wxLogic = new WechatLogic();
      /*  $wechatPayParam = $wxLogic->genWechatReward($dataId,$user_id);*/
        $wechatPayParam = $wxLogic->genWechatReward($dataId,$user_id);
        Log::write('微信打赏：'.$wechatPayParam);
        if ($dataId) {
            $returnArr = array("result" => 1, "msg" => "生成订单成功", "code" => 200, "data" => $dataId,  "pay_param" => $wechatPayParam);
        } else {
            $returnArr = array("result" => 0, "msg" => "生成订单失败", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }
}
