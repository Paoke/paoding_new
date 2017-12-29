<?php

namespace Api\Controller;


use Think\Controller;
use Think\Log;

class BaseRestController extends Controller\RestController
{

    /**
     * 日志记录，用于内容管理的各种操作进行记录
     * @param int $level 日志警告级别,1：特别严重警告，2：严重警告，3：较大警告，4：一般警告，5：日志预警，6：普通操作
     * @param string $str 拼接字符串
     * @param int $operate_type 操作类型，-1未知类型，0管理员登陆，1用户登陆、2查看、3新增、4修改、5删除、6审核、7修改密码
     * @param int $channel_id 频道名称id,-1为空，
     * @param int $data_id 被记录日志的数据的id，-1为空
     */
    public function logRecord($level = 0, $str = "",$operate_type=-1,$channel_id = -1,$data_id = -1)
    {
        if (is_numeric($level) && !empty($level)) {
            $data["log_ip"] = $_SERVER["REMOTE_ADDR"];
            $data["admin_id"] = $_SESSION["admin_id"];
            $data["admin_user_name"] = $_SESSION["admin_user_name"];
            $data["user_id"] = $_SESSION['userArr']['user_id'];
            $data["log_time"] = date("Y-m-d H:i:s", time());
            $data["log_url"] = $_SERVER["REQUEST_URI"];
            $data["log_level"] = $level;
            $data["log_info"] = "用户进行" . $str;
            $data["channel_id"] = $channel_id;
            $data["data_id"] = $data_id;
            $data["operate_type"] = $operate_type;
            $info = M("SystemLog")->add($data);

            if ($info) {
                $returnArr = array("result" => 1, "msg" => "日志添加数据成功", "code" => 200);
            } else {
                $returnArr = array("result" => 0, "msg" => "日志添加数据错误", "code" => 400);
            }
        } else {
            $returnArr = array("result" => 0, "msg" => "日志警告级别参数（1：特别严重警告，2：严重警告，3：较大警告，4：一般警告，5：日志预警，6：普通操作）", "code" => 400);
        }
        json_encode($returnArr);
    }
    
    /*
     * 获取表的名称
     * */
    public function getTableName($channel = "", $type = 0) {
        $tableName = M()->table("{$_SESSION["site_name"]}_system_channel_table_config")->where("channel='$channel' AND type=$type")->getField("table_format");
            if($tableName) {
                return $tableName;
            } else {
                return false;
            }
    }

    public function getViewRecordTable($channelIndex){
        $channel = M('SystemChannel')->where("call_index='".$channelIndex."'")->find();
        $table = ucfirst($channel['base_module']) . ucfirst($channelIndex) . 'ViewRecord';
        return $table;
    }

    /*
      * 增加浏览次数
      * **/
    public function addClickCount($channel, $type, $dataId){
        if($dataId){
            //增加次数,这个次数不一定准确
            $table = $this->getTableName($channel, $type);
            $model = M($table)->where('id='.$dataId)->find();
            $click = $model['clicks'];
            M("$table")->where("id=".$dataId)->setField("clicks", $click+1);
            //增加浏览记录
            $viewRecordTable = $this->getViewRecordTable($channel);
            $channelInfo = M('SystemChannel')->where("call_index='".$channel."'")->find();
            $data['channel_id'] = $channelInfo['id'];
            $data['category_id'] = $model['category_id'];
            $data['data_id'] = $dataId;
            $data['user_id'] = $_SESSION['userArr']['user_id'];
            $data['user_ip'] = get_client_ip();
            $data['create_time'] = date('Y-m-d H:i:s', time());

            M("$viewRecordTable")->add($data);
            return true;
        }else{
            return false;
        }
    }

    //获取表名
    public function setTable($channel = "", $type = 0)
    {
        $info = M()->table("{$_SESSION["site_name"]}_system_channel_table_config")->field("channel,table_format,table_name")->where("channel='$channel' AND type=$type")->find();
        if ($info) {
            $data['table_format'] = $info["table_format"];
            $data['table_name'] = $info["table_name"];
            $data['channel'] = $info["channel"];
            $data['channel_id'] = M()->table("{$_SESSION["site_name"]}_system_channel")->where("call_index='{$info["channel"]}'")->getField("id");  //频道id
            return $data;
        } else {
            return false;
        }

    }
}


