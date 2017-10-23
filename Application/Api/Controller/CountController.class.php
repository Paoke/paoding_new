<?php

namespace Api\Controller;

use Think\Controller;

class CountController extends BaseRestController
{
    public function index()
    {
        //get、post的数据
        $getData = $_GET;
        $postData = $_POST;
        $getId = $_GET["id"];
        $postId = $postData["id"];
        $action = $_GET["action"];  //操作参数
        $channel = $_GET["channel"];  //操作参数
        $type = $_GET["type"];
        $isUser = $_GET["isUser"];  // 1为查询自己的文章，空则不查询
        $channel_id = M("SystemChannel")->where("call_index='$channel'")->getField("id");
        $manageUsers = D("ManageUsers");
        $manageUserRelation = D("ManageUsersRelation");
        $systemFeedbackModel = D("SystemFeedback");
        $manageUserMessageModel = D("ManageUserMessage");
        $systemChannelTableConfModel = D("SystemChannelTableConfig");
        $userId = $_SESSION["userArr"]["user_id"];
        //需要登录才能操作的
        if (!empty($userId)) {
            switch ($action) {
                case "relationNum":
                    $info = $manageUserRelation->where("from_user_id={$_SESSION["userArr"]["user_id"]}")->count();
                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);

                    break;
                case "fansNum":
                    $info = $manageUserRelation->where("to_user_id={$_SESSION["userArr"]["user_id"]}")->count();
                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
                    break;
                case "articleNum":
                    if (!empty($channel_id) && !empty($type)) {
                        $channelTableConfInfo = $systemChannelTableConfModel->checkChannel($channel, $type);
                        if ($channelTableConfInfo) {
                            //获取部分,全部文章
                            if (empty($isUser)) {
                                $info = M($channelTableConfInfo['table_format'])->where("status=0 AND is_deleted!=1")->count();
                                if ($info) {
                                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
                                } else {
                                    $returnArr = array("result" => 0, "msg" => "该频道暂未录入数据", "code" => 402);
                                }
                            } else {
                                $info = M($channelTableConfInfo['table_format'])->where("status=0 AND is_deleted!=1 AND create_user_id={$_SESSION["userArr"]["user_id"]}")->count();
                                $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
                            }
                        } else {
                            $returnArr = array("result" => 0, "msg" => "频道不存在或参数错误，请联系管理员", "code" => 402);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402);
                    }
                    break;
                case "companyNum":
                    break;
                case "likesNum":
                    break;
                case "favoritesNum":
                    break;
                case "commentNum":
                    break;
                //获取
                case "myNum":
                    if (!empty($channel_id) && !empty($type)) {
                        $channelTableConfInfo = $systemChannelTableConfModel->checkChannel($channel, $type);
                        if ($channelTableConfInfo) {
                            //获取部分,全部文章
                            $info = M($channelTableConfInfo['table_format'])->where("is_deleted!=1")->count();
                            if ($info) {
                                $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
                            } else {
                                $returnArr = array("result" => 0, "msg" => "该频道暂未录入数据", "code" => 402);
                            }
                        } else {
                            $returnArr = array("result" => 0, "msg" => "频道不存在或参数错误，请联系管理员", "code" => 402);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402);
                    }
                    break;
                default:
                    $returnArr = array("result" => 0, "msg" => "参数错误", "code" => 402);
                    break;
            }

        }
        json_return(
            $returnArr);
    }

}