<?php
/**
 * Created by PhpStorm.
 * User: Sing
 * Date: 2016/10/20
 * Time: 14:58
 */

namespace Admin\Controller;


use Think\Log;
use Think\Model;

class SiteController extends BaseController
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

    public function siteList()
    {
        $action = $_GET["action"];
        $getData = I("get.");
        $postData = I("post.");
        $getId = $_GET["id"];
        $postId = $_POST["id"];
        switch ($action) {
            case "page_list":
                $data = D('Site')->where('status=0')->select();
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $count = D('Site')->count();          //$count    总共有多少条数据
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                $this->assign('count', $count);
                $this->assign('page', $page);
                $this->assign('page_num', $page_num);
                $this->assign('page_now', $page_now);
                $this->assign('lists', $data);
                $this->display("siteList_list");
                break;
            case "page_add":
                $cat = D('Site/TemplateCat')->select();
                $this->assign('cat', $cat);
                $this->assign('domain_suffix', C('DEFAULT_DOMAIN_SUFFIX'));
                $this->display("siteList_info");
                break;
            case "page_edit":
                break;
            case "page_show":
                $info = D('Site')->where('id=' . $getId)->find();
                $this->assign('info', $info);
                $condition['tmpl_dir'] = $info['default_mobile_template'];
                $template = D('Site/Template')->where($condition)->find();
                $this->assign('template', $template);
                $this->display('siteList_info');
                break;
            case "add":
                $site_name = $_POST["site_name"];
                $dataSiteNameCheck = C("site_name_check");

                foreach ($dataSiteNameCheck as $value) {
                    if ($value == $site_name) {
                        $returnArr = array("result" => 0, "msg" => "抱歉，此站点名不可用", "code" => 200, "data" => null);
                        break;
                    } else {
                        $returnArr = array("result" => 1, "msg" => "恭喜您，此站点名可用", "code" => 200, "data" => null);
                    }
                }

                break;
            case "edit":
                $site_name = $_POST["site_name"];
                $result = D('site');
                if ($result) {
                    $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "创建成功" . $site_name["site_name"],3);
                } else {
                    $returnArr = array("result" => 0, "msg" => "保存失败，请重试", "code" => 402, "data" => null);
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "创建失败，数据库录入失败",3);
                }

                break;
            case "del":
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法");
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }


    public function siteReview()
    {
        $action = $_GET["action"];
        $getData = I("get.");
        $postData = I("post.");
        $getId = $_GET["id"];
        $postId = $_POST["id"];
        switch ($action) {
            case "page_list":
                $data['status'] = 0;
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $count = D('Site/TemplateSellRecord')->count();          //$count    总共有多少条数据
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                $this->assign('count', $count);
                $this->assign('page', $page);
                $this->assign('page_num', $page_num);
                $this->assign('page_now', $page_now);
                $this->record($data);
                $this->display("siteReview_list");
                break;
            case "page_add":
                $id = trim($_GET['id']);
                //购买记录
                $record = D('Site/TemplateSellRecord')->where('id=' . $id)->find();
                $record['domain'] = $record['site_name'] . C('DEFAULT_DOMAIN_SUFFIX');
                $this->assign('vo', $record);

                //模板
                $tmpl = D('Site/Template')->where('id=' . $record['template_id'])->find();
                $this->assign('template', $tmpl);
                $this->display("siteReview_info");
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
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法");
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }

    public function checkSite()
    {

        $siteName = $_POST['site_name'];
        if ($siteName) {
            $Model = D('Site');
            $count = $Model->where("site_name='$siteName'")->count();

            if ($count > 0) {
                exit(json_encode(1));
            }
        }
        exit(json_encode(0));
    }

    /**
     * 建站处理过程
     **/
    public function process()
    {
        //site记录(global_site)
        $siteName = trim($_POST['site_name']);
        if (empty($siteName)) {
            $returnArr = array("result" => 0, "msg" => "安装失败，站点名称为空!", "code" => 401, "data" => null);
            exit(json_encode($returnArr));
        }
        $prefix = $siteName . '_';
        //1. 初始化站点数据，创建站点对应的表结构
        $sqlFile = 'Install/site_data.sql';
        if (!file_exists($sqlFile)) {
            $returnArr = array("result" => 0, "msg" => "安装失败，缺少站点安装SQL文件!", "code" => 402, "data" => null);
            exit(json_encode($returnArr));
        }
        $sqlfileContent = file_get_contents($sqlFile);
        $sqls = $this->sql_format($sqlfileContent, $prefix);

        $Model = new Model();
        foreach ($sqls as $sql) {
            $Model->execute($sql);
        }

        /*// 2. 生成站点模板
        // 2.1 在/Template/下生成站点相应的文件夹
        $siteTemplatePath = 'Template/' . $siteName . DIRECTORY_SEPARATOR;
        mkdir($siteTemplatePath, 0755, true);

        // 2.2 复制选中的默认模板到站点模板文件夹
        $tmplId = $_POST['template_id'];
        $tmplData = D('Site/Template')->where('id=' . $tmplId)->find();
        $filePath = $tmplData['file_path'];
        $selectedDefaultTmplPath = $filePath;
        $module = 'mobile';
        if ($tmplData['tmpl_type'] == 0) {
            $module = 'pc';
        }
        $modulePath = './' . $siteTemplatePath . $module . DIRECTORY_SEPARATOR;
        $targetTmplPath = $siteTemplatePath . $module . DIRECTORY_SEPARATOR . $tmplData['tmpl_dir'];
        mkdir($targetTmplPath, 0755, true);
        recurse_copy($selectedDefaultTmplPath, $targetTmplPath);

        // 2.3 保存站点模板配置(global_site_template_config)
        $config['site_name'] = $siteName;
        $config['default_template_id'] = $tmplId;
        $config['tmpl_type'] = $tmplData['tmpl_type'];
        $config['tmpl_path'] = $targetTmplPath;
        $config['view_path'] = $modulePath;
        $config['default_theme'] = $tmplData['tmpl_dir'];
        $config['tmpl_parse_string_static'] = DIRECTORY_SEPARATOR . $targetTmplPath . DIRECTORY_SEPARATOR . 'Static';
        D('SiteTemplateConfig')->data($config)->add();*/

        // 2. 生成站点模板位置(手机)
        D('SiteTemplateConfig')->where("site_name='".$siteName."'")->delete();
        $config['site_name'] = $siteName;
        $config['tmpl_type'] = 1;
        $config['tmpl_path'] = "Template/$siteName/mobile";
        $config['view_path'] = "./Template/$siteName/";
        $config['default_theme'] = "mobile";
        $config['tmpl_parse_string_static'] = "/Template/$siteName/mobile/Static";
        D('SiteTemplateConfig')->data($config)->add();
        //PC  = 0

        // 3. 保存站点数据
        D('Site')->where("site_name='".$siteName."'")->delete();
        $data['site_name'] = $siteName;
        $data['default_domain'] = $_POST['domain'];
        $data['company'] = $_POST['company'];
        $data['contact'] = $_POST['user'];
        $data['mobile'] = $_POST['mobile'];
        $data['default_mobile_template'] = "mobile";
        /*if (isset($_POST['template'])) {
            $data['default_mobile_template'] = $_POST['template'];
        } else {
            $data['default_mobile_template'] = $tmplData['tmpl_dir'];
        }*/

        /*if ((trim($_POST['cat_id']))) {
            $data['default_mobile_template_cat_id'] = $tmplData['cat_id'];
        } else {
            $data['default_mobile_template_cat_id'] = $_POST['cat_id'];
        }*/
        D('Site')->data($data)->add();

        /*//4.为站点生成默认频道
        $channelJson = $tmplData['channel'];
        if (!empty($channelJson)) {
            $channelArr = json_decode($channelJson, true);
            $Model = M('SystemTemplateChannel', $prefix);
            foreach ($channelArr as $channel) {
                $ret = $this->genDefaultChannel($channel, $prefix);
                if (!$ret) {
                    Log::write("新建站点[" . $siteName . "], 生成频道[" . $channel['name'] . "]失败!");
                } else {
                    //保存站点模板和频道模块的关系
                    $TC['template_id'] = $tmplData['id'];
                    $TC['template_name'] = $tmplData['tmpl_dir'];
                    $TC['channel_id'] = $ret;
                    $TC['channel_index'] = $channel['index'];
                    $TC['is_sys'] = 1;

                    $count = $Model->where($TC)->count();
                    if ($count == 0) {
                        $ret = $Model->add($TC);
                    }

                }
            }

        }*/

        /*//5. 变更购买记录状态
        $recordId = $_POST['record_id'];
        if ($recordId) {
            D('Site/TemplateSellRecord')->where('id=' . $recordId)->setField('status', 1);
        }*/
        $returnArr = array("result" => 1, "msg" => "安装成功,新站点部署完成!", "code" => 200, "data" => null);
        exit(json_encode($returnArr));
    }

    /**
     * 生成站点默认频道
     * @param $channel 频道数据
     * @param 站点对应的表前缀
     */
    private function genDefaultChannel($channel, $prefix = null)
    {

        if ($prefix) {
            $M = M('SystemChannel', $prefix);
        } else {
            $M = M('SystemChannel');
        }

        //先判断call_index是否存在，如果存在则再添加
        $ret = $M->where("call_index='" . $channel['index'] . "'")->find();
        if ($ret != null && count($ret) > 0) {
            Log::write("生成模板，频道[" . $channel['name'] . "已存在]");
            return false;
        }

        // 1.新增频道
        $data['channel_title'] = $channel['name'];
        $data['call_index'] = $channel['index'];

        $data['is_like'] = 1;
        $data['is_reviewed'] = 1;
        $data['is_collect'] = 1;
        $data['is_comment'] = 1;
        $data['is_album'] = 1;
        $data['is_attach'] = 1;
        $data['is_tag'] = 1;
        $data['is_read_count'] = 1;
        $data['is_award'] = 1;
        $data['is_red_packet'] = 1;
        $data['sort_id'] = 50;
        $data['remark'] = $channel['name'];
        $data['is_sys'] = 1;
        $data['is_active'] = 1;
        $data['base_module'] = $channel['type'];

        $channelId = $M->data($data)->add();

        if (!$channelId) {
            return false;
        }

        // 2.新增菜单
        $ret = $this->genChannelMenu($channel['type'], $channel['name'], $channel['index'], $prefix);
        if ($ret) {
            return $channelId;
        } else {
            return false;
        }

    }

    /**
     * 生成频道菜单
     * @param $moduleType 频道模块类型
     * @param $channelTitle 频道名称
     * @param $channelIndex 频道别名
     * @param $prefix 表前缀
     */
    private function genChannelMenu($moduleType, $channelTitle, $channelIndex, $prefix)
    {


        $modules = D('Module')->where("module_type='$moduleType'")->select();

        //增加菜单
        // 1)二级菜单
        $Module = M('SystemModule', $prefix);
        $m = $Module->where("call_index='" . $moduleType . "'")->find();

        $menu['channel'] = $channelIndex;
        $menu['module'] = 'menu';
        $menu['level'] = 2;
        $menu['title'] = $channelTitle;
        $menu['visible'] = 1;
        $menu['parent_id'] = $m['mod_id'];
        $menu['orderby'] = 50;
        $menu['icon'] = 'fa-flag';
        $menu['is_sys'] = 0;
        $menu['call_index'] = $moduleType . '_' . $channelIndex;
        $secondId = $Module->add($menu);

        if ($secondId) {
            //2)增加三级菜单
            $menus = array();
            $i = 0;
            foreach ($modules as $module) {
                $menus[$i]['channel'] = $channelIndex;
                $menus[$i]['module'] = 'module';
                $menus[$i]['level'] = 3;
                $menus[$i]['action'] = $module['config'];
                $menus[$i]['title'] = $module['module_title'];
                $menus[$i]['visible'] = 1;
                $menus[$i]['parent_id'] = $secondId;
                $menus[$i]['orderby'] = 50;
                $menus[$i]['is_sys'] = 0;
                $moduleIndex = $channelIndex . '_' . $module['module_name'];
                $menus[$i]['call_index'] = $moduleIndex;
                $menus[$i]['url'] = $module['url'] . '/channel/' . $channelIndex . '/index/' . $moduleIndex;

                $i++;
            }
            $success = $Module->addAll($menus);

            return $success;
        } else {
            return false;
        }

    }

    private function record($data)
    {

        $Record = D('Site/TemplateSellRecord');
        $data = $Record->alias('A')->join('`global_template` B ON A.template_id=B.id')
            ->field('A.id, A.order_id, A.site_name, A.cost, A.status, A.template_id, A.buy_time,A.buy_type, A.user, A.mobile, A.company, B.tmpl_dir')
            ->where($data)->order('buy_time')->select();
        $this->assign('lists', $data);

    }

    private function sql_format($sql, $tablepre)
    {

        $defaultDBPrefix = C('DB_PREFIX');
        if ($tablepre != $defaultDBPrefix)
            $sql = str_replace('gemmap_', $tablepre, $sql);

        $sql = preg_replace("/TYPE=(InnoDB|MyISAM|MEMORY)( DEFAULT CHARSET=[^; ]+)?/", "ENGINE=\\1 DEFAULT CHARSET=utf8", $sql);

        $sql = str_replace("\r", "\n", $sql);
        $ret = array();
        $num = 0;
        $queriesarray = explode(";\n", trim($sql));
        unset($sql);
        foreach ($queriesarray as $query) {
            $ret[$num] = '';
            $queries = explode("\n", trim($query));
            $queries = array_filter($queries);
            foreach ($queries as $query) {
                $str1 = substr($query, 0, 1);
                if ($str1 != '#' && $str1 != '-')
                    $ret[$num] .= $query;
            }
            $num++;
        }
        return $ret;
    }

    /**
     * 站点可选模板列表(站点只能选默认模板同一类的模板)
     */
    public function siteMobileTemplateList()
    {
        $siteName = session('site_name');
        if (empty($siteName)) {
            $siteName = get_site_name();
        }

        //获取分类ID
        $site = D('Site')->where("site_name='" . $siteName . "'")->find();
        if ($_GET["cat_id"] == 0) {
            $condition['tmpl_type'] = 1;
            $data = D('Site/Template')->where($condition)->select();
        } else if ($_GET["cat_id"]) {
            $condition['tmpl_type'] = 1;
            $condition['cat_id'] = $_GET["cat_id"];
            $data = D('Site/Template')->where($condition)->select();
        }
        $tmplCatInfo = D("Site/TemplateCat")->field("cat_id,cat_name")->select();
        $this->assign('t', 1);
        $this->assign('site', $siteName);
        $this->assign('cat_id', $_GET["cat_id"]);
        $this->assign('tmplCatInfo', $tmplCatInfo);
        $this->assign('default', $site['default_mobile_template']);
        $this->assign('list', $data);
        $this->display('site_tmpl_list');

    }

    /**
     * 站点可选模板列表(站点只能选默认模板同一类的模板)
     */
    public function sitePcTemplateList()
    {
        $siteName = session('site_name');
        if (empty($siteName)) {
            $siteName = get_site_name();
        }
        //获取分类ID
        $site = D('Site')->where("site_name='" . $siteName . "'")->find();
//        $catId = $site['default_mobile_template_cat_id'];
        $condition['tmpl_type'] = 0;
//        $condition['cat_id'] = $catId;
        $data = D('Site/Template')->where($condition)->select();
        $this->assign('t', 0);
        $this->assign('site', $siteName);
        $this->assign('default', $site['default_mobile_template']);
//        $this->assign('cat_id', $catId);
        $this->assign('list', $data);
        $this->display('site_tmpl_list');

    }

    /**
     * 切换模板
     */
    public function changeTemplate()
    {

        $templateId = $_GET['tid'];
        if ($templateId) {

            //1. 变更站点模板信息
            $siteName = $_POST['site'];
            if (empty($siteName)) {
                $siteName = get_site_name();
            }
            $site = D('Site')->where("site_name='" . $siteName . "'")->find();
            $template = D('Site/Template')->where("id=" . $templateId)->find();
            $templateName = $template['tmpl_dir'];

            $site['default_mobile_template'] = $templateName;
            $ret = D('Site')->save($site);
            if (!$ret) {
                $returnArr = array("result" => 0, "msg" => "变更应用模板失败!", "code" => 402, "data" => null);
                exit(json_encode($returnArr));
            }

            //2. 复制新模板到站点文件夹下面, 如果已存在则不再复制
            $siteTemplateDir = 'Template/' . $siteName . '/';
            $module = 'mobile';
            if ($template['tmpl_type'] == 0) {
                $module = 'pc';
            }
            $moduleDir = $siteTemplateDir . $module;
            $targetDir = $moduleDir . '/' . $templateName;
            // 文件夹不存在则复制
            if (!is_dir($targetDir)) {
                //第一次使用该模板
                mkdir($targetDir, 0777, true);
                recurse_copy($template['file_path'], $targetDir);

                //2.2 生成模板对应的默认频道模块(菜单)
                $channelJson = $template['channel'];
                if (!empty($channelJson)) {
                    $channelArr = json_decode($channelJson, true);
                    $Model = M('SystemTemplateChannel');
                    foreach ($channelArr as $channel) {
                        $ret = $this->genDefaultChannel($channel);
                        if (!$ret) {
                            Log::write("新建站点[" . $siteName . "], 生成频道[" . $channel['name'] . "]失败!");
                        } else {
                            //保存站点模板和频道模块的关系
                            $TC['template_id'] = $template['id'];
                            $TC['template_name'] = $template['tmpl_dir'];
                            $TC['channel_id'] = $ret;
                            $TC['channel_index'] = $channel['index'];
                            $TC['is_sys'] = 1;

                            $count = $Model->where($TC)->count();
                            if ($count == 0) {
                                $Model->add($TC);
                            }
                        }
                    }
                }
            }

            //3 生成站点新增的频道模块(主题)
            $condition = array();
            $condition['is_sys'] = 0;
            $condition['is_active'] = 1;
            $newChannels = M('SystemChannel')->where($condition)->select();

            foreach ($newChannels as $channel) {
                //先判断SystemTemplateChannel里面是否已存在

                $condition = array();
                $condition['template_id'] = $templateId;
                $condition['channel_id'] = $channel['id'];
                $count = M('SystemTemplateChannel')->where($condition)->count();
                if ($count == 0) {
                    //生成频道模块主题
                    if ($channel['theme_id'] && $_POST['theme_id'] > 0) {
                        $this->genChannelTheme($channel['theme_id'], $channel['call_index'], $targetDir);
                        //将频道加入关系表
                        $TC['template_id'] = $template['id'];
                        $TC['template_name'] = $template['tmpl_dir'];
                        $TC['channel_id'] = $channel['id'];
                        $TC['channel_index'] = $channel['call_index'];
                        $TC['is_sys'] = 0;

                        M('SystemTemplateChannel')->add($TC);
                    }
                }
            }

            //4. 变更站点模板配置
            $config = D('SiteTemplateConfig')->where("site_name='" . $siteName . "'")->find();
            $config['tmpl_path'] = $targetDir;
            $config['default_theme'] = $templateName;
            $config['default_template_id'] = $templateId;
            $config['view_path'] = './' . $moduleDir . '/';
            $config['tmpl_parse_string_static'] = '/' . $targetDir . '/Static';
            $ret = D('SiteTemplateConfig')->save($config);

            if ($ret) {
                $returnArr = array("result" => 1, "msg" => "变更应用模板成功!", "code" => 200, "data" => null);
            } else {
                $returnArr = array("result" => 0, "msg" => "变更应用模板失败!", "code" => 403, "data" => null);
            }

        } else {
            $returnArr = array("result" => 0, "msg" => "变更应用模板失败!", "code" => 401, "data" => null);
        }

        exit(json_encode($returnArr));
    }

    /**
     * 生成频道主题到站点模板中
     * @param $themeId 选中主题ID
     * @param $channelIndex 频道别名
     * @param $templatePath 模板所在路径
     */
    private function genChannelTheme($themeId, $channelIndex, $templatePath)
    {

        $BASE_PATH = $_SERVER['DOCUMENT_ROOT'];
        // 选中频道主题模板的存放路径
        $theme = D('ChannelTheme')->where('id=' . $themeId)->find();
        $themePath = $BASE_PATH . $theme['file_path'];
        $moduleType = $theme['module_type'];

        //判断站点模板中频道模块的文件是否存在
        $channelModuleTypePath = $templatePath . DIRECTORY_SEPARATOR . $moduleType;
        if (!is_dir($channelModuleTypePath)) {
            mkdir($channelModuleTypePath, 0777, true);
        }

        /**
         * 1. 将频道主题模板文件复制一份到站点的频道模块文件夹
         * 2. 并将文件名改掉: channel_oldFileName.html
         */
        $prefix = $channelIndex . '_';
        copy_and_rename($themePath, $channelModuleTypePath, $prefix);
    }

}