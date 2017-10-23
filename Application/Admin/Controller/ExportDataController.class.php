<?php

namespace Admin\Controller;
use Think\AjaxPage;
use Think\Log;

class ExportDataController extends BaseController
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

    /*
    * 导出数据字段配置
    * */
    public function exportField()
    {
        $channel = $_GET["channel"];
        $action = $_GET["action"];
        switch ($action) {
            case "page_list":
                $this->assign('channel',$channel);
                $this->display('export_field_info');
                break;

            case "page_edit":
                $type = [1,2,4]; // 需要查询哪些类型的表1为内容2为栏目表4为标签表
              
                foreach ($type as $value) {
                    $tableName[$value] = M("SystemChannelTableConfig")->where("channel = '$channel' AND type = '$value'")->getField("table_name");
                }
                
                foreach ($tableName as $item => $value) {
                    $info[$item] = M("SystemChannelExportField")->field("id,field_name,field_title,is_checked")->where("channel = '$channel' AND table_name = '$value'")->select();
                }

                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 401, "data" => $info);
                break;


            case "edit":
                // $postData = I("post.");
                $postData = $_POST['fields'];
                M("SystemChannelExportField")->where("channel = '$channel'")->setField('is_checked',0);
                foreach ($postData as $value) {
                    M("SystemChannelExportField")->where("channel = '$channel' AND field_name = '$value'")->setField('is_checked',1);
                }
                $returnArr = array("result" => 1, "msg" => "修改成功", "code" => 200, "data" => null);
                break;


            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法");
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 401, "data" => null);
        }
        json_return($returnArr);
    }

    /*
   * 导出数据
   * */
    public function exportData()
    {
        $channel = $_GET["channel"];
        $action = $_GET["action"];
        $page_num = $_GET["page_num"];
        $page_now = $_GET["page_now"];
        $moduleType = $_GET['type'];
        $type = [1,2,4]; // 需要查询哪些类型的表1为内容2为栏目表4为标签表
        foreach ($type as $value) {
            $tableName[$value] = M("SystemChannelTableConfig")
                ->where("channel = '$channel' AND type = '$value'")
                ->getField("table_name");
        }
        foreach ($tableName as $item => $value) {
            $info[$value] = M("SystemChannelExportField")
                ->field("field_name")
                ->where("channel = '$channel' AND table_name = '$value' AND is_checked = 1")
                ->select();
        }
        //$info1保存将字段名变成以“，”连接的字符串
        foreach ($info as $item => $value1) {
            foreach ($value1 as $value2) {
                $info1[$item][]=$item.'.'.$value2['field_name'];
            }
            $info1[$item]=implode(',',$info1[$item]);
        }
        //$data是内容表和栏目表的相关数据
        if($action == 0) {
            $data =M()->table($tableName[1])
                ->field("$tableName[1].id,".$info1[$tableName[1]].','.$info1[$tableName[2]])
                ->join("$tableName[2]  on $tableName[2].id=$tableName[1].category_id",'LEFT')
                ->page($page_now, $page_num)
                ->where("$tableName[1].is_deleted = 0")
                ->select();
        } else {
            $data =M()->table($tableName[1])
                ->field($info1[$tableName[1]].','.$info1[$tableName[2]].",$tableName[1].status,"."$tableName[1].is_active")
                ->join("$tableName[2]  on $tableName[2].id=$tableName[1].category_id",'LEFT')
                ->where("$tableName[1].is_deleted = 0")
                ->select();
        }
        $i=0;
        foreach ($data as $value) {
            foreach ($value as $key => $value2) {
                if($key=="status") {
                    if($value2==1) {
                        $data[$i]['status'] = '审核中';
                    }else if($value2==0) {
                        $data[$i]['status'] = '已通过';
                    }else if($value2==-1) {
                        $data[$i]['status'] = '不通过';
                    }
                }
                if($key=="is_active") {
                    if($value2==1) {
                        $data[$i]['is_active'] = '启用';
                    }else if($value2==0) {
                        $data[$i]['is_active'] = '停用';
                        }
                }
            }
            $i++;
        }
        //得到标签关系表名
        $relationTagTableName = M("SystemChannelTableConfig")
            ->where("channel = '$channel' AND type = 5")
            ->getField("table_name");
        //得到channel对应的id
        $channelId  = M("SystemChannel")
            ->where("call_index = '$channel'")
            ->getField("id");
        $data2 =M()->table($relationTagTableName)
            ->field("data_id,tag_id")
            ->where("channel_id = $channelId")
            ->select();
        $i = 0;
        foreach ($data2 as $item => $value1) {
            $tagData = M()->table($tableName[4])
                ->field($info1[$tableName[4]])
                ->where("id = {$value1['tag_id']}")
                ->find();
            $dataId[] = $value1['data_id'];
            $data3[$i] = $tagData;
            $data3[$i]['data_id'] = $value1['data_id'];
            $i++;
        }
        $dataId=array_unique($dataId);
        $tagInfo = array();
        foreach ($dataId as $value1) {
            foreach ($data3 as $value2) {
                if ($value1 == $value2['data_id']) {
                    foreach ( $value2 as $item => $value3) {
                        if ($item != 'data_id') {
                            $tagInfo[$value1][$item] .=','.$value3;
                        }

                    }
                }

            }
        }
      /*  $i = 0;
        foreach ($data as $item1 => $value1) {
            foreach ($tagInfo as $item2 =>  $value2) {

                if($item2 == $value1['id']) {
                    foreach ($value1 as $item3 => $value3) {
                        if( $item3 != 'id') {
                            $lastData[$i][$item3] = $value3;
                        }
                    }
                    foreach ($value2 as $item4 => $value4) {
                        $lastData[$i][$item4] = $value4;
                    }
                }
            }
            $i ++;
        }*/
        $lastData = $data;
        //$dataHeade是excel表的第一列
        $dataHeade = M("SystemChannelExportField")
            ->field("field_title")
            ->where("is_checked = 1 AND channel='$channel'")
            ->select();
        foreach ($dataHeade as $value) {
            $datahade[] = $value['field_title'];

        }
        $datahade[] = '状态';
        $datahade[] = '启用/停用';
        $dataInfo[0] = $datahade;
        $i=1;
       foreach ($lastData as $value) {

            $dataInfo[$i] = $value;
            $i++;
        }

        create_xls($dataInfo,$action);

    }




    

}

