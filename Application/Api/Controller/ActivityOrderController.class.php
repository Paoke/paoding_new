<?php

namespace Api\Controller;

use Api\Logic\ChannelLogic;
use Api\Logic\UserLogic;
use Api\Logic\WechatLogic;
use Com\WxpayAPI\Lib\JsApiPay;
use Com\WxpayAPI\Lib\WxPayApi;
use Com\WxpayAPI\Lib\WxPayUnifiedOrder;
use Com\WxpayAPI\Lib\WxRedPackOrder;
use Common\Util\WxPayConfig;
use Think\Log;

/**
 * 活动报名,订单详情
 **/
class ActivityOrderController extends BaseRestController
{
    /*public function index()
    {
        $getData = $_GET;
        $postData = $_POST;
        $getAction = $_GET["action"];  //操作参数
        $getSelfUserId = $_SESSION["userArr"]["user_id"];  //自身的用户id
        $getSelfUserName = $_SESSION["userArr"]["mobile"];  //自身的用户名
        $getOrderUserId = $_GET["id"];  //别人的用户id
        $getDataId = $_GET["id"];  //id
        $getPanduanJoinActivity = $_GET["panduan_join_activity"]; //表示不执行报只查询是否已报名
        $join_end = $_GET["join_end"]; //join_end/1已报名且活动时间没有结束，2已报名且活动时间已经结束
        $getOrderStatus = $_GET["order_sta"]; //订单状态
        $getOrderUserName = "";  //自身的用户名
        $type = $_GET["type"];  //频道获取类型，1，内容，2，栏目
        $listType = $_GET["listType"];  //文章收藏，点赞，评论获取类型，1，文章的收藏，点赞，评论，2，用户的收藏，点赞，评论||PC端页面获取数据，1，侧边菜单数据，2，具体数据
        $category_id = $_GET['category_id'];//获取栏目分类id
        $orderId = $_GET['order_id'];//订单id
        $data_id = $_GET["data_id"];//文章id,活动id
        $top = $_GET["top"];  //文章收藏，点赞，评论获取的前几条数据
        $getChannel = $_GET["channel"];  //频道别名
        $channel_id = M("SystemChannel")->where("call_index='$getChannel'")->getField("id");  //频道id
        $getChannelId = $_GET["channel_id"];
        $activity = new ActivityLogic();
        //登录用户享有的所有操作
        if (!empty($getSelfUserId)) {
            switch ($getAction) {

                //活动报名功能
                case "join":
                    if ($getSelfUserId) {
                        if($getPanduanJoinActivity == 1) {
                            $ifJoin = M("ActivityOrder")->where("user_id='$getSelfUserId' AND activity_id='$data_id' AND channel_id='$channel_id'")->getField("order_id");
                        } else {
                            $postData = I("post.");
                            $ifJoin = M("ActivityOrder")->where("user_id='$getSelfUserId' AND activity_id='$data_id' AND channel_id='$channel_id'")->getField("order_id");
                            $orderType = M("SystemChannel")->where("call_index='$getChannel'")->getField("order_type");
                            if($ifJoin == NULL) {
                                //  $goods_price = M("$tableName")->where("id='$data_id'")->getField("cost");
                                $user = M("ManageUsers")->where("user_id='$getSelfUserId'")->find();
                                $order_sn= get_rand_str(9,1,1);
                                $data["user_id"] = $getSelfUserId;
                                $data["order_sn"] = $order_sn;
                                $data["mobile"] =$user["mobile"] ;
                                $data["email"] =$user["email"] ;
                                //   $data["goods_price"] =$goods_price ;

                                $data["channel_id"] =$channel_id ;
                                $data["activity_id"] =$data_id ;
                                $data["add_time"] = date("Y-m-d H:i:s", time());
                                $info = M("ActivityOrder")->add($data);
                                if($orderType == 1) {
                                    $orderId = M("ActivityOrder")->where("user_id='$getSelfUserId' AND activity_id='$data_id' AND channel_id='$channel_id'")->getField("order_id");
                                    $extendData["order_id"] = $orderId;
                                    $extendData["type_id"] = $orderType;
                                    $extendData["sign_name"] = $postData["sign_name"];
                                    $extendData["phone_number"] = $postData["phone_number"];
                                    M("ActivityOrderExtend")->add($extendData);
                                }
                            }
                        }

                        
                        if ($info) {
                            $returnArr = array("result" => 1, "msg" => "报名成功", "code" => 200, "data" => 1);
                        } else if($ifJoin){
                            $returnArr = array("result" => 0, "msg" => "已经报名", "code" => 402, "data" => null);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                    }

                    break;
                //订单列表
                case "order_list":
                   
                    if ($getSelfUserId) {
                        $getProm = M("ActivityOrder")->field("order_id,activity_id")->where("user_id='$getSelfUserId' AND order_status='$getOrderStatus'")->select();
                        foreach ($getProm as $item => $value) {
                            $con[] = $value["activity_id"];
                            $con_ord[] = $value["order_id"];
                        }
                        $i =0;
                        $tableName = parent::getTableName($getChannel,$type);//通过channel和type获取表名
                        foreach ($con as $item => $value) {
                            $info[] = M("$tableName")->where("id='$value'")->select()[0];
                            $info[$i]["order_id"] = $con_ord[$i];
                            $info[$i]["join_count"] = M("ActivityOrder")->where("activity_id='$value'")->count();
                            $i++;
                        }
                        if ($info) {
                            $returnArr = array("result" => 1, "msg" => "获取列表成功", "code" => 200, "data" => $info);
                        } else {
                            $returnArr = array("result" => 0, "msg" => "暂无数据", "code" => 402, "data" => null);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                    }
                    break;
                //已经报了名活动时间没有结束和结束的活动
                case "join_end_activity":
                    if ($getSelfUserId) {
                        $getProm = M("ActivityOrder")->field("order_id,activity_id")->where("user_id='$getSelfUserId' AND order_status='$getOrderStatus'")->select();
                        foreach ($getProm as $item => $value) {
                            $con[] = $value["activity_id"];
                        }
                        $nowTime = time();
                        $i =0;
                        $tableName = parent::getTableName($getChannel,$type);//通过channel和type获取表名
                        if($join_end == 1) {
                            foreach ($con as $item => $value) {
                                $info[$i] = M("$tableName")->where("id='$value' AND '$nowTime'<unix_timestamp(formal_end_time)")->select()[0];
                                if( $info[$i] !=null) {
                                    $info[$i]["join_count"] = M("ActivityOrder")->where("activity_id='$value'")->count();
                                }

                                $i++;
                            }
                        } else if($join_end == 2) {
                            foreach ($con as $item => $value) {
                                $info[$i] = M("$tableName")->where("id='$value' AND '$nowTime'>unix_timestamp(formal_end_time)")->select()[0];
                                if( $info[$i] !=null) {
                                    $info[$i]["join_count"] = M("ActivityOrder")->where("activity_id='$value'")->count();
                                }

                                $i++;
                            }
                        }

                        $info = array_filter($info);
                        if ($info) {
                            $returnArr = array("result" => 1, "msg" => "获取列表成功", "code" => 200, "data" => $info);
                        } else {
                            $returnArr = array("result" => 0, "msg" => "暂无数据", "code" => 402, "data" => null);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                    }
                    break;
                //取消订单
                case "del_order":

                if ($getSelfUserId) {
                    $info = M("ActivityOrder")->where("user_id='$getSelfUserId' AND order_id='$orderId'")->setField("order_status", 4);
                    if ($info) {
                        $returnArr = array("result" => 1, "msg" => "取消订单成功", "code" => 200, "data" => null);
                    } else {
                        $returnArr = array("result" => 0, "msg" => "取消订单失败", "code" => 402, "data" => null);
                    }
                } else {
                    $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                }

                break;
                //我要付款
                case "pay_order":
                    if ($getSelfUserId) {
                        $info = M("ActivityOrder")->where("user_id='$getSelfUserId' AND order_id='$orderId'")->setField("order_status", 1);
                        if ($info) {
                            $returnArr = array("result" => 1, "msg" => "确认成功", "code" => 200, "data" => null);
                        } else {
                            $returnArr = array("result" => 0, "msg" => "确认失败", "code" => 402, "data" => null);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                    }
                    break;
                //我要退款
                case "refund_order":
                    if ($getSelfUserId) {
                        $info = M("ActivityOrder")->where("user_id='$getSelfUserId' AND order_id='$orderId'")->setField("order_status", 6);
                        if ($info) {
                            $returnArr = array("result" => 1, "msg" => "确认成功", "code" => 200, "data" => null);
                        } else {
                            $returnArr = array("result" => 0, "msg" => "确认失败", "code" => 402, "data" => null);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                    }
                    break;
                //我已参加
                case "join_order":
                    if ($getSelfUserId) {
                        $info = M("ActivityOrder")->where("user_id='$getSelfUserId' AND order_id='$orderId'")->setField("order_status", 2);
                        if ($info) {
                            $returnArr = array("result" => 1, "msg" => "确认成功", "code" => 200, "data" => null);
                        } else {
                            $returnArr = array("result" => 0, "msg" => "确认失败", "code" => 402, "data" => null);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                    }
                    break;
                //我要评价
                case "evaluate_order":
                    if ($getSelfUserId) {
                        $postEvaluate = $_POST["evaluate_text"];//获取评论内容
                        $comment_user_nickname = M("ManageUsers")->where("user_id='$getSelfUserId'")->getField("nickname");  //频道id
                        $data["comment_user_id"] = $getSelfUserId;
                        $data["comment_user_nickname"] = $comment_user_nickname;
                        $data["comment_time"] = date("Y-m-d H:i:s", time());
                        $data["content"] =$postEvaluate ;
                        $data["data_id"] =$data_id ;
                        $data["channel_id"] =$getChannelId ;
                        $info = M("CommonComment")->add($data);
                        if ($info) {
                            $info1 = M("ActivityOrder")->where("user_id='$getSelfUserId' AND order_id='$orderId'")->setField("order_status", 3);
                            $returnArr = array("result" => 1, "msg" => "评论成功", "code" => 200, "data" => null);
                        } else {
                            $returnArr = array("result" => 0, "msg" => "评价失败", "code" => 402, "data" => null);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                    }
                    break;
                //查看评价
                case "see_evaluate":
                    if ($getSelfUserId) {
                        $info = M("CommonComment")->field("content,comment_user_nickname,comment_time")->where("channel_id='$getChannelId' AND data_id='$data_id'")->select();
                        $i = 0;
                        foreach ($info as $v) {
                            $i++;
                        }
                        for ($m = 0; $m < $i; $m++) {
                            $info[$m]["comment_time"] = date("Y-m-d", strtotime($info[$m]["comment_time"]));
                        }
                        if ($info) {
                            $returnArr = array("result" => 1, "msg" => "获取列表成功", "code" => 200, "data" => $info);
                        } else {
                            $returnArr = array("result" => 0, "msg" => "暂无数据", "code" => 402, "data" => null);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                    }
                    break;
                //售后/退款
                case "service_refund":
                    if ($getSelfUserId) {
                        $getProm = M("ActivityOrder")->field("order_id,activity_id,order_status")->where("user_id='$getSelfUserId' AND order_status=6 OR order_status=7 ")->select();
                        foreach ($getProm as $item => $value) {
                            $con[] = $value["activity_id"];
                            $con_ord[] = $value["order_id"];
                            $con_sta[] = $value["order_status"];
                        }
                        $i =0;
                        $tableName = parent::getTableName($getChannel,$type);//通过channel和type获取表名
                        foreach ($con as $item => $value) {
                            $info[] = M("$tableName")->where("id='$value'")->select()[0];
                            $info[$i]["order_id"] = $con_ord[$i];
                            $info[$i]["order_status"] = $con_sta[$i];
                            if( $con_sta[$i] == 6) {
                                $info[$i]["order_statusname"] = '退款中';
                            }else {
                                $info[$i]["order_statusname"] = '退款成功';
                            }
                            $i++;
                        }
                        if ($info) {
                            $returnArr = array("result" => 1, "msg" => "获取列表成功", "code" => 200, "data" => $info);
                        } else {
                            $returnArr = array("result" => 0, "msg" => "暂无数据", "code" => 402, "data" => null);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                    }
                    break;
                //其他
                default:
                    $returnArr = array("result" => 0, "msg" => "请求错误，请求参数设置有误", "code" => 402);
            }
        } else {
            //不需要登录享有的部分操作
            switch ($getAction) {

                //未登录
                default:
                    $returnArr = array("result" => 0, "msg" => "请先登录", "code" => 402);
            }
        }
        json_return($returnArr);
    }*/

    public function order(){
        $getAction = $_GET["action"];  //操作参数
        $activityId = $_GET["id"];  //
        $orderId = I("order_id");  //
        $order_status = I('order_status');

        $type = $_GET["type"];  //频道获取类型，1，内容，2，栏目
        $channel = $_GET["channel"];  //频道获取类型，1，内容，2，栏目
        $getSelfUserId = $_SESSION["userArr"]["user_id"];  //自身的用户id
        $orderTable = getTable($channel,$type);//通过channel和type获取表名
        if (!empty($getSelfUserId)) {
            switch ($getAction) {
                //订单列表
                case "order_list":
                    if ($getSelfUserId) {
                       
                        $activityTable = getTable($channel,1);
                      
                        if($order_status == 6) {
                            $getProm = M($orderTable['table_format'])->field("order_id,activity_id,order_status,total_amount")->where("user_id='$getSelfUserId' AND order_status=6 OR order_status=7 ")->select();
                        }else {
                            $getProm = M($orderTable['table_format'])->field("order_id,activity_id,order_status,total_amount")->where("user_id='$getSelfUserId' AND order_status='$order_status'")->select();
                        }
                     
                        foreach ($getProm as $item => $value) {
                            $con[] = $value["activity_id"];
                            $con_ord[] = $value["order_id"];
                            $orderStatus[] = $value["order_status"];
                            $cost[] = $value['total_amount'];
                        }
                        $i =0;
                        foreach ($con as $item => $value) {
                            $where['id'] = $value;
                            $where['status'] = 0;
                            $where['is_active'] = 1;
                            $activity = M($activityTable['table_format'])->where($where)->find();

                            if($activity){
                                $info[] = $activity;
                                $info[$i]["order_status"] = $orderStatus[$i];
                                $info[$i]["order_id"] = $con_ord[$i];
                                $info[$i]['cost'] = $cost[$i];
                                $info[$i]['activity_id'] = $value;
                                $info[$i]["join_count"] = M($orderTable['table_format'])->where("activity_id='$value'")->count();
                                $i++;
                            }
                        }
                        if ($info) {
                            $returnArr = array("result" => 1, "msg" => "获取列表成功", "code" => 200, "data" => $info);
                        } else {
                            $returnArr = array("result" => 0, "msg" => "暂无数据", "code" => 402, "data" => null);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "请先登录", "code" => 666);
                    }
                    break;
                case "order_info":

                    if($_GET['id']){

                        $info = $this->orderInfo($channel, $type, $_GET['id']);
                        if($info === false){
                            $returnArr = array("result" => 0, "msg" => "获取数据出错", "code" => 402, "data" => null);
                        }else{
                            $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $info);
                        }

                    }else{
                        $returnArr = array("result" => 0, "msg" => "参数错误", "code" => 402, "data" => null);
                    }



                    break;
                //修改订单状态订单
                case "edit_order":
                    if ($getSelfUserId) {
                        //订单状态
                        $info = M($orderTable['table_format'])->where("user_id='$getSelfUserId' AND order_id='$orderId'")->setField("order_status", $order_status);
                        if ($info) {
                            $returnArr = array("result" => 1, "msg" => "操作成功", "code" => 200, "data" => null);
                        } else {
                            $returnArr = array("result" => 0, "msg" => "操作失败", "code" => 402, "data" => null);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                    }

                    break;
                case "update":
                    if ($getSelfUserId) {
                        $data = I('post.');
                        $where['order_id'] = $data['order_id'];
                        $logic = new ChannelLogic();
                        $logic->setTable($channel, $type);
                        $info = $logic->updateData($where, $data);

                        //更新订单
                        if ($info) {
                            $returnArr = array("result" => 1, "msg" => "操作成功", "code" => 200, "data" => null);
                        } else {
                            $returnArr = array("result" => 0, "msg" => "操作失败", "code" => 402, "data" => null);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                    }
                    break;
                //常规报名
                case "applycommon":
                    if($getSelfUserId){
                        $data=I("post.");
                        $into = M("ActivityHd")->where("id=".$data['activity_id'])->find();
                        $info=array(
                            "name"=>$data['name'],
                            "mobile"=>$data['mobile'],
                            "activity_id"=>$data['activity_id'],
                            "status"=>$data['status'],
                            "activity_name"=>$into['title'],
                            "add_time" => date("Y-m-d H:i:s", time()),
                            "user_id"=>$getSelfUserId,
                            "order_status"=>$data['status'],
                            "activity_user_id"=>$getSelfUserId,
                            "channel_id"=>$data['channel_id']
                        );
                        $activityName = M("ActivityOrderHd")->add($info);
                        if($activityName){
                            $returnArr = array("result" => 1, "msg" => "报名成功", "code" => 200, "data" => $activityName);
                        }else {
                            $returnArr = array("result" => 0, "msg" => "报名失败", "code" => 402, "data" => null);
                        }

                    }else {
                        $returnArr = array("result" => 0, "msg" => "请先登录", "code" => 666);
                    }
                    break;
                //医信报名
                case "apply":
                    if ($getSelfUserId) {
                        $data = I('post.');
                        $zs_data = $data['zs_data'];
                        $activityName = M("ActivityHygl")->where("id='$activityId'")->getField("title");
                        $houseEat = array(
                            'user_id' => $getSelfUserId,
                            'activity_id'=>$activityId,
                            'activity_name'=>$activityName,
                            'create_time' => date("Y-m-d H:i:s", time()),
                        );
                        foreach ($zs_data as $value) {
                            $houseEat['name'] = "住宿时间";
                            $houseEat['value'] = $value;
                            $houseEat['type'] = 0;
                            M("ActivityHouseEat")->add($houseEat);
                        }
                        $yc_data = $data['yc_data'];
                        foreach ($yc_data as $value) {
                            $houseEat['name'] = "用餐时间";
                            $houseEat['value'] = $value;
                            $houseEat['type'] = 1;
                            M("ActivityHouseEat")->add($houseEat);
                        }
                        $info = $this->apply($channel, $type, $_GET['id'], $data);
                        $needPay = $_POST['need_pay'];
                        if($info && $needPay == true){
                            $wxLogic = new WechatLogic();
                           /* $wechatPayParam = $wxLogic->genWechatPayOrder($channel, $type, $info);*/
                            $wechatPayParam = $wxLogic->genWechatPayOrder($channel, $type, $info);
                        }
                        if ($info) {
                            $returnArr = array("result" => 1, "msg" => "生成订单成功", "code" => 200, "data" => $info,  "pay_param" => $wechatPayParam);
                        } else {
                            $returnArr = array("result" => 0, "msg" => "生成订单失败", "code" => 402, "data" => null);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "请先登录", "code" => 666);
                    }
                    break;
                //录入个人信息
                case "Input_information":
                    if($getSelfUserId){
                       $data=I("post.");
                        $where['user_id']=$getSelfUserId;
                        $where['activity_id']=$data['activity_id'];
                        $info=M($orderTable['table_format'])->where($where)->save($data);
                        if($info){
                            $returnArr = array("result" => 1, "msg" => "录入成功", "code" => 200, "data" => null);
                        }else {
                            $returnArr = array("result" => 0, "msg" => "录入失败", "code" => 402, "data" => null);
                        }
                    }
                    break;
                //支付订单
                case "pay":
                    if ($getSelfUserId) {
                        $orderId = $_POST['order_id'];
                        $wxLogic = new WechatLogic();
                       /* $info = $wxLogic->genWechatPayOrder($channel, $type, $orderId);*/
                        $info = $wxLogic->genWechatPayOrder($channel, $type, $orderId);
                       /* Log::write('微信支付pay：'.$info);*/
                        if ($info) {
                            $returnArr = array("result" => 1, "msg" => "生成支付订单成功", "code" => 200, "data" => $info);
                        } else {
                            $returnArr = array("result" => 0, "msg" => "生成支付订单失败,请稍后再试", "code" => 402, "data" => null);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "请先登录", "code" => 666);
                    }
                    break;

                //我要评价
                case "evaluate_order":
                    if ($getSelfUserId) {
                        $postEvaluate = $_POST['txtContent'];//获取评论内容
                        $comment_user_nickname = M("ManageUsers")->where("user_id='$getSelfUserId'")->getField("nickname");  //频道id
                        $data["comment_user_id"] = $getSelfUserId;
                        $data["comment_user_nickname"] = $comment_user_nickname;
                        $data["comment_time"] = date("Y-m-d H:i:s", time());
                        $data["comment_level"] = $_GET['comment_level'];
                        $data["content"] = $postEvaluate ;
                        $data["data_id"] = $activityId ;
                        $data["channel_id"] = $orderTable['channel_id'];
                        $info = M("CommonComment")->add($data);
                        if ($info) {
                            $info1 = M($orderTable['table_format'])->where(" order_id='{$_GET['order_id']}'")->setField("order_status", 3);
                            $returnArr = array("result" => 1, "msg" => "评论成功", "code" => 200, "data" => null);
                        } else {
                            $returnArr = array("result" => 0, "msg" => "评价失败", "code" => 402, "data" => null);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "请先登录", "code" => 666);
                    }
                    break;
                //查看评价
                case "see_evaluate":
                    if ($getSelfUserId) {
                        $info = M("CommonComment")->field("content,comment_user_nickname,comment_time")->where("channel_id='$getChannelId' AND data_id='$data_id'")->select();
                        $i = 0;
                        foreach ($info as $v) {
                            $i++;
                        }
                        for ($m = 0; $m < $i; $m++) {
                            $info[$m]["comment_time"] = date("Y-m-d", strtotime($info[$m]["comment_time"]));
                        }
                        if ($info) {
                            $returnArr = array("result" => 1, "msg" => "获取列表成功", "code" => 200, "data" => $info);
                        } else {
                            $returnArr = array("result" => 0, "msg" => "暂无数据", "code" => 402, "data" => null);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "请先登录", "code" => 666);
                    }
                    break;

                case "sign": //签到
                    $userId = I('user_id');
                    $dataId = I('data_id');
                    $logic = new ChannelLogic();
                    $where['user_id'] = $userId;
                    $where['activity_id'] = $dataId;
                    $info = $logic->getOrder($channel, $type, $where);

                    $flag = $this->sign($channel, $type, $dataId, $userId);
                    $info['sign_status'] = $flag;
                    if ($info) {
                        //未签到且返现金额>0才返现
                        if($flag === 1 && $info['discount']>0 ){
                            //发放现金红包返现
                            $wxLogic = new WechatLogic();
                            $wxLogic->sendRedPack($info, $userId);
                        }
                        $returnArr = array("result" => 1, "msg" => "获取列表成功", "code" => 200, "data" => $info);

                    } else {
                        $returnArr = array("result" => 0, "msg" => "暂无数据", "code" => 405, "data" => null);
                    }
                    break;

                case "answer": //问卷调查返还红包
                    $activityId = I('activity_id');
                    $companyId = I('company_id');
                    Log::write("问卷调查返还红包,activityId[".$activityId."], companyId[".$companyId."]");
                    $logic = new ChannelLogic();
                    $where['user_id'] = $getSelfUserId;
                    $where['activity_id'] = $activityId;
                    $order = $logic->getOrder($channel, 3, $where);

                    if ($order) {
                        $random = $this->getRandomRedPack($channel,$activityId);
                        $order['discount'] = $random;

                        $topic = M('TestWeifan')->where('id='.$companyId)->find();

                        //发放现金红包返现
                        $wxLogic = new WechatLogic();
                        $flag = $wxLogic->answerRedPack($order, $topic['title'], $getSelfUserId);
                        if($flag){
                            $returnArr = array("result" => 1, "msg" => "问卷调查返现成功!", "code" => 200, "data" => null);
                        }else{
                            $returnArr = array("result" => 0, "msg" => "问卷调查返还红包失败!", "code" => 777, "data" => null);
                        }


                    } else {
                        $returnArr = array("result" => 0, "msg" => "暂无数据", "code" => 405, "data" => null);
                    }
                    break;

                //其他
                default:
                    $returnArr = array("result" => 0, "msg" => "请求错误，请求参数设置有误", "code" => 402);
            }
        } else {
            //不需要登录享有的部分操作
            switch ($getAction) {

                //未登录
                default:
                    $returnArr = array("result" => 0, "msg" => "请先登录", "code" => 404);
            }
        }
        json_return($returnArr);
    }

    private function getRandomRedPack($channel, $activityId){
        $table = getTableStr($channel, 1, 'table_format');
        $activity = M($table)->where('id='.$activityId)->find();
        if($activity['zdds'] && $activity['zgds']){
            $min = $activity['zdds'];
            $max = $activity['zgds'];
        }else{
            $min = 1;
            $max = 10;
        }
        $money = rand($min, $max);
        return $money;
    }

    /*
     * 签到
     * **/
    private function sign($channel, $type, $dataId, $userId){


        $where['user_id'] = $userId;
        $where['activity_id'] = $dataId;
        $logic = new ChannelLogic();
        $logic->setTable($channel, $type);
        $order = $logic->getOrder($channel, $type, $where);

        if(!$order){
            return -1; //该用户没有参加当前频道的活动
        }
        if($order['sign_status'] == 1){
            return -2;
        }
        $data = array(
            'sign_status' => 1,
            'order_status' => 2 //如果会议签到了，订单算已参与了
        );
        $where['order_id'] = $order['order_id'];
        $flag = $logic->updateData($where, $data);

        if($flag === false){
            return -3; //签名(更新状态)失败
        }
        return 1;
    }

    /*
     * 获取订单详情
     * **/
    private function orderInfo($channel, $type, $id){
        $orderTable = $this->getTableName($channel, $type);
        $activityTable = getTable($channel, 1)['table_name'];
        $where['A.order_id'] = $id;
        $info = M("$orderTable")->alias('A')
                        ->join("LEFT JOIN $activityTable B ON A.activity_id=B.id")
                        ->where($where)
                        ->select();

        return $info;
    }

    private function apply($channel, $type, $activityId, $data) {

        $getSelfUserId = $_SESSION["userArr"]["user_id"];  //自身的用户id
        $orderTable = getTable($channel, $type);
        $activityTable = getTable($channel,1);
        //$order_sn，订单编号，随机字符串
        $order_sn= get_rand_str(9,1,1);
        $user = M("ManageUsers")->where("user_id='$getSelfUserId'")->find();
        $activityData = M($activityTable['table_format'])
            ->where("id = ".$activityId)
            ->find();
        $data["user_id"] = $getSelfUserId;
        $data["order_sn"] = $order_sn;
        $data["mobile"] = $data['mobile'] ? $data['mobile'] : $user["mobile"] ;
        $data["email"] = $data['email'] ? $data['email'] : $user["email"] ;
        $data["name"] = $data['name'] ? $data['name'] : $user["nickname"] ;
        $data["activity_id"] = $activityId;
        $data["activity_name"] = $activityData['title'] ;
        $data["goods_price"] = $activityData['cost'];
        $data["goods_num"] = 1;
        $data["activity_user_id"] = $activityData['create_user_id'];
        $data["channel_id"] =$orderTable['channel_id'] ;
        $data["order_status"] = $data['status'] ? $data['status'] : 0;
        $data["pay_status"] = $data['status'] ? $data['status'] : 0;
        $data["add_time"] = date("Y-m-d H:i:s", time());

        $ticketId = $data['ticket_cat_id'];
        if($ticketId){
            $ticketTable = getTableStr($channel, 6, 'table_format');
            $ticket = M($ticketTable)->where('id='.$ticketId)->find();

            $price = $ticket['ticket_price'];
            $data['goods_price'] = $price;
            $data['order_amount'] = $price;
            $data['total_amount'] = $price;

            //计算签到返现
            $ratio = $ticket['ticket_return_ratio'] * 0.01; //折扣
            $discount = $price * $ratio;//返现金额
            $data['discount'] = $discount;

        }
        $info = M($orderTable['table_format'])->add($data);
        if($info){
            $unfiyOrder['channel'] = $channel;
            $unfiyOrder['type'] = $type;
            $unfiyOrder['order_id'] = $info;
            $unfiyOrder['order_sn'] = $order_sn;
            M('CommonUnifyOrder')->add($unfiyOrder);
        }
        return $info;
    }






    //递归函数
    public function diff($id = 0, &$array = array())
    {
        $info = M("ActivityCategory")->where("id = $id")->find();
        if ($info) {
            $array[] = $info;
            $this->diff($info["parent_id"], $array);
        }
        return $array;
    }

}
