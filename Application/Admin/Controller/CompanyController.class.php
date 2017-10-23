<?php

namespace Admin\Controller;

use Admin\Util\GetFirstCharterUtil;
use Think\Log;

class CompanyController extends BaseController
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
        $checkAction = array('company');
       if(in_array($act,$checkAction) && in_array($action,$check)) {
            $res = parent::checkRole();
            if ($res["result"] != 1) {
                $this->error("您的账号没有操作权限");
            }
        }
    }

    /**
     * 内容管理 - 入口函数
     * page_list，page_info 页面显示
     * page_add，page_edit 编辑页面显示
     * add，edit,del，编辑入口
     */

    public function company()
    {
        $action = $_GET["action"];//action/page_list
        $getId = $_GET["id"];
        $channel = $_GET["channel"];//channel/company_info
        $categoryId = $_GET["category_id"];
        //在SystemChannel表中根据传来的channel名字company_info找到相应的id（每一个channel别名都有一个唯一的ID）
        $moduleType = $_GET['type'];
        $tableConfigId = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("id");
        $channelId = M("SystemChannel")->where("call_index='$channel'")->getField("id");
        $tableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("table_format");
        $category = M("SystemChannelTableConfig")->where("channel='$channel' AND type='2'")->getField("table_name");
        $systemChannelFormField = M("SystemChannelFormField");
        $categoryTableName =  M("SystemChannelTableConfig")->where("channel='$channel' AND type='2'")->getField("table_format");
        if($categoryId>0){
            $categoryName = M("$categoryTableName") ->where("id = '$categoryId'")->getField("cat_name");
        }
        //判断是否设置参数
        switch ($action) {
            case "page_list":
                $condition['table_config_id'] = $tableConfigId;
                $condition['show_list'] = 1;
                $infoField =$systemChannelFormField->field("title,name,form_type")->where($condition)->order('admin_sort')->select();
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页

                $data['is_deleted']=0;
                $keyword=trim(I("keyword"));
               
                if($keyword){
                    $data['title|intro']=array("EXP","LIKE '%$keyword%'");
                }
                if($categoryId>0) {
                    $data['category_id']=$categoryId;
                }
                $count= M("$tableName")->where($data)->count();//$count    总共有多少条数据

                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page  总共有几页

                $data2['call_index']=$channel;
                $lead=M("SystemChannel")->where($data2)->field("is_import_data,is_export_data")->select();
                $this->assign("lead",$lead);

                foreach ($infoField as $item => $value) {
                    $pageListData[] = $value['name'];
                }
                $pageListTypeData[0]='text';
                foreach ($infoField as $item => $value) {
                    $pageListTypeData[] = $value['form_type'];
                }
                $keyword=trim(I("keyword"));
                
                if($keyword){
                    $where['title|intro']=array("LIKE","%$keyword%");
                }
                if($categoryId>0) {
                    $where['V.category_id']=$categoryId;
                }
                $where['V.is_deleted']=0;
                $pageListData1=implode(",",$pageListData);

                $pageListDataShow =M("$tableName")
                    ->join("AS V LEFT JOIN  $category B ON V.category_id=B.id")
                    ->page($page_now, $page_num)
                    ->field("V.id,$pageListData1,B.cat_name,V.status,V.is_active")
                    ->where($where)
                    ->select();

                $i=0;
                foreach ($pageListDataShow as $value) {
                    $m =0;
                    foreach ($value as $key => $value2) {
                        if($key=="status") {
                            if($value2==1) {
                                $pageListDataTypeShow[$i]['status']=array('data'=>"审核中",'type'=>"text");
                            }else if($value2==0) {
                                $pageListDataTypeShow[$i]['status']=array('data'=>"已通过",'type'=>"text");
                            }else if($value2==-1) {
                                $pageListDataTypeShow[$i]['status']=array('data'=>"不通过",'type'=>"text");
                            }
                        }else{
                            $pageListDataTypeShow[$i][$key]=array('data'=>$value2,'type'=>$pageListTypeData[$m]);
                        }
                        $m++;
                    }
                    $i++;
                }
                $is_copy = M("SystemChannel")->where("call_index='$channel'")->getField("is_copy");
                if (!empty($tableConfigId)) {

                    $channel_id = M("$tableName")->getField("channel_id");
                    $this->assign('count', $count);
                    $this->assign("category_id",$categoryId);
                    $this->assign("category_name",$categoryName);
                    $this->assign('page', $page);
                    $this->assign('page_num', $page_num);
                    $this->assign('page_now', $page_now);
                    $this->assign("info", $pageListDataTypeShow);
                    $this->assign("is_copy", $is_copy);
                    $this->assign("info_field", $infoField);
                    $this->assign("channel", $channel);
                    $this->assign('tableName', $tableName);
                    $this->assign("type", $moduleType);
                    $this->display("company_list");
                    $this->logRecord(6,"查看企业数据",6,$channel_id,$getId);
                } else {
                    $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
                }
                break;
            case "page_add":
                if ($channel) {
                    if($getId) {
                        $infoField =$systemChannelFormField->field("title,name")->where("table_config_id='$tableConfigId'")->order('admin_sort')->select();
                        $channel_id = M("$tableName")->getField("channel_id");
                        $systemLog = M("SystemLog")->field("admin_user_name,log_time,log_info,log_ip")->where("channel_id='$channel_id' AND data_id='$getId' AND operate_type!=4")->select();
                        foreach ($infoField as $item => $value) {
                            $pageListData[] = $value['name'];
                        }
                        $pageListData1=implode(",",$pageListData);
                        $condition['id'] = $getId;
                        $condition['is_deleted'] = 0;
                        $pageListDataShow = M("$tableName")->field("id,$pageListData1")->where($condition)->find();
                        $data = $pageListDataShow;
                        $company = M("$tableName")->where($condition)->find();
                        $categoryTableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type=2")->getField("table_format");
                        $categoryData = M("$categoryTableName")->field('id, cat_name')->where('is_deleted=0')->order('sort_num')->select();

                        $levelTableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type=3")->getField("table_format");
                        $levelData = M("$levelTableName")->field('id, level_name')->where('is_deleted=0')->select();

                        //判断是否是否需要绑定用户
                        $is_bind_user = M("SystemChannel")->where("call_index='$channel'")->getField("is_bind_user");
                        $this->assign('is_bind_user', $is_bind_user);
                        //判断是否是否需要绑定用户
                        //判断是否需要开启置顶
                        $is_top = M("SystemChannel")->where("call_index='$channel'")->getField("is_top");
                        $this->assign('is_top', $is_top);

                        $this->assign("iscopy",'1'); //1是copy
                        $this->assign("id", $getId);
                        $this->assign("ifadd",'');
                        $this->assign("channel", $channel);
                        $this->assign("type", $moduleType);
                        $this->assign('system_log', $systemLog);
                        $this->assign('info', $company);
                        $this->assign("data", $data);
                        $this->assign('category_data', $categoryData);
                        $this->assign('level_data', $levelData);
                        $this->display("company_info");
                    } else {
                        $this->assign("iscopy",'0'); //0是正常的新增
                        $this->assign("ifadd",'');
                        $this->assign("channel", $channel);
                        $this->assign("type", $moduleType);
                        $categoryTableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type=2")->getField("table_format");
                        $categoryData = M("$categoryTableName")->field('id, cat_name')->where('is_deleted=0')->order('sort_num')->select();
                        $userName = M("ManageUsers")->where("user_id=".$_SESSION['admin_id'])->getField("user_name");
                        $tagsTableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type=4")->getField("table_format");
                        $tagsInfo = M("$tagsTableName")->field("id,tag_name")->where("status = 1 AND is_deleted=0")->select();
                        if($tagsInfo) {
                            $ifTags = 1;
                        } else {
                            $ifTags = 0;
                        }
                        $levelTableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type=3")->getField("table_format");
                        $levelData = M("$levelTableName")->field('id, level_name')->where('is_deleted=0')->select();

                        //判断是否是否需要绑定用户
                        $is_bind_user = M("SystemChannel")->where("call_index='$channel'")->getField("is_bind_user");
                        $this->assign('is_bind_user', $is_bind_user);
                        //判断是否是否需要绑定用户

                        $this->assign('level_data', $levelData);
                        $this->assign("tags_info", $tagsInfo);
                        $this->assign("if_tags", $ifTags);
                        $this->assign('currentUser', $userName);
                        $this->assign('currentDate', date("Y-m-d"));
                        $this->assign('category_data', $categoryData);
                        $this->display("company_info");
                    }
                } else {
                    $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                }
                break;
            case "page_edit":
                if ($channel) {
                    if ($getId) {
                        $data['data_id']=$getId;
                        $lead=M("Company_".$channel."ViewRecord")->where($data)->field("data_id")->count();

                        $infoField =$systemChannelFormField->field("title,name")->where("table_config_id='$tableConfigId'")->order('admin_sort')->select();
                        $channel_id = M("$tableName")->getField("channel_id");
                        $systemLog = M("SystemLog")->field("admin_user_name,log_time,log_info,log_ip")->where("channel_id='$channel_id' AND data_id='$getId' AND operate_type!=4")->select();
                        foreach ($infoField as $item => $value) {
                            $pageListData[] = $value['name'];
                        }
                        $pageListData1=implode(",",$pageListData);

                        $condition['id'] = $getId;
                        $condition['is_deleted'] = 0;
                        $pageListDataShow = M("$tableName")->field("id,is_red,is_hot,$pageListData1")->where($condition)->find();

                        $data = $pageListDataShow;
                        $company = M("$tableName")->where($condition)->find();

                        $categoryTableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type=2")->getField("table_format");
                        $categoryData = M("$categoryTableName")->field('id, cat_name')->where('is_deleted=0')->order('sort_num')->select();

                        $levelTableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type=3")->getField("table_format");
                        $levelData = M("$levelTableName")->field('id, level_name')->where('is_deleted=0')->select();

                        $tagsTableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type=4")->getField("table_format");
                        $tagsRelationTableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type=5")->getField("table_format");
                        $tagsInfo = M("$tagsTableName")->field("id,tag_name")->where("status = 1 AND is_deleted!=1")->select();
                        $tagsRelationInfo = M("$tagsRelationTableName")->field("tag_id ")->where("channel_id = '$channelId' AND data_id = '$getId'")->select();
                        $checkTagIdArr = array();

                        $i = 0;
                        foreach($tagsRelationInfo as $item){
                            $checkTagIdArr[$i] = $item['tag_id'];
                            $i ++;
                        }

                        $i = 0;
                        foreach ($tagsInfo as $item) {

                            if(in_array($item['id'], $checkTagIdArr)) {
                                $tagsInfo[$i]['checked'] = 1;
                            }else{
                                $tagsInfo[$i]['checked'] = 0;
                            }
                            $i++;
                        }

                        if($tagsInfo) {
                            $ifTags = 1;
                        } else {
                            $ifTags = 0;
                        }
                        //判断是否是否需要绑定用户
                        $is_bind_user = M("SystemChannel")->where("call_index='$channel'")->getField("is_bind_user");
                        $this->assign('is_bind_user', $is_bind_user);
                        //判断是否是否需要绑定用户

                        //获取绑定过的企业个户
                        $relation=M('SystemRelation')->where("channel_id=".$channelId." AND data_id=".$getId)->find();
                        if($relation){
                            $bind_user_id=$relation['user_id'];
                            $userModel=M('ManageUsers')->where("user_id='$bind_user_id'")->find();
                            $bind_user_name=$userModel['user_name'];
                        }

                        //子表
                        $conf['channel_index'] = $channel;
                        $child = M('SystemChannelChild')->field('id,title,channel_index, type, has_relation')->where($conf)->select();
                        $this->assign('child', $child);
                        //判断是否需要开启置顶
                        $is_top = M("SystemChannel")->where("call_index='$channel'")->getField("is_top");
                        $this->assign('is_top', $is_top);

                        $this->assign("lead",$lead);
                        $this->assign('ifcheck',1);
                        $this->assign("tags_info", $tagsInfo);
                        $this->assign("if_tags", $ifTags);
                        $this->assign("ifadd",'b');
                        $this->assign("id", $getId);
                        $this->assign("channel", $channel);
                        $this->assign("type", $moduleType);
                        $this->assign('system_log', $systemLog);
                        $this->assign('info', $company);
                        $this->assign("data", $data);
                        //绑定的用户信息
                        $this->assign("bind_user_id", $bind_user_id);
                        $this->assign("bind_user_name", $bind_user_name);

                        $this->assign('category_data', $categoryData);
                        $this->assign('level_data', $levelData);

                        $this->display("company_info");
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
                    $isCopy = $_GET["iscopy"];
                    $tags = $postData['tag_name'];
                    $tagsTable = M("SystemChannelTableConfig")->where("channel='$channel' AND type='4'")->getField("table_format");
                    $tagsRelationTable = M("SystemChannelTableConfig")->where("channel='$channel' AND type='5'")->getField("table_format");

                    //检查用户是否绑定过
                    if($postData['bind_user_id']){
                        if(M('SystemRelation')->where("channel_id=".$channelId." AND user_id=".$postData['bind_user_id'])->count()>0) {
                            $this->logRecord(5, "新增数据【" . $postData["title"] . "】失败，用户重复绑定",3);
                            $returnArr = array("result" => 0, "msg" => "保存失败，用户重复绑定", "code" => 402, "data" => null);
                            break;
                        }
                    }
                    //判断是否置顶数据
                    if($postData['is_red']!="1"){
                        $postData['is_red']=0;
                    }
                    //添加频道数据
                    $dataId = $this->addCompany($channel, $tableName, $postData);
                    if ($dataId)
                    {
                        //根据绑定用户id，记录绑定关系
                        $this->bindUser($channelId,$postData['bind_user_id'],$dataId);
                        //处理tag
                        if($tags) {
                            foreach ( $tags as $value){
                                $relationData['channel_id'] = $channelId;
                                $relationData['tag_id'] = $value;
                                $relationData['data_id'] = $dataId;
                                $relationData['remark'] = M("$tagsTable")->where("id = '$value'")->getField("remark");
                                $relationData["create_time"] = date("Y-m-d H:i:s", time());
                                M("$tagsRelationTable")->add($relationData);
                            }
                        }
                        //记录审核日志
                        $channelModel = M("systemChannel")->where("call_index='$channel'")->find();
                        if($channelModel['is_auto_review']==1){
                            $this->logRecord(6,"自动审核企业" . $postData["title"]. "成功",6,$channelId,$dataId);
                        }
                        //记录操作日志
                        $this->logRecord(6,"新增企业数据【" . $postData["title"]. "】成功",3,$channelId,$dataId);
                        $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                    } else {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(5, "新增企业数据【" . $postData["title"] . "】失败",3);
                        $returnArr = array("result" => 0, "msg" => "保存失败，请重试", "code" => 402, "data" => null);
                    }
                } else {
                    $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                }
                break;
            case "edit":
                if ($channel) {
                    $postData = I("post.");
                    $getData = I("get.");

                    $recovery = $_GET["recovery"];
                    $tagsTable = M("SystemChannelTableConfig")->where("channel='$channel' AND type='4'")->getField("table_format");
                    $tagsRelationTable = M("SystemChannelTableConfig")->where("channel='$channel' AND type='5'")->getField("table_format");

                    //判断是否置顶数据
                    if($postData['is_red']!="1"){
                        $postData['is_red']=0;
                    }
                    //检查用户是否绑定过
                    if($postData['bind_user_id']){
                    if(M('SystemRelation')->where("data_id !=".$postData['id']." AND channel_id =".$channelId." AND user_id=".$postData['bind_user_id'])->count()>0) {
                        $this->logRecord(5, "编辑数据【" . $postData["title"] . "】失败，用户重复绑定",3);
                        $returnArr = array("result" => 0, "msg" => "保存失败，用户已被绑定", "code" => 402, "data" => null);
                        break;
                    }
                    }
                    if ($recovery == 1) {
                        $info = $this->editCompany($tableName,$getData);
                    } else {
                        $info = $this->editCompany($tableName,$postData);
                    }

                    if ($info) {
                        //根据绑定用户id，记录绑定关系
                        $this->updateUser($channel,$channelId,$postData['bind_user_id'],$getId);
                        //重新处理tag关系
                        if($channelId>0 && $getId>0 ) {
                            M("$tagsRelationTable")->where("channel_id = '$channelId' AND data_id = '$getId'")->delete();
                        }
                        $tags = $postData['tag_name'];
                        if($tags) {
                            foreach ( $tags as $value){
                                $relationData['channel_id'] = $channelId;
                                $relationData['tag_id'] = $value;
                                $relationData['data_id'] = $getId;
                                $relationData['remark'] = M("$tagsTable")->where("id = '$value'")->getField("remark");
                                $relationData["create_time"] = date("Y-m-d H:i:s", time());
                                M("$tagsRelationTable")->add($relationData);
                            }
                        }
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $channel_id = M("$tableName")->getField("channel_id");
                        if ($recovery == 1) {
                            $this->logRecord(6,"恢复数据【". $postData["title"]. "】成功",4,$channel_id,$getId);
                            $this->redirect("Admin/Company/company/action/recycle_page_list/channel/$channel/type/1");
                        }else{
                            $this->logRecord(6,"修改数据【". $postData["title"]. "】成功",4,$channel_id,$getId);
                        }
                        $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                    } else {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(6, "修改数据" . $postData["title"] . "】失败");
                        $returnArr = array("result" => 0, "msg" => "保存失败，请重试", "code" => 402, "data" => null);
                    }
                } else {
                    $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                }
                break;
            case "recovery":
                if ($channel) {

                } else {
                    $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                }
                break;
            case "del":
                if ($channel) {
                    if ($getId) {
                        $tableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("table_format");
                        $logData = M("$tableName")->where("id=$getId")->find();
                        $result = M("$tableName")->where("id=$getId")->setField("is_deleted",1);
                        if ($result) {
                            $result = M("ManageCompanyAccounts")->where("data_id=$getId")->setField("is_deleted",1);
                            $tagsRelationTable = M("SystemChannelTableConfig")->where("channel='$channel' AND type='5'")->getField("table_format");
                            if($channelId > 0) {
                                $result2 = M("$tagsRelationTable")->where("channel_id = '$channelId' AND data_id = '$getId'")->delete();
                            }
                            
                            //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                            $channel_id = M("$tableName")->getField("channel_id");
                            $this->logRecord(6,"删除数据【" . $logData["title"] . "】成功",5,$channel_id,$getId);
                            $returnArr = array("result" => 1, "msg" => "已放入回收站", "code" => 200, "data" => null);
                        } else {
                            //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                            $this->logRecord(5, "删除数据" . $logData["title"] . "】失败",5);
                            $returnArr = array("result" => 0, "msg" => "删除失败，请重试", "code" => 402, "data" => null);
                        }
                    } else {
                        $this->logRecord(5, "删除数据失败，该数据已被删除",5);
                        $returnArr = array("result" => 0, "msg" => "删除失败，该数据已被删除", "code" => 402, "data" => null);
                    }
                } else {
                    $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                }
                break;
            case "dels":
                if ($channel) {
                    if ($getId) {
                        $tableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("table_format");
                        $logData = M("$tableName")->where("id=$getId")->find();
                        $result = M("$tableName")->where("id=$getId")->delete();
                        if ($result) {
                            //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                            $channel_id = M("$tableName")->getField("channel_id");
                            $this->logRecord(6,"删除数据" . $logData["title"],5,$channel_id,$getId);
                            $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);
                        } else {
                            //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                            $this->logRecord(5, "删除数据" . $logData["title"] . "失败，数据库删除失败",5);
                            $returnArr = array("result" => 0, "msg" => "删除失败，请重试", "code" => 402, "data" => null);
                        }
                    } else {
                        $this->logRecord(5, "删除数据失败，该数据已被删除",5);
                        $returnArr = array("result" => 0, "msg" => "删除失败，该数据已被删除", "code" => 402, "data" => null);
                    }
                } else {
                    $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                }
                break;
            case "search":
              /*  $getId = $_GET["id"];
                $channel=$_GET['channel'];

                $where=array("A.category_id"=>$getId['id']);
                $where['A.is_deleted']=0;

                $data=M("$tableName")->join("AS A LEFT JOIN $category AS B ON A.category_id=B.id")
                    ->field("A.id,A.company_account,A.title,A.contacts,A.mobile,A.logo_img,B.cat_name,A.status,A.status")
                    ->where($where)->select();

                $count=M("$tableName")->join("AS A LEFT JOIN $category AS B ON A.category_id=B.id")->where($where)->count();
                if($data){
                    $returnArr=array("result"=>1,"msg"=>"获取数据成功","code"=>402,"data"=>$data,"count"=>$count);
                }else {
                    $returnArr=array("result"=>0,"msg"=>"获取数据失败","code"=>200,"data"=>null);
                }
                $this->assign("channel",$channel);*/
                $categoryId = $_GET["category_id"];
                $condition['table_config_id'] = $tableConfigId;
                $condition['show_list'] = 1;
                $infoField =$systemChannelFormField->field("title,name,form_type")->where($condition)->order('admin_sort')->select();
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页

                $data['is_deleted']=0;
                $count= M("$tableName")->where($data)->count();//$count    总共有多少条数据

                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page  总共有几页

                $data['call_index']=$channel;
                $lead=M("SystemChannel")->where($data)->field("is_import_data,is_export_data")->select();
                $this->assign("lead",$lead);

                foreach ($infoField as $item => $value) {
                    $pageListData[] = $value['name'];
                }
                $pageListTypeData[0]='text';
                foreach ($infoField as $item => $value) {
                    $pageListTypeData[] = $value['form_type'];
                }
               
                $where['V.is_deleted']=0;
                $where['V.category_id']=$categoryId;
                $pageListData1=implode(",",$pageListData);

                $pageListDataShow =M("$tableName")
                    ->join("AS V LEFT JOIN  $category B ON V.category_id=B.id")
                    ->page($page_now, $page_num)
                    ->field("V.id,$pageListData1,B.cat_name,V.status,V.is_active")
                    ->where($where)
                    ->select();

                $i=0;
                foreach ($pageListDataShow as $value) {
                    $m =0;
                    foreach ($value as $key => $value2) {
                        if($key=="status") {
                            if($value2==1) {
                                $pageListDataTypeShow[$i]['status']=array('data'=>"审核中",'type'=>"text");
                            }else if($value2==0) {
                                $pageListDataTypeShow[$i]['status']=array('data'=>"已通过",'type'=>"text");
                            }else if($value2==-1) {
                                $pageListDataTypeShow[$i]['status']=array('data'=>"不通过",'type'=>"text");
                            }
                        }else{
                            $pageListDataTypeShow[$i][$key]=array('data'=>$value2,'type'=>$pageListTypeData[$m]);
                        }
                        $m++;
                    }
                    $i++;
                }
                $is_copy = M("SystemChannel")->where("call_index='$channel'")->getField("is_copy");
                if (!empty($tableConfigId)) {

                    $channel_id = M("$tableName")->getField("channel_id");
                    $this->assign('count', $count);
                    $this->assign('page', $page);
                    $this->assign('page_num', $page_num);
                    $this->assign('page_now', $page_now);
                    $this->assign("info", $pageListDataTypeShow);
                    $this->assign("is_copy", $is_copy);
                    $this->assign("info_field", $infoField);
                    $this->assign("channel", $channel);
                    $this->assign('tableName', $tableName);
                    $this->assign("type", $moduleType);
                    $this->display("company_list");
                    $this->logRecord(6,"查看企业数据",6,$channel_id,$getId);
                } else {
                    $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
                }
                break;
            case "recycle_page_list":
                $condition['table_config_id'] = $tableConfigId;
                $condition['show_list'] = 1;
                // $condition['table_name'] =$tableName2;
                $infoField =$systemChannelFormField->field("title,name,form_type")->where($condition)->order('admin_sort')->select();
                foreach ($infoField as $item => $value) {
                    $pageListData[] = $value['name'];
                }
                $pageListTypeData[0]='text';
                foreach ($infoField as $item => $value) {
                    $pageListTypeData[] = $value['form_type'];
                }

                $pageListData1=implode(",",$pageListData);
                $pageListDataShow =M("$tableName")->join("as v left join $category as b on v.category_id=b.id")
                    ->field("v.id,$pageListData1,cat_name,v.status")
                    ->where("v.is_deleted=1")
                    ->select();
                $i=0;
                foreach ($pageListDataShow as $value) {
                    $m =0;
                    foreach ($value as $key => $value2) {
                        if($key=="status") {
                            $pageListDataTypeShow[$i]['status']=array('data'=>"已 删 除",'type'=>"text");

                        }else{
                            $pageListDataTypeShow[$i][$key]=array('data'=>$value2,'type'=>$pageListTypeData[$m]);
                        }

                        $m++;
                    }
                    $i++;
                }
                if (!empty($tableConfigId)) {
                    $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                    $page_now = I('get.page_now', 1);   //$page_now 第几页
                    $countTable= M("$tableName")->where("is_deleted=1");
                    $count=$countTable->count();
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
                    $this->display("company_recycle_list");
                    $this->logRecord(6,"查看数据",2,$channel_id,$getId);
                } else {
                    $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
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
                } else {
                    $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                }
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法");
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }

    /*
     *添加新的用户，并关联到企业数据中
     */
    private function bindUser($channel,$channelId,$bind_user_id,$data_id){

        //添加用户和频道数据的关联关系
        $relation['channel_index'] = $channel;
        $relation['channel_id'] = $channelId;
        $relation['user_id'] = $bind_user_id;
        $relation['data_id'] = $data_id;

        $model=M('SystemRelation');
        if($model->where($relation)->count()>0){
            return -1;
        }else{
            return M('SystemRelation')->add($relation);
        }
    }

    /*
     *添加新的用户，并关联到企业数据中
     */
    private function updateUser($channel,$channelId,$bind_user_id,$data_id){

        //添加用户和频道数据的关联关系
        $relation['channel_index'] = $channel;
        $relation['channel_id'] = $channelId;
        $relation['data_id'] = $data_id;

       M('SystemRelation')->where($relation)->setField('user_id',$bind_user_id);
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
                        $company = M("$tableName")->where('id='.$id)->find();
                        $flag = M("$tableName")->where('id='.$id)->setField('status', $status);

                        if($flag === false){
                            $this->logRecord(5, "审核【".$company["title"]."】失败，更改频道表出错", 9, $company['channel_id'], $id);
                            $returnArr = array("result" => 0, "msg" => "审核失败，请重试", "code" => 405, "data" => null);
                            json_return($returnArr);
                        }

                        $where = array();
                        $where['data_id'] = $id;
                        $where['channel'] = $channel;
                        $flag =  M('ManageCompanyAccounts')->where($where)->setField('status', $status);
                        if($flag){
                            $this->logRecord(5, "审核【".$company["title"]."】失败，更改企业用户表出错", 9, $company['channel_id'], $id);
                            $returnArr = array("result" => 0, "msg" => "审核失败，请重试", "code" => 405, "data" => null);


                        }else{
                            $this->logRecord(6, "审核【".$company["title"]."】成功!", 9, $company['channel_id'], $id);
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
                $data = $this->getCompanyByStatus(-1, $tables);
                if($data)  {
                    $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $data);
                } else {
                    $returnArr = array("result" => 0, "msg" => "获取数据失败", "code" => 402, "data" => null);
                }
                break;

            case "info":
                $data = $this->getCompanyByStatus(0, $tables);
                if($data)  {
                    $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $data);
                } else {
                    $returnArr = array("result" => 0, "msg" => "获取数据失败", "code" => 402, "data" => null);
                }
                break;

            case "audit":
                $data = $this->getCompanyByStatus(1, $tables);
                if($data)  {
                    $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $data);
                } else {
                    $returnArr = array("result" => 0, "msg" => "获取数据失败", "code" => 402, "data" => null);
                }
                break;

            case "list":
                $data = $this->getCompanyByStatus(false, $tables);
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

    /*
     * 频道对应的标签
     */
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

        $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
        $page_now = I('get.page_now', 1);   //$page_now 第几页
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
                    $pageListDataShow =M("$tableName")
                        ->field("id,$pageListData1,status")
                        ->page($page_now, $page_num)
                        ->where($where)->select();

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
                    $this->logRecord(6, "添加文章分类" . $postData["title"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "提交成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加文章分类失败，数据库录入失败");
                    $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
                }
                break;
            case "edit":
                $postData = I("post.");
                //设置表单不能为空
                //进入编辑函数
                $info = $this->editCategory($postData);
                if ($info) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "编辑文章分类" . $postData["title"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "提交成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5, "编辑文章分类" . $postData["title"] . "失败，数据库删除失败");
                    $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
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
                        $this->logRecord(6, "删除文章分类" . $logData["title"] . "成功");
                        $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);
                    } else {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(5, "删除文章分类" . $logData["title"] . "失败，数据库删除失败");
                        $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
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
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法");
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
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
        $category = M("SystemChannelTableConfig")->where("channel='$channel' AND type=2")->getField("table_format");

        $systemChannelFormField = M("SystemChannelFormField");

        //判断是否设置参数
        switch ($action) {
            case "page_list":

                $keyword=trim(I("keyword"));
                if($keyword) {
                    $where["cat_name"] = array("exp", "LIKE '%$keyword%'");
                }
                $where['is_deleted']=0;
                //查找显示一级分类
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $countTable= M("$tableName")->where("is_deleted=0");
                $count=$countTable->where($where)->count();    //$count    总共有多少条数据
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page 总共有几页

                if (!empty($tableConfigId)) {

                    $infoField =$systemChannelFormField->field("title,name,form_type")->where("table_config_id='$tableConfigId'")->order('admin_sort ')->select();
                    foreach ($infoField as $item => $value) {
                        $pageListData[] = $value['name'];
                    }
                    $pageListTypeData[0]='text';
                    foreach ($infoField as $item => $value) {
                        $pageListTypeData[] = $value['form_type'];
                    }
                    $pageListData1=implode(",",$pageListData);
                    $pageListDataShow =M("$tableName")->field("id,$pageListData1")->where($where)->order("sort_num asc")->select();

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

                $returnArr = array("result" => 0, "msg" => "该名称已存在！不能重复", "code" => 402, "data" => null);
                $where=array("call_index = '" . $postData['call_index'] . "'");
                if(M("$tableName")->where($where)->count()){
                    json_return($returnArr);
                }
                $info = $this->addCategory($channel, $tableName, $postData);
                if ($info) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加文章分类" . $postData["title"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "提交成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加文章分类失败，数据库录入失败");
                    $returnArr = array("result" => 0, "msg" => "数据已存在", "code" => 402, "data" => null);
                }
                break;
            case "edit":
                $postData = I("post.");
                $getPinyin = new GetFirstCharterUtil();
                $fieldName = $getPinyin->getAllChar($postData['cat_name']);
                $postData['call_index'] = $fieldName;

                //进入编辑函数
                $info = $this->editCategory($postData);
                if ($info) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "编辑文章分类" . $postData["title"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "提交成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5, "编辑文章分类" . $postData["title"] . "失败，数据库删除失败");
                    $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
                }

                break;
            case "del":
                //查找删除的id是否有子级
                if ($getId) {
                    $tableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("table_format");
                    $returnArr = array("result" => 0, "msg" => "此类别下面有数据", "code" => 402, "data" => null);
                    $category= M("SystemChannelTableConfig")->where("channel='$channel' AND type=1")->getField("table_format");
                    $where=array("category_id = '" . $getId . "'","is_deleted=0");
                    if(M("$category")->where($where)->count()){
                        json_return($returnArr);
                    }
                    $logData = M("$tableName")->where("id=$getId")->find();
                    $result = M("$tableName")->where("id=$getId")->setField("is_deleted", 1);
                    if ($result) {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(6, "删除文章分类" . $logData["title"] . "成功");
                        $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);
                    } else {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(5, "删除文章分类" . $logData["title"] . "失败，数据库删除失败");
                        $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
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
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法");
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }

    private function getCompanyByStatus($status, $table){

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

    /**
     * @param $channelIndex 频道别名
     * @param $tableName 表名
     * @param $data 数据
     */
    private function addCompany($channelIndex, $tableName, $data = array())
    {

        if($data['level_id'] > 0){
            $levelTable = $this->getTableName($channelIndex, 3);
            $level = M($levelTable)->where("id=".$data['level_id'])->find();
            $data["level_data"] = $level['jibieshunxu'];
            $many_year = '+' . $level['expiry_date'] . ' year';
            $data['level_expiry'] = date("Y-m-d",strtotime($many_year));
        }

        $con['call_index'] = $channelIndex;
        $con['is_active'] = 1;
        $channel = M("SystemChannel")->where($con)->find();

        $data["id"] = '';
        $data['channel_id'] = $channel['id'];
        $data["create_user_id"] = $_SESSION["admin_id"];
        $data["create_user"] = M("manageUsers")->where("user_id=".$data['create_user_id'])->getField("user_name");
        $data["create_time"] = date("Y-m-d H:i:s", time());
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
    private function editCompany($tableName,$data = array())
    {
        $getId = $_GET["id"];
        $channel = $_GET["channel"];

        $oldLevelId = M($tableName)->where("id=".$getId)->getField('level_id');
        if($data['level_id'] != $oldLevelId){
            if($data['level_id'] == 0){
                $data['level_data'] = null;
                $data['level_expiry'] = null;
            }else if($data['level_id'] > 0){

                $levelTable = $this->getTableName($channel, 3);
                $level = M($levelTable)->where("id=".$data['level_id'])->find();
                $data["level_data"] = $level['jibieshunxu'];
                $many_year = '+' . $level['expiry_date'] . ' year';
                $data['level_expiry'] = date("Y-m-d",strtotime($many_year));
            }
        }
        //将更新的用户名与更新时间赋值给数组。
        $data["update_user_id"] = $_SESSION["admin_id"];
        $data["update_time"] = date("Y-m-d H:i:s", time());
        // dump($data);die;
        $info = M($tableName)->where("id='$getId'")->save($data);
        return $info;
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
        $data['create_user'] = M("manageUsers")->where("user_id=".$data['create_user_id'])->getField("user_name");
        $data["create_time"] = date("Y-m-d H:i:s", time());
        $info = M("$tableName")->add($data);
        return $info;
    }

    /**
     * @param array $data 需要添加的数据信息
     * @return mixed 返回是否添加成功
     */
    private function addCategory($channelIndex, $tableName, $data = array())
    {
        $con['call_index'] = $channelIndex;
        $con['is_active'] = 1;
        $channel = M('SystemChannel')->where($con)->find();

        //将建立的用户名与建立时间赋值给数组。
        $data['channel_id'] = $channel['id'];
        $data["create_user_id"] = $_SESSION["admin_id"];
        $data['create_user'] = M("manageUsers")->where("user_id=".$data['create_user_id'])->getField("user_name");
        $data["create_time"] = date("Y-m-d H:i:s", time());
        $info = M("$tableName")->add($data);
        return $info;
    }

    /**
     * @param array $data 需要修改的数据信息
     * @return mixed 返回是否修改成功
     */
    private function editCategory($data = array())
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
     * 递归无限级分类【先序遍历算】，获取任意该节点下所有的孩子
     * @param array $data 待排序的数组
     * @param int $parent_id 父级节点
     * @param int $level 层级数
     * @return array $arrTree 排序后的数组
     */
    private function getTreeSon($data, $parent_id = 0, $level = 0)
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

    /**
     * 评论管理 - 入口函数
     * page_list，page_info 页面显示
     * page_add，page_edit 编辑页面显示
     * add，edit,del，编辑入口
     */
    public function comment()
    {
        $action = $_GET["action"];
        $channel = $_GET["channel"];
        $moduleType = $_GET["index"];
        $getId = $_GET["id"];
        $channelId = M("SystemChannel")->where("call_index='$channel'")->getField("id");
        $commonComment = M("CommonComment");//Article基础字段表，保存每个文章基础字段的内容
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
                    $this->display("comment_list");
                } else {
                    $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                }
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法");
                break;
        }
    }

    public function link()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $postId = $_POST["id"];
        $getData = I("get.");
        $postData = I("post.");
        switch ($action) {
            case "page_list":
                $Ad = M("SystemFriendLink");
                $page_num = I("get.page_num", null) ? I("get.page_num") : I("post.page_num", 25);   //$page_num 每页几条数据
                $page_now = I("get.page_now", 1);   //$page_now 第几页
                $mod_id = get_mod_id("Plugin", "linkList");
                $this->assign("mod_id", $mod_id);
                $res = $Ad->page($page_now, $page_num)->order("orderby")->select();
                $this->assign("list", $res);// 赋值数据集
                $count = $Ad->count();// 查询满足要求的总记录数
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                $this->assign("page", $page);
                $this->assign("page_num", $page_num);
                $this->assign("page_now", $page_now);
                $this->assign("count", $count);
                $this->display("link_list");
                break;
            case "page_add":
                $this->display("link_info");
                break;
            case "page_edit":
                if ($getId) {
                    $link_info = D("SystemFriendLink")->where("link_id=" . $getId)->find();
                    $this->assign("info", $link_info);
                    $this->display("link_info");
                } else {
                    $returnArr = array("result" => 0, "msg" => "请求错误，未指定数据", "code" => 402, "data" => null);
                    json_return($returnArr);
                }
                break;
            case "add":
                stream_context_set_default(array("http" => array("timeout" => 2)));
                send_http_status("311");
                $r = D("SystemFriendLink")->add($postData);
                if ($r) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加友情链接" . $postData["link_name"] . "成功");
                    $this->success("操作成功", U("Admin/Article/link/action/page_list"));
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加友情链接失败");
                    $this->error("操作失败", U("Admin/Article/link/action/page_list"));
                }
                break;
            case "edit":
                $logData = D("SystemFriendLink")->field("link_nme")->where("link_id=" . $postData["link_id"])->find();
                $r = D("SystemFriendLink")->where("link_id=" . $postData["link_id"])->save($postData);
                if ($r) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "编辑友情链接" . $logData["link_name"] . "成功");
                    $this->success("操作成功", U("Admin/Article/link/action/page_list"));
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "编辑友情链接" . $logData["link_name"] . "失败,数据库录入失败");
                    $this->error("操作失败", U("Admin/Article/link/action/page_list"));
                }
                break;
            case "del":
                $logData = D("SystemFriendLink")->field("link_nme")->where("link_id=" . $postData["link_id"])->find();
                $r = D("SystemFriendLink")->where("link_id=" . $postData["link_id"])->delete();
                if ($r) exit(json_encode(1));
                if ($r) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "删除友情链接" . $logData["link_name"] . "成功");
                    $this->success("操作成功", U("Admin/Article/link/action/page_list"));
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5, "删除友情链接" . $logData["link_name"] . "失败，数据库删除失败");
                    $this->error("操作失败", U("Admin/Article/link/action/page_list"));
                }
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法");
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
                json_return($returnArr);
        }
    }

    /**
     * 招聘信息 - 入口函数
     * page_list，page_info 页面显示
     * page_add，page_edit 编辑页面显示
     * add，edit,del，编辑入口
     */
    public function recruit()
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
                $dataId = $_GET['id'];
                $keyword=trim(I("keyword"));
                if($keyword) {
                    $where["cat_name"] = array("exp", "LIKE '%$keyword%'");
                }
                $where['is_deleted']=0;
                $where['data_id'] = $dataId;
                //查找显示一级分类
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $countTable= M("$tableName")->where("is_deleted=0");
                $count=$countTable->where($where)->count();    //$count    总共有多少条数据
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页

                if (!empty($tableConfigId)) {

                    $infoField =$systemChannelFormField->field("title,name,form_type")->where("table_config_id='$tableConfigId'")->order('admin_sort ')->select();
                    foreach ($infoField as $item => $value) {
                        $pageListData[] = $value['name'];
                    }
                    $pageListTypeData[0]='text';
                    foreach ($infoField as $item => $value) {
                        $pageListTypeData[] = $value['form_type'];
                    }
                    $pageListData1=implode(",",$pageListData);
                    $pageListDataShow =M("$tableName")->field("id,$pageListData1")->where($where)->select();
                    $i=0;
                    foreach ($pageListDataShow as $value) {
                        $m =0;
                        foreach ($value as $key => $value2) {
                            $pageListDataTypeShow[$i][$key]=array('data'=>$value2,'type'=>$pageListTypeData[$m]);
                            $m++;
                        }
                        $i++;
                    }

                    $this->assign('data_id', $dataId);
                    $this->assign('count', $count);
                    $this->assign('page', $page);
                    $this->assign('page_num', $page_num);
                    $this->assign('page_now', $page_now);
                    $this->assign("info", $pageListDataTypeShow);
                    $this->assign("info_field", $infoField);
                    $this->assign("channel", $channel);
                    $this->assign("type", $moduleType);
                    $this->display("recruit_list");
                } else {
                    $returnArr = array("result" => 0, "msg" => "该频道不存在", "code" => 402, "data" => null);
                }
                break;
            case "page_add":
                $dataId = $_GET['data_id'];
                //招聘分类
                $tableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type=9")->getField("table_format");
                $recruit_cat = M("$tableName")
                    ->where("parent_id = 0")
                    ->order('sort')
                    ->select();

                $this->assign('data_id', $dataId);
                $this->assign("channel", $channel);
                $this->assign("type", $moduleType);
                $this->assign('cat_list', $recruit_cat);
                $this->display("recruit_info");
                break;
            case "page_edit":
                if ($getId) {
                    $categoryId = M("$tableName")->field('category_id')->where('id='.$getId)->find();

                    //招聘分类
                    $tableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type=9")->getField("table_format");
                    $recruit_cat = M("$tableName") ->where("parent_id = 0")->order('sort')->select();
                    $dataId = $_GET['data_id'];

                    //找到传进来的id值的信息
                    $this->assign('data_id', $dataId);
                    $this->assign("id", $getId);
                    $this->assign("type", $moduleType);
                    $this->assign("channel", $channel);
                    $this->assign('cat_list', $recruit_cat);
                    $this->assign('category_id', $categoryId['category_id']);
                    $this->display("recruit_info");
                } else {
                    $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
                }
                break;
            case "add":
                $postData = I("post.");
                $info = $this->addCategory($channel, $tableName, $postData);
                if ($info) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加文章分类" . $postData["title"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "提交成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加文章分类失败，数据库录入失败");
                    $returnArr = array("result" => 0, "msg" => "数据已存在", "code" => 402, "data" => null);
                }
                break;
            case "edit":
                $postData = I("post.");
                //设置表单不能为空
                //进入编辑函数
                $info = $this->editCategory($postData);
                if ($info) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "编辑文章分类" . $postData["title"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "提交成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5, "编辑文章分类" . $postData["title"] . "失败，数据库删除失败");
                    $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
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
                        $this->logRecord(6, "删除文章分类" . $logData["title"] . "成功");
                        $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);
                    } else {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(5, "删除文章分类" . $logData["title"] . "失败，数据库删除失败");
                        $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
                    }
                }
                break;
            case "recruit_add":
                $parentId = $_GET['parent_id'];
                if($parentId == null||$parentId==0){
                    $parentId = 0;
                }
                $tableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type=9")->getField("table_format");
                $second_recruit_cat = M("$tableName")
                    ->field("id,title")
                    ->where("parent_id = '$parentId'")
                    ->order('sort')
                    ->select();
                $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $second_recruit_cat);
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
                } else {
                    $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                }
                break;

            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法");
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }

    /*
     * 招聘分类二级类别处理
     */
    public function recruitLevel()
    {
        $info = M("WeifanClass")
            ->field("id,name")
            ->select();
        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
        json_return($returnArr);
    }

    /**
     * 资料管理 - 入口函数
     * page_list，page_info 页面显示
     * page_add，page_edit 编辑页面显示
     * add，edit,del，编辑入口
     */
    public function file()
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


                $where['is_deleted']=0;

                $dataId = $_GET['id'];
                if($dataId){
                    $where['data_id'] = $dataId;
                }

                //查找显示一级分类
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $countTable= M("$tableName")->where("is_deleted=0");
                $count=$countTable->where($where)->count();    //$count    总共有多少条数据
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页

                if (!empty($tableConfigId)) {

                    $infoField =$systemChannelFormField->field("title,name,form_type")->where("table_config_id='$tableConfigId'")->order('admin_sort ')->select();
                    foreach ($infoField as $item => $value) {
                        $pageListData[] = $value['name'];
                    }
                    $pageListTypeData[0]='text';
                    foreach ($infoField as $item => $value) {
                        $pageListTypeData[] = $value['form_type'];
                    }
                    $pageListData1=implode(",",$pageListData);
                    $pageListDataShow =M("$tableName")->field("id,$pageListData1")->where($where)->select();
                    $i=0;
                    foreach ($pageListDataShow as $value) {
                        $m =0;
                        foreach ($value as $key => $value2) {
                            $pageListDataTypeShow[$i][$key]=array('data'=>$value2,'type'=>$pageListTypeData[$m]);
                            $m++;
                        }
                        $i++;
                    }

                    $this->assign('data_id', $dataId);
                    $this->assign('count', $count);
                    $this->assign('page', $page);
                    $this->assign('page_num', $page_num);
                    $this->assign('page_now', $page_now);
                    $this->assign("info", $pageListDataTypeShow);
                    $this->assign("info_field", $infoField);
                    $this->assign("channel", $channel);
                    $this->assign("type", $moduleType);
                    $this->display("file_list");
                } else {
                    $returnArr = array("result" => 0, "msg" => "该频道不存在", "code" => 402, "data" => null);
                }
                break;
            case "page_add":

                $dataId = $_GET['data_id'];

                $this->assign('data_id', $dataId);
                $this->assign("channel", $channel);
                $this->assign("type", $moduleType);
                $this->display("file_info");
                break;
            case "page_edit":
                if ($getId) {
                    $dataId = $_GET['data_id'];
                    //找到传进来的id值的信息
                    $this->assign('data_id', $dataId);
                    $this->assign("id", $getId);
                    $this->assign("type", $moduleType);
                    $this->assign("channel", $channel);
                    $this->display("file_info");
                } else {
                    $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
                }
                break;
            case "add":
                $postData = I("post.");
                $info = $this->addCategory($channel, $tableName, $postData);
                if ($info) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加文章分类" . $postData["title"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "提交成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加文章分类失败，数据库录入失败");
                    $returnArr = array("result" => 0, "msg" => "数据已存在", "code" => 402, "data" => null);
                }
                break;
            case "edit":
                $postData = I("post.");
                //设置表单不能为空
                //进入编辑函数
                $info = $this->editCategory($postData);
                if ($info) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "编辑文章分类" . $postData["title"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "提交成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5, "编辑文章分类" . $postData["title"] . "失败，数据库删除失败");
                    $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
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
                        $this->logRecord(6, "删除文章分类" . $logData["title"] . "成功");
                        $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);
                    } else {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(5, "删除文章分类" . $logData["title"] . "失败，数据库删除失败");
                        $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
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
                } else {
                    $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
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
     * 资料管理 - 入口函数
     * page_list，page_info 页面显示
     * page_add，page_edit 编辑页面显示
     * add，edit,del，编辑入口
     */
    public function news()
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


                $where['is_deleted']=0;

                $keyword=trim(I("keyword"));
                $dataId = $_GET['id'];
                if($dataId){
                    $where['data_id'] = $dataId;
                }

                //查找显示一级分类
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $countTable= M("$tableName")->where("is_deleted=0");
                $count=$countTable->where($where)->count();    //$count    总共有多少条数据
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页

                if (!empty($tableConfigId)) {

                    $infoField =$systemChannelFormField->field("title,name,form_type")->where("table_config_id='$tableConfigId'")->order('admin_sort ')->select();
                    foreach ($infoField as $item => $value) {
                        $pageListData[] = $value['name'];
                    }
                    $pageListTypeData[0]='text';
                    foreach ($infoField as $item => $value) {
                        $pageListTypeData[] = $value['form_type'];
                    }
                    $pageListData1=implode(",",$pageListData);
                    $pageListDataShow =M("$tableName")->field("id,$pageListData1")->where($where)->select();
                    $i=0;
                    foreach ($pageListDataShow as $value) {
                        $m =0;
                        foreach ($value as $key => $value2) {
                            $pageListDataTypeShow[$i][$key]=array('data'=>$value2,'type'=>$pageListTypeData[$m]);
                            $m++;
                        }
                        $i++;
                    }

                    $this->assign('data_id', $dataId);
                    $this->assign('count', $count);
                    $this->assign('page', $page);
                    $this->assign('page_num', $page_num);
                    $this->assign('page_now', $page_now);
                    $this->assign("info", $pageListDataTypeShow);
                    $this->assign("info_field", $infoField);
                    $this->assign("channel", $channel);
                    $this->assign("type", $moduleType);
                    $this->display("news_list");
                } else {
                    $returnArr = array("result" => 0, "msg" => "该频道不存在", "code" => 402, "data" => null);
                }
                break;
            case "page_add":

                $dataId = $_GET['data_id'];

                $this->assign('data_id', $dataId);
                $this->assign("channel", $channel);
                $this->assign("type", $moduleType);
                $this->display("news_info");
                break;
            case "page_edit":
                if ($getId) {
                    $dataId = $_GET['data_id'];

                    $this->assign('data_id', $dataId);
                    //找到传进来的id值的信息
                    $this->assign("id", $getId);
                    $this->assign("type", $moduleType);
                    $this->assign("channel", $channel);
                    $this->display("news_info");
                } else {
                    $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
                }
                break;
            case "add":
                $postData = I("post.");
                $info = $this->addCategory($channel, $tableName, $postData);
                if ($info) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加文章分类" . $postData["title"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "提交成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加文章分类失败，数据库录入失败");
                    $returnArr = array("result" => 0, "msg" => "数据已存在", "code" => 402, "data" => null);
                }
                break;
            case "edit":
                $postData = I("post.");
                //设置表单不能为空
                //进入编辑函数
                $info = $this->editCategory($postData);
                if ($info) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "编辑文章分类" . $postData["title"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "提交成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5, "编辑文章分类" . $postData["title"] . "失败，数据库删除失败");
                    $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
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
                        $this->logRecord(6, "删除文章分类" . $logData["title"] . "成功");
                        $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);
                    } else {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(5, "删除文章分类" . $logData["title"] . "失败，数据库删除失败");
                        $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
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
                } else {
                    $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
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
     * 级别管理 - 入口函数
     * page_list，page_info 页面显示
     * page_add，page_edit 编辑页面显示
     * add，edit,del，编辑入口
     */
    public function level()
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
                    $where["level_name"] = array("EXP", "LIKE '%$keyword%'");
                }
                $where['is_deleted']=0;
                //查找显示一级分类
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $countTable= M("$tableName")->where("is_deleted=0");
                $count=$countTable->where($where)->count();    //$count    总共有多少条数据
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页

                if (!empty($tableConfigId)) {

                    $infoField =$systemChannelFormField->field("title,name,form_type")->where("table_config_id='$tableConfigId'")->order('admin_sort ')->select();
                    foreach ($infoField as $item => $value) {
                        $pageListData[] = $value['name'];
                    }
                    $pageListTypeData[0]='text';
                    foreach ($infoField as $item => $value) {
                        $pageListTypeData[] = $value['form_type'];
                    }
                    $pageListData1=implode(",",$pageListData);
                    $pageListDataShow =M("$tableName")->field("id,$pageListData1")->where($where)->select();
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


                    $this->assign('count', $count);
                    $this->assign('page', $page);
                    $this->assign('page_num', $page_num);
                    $this->assign('page_now', $page_now);
                    $this->assign("info", $pageListDataTypeShow);
                    $this->assign("info_field", $infoField);
                    $this->assign("channel", $channel);
                    $this->assign("type", $moduleType);
                    $this->display("level_list");
                } else {
                    $returnArr = array("result" => 0, "msg" => "该频道不存在", "code" => 402, "data" => null);
                }
                break;
            case "page_add":
                //查询分类树
                $this->assign("channel", $channel);
                $this->assign("type", $moduleType);
                $this->display("level_info");
                break;
            case "page_edit":
                if ($getId) {
                    //找到传进来的id值的信息
                    $this->assign("id", $getId);
                    $this->assign("type", $moduleType);
                    $this->assign("channel", $channel);
                    $this->display("level_info");
                } else {
                    $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
                }
                break;
            case "add":
                $postData = I("post.");
                $returnArr = array("result" => 0, "msg" => "该名称已存在！不能重复", "code" => 402, "data" => null);
                $where=array("level_name = '" . $postData['level_name'] . "'");
                if(M("$tableName")->where($where)->count()){
                    json_return($returnArr);
                }
                $info = $this->addCategory($channel, $tableName, $postData);
                if ($info) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加文章分类" . $postData["title"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "提交成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加文章分类失败，数据库录入失败");
                    $returnArr = array("result" => 0, "msg" => "数据已存在", "code" => 402, "data" => null);
                }
                break;
            case "edit":
                $postData = I("post.");
                //设置表单不能为空
                //进入编辑函数
                $info = $this->editCategory($postData);
                if ($info) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "编辑文章分类" . $postData["title"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "提交成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5, "编辑文章分类" . $postData["title"] . "失败，数据库删除失败");
                    $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
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
                        $this->logRecord(6, "删除文章分类" . $logData["title"] . "成功");
                        $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);
                    } else {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(5, "删除文章分类" . $logData["title"] . "失败，数据库删除失败");
                        $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
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
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法");
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }


    /**
     * 招聘分类 - 入口函数
     * page_list，page_info 页面显示
     * page_add，page_edit 编辑页面显示
     * add，edit,del，编辑入口
     */
    public function recruit_cat()
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
                //查找显示一级分类
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $countTable= M("$tableName")->where("is_deleted=0");
                $count=$countTable->where($where)->count();    //$count    总共有多少条数据
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页

                if (!empty($tableConfigId)) {

                    $infoField =$systemChannelFormField->field("title,name,form_type")->where("table_config_id='$tableConfigId'")->order('admin_sort ')->select();
                    foreach ($infoField as $item => $value) {
                        $pageListData[] = $value['name'];
                    }
                    $pageListTypeData[0]='text';
                    foreach ($infoField as $item => $value) {
                        $pageListTypeData[] = $value['form_type'];
                    }
                    $pageListData1=implode(",",$pageListData);
                    $pageListDataShow =M("$tableName")->field("id,$pageListData1")->where($where)->order("sort asc")->select();

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


                    $this->assign('count', $count);
                    $this->assign('page', $page);
                    $this->assign('page_num', $page_num);
                    $this->assign('page_now', $page_now);
                    $this->assign("info", $pageListDataTypeShow);
                    $this->assign("info_field", $infoField);
                    $this->assign("channel", $channel);
                    $this->assign("type", $moduleType);
                    $this->display("recruit_cat_list");
                } else {
                    $returnArr = array("result" => 0, "msg" => "该频道不存在", "code" => 402, "data" => null);
                }
                break;
            case "page_add":
                //查询分类树
                $this->assign("channel", $channel);
                $this->assign("type", $moduleType);
                $this->display("recruit_cat_info");
                break;
            case "page_edit":
                if ($getId) {
                    //找到传进来的id值的信息
                    $this->assign("id", $getId);
                    $this->assign("type", $moduleType);
                    $this->assign("channel", $channel);
                    $this->display("recruit_cat_info");
                } else {
                    $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
                }
                break;
            case "add":
                $postData = I("post.");
                $returnArr = array("result" => 0, "msg" => "该名称已存在！不能重复", "code" => 402, "data" => null);
                $where=array("title = '" . $postData['title'] . "'");
                if(M("$tableName")->where($where)->count()){
                    json_return($returnArr);
                }
                $info = $this->addCategory($channel, $tableName, $postData);
                if ($info) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加文章分类" . $postData["title"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "提交成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加文章分类失败，数据库录入失败");
                    $returnArr = array("result" => 0, "msg" => "数据已存在", "code" => 402, "data" => null);
                }
                break;
            case "edit":
                $postData = I("post.");
                //设置表单不能为空
                //进入编辑函数
                $info = $this->editCategory($postData);
                if ($info) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "编辑文章分类" . $postData["title"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "提交成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5, "编辑文章分类" . $postData["title"] . "失败，数据库删除失败");
                    $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
                }

                break;
            case "del":
                //查找删除的id是否有子级
                if ($getId) {
                    $tableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("table_format");
                    $returnArr = array("result" => 0, "msg" => "此类别下面有数据", "code" => 402, "data" => null);
                    $category= M("SystemChannelTableConfig")->where("channel='$channel' AND type=1")->getField("table_format");
                    $where=array("category_id = '" . $getId . "'","is_deleted=0");
                    if(M("$category")->where($where)->count()){
                        json_return($returnArr);
                    }
                    $logData = M("$tableName")->where("id=$getId")->find();
                    $result = M("$tableName")->where("id=$getId")->setField("is_deleted", 1);
                    if ($result) {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(6, "删除文章分类" . $logData["title"] . "成功");
                        $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);
                    } else {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(5, "删除文章分类" . $logData["title"] . "失败，数据库删除失败");
                        $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
                    }
                }
                break;
            case "extends":
                if ($channel) {
                    $systemChannelFormField = M("SystemChannelFormField");
                    $extends = $systemChannelFormField->field("name,title,form_type,default_value,item_option,valid_tip_msg,valid_error_msg,valid_pattern,date_format,file_format,is_relation")->where("table_config_id='$tableConfigId'")->order('admin_sort')->select();
                    $extendValCont = M("$tableName")->where("id='$getId' AND is_deleted=0")->find();

                    $recruitTable = M("SystemChannelTableConfig")
                        ->where("channel = '$channel' AND type = 9")
                        ->getField("table_format");
                    $recruit = M($recruitTable)
                        ->field("id as value,title as name,is_deleted as checked")
                        ->where("is_deleted = 0 AND parent_id = 0")
                        ->select();
                    $parent = array(
                        'value' => 0,
                        'name' => '无父类',
                        'checked' => 1
                    );
                    $i =1 ;
                    $recruitData[0] = $parent;
                    foreach ($recruit as $value) {
                        $recruitData[$i] = $value;
                        $i ++;
                    }
                    $i = 0;
                    foreach ($extends as $extend) {
                        $op = array();
                        if (!empty($extend['item_option'])) {
                            $itemStr =  json_decode($extend['item_option'], true);
                        }
                        if($extend['form_type'] == 'select') {
                            $extends[$i]['item_option'] = $recruitData;
                        } else {
                            $extends[$i]['item_option'] = $itemStr;
                        }

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
            case "list":
                $keyword = trim(I("cat_name"));
                if($keyword) {
                    $where["cat_name"] = array("exp", "LIKE '%$keyword%'");
                }
                $where['is_deleted']=0;
                //查找显示一级分类
                $page_num = I('post.page_num', 8);   //$page_num 每页几条数据
                $page_now = I('post.page_now', 1);   //$page_now 第几页
                $count=M("$tableName")->where($where)->count();    //$count    总共有多少条数据
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page  总共有几页

                $data = M("$tableName")->where($where)->field('id, cat_name, sort_num')->select();
                if($data)  {

                    $returnArr = array("result" => 1, "msg" => "获取数据中成功", "code" => 200, "data" => $data);
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


    /**
     * 初始化编辑器链接
     * @param $post_id post_id
     */
    private function initEditor()
    {
        $this->assign("URL_upload", U("Admin/Ueditor/imageUp", array("savepath" => "company")));
        $this->assign("URL_fileUp", U("Admin/Ueditor/fileUp", array("savepath" => "company")));
        $this->assign("URL_scrawlUp", U("Admin/Ueditor/scrawlUp", array("savepath" => "company")));
        $this->assign("URL_getRemoteImage", U("Admin/Ueditor/getRemoteImage", array("savepath" => "company")));
        $this->assign("URL_imageManager", U("Admin/Ueditor/imageManager", array("savepath" => "company")));
        $this->assign("URL_imageUp", U("Admin/Ueditor/imageUp", array("savepath" => "company")));
        $this->assign("URL_getMovie", U("Admin/Ueditor/getMovie", array("path" => "company")));
        $this->assign("URL_Home", "");
    }
}
