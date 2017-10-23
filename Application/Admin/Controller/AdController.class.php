<?php

namespace Admin\Controller;

use Think\Log;

class AdController extends BaseController
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

    /**
     * 广告列表 - 入口函数
     * page_list，page_info 页面显示
     * page_add，page_edit 编辑页面显示
     * add，edit,del，编辑入口
     */
    public function ad()
    {
        $action = $_GET["action"];
        //获取id，id是给编辑页面用的
        $getId = $_GET["id"];

        $LOGIC = D("Ad", 'Logic');
        $AdPositionLOGIC = D('AdPosition', 'Logic');

        $param = $this->getRequestData();
        //判断是否设置参数
        switch ($action) {
            case "page_list":

                $result = $LOGIC->getList($param);
                $this->batch_assign($result);

                $ad_position_list = $AdPositionLOGIC->getAdPosition();
                $mod_id = get_mod_id('Ad', 'editAd');
                $this->assign('mod_id', $mod_id);
                $this->assign('ad_position_list', $ad_position_list);//广告位

                $this->display('ad_list');
                break;
            case "page_add":
                $position = $AdPositionLOGIC->getAdPosition();
                $this->assign('position', $position);
                $this->display("ad_info");
                break;
            case "page_edit":
                if ($getId) {
                    //下拉列表
                    $position = $AdPositionLOGIC->getAdPosition();
                    $this->assign('position', $position);
                    //数据
                    $info = $LOGIC->getDataById($getId);
                    $this->assign("info", $info);
                    $this->display("ad_info");
                } else {
                    $returnArr = array("result" => 0, "msg" => "该数据不存在，请重试", "code" => 402, "data" => null);
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5, "非法操作，浏览了广告编辑页面失败，未指定编辑数据",2);
                }
                break;
            case "add":
                $data = I('post.');

                $result = $LOGIC->addData($data);
                if ($result) {
                    $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加广告成功" . $data["ad_name"],3,$data['channel_id'],$result['id']);
                } else {
                    $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加广告失败",3);
                }
                break;
            case "edit":

                $data = I('post.');

                $result = $LOGIC->saveData($data);
                if ($result) {
                    $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "修改广告成功" . $data["ad_name"], 3,$data['channel_id'],$result['id']);
                } else {
                    $returnArr = array("result" => 0, "msg" => "保存失败，请重试", "code" => 402, "data" => null);
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "修改广告失败",3);
                }
                break;
            case "del":
                $logData = $LOGIC->getDataById($getId);
                $result = $LOGIC->deleteDataById($getId);
                if ($result) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "删除广告" . $logData["title"] . "成功",5);
                    $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "删除广告" . $logData["title"] . "失败",5);
                    $returnArr = array("result" => 0, "msg" => "删除失败，请重试", "code" => 402, "data" => null);
                }
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                break;
        }
        json_return($returnArr);
    }

    /**
     * 广告位列表 - 入口函数
     * page_list，page_info 页面显示
     * page_add，page_edit 编辑页面显示
     * add，edit,del，编辑入口
     */
    public function adPosition()
    {
        $action = $_GET["action"];
        $LOGIC = D("AdPosition", 'Logic');
        $param = $this->getRequestData();
        //判断是否设置参数
        switch ($action) {
            case "page_list":
                $result=$LOGIC->getList($param);
                $this->batch_assign($result);
                $this->display('adposition_list');
                break;
            case "page_add":
                break;
            case "page_edit":
                break;
            case "add":
                break;
            case "edit":
                break;
            case "del":
                break;
            default:
                break;
        }
    }

    public function changeAdField()
    {
        $data[$_REQUEST['field']] = I('GET.value');
        $data['ad_id'] = I('GET.ad_id');
        $LOGIC = D("AdPosition", 'Logic');
        $LOGIC->saveData($data); // 根据条件保存修改的数据
    }
}
