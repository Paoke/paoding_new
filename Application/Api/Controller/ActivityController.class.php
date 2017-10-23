<?php

namespace Api\Controller;

use Api\Logic\ChannelLogic;
use Common\Util\Image;
use Think\Log;

class ActivityController extends BaseRestController
{
    //数据列表
    public function dataList(){
        $parameterGet = I('get.');
        $parameterPost = I('post.');
        $param = array_merge($parameterGet, $parameterPost);
        $channelLogic = new ChannelLogic();
        $bool = $channelLogic->setTable($param['channel'], $param['type']);
        if ($bool) {
            switch($param['type']){
                case  1:
                    $info = $channelLogic->getList($param);
                    //搜索
                    if($param['tag_id']){
                        $search = $channelLogic->getTags($param['channel'], $param['tag_id']);
                    }else if($param['category_id']){
                        $search = $channelLogic->getCategoryName($param['channel'], $param['category_id']);
                    }
                    break;
                case  2:
                    $info = $channelLogic->getCategoryList();
                    break;
                case  4:
                    $info = $channelLogic->getTagList($param['channel']);
                    break;
//                case  5:暂时废弃，查tag的时候理论上可以用1的方法
//                    $info = $articleLogic->getTagArticleList($parameterGet);
//                    break;

                case  6:
                    $info = $channelLogic->getTicketList($param);
                    break;
                default:
                    $info = $channelLogic->getChildList($param);
                    break;
            }
            if ($info) {
                $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
                if($search){
                    $returnArr['search'] = $search;
                }
            } else {
                $returnArr = array("result" => 0, "msg" => "没有数据或该用户不存在，否则为栏目不存在", "code" => 400);
            }
        }
        else {
            $returnArr = array("result" => 0, "msg" => "系统繁忙，请稍后再试", "code" => 400);
        }
        json_return($returnArr);
    }

    /*
       * 某条数据的具体内容
       */
    public function dataDetail(){
        $parameterGet = I('get.');
        $param = array_merge(I('post.'), I('get.'));
        $channelLogic = new ChannelLogic();
        $bool = $channelLogic->setTable($parameterGet['channel'], $parameterGet['type']);
        $channel = $_GET['channel'];
        $type = $_GET['type'];
        $userId = session('userArr')['user_id'];
        if ($bool) {
            switch($parameterGet['type']) {
                case  1://增加点击次数,只计算获取文章详情的操作
                    $this->addClickCount($parameterGet['channel'], $parameterGet['type'], $parameterGet['data_id']);
                    $info = $channelLogic->getDetail($parameterGet);
                    if($userId){

                        if($param['order_status']){
                            $where['activity_id'] = $info['id'];
                            $where['user_id'] = $userId;
                            $order = $channelLogic->getOrder($channel, 3, $where);
                            if($order) {
                                $info['order_status'] = $order['order_status'];
                                $info['order_id'] = $order['order_id'] ? $order['order_id'] : 0;
                                $info['ticket_cat_id'] = $order['ticket_cat_id'] ? $order['ticket_cat_id'] : 0;
                                $info['ticket_price'] = $order['total_amount'] ? $order['total_amount'] : 0;
                                $info['company'] = $order['company'] ? $order['company'] : '';
                                $info['job'] = $order['job'] ? $order['job'] : '';
                                $applyInfo = $channelLogic->getApplyInfo($channel, 3, $info['id'], $userId);
                                if(is_array($applyInfo)){
                                    $info = array_merge($info, $applyInfo);
                                }
                            } else {
                                $userInfo = $channelLogic->getUserInfo($userId);
                                $info = array_merge($info, $userInfo);
                            }
                          
                          
                        }
                        if($param['is_collect']){
                            $info['is_collect'] = $channelLogic->isCollect($channel, $type, $info['id'], $userId);
                        }
                    }

                    break;
                default:
                    $info = $channelLogic->getChildDetail($param);
                    break;
            }

            if ($info) {
                //是否显示购买按钮，暂时屏蔽
//                if($info['user_type'] == 2 && $userType == 2){
//                    $account = session('company_account');
//                    if($info['create_user_id'] == $account['id']){
//                        //如果当前服务为登录人发布，则不显示购买按钮
//                        $buy_flag = false;
//                    }
//
//                }else{
//                    $userId = session('userArr')['user_id'];
//                    if($info['create_user_id'] == $userId){
//                        //如果当前服务为登录人发布，则不显示购买按钮
//                        $buy_flag = false;
//                    }
//                }
//              $info['buy_flag'] = $buy_flag;
                //判断结束
                $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
            } else {
                $returnArr = array("result" => 0, "msg" => "没有数据或该用户不存在，否则为栏目不存在", "code" => 400);
            }
        }
        else {
            $returnArr = array("result" => 0, "msg" => "系统繁忙，请稍后再试", "code" => 400);
        }
        json_return($returnArr);
    }

    //获取用户发布的列表
    public function getMyBusinessList($parameter){

        $formArr = getTable($parameter['channel'],$parameter['type']);
        $activityTable = getTable($parameter['channel'],1);
       
        if($parameter['type_id'] >2) {
            $orderInfo = M()->table("{$formArr["table_name"]}")
                ->field('order_id,activity_id')
                ->where("activity_user_id = '{$_SESSION["userArr"]["user_id"]}' AND activity_user_type = 1 AND order_status > 1")
                ->limit($parameter['limit_start'], $parameter['limit_end'])
                ->select();
        } else {
          
            $orderInfo = M()->table("{$formArr["table_name"]}")
                ->field('order_id,activity_id')
                ->where("activity_user_id = '{$_SESSION["userArr"]["user_id"]}' AND activity_user_type = 1 AND order_status = 1 AND is_admin = 0")
                ->limit($parameter['limit_start'], $parameter['limit_end'])
                ->select();
        }
      
        $i =0 ;
        foreach ($orderInfo as $value) {
            $info[$i]['data'] = M($activityTable['table_format'])
                ->where("is_deleted = 0  AND is_active = 1 AND id='{$value['activity_id']}'")
                ->find();
            $info[$i]["order_id"] = $value['order_id'];
            $i++;
        }
        return $info;
    }

    //发布江湖救急
    public function add(){
        $parameter = I('get.');
        $channel = $parameter['channel'];
        $type = $parameter['type'];
        $data = I('post.');
        switch($type){
            case 1:
                $returnArr = $this->addActivity($channel, $type, $data);
                break;
            case 4://标签
                break;
            default:
                $returnArr = $this->addChildData($channel, $type, $parameter, $data);
                break;
        }
        json_return($returnArr);
    }

    private function addActivity($channel, $type, $data){
        $data["create_time"] = date("Y-m-d H:i:s", time());
        $tableName = $this->setTable($channel,$type);
        $data['channel_id'] = $tableName['channel_id'];

        if($data['create_user_id']){
            $data['create_user'] = M('ManageUsers')->where('user_id='.$data['create_user_id'])->getField('user_name');
        }

        $conf['call_index'] = $channel;
        $channelInfo = M('SystemChannel')->where($conf)->find();
        if($channelInfo['is_content_reviewed'] == 1){
            $data['status'] = 0;
        }

        $data = $this->saveBase64Image($data);
        $info = M("{$tableName['table_format']}")->add($data);
        if ($info) {
            $returnArr = array("result" => 1, "msg" => "发布任务成功", "code" => 200, "data" => 1);
        } else {
            $returnArr = array("result" => 0, "msg" => "系统繁忙，请稍后再试", "code" => 400);
        }
        return $returnArr;
    }

    //录入子表数据
    private function addChildData($channel, $type, $param, $data){
        if($param['user_type'] == 2){
            $userId = session('company_account')['user_id'];
            $userName = session('company_account')['nickname'];
            Log::write("企业用户信息[".json_encode(session('company_account'))."]");
        }else{
            $userId = session('userArr')['user_id'];
            $userName = session('userArr')['nickname'];
        }

        if($userId){
            $data['create_user_id'] = $userId;
            $data['create_user'] = $userName;
            $logic = new ChannelLogic();
            $logic->setTable($channel, $type);

            if($data['order_id']){
                $where['order_id'] = $data['order_id'];
                $order = $logic->getOrder($channel, 3, $where);
                $data['data_id'] = $order['data_id'] ? $order['data_id'] : $order['activity_id'];
            }

            //检查是否记录重复存在
            if($param['is_exist'] == 1){
                $userId = session('userArr')['user_id'];
                $where = array(
                    'create_user_id' => $userId,
                    'order_id' => $data['order_id'],
                );
                //同一个用户,同一张订单，不能出现多次预定
                $isExist = $logic->isExistData($where);
                if($isExist){
                    $returnArr = array("result" => 0, "msg" => "用户数据已存在", "code" => 707);
                    return $returnArr;
                }
            }

            $data = $this->saveBase64Image($data);
            Log::write("企业用户信息[".json_encode(session('company_account'))."]");
            $info = $logic->addData($channel, $type, $data);
            if ($info) {
                $returnArr = array("result" => 1, "msg" => "发布任务成功", "code" => 200, "data" => 1);
            } else {
                $returnArr = array("result" => 0, "msg" => "系统繁忙，请稍后再试", "code" => 400);
            }
        }else{
            $returnArr = array("result" => 0, "msg" => "请先登录", "code" => 666);
        }
        return $returnArr;
    }
    private function saveBase64Image($data){
        foreach($data as $key=>$value){
            if(strpos($value, 'data:image') !== false){
                $base64Image = $value;
                $site = get_site_name();
                $imgDiv = UPLOAD_PATH . $site. '/image/' . date('Ymd', time()) . '/';

                $imgPath = Image::base64ToFile($base64Image, $imgDiv, $key);
                $data[$key] = $imgPath;
            }
        }

        return $data;
    }


    /*
      * 根据条件统计总数
      */
    public function getCount(){
        $parameterGet = I('get.');
        $parameterPost = I('post.');

        $activityLogic = new ActivityLogic();
        $bool = $activityLogic->setTable($parameterPost['channel'],  $parameterPost['type']);

        $channelLogic = new ChannelLogic();
        $bool = $channelLogic->setTable($parameterGet['channel'],  $parameterGet['type']);

        if ($bool) {
            $info = $channelLogic->getCount($parameterPost);
        } else {
            $returnArr = array("result" => 0, "msg" => "系统繁忙，请稍后再试", "code" => 400);
        }
        json_return($returnArr);
    }

    //递归函数
    public function diff($id = 0, &$array = array())
    {
        $info = M("ActivityCategory")->where("id = $id")->find();
        if ($info) {
            $array[] = $info;
            $this->diff($info["parent_id"], $array);
        }
        return $array;
    }


    //个人中心---我的服务
    public function myBusiness(){
        $parameter = I('get.');
        $channel = $parameter['channel'];  //操作参数
        $type = $parameter['type'];
        $channelLogic = new ChannelLogic();
        $bool = $channelLogic->setTable($channel, $type);
        if ($bool) {
            $info = $channelLogic->getMyBusiness($parameter);
            if ($info) {
                $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
            } else {
                $returnArr = array("result" => 0, "msg" => "没有数据或该用户不存在，否则为栏目不存在", "code" => 400);
            }
        }
        else {
            $returnArr = array("result" => 0, "msg" => "系统繁忙，请稍后再试", "code" => 400);
        }
        json_return($returnArr);
    }

    //数量统计
    public function numberCount()
    {
        $action = $_GET['count'];
        $channel = $_GET['channel'];
        $type = $_GET['type'];
        $activityTable = getTable($channel,$type);
        switch ($action) {
            //个人中心里江湖救急的待付款，已完成，退款/售后数量统计
            case "service_count":
                //待付款
                $info['pending_payment'] = M($activityTable['table_format'])
                    ->where("user_id = '{$_SESSION["userArr"]["user_id"]}' AND order_status = 1")
                    ->count();
                //已完成
                $info['already_completed'] = M($activityTable['table_format'])
                    ->where("user_id = '{$_SESSION["userArr"]["user_id"]}' AND order_status = 2")
                    ->count();
                // 售后
                $info['customer_service'] = M($activityTable['table_format'])
                    ->where("user_id = '{$_SESSION["userArr"]["user_id"]}' AND order_status = 6 OR order_status = 7")
                    ->count();
                if($info) {
                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200 , "data" =>$info);
                }else {
                    $returnArr = array("result" => 0, "msg" => "获取失败", "code" => 402);
                }

                break;

            //个人中心里个人服务，已发布，待完成，已完成数量统计
            case "business_count":
                $info = $this->getMyBusiness();
                if($info) {
                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200 , "data" =>$info);
                }else {
                    $returnArr = array("result" => 0, "msg" => "获取失败", "code" => 402);
                }

                break;
            //其他
            default:
                $returnArr = array("result" => 0, "msg" => "请求错误，请求参数设置有误", "code" => 402);
        }
        json_return($returnArr);
    }

    //个人中心---我的服务
    public function getMyBusiness(){

        $activityTable = getTable($_GET['channel'],$_GET['type']);
        $orderTable = getTable($_GET['channel'],3);
        //已发布
        $info['already_released'] = M($activityTable['table_format'])
            ->where("is_deleted = 0 AND create_user_id = '{$_SESSION["userArr"]["user_id"]}'")
            ->count();
        //待完成
        $data = M($activityTable['table_format'])
            ->field("id")
            ->where("is_deleted = 0 AND create_user_id = '{$_SESSION["userArr"]["user_id"]}'")
            ->select();
        $pending_completion = 0;
        $already_over = 0;
        foreach ($data as $value) {
            //待完成
            $count = M($orderTable['table_format'])
                ->where("activity_id = '{$value['id']}' AND order_status = 1")
                ->count();

            //已结束
            $count2 = M($orderTable['table_format'])
                ->where("activity_id = '{$value['id']}' AND order_status >1")
                ->count();
            if($count) {
                $pending_completion += $count;
            }
            if($count2){
                $already_over += $count2;
            }
        }
        //待完成
        $info['pending_completion']= $pending_completion;
        //已结束
        $info['already_over'] = $already_over ;
        return $info ? $info : null;
    }

//    //列表
//    public function dataList(){
//        $parameter = I('get.');
//        $channel = $parameter['channel'];  //操作参数
//        $type = $parameter['type'];
//        $action = $_GET['action'];
//        $activity = new ActivityLogic();
//        switch ($action) {
//
//            case "company":
//                $parameter['user_type'] = 2;
//                $parameter['create_user_id'] = $_SESSION["company_account"]["id"];
//
//                $bool = $activity->setTable($channel, $type);
//                if ($bool) {
//
//                    $info = $activity->getListByCompany($parameter);
//                    if ($info === false) {
//                        $returnArr = array("result" => 0, "msg" => "获取失败", "code" => 401);
//                    } else {
//                        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                    }
//                }else {
//                    $returnArr = array("result" => 0, "msg" => "系统繁忙，请稍后再试", "code" => 400);
//                }
//                break;
//
//            //常规列表
//            case "form_list":
//
//                $bool = $activity->setTable($channel, $type);
//                if ($bool) {
//                    //  $article->__invoke($options);
//                    if($type == 1) {
//                        $info = $activity->activityList($parameter);
//                    } else if ($type == 4) {
//                        $info = $activity->getTagList($parameter);
//                    } else if ($type == 5) {
//                        $info = $activity->getTagArticleList($parameter);
//                    }
//                    if ($info) {
//                        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                    } else {
//                        $returnArr = array("result" => 0, "msg" => "没有数据或该用户不存在，否则为栏目不存在", "code" => 400);
//                    }
//                }
//                else {
//                    $returnArr = array("result" => 0, "msg" => "系统繁忙，请稍后再试", "code" => 400);
//                }
//                break;
//
//            //个人中心--个人服务---相应列表
//            case "business_list" :
//                    $info = $this->getMyBusinessList($parameter);
//                    if ($info) {
//                        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                    } else {
//                        $returnArr = array("result" => 0, "msg" => "没有数据或该用户不存在，否则为栏目不存在", "code" => 400);
//                    }
//                break;
//
//            //其他
//            default:
//                $returnArr = array("result" => 0, "msg" => "请求错误，请求参数设置有误", "code" => 402);
//        }
//
//        json_return($returnArr);
//    }

//    public function index()
//    {
//        $getData = $_GET;
//        $postData = $_POST;
//        $getAction = $_GET["action"];  //操作参数
//        $getSelfUserId = $_SESSION["userArr"]["user_id"];  //自身的用户id
//        $getSelfUserName = $_SESSION["userArr"]["mobile"];  //自身的用户名
//        $getOrderUserId = $_GET["id"];  //别人的用户id
//        $getDataId = $_GET["id"];  //别人的用户id
//        $getUserId = $_GET["userId"]; //报名用户id
//        $timeType = $_GET["time_type"]; //报名用户id
//        $getOrderUserName = "";  //自身的用户名
//        $type = $_GET["type"];  //频道获取类型，1，内容，2，栏目
//        $listType = $_GET["listType"];  //文章收藏，点赞，评论获取类型，1，文章的收藏，点赞，评论，2，用户的收藏，点赞，评论||PC端页面获取数据，1，侧边菜单数据，2，具体数据
//        $category_id = $_GET['category_id'];//获取栏目分类id
//        $data_id = $_GET["data_id"];//文章id,活动id
//        $top = $_GET["top"];  //文章收藏，点赞，评论获取的前几条数据
//        $getChannel = $_GET["channel"];  //频道别名
//        $channel_id = M("SystemChannel")->where("call_index='$getChannel'")->getField("id");  //频道id
//        $activity = new ActivityReLogic();
//        //登录用户享有的所有操作
//        if (!empty($getSelfUserId)) {
//            switch ($getAction) {
//                //获取部分、全部文章
//                case "list":
//
//                    if (!empty($channel_id) && !empty($type)) {
//                        //设置频道表名，返回布尔值，有为真，无为假
//                        $bool = $activity->setTable($getChannel, $type);
//                        if ($bool) {
//                            $options = array(
//                                "showType" => $getData["showType"],
//                                "top" => $getData["top"],
//                            );
//                            switch ($options["showType"]) {
//                                //获取该频道下全部文章
//                                case 1:
//                                    $info = $activity->getActivityList();
//
//                                    $i = 0;
//                                    foreach ($info as $v) {
//                                        $i++;
//                                    }
//                                    for ($m = 0; $m < $i; $m++) {
//                                        $info[$m]["formal_start_time"] = date("Y-m-d", strtotime($info[$m]["formal_start_time"]));
//                                        if($info[$m]["cost"]) {
//                                            if($info[$m]["cost"] == 0) {
//                                                $info[$m]["cost"] = '免费';
//                                            } else {
//                                                $d = $info[$m]["cost"];
//                                                $info[$m]["cost"] = "费用: $d";
//                                            }
//                                        }
//                                    }
//                                    if ($info) {
//                                        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                    } else {
//                                        $returnArr = array("result" => 0, "msg" => "没有数据", "code" => 402);
//                                    }
//                                    break;
//                                //获取该频道下指定用户文章
//                                case 2:
//                                    if ($getOrderUserId) {
//                                        //设置其他用户id
//                                        $options["orderUserId"] = $getOrderUserId;
//                                        $activity->__invoke($options);
//                                        $info = $activity->getAppointUserActivityList();
//                                        if ($info) {
//                                            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                        } else {
//                                            $returnArr = array("result" => 0, "msg" => "没有数据", "code" => 402);
//                                        }
//                                    } else {
//                                        $returnArr = array("result" => 1, "msg" => "没有指定要获取文章的用户", "code" => 200);
//                                        json_return($returnArr);
//                                    }
//                                    break;
//                                //获取该频道下自身用户，删除了的文章，需要登录
//                                case 3:
//                                    if ($getSelfUserId) {
//                                        //设置其他用户id
//                                        $options["orderUserId"] = $getSelfUserId;
//                                        $activity->__invoke($options);
//                                        $info = $activity->getAppointUserActivityDelList();
//                                        if ($info) {
//                                            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                        } else {
//                                            $returnArr = array("result" => 0, "msg" => "没有数据", "code" => 402);
//                                        }
//                                    } else {
//                                        $returnArr = array("result" => 0, "msg" => "未登录，请登录", "code" => 666);
//                                    }
//                                    break;
//                                //获取该频道下指定用户文章，收藏的文章，需要登录
//                                case 4:
//                                    if ($getSelfUserId) {
//                                        //设置其他用户id
//                                        $options["orderUserId"] = $getSelfUserId;
//                                        $activity->__invoke($options);
//                                        $info = $activity->getAppointUserActivityFavoriteList();
//                                        if ($info) {
//                                            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                        } else {
//                                            $returnArr = array("result" => 0, "msg" => "没有数据", "code" => 402);
//                                        }
//                                    } else {
//                                        $returnArr = array("result" => 0, "msg" => "未登录，请登录", "code" => 666);
//                                    }
//                                    break;
//                                //获取指定用户评论过的全部、部分文章信息，需要登录
//                                case 5:
//                                    if ($getSelfUserId) {
//                                        //设置其他用户id
//                                        $options["orderUserId"] = $getSelfUserId;
//                                        $activity->__invoke($options);
//                                        $info = $activity->getAppointUserActivityCommentList();
//                                        if ($info) {
//                                            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                        } else {
//                                            $returnArr = array("result" => 0, "msg" => "没有数据", "code" => 402);
//                                        }
//                                    } else {
//                                        $returnArr = array("result" => 0, "msg" => "未登录，请登录", "code" => 666);
//                                    }
//                                    break;
//                                //PC端页面通过栏目获取文章数据
//                                case 6:
//                                    if (!empty($top)) {
//                                        //获取内容表名
//                                        $info = $activity->getTable();
//                                        $tableName = $info["tableName"];
//                                        //重新获取表，获取栏目表
//                                        $activity->setTable($getChannel, 2);
//                                        //获取栏目表名
//                                        $info = $activity->getTable();
//                                        $categoryName = $info["tableName"];
//
//                                        $newsListCategory = M()->table("$categoryName")
//                                            ->field("id,cat_name")
//                                            ->where("is_deleted=0")
//                                            ->select();
//
//                                        $newsListData = M()->table("$tableName as a,$categoryName as b")
//                                            ->field("a.*,b.cat_name")
//                                            ->where("a.is_deleted=0 AND a.category_id='$category_id'AND b.id=a.category_id")
//                                            ->limit($top)
//                                            ->select();
//
//                                        $i = 0;
//                                        foreach ($newsListData as $v) {
//                                            $i++;
//                                        }
//                                        for ($m = 0; $m < $i; $m++) {
//                                            $newsListData[$m]["release_time"] = date("Y-m-d", strtotime($newsListData[$m]["create_time"]));
//                                            $newsListData[$m]["data_id"] = $newsListData[$m]["id"];
//                                        }
//                                        if ($listType == 1) {//侧边菜单数据
//                                            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $newsListCategory);
//                                        } else if ($listType == 2) {//右部具体数据
//                                            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $newsListData);
//                                        } else {
//                                            $returnArr = array("result" => 2, "msg" => "没有数据", "code" => 402);
//                                        }
//                                    } else {
//                                        $returnArr = array("result" => 0, "msg" => "请输入获取数量", "code" => 402);
//                                    }
//                                    break;
//                                case 7:
//                                    if (!empty($top)) {
//                                        //获取内容表名
//                                        $info = $activity->getTable();
//                                        $tableName = $info["tableName"];
//                                        //重新获取表，获取栏目表
//                                        $activity->setTable($getChannel, 2);
//                                        //获取栏目表名
//                                        $info = $activity->getTable();
//                                        $categoryName = $info["tableName"];
//
//                                        $categoryDisplay = M()->table("$categoryName")->where("is_deleted=0 AND id='$category_id'")->getField("cat_name");
//                                        $newsListCategory = M()->table("$categoryName")->field("id,cat_name")->where("is_deleted=0")->select();
//                                        $newsListData = M()->table("$tableName as a,$categoryName as b")
//                                            ->field("a.title,a.create_time,b.cat_name")
//                                            ->where("a.is_deleted=0 AND a.category_id='$category_id' AND b.id=a.category_id")
//                                            ->limit($top)
//                                            ->select();
//
//                                        if ($listType == 1) {//侧边菜单数据
//                                            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $newsListCategory);
//                                        } else if ($listType == 2) {//具体数据
//                                            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $newsListData);
//                                        } else {
//                                            $returnArr = array("result" => 2, "msg" => "没有数据", "code" => 402);
//                                        }
//                                    } else {
//                                        $returnArr = array("result" => 0, "msg" => "请输入获取数量", "code" => 402);
//                                    }
//                                    break;
//                                //根据活动时间将活动分类获取
//                                case 8:
//                                    $info = $activity->getActivityList($timeType);
//
//                                    if ($info) {
//                                        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                    } else {
//                                        $returnArr = array("result" => 0, "msg" => "没有数据", "code" => 402);
//                                    }
//                                    break;
//                                //其余情况下，统一获取频道下全部文章
//                                default:
//                                    $returnArr = array("result" => 0, "msg" => "参数设置错误", "code" => 402);
//                            }
//                        } else {
//                            $returnArr = array("result" => 0, "msg" => "频道不存在，请联系管理员", "code" => 402);
//                        }
//
//                    } else {
//                        $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402);
//                    }
//                    break;
//                //获取指定文章详细信息
//                case "detail":
//                    if (!empty($channel_id) && !empty($type)) {
//                        //设置频道表名，返回布尔值，有为真，无为假
//                        $bool = $activity->setTable($getChannel, $type);
//                        if ($bool) {
//                            $options = array(
//                                "dataId" => $data_id,
//                                "top" => $getData["top"],
//                            );
//                            $activity->__invoke($options);
//                            $info = $activity->getActivityDetail();
//                            $info["content"] = htmlspecialchars_decode($info["content"]);
//                            $joinCount = M("ActivityOrder")->where("activity_id='$data_id'")->count();//已经报名人数
//                            $info['join_count'] = $joinCount;
//                            if($info["cost"]) {
//                                $isJoin = M("ActivityOrder")->where("user_id='$getUserId' AND activity_id='$data_id'")->count();
//                                $info['is_join'] = false;
//                                if($isJoin > 0){
//                                    $info['is_join'] = true;
//                                }
//                                if($info["cost"] == 0) {
//                                    $info["cost"] = '免费';
//                                } else {
//                                    $d = $info["cost"];
//                                    $info["cost"] = "费用: $d";
//                                }
//                            }
//
//
//                            if ($info) {
//                                $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                            } else {
//                                $returnArr = array("result" => 0, "msg" => "没有数据", "code" => 402, "data" => $info);
//                            }
//                        } else {
//                            $returnArr = array("result" => 0, "msg" => "频道不存在，请联系管理员", "code" => 402);
//                        }
//                    } else {
//                        $returnArr = array("result" => 0, "msg" => "频道参数设置错误", "code" => 402);
//                    }
//                    break;
//                //点赞信息录入，需要登录
//                case "like":
//                    if (!empty($channel_id) && !empty($type) && !empty($getDataId)) {
//                        //设置频道表名，返回布尔值，有为真，无为假
//                        $bool = $activity->setTable($getChannel, $type);
//                        if ($bool) {
//                            //封装点赞用户信息与所点赞的文章
//                            $data = array(
//                                "zan_user_id" => $_SESSION["userArr"]["user_id"],
//                                "zan_user_name" => $_SESSION["userArr"]["mobile"],
//                                "zan_user_nickname" => $_SESSION["userArr"]["nickname"],
//                                "zan_time" => date("Y - m - d H:i:s", time()),
//                                "data_id" => $getDataId,
//                                "channel_id" => $channel_id,
//                            );
//                            $info = $activity->likes($data);
//                            if ($info) {
//                                $returnArr = array("result" => 1, "msg" => "点赞成功", "code" => 200, "data" => $info);
//                            } else {
//                                $returnArr = array("result" => -1, "msg" => "取消成功", "code" => 200, "data" => $info);
//                            }
//                        } else {
//                            $returnArr = array("result" => 0, "msg" => "频道不存在，请联系管理员", "code" => 402);
//                        }
//
//                    } else {
//                        $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402);
//                    }
//                    break;
//                //点赞信息
//                case "likeList":
//                    if (!empty($channel_id) && !empty($getDataId)) {
//                        switch ($listType) {
//                            //获取文章的所有点赞
//                            case 1:
//                                $info = $activity->getActivityLikesList($channel_id, $getDataId);
//                                if ($info) {
//                                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                } else {
//                                    $returnArr = array("result" => 0, "msg" => "没有查询到相关数据", "code" => 402, "data" => $info);
//                                }
//                                break;
//                            //获取用户的所有点赞
//                            case 2:
//                                $info = $activity->getSelfActivityLikesList($channel_id, $getSelfUserId);
//                                if ($info) {
//                                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                } else {
//                                    $returnArr = array("result" => 0, "msg" => "没有查询到相关数据", "code" => 402, "data" => $info);
//                                }
//                                break;
//                            default:
//                                $returnArr = array("result" => 0, "msg" => "请求错误，没有指定获取类型", "code" => 402);
//                        }
//                    } else {
//                        $returnArr = array("result" => 0, "msg" => "请求错误，频道参数设置错误", "code" => 402);
//                    }
//                    break;
//                //点赞前排数据
//                case "likeTop":
//                    if (!empty($channel_id) && !empty($getDataId) && !empty($top)) {
//                        switch ($listType) {
//                            //获取文章的所有点赞的前几条点赞数据
//                            case 1:
//                                $info = $activity->getActivityLikesTop($channel_id, $getDataId, $top);
//                                if ($info) {
//                                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                } else {
//                                    $returnArr = array("result" => 0, "msg" => "没有查询到相关数据", "code" => 402, "data" => $info);
//                                }
//                                break;
//                            //获取用户的所有点赞的前几条数据
//                            case 2:
//                                $info = $activity->getSelfActivityLikesTop($channel_id, $getSelfUserId, $top);
//                                if ($info) {
//                                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                } else {
//                                    $returnArr = array("result" => 0, "msg" => "没有查询到相关数据", "code" => 402, "data" => $info);
//                                }
//                                break;
//                            default:
//                                $returnArr = array("result" => 0, "msg" => "请求错误，没有指定获取类型", "code" => 402);
//                        }
//                    } else {
//                        $returnArr = array("result" => 0, "msg" => "请求错误，频道参数设置错误", "code" => 402);
//                    }
//                    break;
//                //收藏信息录入，需要登录
//                case "favorite":
//                    if (!empty($channel_id) && !empty($type) && !empty($getDataId)) {
//                        //设置频道表名，返回布尔值，有为真，无为假
//                        $bool = $activity->setTable($getChannel, $type);
//                        if ($bool) {
//                            //封装点赞用户信息与所点赞的文章
//                            $data = array(
//                                "collect_user_id" => $_SESSION["userArr"]["user_id"],
//                                "collect_user_name" => $_SESSION["userArr"]["mobile"],
//                                "collect_user_nickname" => $_SESSION["userArr"]["nickname"],
//                                "collect_time" => date("Y - m - d H:i:s", time()),
//                                "pageurl" => $_SERVER["REQUEST_URI"],
//                                "data_id" => $getDataId,
//                                "channel_id" => $channel_id,
//                            );
//                            $info = $activity->favorites($data);
//                            if ($info) {
//                                $returnArr = array("result" => 1, "msg" => "收藏成功", "code" => 200, "data" => $info);
//                            } else {
//                                $returnArr = array("result" => -1, "msg" => "取消成功", "code" => 200, "data" => $info);
//                            }
//                        } else {
//                            $returnArr = array("result" => 0, "msg" => "频道不存在，请联系管理员", "code" => 402);
//                        }
//
//                    } else {
//                        $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402);
//                    }
//                    break;
//                //收藏信息
//                case "favoriteList":
//                    if (!empty($channel_id) && !empty($getDataId)) {
//                        switch ($listType) {
//                            //获取文章的所有收藏
//                            case 1:
//                                $info = $activity->getActivityFavoritesList($channel_id, $getDataId);
//                                if ($info) {
//                                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                } else {
//                                    $returnArr = array("result" => 0, "msg" => "没有查询到相关数据", "code" => 402, "data" => $info);
//                                }
//                                break;
//                            //获取用户的所有收藏
//                            case 2:
//                                $info = $activity->getSelfActivityFavoritesList($channel_id, $getSelfUserId);
//                                if ($info) {
//                                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                } else {
//                                    $returnArr = array("result" => 0, "msg" => "没有查询到相关数据", "code" => 402, "data" => $info);
//                                }
//                                break;
//                            default:
//                                $returnArr = array("result" => 0, "msg" => "请求错误，没有指定获取类型", "code" => 402);
//                        }
//                    } else {
//                        $returnArr = array("result" => 0, "msg" => "请求错误，频道参数设置错误", "code" => 402);
//                    }
//                    break;
//                //收藏前排数据
//                case "favoriteTop":
//                    if (!empty($channel_id) && !empty($getDataId) && !empty($top)) {
//                        switch ($listType) {
//                            //获取文章的所有收藏的前几条
//                            case 1:
//                                $info = $activity->getActivityLikesTop($channel_id, $getDataId, $top);
//                                if ($info) {
//                                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                } else {
//                                    $returnArr = array("result" => 0, "msg" => "没有查询到相关数据", "code" => 402, "data" => $info);
//                                }
//                                break;
//                            //获取用户的所有收藏的前几条
//                            case 2:
//                                $info = $activity->getSelfActivityFavoritesTop($channel_id, $getSelfUserId, $top);
//                                if ($info) {
//                                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                } else {
//                                    $returnArr = array("result" => 0, "msg" => "没有查询到相关数据", "code" => 402, "data" => $info);
//                                }
//                                break;
//                            default:
//                                $returnArr = array("result" => 0, "msg" => "请求错误，没有指定获取类型", "code" => 402);
//                        }
//                    } else {
//                        $returnArr = array("result" => 0, "msg" => "请求错误，频道参数设置错误", "code" => 402);
//                    }
//                    break;
//                //评论信息录入，需要登录
//                case "comment":
//                    if (!empty($channel_id) && !empty($getDataId)) {
//                        //封装评论用户信息与所评论的文章
//                        $data = array(
//                            "content" => $postData["content"],
//                            "comment_user_id" => $_SESSION["userArr"]["user_id"],
//                            "comment_user_name" => $_SESSION["userArr"]["mobile"],
//                            "comment_user_nickname" => $_SESSION["userArr"]["nickname"],
//                            "comment_time" => date("Y-m-d H:i:s", time()),
//                            "data_id" => $getDataId,
//                            "channel_id" => $channel_id,
//                        );
//                        //验证表单不能为空
//                        $returnArr = array("result" => 0, "msg" => "内容不能为空", "code" => 402);
//                        if (empty($data["content"])) json_return($returnArr);
//                        //录入数据
//                        $info = $activity->comments($data);
//                        if ($info) {
//                            $data["comment_time"] = date_to_timestamp($data["comment_time"]);
//                            $returnArr = array("result" => 1, "msg" => "评论成功", "code" => 200, "data" => $data);
//                        } else {
//                            $returnArr = array("result" => 0, "msg" => "评论失败，网络繁忙", "code" => 402);
//                        }
//                    } else {
//                        $returnArr = array("result" => 0, "msg" => "请求错误，请求参数设置有误", "code" => 402);
//                    }
//                    break;
//                //评论信息
//                case "commentList":
//                    if (!empty($channel_id) && !empty($getDataId)) {
//                        switch ($listType) {
//                            //获取文章下的所有评论
//                            case 1:
//                                $info = $activity->getActivityCommentsList($channel_id, $getDataId);
//                                if ($info) {
//                                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                } else {
//                                    $returnArr = array("result" => 0, "msg" => "没有查询到相关数据", "code" => 402, "data" => $info);
//                                }
//                                break;
//                            //获取用户的所有评论
//                            case 2:
//                                $info = $activity->getSelfActivityCommentsList($channel_id, $getSelfUserId);
//                                if ($info) {
//                                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                } else {
//                                    $returnArr = array("result" => 0, "msg" => "没有查询到相关数据", "code" => 402, "data" => $info);
//                                }
//                                break;
//                            default:
//                                $returnArr = array("result" => 0, "msg" => "请求错误，没有指定获取类型", "code" => 402);
//                        }
//                    } else {
//                        $returnArr = array("result" => 0, "msg" => "请求错误，频道参数设置错误", "code" => 402);
//                    }
//                    break;
//                //评论前排数据
//                case "commentTop":
//                    if (!empty($channel_id) && !empty($getDataId) && !empty($top)) {
//                        switch ($listType) {
//                            //获取文章评论的前几条评论
//                            case 1:
//                                $info = $activity->getActivityCommentsTop($channel_id, $getDataId, $top);
//                                if ($info) {
//                                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                } else {
//                                    $returnArr = array("result" => 0, "msg" => "没有查询到相关数据", "code" => 402, "data" => $info);
//                                }
//                                break;
//                            //获取用户评论的前几条评论
//                            case 2:
//                                $info = $activity->getSelfActivityCommentsTop($channel_id, $getSelfUserId, $top);
//                                if ($info) {
//                                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                } else {
//                                    $returnArr = array("result" => 0, "msg" => "没有查询到相关数据", "code" => 402, "data" => $info);
//                                }
//                                break;
//                            default:
//                                $returnArr = array("result" => 0, "msg" => "请求错误，没有指定获取类型", "code" => 402);
//                        }
//                    } else {
//                        $returnArr = array("result" => 0, "msg" => "请求错误，频道参数设置错误", "code" => 402);
//                    }
//                    break;
//                //图片上传
//                case "imgUpload":
//                    if (!empty($channel_id) && !empty($type)) {
//                        //设置频道表名，返回布尔值，有为真，无为假
//                        $bool = $activity->setTable($getChannel, $type);
//                        if ($bool) {
//                            // 实例化上传类
//                            $upload = new \Think\Upload();
//                            // 设置附件上传大小 (-1) 是不限值大小
//                            $upload->maxSize = 1024 * 1024;
//                            $upload->saveName = mt_rand(1, 99999) . substr(md5(mt_rand(1, 9999) . time()), 1, 13);
//                            // 设置附件上传类型
//                            $upload->allowExts = array(
//                                'jpg', 'gif', 'png', 'jpeg'
//                            );
//                            // 设置附件上传父目录
//                            $upload->rootPath = " ./Public/upload / ";
//                            //设置附件上传子路径
//                            $upload->savePath = "Activity / " . date("Y", time()) . " / " . date("m - d", time()) . " / ";
//                            $upload->autoSub = false;
//                            $upload->saveExt = "";
//                            $uploadInfo = $upload->upload();
//                            // 保存表单数据 包括附件数据
//                            if ($uploadInfo) {
//                                $returnArr = array("result" => 1, "msg" => "上传成功", "code" => 200, "data" => $uploadInfo["file"]["urlpath"]);
//                            } else {
//                                $returnArr = array("result" => 0, "msg" => "上传失败", "code" => 402);
//                            }
//
////                    //----- 创建缩略图 -----//
////                foreach ($uploadInfo as $v) {
////                    //缩略图 文件保存地址
////                    $timage = " ./" . $v['savepath'] . $v['savename'];
////                    //上传数据库
////                    $arr['image'] = " ./" . $v['savepath'] . $v['savename'];//保存图片路径
////                    $arr['create_time'] = NOW_TIME;//创建时间
////
////                    if ($_POST['thum'] == 1) {
////                        // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
////                        $spath = " ./Uploads / " . $v['savepath'] . "s_" . $v['savename']; //缩略图名称 地址
////                        $this->thumbs($timage, $spath, $_POST['hejpg'], $_POST['wijpg']);
////                        $arr['simage'] = $v['savepath'] . "s_" . $v['savename'];//保存缩略图片路径
////                    }
////                }
//                        } else {
//                            $returnArr = array("result" => 0, "msg" => "频道不存在，请联系管理员", "code" => 402);
//                        }
//                    } else {
//                        $returnArr = array("result" => 0, "msg" => "频道参数设置错误", "code" => 402);
//                    }
//                    break;
//                //获取所有频道
//                case "allTable":
//                    $info = $activity->getAllTable();
//                    if ($info) {
//                        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                    } else {
//                        $returnArr = array("result" => 1, "msg" => "频道为空，请创建", "code" => 200, "data" => $info);
//                    }
//                    break;
//                //支付功能
//                case "pay":
//
//                    break;
//                //活动报名功能
//                case "activityJoin":
//                    if ($getUserId) {
//                        $ifJoin = M("ActivityOrder")->where("user_id='$getUserId' AND activity_id='$data_id'")->getField("order_id");
//                        if($ifJoin == NULL) {
//                            $data["user_id"] = $getUserId;
//                            $data["activity_id"] =$data_id ;
//                            $data["add_time"] = date("Y-m-d H:i:s", time());
//                            $info = M("ActivityOrder")->add($data);
//                        }
//                        if ($info) {
//                            $returnArr = array("result" => 1, "msg" => "报名成功", "code" => 200, "data" => 1);
//                        } else if($ifJoin){
//                            $returnArr = array("result" => 0, "msg" => "已经报名", "code" => 402, "data" => null);
//                        }
//                    } else {
//                        $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402, "data" => null);
//                    }
//
//                    break;
//                //其他
//                default:
//                    $returnArr = array("result" => 0, "msg" => "请求错误，请求参数设置有误", "code" => 402);
//            }
//        } else {
//            //不需要登录享有的部分操作
//            switch ($getAction) {
//                //获取部分、全部文章
//                case "list":
//                    if (!empty($channel_id) && !empty($type)) {
//                        //设置频道表名，返回布尔值，有为真，无为假
//                        $bool = $activity->setTable($getChannel, $type);
//                        if ($bool) {
//                            $options = array(
//                                "showType" => $getData["showType"],
//                                "top" => $getData["top"],
//                            );
//                            switch ($options["showType"]) {
//                                //获取该频道下全部文章
//                                case 1:
//                                    $info = $activity->getActivityList();
//                                    if ($info) {
//                                        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                    } else {
//                                        $returnArr = array("result" => 0, "msg" => "没有数据", "code" => 402);
//                                    }
//                                    break;
//                                //获取该频道下指定用户文章
//                                case 2:
//                                    if ($getOrderUserId) {
//                                        //设置其他用户id
//                                        $options["orderUserId"] = $getOrderUserId;
//                                        $activity->__invoke($options);
//                                        $info = $activity->getAppointUserActivityList();
//                                        if ($info) {
//                                            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                        } else {
//                                            $returnArr = array("result" => 0, "msg" => "没有数据", "code" => 402);
//                                        }
//                                    } else {
//                                        $returnArr = array("result" => 1, "msg" => "没有指定要获取文章的用户", "code" => 200);
//                                        json_return($returnArr);
//                                    }
//                                    break;
//                                //获取该频道下自身用户，删除了的文章，需要登录
//                                case 3:
//                                    if ($getSelfUserId) {
//                                        //设置其他用户id
//                                        $options["orderUserId"] = $getSelfUserId;
//                                        $activity->__invoke($options);
//                                        $info = $activity->getAppointUserActivityDelList();
//                                        if ($info) {
//                                            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                        } else {
//                                            $returnArr = array("result" => 0, "msg" => "没有数据", "code" => 402);
//                                        }
//                                    } else {
//                                        $returnArr = array("result" => 0, "msg" => "未登录，请登录", "code" => 666);
//                                    }
//                                    break;
//                                //获取该频道下指定用户文章，收藏的文章，需要登录
//                                case 4:
//                                    if ($getSelfUserId) {
//                                        //设置其他用户id
//                                        $options["orderUserId"] = $getSelfUserId;
//                                        $activity->__invoke($options);
//                                        $info = $activity->getAppointUserActivityFavoriteList();
//                                        if ($info) {
//                                            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                        } else {
//                                            $returnArr = array("result" => 0, "msg" => "没有数据", "code" => 402);
//                                        }
//                                    } else {
//                                        $returnArr = array("result" => 0, "msg" => "未登录，请登录", "code" => 666);
//                                    }
//                                    break;
//                                //获取该频道下指定用户文章，评论过的的文章，需要登录
//                                case 5:
//                                    if ($getSelfUserId) {
//                                        //设置其他用户id
//                                        $options["orderUserId"] = $getSelfUserId;
//                                        $activity->__invoke($options);
//                                        $info = $activity->getAppointUserActivityCommentList();
//                                        if ($info) {
//                                            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                        } else {
//                                            $returnArr = array("result" => 0, "msg" => "没有数据", "code" => 402);
//                                        }
//                                    } else {
//                                        $returnArr = array("result" => 0, "msg" => "未登录，请登录", "code" => 666);
//                                    }
//                                    break;
//                                //PC端页面通过栏目获取文章数据
//                                case 6:
//                                    //获取内容表名
//                                    $info = $activity->getTable();
//                                    $tableName = $info["tableFormat"];
//                                    //重新获取表，获取栏目表
//
//                                    $activity->setTable($getChannel, 2);
//                                    //获取栏目表名
//                                    $info = $activity->getTable();
//
//                                    $categoryName = $info["tableFormat"];
//                                    $categoryAllName = $info["tableName"];
//
//                                    $newsListCategory = M("$categoryName")->alias('a')
//                                        ->field("a.id,a.cat_name")
//                                        ->where("a.is_deleted=0")
//                                        ->select();
//
//                                    $newsListData = M("$tableName")->alias('a')->
//                                    field("a.*,b.cat_name")->
//                                    join("$categoryAllName b on b.id=a.category_id", "LEFT")->
//                                    where("a.is_deleted=0 AND a.category_id='$category_id'")->select();
//                                    $i = 0;
//                                    foreach ($newsListData as $v) {
//                                        $i++;
//                                    }
//                                    for ($m = 0; $m < $i; $m++) {
//                                        $newsListData[$m]["release_time"] = date("Y-m-d", strtotime($newsListData[$m]["create_time"]));
//                                        $newsListData[$m]["data_id"] = $newsListData[$m]["id"];
//                                    }
//
//                                    if ($listType == 1) {//侧边菜单数据
//                                        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $newsListCategory);
//                                    } else if ($listType == 2) {//右部具体数据
//                                        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $newsListData);
//                                    } else {
//                                        $returnArr = array("result" => 2, "msg" => "没有数据", "code" => 402);
//                                    }
//                                    break;
//                                case 7:
//                                    //获取内容表名
//                                    $info = $activity->getTable();
//                                    $tableName = $info["tableFormat"];
//                                    $newsInfoData = M("$tableName")->where("id = '$data_id'")->select();
//                                    $newsInfoData[0]['content'] = htmlspecialchars_decode($newsInfoData[0]['content']);
//                                    $newsInfoData[0]['release_time'] = date("Y-m-d", strtotime($newsInfoData[0]['create_time']));
//
//                                    if ($newsInfoData) {
//                                        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $newsInfoData);
//                                    } else {
//                                        $returnArr = array("result" => 2, "msg" => "没有数据", "code" => 402);
//                                    }
//                                    break;
//                                //其余情况下，统一获取频道下全部文章
//                                default:
//                                    $returnArr = array("result" => 0, "msg" => "参数设置错误", "code" => 402);
//                            }
//
//                        } else {
//
//                            $returnArr = array("result" => 0, "msg" => "频道不存在，请联系管理员", "code" => 402);
//                        }
//
//                    } else {
//                        $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402);
//                    }
//                    break;
//                //获取指定文章详细信息
//                case "detail":
//                    if (!empty($channel_id) && !empty($type)) {
//                        //设置频道表名，返回布尔值，有为真，无为假
//                        $bool = $activity->setTable($getChannel, $type);
//                        if ($bool) {
//
//                            $options = array(
//                                "dataId" => $getDataId,
//                                "top" => $getData["top"],
//                            );
//                            $activity->__invoke($options);
//                            $info = $activity->getActivityDetail();
//                            $joinCount = M("ActivityOrder")->where("activity_id='$data_id'")->count();
//                            $info['join_count'] = $joinCount;
//                            if ($info) {
//                                $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                            } else {
//                                $returnArr = array("result" => 0, "msg" => "没有数据", "code" => 402, "data" => $info);
//                            }
//                        } else {
//                            $returnArr = array("result" => 0, "msg" => "频道不存在，请联系管理员", "code" => 402);
//                        }
//                    } else {
//                        $returnArr = array("result" => 0, "msg" => "频道参数设置错误", "code" => 402);
//                    }
//                    break;
//                //点赞信息
//                case "likeList":
//                    if (!empty($channel_id) && !empty($getDataId)) {
//                        switch ($listType) {
//                            //获取文章的所有点赞
//                            case 1:
//                                $info = $activity->getActivityLikesList($channel_id, $getDataId);
//                                if ($info) {
//                                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                } else {
//                                    $returnArr = array("result" => 0, "msg" => "没有查询到相关数据", "code" => 402, "data" => $info);
//                                }
//                                break;
//                            //获取用户的所有点赞
//                            case 2:
//                                $info = $activity->getSelfActivityLikesList($channel_id, $getSelfUserId);
//                                if ($info) {
//                                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                } else {
//                                    $returnArr = array("result" => 0, "msg" => "没有查询到相关数据", "code" => 402, "data" => $info);
//                                }
//                                break;
//                            default:
//                                $returnArr = array("result" => 0, "msg" => "请求错误，没有指定获取类型", "code" => 402);
//                        }
//                    } else {
//                        $returnArr = array("result" => 0, "msg" => "请求错误，频道参数设置错误", "code" => 402);
//                    }
//                    break;
//                //点赞前排数据
//                case "likeTop":
//                    if (!empty($channel_id) && !empty($getDataId) && !empty($top)) {
//                        switch ($listType) {
//                            //获取文章的所有点赞的前几条点赞数据
//                            case 1:
//                                $info = $activity->getActivityLikesTop($channel_id, $getDataId, $top);
//                                if ($info) {
//                                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                } else {
//                                    $returnArr = array("result" => 0, "msg" => "没有查询到相关数据", "code" => 402, "data" => $info);
//                                }
//                                break;
//                            //获取用户的所有点赞的前几条数据
//                            case 2:
//                                $info = $activity->getSelfActivityLikesTop($channel_id, $getSelfUserId, $top);
//                                if ($info) {
//                                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                } else {
//                                    $returnArr = array("result" => 0, "msg" => "没有查询到相关数据", "code" => 402, "data" => $info);
//                                }
//                                break;
//                            default:
//                                $returnArr = array("result" => 0, "msg" => "请求错误，没有指定获取类型", "code" => 402);
//                        }
//                    } else {
//                        $returnArr = array("result" => 0, "msg" => "请求错误，频道参数设置错误", "code" => 402);
//                    }
//                    break;
//                //收藏信息
//                case "favoriteList":
//                    if (!empty($channel_id) && !empty($getDataId)) {
//                        switch ($listType) {
//                            //获取文章的所有收藏
//                            case 1:
//                                $info = $activity->getActivityFavoritesList($channel_id, $getDataId);
//                                if ($info) {
//                                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                } else {
//                                    $returnArr = array("result" => 0, "msg" => "没有查询到相关数据", "code" => 402, "data" => $info);
//                                }
//                                break;
//                            //获取用户的所有收藏
//                            case 2:
//                                $info = $activity->getSelfActivityFavoritesList($channel_id, $getSelfUserId);
//                                if ($info) {
//                                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                } else {
//                                    $returnArr = array("result" => 0, "msg" => "没有查询到相关数据", "code" => 402, "data" => $info);
//                                }
//                                break;
//                            default:
//                                $returnArr = array("result" => 0, "msg" => "请求错误，没有指定获取类型", "code" => 402);
//                        }
//                    } else {
//                        $returnArr = array("result" => 0, "msg" => "请求错误，频道参数设置错误", "code" => 402);
//                    }
//                    break;
//                //收藏前排数据
//                case "favoriteTop":
//                    if (!empty($channel_id) && !empty($getDataId) && !empty($top)) {
//                        switch ($listType) {
//                            //获取文章的所有收藏的前几条
//                            case 1:
//                                $info = $activity->getActivityLikesTop($channel_id, $getDataId, $top);
//                                if ($info) {
//                                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                } else {
//                                    $returnArr = array("result" => 0, "msg" => "没有查询到相关数据", "code" => 402, "data" => $info);
//                                }
//                                break;
//                            //获取用户的所有收藏的前几条
//                            case 2:
//                                $info = $activity->getSelfActivityFavoritesTop($channel_id, $getSelfUserId, $top);
//                                if ($info) {
//                                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                } else {
//                                    $returnArr = array("result" => 0, "msg" => "没有查询到相关数据", "code" => 402, "data" => $info);
//                                }
//                                break;
//                            default:
//                                $returnArr = array("result" => 0, "msg" => "请求错误，没有指定获取类型", "code" => 402);
//                        }
//                    } else {
//                        $returnArr = array("result" => 0, "msg" => "请求错误，频道参数设置错误", "code" => 402);
//                    }
//                    break;
//                //评论信息
//                case "commentList":
//                    if (!empty($channel_id) && !empty($getDataId)) {
//                        switch ($listType) {
//                            //获取文章下的所有评论
//                            case 1:
//                                $info = $activity->getActivityCommentsList($channel_id, $getDataId);
//                                if ($info) {
//                                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                } else {
//                                    $returnArr = array("result" => 0, "msg" => "没有查询到相关数据", "code" => 402, "data" => $info);
//                                }
//                                break;
//                            //获取用户的所有评论
//                            case 2:
//                                $info = $activity->getSelfActivityCommentsList($channel_id, $getSelfUserId);
//                                if ($info) {
//                                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                } else {
//                                    $returnArr = array("result" => 0, "msg" => "没有查询到相关数据", "code" => 402, "data" => $info);
//                                }
//                                break;
//                            default:
//                                $returnArr = array("result" => 0, "msg" => "请求错误，没有指定获取类型", "code" => 402);
//                        }
//                    } else {
//                        $returnArr = array("result" => 0, "msg" => "请求错误，频道参数设置错误", "code" => 402);
//                    }
//                    break;
//                //评论前排数据
//                case "commentTop":
//                    if (!empty($channel_id) && !empty($getDataId) && !empty($top)) {
//                        switch ($listType) {
//                            //获取文章评论的前几条评论
//                            case 1:
//                                $info = $activity->getActivityCommentsTop($channel_id, $getDataId, $top);
//                                if ($info) {
//                                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                } else {
//                                    $returnArr = array("result" => 0, "msg" => "没有查询到相关数据", "code" => 402, "data" => $info);
//                                }
//                                break;
//                            //获取用户评论的前几条评论
//                            case 2:
//                                $info = $activity->getSelfActivityCommentsTop($channel_id, $getSelfUserId, $top);
//                                if ($info) {
//                                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//                                } else {
//                                    $returnArr = array("result" => 0, "msg" => "没有查询到相关数据", "code" => 402, "data" => $info);
//                                }
//                                break;
//                            default:
//                                $returnArr = array("result" => 0, "msg" => "请求错误，没有指定获取类型", "code" => 402);
//                        }
//                    } else {
//                        $returnArr = array("result" => 0, "msg" => "请求错误，频道参数设置错误", "code" => 402);
//                    }
//                    break;
//                //图片上传
//                case "imgUpload":
//                    if (!empty($channel_id) && !empty($type)) {
//                        //设置频道表名，返回布尔值，有为真，无为假
//                        $bool = $activity->setTable($getChannel, $type);
//                        if ($bool) {
//                            // 实例化上传类
//                            $upload = new \Think\Upload();
//                            // 设置附件上传大小 (-1) 是不限值大小
//                            $upload->maxSize = 1024 * 1024;
//                            $upload->saveName = mt_rand(1, 99999) . substr(md5(mt_rand(1, 9999) . time()), 1, 13);
//                            // 设置附件上传类型
//                            $upload->allowExts = array(
//                                'jpg', 'gif', 'png', 'jpeg'
//                            );
//                            // 设置附件上传父目录
//                            $upload->rootPath = " ./Public/upload / ";
//                            //设置附件上传子路径
//                            $upload->savePath = "Activity / " . date("Y", time()) . " / " . date("m - d", time()) . " / ";
//                            $upload->autoSub = false;
//                            $upload->saveExt = "";
//                            $uploadInfo = $upload->upload();
//                            // 保存表单数据 包括附件数据
//                            if ($uploadInfo) {
//                                $returnArr = array("result" => 1, "msg" => "上传成功", "code" => 200, "data" => $uploadInfo["file"]["urlpath"]);
//                            } else {
//                                $returnArr = array("result" => 0, "msg" => "上传失败", "code" => 402);
//                            }
//
////                    //----- 创建缩略图 -----//
////                foreach ($uploadInfo as $v) {
////                    //缩略图 文件保存地址
////                    $timage = " ./" . $v['savepath'] . $v['savename'];
////                    //上传数据库
////                    $arr['image'] = " ./" . $v['savepath'] . $v['savename'];//保存图片路径
////                    $arr['create_time'] = NOW_TIME;//创建时间
////
////                    if ($_POST['thum'] == 1) {
////                        // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
////                        $spath = " ./Uploads / " . $v['savepath'] . "s_" . $v['savename']; //缩略图名称 地址
////                        $this->thumbs($timage, $spath, $_POST['hejpg'], $_POST['wijpg']);
////                        $arr['simage'] = $v['savepath'] . "s_" . $v['savename'];//保存缩略图片路径
////                    }
////                }
//                        } else {
//                            $returnArr = array("result" => 0, "msg" => "频道不存在，请联系管理员", "code" => 402);
//                        }
//                    } else {
//                        $returnArr = array("result" => 0, "msg" => "频道参数设置错误", "code" => 402);
//                    }
//                    break;
//                //未登录
//                default:
//                    $returnArr = array("result" => 0, "msg" => "请先登录", "code" => 666);
//            }
//        }
//        json_return($returnArr);
//    }
}
