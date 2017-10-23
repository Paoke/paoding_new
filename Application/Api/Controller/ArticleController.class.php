<?php

namespace Api\Controller;

use Api\Logic\ChannelLogic;
use Think\Log;
use Think\Controller;


class ArticleController extends BaseRestController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {}

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
                   
                    $param['channel_type'] = 'article';
                    $info = $channelLogic->getList($param);
                   
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
                default:
                  
                    $info = $channelLogic->getChildList($param);
                    break;
            }
          
            if ($info) {
                $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
            } else {
                $returnArr = array("result" => 0, "msg" => "没有数据或该用户不存在，否则为栏目不存在", "code" => 400);
            }
        } else {
            $returnArr = array("result" => 0, "msg" => "系统繁忙，请稍后再试", "code" => 400);
        }
        json_return($returnArr);
    }

    /*
     * 某条数据的具体内容
     */
    public function dataDetail(){
        $parameterGet = I('get.');
        $channelLogic = new ChannelLogic();
        $bool = $channelLogic->setTable($parameterGet['channel'], $parameterGet['type']);
        $postData = I('post.');
        $param = array_merge($parameterGet, $postData);
        if ($bool) {
            switch($parameterGet['type']) {
                case  1://增加点击次数,只计算获取文章详情的操作
                    $this->addClickCount($parameterGet['channel'], $parameterGet['type'], $parameterGet['data_id']);
                    $info = $channelLogic->getDetail($parameterGet);
                    break;
                default:
                    $info = $channelLogic->getChildDetail($param);
                    break;
            }
            
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

    /*
     * 添加数据
     */
    public function add(){
        $parameterGet = I('get.');
        $parameterPost = I('post.');
        $param = array_merge($parameterGet, $parameterPost);
       
        $channelLogic = new ChannelLogic();
        $bool = $channelLogic->setTable($param['channel'], $param['type']);
        if ($bool) {
            $info=$channelLogic->addData($param['channel'], $param['type'],$parameterPost);
            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
        }else {
            $returnArr = array("result" => 0, "msg" => "系统繁忙，请稍后再试", "code" => 400);
        }
        json_return($returnArr);
    }
    /*
     * 联系我们(庖丁代码专用)
     */
    public function add_by_code(){
        $getData = $_GET;
        $postData = $_POST;
        $user = new ChannelLogic();
        $options = array(
            "content" => $postData["jumpMessage"],
            "nickname"=>$postData['jumpName'],
            "mobile"=>$postData['jumpMobile'],
            "code"=>$postData['code'],
             "category_id"=>$postData['category_id'],
        );

        //验证五分钟内验证码有效
        $date=M("ManageSmsLog")->where("add_time between date_add(now(), interval - 5 minute) and now() AND is_active=1")->count();
        if(!$date){
            $returnArr=array("result"=>0,"msg"=>"验证码已过期，请重新发送","code"=>402,"data"=>null);
            json_return($returnArr);
        }

        //校验验证码的正误
        $count = M("ManageSmsLog")->where(array("code = '" . $postData['code'] . "'","is_active=1"))->count();
        if(!$count){
            $returnArr = array("result" => 0, "msg" => "验证码不正确,请重新输入", "code" => 200, "data" => null);
            json_return($returnArr);
        }

        $returnArr = array("result" => 0, "msg" => "姓名不能为空", "code" => 402, "data" => null);
        if (empty($options["nickname"])) json_return($returnArr);
        $returnArr = array("result" => 0, "msg" => "留言信息不能为空", "code" => 402, "data" => null);
        if (empty($options["content"])) json_return($returnArr);
        $returnArr = array("result" => 0, "msg" => "手机号码不能为空", "code" => 402, "data" => null);
        if (empty($options["mobile"])) json_return($returnArr);


        $data = array(
            "desc"=>$options["content"],
            "xingming" =>$options["nickname"],
            "sjh"=> $options["mobile"],
            "category_id"=>$options["category_id"],
            "status"=>0,
            "create_time"=>date("Y-m-d H:i:s")
        );

        $info = $user->Contact($data);

        if($info){
//            $returnArr = array("result" => 0, "msg" => "该用户不存在", "code" => 402);
//        }else{
            $returnArr = array("result" => 1, "msg" => "提交成功", "code" => 200);
        }else {
            $returnArr = array("result" => 0, "msg" => "提交失败", "code" => 402);
        }
        json_return($returnArr);
    }

    /*
     * 添加数据
     */
    public function addByCode(){
        $parameterGet = I('get.');
        $parameterPost = I('post.');
        $param = array_merge($parameterGet, $parameterPost);
        $channelLogic = new ChannelLogic();
        $bool = $channelLogic->setTable($param['channel'], $param['type']);
        if ($bool) {
            $info=$channelLogic->addData($param['channel'], $param['type'],$parameterPost);
            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
        }else {
            $returnArr = array("result" => 0, "msg" => "系统繁忙，请稍后再试", "code" => 400);
        }
        json_return($returnArr);
    }

    /*
     *添加文章被获取联系方式
     * */
    public function getContactData(){
        $parameterGet = I('get.');
        $channelLogic = new ChannelLogic();
        $channelLogic->setTable("cklx", 1);
        $channelLogic = new ChannelLogic();
        $table = $channelLogic->getChannelTable($parameterGet['channel'], 1);
        $data['wzID'] = $parameterGet['data_id'];
        $data['wzlx'] = $parameterGet['type'];
        $data['yhID'] = $parameterGet['user_id'];
        $data['title'] =M($table['table_format'])->where("id={$parameterGet['data_id']}")->getField("title");

        $userData = M("ManageUsers")->field("nickname,user_name")->where("user_id = ".$parameterGet['user_id'])->find();
        $data['yhxm'] = $userData['nickname'];
        $data['yhdhhm'] = $userData['user_name'];
         $data['status'] = 0;
        $data["create_time"] = date("Y-m-d H:i:s", time());
        $info = M("ArticleCklx")->add($data);
        if($info) {
            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
        } else {
            $returnArr = array("result" => 0, "msg" => "系统繁忙，请稍后再试", "code" => 400);
        }
        json_return($returnArr);
    }


    /*
     * 发送邮件
     */
    public function toEmail(){
        $da=$_SERVER['PHP_SELF'];
        $parameter = I('get.');
        $channel = $parameter['channel'];  //操作参数
        $type = $parameter['type'];

        $channelLogic = new ChannelLogic();
        $bool = $channelLogic->setTable($channel, $type);
        if ($bool) {

            $table = $channelLogic->getTable()['tableFormat'];
            $info = M("$table")
                ->field("id,title,scwj")
                ->where("is_deleted=0 AND id=".$parameter['data_id'])
                ->find();
            if(!$info){
                $returnArr = array("result" => 0, "msg" => "发送邮件失败!获取文件信息出错!", "code" => 402);
                json_return($returnArr);
            }

            $userId  = $_SESSION["userArr"]["user_id"];
            $userEmail = M("ManageUsers")
                   ->where("user_id=".$userId)
                   ->getField("email");
            if(empty($userEmail)){
                $returnArr = array("result" => 0, "msg" => "用户没有绑定邮箱，请先到个人中填写邮箱资料!", "code" => 402);
                json_return($returnArr);
            }
            $toAddress = $userEmail;
            $title = $info['title'];
            if(!$info['scwj']){
                $returnArr = array("result" => 0, "msg" => "没有找到附件文件，将不进行邮件推送!", "code" => 404);
                json_return($returnArr);
            }
            $http = 'http';
            if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'){
                $http = 'https';
            }
            $domain = $http . '://' . I('server.HTTP_HOST');

            $file = $domain . $info['scwj'];
            $content = $info['title'].'的下载地址是：'.$file;
            $flag = send_email_asyn($toAddress, $title, $content);
            if ($flag) {
                $returnArr = array("result" => 1, "msg" => "邮件已经发送到[".$toAddress."]，如果长时间未能收到，请重试!", "code" => 200);
            } else {
                $returnArr = array("result" => 0, "msg" => "发送邮件失败!", "code" => 404);
            }

        }
        else {
            $returnArr = array("result" => 0, "msg" => "系统繁忙，请稍后再试", "code" => 400);
        }
        json_return($returnArr);
    }

    //递归函数
    public function diff($id = 0, &$array = array())
    {
        $info = M("ArticleCategory")->where("id=$id")->find();
        if ($info) {
            $array[] = $info;
            $this->diff($info["parent_id"], $array);
        }
        return $array;
    }

    //图片上传
    public function imgUpload()
    {
        $channel = $_GET["channel"];  //操作参数
        $type = $_GET["type"];
        $channel_id = M("SystemChannel")->where("call_index='$channel'")->getField("id");
        $systemChannelTableConfModel = D("SystemChannelTableConfig");
        if (!empty($channel_id) && !empty($type)) {
            $channelTableConfInfo = $systemChannelTableConfModel->checkChannel($channel, $type);
            if ($channelTableConfInfo) {
                // 实例化上传类
                $upload = new \Think\Upload();
                // 设置附件上传大小 (-1) 是不限值大小
                $upload->maxSize = 1024 * 1024;
                $upload->saveName = mt_rand(1, 99999) . substr(md5(mt_rand(1, 9999) . time()), 1, 13);
                // 设置附件上传类型
                $upload->allowExts = array(
                    'jpg', 'gif', 'png', 'jpeg'
                );
                // 设置附件上传父目录
                $upload->rootPath = "./Public/upload/";
                //设置附件上传子路径
                $upload->savePath = "article/" . date("Y", time()) . "/" . date("m-d", time()) . "/";
                $upload->autoSub = false;
                $upload->saveExt = "";
                $uploadInfo = $upload->upload();
                // 保存表单数据 包括附件数据
                if ($uploadInfo) {
                    $returnArr = array("result" => 1, "msg" => "上传成功", "code" => 200, "data" => $uploadInfo["file"]["urlpath"]);
                } else {
                    $returnArr = array("result" => 0, "msg" => "上传失败", "code" => 402);
                }

//                    //----- 创建缩略图 -----//
//                foreach ($uploadInfo as $v) {
//                    //缩略图 文件保存地址
//                    $timage = "./" . $v['savepath'] . $v['savename'];
//                    //上传数据库
//                    $arr['image'] = "./" . $v['savepath'] . $v['savename'];//保存图片路径
//                    $arr['create_time'] = NOW_TIME;//创建时间
//
//                    if ($_POST['thum'] == 1) {
//                        // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
//                        $spath = "./Uploads/" . $v['savepath'] . "s_" . $v['savename']; //缩略图名称 地址
//                        $this->thumbs($timage, $spath, $_POST['hejpg'], $_POST['wijpg']);
//                        $arr['simage'] = $v['savepath'] . "s_" . $v['savename'];//保存缩略图片路径
//                    }
//                }
            } else {
                $returnArr = array("result" => 0, "msg" => "频道不存在或参数错误，请联系管理员", "code" => 402);
            }
        } else {
            $returnArr = array("result" => 0, "msg" => "频道参数错误", "code" => 402);
        }
        json_return($returnArr);
    }

}
