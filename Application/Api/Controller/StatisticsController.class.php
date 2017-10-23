<?php

namespace Api\Controller;

use Think\Controller;
use Think\Log;

class StatisticsController extends BaseRestController
{
    public function view_record()
    {
        $id = $_GET['id'] ? $_GET['id'] : $_POST['id'];
        $action = $_GET['action'];
        $account = session('company_account');
        $where['channel_index'] = $account['channel'];
        $where['user_id'] = $account['user_id'];
        $dataId = M('SystemRelation')->where($where)->getField('data_id');
        $account['data_id'] = $dataId;
        $channel = $_GET['channel'];
        $type = $_GET['type'];


        //需要登录才能操作的
        if (!empty($account['user_id'])) {
            switch ($action) {
                case "count":
                    $conf['call_index'] = $channel;
                    $conf['is_active'] = 1;
                    $channelInfo = M('SystemChannel')->where($conf)->find();
                  
                    $VIEW_RECORD_TABLE = strtoupper('__' .$channelInfo['base_module'] . '_' . $channelInfo['call_index'] . '_VIEW_RECORD__');

                    //统计周数据访问量
                  /*  $sql = "SELECT DAYOFWEEK(`create_time`) week_day, COUNT(1) `count` FROM ".$VIEW_RECORD_TABLE.
                                " WHERE DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= `create_time`".
                                " AND `channel_id`=".$channelInfo['id'].
                                " AND `data_id`=".$account['data_id'].
                                " GROUP BY week_day";*/
                  /*  $sql = "SELECT DAYOFWEEK('create_time') as week_day, COUNT(1) 'count' FROM".$VIEW_RECORD_TABLE.
                        "WHERE 'data_id' = ".$account['data_id'].
                        "GROUP BY week_day";*/
                    $sql = "SELECT DAYOFWEEK(`create_time`) week_day, COUNT(1) `count` FROM ".$VIEW_RECORD_TABLE.
                        " WHERE DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= `create_time`".
                        " AND `channel_id`=".$channelInfo['id'].
                        " AND `data_id`=".$account['data_id'].
                        " GROUP BY week_day";
                    $weekData1 = M()->query($sql);

                    $weekData1 = $this->formatWeekStatistics($weekData1);
                    //统计周数据访问人数
                    $sql = "SELECT A.week_day, COUNT(1) count FROM ".
                            " (SELECT DAYOFWEEK(`create_time`) week_day, user_id FROM ". $VIEW_RECORD_TABLE.
                            " WHERE DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= `create_time`".
                            " AND `channel_id`=".$channelInfo['id'].
                            " AND `data_id`=".$account['data_id'].
                            " GROUP BY week_day,user_id) A".
                            " GROUP BY A.week_day";
                    $weekData2 = M()->query($sql);
                    $weekData2 = $this->formatWeekStatistics($weekData2);

                    //统计年数据访问量
                    $sql = "SELECT CONVERT(DATE_FORMAT(create_time,'%m'), SIGNED) `month`, COUNT(1) `count` FROM " . $VIEW_RECORD_TABLE .
                        " WHERE DATE_FORMAT(create_time,'%Y')=DATE_FORMAT(NOW(),'%Y')".
                        " AND `channel_id`=".$channelInfo['id'].
                        " AND `data_id`=".$account['data_id'].
                        " GROUP BY `month`";
                    $yearData1 = M()->query($sql);
                    $yearData1 = $this->formatYearStatistics($yearData1);

                    //统计年数据访问人数
                    $sql = "SELECT A.`month`, COUNT(1) count FROM ".
                            " (SELECT CONVERT(DATE_FORMAT(create_time,'%m'), SIGNED) `month`, user_id FROM ". $VIEW_RECORD_TABLE .
                            " WHERE DATE_FORMAT(create_time,'%Y')=DATE_FORMAT(NOW(),'%Y')".
                            " AND `channel_id`=" . $channelInfo['id'] .
                            " AND `data_id`=" . $account['data_id'] .
                            " GROUP BY `month`, user_id) A".
                            " GROUP BY A.`month`";
                    $yearData2 = M()->query($sql);
                    $yearData2 = $this->formatYearStatistics($yearData2);

                    $data['week1'] = $weekData1;
                    $data['week2'] = $weekData2;

                    $data['year1'] = $yearData1;
                    $data['year2'] = $yearData2;
                    $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, 'data' => $data);
                    break;

                default:
                    $returnArr = array("result" => 0, "msg" => "参数错误", "code" => 402);
                    break;
            }

        }else{
            $returnArr = array("result" => 0, "msg" => "请先登录!", "code" => 666);
        }
        json_return($returnArr);
    }

    /* *
     * 格式化周统计数据
     * **/
    private function formatWeekStatistics($data){

        $newData = array();
        foreach($data as $item){
            $newData[$item['week_day']] = $item['count'];
        }

        $weekStrArr = ['周日', '周一', '周二', '周三', '周四', '周五', '周六'];

        $weekData = array();
        $week = array();
        $count = array();
        $today = date('w');//找出今天星期几，最后一个数据为今天+

        $index = 1 + $today;//index 第一个数据为周几
        if($index >= count($weekStrArr)){//今天为周六
            $index = 0;
        }
        
        for($i=0; $i<7; $i++){

            if($index >= count($weekStrArr)){
                $index = 0;
            }

            $week[$i] = $weekStrArr[$index];
            $count[$i] = $newData[$index+1] ? $newData[$index+1] : 0;

            $index++;
        }

        $weekData['week'] = $week;
        $weekData['count'] = $count;
        return $weekData;
    }

    /* *
     * 格式化年数据
     * **/
    private function formatYearStatistics($data){


        $newData = array();
        foreach($data as $item){
            $newData[$item['month']] = $item['count'];
        }

        $yearData = array();
        $month = array();
        $count = array();
        for($i=0; $i<12; $i++){
            $mon = $i + 1;
            $month[$i] = $mon;
            $count[$i] = $newData[$mon] ? $newData[$mon] : 0;
        }

        $yearData['month'] = $month;
        $yearData['count'] = $count;

        return $yearData;
    }


}