<?php

namespace Admin\Controller;

use Admin\Logic\ExtendLogic;
use Admin\Logic\SystemExtendAttributeLogic;
use Admin\Util\GetFirstCharterUtil;
use Think\Log;

class ActivityController extends BaseController
{
    /**
     * 析构函数，判断权限等
     */
    public function __construct()
    {
        parent::__construct();
       /* $act = ACTION_NAME; //哪个方法
        $action = $_GET["action"];//action/page_list
        $check = array('page_list', 'page_add', 'page_edit','del');
        $checkAction = array('activity');
        if(in_array($act,$checkAction) && in_array($action,$check)) {
            $res = parent::checkRole();
            if ($res["result"] != 1) {
                $this->error("您的账号没有操作权限");
            }
        }*/
    }

    /**
     * 内容管理 - 入口函数
     * page_list，page_info 页面显示
     * page_add，page_edit 编辑页面显示
     * add，edit,del，编辑入口
     */
    public function activity()
    {
        $action = $_GET["action"];//action/page_list
        $getId = $_GET["id"];
        $channel = $_GET["channel"];//channel/activity_info
        $categoryId = $_GET["category_id"];
        //在SystemChannel表中根据传来的channel名字activity_info找到相应的id（每一个channel别名都有一个唯一的ID）
        $moduleType = $_GET['type'];
        $tableConfigId = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("id");
        $systemChannel = M("SystemChannel")->field("id,is_export_data")->where("call_index='$channel'")->find();
        $tableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("table_format");
        $channelId = M("SystemChannel")->where("call_index='$channel'")->getField("id");
        // $tableName2 = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("table_name");
        $tags = M("SystemChannelTableConfig")->where("channel='$channel' AND type=4")->getField("table_name");
        $relation=M("SystemChannelTableConfig")->where("channel='$channel' AND type=5")->getField("table_name");
        $systemChannelFormField = M("SystemChannelFormField");
        $categoryTableName =  M("SystemChannelTableConfig")->where("channel='$channel' AND type='2'")->getField("table_format");
        if($categoryId>0){
            $categoryName = M("$categoryTableName") ->where("id = '$categoryId'")->getField("cat_name");
        }

        //判断是否设置参数
        switch ($action) {
            case "page_list":
                $data['call_index']=$channel;
                $lead=M("SystemChannel")->where($data)->field("is_import_data,is_export_data,is_copy")->select();
                $this->assign("lead",$lead);
                $condition['table_config_id'] = $tableConfigId;
                $condition['show_list'] = 1;
                // $condition['table_name'] =$tableName2;
                $infoField = $systemChannelFormField->field("title,name,form_type")->where($condition)->order('admin_sort')->select();
                foreach ($infoField as $item => $value) {
                    $pageListData[] = $value['name'];
                }
                $pageListTypeData[0] = 'text';
                foreach ($infoField as $item => $value) {
                    $pageListTypeData[] = $value['form_type'];
                }
                $where['A.is_deleted']=0;
                if($categoryId>0) {
                    $where['A.category_id']=$categoryId;
                }
                $pageListData1 = implode(",", $pageListData);
                $gotPage=I("gotPage");

                $pageListDataShow =  M("$tableName")
                    ->join("AS A LEFT JOIN $relation AS B ON A.id=B.data_id")
                    ->field("A.id,$pageListData1,A.status,A.is_active")
                    ->where($where)
                    ->order("id desc")
                    ->select();

                $i = 0;
                foreach ($pageListDataShow as $value) {
                    $m = 0;
                    foreach ($value as $key => $value2) {
                        if ($key == "status") {
                            if ($value2 == -1) {
                                $pageListDataTypeShow[$i]['status'] = array('data' => "不通过", 'type' => "text");
                            } else if ($value2 == 0) {
                                $pageListDataTypeShow[$i]['status'] = array('data' => "已发布", 'type' => "text");
                            } else if ($value2 == 1) {
                                $pageListDataTypeShow[$i]['status'] = array('data' => "待审核", 'type' => "text");
                            }
                        } else {
                            $pageListDataTypeShow[$i][$key] = array('data' => $value2, 'type' => $pageListTypeData[$m]);
                        }
                        $m++;
                    }
                    $i++;
                }
                if (!empty($tableConfigId)) {
                    $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                    $page_now = I('get.page_now', 1);   //$page_now 第几页
                    $infowhere['is_deleted']=0;
                    if($categoryId>0) {
                        $infowhere['category_id']=$categoryId;
                    }
                    if($gotPage){
                        $page_now=$gotPage;
                    }
                    $countTable = M("$tableName")->where($infowhere);
                    $count=$countTable->count();
                    //$count    总共有多少条数据
                    $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                    $channel_id = M("$tableName")->getField("channel_id");
                    $this->assign('count', $count);
                    $this->assign("category_id",$categoryId);
                    $this->assign("category_name",$categoryName);
                    $this->assign('page', $page);
                    $this->assign('page_num', $page_num);
                    $this->assign('page_now', $page_now);
                    $this->assign("info", $pageListDataTypeShow);
                    $this->assign("is_export_data", $systemChannel['is_export_data']);
                    $this->assign('tableName', $tableName);
                  
                    $this->assign("info_field", $infoField);
                    $this->assign("channel", $channel);
                    $this->assign("type", $moduleType);
                    $this->display("activity_list");
                    $this->logRecord(6, "查看数据",2, $channel_id, $getId);
                } else {
                    $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                }
                break;
            case "page_add":
                if ($channel) {
                    $this->assign("channel", $channel);
                    $this->assign("type", $moduleType);
                    $categoryTableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type=2")->getField("table_format");
                    $categoryData = M("$categoryTableName")->field('id, cat_name')->where('is_deleted=0')->order('sort_num')->select();
                    $tagsTableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type=4")->getField("table_format");
                    $tagsInfo = M("$tagsTableName")->field("id,tag_name")->where("status = 1 AND is_deleted!=1")->select();

                    if($tagsInfo) {
                        $ifTags = 1;
                    } else {
                        $ifTags = 0;
                    }
                    //判断是否是否需要绑定用户
                    $is_bind_user = M("SystemChannel")->where("call_index='$channel'")->getField("is_bind_user");
                    $this->assign('is_bind_user', $is_bind_user);
                    //判断是否是否需要绑定用户
                    $this->assign("tags_info", $tagsInfo);
                    $this->assign("if_tags", $ifTags);
                    //判断是否需要开启置顶
                    $is_top = M("SystemChannel")->where("call_index='$channel'")->getField("is_top");
                    $this->assign('is_top', $is_top);

                    //$this->assign('currentUser', $userName);
                    $this->assign('currentDate', date("Y-m-d"));
                    $this->assign('category_data', $categoryData);
                    $this->display("activity_info");

                } else {
                    $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                }
                break;
            case "page_edit":
                if ($channel) {
                    if ($getId) {
                        $date['data_id']=$getId;
                        $lead=M("Activity_".$channel."ViewRecord")->where($date)->field("data_id")->count();

                        $infoField = $systemChannelFormField->field("title,name")->where("table_config_id='$tableConfigId'")->order('admin_sort')->select();
                        $channel_id = M("$tableName")->getField("channel_id");

                        $systemLog = M("SystemLog")->field("log_id,admin_id,admin_user_name,log_time,log_info,log_ip")->where("channel_id='$channel_id' AND data_id='$getId' AND operate_type!=4")->select();
                        foreach ($infoField as $item => $value) {
                            $pageListData[] = $value['name'];
                        }
                        $pageListData1 = implode(",", $pageListData);

                        $condition['id'] = $getId;
                        $condition['is_deleted'] = 0;
                        $pageListDataShow = M("$tableName")->field("id,is_red,is_hot,$pageListData1")->where($condition)->find();

                        $data = $pageListDataShow;

                        $activity = M("$tableName")->where($condition)->find();
                        $categoryTableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type=2")->getField("table_format");
                        $categoryData = M("$categoryTableName")->field('id, cat_name')->where('is_deleted=0')->order('sort_num')->select();

                        //报名管理
                        $condition = array();
                        $condition['channel_id'] = $channel_id;
                        $condition['activity_id'] = $getId;
                        $orderTableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type=3")->getField("table_format");
                        $orderCount = M("$orderTableName")->where('hd_id='.$getId)->count();
                        $orderList = M("$orderTableName")->where('hd_id='.$getId)->page(1,10)->select();

                        $orderPage = ($orderCount/10) > intval(($orderCount/10)) ? intval(($orderCount/10))+1 : intval(($orderCount/10));
                        $countArr['page_count'] = $orderPage;

//                        // 提交报名
//                        $countArr['submit_apply'] = M("$orderTableName")->where($condition)->count();
//
//                        // 待审核
//                        $cond = $condition;
//                        $cond['order_status'] = -1;
//                        $countArr['wait_audit'] = M("$orderTableName")->where($cond)->count();
//
//                        // 报名人数
//                        $cond = $condition;
//                        $cond['order_status'] = 1;
//                        $countArr['apply_success'] = M("$orderTableName")->where($cond)->count();
//
//                        // 已取消
//                        $cond = $condition;
//                        $cond['order_status'] = 4;
//                        $countArr['cancel'] = M("$orderTableName")->where($cond)->count();
//
//                        // 不通过(作废)
//                        $cond = $condition;
//                        $cond['order_status'] = 5;
//                        $countArr['not_pass'] = M("$orderTableName")->where($cond)->count();
//
//                        // 待支付
//                        $cond = $condition;
//                        $cond['pay_status'] = 0;
//                        $countArr['not_pay'] = M("$orderTableName")->where($cond)->count();
//
//                        //活动收入
//                        $cond = $condition;
//                        $cond['pay_status'] = 1;
//                        $countArr['total_amount'] = M("$orderTableName")->where($cond)->sum('total_amount');
//                        if(empty($countArr['total_amount'])){
//                            $countArr['total_amount'] = '0.00';
//                        }
//
//                        // 已签到
//                        $cond = $condition;
//                        $cond['sign_status'] = 1;
//                        $countArr['sign_success'] = M("$orderTableName")->where($cond)->count();
//
//                        // 未签到
//                        $cond = $condition;
//                        $cond['sign_status'] = 0;
//                        $cond['pay_status'] = 1;
//                        $cond['order_status'] = 1;
//                        if($countArr['should_sign'] === 0){
//                            $countArr['not_sign'] = 0;
//                        }else{
//                            $countArr['not_sign'] = M("$orderTableName")->where($cond)->count();
//                        }
//
//                        // 应签到 = 未签到 + 已签到
//                        $countArr['should_sign'] = $countArr['not_sign'] + $countArr['sign_success'];

                        $tagsTableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type=4")->getField("table_format");
                        $tagsRelationTableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type=5")->getField("table_format");
                        $tagsInfo = M("$tagsTableName")->field("id,tag_name")->where("status = 1 AND is_deleted!=1")->select();
                        $tagsRelationInfo = M("$tagsRelationTableName")->field("tag_id ")->where("channel_id = {$systemChannel['id']} AND data_id = '$getId'")->select();
                        $trInfo = array();
                        foreach ($tagsRelationInfo as $value) {
                            $i = 0;
                            foreach ($tagsInfo as $value1) {
                                if($value1['id'] == $value['tag_id'] ) {
                                    $trInfo[$i] = $value1;
                                    $trInfo[$i]['checked'] = 1;
                                } else if ($trInfo[$i]['checked']!=1) {
                                    $trInfo[$i] = $value1;
                                }
                                $i++;
                            }
                        }
                        if($trInfo == null) {
                            $trInfo = $tagsInfo;
                        }

                        if($tagsInfo) {
                            $ifTags = 1;
                        } else {
                            $ifTags = 0;
                        }

                        //判断是否是否需要绑定用户
//                        $is_bind_user = M("SystemChannel")->where("call_index='$channel'")->getField("is_bind_user");
//                        $this->assign('is_bind_user', $is_bind_user);
                        $pageNow = $_GET["page_now"];
                        $pageNum = $_GET['page_num'];
                        $this->assign('page_now', $pageNow);
                        $this->assign("page_num",$pageNum);
                        //判断是否需要开启置顶
                        $is_top = M("SystemChannel")->where("call_index='$channel'")->getField("is_top");
                        $this->assign('is_top', $is_top);

                        //子表
                        $conf['channel_index'] = $channel;
                        $child = M('SystemChannelChild')->field('id,title,channel_index, type, has_relation')->where($conf)->select();
                        $this->assign('child', $child);

                        $this->assign("lead",$lead);
                        $this->assign('ifcheck',1);
                        $this->assign("tags_info", $trInfo);
                        $this->assign("if_tags", $ifTags);
                        $this->assign("ifadd",'b');

                        $this->assign('countArr', $countArr);
                        $this->assign('order_list', $orderList);
                        $this->assign("id", $getId);
                        $this->assign("channel", $channel);
                        $this->assign("type", $moduleType);
                        $this->assign('system_log', $systemLog);
                        $this->assign('info', $activity);
                        $this->assign("data", $data);
                        $this->assign('category_data', $categoryData);
                        $this->display("activity_info");
                    } else {
                        $returnArr = array("result" => 0, "msg" => "该数据不存在，请重试", "code" => 402, "data" => null);
                    }
                } else {
                    $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                }
                break;
            case "add":
                if ($channel) {
                    $postData = I("post.");
                    $tags = $postData['tag_name'];
                    //添加函数
                    $dataId = $this->addActivity($channel, $tableName, $postData);
                    $tagsTable = M("SystemChannelTableConfig")->where("channel='$channel' AND type='4'")->getField("table_format");
                    $tagsRelationTable = M("SystemChannelTableConfig")->where("channel='$channel' AND type='5'")->getField("table_format");
                    if ($dataId) {
                        //处理tag
                        if($tags) {
                            foreach ( $tags as $value){
                                $tagInfo = M("$tagsTable")->field("remark,tag_name")->where("id = '$value'")->find();
                                $relationData['channel_id'] = $channelId;
                                $relationData['tag_id'] = $value;
                                $relationData['data_id'] = $dataId;
                                $relationData['remark'] = $tagInfo['remark'];
                                $relationData['tag_name'] = $tagInfo['tag_name'];
                                $relationData["create_time"] = date("Y-m-d H:i:s", time());
                                M("$tagsRelationTable")->add($relationData);
                            }
                        }
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $dataid = M("$tableName")->order('id desc')->limit(0)->getField("id");
                        $channel_id = M("$tableName")->getField("channel_id");
                        //记录审核日志
                        $channelModel = M("systemChannel")->where("call_index='$channel'")->find();
                        if($channelModel['is_auto_review']==1){
                            $this->logRecord(6,"自动审核活动" . $postData["title"]. "成功",6,$channel_id,$dataid);
                        }
                        //记录操作日志
                        $this->logRecord(6, "增加活动数据" . $postData["title"],3, $channel_id, $dataid);
                        $returnArr = array("result" => 1, "msg" => "提交成功", "code" => 200, "data" => null);
                    } else {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(5, "添加活动" . $postData["title"] . "失败",3);
                        $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试！", "code" => 402, "data" => null);
                    }
                } else {
                    $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试！", "code" => 402, "data" => null);
                }
                break;
            case "edit":
                if ($channel) {
                    $recovery = $_GET["recovery"];
                    $getData = I("get.");
                    $postData = I("post.");
                    $tags = $postData['tag_name'];
                    $tagsTable = M("SystemChannelTableConfig")->where("channel='$channel' AND type='4'")->getField("table_format");
                    $tagsRelationTable = M("SystemChannelTableConfig")->where("channel='$channel' AND type='5'")->getField("table_format");
                    if ($recovery == 1) {
                        $info = $this->editTags($getData);
                    } else {
                        $info = $this->editTags($postData);
                    }

                        if ($info) {
                            if($systemChannel['id']>0 && $getId>0 ) {
                                $result = M("$tagsRelationTable")->where("channel_id = '{$systemChannel['id']}' AND data_id = '$getId'")->delete();
                            }
                            if($tags) {
                                foreach ( $tags as $value){
                                    $tagInfo = M("$tagsTable")->field("remark,tag_name")->where("id = '$value'")->find();
                                    $relationData['channel_id'] = $systemChannel['id'];
                                    $relationData['tag_id'] = $value;
                                    $relationData['data_id'] = $getId;
                                    $relationData['remark'] = $tagInfo['remark'];
                                    $relationData['tag_name'] = $tagInfo['tag_name'];
                                    $relationData["create_time"] = date("Y-m-d H:i:s", time());
                                    M("$tagsRelationTable")->add($relationData);

                                }

                            }
                            //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                            $channel_id = M("$tableName")->getField("channel_id");
                            if ($recovery == 1) {
                                $this->logRecord(6,"恢复活动". $postData["title"]."】成功",4,$channel_id,$getId);
                                $this->redirect("Admin/Activity/activity/action/recycle_page_list/channel/$channel/type/1");
                            }
                            $this->logRecord(6, "修改活动" . $postData["title"]."】成功", $channel_id,4,$channel_id,$getId);
                            $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                        } else {
                            //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                            $this->logRecord(6, "编辑活动" . $postData["title"] . "失败",4);
                            $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
                        }
                } else {
                    $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
                }
                break;
            case "del":
                if ($channel) {
                    $getId = $_GET["id"];
                    if ($getId) {
                        $tableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("table_format");
                        $logData = M("$tableName")->where("id=$getId")->find();
                        $result = M("$tableName")->where("id=$getId")->setField("is_deleted", 1);
                        if ($result) {
                            //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                            $channel_id = M("$tableName")->getField("channel_id");
                            $this->logRecord(6, "删除活动" . $logData["title"],5,$channel_id,$getId);
                            $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);
                        } else {
                            //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                            $this->logRecord(5, "删除活动" . $logData["title"] . "失败",5);
                            $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "删除失败，该活动已删除", "code" => 402, "data" => null);
                    }
                } else {
                    $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
                }
                break;
            case "remove":
                if ($channel) {
                    $getId = $_GET["id"];
                    if ($getId) {
                        $tableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("table_format");
                        $logData = M("$tableName")->where("id=$getId")->find();
                        $result = M("$tableName")->where("id=$getId")->delete();
                        if ($result === false) {
                            //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                            $this->logRecord(5, "物理删除活动" . $logData["title"] . "失败",5);
                            $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
                        } else {
                            $tagsRelationTable = M("SystemChannelTableConfig")->where("channel='$channel' AND type='5'")->getField("table_format");
                            if($systemChannel['id'] > 0) {
                                $result2 = M("$tagsRelationTable")->where("channel_id = '{$systemChannel['id']}' AND data_id = '$getId' ")->delete();
                            }
                           
                            //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                            $channel_id = M("$tableName")->getField("channel_id");
                            $this->logRecord(6, "物理删除活动" . $logData["title"],5,$channel_id,$getId);
                            $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);

                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "删除失败，该活动已删除", "code" => 402, "data" => null);
                    }
                } else {
                    $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
                }
                break;
            case "recycle_page_list":
                $condition['table_config_id'] = $tableConfigId;
                $condition['show_list'] = 1;
                // $condition['table_name'] =$tableName2;
                $infoField = $systemChannelFormField->field("title,name,form_type")->where($condition)->order('admin_sort')->select();
                foreach ($infoField as $item => $value) {
                    $pageListData[] = $value['name'];
                }
                $pageListTypeData[0] = 'text';
                foreach ($infoField as $item => $value) {
                    $pageListTypeData[] = $value['form_type'];
                }

                $pageListData1 = implode(",", $pageListData);
                $pageListDataShow = M("$tableName")
                    ->join("AS A LEFT JOIN $tags AS B ON A.channel_id=B.channel_id")
                    ->field("A.id,$pageListData1,A.status,A.is_active,group_concat(B.tag_name)")
                    ->group("id")
                    ->where("A.is_deleted=1")
                    ->select();
                $i = 0;
                foreach ($pageListDataShow as $value) {
                    $m = 0;
                    foreach ($value as $key => $value2) {
                        if ($key == "status") {
                            $pageListDataTypeShow[$i]['status'] = array('data' => "已 删 除", 'type' => "text");

                        } else {
                            $pageListDataTypeShow[$i][$key] = array('data' => $value2, 'type' => $pageListTypeData[$m]);
                        }

                        $m++;
                    }
                    $i++;
                }
                if (!empty($tableConfigId)) {
                    $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                    $page_now = I('get.page_now', 1);   //$page_now 第几页
                    $countTable = M("$tableName")->where("is_deleted=0")->select();
                    $count = 0;
                    foreach ($countTable as $value) {
                        $count++;
                    }
                    //$count    总共有多少条数据
                    $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                    $channel_id = M("$tableName")->getField("channel_id");
                    $this->assign('count', $count);
                    $this->assign('page', $page);
                    $this->assign('page_num', $page_num);
                    $this->assign('page_now', $page_now);
                    $this->assign("info", $pageListDataTypeShow);
                    $this->assign("info_field", $infoField);
                    $this->assign("channel", $channel);
                    $this->assign("type", $moduleType);
                    $this->display("activity_recycle_list");
                    $this->logRecord(6, "查看列表数据",2, $channel_id);
                } else {
                    $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
                }
                break;

            case "extends":
                if ($channel) {
                    $systemChannelFormField = M("SystemChannelFormField");
                    $files = "name,title,form_type,default_value,item_option,valid_tip_msg,valid_error_msg,valid_pattern,date_format,file_format,is_relation";

                    $condition['table_config_id'] = $tableConfigId;
                    $condition['admin_use'] = 1;

                    $extends = $systemChannelFormField->field($files)->where($condition)->order('admin_sort')->select();
                    $extendValCont = M("$tableName")->where("id='$getId' AND is_deleted=0")->find();
                    $i = 0;
                    foreach ($extends as $extend) {
                        $op = array();
                        if (!empty($extend['item_option'])) {
                            $itemStr = json_decode($extend['item_option'], true);
                        }
                        $extends[$i]['item_option'] = $itemStr;
                        $itemStr = null;
                        if (count($extendValCont) > 0) {
                            $key = $extend['name'];
                            $extends[$i]['default_value'] = $extendValCont[$key];
                        }

                        $i++;
                    }
                    $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $extends);
                    //exit(json_encode($returnArr));
                } else {
                    $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                }
                break;

            case "qrcode":
                $info = $this->gen_qrcode($channel, $moduleType, $getId);
                if ($info) {
                    $returnArr = array("result" => 1, "msg" => "生成二维码成功", "code" => 200, "data" => $info);
                } else {
                    $returnArr = array("result" => 0, "msg" => "网络繁忙，请稍后重试", "code" => 402, "data" => null);
                }
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }

    /*
   * 频道对应的审核管理
   * */
    public function examine()
    {
        //获取操作参数
        $action = $_GET["action"];
        $getId = $_GET["id"];
        //获取频道参数
        $channel = $_GET["channel"];
        $moduleType = $_GET['type'];

        //在SystemChannel表中根据传来的channel名字company_info找到相应的id（每一个channel别名都有一个唯一的ID）
        $tableConfigId = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("id");
        $channelId = M("SystemChannel")->where("call_index='$channel'")->getField("id");
        $tableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("table_format");

        $tables = M("SystemChannelTableConfig")->where("channel='$channel' AND type='1'")->getField("table_format");


        //判断是否设置参数
        switch ($action) {
            case "page_list":

                $this->assign('channel', $channel);
                $this->display("examine_list");
                break;

            case "update_status":
                if ($channel) {
                    $id = $_POST['id'];
                    $status = $_POST['status'];
                    if ($id) {
                        $tableName = $this->getTableName($channel, $moduleType);
                        $activity = M("$tableName")->where('id='.$id)->find();
                        $flag = M("$tableName")->where('id='.$id)->setField('status', $status);

                        if($flag === false){
                            $this->logRecord(6, "审核【".$activity["title"]."】失败", 9, $activity['channel_id'], $id);
                            $returnArr = array("result" => 0, "msg" => "审核失败，请重试", "code" => 405, "data" => null);
                        }else{
                            $this->logRecord(6, "审核【".$activity["title"]."】成功!", 9, $activity['channel_id'], $id);
                            $returnArr = array("result" => 1, "msg" => "审核成功", "code" => 200, "data" => null);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "审核失败，缺少参数", "code" => 402, "data" => null);
                    }
                } else {
                    $returnArr = array("result" => 0, "msg" => "审核失败，频道参数错误", "code" => 402, "data" => null);
                }
                break;

            case "record":
                $conf['call_index'] = $channel;
                $conf['is_active'] = 1;
                $channelInfo = M("SystemChannel")->where($conf)->find();

                $where['channel_id'] = $channelInfo['id'];
                $where['operate_type'] = 9;
                $page_num = I('post.page_num', 25); // ? I('get.page_num') : I('post.page_num', 10);   //$page_num 每页几条数据
                $page_now = I('post.page_now', 1);   //$page_now 第几页
                $count=M("SystemLog")->where($where)->count();
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page  总共有几页
                $record = M("SystemLog")->where($where)
                    ->page($page_now,$page_num)
                    ->field("log_info,log_time,admin_user_name,operate_type")
                    ->order('log_time desc')->select();
                $arr['page_now']=$page_now;
                $arr['page']=$page;
                if($record)  {
                    $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $record,"arr"=>$arr);
                } else {
                    $returnArr = array("result" => 0, "msg" => "该频道不存在", "code" => 402, "data" => null);
                }
                $this->assign('channel', $channel);
                break;

            case "issue":
                $data = $this->getActivityByStatus(-1, $tables);
                if($data)  {
                    $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $data);
                } else {
                    $returnArr = array("result" => 0, "msg" => "获取数据失败", "code" => 402, "data" => null);
                }
                break;

            case "info":
                $data = $this->getActivityByStatus(0, $tables);
                if($data)  {
                    $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $data);
                } else {
                    $returnArr = array("result" => 0, "msg" => "获取数据失败", "code" => 402, "data" => null);
                }
                break;

            case "audit":
                $data = $this->getActivityByStatus(1, $tables);
                if($data)  {
                    $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $data);
                } else {
                    $returnArr = array("result" => 0, "msg" => "获取数据失败", "code" => 402, "data" => null);
                }
                break;

            case "list":
                $data = $this->getActivityByStatus(false, $tables);
                if($data)  {
                    $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $data);
                } else {
                    $returnArr = array("result" => 0, "msg" => "获取数据失败", "code" => 402, "data" => null);
                }
                break;

            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法");
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }

    private function getActivityByStatus($status, $table){

        if($status !== false){
            $where['status'] = $status;
        }
        $where['is_deleted']=0;

        $page_num = I('post.page_num', 8); // ? I('get.page_num') : I('post.page_num', 10);   //$page_num 每页几条数据
        $page_now = I('post.page_now', 1);   //$page_now 第几页
        $count = M("$table")->where($where)->count();
        $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page  总共有几页

        $info = M("$table")->where($where)->page($page_now,$page_num)->field("id,title,status")->select();

        $arr['page_now'] = $page_now;
        $arr['page'] = $page;
        $arr['count'] = $count;

        $data['data'] = $info;
        $data['arr'] = $arr;

        return $data;
    }

    /*
     * 频道对应的标签
     * */
    public function tags()
    {
        //获取操作参数
        $action = $_GET["action"];
        $getId = $_GET["id"];
        //获取频道参数
        $channel = $_GET["channel"];
        $moduleType = $_GET['type'];
        //获取频道表ID
        $tableConfigId = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("id");
        $tableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("table_format");
        $systemChannelFormField = M("SystemChannelFormField");

        //判断是否设置参数
        switch ($action) {
            case "page_list":
                $keyword=trim(I("keyword"));
                if($keyword) {
                    $where["cat_name"] = array("exp", "LIKE '%$keyword%'");
                }
                $where['is_deleted']=0;
                if (!empty($tableConfigId)) {

                    $infoField =$systemChannelFormField->field("title,name,form_type")->where("table_config_id='$tableConfigId'")->order('admin_sort')->select();
                    foreach ($infoField as $item => $value) {
                        $pageListData[] = $value['name'];
                    }
                    $pageListTypeData[0]='text';
                    foreach ($infoField as $item => $value) {
                        $pageListTypeData[] = $value['form_type'];
                    }
                    $pageListData1=implode(",",$pageListData);
                    $pageListDataShow =M("$tableName")->field("id,$pageListData1,status")->where($where)->select();

                    $i=0;
                    foreach ($pageListDataShow as $value) {
                        $m =0;
                        foreach ($value as $key => $value2) {
                            $pageListDataTypeShow[$i][$key]=array('data'=>$value2,'type'=>$pageListTypeData[$m]);
                            $m++;
                            //  $pageListDataTypeShow[$i][$key]=$value2;
                        }
                        $i++;
                    }

                    //查找显示一级分类
                    $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                    $page_now = I('get.page_now', 1);   //$page_now 第几页
                    $countTable= M("$tableName")->where("is_deleted=0")->select();
                    $count=0;
                    foreach ($countTable as $value) {
                        $count++;
                    }          //$count    总共有多少条数据

                    $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                    $this->assign('count', $count);
                    $this->assign('page', $page);
                    $this->assign('page_num', $page_num);
                    $this->assign('page_now', $page_now);
                    $this->assign("info", $pageListDataTypeShow);
                    $this->assign("table_name", $tableName);
                    $this->assign("info_field", $infoField);
                    $this->assign("channel", $channel);
                    $this->assign("type", $moduleType);
                    $this->display("tag_list");
                } else {
                    $returnArr = array("result" => 0, "msg" => "该频道不存在", "code" => 402, "data" => null);
                }
                break;
            case "page_add":
                //查询分类树
                $this->assign("channel", $channel);
                $this->assign("type", $moduleType);
                $this->display("tag_info");
                break;
            case "page_edit":
                if ($getId) {
                    //找到传进来的id值的信息
                    $this->assign("id", $getId);
                    $this->assign("type", $moduleType);
                    $this->assign("channel", $channel);
                    $this->display("tag_info");
                } else {
                    $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
                }
                break;
            case "add":
                $postData = I("post.");
                $returnArr = array("result" => 0, "msg" => "标签名不能重复", "code" => 402, "data" => null);
                $where=array("tag_name = '" . $postData['tag_name'] . "'");
                if(M("$tableName")->where($where)->count()){
                    json_return($returnArr);
                }
                $info = $this->addTags($channel, $tableName, $postData);
                if ($info) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加分类" . $postData["title"] . "成功",3);
                    $returnArr = array("result" => 1, "msg" => "提交成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加分类失败，数据库录入失败",3);
                    $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
                }
                break;
            case "edit":
                $postData = I("post.");
                $returnArr = array("result" => 0, "msg" => "标签名不能重复", "code" => 402, "data" => null);
                $where=array("tag_name = '" . $postData['tag_name'] . "'");
                if(M("$tableName")->where($where)->count()){
                    json_return($returnArr);
                }
                //设置表单不能为空
                //进入编辑函数
                $info = $this->editCategory($postData);
                if ($info) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "编辑活动分类" . $postData["title"] . "成功",4);
                    $returnArr = array("result" => 1, "msg" => "提交成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5, "编辑活动分类" . $postData["title"] . "失败",4);
                    $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
                }

                break;
            case "del":
                //查找删除的id是否有子级
                if ($getId) {
                    $tableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("table_format");
                    $returnArr = array("result" => 0, "msg" => "此分类下有子分类，无法删除", "code" => 402, "data" => null);
                    $category= M("SystemChannelTableConfig")->where("channel='$channel' AND type=1")->getField("table_format");
                    $where=array("category_id = '" . $getId . "'");
                    if(M("$category")->where($where)->count()){
                        json_return($returnArr);
                    }
                    $logData = M("$tableName")->where("id=$getId")->find();
                    $result = M("$tableName")->where("id=$getId")->setField("is_deleted", 1);
                    if ($result) {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(6, "删除活动分类" . $logData["title"] . "成功",5);
                        $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);
                    } else {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(5, "删除活动分类" . $logData["title"] . "失败",5);
                        $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
                    }
                }
                break;
            case "extends":
                if ($channel) {
                    $systemChannelFormField = M("SystemChannelFormField");
                    $extends = $systemChannelFormField->field("name,title,form_type,default_value,item_option,valid_tip_msg,valid_error_msg,valid_pattern,date_format,file_format,is_relation")->where("table_config_id='$tableConfigId'")->order('admin_sort')->select();
                    $extendValCont = M("$tableName")->where("id='$getId' AND is_deleted=0")->find();
                    $i = 0;
                    foreach ($extends as $extend) {
                        $op = array();
                        if (!empty($extend['item_option'])) {
                            $itemStr =  json_decode($extend['item_option'], true);
                        }
                        $extends[$i]['item_option'] = $itemStr;
                        $itemStr=null;
                        if (count($extendValCont) > 0) {
                            $key = $extend['name'];
                            $extends[$i]['default_value'] = $extendValCont[$key];
                        }

                        $i++;
                    }

                    $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $extends);
                    //exit(json_encode($returnArr));
                } else {
                    $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                }
                break;

            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法".-1);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }

    /**
     * 添加标签
     * @param array $data 需要添加的数据信息
     * @return mixed 返回是否添加成功
     */
    private function addTags($channelIndex, $tableName, $data = array())
    {
        $con['call_index'] = $channelIndex;
        $con['is_active'] = 1;
        $channel = M('SystemChannel')->where($con)->find();

        //将建立的用户名与建立时间赋值给数组。
        $data['channel_id'] = $channel['id'];
        $data["create_user_id"] = $_SESSION["admin_id"];

        //$data['create_user'] = M("ManageAdmin")->where("admin_id=".$data['create_user_id'])->getField("name");

        $data['create_user'] = M("ManageUsers")->where("user_id=".$data['create_user_id'])->getField("user_name");

        $data["create_time"] = date("Y-m-d H:i:s", time());
        $info = M("$tableName")->add($data);
        return $info;
    }

    /**
     * @param array $data 需要修改的数据信息
     * @return mixed 返回是否修改成功
     */
    private function editTags($data = array())
    {
        $getId = $_GET["id"];
        $channel = $_GET["channel"];
        $moduleType = $_GET['type'];
        $tableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("table_format");
        //将更新的用户名与更新时间赋值给数组。
        $data["update_user_id"] = $_SESSION["admin_id"];
        $data["update_time"] = date("Y-m-d H:i:s", time());
        //判断是否有父级ID
        $info = M("$tableName")->where("id='$getId'")->save($data);
        return $info;
    }
    
    /**
     * @param array $data 需要添加的数据信息
     * @return mixed 返回是否添加成功
     */
    public function addActivity($channelIndex, $tableName, $data = array())
    {
        $con['call_index'] = $channelIndex;
        $con['is_active'] = 1;
        $channel = M("SystemChannel")->where($con)->find();
        //将建立的用户名与建立时间赋值给数组。
        $data['channel_id'] = $channel['id'];
        $data["create_user_id"] = $_SESSION["admin_id"];

        //$data["create_user"] = M("ManageAdmin")->where("admin_id=" . $data['create_user_id'])->getField("name");

        $data["create_user"] = M("ManageUsers")->where("user_id=" . $data['create_user_id'])->getField("user_name");

        $data["create_time"] = date("Y-m-d H:i:s", time());
        $data['is_active'] = 1;
        $data['is_delete'] = 0;
        //***********************判断是否自动审核**********************/
        if($channel['is_auto_review']==1){
            $data["status"]=0;
        }
        //***********************判断是否自动审核**********************/

        $info = M("$tableName")->add($data);
        return $info;
    }


    /**
     * @param array $data 需要修改的数据信息
     * @return mixed 返回是否修改成功
     */
    public function editActivity($data = array())
    {
        $getId = $_GET["id"];
        $channel = $_GET["channel"];
        $moduleType = $_GET['type'];
        $tableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("table_format");
        //将更新的用户名与更新时间赋值给数组。
        $data["update_user_id"] = $_SESSION["admin_id"];
        $data["update_time"] = date("Y-m-d H:i:s", time());
        //***********************判断是否自动审核**********************/
        if($channel['is_auto_review']==1){
            $data["status"]=0;
        }
        //***********************判断是否自动审核**********************/
        $info = M("$tableName")->where("id='$getId'")->save($data);
        return $info;
    }


    /**
     * 类别栏目 - 入口函数
     * page_list，page_info 页面显示
     * page_add，page_edit 编辑页面显示
     * add，edit,del，编辑入口
     */
    public function category()
    {
        //获取操作参数
        $action = $_GET["action"];
        $getId = $_GET["id"];
        //获取频道参数
        $channel = $_GET["channel"];
        $moduleType = $_GET['type'];
        //获取频道表ID
        $tableConfigId = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("id");
        $tableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("table_format");
        //$category = M("SystemChannelTableConfig")->where("channel='$channel' AND type=4")->getField("table_name");
        $systemChannelFormField = M("SystemChannelFormField");
        //判断是否设置参数
        switch ($action) {
            case "page_list":
                if (!empty($tableConfigId)) {

                    $infoField = $systemChannelFormField->field("title,name,form_type")->where("table_config_id='$tableConfigId'")->order('admin_sort')->select();
                    foreach ($infoField as $item => $value) {
                        $pageListData[] = $value['name'];
                    }
                    $pageListTypeData[0] = 'text';
                    foreach ($infoField as $item => $value) {
                        $pageListTypeData[] = $value['form_type'];
                    }
                    $pageListData1 = implode(",", $pageListData);
                    $pageListDataShow = M("$tableName")->field("id,$pageListData1")->where("is_deleted=0")->select();
                    $i = 0;
                    foreach ($pageListDataShow as $value) {
                        $m = 0;
                        foreach ($value as $key => $value2) {
                            $pageListDataTypeShow[$i][$key] = array('data' => $value2, 'type' => $pageListTypeData[$m]);
                            $m++;
                            //  $pageListDataTypeShow[$i][$key]=$value2;
                        }
                        $i++;
                    }

                    //查找显示一级分类
                    $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                    $page_now = I('get.page_now', 1);   //$page_now 第几页
                    $countTable = M("$tableName")->where("is_deleted=0")->select();
                    $count = 0;
                    foreach ($countTable as $value) {
                        $count++;
                    }          //$count    总共有多少条数据
                    $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                    $this->assign('count', $count);
                    $this->assign('page', $page);
                    $this->assign('page_num', $page_num);
                    $this->assign('page_now', $page_now);
                    $this->assign("info", $pageListDataTypeShow);
                    $this->assign("info_field", $infoField);
                    $this->assign("channel", $channel);
                    $this->assign("type", $moduleType);
                    $this->display("category_list");
                } else {
                    $returnArr = array("result" => 0, "msg" => "该频道不存在", "code" => 402, "data" => null);
                }
                break;
            case "page_add":
                //查询分类树
                $this->assign("channel", $channel);
                $this->assign("type", $moduleType);
                $this->display("category_info");
                break;
            case "page_edit":
                if ($getId) {
                    //找到传进来的id值的信息
                    $this->assign("id", $getId);
                    $this->assign("type", $moduleType);
                    $this->assign("channel", $channel);
                    $this->display("category_info");
                } else {
                    $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
                }
                break;
            case "add":
                $postData = I("post.");
                $getPinyin = new GetFirstCharterUtil();
                $fieldName = $getPinyin->getAllChar($postData['cat_name']);
                $postData['call_index'] = $fieldName;

                $returnArr = array("result" => 0, "msg" => "分类不允许重名", "code" => 402, "data" => null);
                $where=array("call_index = '" . $postData['call_index'] . "'");
                if(M("$tableName")->where($where)->count()){
                    json_return($returnArr);
                }
                $info = $this->addCategory($channel, $tableName, $postData);
                if ($info) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加活动分类" . $postData["title"] . "成功",3);
                    $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添活动分类失败，数据库录入失败",3);
                    $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
                }
                break;
            case "edit":
                $postData = I("post.");
                $getPinyin = new GetFirstCharterUtil();
                $fieldName = $getPinyin->getAllChar($postData['cat_name']);
                $postData['call_index'] = $fieldName;
                //设置表单不能为空
                //进入编辑函数
                $info = $this->editCategory($postData);
                if ($info) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "编辑活动分类" . $postData["title"] . "成功",3);
                    $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5, "编辑活动分类" . $postData["title"] . "失败",4);
                    $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
                }

                break;
            case "del":
                //查找删除的id是否有子级
                if ($getId) {
                    $tableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("table_format");
                    $logData = M("$tableName")->where("id=$getId")->find();
                    $result = M("$tableName")->where("id=$getId")->setField("is_deleted", 1);
                    if ($result) {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(6, "删除活动分类" . $logData["title"] . "成功",5);
                        $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);
                    } else {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(5, "删除活动分类" . $logData["title"] . "失败，数据库删除失败",5);
                        $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
                    }
                }
                break;

            case "extends":
                if ($channel) {
                    $systemChannelFormField = M("SystemChannelFormField");
                    $extends = $systemChannelFormField->field("name,title,form_type,default_value,item_option,valid_tip_msg,valid_error_msg,valid_pattern,date_format,file_format,is_relation")->where("table_config_id='$tableConfigId'")->order('admin_sort')->select();
                    $extendValCont = M("$tableName")->where("id='$getId' AND is_deleted=0")->find();
                    $i = 0;
                    foreach ($extends as $extend) {
                        $op = array();
                        if (!empty($extend['item_option'])) {
                            $itemStr = json_decode($extend['item_option'], true);
                        }
                        $extends[$i]['item_option'] = $itemStr;
                        $itemStr = null;
                        if (count($extendValCont) > 0) {
                            $key = $extend['name'];
                            $extends[$i]['default_value'] = $extendValCont[$key];
                        }

                        $i++;
                    }

                    $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $extends);
                    //exit(json_encode($returnArr));
                } else {
                    $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                }
                break;
            case "list":
                $keyword = trim(I("cat_name"));

                if($keyword) {
                    $where["cat_name"] = array("exp", "LIKE '%$keyword%'");
                }
                $where['is_deleted']=0;
                //查找显示一级分类
                $page_num = I('post.page_num',8);   //$page_num 每页几条数据
                $page_now = I('post.page_now',1);   //$page_now 第几页

                $count=M("$tableName")->where($where)->count();    //$count    总共有多少条数据
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page  总共有几页

                $data = M("$tableName")->where($where)->page($page_now,$page_num)->field('id, cat_name, sort_num')->select();
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
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }

    /**
     * @param array $data 需要添加的数据信息
     * @return mixed 返回是否添加成功
     */
    public function addCategory($channelIndex, $tableName, $data = array())
    {
        $con['call_index'] = $channelIndex;
        $con['is_active'] = 1;
        $channel = M('SystemChannel')->where($con)->find();

        //将建立的用户名与建立时间赋值给数组。
        $data['channel_id'] = $channel['id'];
        $data["create_user_id"] = $_SESSION["admin_id"];

        //$data['create_user'] = M("ManageAdmin")->where("admin_id=" . $data['create_user_id'])->getField("name");

        $data['create_user'] = M("ManageUsers")->where("user_id=" . $data['create_user_id'])->getField("user_name");

        $data["create_time"] = date("Y-m-d H:i:s", time());
        $info = M("$tableName")->add($data);
        return $info;
    }

    /**
     * @param array $data 需要修改的数据信息
     * @return mixed 返回是否修改成功
     */
    public function editCategory($data = array())
    {
        $getId = $_GET["id"];
        $channel = $_GET["channel"];
        $moduleType = $_GET['type'];
        $tableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("table_format");
        //将更新的用户名与更新时间赋值给数组。
        $data["update_user_id"] = $_SESSION["admin_id"];
        $data["update_time"] = date("Y-m-d H:i:s", time());
        //判断是否有父级ID
        $info = M("$tableName")->where("id='$getId'")->save($data);
        return $info;
    }


    /**
     * 评价管理 - 入口函数
     * page_list，page_info 页面显示
     * page_add，page_edit 编辑页面显示
     * add，edit,del，编辑入口
     */

    public function comment()
    {
        $action = $_GET["action"];
        $channel = $_GET["channel"];
        $channelId = M("SystemChannel")->where("call_index='$channel'")->getField("id");
        $commonComment = M("CommonComment");//Activity基础字段表，保存每个活动基础字段的内容
        //判断是否设置参数
        switch ($action) {
            case "page_list":
                if ($channel) {
                    //$infoField是SystemChannelFormField表中所有可以显示的字段名
                    $info = $commonComment->field("id,data_id,comment_user_name,comment_time,content,feedback_user_name,feedback_time,status")->where("channel_id= $channelId ")->select();
                    $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                    $page_now = I('get.page_now', 1);   //$page_now 第几页
                    $count = $commonComment->where("channel_id='$channelId'")->count();          //$count    总共有多少条数据
                    $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                    $this->assign('count', $count);
                    $this->assign('page', $page);
                    $this->assign('page_num', $page_num);
                    $this->assign('page_now', $page_now);
                    $this->assign("info", $info);
                    $this->assign("channel", $channel);
                    $this->display("comment");
                } else {
                    $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                }
                break;

            case "page_add":
                $this->display("comment_info");
                break;
            case "page_edit":
                $this->display("comment_info");
                break;
            case "add":
                break;
            case "edit":
                break;
            case "del":
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                break;
        }
    }


    /**
     * 递归无限级分类【先序遍历算】，获取任意该节点下所有的孩子
     * @param array $data 待排序的数组
     * @param int $parent_id 父级节点
     * @param int $level 层级数
     * @return array $arrTree 排序后的数组
     */
    public function getTreeSon($data, $parent_id = 0, $level = 0)
    {
        static $arr = array(); //使用static代替global
        if (empty($data)) return false;
        $level++;
        foreach ($data as $item => $value) {
            if ($value['parent_id'] == $parent_id) {
                $value['level'] = $level;
                $arr[] = $value;
                unset($data[$item]); //注销当前节点数据，减少已无用的遍历
                $this->getTreeSon($data, $value['id'], $level);
            }
        }
        return $arr;
    }

    //报名管理
    public function activity_order(){

        $action = $_GET['action'];
        $id = $_GET['id'];

        if(empty($_GET['id'])){
            $id = $_POST['id'];
        }
        switch($action){
            case "page_list":

                $activityId = $_POST['activity_id'];
                $index = $_POST['channel'];
                $channel = M("SystemChannel")->where("call_index='".$index."'")->find();
                // dump($channel);die;

                $page_now = $_POST['page_now'];
                $page_num = 10;
                $orderTableName = M("SystemChannelTableConfig")->where("channel='$index' AND type=3")->getField("table_format");
                $condition['activity_id'] = $activityId;
                $condition['channel_id'] = $channel['id'];
                $count= M("$orderTableName")->where('hd_id='.$activityId)->count();
                $list = M("$orderTableName")->where('hd_id='.$activityId)->page($page_now, $page_num)->select();
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num);

                $data['page'] = $page;
                $data['list'] = $list;
                $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $data);
                break;
            case "update":
                if($id){
                    $field = $_POST['field'];
                    $value = $_POST['value'];
                    $state = M("ActivityOrder")->where("order_id=".$id)->setField($field, $value);
                    if($state){
                        $returnArr = array("result" => 1, "msg" => "审核成功", "code" => 200, "data" => null);
                    }else{
                        $returnArr = array("result" => 0, "msg" => "审核失败", "code" => 402, "data" => null);
                    }
                }else{
                    $returnArr = array("result" => 0, "msg" => "审核失败", "code" => 403, "data" => null);
                }
                break;

            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 404, "data" => null);
        }
        json_return($returnArr);

    }

    /**
     * 票价类别 - 入口函数
     * page_list，page_info 页面显示
     * page_add，page_edit 编辑页面显示
     * add，edit,del，编辑入口
     */
    public function ticket_cat()
    {
        //获取操作参数
        $action = $_GET["action"];
        $getId = $_GET["id"];
        //获取频道参数
        $channel = $_GET["channel"];
        $moduleType = $_GET['type'];
        //获取频道表ID
        $tableConfigId = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("id");
        $tableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("table_format");
        $systemChannelFormField = M("SystemChannelFormField");
        //判断是否设置参数
        switch ($action) {
            case "page_list":
                if (!empty($tableConfigId)) {

                    $infoField = $systemChannelFormField->field("title,name,form_type")->where("table_config_id='$tableConfigId'")->order('admin_sort')->select();
                    foreach ($infoField as $item => $value) {
                        $pageListData[] = $value['name'];
                    }
                    $pageListTypeData[0] = 'text';
                    foreach ($infoField as $item => $value) {
                        $pageListTypeData[] = $value['form_type'];
                    }
                    $pageListData1 = implode(",", $pageListData);
                    $conf['is_deleted'] = 0;
                    $conf['data_id'] = $_GET['data_id'];
                    $pageListDataShow = M("$tableName")->field("id,$pageListData1")->where($conf)->select();
                    $i = 0;
                    foreach ($pageListDataShow as $value) {
                        $m = 0;
                        foreach ($value as $key => $value2) {
                            $pageListDataTypeShow[$i][$key] = array('data' => $value2, 'type' => $pageListTypeData[$m]);
                            $m++;
                        }
                        $i++;
                    }

                    //查找显示一级分类
                    $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                    $page_now = I('get.page_now', 1);   //$page_now 第几页
                    $countTable = M("$tableName")->where("is_deleted=0")->select();
                    $count = 0;
                    foreach ($countTable as $value) {
                        $count++;
                    }          //$count    总共有多少条数据
                    $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                    $this->assign('data_id', $_GET['data_id']);
                    $this->assign('count', $count);
                    $this->assign('page', $page);
                    $this->assign('page_num', $page_num);
                    $this->assign('page_now', $page_now);
                    $this->assign("info", $pageListDataTypeShow);
                    $this->assign("info_field", $infoField);
                    $this->assign("channel", $channel);
                    $this->assign("type", $moduleType);
                    $this->display("ticket_cat_list");
                } else {
                    $returnArr = array("result" => 0, "msg" => "该频道不存在", "code" => 402, "data" => null);
                }
                break;

            case "page_add":
                //查询分类树
                $this->assign('data_id', $_GET['data_id']);
                $this->assign("channel", $channel);
                $this->assign("type", $moduleType);
                $this->display("ticket_cat_info");
                break;
            case "page_edit":
                if ($getId) {
                    //找到传进来的id值的信息
                    $this->assign("id", $getId);
                    $this->assign("type", $moduleType);
                    $this->assign("channel", $channel);
                    $this->display("ticket_cat_info");
                } else {
                    $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
                }
                break;
            case "add":
                $postData = I("post.");

                $info = $this->addCategory($channel, $tableName, $postData);
                if ($info) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加活动分类" . $postData["title"] . "成功",3);
                    $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);

                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添活动分类失败，数据库录入失败",3);
                    $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
                }
                break;
            case "edit":
                $postData = I("post.");
                //设置表单不能为空
                //进入编辑函数
                $info = $this->editCategory($postData);
                if ($info) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "编辑活动分类" . $postData["title"] . "成功",3);
                    $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5, "编辑活动分类" . $postData["title"] . "失败",4);
                    $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
                }

                break;
            case "del":
                //查找删除的id是否有子级
                if ($getId) {
                    $tableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("table_format");
                    $logData = M("$tableName")->where("id=$getId")->find();
                    $result = M("$tableName")->where("id=$getId")->setField("is_deleted", 1);
                    if ($result) {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(6, "删除活动分类" . $logData["title"] . "成功",5);
                        $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);
                    } else {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(5, "删除活动分类" . $logData["title"] . "失败，数据库删除失败",5);
                        $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
                    }
                }
                break;

            case "extends":
                if ($channel) {
                    $systemChannelFormField = M("SystemChannelFormField");
                    $extends = $systemChannelFormField->field("name,title,form_type,default_value,item_option,valid_tip_msg,valid_error_msg,valid_pattern,date_format,file_format,is_relation")->where("table_config_id='$tableConfigId'")->order('admin_sort')->select();
                    $extendValCont = M("$tableName")->where("id='$getId' AND is_deleted=0")->find();
                    $i = 0;
                    foreach ($extends as $extend) {
                        $op = array();
                        if (!empty($extend['item_option'])) {
                            $itemStr = json_decode($extend['item_option'], true);
                        }
                        $extends[$i]['item_option'] = $itemStr;
                        $itemStr = null;
                        if (count($extendValCont) > 0) {
                            $key = $extend['name'];
                            $extends[$i]['default_value'] = $extendValCont[$key];
                        }

                        $i++;
                    }

                    $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $extends);
                    //exit(json_encode($returnArr));
                } else {
                    $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                }
                break;

            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }

    private function gen_qrcode($channel, $type, $id){

        $where['channel'] = $channel;
        $where['type'] = $type;
        $where['data_id'] = $id;
        $info = M('CommonQrcode')->where($where)->find();
        if($info['qr_path']){
            $file = ltrim($info['qr_path'], '/');
            if(is_file($file)){

            }

        }

        $table = getTableStr($channel, $type, 'table_format');
        $logo = M($table)->where('id='.$id)->getField('cover_url');

        $http = 'http';
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'){
            $http = 'https';
        }
        $domain = $http . '://' . I('server.HTTP_HOST');
        $url = $domain . "/Mobile/User/user_sign/channel/" . $channel . "/type/3" . "/id/" . $id;

        $site = session('site_name');
        $qrPath = "Public/upload/" . $site . "/qrcode/";
        if(!is_dir($qrPath)){
            mkdir($qrPath, 0755, true);
        }
        /*$name = $channel . '_' . date('YmdHis') . '.png';
        $tempQrFile = $qrPath . $name;*/
        $qrFile = $qrPath . $channel . '_' . $type . '_' . $id . '.png';

        Vendor("phpqrcode.phpqrcode");
        $QRcode = new \QRcode ();
        $content = $url;
        // 纠错级别：L、M、Q、H
        $level = 'L';
        // 点的大小：1到10,用于手机端4就可以了
        $size = 10;
        // 下面注释了把二维码图片保存到本地的代码,如果要保存图片,用$fileName替换第二个参数false
        //$path = "images/";
        // 生成的文件名
        //$fileName = $path.$size.'.png';
        $QRcode::png($content, $qrFile, $level, $size);

        /*if(!is_file($tempQrFile)){
            return false; //生成二维码失败
        }

        if ($logo !== FALSE) {
            $QR = imagecreatefromstring ( file_get_contents ( $tempQrFile ) );
            $logo = imagecreatefromstring ( file_get_contents ( $logo ) );
            $QR_width = imagesx ( $QR );
            $QR_height = imagesy ( $QR );
            $logo_width = imagesx ( $logo );
            $logo_height = imagesy ( $logo );
            $logo_qr_width = $QR_width / 5;
            $scale = $logo_width / $logo_qr_width;
            $logo_qr_height = $logo_height / $scale;
            $from_width = ($QR_width - $logo_qr_width) / 2;
            imagecopyresampled ( $QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height );
        }

        $qrFile = $qrPath . $channel . '_' . $type . '_' . $id . '.png';

        imagepng($QR, $qrFile);*/

        if(!is_file($qrFile)){
            return false; //生成二维码失败
        }else{
            //unlink($tempQrFile);
        }

        $qrFile = '/' . $qrFile;

        $data['channel'] = $channel;
        $data['type'] = $type;
        $data['data_id'] = $id;

        $data['content'] = $url;
        $data['qr_path'] = $qrFile;

        $flag = M('CommonQrcode')->add($data);
        if(!$flag){
            return false;
        }
        return $qrFile;
    }


    /*
     * 会议统计
     * */
    public function meetingStatistics()
    {
        $channel = $_GET["channel"];//channel/activity_info
        $channelId = M("SystemChannel")->where("call_index='$channel'")->getField("id");
        $activityId = $_GET["activity_id"];//channel/activity_info
        //会议评价
        $meeting = M("commonComment")->alias('a')
            ->field("a.comment_user_nickname,a.comment_time,a.comment_level,a.content,b.mobile")
            ->join('__MANAGE_USERS__ b on b.user_id=a.comment_user_id','LEFT')
            ->where("a.data_id = '$activityId' AND a.channel_id = '$channelId'")
            ->order("comment_time desc")
            ->select();

        //演讲人评价
        $speechaPeople = M("CommonCommentYjgl")->alias('a')
            ->field("a.comment_user_nickname,a.comment_time,a.comment_level,a.content,b.mobile,c.yjzt,c.title")
            ->join('__MANAGE_USERS__ b on b.user_id=a.comment_user_id','LEFT')
            ->join('__ACTIVITY_YJGL_HYGL__ c on c.id=a.yjgl_hygl_id','LEFT')
            ->where("a.activity_id = '$activityId'")
            ->order("comment_time desc")
            ->select();

        //会务调查统计
        $testId = M("TestWeifan")->field("id")->where("is_deleted = 0 AND activity_id = '$activityId'")->select();
        foreach ($testId as $value) {
          $topicId[] = M("TestTopicsWeifan")->field("topic_id")->where("test_id = '{$value['id']}'")->select();
        }
        foreach ($topicId as $value) {
            foreach ($value as $value2) {
                $topicAllId[] = $value2['topic_id'];
            }
        }
        $topicAllId = array_unique($topicAllId); //此会议下所有公司所有问题
        $where['b.activity_id'] = $activityId;
        $where['a.topic_id'] =  array('in',$topicAllId);
       foreach ($topicAllId as $value){
           $problemStatistics = M("TopicAnswerWeifan")->alias('a')
               ->field("a.topic_id,a.topic_title,a.desc, a.id,b.answer,count( distinct b.user_id) as count")
               ->join('__TEST_RESULT_WEIFAN__ b on b.answer=a.id','LEFT')
               ->where($where)
               ->group('b.answer')
               ->select();
       }

        //演讲人打赏详细
        $speechMoney = M("SpeechWechatLog")
            ->field("activity_name,speech_people_name,user_name,user_mobile,order_amount/100.0 as money,create_time")
            ->where("activity_id = '$activityId'")
            ->select();
        $i = 0;
        foreach ($speechMoney as $value) {
            $speechMoney[$i]['money'] = floatval($value['money']).' 元';
            $i++;
        }
        $this->assign("speech_people",$speechaPeople);
        $this->assign("speech_money",$speechMoney);
        $this->assign("problem_tatistics",$problemStatistics);
        $this->assign("meeting",$meeting);
        $this->display("statistics_list");
    }
}

