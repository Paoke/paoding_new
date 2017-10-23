<?php

namespace Admin\Controller;

use Admin\Model;
use Common\Util\File;
use Think\AjaxPage;
use Think\Log;
use Think\Page;

class TemplateController extends BaseController
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

    //手机模板分类
    public function mobileTemplateSpec()
    {

        $action = $_GET["action"];
        $getId = $_GET["id"];
        $postId = $_POST["id"];
        $getData = I("get.");
        $postData = I("post.");
        switch ($action) {
            case "page_list":
                $TMPL = D('Site/TemplateCat');
                $list = $TMPL->where('cat_type=1')->select();
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $count = $TMPL->count();          //$count    总共有多少条数据
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                $this->assign('count', $count);
                $this->assign('page', $page);
                $this->assign('page_num', $page_num);
                $this->assign('page_now', $page_now);
                $this->assign('list', $list);
                $this->display("mobile_spec_list");
                break;
            case "page_add":
                $this->display('mobile_spec_info');
                break;
            case "page_edit":
                $info = D('Site/TemplateCat')->where("cat_id=$getId")->find();
                $this->assign('info', $info);
                $this->display('mobile_spec_info');
                break;
            case "add":
                $state = D('Site/TemplateCat')->data($postData)->add();
                if ($state) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "新增模板" . $postData["title"] . "成功",3);
                    $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "新增模板" . $postData["title"] . "失败，没有指定编辑信息",3);
                    $returnArr = array("result" => 0, "msg" => "保存失败，该数据不存在", "code" => 402, "data" => null);
                }
                break;
            case "edit":
                if (!empty($_GET['id'])) {
                    foreach ($postData as $key => $val) {
                        if ($key == '__hash__') {
                            unset($postData[$key]);
                        }
                    }
                    $state = D('Site/TemplateCat')->where('cat_id=' . $postData['cat_id'])->save($postData);

                    if ($state) {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(6, "编辑模板" . $postData["title"] . "成功",4);
                        $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                    } else {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(6, "编辑模板" . $postData["title"] . "失败",4);
                        $returnArr = array("result" => 0, "msg" => "保存失败", "code" => 402, "data" => null);
                    }
                } else {
                    $this->logRecord(6, "编辑模板" . $postData["title"] . "失败，该数据不存在",4);
                    $returnArr = array("result" => 0, "msg" => "保存失败，该数据不存在", "code" => 402, "data" => null);
                }
                break;
            case "del":
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }

    public function mobileTemplate()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $postId = $_POST["id"];
        $getData = I("get.");
        $postData = I("post.");
        switch ($action) {
            case "page_list":
                $type = 1;
                $catId = $_GET['catid'];
                if (isset($catId)) {
                    $condition['tmpl_type'] = $type;
                    if ($catId > 0) {
                        $condition['cat_id'] = $catId;
                    }
                    $list = D('Site/Template')->where($condition)->select();
                    $this->assign('catid', $catId);

                } else {
                    //1. 加载模板列表
                    $list = D('Site/Template')->where("tmpl_type=$type")->select();
                }

                $cat = D('Site/TemplateCat')->where("cat_type=$type")->select();

                $this->assign('cat', $cat);
                $this->assign('t', $type);
                $this->assign('list', $list);
                $this->display('template_list');
                break;
            case "page_add":
                $t = $_GET['t'] ? 1 : $_GET['t'];
                $cat = D('Site/TemplateCat')->where('cat_type=' . $t)->select();
                $this->assign('cat', $cat);

                $types = D('Module')->field('module_type, type_name')->group('module_type, type_name')->select();
                $this->assign('mt', $types);

                if (!empty($_GET['id'])) {
                    $id = $_GET['id'];
                    $info = D('Site/Template')->where('id=' . $id)->find();
                    $this->assign('info', $info);

                }
                $this->assign('channel_prefix', C('DEFAULT_CHANNEL_PREFIX'));
                $this->initEditor();
                $this->display("template_info");
                break;
            case "page_edit":
                $t = $_GET['t'] ? 1 : $_GET['t'];
                $cat = D('Site/TemplateCat')->where('cat_type=' . $t)->select();
                $this->assign('cat', $cat);
                if (!empty($_GET['id'])) {
                    $id = $_GET['id'];
                    $info = D('Site/Template')->where('id=' . $id)->find();
                    $this->assign('info', $info);

                    $channelJson = $info['channel'];
                    $channel = json_decode($channelJson, true);
                    $this->assign('channel', $channel);
                }
                $this->initEditor();
                $this->display("template_info");
                break;
            case "add":
                $BASE_PATH = $_SERVER['DOCUMENT_ROOT'];

                $type = $_POST['tmpl_type'];
                $zip = $BASE_PATH . $_POST['file_path'];
                $defaultTemplatePath = C('TEMPLATE_PATH');
                $module = $type == 0 ? 'pc' : 'mobile';
                $outPath = $BASE_PATH . $defaultTemplatePath . "/" . $module;
                $file = new File();
                $success = $file->unzip($zip, $outPath);
                if (!$success) {
                    $returnArr = array("result" => 0, "msg" => "新增模板失败: 解压zip包出错!", "code" => 402, "data" => null);
                    json_return($returnArr);
                }

                $tmpl_path = $defaultTemplatePath . "/" . $module . DIRECTORY_SEPARATOR . $_POST['tmpl_dir'];
                $tmpl['file_path'] = $tmpl_path;
                $tmpl['tmpl_dir'] = $_POST['tmpl_dir'];
                $tmpl['title'] = $_POST['title'];
                $tmpl['description'] = $_POST['description'];
                $tmpl['remarks'] = $_POST['remarks'];
                $tmpl['image'] = $_POST['image'];
                $tmpl['cat_id'] = $_POST['cat_id'];
                $tmpl['cat_name'] = $_POST['cat_name'];
                $tmpl['real_price'] = $_POST['real_price'];
                $tmpl['trail_price'] = $_POST['trail_price'];
                $tmpl['content'] = $_POST['content'];
                $tmpl['orders'] = $_POST['orders'];
                $tmpl['tmpl_type'] = $type;
                $tmpl['is_sys'] = 1;
                $tmpl['channel'] = $_POST['channel'];

                $tmpl['create_time'] = date("Y-m-d H:i:s", time());
                $tmpl['create_user_id'] = session('admin_id');
                $tmpl['update_time'] = date("Y-m-d H:i:s", time());
                $tmpl['update_user_id'] = session('admin_id');

                $ret = D('Site/Template')->data($tmpl)->add();
                if ($ret) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "新增模板" . $tmpl["title"] . "成功",3);
                    $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "新增模板" . $tmpl["title"] . "失败，数据库录入失败",3);
                    $returnArr = array("result" => 0, "msg" => "保存失败", "code" => 402, "data" => null);
                }
                break;
            case "check":
                $condition = array();
                if ($_POST["param"]) {
                    $templateDir = trim($_POST["param"]);
                    $condition['tmpl_dir'] = $templateDir;
                    $count = D('Site/Template')->where($condition)->count();
                    if ($count > 0) {
                        $return = '模板名称已存在，请重新输入!';
                    } else {
                        $return = 'y';
                    }
                } else {
                    $return = '参数为空!';
                }

                exit($return);
                break;
            case "edit":
                break;
            case "del":
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }


    public function pcTemplate()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $postId = $_POST["id"];
        $getData = I("get.");
        $postData = I("post.");
        switch ($action) {
            case "page_list":
                $type = 0;
                $catId = $_GET['catid'];
                if (isset($catId)) {
                    $condition['tmpl_type'] = $type;
                    if ($catId > 0) {
                        $condition['cat_id'] = $catId;
                    }
                    $list = D('Site/Template')->where($condition)->select();
                    $this->assign('catid', $catId);

                } else {
                    //1. 加载模板列表
                    $list = D('Site/Template')->where("tmpl_type=$type")->select();
                }

                $cat = D('Site/TemplateCat')->where("cat_type=$type")->select();

                $this->assign('cat', $cat);
                $this->assign('t', $type);
                $this->assign('list', $list);
                $this->display('template_list');
                break;
            case "page_add":
                $t = $_GET['t'] ? 1 : $_GET['t'];
                $cat = D('Site/TemplateCat')->where('cat_type=' . $t)->select();
                $this->assign('cat', $cat);
                if (!empty($_GET['id'])) {
                    $id = $_GET['id'];
                    $info = D('Site/Template')->where('id=' . $id)->find();
                    $this->assign('info', $info);

                    $this->assign('flag', 1);
                } else {
                    $this->assign('flag', 0);
                }

                $this->display("template_info");
                break;
            case "page_edit":
                $t = $_GET['t'] ? 1 : $_GET['t'];
                $cat = D('Site/TemplateCat')->where('cat_type=' . $t)->select();
                $this->assign('cat', $cat);
                if (!empty($_GET['id'])) {
                    $id = $_GET['id'];
                    $info = D('Site/Template')->where('id=' . $id)->find();
                    $this->assign('info', $info);

                    $this->assign('flag', 1);
                } else {
                    $this->assign('flag', 0);
                }

                $this->display("template_info");
                break;
            case "add":
                $BASE_PATH = $_SERVER['DOCUMENT_ROOT'];

                $type = $_POST['tmpl_type'];
                $zip = $BASE_PATH . $_POST['file_path'];
                $defaultTemplatePath = C('TEMPLATE_PATH');
                $module = $type == 0 ? 'pc' : 'mobile';
                $outPath = $BASE_PATH . $defaultTemplatePath . $module;

                $file = new File();
                $success = $file->unzip($zip, $outPath);
                if (!$success) {
                    $arr = array("status" => 0, "msg" => "新增模板失败: 解压zip包出错!");
                    exit(json_encode($arr));
                }

                $tmpl_path = $defaultTemplatePath . $module . DIRECTORY_SEPARATOR . $_POST['tmpl_dir'];

                $tmpl['file_path'] = $tmpl_path;
                $tmpl['tmpl_dir'] = $_POST['tmpl_dir'];
                $tmpl['title'] = $_POST['title'];
                $tmpl['description'] = $_POST['description'];
                $tmpl['remarks'] = $_POST['remarks'];
                $tmpl['image'] = $_POST['image'];
                $tmpl['cat_id'] = $_POST['cat_id'];
                $tmpl['cat_name'] = $_POST['cat_name'];
                $tmpl['real_price'] = $_POST['real_price'];
                $tmpl['trail_price'] = $_POST['trail_price'];
                $tmpl['content'] = $_POST['content'];
                $tmpl['orders'] = $_POST['orders'];
                $tmpl['tmpl_type'] = $type;
                $tmpl['is_sys'] = 1;

                $tmpl['create_time'] = date("Y-m-d H:i:s", time());
                $tmpl['create_user_id'] = session('admin_id');
                $tmpl['update_time'] = date("Y-m-d H:i:s", time());
                $tmpl['update_user_id'] = session('admin_id');

                $ret = D('Site/Template')->data($tmpl)->add();
                if ($ret) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "新增模板" . $tmpl["title"] . "成功",3);
                    $arr = array("status" => 1, "msg" => "保存成功!");
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "新增模板失败，数据库新增失败",3);
                    $arr = array("status" => 0, "msg" => "保存失败!");
                }
                break;
            case "edit":
                break;
            case "del":
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }

    public function getTemplateByCat()
    {
        $catId = trim($_GET['catid']);

        if ( isset($catId)) {
            if ($catId > 0) {
                $condition['cat_id'] = $catId;
            }
            $condition['1'] = '1';
            $data = D('Site/Template')->where($condition)->select();
            if (count($data) > 0) {
                exit(json_encode($data));
            }

        }

        exit(json_encode(0));


    }

    /**
     * 魔板选择
     */
    public function pcChangeTemplate()
    {
        $t = 'pc';
        $this->changeTemplate($t);
    }

    public function mobileChangeTemplate()
    {
        $t = 'mobile';
        $this->changeTemplate($t);
    }

    public function changeTemplate($t)
    {
        //  $t = I('t','pc'); // pc or  mobile
        $m = ($t == 'pc') ? 'Home' : 'Mobile';
        $arr = scandir("./Template/$t/");
        $template_list = "";
        foreach ($arr as $key => $val) {
            if ($val == '.' || $val == '..')
                continue;
            $template_list .= $val . ',';
        }
        $template_list = substr($template_list, 0, strlen($template_list) - 1);

        // 修改文件配置  
        if (!is_writeable("./Application/$m/Conf/html.php"))
            return "文件/Application/$m/Conf/html.php不可写,不能启用魔板,请修改权限!!!";

        $config_html = "<?php
		return array(
			'VIEW_PATH'       =>'./Template/$t/', // 改变某个模块的模板文件目录
			'DEFAULT_THEME'    =>'{$_GET['key']}', // 模板名称
			'TMPL_DETECT_THEME' => true, // 自动侦测模板主题
			'THEME_LIST' => '{$template_list}', // 支持的模板主题项
			'TMPL_PARSE_STRING'  =>array(
		//                '__PUBLIC__' => '/Common', // 更改默认的/Public 替换规则
		//			'__STATIC__'     => '/Template/$t/{$_GET['key']}/Static', // 增加新的image  css js  访问路径  后面给 php 改了
			   ),
			   //'DATA_CACHE_TIME'=>60, // 查询缓存时间
			);
		?>";
        file_put_contents("./Application/$m/Conf/html.php", $config_html);

        //保存到数据库
        $site_name = session('site_name');
        $template_name = $_GET['key'];
        if ($t == 'pc') {
            $sql = "UPDATE gemmap_site SET shop_template= '$template_name' WHERE site_name='$site_name' ";
        } else {
            $sql = "UPDATE gemmap_site SET mobile_template= '$template_name' WHERE site_name='$site_name' ";
        }
        $Model = new \Think\Model();
        $ccc = $Model->execute($sql);
        var_dump('<script>window.alert($ccc)</script>');

        $this->success("操作成功!!!", U('Admin/Template/templateList', array('t' => $t)));
    }

    /**
     * 初始化编辑器链接
     * @param $post_id post_id
     */
    private function initEditor()
    {
        $this->assign("URL_upload", U('Admin/Ueditor/imageUp', array('savepath' => 'template')));
        $this->assign("URL_fileUp", U('Admin/Ueditor/fileUp', array('savepath' => 'template')));
        $this->assign("URL_scrawlUp", U('Admin/Ueditor/scrawlUp', array('savepath' => 'template')));
        $this->assign("URL_getRemoteImage", U('Admin/Ueditor/getRemoteImage', array('savepath' => 'template')));
        $this->assign("URL_imageManager", U('Admin/Ueditor/imageManager', array('savepath' => 'template')));
        $this->assign("URL_imageUp", U('Admin/Ueditor/imageUp', array('savepath' => 'template')));
        $this->assign("URL_getMovie", U('Admin/Ueditor/getMovie', array('savepath' => 'template')));
        $this->assign("URL_Home", "");
    }

    public function channelTemplate()
    {

        $action = $_GET["action"];

        switch ($action) {
            case "page_list":
                $module = D('Module')->field('module_type, type_name')->where("module_type<>'System'")->group('module_type, type_name')->select();
                $this->assign('module', $module);

                $condition = array();
                if ($_GET['module']) {
                    $condition['module_type'] = $_GET['module'];
                }
                $theme = D('ChannelTheme')->where($condition)->select();

                $this->assign('list', $theme);
                $this->display('channel_template_list');
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(6, "浏览了频道主题模板列表页面",2);
                break;
            case "page_add":

                $module = D('Module')->field('module_type, type_name')->where("module_type<>'System'")->group('module_type, type_name')->select();
                $this->assign('mt', $module);

                $this->initEditor();
                $this->display('channel_template_info');
                break;
            case "page_edit":
                $module = D('Module')->field('module_type, type_name')->where("module_type<>'System'")->group('module_type, type_name')->select();
                $this->assign('mt', $module);

                if (!empty($_GET['id'])) {
                    $id = $_GET['id'];
                    $info = D('ChannelTheme')->where('id=' . $id)->find();
                    $this->assign('info', $info);

                }
                $this->initEditor();
                $this->display('channel_template_info');
                break;
            case "add":
                $BASE_PATH = $_SERVER['DOCUMENT_ROOT'];

                $zip = $BASE_PATH . $_POST['file_path'];
                $channelTemplatePath = C('CHANNEL_THEME_TEMPLATE_PATH');
                $module = $_POST['module_type'];
                $outPath = $BASE_PATH . $channelTemplatePath . $module;

                $file = new File();
                $success = $file->unzip($zip, $outPath);
                if (!$success) {
                    $returnArr = array("result" => 0, "msg" => "新增频道主题模板失败: 解压zip包出错!", "code" => 401, "data" => null);
                    json_return($returnArr);
                }
                $tmpl_path = $channelTemplatePath . $module . DIRECTORY_SEPARATOR . $_POST['theme_name'];
                $tmpl['file_path'] = $tmpl_path;
                $tmpl['theme_name'] = $_POST['theme_name'];
                $tmpl['theme_title'] = $_POST['theme_title'];
                $tmpl['description'] = $_POST['description'];
                $tmpl['remarks'] = $_POST['remarks'];
                $tmpl['image'] = $_POST['image'];
                $tmpl['module_type'] = $_POST['module_type'];
                $tmpl['content'] = $_POST['content'];
                $tmpl['is_active'] = $_POST['is_active'];

                $tmpl['create_time'] = date("Y-m-d H:i:s", time());
                $tmpl['create_user_id'] = session('admin_id');
                $tmpl['update_time'] = date("Y-m-d H:i:s", time());
                $tmpl['update_user_id'] = session('admin_id');

                $ret = D('ChannelTheme')->data($tmpl)->add();
                if ($ret) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "新增模板" . $tmpl["title"] . "成功",3);
                    $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "新增模板" . $tmpl["title"] . "失败，数据库录入失败",3);
                    $returnArr = array("result" => 0, "msg" => "保存失败", "code" => 402, "data" => null);
                }
                break;
            case "edit":
                break;
            case "del":
                break;

            case "json_list":

                $condition = array();
                if ($_GET['module']) {
                    $condition['module_type'] = $_GET['module'];
                }
                $theme = D('ChannelTheme')->where($condition)->select();
                $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $theme);
                exit(json_encode($returnArr));
                break;

            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 404, "data" => null);
        }
        json_return($returnArr);
    }

}
