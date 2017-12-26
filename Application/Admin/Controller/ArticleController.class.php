<?php

namespace Admin\Controller;

use Admin\Util\GetFirstCharterUtil;
use Think\Log;

class ArticleController extends BaseController
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

    /**
     * 内容管理 - 入口函数
     * page_list，page_info 页面显示
     * page_add，page_edit 编辑页面显示
     * add，edit,del，编辑入口
     */

    public function article()
    {
        $action = $_GET["action"];//action/page_list
        $getId = $_GET["id"];

        $channel = $_GET["channel"];//channel/article_info
        //在SystemChannel表中根据传来的channel名字article_info找到相应的id（每一个channel别名都有一个唯一的ID）
        $moduleType = $_GET['type'];
        $categoryId = $_GET["category_id"];
        $channelId = M("SystemChannel")->where("call_index='$channel'")->getField("id");
        $tableConfigId = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("id");
        $systemChannel = M("SystemChannel")->field("id,is_export_data")->where("call_index='$channel'")->find();
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
                $ff = I("get.");
                $data['call_index']=$channel;
                $lead=M("SystemChannel")->where($data)->field("is_import_data,is_export_data")->select();
                $this->assign("lead",$lead);
                $condition['table_config_id'] = $tableConfigId;
                $condition['show_list'] = 1;
                // $condition['table_name'] =$tableName2;
                $infoField =$systemChannelFormField->field("title,name,form_type")->where($condition)->order('admin_sort')->select();
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $info['is_deleted']=0;
                $keyword2 =trim(I("post.keyword"));
                $keyword3 = $_GET["keyword"];
                if($keyword2){
                    $keyword = $keyword2;
                } else {
                    $keyword= $keyword3;
                }
                $gotPage=I("gotPage");
                if($gotPage){
                    $page_now=$gotPage;
                }
                if($keyword){
                    $info['title|content']=array("EXP","LIKE '%$keyword%'");
                }
                if($categoryId>0) {
                    $info['category_id']=$categoryId;
                }
                $count= M("$tableName")->where($info)->count();//$count    总共有多少条数据

                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                foreach ($infoField as $item => $value) {
                    $pageListData[] = $value['name'];
                }
                $pageListTypeData[0]='text';
                foreach ($infoField as $item => $value) {
                    $pageListTypeData[] = $value['form_type'];
                }
                $pageListData1=implode(",",$pageListData);
                $keyword2 =trim(I("post.keyword"));
                $keyword3 = $_GET["keyword"];
                if($keyword2){
                    $keyword = $keyword2;
                } else {
                    $keyword= $keyword3;
                }
                if($keyword)
                {
                    $where['V.title|V.content'] = array('like', "%$keyword%");
                }
                $where['V.is_deleted']=0;
                if($categoryId>0) {
                    $where['V.category_id']=$categoryId;
                }


                $pageListDataShow =M("$tableName")
                    ->join("AS V LEFT JOIN  $category B ON V.category_id=B.id")
                    ->page($page_now, $page_num)
                    ->field("V.id,$pageListData1,B.cat_name,V.status,V.is_active")
                    ->where($where)
                    ->order("id desc")
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
                    if($categoryId) {
                        $this->assign("category_id",$categoryId);
                    } else{
                        $this->assign("category_id",0);
                    }
                   
                    $this->assign("keyword",$keyword);
                     $this->assign("category_name",$categoryName);
                    $this->assign('page', $page);
                    $this->assign('page_num', $page_num);
                    $this->assign('page_now', $page_now);
                    $this->assign("info", $pageListDataTypeShow);
                    $this->assign("is_copy", $is_copy);
                    $this->assign("is_export_data", $systemChannel['is_export_data']);
                    $this->assign("info_field", $infoField);
                    $this->assign("channel", $channel);
                    $this->assign('tableName', $tableName);
                    $this->assign("type", $moduleType);
                    $this->display("article_list");
                    $this->logRecord(6,"查看数据",2,$channel_id,$getId);
                } else {
                    $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                }
                break;
            case "page_add":
                if ($channel) {
                    if($getId) {
                        $infoField =$systemChannelFormField->field("title,name")->where("table_config_id='$tableConfigId'")->order('admin_sort')->select();
                        $channel_id = M("$tableName")->getField("channel_id");
                        $systemLog = M("SystemLog")->field("log_id,admin_id,admin_user_name,log_time,log_info,log_ip")->where("channel_id='$channel_id' AND data_id='$getId' AND operate_type!=4")->select();
                        foreach ($infoField as $item => $value) {
                            $pageListData[] = $value['name'];
                        }
                        $pageListData1=implode(",",$pageListData);
                        $condition['id'] = $getId;
                        $condition['is_deleted'] = 0;
                        $pageListDataShow = M("$tableName")->field("id,$pageListData1")->where($condition)->find();
                        $data = $pageListDataShow;
                        $article = M("$tableName")->where($condition)->find();
                        $categoryTableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type=2")->getField("table_format");
                        $categoryData = M("$categoryTableName")->field('id, cat_name')->where('is_deleted=0')->order('sort_num')->select();

                        //判断是否是否需要绑定用户
                        $is_bind_user = M("SystemChannel")->where("call_index='$channel'")->getField("is_bind_user");
                        $this->assign('is_bind_user', $is_bind_user);
                        //判断是否需要开启置顶
                        $is_top = M("SystemChannel")->where("call_index='$channel'")->getField("is_top");
                        $this->assign('is_top', $is_top);

                        $this->assign("iscopy",'1'); //为1是copy不是正常的新增
                        $this->assign("id", $getId);
                        $this->assign("ifadd",'');
                        $this->assign("channel", $channel);
                        $this->assign("type", $moduleType);
                        $this->assign('system_log', $systemLog);
                        $this->assign('info', $article);
                        $this->assign("data", $data);
                        $this->assign('category_data', $categoryData);

                        $this->display("article_info");
                    } else {
                        //判断是否是否需要绑定用户
                        $is_bind_user = M("SystemChannel")->where("call_index='$channel'")->getField("is_bind_user");
                        $this->assign('is_bind_user', $is_bind_user);
                        //判断是否是否需要绑定用户

                        $this->assign("iscopy",'0'); //为0不是copy是正常的新增
                        $this->assign("ifadd",'');
                        $this->assign("channel", $channel);
                        $this->assign("type", $moduleType);
                        $categoryTableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type=2")->getField("table_format");
                        $categoryData = M("$categoryTableName")->field('id, cat_name')->where('is_deleted=0')->order('sort_num')->select();
                        $userName = M("ManageUsers")->where("user_id=".$_SESSION['admin_id'])->getField("user_name");
                        $tagsTableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type=4")->getField("table_format");
                        $tagsInfo = M("$tagsTableName")->field("id,tag_name")->where("status = 1 AND is_deleted!=1")->select();
                        if($tagsInfo) {
                            $ifTags = 1;
                        } else {
                            $ifTags = 0;
                        }

                        if($channel=="js"||$channel=="jtgs"){
                            $data_hzjg=M('article_hzjg')->select();
                            if($channel=='js'){
                                $this->assign('hzjg','js');
                            }else{
                                $this->assign('hzjg','jtgs');
                            }

                            $this->assign('data_hzjg',$data_hzjg);
                        }
                        $this->assign("tags_info", $tagsInfo);
                        $this->assign("if_tags", $ifTags);
                        $this->assign('currentUser', $userName);
                        $this->assign('currentDate', date("Y-m-d"));
                        $this->assign('category_data', $categoryData);
                        $this->display("article_info");
                    }
                } else {
                    $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                }
                break;
            case "page_edit":
                if ($channel) {
                    if ($getId) {
                        $date['data_id']=$getId;
                        $lead=M("Article_".$channel."ViewRecord")->where($date)->field("data_id")->count();

                        $infoField =$systemChannelFormField->field("title,name")->where("table_config_id='$tableConfigId'")->order('admin_sort')->select();
                        $channel_id = M("$tableName")->getField("channel_id");
                        $systemLog = M("SystemLog")->field("log_id,admin_id,admin_user_name,log_time,log_info,log_ip")->where("channel_id='$channel_id' AND data_id='$getId' AND operate_type!=4")->select();
                        foreach ($infoField as $item => $value) {
                            $pageListData[] = $value['name'];
                        }
                        $pageListData1=implode(",",$pageListData);

                        $condition['id'] = $getId;
                        $condition['is_deleted'] = 0;
                        $pageListDataShow = M("$tableName")->field("id,is_red,is_hot,$pageListData1")->where($condition)->find();

                        $data = $pageListDataShow;

                        $article = M("$tableName")->where($condition)->find();
                        $categoryTableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type=2")->getField("table_format");
                        $categoryData = M("$categoryTableName")->field('id, cat_name')->where('is_deleted=0')->order('sort_num')->select();
                        //专题
                        $zutiData = M("ArticleZtgl")->field("id,title")->where("is_deleted=0")->select();
                        $this->assign("zutiData",$zutiData);
                        $jschannel = M("SystemChannel")->where("call_index='$channel'")->getField("call_index");
                        $this->assign("jschannel",$jschannel);
                        $tagsTableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type=4")->getField("table_format");
                        $tagsRelationTableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type=5")->getField("table_format");
                        $tagsInfo = M("$tagsTableName")->field("id,tag_name")->where("status = 1 AND is_deleted=0")->select();
                        $tagsRelationInfo = M("$tagsRelationTableName")->field("tag_id ")->where("channel_id = {$systemChannel['id']} AND data_id = '$getId'")->select();
                        $trInfo = array();
                        $checkTagIdArr = array();
                        $i = 0;
                        foreach($tagsRelationInfo as $item){
                            $checkTagIdArr[$i] = $item['tag_id'];
                            $i++;
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
                        $conf['channel_index'] = $channel;
                        $child = M('SystemChannelChild')->field('id,title,channel_index, type, has_relation')->where($conf)->select();

                        //判断是否是否需要绑定用户
                        $is_bind_user = M("SystemChannel")->where("call_index='$channel'")->getField("is_bind_user");
                        $this->assign('is_bind_user', $is_bind_user);
                        //判断是否需要开启置顶
                        $is_top = M("SystemChannel")->where("call_index='$channel'")->getField("is_top");
                        $this->assign('is_top', $is_top);

                        //获取绑定过的企业个户
                        $relation=M('SystemRelation')->where("channel_id=".$channelId." AND data_id=".$getId)->find();
                        if($relation){
                            $bind_user_id=$relation['user_id'];
                            $userModel=M('ManageUsers')->where("user_id='$bind_user_id'")->find();
                            $bind_user_name=$userModel['user_name'];
                        }
                        
                        
                        $categoryId = $_GET['category_id'];
                        $keyword = $_GET['keyword'];
                        if($categoryId) {
                            $this->assign('category_id', $categoryId);
                        } else {
                            $this->assign('category_id', 0);
                        }

                        //应用事例
                        if($channel=="hzjg"){
                            $yysl=M('article_relation_yysl')->where('hzjg_id='.$getId)->select();
                            $this->assign('yysl',$yysl);
                        }

                        if($channel=="js"||$channel=="jtgs"){
                            $data_hzjg=M('article_hzjg')->select();
                            if($channel=='js'){
                                $this->assign('hzjg','js');
                            }else{
                                $arrHzjg=explode(',',$article['hzjg_id']);
                                $this->assign('arrHzjg',$arrHzjg);
                                $this->assign('hzjg','jtgs');
                            }

                            $this->assign('data_hzjg',$data_hzjg);
                        }

                        $this->assign('keyword', $keyword);
                        $pageNow = $_GET["page_now"];
                        $pageNum = $_GET['page_num'];
                        $this->assign('page_now', $pageNow);
                        $this->assign("page_num",$pageNum);
                        $this->assign('child', $child);
                        $this->assign("lead",$lead);
                        $this->assign('ifcheck',1);
                        $this->assign("tags_info", $tagsInfo);
                        $this->assign("if_tags", $ifTags);
                        $this->assign("ifadd",'b');
                        $this->assign("id", $getId);
                        $this->assign("channel", $channel);
                        $this->assign("type", $moduleType);
                        $this->assign('system_log', $systemLog);
                        $this->assign('info', $article);
                        $this->assign("data", $data);
                        $this->assign('category_data', $categoryData);
                        //绑定的用户信息
                        $this->assign("bind_user_id", $bind_user_id);
                        $this->assign("bind_user_name", $bind_user_name);



                        $this->display("article_info");
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

                    //判断是否置顶数据
                    if($postData['is_red']!="1"){
                        $postData['is_red']=0;
                    }
                    //检查用户是否绑定过
//                    if(M('SystemRelation')->where("channel_id=".$channelId." AND user_id=".$postData['bind_user_id'])->count()>0) {
//                        $this->logRecord(5, "新增数据【" . $postData["title"] . "】失败，用户重复绑定",3);
//                        $returnArr = array("result" => 0, "msg" => "保存失败，用户重复绑定", "code" => 402, "data" => null);
//                        break;
//                    }
                    //添加函数
                    $dataId = $this->addArticle($channel, $tableName, $postData,$isCopy);
                    if ($dataId) {
                        //根据绑定用户id，记录绑定关系
                        //$this->bindUser($channelId,$postData['bind_user_id'],$dataId);

                        //处理tag
                       if($tags) {
                            foreach ( $tags as $value){
                                $tagInfo = M("$tagsTable")->field("remark,tag_name")->where("id = '$value'")->find();
                                $relationData['channel_id'] = $systemChannel['id'];
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
                            $this->logRecord(6,"自动审核文章" . $postData["title"]. "成功",6,$channel_id,$dataid);
                        }
                        //记录操作日志
                        $this->logRecord(6,"添加文章" . $postData["title"]. "成功",3,$channel_id,$dataid);
                        $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                    } else {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(5, "添加文章" . $postData["title"] . "失败");
                        $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
                    }
                } else {
                    $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                }
                break;
            case "edit":
                if ($channel) {
                    $recovery = $_GET["recovery"];
                    $postData = I("post.");
                    $getData = I("get.");
                    $tags = $postData['tag_name'];
                    $tagsTable = M("SystemChannelTableConfig")->where("channel='$channel' AND type='4'")->getField("table_format");
                    $tagsRelationTable = M("SystemChannelTableConfig")->where("channel='$channel' AND type='5'")->getField("table_format");

                    //判断是否置顶数据
                    if($postData['is_red']!="1"){
                        $postData['is_red']=0;
                    }
                    //检查用户是否绑定过
//                    if(M('SystemRelation')->where("data_id !=".$postData['id']." AND channel_id =".$channelId." AND user_id=".$postData['bind_user_id'])->count()>0) {
//                        $this->logRecord(5, "编辑数据【" . $postData["title"] . "】失败，用户重复绑定",3);
//                        $returnArr = array("result" => 0, "msg" => "保存失败，用户已被绑定", "code" => 402, "data" => null);
//                        break;
//                    }

                    if ($recovery == 1) {
                        $info = $this->editArticle($getData);
                    } else {
                        $info = $this->editArticle($postData);
                    }

                    if ($info) {//处理tag
                        if($systemChannel['id']>0 && $getId>0 ) {
                            $result = M("$tagsRelationTable")->where("channel_id = '{$systemChannel['id']}' AND data_id = '$getId'")->delete();
                        }
                        if($tags) {
                            foreach ( $tags as $value){
                                $tagInfo =  M("$tagsTable")->field("remark,tag_name")->where("id = '$value'")->find();
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
                            $this->logRecord(6,"恢复数据". $postData["title"],4,$channel_id,$getId);
                            $this->redirect("Admin/Article/article/action/recycle_page_list/channel/$channel/type/1");
                        }else{
                            $this->logRecord(6,"修改数据". $postData["title"]."成功",4,$channel_id,$getId);
                        }
                        $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                    } else {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(6, "修改数据" . $postData["title"] . "失败");
                        $returnArr = array("result" => 0, "msg" => "修改失败，请重试", "code" => 402, "data" => null);
                    }
                } else {
                    $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
                }
                break;
            case "del":
                if ($channel) {
                    if ($getId) {
                        $tableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("table_format");
                        $logData = M("$tableName")->where("id=$getId")->find();
                        $result = M("$tableName")->where("id=$getId")->setField("is_deleted",1);

                        if ($result) {
                            $tagsRelationTable = M("SystemChannelTableConfig")->where("channel='$channel' AND type='5'")->getField("table_format");
                            if($systemChannel['id'] > 0) {
                                $result2 = M("$tagsRelationTable")->where("channel_id = '{$systemChannel['id']}' AND data_id = '$getId' ")->delete();
                            }
                            
                            //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                            $channel_id = M("$tableName")->getField("channel_id");
                            $this->logRecord(6,"删除【" . $logData["title"]. "】成功",5,$channel_id,$getId);
                            $returnArr = array("result" => 1, "msg" => "已放入回收站", "code" => 200, "data" => null);
                        } else {
                            //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                            $this->logRecord(5, "删除【" . $logData["title"] . "】失败");
                            $returnArr = array("result" => 0, "msg" => "删除", "code" => 402, "data" => null);
                        }
                    } else {
                        $this->logRecord(5, "删除文章失败，数据不存在");
                        $returnArr = array("result" => 0, "msg" => "删除失败，该数据不存在", "code" => 402, "data" => null);
                    }
                } else {
                    $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
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
                            $this->logRecord(6,"删除【" . $logData["title"]. "】成功",5, $channel_id,$getId);
                            $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);
                        } else {
                            //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                            $this->logRecord(5, "删除文章" . $logData["title"] . "失败");
                            $returnArr = array("result" => 0, "msg" => "删除失败", "code" => 402, "data" => null);
                        }
                    } else {
                        $this->logRecord(5, "删除文章失败，数据不存在");
                        $returnArr = array("result" => 0, "msg" => "删除失败，该数据不存在", "code" => 402, "data" => null);
                    }
                } else {
                    $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
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
                    $this->display("article_recycle_list");
                    $this->logRecord(6,"查看数据",4,$channel_id,$getId);
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
                    //exit(json_encode($returnArr));
                } else {
                    $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                }
                break;
            case "search":
               /* $getId = $_GET["id"];
                $channel=$_GET['channel'];

                $where=array("A.category_id"=>$getId['id']);
                $where['A.is_deleted']=0;

                $data=M("$tableName")->join("AS A LEFT JOIN $category AS B ON A.category_id=B.id")
                    ->field("A.id,A.title,A.cover_url,A.link,A.desc,A.content,B.cat_name,A.status,A.status")
                    ->where($where)
                    ->select();

                $count=M("$tableName")->join("AS A LEFT JOIN $category AS B ON A.category_id=B.id")->where($where)->count();
                if($data){
                    $returnArr=array("result"=>1,"msg"=>"获取数据成功","code"=>402,"data"=>$data,"count"=>$count);
                }else {
                    $returnArr=array("result"=>0,"msg"=>"获取数据失败","code"=>200,"data"=>null);
                }
                $this->assign("channel",$channel);*/
                $categoryId = $_GET["category_id"];
                $data['call_index']=$channel;
                $lead=M("SystemChannel")->where($data)->field("is_import_data,is_export_data")->select();
                $this->assign("lead",$lead);
                $condition['table_config_id'] = $tableConfigId;
                $condition['show_list'] = 1;
                // $condition['table_name'] =$tableName2;
                $infoField =$systemChannelFormField->field("title,name,form_type")->where($condition)->order('admin_sort')->select();
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $info['is_deleted']=0;
                $count= M("$tableName")->where($info)->count();//$count    总共有多少条数据
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                foreach ($infoField as $item => $value) {
                    $pageListData[] = $value['name'];
                }
                $pageListTypeData[0]='text';
                foreach ($infoField as $item => $value) {
                    $pageListTypeData[] = $value['form_type'];
                }
                $pageListData1=implode(",",$pageListData);
                $where['V.is_deleted']=0;
                $where['V.category_id']=$categoryId;
                $pageListDataShow =M("$tableName")
                    ->join("AS V LEFT JOIN  $category B ON V.category_id=B.id")
                    ->page($page_now, $page_num)
                    ->field("V.id,$pageListData1,B.cat_name,V.status,V.is_active")
                    ->where($where)
                    ->order("id desc")
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
                    $this->assign("is_export_data", $systemChannel['is_export_data']);
                    $this->assign("info_field", $infoField);
                    $this->assign("channel", $channel);
                    $this->assign('tableName', $tableName);
                    $this->assign("type", $moduleType);
                    $this->display("article_list");
                    $this->logRecord(6,"查看数据",2,$channel_id,$getId);
                } else {
                    $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
                }
                break;
            case "list": //数据列表
                //获取表头

                $conf['table_config_id'] = $tableConfigId;
                $conf['show_list'] = 1;
                $info = $systemChannelFormField->field('title,name')->where($conf)->order('admin_sort')->select();
                $titles[0] = 'ID';
                $fields[0] = 'id';
                if($info){
                    $i = 1;
                    foreach($info as $item){
                        $titles[$i] = $item['title'];
                        $fields[$i] = $item['name'];
                        $i++;
                    }
                }

                $data['titles'] = $titles;
                $data['fields'] = $fields;
                //获取数据
                $where['is_deleted'] = 0;
                if($_GET['data_id']){
                    $where['data_id'] = $_GET['data_id'];
                }

                $table = getTableStr($channel, $moduleType, 'table_format');
                if($_GET['not_paging']){ //不分页
                    $list = M($table)->field($fields)->where($where)->select();
                }else{ //分页
                    $count = M($table)->where($where)->count();          //$count    总共有多少条数据
                    $page_num = I('post.page_num', null) ? I('post.page_num') : 10;   //$page_num 每页几条数据
                    $page_now = I('post.page_now', 1);   //$page_now 第几页
                    $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页

                    $list = M($table)->field($fields)->page($page_now, $page_num)->where($where)->select();

                    $pageConfig['num'] = $page_num;
                    $pageConfig['now'] = $page_now;
                    $pageConfig['total'] = $page;
                    $data['page'] = $pageConfig;

                }

                $data['list'] = $list;
                $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $data);

                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法");
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

            case "update_status":
                if ($channel) {
                    $id = $_POST['id'];
                    $status = $_POST['status'];
                    if ($id) {
                        $tableName = $this->getTableName($channel, $moduleType);
                        $article = M("$tableName")->where('id='.$id)->find();
                        $flag = M("$tableName")->where('id='.$id)->setField('status', $status);

                        if($flag === false){
                            $this->logRecord(5, "审核【".$article["title"]."】失败", 9, $article['channel_id'], $id);
                            $returnArr = array("result" => 0, "msg" => "审核失败，请重试", "code" => 405, "data" => null);
                        }else{
                            $this->logRecord(6, "审核【".$article["title"]."】成功!", 9, $article['channel_id'], $id);
                            if($status==0){
                                $content = "【庖丁众包】尊敬的用户，您提交的".$article["title"]."项目已通过审核！项目经理将于24小时内与您联系，请保持电话畅通。";
                            }else{
                                $content = "【庖丁众包】尊敬的用户，很抱歉！您提交的".$article["title"]."项目不符合平台的发布要求，感谢您对庖丁众包的支持！顺祝商祺！";
                            }

                            $user_mobile=M('manage_users')->where('user_id='.$article['create_user_id'])->field('mobile')->find();
                            send_note($content,$user_mobile['mobile']);
                            sendNotice($content,$article['create_user_id']);
                            $returnArr = array("result" => 1, "msg" => "审核成功", "code" => 200, "data" => null);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "审核失败，缺少参数", "code" => 402, "data" => null);
                    }
                } else {
                    $returnArr = array("result" => 0, "msg" => "审核失败，频道参数错误", "code" => 402, "data" => null);
                }

                break;

            case "issue":
                $data = $this->getArticleByStatus(-1, $tables);
                if($data)  {
                    $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $data);
                } else {
                    $returnArr = array("result" => 0, "msg" => "获取数据失败", "code" => 402, "data" => null);
                }
            break;
            

            case "info":
                $data = $this->getArticleByStatus(0, $tables);
                if($data)  {
                    $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $data);
                } else {
                    $returnArr = array("result" => 0, "msg" => "获取数据失败", "code" => 402, "data" => null);
                }
            break;
            

            case "audit":
                $data = $this->getArticleByStatus(1, $tables);
                if($data)  {
                    $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $data);
                } else {
                    $returnArr = array("result" => 0, "msg" => "获取数据失败", "code" => 402, "data" => null);
                }
            break;

            case "list":
                $data = $this->getArticleByStatus(false, $tables);
                if($data)  {
                    $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $data);
                } else {
                    $returnArr = array("result" => 0, "msg" => "获取数据失败", "code" => 402, "data" => null);
                }
            break;

//            case "audit":
//                $data = $this->getCompanyByStatus(1, $tables);
//                if($data)  {
//                    $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $data);
//                } else {
//                    $returnArr = array("result" => 0, "msg" => "获取数据失败", "code" => 402, "data" => null);
//                }
//
//                break;

//            case "list":
//                $data = $this->getArticleByStatus(false, $tables);
//                if($data)  {
//                    $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $data);
//                } else {
//                    $returnArr = array("result" => 0, "msg" => "获取数据失败", "code" => 402, "data" => null);
//                }
//                break;

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
        $systemChannelFormField = M("SystemChannelFormField");


        //判断是否设置参数
        switch ($action) {
            case "page_list":
                $keyword=trim(I("keyword"));
               
                if($keyword) {
                    $where["title|content"] = array("LIKE","%$keyword%");
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
                $where=array("call_index = '" . $postData['call_index'] . "'","is_deleted = 0");
                if(M("$tableName")->where($where)->count()){
                    json_return($returnArr);
                }
                $info = $this->addCategory($channel, $tableName, $postData);
                if ($info) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加文章分类" . $postData["title"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加文章分类失败，数据库录入失败");
                    $returnArr = array("result" => 0, "msg" => "保存失败，数据已存在", "code" => 402, "data" => null);
                }
                break;
            case "edit":
                $postData = I("post.");
                $getPinyin = new GetFirstCharterUtil();
                $fieldName = $getPinyin->getAllChar($postData['cat_name']);
                $postData['call_index'] = $fieldName;

                $returnArr = array("result" => 0, "msg" => "该名称已存在！不能重复", "code" => 402, "data" => null);
                $where=array("call_index = '" . $postData['call_index'] . "'","is_deleted = 0","id<>". $_GET["id"]);
                if(M("$tableName")->where($where)->count()){
                    json_return($returnArr);
                }
                //进入编辑函数
                $info = $this->editCategory($postData);
                if ($info) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "编辑文章分类" . $postData["title"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "修改成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5, "编辑文章分类" . $postData["title"] . "失败，数据库删除失败");
                    $returnArr = array("result" => 0, "msg" => "修改失败，请联系管理员", "code" => 402, "data" => null);
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
                $where=array("tag_name = '" . $postData['tag_name'] . "'","is_deleted = 0");
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
                $returnArr = array("result" => 0, "msg" => "标签名不能重复", "code" => 402, "data" => null);
                $where=array("tag_name = '" . $postData['tag_name'] . "'","is_deleted = 0","id<>". $_GET["id"]);
                if(M("$tableName")->where($where)->count()){
                    json_return($returnArr);
                }
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

    /*
     *
     */
    private function getArticleByStatus($status, $table){

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
     * @param array $data 需要添加的数据信息
     * $isCopy为1表示复制为0表示正常新增
     * @return mixed 返回是否添加成功
     */
    private function addArticle($channelIndex, $tableName, $data = array(),$isCopy)
    {
        $con['call_index'] = $channelIndex;
        $con['is_active'] = 1;
        $channel = M("SystemChannel")->where($con)->find();
        //将建立的用户名与建立时间赋值给数组。
        /*  if($isCopy == 1) {
              $data = $this->getCopyImage($data);
          }*/
        $data["id"] = '';
        $data['channel_id'] = $channel['id'];
        $data["create_user_id"] = $_SESSION["admin_id"];
        $data["create_user"] = M("ManageUsers")->where("user_id=".$data['create_user_id'])->getField("user_name");
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

    /*
     * 将复制的内容中图片（复制内容中只是地址）进行复制
     * */
    /* public function getCopyImage($data = array()) {
         $systemChannelFormField = M("SystemChannelFormField");
         $whereData["channel"] = $data["channel"];
         $whereData["form_type"] = "image";
         $imageName = $systemChannelFormField->field("name")->where($whereData)->select();
         foreach ($imageName as $value) {
             foreach ($value as $value1) {
                 $imageName1[] = $value1; //类型为image的字段名
             }
         }
         foreach ($data as $item =>$value) {
             foreach ($imageName1 as $value) {
                 if($value == $item ) {
                     $imageName2[] = $item; //传来的数据中为图片的数据名
                 }
             }
         }

         foreach ($imageName2 as $value ) {
             copy($yuan,$newfile);
         }

         return $data;
     }*/

    /**
     * @param array $data 需要修改的数据信息
     * @return mixed 返回是否修改成功
     */
    private function editArticle($data = array())
    {
        $getId = $_GET["id"];
        $channel = $_GET["channel"];
        $moduleType = $_GET['type'];

        $tableName = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$moduleType'")->getField("table_format");
        //将更新的用户名与更新时间赋值给数组。
        $data["update_user_id"] = $_SESSION["admin_id"];
        $data["update_time"] = date("Y-m-d H:i:s", time());

        //***********************判断是否自动审核**********************/
        $is_auto_review=M("SystemChannel")->where("call_index='".$channel."'")->getField("is_auto_review");
        if($is_auto_review){
            $data["status"]=0;
        }
        //***********************判断是否自动审核**********************/

        // dump($data);die;
        $info = M("$tableName")->where("id=".$getId)->save($data);
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
        $data['create_user'] = M("ManageUsers")->where("user_id=".$data['create_user_id'])->getField("user_name");
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

    public function validCat()
    {
        $name = I("post.name");
        $param = I("post.param");
        $map[$name] = $param;
        $cat_id = I("get.cat_id");
        $id = M("article_cat")->where($map)->getField("cat_id");
        if ($id && $id != $cat_id) {
            if ($name == "cat_name")
                exit("该分类名称已存在!");
            else if ($name == "cat_alias")
                exit("该英文名称已存在!");
        } else
            exit("y");
    }

    /**
     * 初始化编辑器链接
     * @param $post_id post_id
     */
    private function initEditor()
    {
        $this->assign("URL_upload", U("Admin/Ueditor/imageUp", array("savepath" => "article")));
        $this->assign("URL_fileUp", U("Admin/Ueditor/fileUp", array("savepath" => "article")));
        $this->assign("URL_scrawlUp", U("Admin/Ueditor/scrawlUp", array("savepath" => "article")));
        $this->assign("URL_getRemoteImage", U("Admin/Ueditor/getRemoteImage", array("savepath" => "article")));
        $this->assign("URL_imageManager", U("Admin/Ueditor/imageManager", array("savepath" => "article")));
        $this->assign("URL_imageUp", U("Admin/Ueditor/imageUp", array("savepath" => "article")));
        $this->assign("URL_getMovie", U("Admin/Ueditor/getMovie", array("savepath" => "article")));
        $this->assign("URL_Home", "");
    }


    /**
     * 应用事例
     *
     */
    public function use_example()
    {
        $action=$_GET['action'];

        switch ($action){

            case "add":
                $this->assign('hzjg_id',$_GET['id']);
                $this->display('example_info');
                break;


            case "add_data":
                $data=$_POST;
                $data['create_time']=date('Y-m-d H:i:s');
                $result=M("article_relation_yysl")->add($data);
                if($result){
                    $returnArr = array("result" => 1, "msg" => "添加成功", "code" => 200, "data" => null);
                }else{
                    $returnArr = array("result" => 0, "msg" => "添加失败", "code" => 402, "data" => null);
                }
                json_return($returnArr);
                break;


            case "edit":

                $id=$_GET['id'];
                $data=M('article_relation_yysl')->where('id='.$id)->find();
                $this->assign('id',$_GET['id']);
                $this->assign('data',$data);
                $this->display('example_info');
                break;

            case "save":
                $id=$_GET['id'];
                $data=$_POST;
                $result=M("article_relation_yysl")->where('id='.$id)->save($data);
                if($result){
                    $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                }else{
                    $returnArr = array("result" => 0, "msg" => "保存失败", "code" => 402, "data" => null);
                }
                json_return($returnArr);
                break;
            case "delete":

                $id=$_GET['id'];
                $result=M("article_relation_yysl")->where('id='.$id)->delete();
                if($result){
                    $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);
                }else{
                    $returnArr = array("result" => 0, "msg" => "删除失败", "code" => 402, "data" => null);
                }
                json_return($returnArr);
                break;



        }
    }

}
