<?php
namespace Api\Controller;

class ChannelController extends BaseRestController
{
    public function index()
    {
        $getData = $_GET;
        $postData = $_POST;

        $getId = $_GET["id"];
        $postId = $postData["id"];

        $action = $_GET["action"];  //操作参数
        $channel = $_GET["channel"];  //操作参数
        $channel_id = M("SystemChannel")->where("call_index='$channel'")->getField("id");
        $channel_config = M("SystemChannel")->where("call_index='$channel'")->find();
        $systemChannelFormFieldModel = D("SystemChannelFormField");
        $systemChannelTableConfModel = D("SystemChannelTableConfig");
        $type = $_GET["type"];  //频道类型

        //需要登录才能操作的
            switch ($action) {
                //频道表单元素展示
                case "formList":
                 
                    if (!empty($channel_id) && !empty($type)) {
                        $channelTableConfInfo = $systemChannelTableConfModel->checkChannel($channel, $type);
                      
                        if ($channelTableConfInfo) {
                            $all = $_GET['all'];
                            if($all === '0'){
                                $all = false;
                            }else{
                                $all = true;
                            }

                            $fields = $systemChannelFormFieldModel->formList($channel, $channelTableConfInfo, $all);

                            $fieldArr = array();
                            if ($fields) {
                                if($getId){
                                    $table = $this->getTableName($channel, $type);
                                    $info = M("$table")->where('id='.$getId)->find();
                                    $data['info'] = $info;
                                    $i=0;
                                    foreach($fields as $item){

                                        $index = $item['name'];
                                        $item['default_value'] = $info[$index] ? $info[$index] : '';
                                        if($item['form_type'] != 'password'){ //去掉密码数据
                                            $fieldArr[$i] = $item;
                                            $i++;
                                        }
                                    }

                                    $data['fields'] = $fieldArr;
                                }else{
                                    $data['fields'] = $fields;
                                }
                                $returnArr = array("result" => 1, "msg" => "获取表单数据成功", "code" => 200, "data" => $data);
                            } else {
                                $returnArr = array("result" => 0, "msg" => "该频道在扩展字段中不存在，请联系管理员", "code" => 402);
                            }
                        } else {
                            $returnArr = array("result" => 0, "msg" => "频道不存在或参数错误，请联系管理员", "code" => 402);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "频道参数设置错误", "code" => 402);
                    }
                    break;
                //频道表单提交数据
                case "formAdd":
                    //提交时用户id不能为空
                    $userId = $_SESSION["userArr"]["user_id"];
                    if (empty($userId)) {
                        $returnArr = array("result" => 0, "msg" => "未登录，请登录", "code" => 666);
                        break;
                    }
                    if (!empty($channel_id) && !empty($type)) {
                        $channelTableConfInfo = $systemChannelTableConfModel->checkChannel($channel, $type);
                        if ($channelTableConfInfo) {
                            if ($channel_config["is_content_reviewed"] == 1) {//1为自动审核，0为人工审核
                                $postData["status"] =0;
                            }else{
                                $postData["status"] =1;
                            }

                            $postData["create_time"] = date("Y-m-d H:i:s", time());
                            $postData["create_user_id"] = $_SESSION["userArr"]["user_id"];
                            $postData["channel_id"] = $channel_id;
                            $info = M($channelTableConfInfo["table_format"])->add($postData);

                            if ($info) {
                                if ($channel_config["is_content_reviewed"] == 1) {//1为自动审核，0为人工审核
                                    $returnArr = array("result" => 1, "msg" => "发表成功", "code" => 200);
                                } else {
                                    $returnArr = array("result" => 1, "msg" => "审核后自动发表，请稍候", "code" => 200);
                                }

                            } else {
                                $returnArr = array("result" => 0, "msg" => "提交失败", "code" => 402);
                            }
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "频道参数设置错误", "code" => 402);
                    }
                    break;
                default:
                    $returnArr = array("result" => 0, "msg" => "请求错误，请求参数设置有误", "code" => 402);
            }
        json_return($returnArr);
    }


    public function category(){

        $action = $_GET['action'];
        $channel = $_GET['channel'];
        $type = $_GET['type'] ? $_GET['type'] : 2;

        switch ($action) {

            case "list": //获取分类数据
                if($channel){
                    $tableFormat = getChannelTable($channel, $type)['table_format'];
                    $data = M("$tableFormat")->where("is_deleted=0 AND status=1")->select();
                    $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $data);
                }else{
                    $returnArr = array("result" => 0, "msg" => "请求错误，缺少参数", "code" => 404);
                }
                break;

            //其他
            default:
                $returnArr = array("result" => 0, "msg" => "请求错误，请求参数设置有误", "code" => 402);
        }
        json_return($returnArr);

    }

}