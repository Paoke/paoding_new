<?php

namespace Admin\Controller;

use Think\Model;

header("Content-type: text/html; charset=utf-8");

class SystemController extends BaseController
{
    /**
     * 析构函数，判断权限等
     */
    public function __construct()
    {
        parent::__construct();
        $act = ACTION_NAME; //哪个方法
        $action = $_GET["action"];//action/page_list
        $check = array('page_edit');
        $checkAction = array('setting');
        if(in_array($act,$checkAction) && in_array($action,$check)) {
            $res = parent::checkRole();
            if ($res["result"] != 1) {
                $this->error("您的账号没有操作权限");
            }
        }
    }


    public function setting()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $postId = $_POST["id"];
        $getData = I("get.");
        $postData = I("post.");
        switch ($action) {
            //网站设置显示页面
            case "page_info":
                $list = M('config')->select();
                foreach ($list as $key => $value) {//获取配置
                    $vo[$value['name']] = $value['value'];
                }
                $this->vo = $vo;
                $this->display("setting_info");
                break;
            case "page_edit":
                $list = M('config')->select();
                foreach ($list as $key => $value) {
                    # code...
                    $vo[$value['name']] = $value['value'];
                }
                $this->vo = $vo;
                $this->display("setting_basic_info");
                break;

            //网站设置 修改
            case "edit":
                $model = M('Config');
                $data = I('post.');
                unset($data['__hash__']);

                foreach ($data as $key => $value) {
                    $model->where(array('name' => $key))->data(array('value' => $value))->save();
                }

                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(6, "修改网站设置" . $data["name"] . "成功",4);
                $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);

                break;
            //添加
            case "add":
                $data=I("post.");
                $r=M("Config")->add($data);
                if ($r) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                    $this->logRecord(6, "新增" . $data["name"] . "成功",3);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $returnArr = array("result" => 0, "msg" => "保存失败，请重试", "code" => 402, "data" => null);
                    $this->logRecord(5, "新增" . $data["name"] . "失败，数据库录入失败",3);
                }
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);

        }
        json_return($returnArr);
    }

    /*
     * 注册条款
     */
    public  function  terms(){
        $action = $_GET["action"];
       switch($action){
           case "page_list";
               $list = M('config')->select();
               foreach ($list as $key => $value) {
                   $vo[$value['name']] = $value['value'];
               }
               $this->vo = $vo;
               $this->display("register_info");
               break;

           case "edit":
               $content = $_POST['content'];
               M('Config')->where("name='introduction_register_law'")->setField('value', $content);

               //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
               $this->logRecord(6, "修改注册条款成功",4);
               $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
               break;
           default:
               //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
               $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
               $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
       }

        json_return($returnArr);
    }

    /*
     * 关于我们
     */
    public  function about()
    {
        $action = $_GET["action"];
        switch ($action) {
            case "page_list";
                $list = M('config')->select();
                foreach ($list as $key => $value) {
                    $vo[$value['name']] = $value['value'];
                }
              
                $this->vo = $vo;
                $this->display("about");
                break;
            case "edit":
                    $content=$_POST['content'];
                    M("Config")->where("name='introduction_aboutus'")->setField("value",$content);

                    $this->logRecord(6,"修改​关于我们的介绍内容成功",4);
                    $returnArr=array("result"=>"1","msg"=>"修改成功","code"=>200,"data"=>null);
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }

    /*
     * 服务协议
     */
    public  function service(){
        $action=$_GET['action'];
        switch($action){
            case "page_list":
                $list=M("Config")->select();
                foreach ($list as  $key => $value){
                    $vo[$value['name']]=$value['value'];
                }
               
                $this->assign("vo",$vo);
                $this->display("service_info");
                break;
            case "edit":
                $content=$_POST['content'];
                M("Config")->where("name='introduction_service_law'")->setField("value",$content);

                $this->logRecord(6,"修改服务协议成功",4);
                $returnArr=array("result"=>1,"msg"=>"修改成功","code"=>200,"data"=>null);
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }


    /**
     * 全局模块操作(global_module)
     */
    public function gModule()
    {

        $action = trim($_GET['action']);

        switch ($action) {
            case 'list':
                $type = trim($_GET['type']);
                $condition = array();
                if ($type) {
                    $condition['module_type'] = $type;
                }
                $data = D('Module')->where($condition)->select();
                $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $data);
                break;

            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
                break;
        }

        exit(json_encode($returnArr));

    }

    /*
     * 新增修改配置
     */
    public function handle()
    {
        $param = I('post.');
        $inc_type = $param['inc_type'];
        //unset($param['__hash__']);
        unset($param['inc_type']);
        tpCache($inc_type, $param);
        $this->success("操作成功", U('System/index', array('inc_type' => $inc_type)));
    }

    public function menu()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $systemModuleModel = M("SystemModule");
        switch ($action) {
            case "page_list":
                //查找组织数据
                $info = $systemModuleModel->field("mod_id,title,level,orderby,call_index,visible,is_sys")->where("level=1")->order("orderby ASC,mod_id ASC")->select();
                //判断是否有id传进来
                if ($getId) {
                    $info = $systemModuleModel->field("mod_id,title,level,orderby,call_index,visible,is_sys")->where("parent_id=$getId")->order("orderby ASC,mod_id ASC")->select();
                    //判断是否有子节点，有则添加infoSon键值
                    foreach ($info as $item => $value) {
                        $infoSon = $systemModuleModel->where("parent_id={$value['mod_id']}")->count();
                        $info[$item]["infoSon"] = $infoSon;
                    }
                    //判断是否该节点是否点击，获取点击的id下面的所有子id
                    if ($_GET["getTreeSon"] == "1") {
                        $systemModuleModel = M("SystemModule");
                        $info = $systemModuleModel->field("mod_id,parent_id,level,orderby,call_index,visible,is_sys")->select();
                        //获取所有子id的函数
                        $info = $this->getTreeSon($info, $getId, 1);
                    }
                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
                    json_return($returnArr);
                }
                //判断该分级下面是否还有分级，有分级则给 infoSon 作为标记。
                foreach ($info as $item => $value) {
                    $infoSon = $systemModuleModel->where("parent_id={$value['mod_id']}")->count();
                    $info[$item]["infoSon"] = $infoSon;
                }

                $this->assign("infoSon", $infoSon);
                $this->assign("info", $info);
                $this->display("menu_list");
                break;
            case "page_add":
                $info = $systemModuleModel->field("mod_id,title,(level*2) as level,concat(parent_id_path,mod_id,'_') as a")->order("a ASC,orderby ASC")->select();
                $this->assign("menuTree", $info);
                $this->display("menu_info");
                break;
            case "page_edit":
                //有编辑id值则显示页面。
                if ($getId) {
                    $info = $systemModuleModel->field("mod_id,title,action,(level*2) as level,concat(parent_id_path,mod_id,'_') as a")->order("a ASC,orderby ASC")->select();

                    $this->assign("menuTree", $info);
                    $info = $systemModuleModel->where("mod_id=$getId")->find();
                    $this->assign("info", $info);
                    $this->display("menu_info");
                } else {
                    $returnArr = array("result" => 0, "msg" => "保存失败，没有指定编辑信息", "code" => 402, "data" => null);
                }
                break;
            case "add":
                $postData = I("post.");
                //设置需要填写的input。
                $returnArr = array("result" => 0, "msg" => "保存失败，除了上级菜单，图标，调用别名其他为必填项", "code" => 402, "data" => null);
                if (empty($postData["title"])) json_return($returnArr);
                if (empty($postData["urlMode"])) json_return($returnArr);
                if (empty($postData["orderby"])) json_return($returnArr);
                $info = $this->addMenu($postData);
                if ($info) {
                    $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                } else {
                    $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
                }
                break;
            case "edit":
                $postData = I("post.");
                //设置需要填写的input。
                $returnArr = array("result" => 0, "msg" => "保存失败，菜单名称为必填项", "code" => 402, "data" => null);
                if (empty($postData["title"])) json_return($returnArr);
                $returnArr = array("result" => 0, "msg" => "保存失败，URL模式为必填项", "code" => 402, "data" => null);
                if (empty($postData["urlMode"])) json_return($returnArr);
//                var_dump($postData);exit;
                if ($postData["id"] == $postData["parent_id"]) {
                    $returnArr = array("result" => 0, "msg" => "保存失败，不能将自己作为上级", "code" => 402, "data" => null);
                } else {
                    $info = $this->editMenu($postData);
                    if ($info) {
                        $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                    } else {
                        $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
                    }
                }
                break;
            case "del":
                //查找删除的id是否有子级
                $res = $systemModuleModel->where("parent_id=$getId")->count();
                if ($res) {
                    $returnArr = array("result" => 0, "msg" => "要删除的菜单中含有子项目,请先移动或删除子项目", "code" => 402, "data" => null);
                } else {
                    $result = $systemModuleModel->where("mod_id=$getId")->delete();
                    if ($result) {
                        $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);
                    } else {
                        $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
                    }
                }
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }

    /**
     * @param array $data 要添加的机构的数据
     * @return bool|mixed 返回是否添加成功
     * 添加机构函数
     */
    public function addMenu($data)
    {
        $systemModuleModel = M("SystemModule");
        if ($data["urlMode"] == 1) {
            $urlModeArr = explode("/", $data["url"]);
            $data["ctl"] = $urlModeArr[0];
            $data["act"] = mb_substr($data["url"], strlen($data["ctl"]) + 1);
        } elseif ($data["urlMode"] == 2) {
            $data["url"] = $data["ctl"] . "/" . $data["act"];
        }
        $data["action"] = array("show" => "0", "add" => "0", "edit" => "0", "del" => "0");
        foreach ($data["action"] as $item => $value) {
            foreach ($data["roleAction"] as $item2 => $value2) {
                if ($item == $item2) {
                    $data["action"][$item] = intval($value2);
                }
            }
        }
        $data["action"] = json_encode($data["action"]);
        //判断添加的组织机构是否有上级
        $parent_id = isset($data["parent_id"]) ? $data["parent_id"] : 0;
        //没有上级，则默认为顶级，并赋值创建时间与创建人。
        if (empty($parent_id)) {
            $data["level"] = 1;
            $data["parent_id_path"] = "_0_";
        } else {
            //有上级，则附属到上级去。
            $info = $systemModuleModel->where("mod_id=$parent_id")->find();
            $data["level"] = count(explode("_", $info["parent_id_path"])) - 1;
            $data["parent_id_path"] = $info["parent_id_path"] . $info["mod_id"] . "_";
        }
        $info = $systemModuleModel->add($data);
        return $info;
    }

    /**
     * @param array $data 要编辑的机构的数据
     * @return bool|mixed 返回是否编辑成功
     * 编辑机构函数
     */
    public function editMenu($data = array())
    {
        $systemModuleModel = M("SystemModule");
        if ($data["urlMode"] == 1) {
            $urlModeArr = explode("/", $data["url"]);
            $data["ctl"] = $urlModeArr[0];
            $data["act"] = mb_substr($data["url"], strlen($data["ctl"]) + 1);
        } elseif ($data["urlMode"] == 2) {
            $data["url"] = $data["ctl"] . "/" . $data["act"];
        }
        $data["action"] = array("show" => "0", "add" => "0", "edit" => "0", "del" => "0");
        foreach ($data["action"] as $item => $value) {
            foreach ($data["roleAction"] as $item2 => $value2) {
                if ($item == $item2) {
                    $data["action"][$item] = intval($value2);
                }
            }
        }
        $data["action"] = json_encode($data["action"]);
        //判断添加的组织机构是否有上级
        $parent_id = isset($data["parent_id"]) ? $data["parent_id"] : 0;
        //没有上级，则默认为顶级，并赋值创建时间与创建人。
        if (empty($parent_id)) {
            $data["level"] = 1;
            $data["parent_id_path"] = "_0_";
        } else {
            $info = $systemModuleModel->where("mod_id=$parent_id")->find();
            $data["level"] = count(explode("_", $info["parent_id_path"])) - 1;
            $data["parent_id_path"] = $info["parent_id_path"] . $info["mod_id"] . "_";
        }

        $info = $systemModuleModel->where("mod_id={$data['id']}")->save($data);
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
                $this->getTreeSon($data, $value['mod_id'], $level);
            }
        }
        return $arr;
    }

    /**
     * 清空系统缓存
     */
    public function cleanCache()
    {

        if (IS_POST) {
            in_array('cache', $_POST['clear']) && delFile('./Application/Runtime/Cache');// 模板缓存
            in_array('data', $_POST['clear']) && delFile('./Application/Runtime/Data');// 项目数据
            in_array('logs', $_POST['clear']) && delFile('./Application/Runtime/Logs');// logs日志
            in_array('temp', $_POST['clear']) && delFile('./Application/Runtime/Temp');// 临时数据
            //in_array('goods_thumb',$_POST['clear'])  && delFile('./Public/upload/goods/thumb'); // 删除缩略图

            // 删除静态文件
            $html_arr = glob("./Application/Runtime/Html/*.html");
            foreach ($html_arr as $key => $val) {

                in_array('index', $_POST['clear']) && strstr($val, 'Home_Index_index.html') && unlink($val); // 首页
                in_array('goodsList', $_POST['clear']) && strstr($val, 'Home_Goods_goodsList') && unlink($val); // 列表页
                in_array('channel', $_POST['clear']) && strstr($val, 'Home_Channel_index') && unlink($val);  // 频道页

                in_array('articleList', $_POST['clear']) && strstr($val, 'Index_Article_articleList') && unlink($val);  // 文章列表页
                in_array('detail', $_POST['clear']) && strstr($val, 'Index_Article_detail') && unlink($val);  // 文章详情
                in_array('articleList', $_POST['clear']) && strstr($val, 'Doc_Index_index_') && unlink($val);  // 文章列表页
                in_array('detail', $_POST['clear']) && strstr($val, 'Doc_Index_article_') && unlink($val);  // 文章详情

                // 详情页
                if (in_array('goodsInfo', $_POST['clear'])) {
                    if (strstr($val, 'Home_Goods_goodsInfo') || strstr($val, 'Home_Goods_ajaxComment') || strstr($val, 'Home_Goods_ajax_consult'))
                        unlink($val);
                }
            }
            $this->success("操作完成!!!");
            exit;
        }
        $this->display();
    }

    /**
     * 清空静态商品页面缓存
     */
    public function ClearGoodsHtml()
    {
        $goods_id = I('goods_id');
        if (unlink("./Application/Runtime/Html/Home_Goods_goodsInfo_{$goods_id}.html")) {
            // 删除静态文件
            $html_arr = glob("./Application/Runtime/Html/Home_Goods*.html");
            foreach ($html_arr as $key => $val) {
                strstr($val, "Home_Goods_ajax_consult_{$goods_id}") && unlink($val); // 商品咨询缓存
                strstr($val, "Home_Goods_ajaxComment_{$goods_id}") && unlink($val); // 商品评论缓存
            }
            $json_arr = array('status' => 1, 'msg' => '清除成功', 'result' => '');
        } else {
            $json_arr = array('status' => -1, 'msg' => '未能清除缓存', 'result' => '');
        }
        $json_str = json_encode($json_arr);
        exit($json_str);
    }

    /**
     * 商品静态页面缓存清理
     */
    public function ClearGoodsThumb()
    {
        $goods_id = I('goods_id');
        delFile("./Public/upload/goods/thumb/$goods_id"); // 删除缩略图
        $json_arr = array('status' => 1, 'msg' => '清除成功,请清除对应的静态页面', 'result' => '');
        $json_str = json_encode($json_arr);
        exit($json_str);
    }

    /**
     * 清空 文章静态页面缓存
     */
    public function ClearAritcleHtml()
    {
        $article_id = I('article_id');
        unlink("./Application/Runtime/Html/Index_Article_detail_{$article_id}.html"); // 清除文章静态缓存
        unlink("./Application/Runtime/Html/Doc_Index_article_{$article_id}_api.html"); // 清除文章静态缓存
        unlink("./Application/Runtime/Html/Doc_Index_article_{$article_id}_phper.html"); // 清除文章静态缓存
        unlink("./Application/Runtime/Html/Doc_Index_article_{$article_id}_android.html"); // 清除文章静态缓存
        unlink("./Application/Runtime/Html/Doc_Index_article_{$article_id}_ios.html"); // 清除文章静态缓存
        $json_arr = array('status' => 1, 'msg' => '操作完成', 'result' => '');
        $json_str = json_encode($json_arr);
        exit($json_str);
    }

    /**
     *  管理员登录后 处理相关操作
     */
    public function login_task()
    {

        /*** 随机清空购物车的垃圾数据*/
        $time = time() - 3600; // 删除购物车数据  1小时以前的
        M("Cart")->where("user_id = 0 and  add_time < $time")->delete();
        $today_time = time();

        // 发货后满多少天自动收货确认
        $auto_confirm_date = tpCache('shopping.auto_confirm_date');
        $auto_confirm_date = $auto_confirm_date * (60 * 60 * 24); // 7天的时间戳
        $order_id_arr = M('GoodsOrder')->where("order_status = 1 and shipping_status = 1 and ($today_time - shipping_time) >  $auto_confirm_date")->getField('order_id', true);
        foreach ($order_id_arr as $k => $v) {
            confirm_order($v);
        }

        // 多少天后自动分销记录自动分成
        $switch = tpCache('distribut.switch');
        if ($switch == 1 && file_exists(APP_PATH . 'Common/Logic/DistributLogic.class.php')) {
            $distributLogic = new \Common\Logic\DistributLogic();
            $distributLogic->auto_confirm(); // 自动确认分成
        }
    }

    public function qa()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $problem=M("SystemProblem");
        switch ($action) {
            case "page_list":
                $where['is_deleted']=0;
                $count = M("SystemProblem")->count();// 查询满足要求的总记录数
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                $this->assign("count",$count);
                $this->assign("page_num",$page_num);
                $this->assign("page_now",$page_now);
                $this->assign("page",$page);

                $list=$problem
                    ->join("AS A LEFT JOIN __MANAGE_USERS__ AS B ON A.create_user_id=B.user_id")
                    ->field("A.id,A.problem,A.answer,A.create_time,A.create_user_id,B.user_name")
                    ->where($where)
                    ->page($page_now,$page_num)
                    ->order("create_time DESC")
                    ->select();

                $this->assign("list",$list);
                $this->display("qa_list");
                break;
            case "page_add":
                $this->display("qa_info");
                break;
            case "page_edit":
                $info=$problem->where(array("id"=>$getId))->find();
                $this->assign("info",$info);
                $this->display("qa_info");
                break;
            case "add":
                $post=I("post.");
                $post["create_time"] = date("Y-m-d H:i:s", time());
                $post['create_user_id']=1;
                $info=$problem->add($post);
                if($info){
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加问题" . $post["title"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                }else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加问题失败，数据库录入失败");
                    $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
                }
                break;
            case "edit":
                $post=I("post.");
                $post['create_user_id']=1;
                $info=$problem->save($post);
                if($info){
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "编辑问题" . $post["title"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "编辑成功", "code" => 200, "data" => null);
                }else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "编辑 问题失败，数据库录入失败");
                    $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
                }
                break;
            case "del":
                $logData =$problem->field("problem")->where("id=$getId")->find();
                $row =$problem->where(array('id' => $getId))->delete();
                if ($row) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "删除用户" . $logData["title"] . "成功");
                    $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);
                    //$this->success('成功删除会员');die;
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5, "删除用户" . $logData["title"] . "失败");
                    $returnArr = array("result" => 0, "msg" => "未知错误，请联系管理员", "code" => 402, "data" => null);
                }
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法");
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }

    public function introduction()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $introduction=M("SystemIntroduction");
        $admin=M("ManageUsers");

        switch ($action) {
            case "page_list":
                $where['is_deleted']=0;
                $count = M("SystemIntroduction")->count();// 查询满足要求的总记录数
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                $this->assign("count",$count);
                $this->assign("page_num",$page_num);
                $this->assign("page_now",$page_now);
                $this->assign("page",$page);

                $list=$introduction
                    ->join("AS A LEFT JOIN __MANAGE_USERS__ AS B ON A.create_user_id=B.user_id")
                    ->field("A.id,A.title,A.content,A.create_time,A.create_user_id,B.user_name")
                    ->page($page_now,$page_num)
                    ->where($where)
                    ->order("create_time DESC")
                    ->select();
                $this->assign("list",$list);
                $this->display("introduction_list");
                break;
            case "page_add":
                $this->display("introduction_info");
                break;
            case "page_edit":
                $info = $introduction->where(array('id' => $getId))->find();
                $this->assign('info', $info);
                $this->display("introduction_info");
                break;
            case "add":
                $post=I("post.");
                $post["create_time"] = date("Y-m-d H:i:s", time());
                $post['create_user_id']=1;
                $info=$introduction->add($post);
                if($info){
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6,"新增数据【" . $post["title"]. "】成功");
                    $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                }else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5,"新增数据失败");
                    $returnArr = array("result" => 0, "msg" => "保存失败", "code" => 402, "data" => null);
                }
                break;
            case "edit":
                $post=I("post.");
                $post['create_user_id']=1;
                $info=$introduction->save($post);
                if($info){
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6,"修改数据【" . $post["title"]. "】成功");
                    $returnArr = array("result" => 1, "msg" => "修改成功", "code" => 200, "data" => null);
                }else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5,"修改数据失败");
                    $returnArr = array("result" => 0, "msg" => "修改失败", "code" => 402, "data" => null);
                }
                break;
            case "del":
                $logData =$introduction->field("title")->where("id=$getId")->find();
                $row =$introduction->where(array('id' => $getId))->delete();
                if($row){
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6,"删除数据【" . $logData["title"]. "】成功");
                    $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);
                }else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5,"删除数据失败");
                    $returnArr = array("result" => 0, "msg" => "删除失败", "code" => 402, "data" => null);
                }
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法");
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }


}
