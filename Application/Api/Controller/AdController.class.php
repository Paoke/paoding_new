<?php

namespace Api\Controller;

use Think\Controller;

class AdController extends BaseRestController
{
    public function index()
    {}

    public function getData()
    { //判断是否设置参数
        switch ( $_GET["type"]) {
            //获取电脑端广告数据
            case "pc":
                $where['pid'] = 1;
                break;
            //获取手机端广告数据
            case "mobile":
                $where['pid'] = 2;
                break;
            //获取后台广告数据
            case "admin":
                $where['pid'] = 1;
                break;
            default:
                $returnArr = array("result" => 0, "msg" => "请求广告端参数错误", "code" => 402, "data" => null);
                json_return($returnArr);
        }
        $where['enabled'] = 1;
        $info = M()->table("Ad")->field("ad_name,ad_link,ad_code")->where($where)->order("orderby ASC,add_time DESC")->count();
        //判断是否取回数据
        if ($info) {
            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
        } else {
            $returnArr = array("result" => 0, "msg" => "没有广告数据", "code" => 200, "data" => null);
        }
        json_return($returnArr);
    }

//    /**
//     * 获取广告数据
//     */
//    public function getAd()
//    {
//        $modelAd = D("ad");
//        $action = $_GET["action"];
//        $getId = $_GET["id"];
//        //判断是否设置参数
//        if ($action) {
//            switch ($action) {
//                //获取电脑端广告数据
//                case "pc":
//                    $info = $getId ? $modelAd->getAd($action, $getId) : $modelAd->getAd($action);
//                    break;
//                //获取手机端广告数据
//                case "mobile":
//                    $info = $getId ? $modelAd->getAd($action, $getId) : $modelAd->getAd($action);
//                    break;
//                //获取后台广告数据
//                case "admin":
//                    $info = $getId ? $modelAd->getAd($action, $getId) : $modelAd->getAd($action);
//                    break;
//                default:
//                    $returnArr = array("result" => 0, "msg" => "请求错误，请求参数值设置有误", "code" => 402, "data" => null);
//                    json_return($returnArr);
//            }
//            //判断是否取回数据
//            if ($info) {
//                $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//            } else {
//                $returnArr = array("result" => 1, "msg" => "获取成功，未发现数据", "code" => 200, "data" => null);
//            }
//        } else {
//            $returnArr = array("result" => 0, "msg" => "请求错误，请求参数设置有误", "code" => 402);
//        }
//        json_return($returnArr);
//    }
}