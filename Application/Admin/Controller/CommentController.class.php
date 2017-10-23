<?php

namespace Admin\Controller;


use Think\AjaxPage;
use Think\Log;
use Think\Model;
use Think\Page;

class CommentController extends BaseController
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

    public function index()
    {
    }


    public function channelComment(){
        $action = $_GET["action"];
        $channelIndex = $_GET['channel'];
        $status = $_GET["status"];
        $type = $_GET['type'] == null ? "1" : $_GET['type'];
        $dataId = $_GET['data_id'];
        $COMMENT = M('CommonComment');
        switch ($action) {
            case "page_list":
                if($channelIndex && $dataId){
                    $channel = M('SystemChannel')->where("call_index='".$channelIndex."'")->find();
                    $con['A.channel_id'] = $channel['id'];
                    $con['A.data_id'] = $dataId;
                    if($status !='all') {
                        $con['A.status'] = $status;
                    }
                    $field = "A.*, B.head_pic comment_headimg, C.head_pic feedback_headimg";

                    $data = $COMMENT->alias('A')->join("LEFT JOIN __MANAGE_USERS__ B ON A.comment_user_id=B.user_id LEFT JOIN __MANAGE_USERS__ C ON A.feedback_user_id=C.user_id")->field($field)->where($con)->select();
                    $i=0;
                    foreach ($data as $value) {
                        foreach ($value as $key => $value2) {
                            if($key=="status") {
                                if($value2==-1) {
                                    $data[$i]['status']="不通过";
                                }else if($value2==0) {
                                    $data[$i]['status']="已发布";
                                }else if($value2==1) {
                                    $data[$i]['status']="待审核";
                                }
                            }else{
                                $data[$i][$key]=$data[$i][$key];
                            }
                        }
                        $i++;
                    }

                    $data = $this->commentDataTree($data);

                    $returnArr = array("result" => 1, "msg" => "请求成功!", "code" => 200, "data" => $data);
                }else{
                    $returnArr = array("result" => 0, "msg" => "请求错误，缺少必要参数", "code" => 401, "data" => null);
                }
                json_return($returnArr);

                break;

            //审核
            case "examine":
                if($channelIndex && $dataId){
                    $channel = M('SystemChannel')->where("call_index='".$channelIndex."'")->find();
                    $con['A.channel_id'] = $channel['id'];
                    $con['A.data_id'] = $dataId;
                    if($status !='all') {
                        $con['A.status'] = $status;
                    }
                    $field = "A.*, B.head_pic comment_headimg, C.head_pic feedback_headimg";

                    $data = $COMMENT->alias('A')->join("LEFT JOIN __MANAGE_USERS__ B ON A.comment_user_id=B.user_id LEFT JOIN __MANAGE_USERS__ C ON A.feedback_user_id=C.user_id")->field($field)->where($con)->select();
                    $i=0;
                    foreach ($data as $value) {
                        foreach ($value as $key => $value2) {
                            if($key=="status") {
                                if($value2==-1) {
                                    $data[$i]['status']="不通过";
                                }else if($value2==0) {
                                    $data[$i]['status']="已发布";
                                }else if($value2==1) {
                                    $data[$i]['status']="待审核";
                                }
                            }else{
                                $data[$i][$key]=$data[$i][$key];
                            }
                        }
                        $i++;
                    }

                    $data = $this->commentDataTree($data);

                    $returnArr = array("result" => 1, "msg" => "请求成功!", "code" => 200, "data" => $data);
                }else{
                    $returnArr = array("result" => 0, "msg" => "请求错误，缺少必要参数", "code" => 401, "data" => null);
                }
                json_return($returnArr);

                break;
            
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);


    }

}
