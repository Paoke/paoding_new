<?php

namespace Admin\Controller;
use Think\AjaxPage;
use Think\Log;

class ChannelDataController extends BaseController
{

    /*
     * 子表单模块数据
     * */
    public function child_module()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $channel = $_GET["channel"];
        $type = $_GET['type'];

        $tableConfig = M("SystemChannelTableConfig")->where("channel='$channel' AND type='$type'")->find();
        $channelInfo = M("SystemChannel")->where("call_index='$channel'")->find();
        $ChannelFormFieldDAO = M("SystemChannelFormField");
        $child = M('SystemChannelChild')->where("channel_index='$channel' AND type=".$type)->find();
        $table = $tableConfig['table_format'];

        switch ($action) {

            case "page_list": //数据列表
                //获取表头

                $conf['table_config_id'] = $tableConfig['id'];
                $conf['show_list'] = 1;
                $info = $ChannelFormFieldDAO->field('title,name')->where($conf)->order('admin_sort')->select();
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

                $count = M($table)->where($where)->count();          //$count    总共有多少条数据
                $page_num = I('post.page_num', null) ? I('post.page_num') : 10;   //$page_num 每页几条数据
                $page_now = I('post.page_now', 1);   //$page_now 第几页
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页

                $list = M($table)->field($fields)->page($page_now, $page_num)->where($where)->select();

                $pageConfig['num'] = $page_num;
                $pageConfig['now'] = $page_now;
                $pageConfig['total'] = $page;
                $data['page'] = $pageConfig;

                $data['list'] = $list;
                $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $data);

                break;

            case "relation_data": //数据列表
                $data_id = $_GET['data_id'];

                //获取表头
                $conf['channel'] = $channel;
                $conf['type'] = $type;
                $conf['is_relation'] = 1;
                $info = $ChannelFormFieldDAO->field('title,name')->where($conf)->order('admin_sort')->select();

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
                if(!empty($_POST['keyword'])){
                    $keyword = '%'.$_POST['keyword'].'%';
                    unset($fields['id']);
                    if(count($fields)>1){
                        foreach($fields as $field){
                            $map[$field] = array('LIKE', $keyword);
                        }
                        $map['_logic'] = 'or';
                        $where['_complex'] = $map;
                    }else{
                        $field = $fields[0];
                        $where[$field] = array('LIKE', $keyword);
                    }

                }

                /*
                 * 子表关联数据为主表数据，暂时做为n对1
                 * **/
                if($child['channel_index'] == $child['relation_channel'] && $child['relation_type'] == 1){
                    $where['id'] = $data_id;
                }

                $relationChannelTable = getChannelTable($child['relation_channel'], $child['relation_type']);
                $tableFormat = $relationChannelTable['table_format'];
                $count = M($tableFormat)->where($where)->count();          //$count    总共有多少条数据
                $page_num = I('post.page_num', null) ? I('post.page_num') : 10;   //$page_num 每页几条数据
                $page_now = I('post.page_now', 1);   //$page_now 第几页
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页

                $list = M($tableFormat)->field($fields)->page($page_now, $page_num)->where($where)->select();

                $pageConfig['num'] = $page_num;
                $pageConfig['now'] = $page_now;
                $pageConfig['total'] = $page;
                $data['page'] = $pageConfig;

                $data['list'] = $list;
                $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $data);

                break;

            case "page_add": //数据新增页面

                C('TOKEN_ON',false);
                $this->assign('channel', $channel);
                $this->assign('type', $type);
                $this->assign('child', $child);
                $this->assign('data_id', $_GET['data_id']);
                $this->display('child_info');
                break;

            case "add_relation_data": //数据新增页面

                $this->assign('channel', $channel);
                $this->assign('type', $type);
                $this->assign('child', $child);
                $this->assign('data_id', $_GET['data_id']);
                $this->display('relation_child_info');
                break;

            case "page_edit": //数据编辑页面

                $info = M($table)->where("id=".$getId)->find();
                $this->assign('channel', $channel);
                $this->assign('type', $type);
                $this->assign('child', $child);
                $this->assign('data_id', $info['data_id']);
                $this->assign('id', $getId);
                $this->assign('info', $info);
                $this->display('child_info');
                break;

            case "add": //数据新增

                $data = I('post.');

                if($_GET['check']){
                    $check = $_GET['check'];
                    if($check == 1){
                        $condition = $data['condition'];
                        $itemNumField = $data['item_num_field'];
                        unset($data['condition']);
                        unset($data['item_num_field']);

                        $flag = $this->checkOutOfRoom($channel, $type, $data, $condition, $itemNumField);
                        if(!$flag){
                            $returnArr = array("result" => 0, "msg" => "数据条目已超过限制", "code" => 555, "data" => null);
                            json_return($returnArr);
                        }
                    }
                }

                $flag = $this->addChildData($table, $channelInfo, $data);
                if($flag === false){

                    $this->logRecord(5, "新增[".$channelInfo['channel_title']."-".$child['title']."]数据[".$data['title']."]失败", 3, $channelInfo['id'], $data['data_id']);
                    $returnArr = array("result" => 0, "msg" => "保存数据失败", "code" => 402, "data" => null);
                }else{
                    $this->logRecord(6, "新增[".$channelInfo['channel_title']."-".$child['title']."]数据[".$data['title']."]成功", 3, $channelInfo['id'], $data['data_id']);
                    $returnArr = array("result" => 1, "msg" => "新增数据成功", "code" => 200, "data" => null);
                }

                break;

            case "edit": //数据编辑

                $data = I('post.');

                $flag = $this->updateChildData($table, $channelInfo, $data);
                if($flag === false){
                    $this->logRecord(5, "编辑[".$channelInfo['channel_title']."-".$child['title']."]数据[".$data['title']."]失败", 4, $channelInfo['id'], $data['data_id']);
                    $returnArr = array("result" => 0, "msg" => "保存数据失败", "code" => 402, "data" => null);
                }else{
                    $this->logRecord(6, "编辑[".$channelInfo['channel_title']."-".$child['title']."]数据[".$data['title']."]成功", 4, $channelInfo['id'], $data['data_id']);
                    $returnArr = array("result" => 1, "msg" => "更新数据成功", "code" => 200, "data" => null);
                }

                break;

            case "del": //数据编辑

                $flag = M($table)->where("id=".$getId)->setField('is_deleted', 1);
                if($flag === false){
                    $this->logRecord(5, "删除[".$channelInfo['channel_title']."-".$child['title']."]数据ID[".$getId."]失败", 4, $channelInfo['id']);
                    $returnArr = array("result" => 0, "msg" => "删除数据失败", "code" => 402, "data" => null);
                }else{
                    $this->logRecord(6, "删除[".$channelInfo['channel_title']."-".$child['title']."]数据ID[".$getId."]成功", 4, $channelInfo['id']);
                    $returnArr = array("result" => 1, "msg" => "删除数据成功", "code" => 200, "data" => null);
                }

                break;

            case "batch_add":
                $data = I('post.');
                $table = getChannelTable($channel, $type)['table_format'];
                $flag = M($table)->addAll($data);
                if($flag === false){
                    $this->logRecord(5, "批量新增[".$channelInfo['channel_title']."-".$child['title']."]数据[".$data['title']."]失败", 3, $channelInfo['id'], $data['data_id']);
                    $returnArr = array("result" => 0, "msg" => "保存数据失败", "code" => 402, "data" => null);
                }else{
                    $this->logRecord(6, "批量新增[".$channelInfo['channel_title']."-".$child['title']."]数据[".$data['title']."]成功", 3, $channelInfo['id'], $data['data_id']);
                    $returnArr = array("result" => 1, "msg" => "保存数据成功", "code" => 200, "data" => null);
                }

                break;

            case "extends":
                if ($channel) {
                    $files = "name,title,form_type,default_value,item_option,valid_tip_msg,valid_error_msg,valid_pattern,date_format,file_format,is_relation";
                    $condition['table_config_id'] = $tableConfig['id'];
                    $condition['admin_use'] = 1;

                    $extends = $ChannelFormFieldDAO->field($files)->where($condition)->order('admin_sort')->select();
                    $extendValCont = M($table)->where("id='$getId' AND is_deleted=0")->find();
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
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 401, "data" => null);
                break;
        }
        json_return($returnArr);
    }

    /*
     * 检查入住酒店房间数据是否超出限制
     * **/
    private function checkOutOfRoom($channel, $type, $data, $condition, $itemNumField){

        //获取条件
        if(strpos($condition, ',') !== false){
            $conditionField = explode(',', $condition);
        }else{
            $conditionField = $condition;
        }

        foreach($conditionField as $item){
            $where[$item] = $data[$item];
        }
        $maxItemNum = $data[$itemNumField];

        return $this->checkOutOfQuantity($channel, $type, $where, $maxItemNum);

    }

    /*
     * 检查同条件数据是否超出限制
     * @param $condition 检查条件
     * @param $maxItemNum 最大条目数
     * **/
    private function checkOutOfQuantity($channel, $type, $condition, $maxItemNum=1){
        $table = getTableStr($channel, $type, 'table_format');
        $count = M($table)->where($condition)->count();
        if($count > $maxItemNum){
            return false;
        }else{
            return true;
        }
    }

    private function addChildData($table, $channel, $data){

        if(count($data) <= 0){
            return false;
        }
        $data['channel_id'] = $channel['id'];
        $data["create_user_id"] = $_SESSION["admin_id"];
        $data["create_user"] = M("ManageUsers")->where("user_id=".$data['create_user_id'])->getField("user_name");
        $data["create_time"] = date("Y-m-d H:i:s", time());
        $data['is_active'] = 1;
        $data['is_delete'] = 0;
        $data['is_admin'] = 1;

        $flag = M($table)->add($data);
        return $flag;
    }

    private function updateChildData($table, $channel, $data){

        if(count($data) <= 0){
            return false;
        }
        $data["update_user_id"] = $_SESSION["admin_id"];
        $data["update_time"] = date("Y-m-d H:i:s", time());

        $flag = M($table)->where("id=".$data['id'])->save($data);
        return $flag;
    }

}