<?php

namespace Admin\Controller;

use Admin\Dao\ChannelFormFieldDao;
use Admin\Util\GetFirstCharterUtil;
use Think\Exception;
use Think\Log;
use Think\Model;

header("Content-type: text/html; charset=utf-8");

class ChannelController extends BaseController
{
    /**
     * 析构函数，判断权限等
     */
    public function __construct()
    {
        parent::__construct();
        $act = ACTION_NAME; //哪个方法
        $action = $_GET["action"];//action/page_list
        $check = array('page_list', 'page_add', 'page_edit','del');
        $checkAction = array('channel');
        if(in_array($act,$checkAction) && in_array($action,$check)) {
            $res = parent::checkRole();
            if ($res["result"] != 1) {
                $this->error("您的账号没有操作权限");
            }
        }
    }

    /*
     * 频道表字段配置(所有的表，都可以进入该方法配置表字段)
     * */
    public function channel_field_config()
    {
        $channelIndex = $_GET['channel'];
        $type = $_GET['type'];
        $flow = $_GET['flow'];
        if (empty($flow)) {
            $flow = $_POST['flow'];
        }
        $action = $_GET["action"];
        $getId = $_GET["id"];

        switch ($action) {

            case 'field':
                $channel = M('SystemChannel')->where("call_index='" . $channelIndex . "'")->find();

                $title = $this->getFieldConfigTitle($channel['base_module'], $type, $channel['channel_title']);

                $this->assign('channel_title', $title);
                $this->assign('channel', $channelIndex);
                $this->assign('module', $channel['base_module']);
                $this->assign('channel_id', $channel['id']);
                $this->assign('type', $type);
                $this->assign('flow', $flow);
                $this->display("channel_field_config");
                break;
            case 'list':
                $channel = M('SystemChannel')->where("call_index='" . $channelIndex . "'")->find();

                $dao = new ChannelFormFieldDao();
                $list = $dao->getFormField($channelIndex, $type, 'mobile_sort');
                $this->assign('channel', $channelIndex);
                $this->assign('type', $type);
                $this->assign('flow', $flow);
                $this->assign('channel_title', $channel['channel_title']);
                $this->assign('channel_id', $channel['id']);
                $this->assign('list', $list);
                $this->display("channel_field_config_list");
                break;

            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
        }
        json_return($returnArr);
    }

    /*
     * 获取字段配置标题
     * **/
    private function getFieldConfigTitle($module, $type, $channel){

        $config = array(

            'CHANNEL_1' => "表单内容字段配置",
            'CHANNEL_2' => "栏目内容字段配置",
            'CHANNEL_3' => "订单内容字段配置",
            'CHANNEL_4' => "标签内容字段配置",
            'Activity_3' => "订单内容字段配置",
            'Company_3' => "级别管理字段配置",
            'Company_6' => "招聘管理字段配置",
            'Company_7' => "资料管理字段配置",
            'Company_8' => "动态内容字段配置",
        );

        $index = $module . '_' . $type;
        if(empty($config[$index])){
            $index = 'CHANNEL_' . $type;
        }

        return $channel . ' ' . $config[$index];
    }
    /*
     * 频道操作
     */
    public function channel()
    {
        $action = $_GET["action"];
        $channel_type = $_GET["channel_type"];
        $id = $_GET["id"];
        $flow = $_GET['flow'];
        if (empty($flow)) {
            $flow = $_POST['flow'];
        }
        $this->assign('flow', $flow);

        $model = M('SystemChannel');
        $getFirstChar = new GetFirstCharterUtil();
        //判断是否设置参数
        switch ($action) {
            //列表界面
            case "page_list":
                $model = M('SystemChannel');
                $condition['is_active'] = 1;
                $count = $model->where($condition)->count();
                $haveOrder = C("haveOrder"); //那些频道类型拥有订单/报名表
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页

                $list = $model->where($condition)->page($page_now, $page_num)->order("is_sys")->select();
                $i = 0;
                foreach ($list as $value) {
                    foreach ($haveOrder as $value1) {
                        if($value['base_module'] == $value1) {
                            $list[$i]['have_order'] = 1;
                        }
                    }
                    $i++;
                }

                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                $this->assign('page', $page);
                $this->assign('page_num', $page_num);
                $this->assign('page_now', $page_now);
                $this->assign('count', $count);
                $this->assign('list', $list);
                $this->display('channel_list');
                break;
            //编辑界面
            case "page_add":
                $types = D('Module')->field('module_type, type_name')->group('module_type, type_name')->order('type')->select();
                $list_type_id = $_GET["list_type_id"];
                $this->assign('list_type_id', $list_type_id);
                $this->assign('channel_type', $channel_type);
                $this->assign('add', '1');
                $this->display('channel_info');
                exit();
                break;

            case "page_edit":
                // channel
                if (empty($id)) {
                    $channelIndex = $_GET['channel'];
                    $channel = M('SystemChannel')->where("call_index='" . $channelIndex . "'")->find();
                    $id = $channel['id'];
                } else {
                    $channel = M('SystemChannel')->where('id=' . $id)->find();
                }
                $child = M('SystemChannelChild')->field('id,title,type,channel_index')->where("channel_id=".$id)->select();

                $this->assign('child', $child);
                $this->assign('info', $channel);
                $this->assign('channel', $channel['call_index']);
                $this->assign('channel_type', $channel['base_module']);
                $this->assign('add', '0');
                // module type
                $types = D('Module')->field('module_type, type_name')->where("module_type='" . $channel['base_module'] . "'")->group('module_type, type_name')->select();
                $this->assign('mt', $types);
                $this->assign('flow', $flow);
                $this->display('channel_info');
                exit();
                break;

            case "check":
                $condition = array();
                if ($_POST["param"]) {
                    $callIndex = trim($_POST["param"]);
                    $channelPrefix = C('DEFAULT_CHANNEL_PREFIX');
                    if (strpos($callIndex, $channelPrefix) !== false) {
                        $return = '前缀' . $channelPrefix . '开头的别名为系统默认频道模块别名，请使用其他字符串!';
                        exit($return);
                    }

                    $condition['call_index'] = $callIndex;
                }

                $count = M('SystemChannel')->where($condition)->count();

                if ($count > 0) {
                    $return = '字段值已存在，请重新输入!';
                } else {
                    $return = 'y';
                }
                exit($return);
                break;

            case "add"://新增频道
                try {
                    $data['channel_title'] = trim($_POST['channel_title']);
                    $data['list_type_id'] = $_GET["list_type_id"];
                   
                    //获取中文字符的首字母
                    $call_index_char = $getFirstChar->getAllChar($data['channel_title']);
                    $calIndex =  trim($call_index_char);
                    $channel = M('SystemChannel')->where("call_index= '$calIndex'")->find();
                   if($channel){
                       $callIndexNum = $channel['call_index_num']+1;
                       M('SystemChannel')->where("call_index= '$calIndex'")->setField('call_index_num',$callIndexNum);
                        $call_index_char = $call_index_char .$callIndexNum;
                       $data['call_index'] = $call_index_char;
                    } else {
                       $data['call_index'] = $calIndex;
                   }
                    if (empty($data['channel_title']) || empty($data['call_index'])) {
                        $returnArr = array("result" => 0, "msg" => "新增数据失败!", "code" => 405, "data" => null);
                        exit($returnArr);
                    }

                    $data['is_like'] = empty($_POST['is_like']) ? "0" : $_POST['is_like'];
                    $data['is_content_reviewed'] = empty($_POST['is_content_reviewed']) ? "0" : $_POST['is_content_reviewed'];
                    $data['is_collect'] = empty($_POST['is_collect']) ? "0" : $_POST['is_collect'];
                    $data['is_comment'] = empty($_POST['is_comment']) ? "0" : $_POST['is_comment'];
                    $data['is_album'] = empty($_POST['is_album']) ? "0" : $_POST['is_album'];
                    $data['is_attach'] = empty($_POST['is_attach']) ? "0" : $_POST['is_attach'];
                    $data['is_tag'] = empty($_POST['is_tag']) ? "0" : $_POST['is_tag'];
                    $data['is_comment_reviewed'] = empty($_POST['is_comment_reviewed']) ? "0" : $_POST['is_comment_reviewed'];
                    $data['is_award'] = empty($_POST['is_award']) ? "0" : $_POST['is_award'];
                    $data['is_red_packet'] = empty($_POST['is_red_packet']) ? "0" : $_POST['is_red_packet'];
                    $data['base_module'] = trim($_POST['module_type']);
                    $data['is_sys'] = 0;
                    $data['is_active'] = 1;
                    $data['is_bind_user'] = empty($_POST['is_bind_user']) ? "0" : $_POST['is_bind_user'];
                    $data['is_import_data'] = empty($_POST['is_import_data']) ? "0" : $_POST['is_import_data'];
                    $data['is_export_data'] = empty($_POST['is_export_data']) ? "0" : $_POST['is_export_data'];
                    $data['is_copy'] = empty($_POST['is_copy']) ? "0" : $_POST['is_copy'];
                    $data['is_auto_review'] = empty($_POST['is_auto_review']) ? "0" : $_POST['is_auto_review'];
                    $data['is_time_use'] = empty($_POST['is_time_use']) ? "0" : $_POST['is_time_use'];
                    $data['is_top'] = empty($_POST['is_top']) ? "0" : $_POST['is_top'];
                    if ($_POST['theme_id'] && $_POST['theme_id'] > 0) {
                        $data['theme_id'] = $_POST['theme_id'];
                    }
                    $channelIndex = $data['call_index'];

                    $channelId = $model->data($data)->add();
                    if (!$channelId) {
                        $returnArr = array("result" => 0, "msg" => "新增数据失败!", "code" => 401, "data" => null);
                        exit(json_encode($returnArr));
                    }

                    //初始化列表显示类型
                    $listTypeId = $_GET["list_type_id"];
                    $MobileChannelPage = M("MobileChannelPage");
                    $MobileListType = M("MobileListType");
                    $listTypeData = $MobileListType->where("id = '$listTypeId'")->find();
                    $listData['default_id'] =  $listTypeId;
                    $listData['channel'] =  $channelIndex;
                    $listData['html'] =  $listTypeData['html'];
                    $listData['data_json'] =  $listTypeData['json'];
                    $listData['create_time'] =  date("Y-m-d H:i:s", time());
                    $listTypeDataId = $MobileChannelPage->data($listData)->add();
                    $datas['list_type_data_id'] = $listTypeDataId;
                    $model->where("call_index = '$channelIndex'")->save($datas);
                    //增加菜单
                    //1. 找出选中的模块数据
                    $moduleType = trim($_POST['module_type']);
                    if ($moduleType) {
                        $postData = I('post.');
                        $success = $this->genChannelMenu($moduleType, $data['channel_title'], $channelIndex, $postData);

                        if (!$success) {
                            $returnArr = array("result" => 0, "msg" => "新增频道成功，但生成菜单失败!", "code" => 401, "data" => null);
                            exit(json_encode($returnArr));
                        }

                        $h = M("MobileHtmlFixed")->where("id = 1")->find();
                        $h1 = M("MobileListType")->where("id = '$listTypeId'")->getField("html");
                        $list_html = $h['html_start'].$h1. $h['html_end'];
                        $this->saveHtmlFile($list_html, $data['base_module'], $channelIndex.'_list.html');
                        $this->saveHtmlFile('', $data['base_module'], $channelIndex.'_info.html');
                        $returnArr = array("result" => 1, "msg" => "新增数据成功!", "code" => 200, "data" => $channelIndex);

                    } else {
                        $returnArr = array("result" => 0, "msg" => "新增数据失败!", "code" => 403, "data" => null);
                    }
                } catch (\Exception $e) {
                    $returnArr = array("result" => 0, "msg" => "新增数据失败!", "code" => 404, "data" => null);
                }
                break;

            case "edit"://编辑channel
                $channel = M('SystemChannel')->where("id=" . $id)->find();
                $channelTitle = $channel['channel_title'];
                $channel['channel_title'] = empty($_POST['channel_title']) ? $channel['channel_title'] : $_POST['channel_title'];
                $channel['is_like'] = empty($_POST['is_like']) ? "0" : $_POST['is_like'];
                $channel['is_content_reviewed'] = empty($_POST['is_content_reviewed']) ? "0" : $_POST['is_content_reviewed'];
                $channel['is_collect'] = empty($_POST['is_collect']) ? "0" : $_POST['is_collect'];
                $channel['is_comment'] = empty($_POST['is_comment']) ? "0" : $_POST['is_comment'];
                $channel['is_album'] = empty($_POST['is_album']) ? "0" : $_POST['is_album'];
                $channel['is_attach'] = empty($_POST['is_attach']) ? "0" : $_POST['is_attach'];
                $channel['is_tag'] = empty($_POST['is_tag']) ? "0" : $_POST['is_tag'];
                $channel['is_comment_reviewed'] = empty($_POST['is_comment_reviewed']) ? "0" : $_POST['is_comment_reviewed'];
                $channel['is_award'] = empty($_POST['is_award']) ? "0" : $_POST['is_award'];
                $channel['is_red_packet'] = empty($_POST['is_red_packet']) ? "0" : $_POST['is_red_packet'];
                $channel['order_type'] = empty($_POST['order_type']) ? "0" : $_POST['order_type'];
                $channel['is_import_data'] = empty($_POST['is_import_data']) ? "0" : $_POST['is_import_data'];
                $channel['is_export_data'] = empty($_POST['is_export_data']) ? "0" : $_POST['is_export_data'];
                $channel['is_copy'] = empty($_POST['is_copy']) ? "0" : $_POST['is_copy'];
                $channel['is_auto_review'] = empty($_POST['is_auto_review']) ? "0" : $_POST['is_auto_review'];
                $channel['is_time_use'] = empty($_POST['is_time_use']) ? "0" : $_POST['is_time_use'];
                $channel['is_top'] = empty($_POST['is_top']) ? "0" : $_POST['is_top'];
                $channel['is_bind_user'] = empty($_POST['is_bind_user']) ? "0" : $_POST['is_bind_user'];
                $count = M('SystemChannel')->where($channel)->count();

                $typeData["type_id"] = $channel['order_type'];
                $typeData["channel"] = $channel['call_index'];
                $typeData["channel_id"] = $channel['id'];
                if ($count == 0) {
                    $ret = M('SystemChannel')->save($channel);
                    if (!$ret) {
                        $returnArr = array("result" => 0, "msg" => "修改频道数据失败!", "code" => 401, "data" => $ret);
                        exit(json_encode($returnArr));
                    }
                }

                //修改对应二级菜单名称
                if ($channel['channel_title'] != $channelTitle) {
                    $con['channel'] = $channel['call_index'];
                    $con['module'] = 'menu';
                    M('SystemModule')->where($con)->setField('title', $channel['channel_title']);
                }


                $returnArr = array("result" => 1, "msg" => "修改频道数据成功!", "code" => 200, "data" => $channel['call_index']);
                break;
            //删除
            case "del":
                if ($id) {
                    $channel = M('SystemChannel')->where("id=" . $id)->find();
                    $callIndex = $channel['call_index'];
                    $allowDelete = false;
                    if (strtolower($channel['base_module']) == 'system') {
                        $con = array();
                        $con['channel'] = $callIndex;
                        $tableConfig = M('SystemChannelTableConfig')->where($con)->field('table_name')->select();
                        foreach ($tableConfig as $config) {
                            $channelTable = $config['table_name'];
                            $sql = "SELECT COUNT(1) t_count FROM " . $channelTable;
                            $ret = M()->query($sql);
                            $count = $ret[0]['t_count'];
                            if ($count > 0) {
                                $allowDelete = false;
                                break;
                            } else {
                                $allowDelete = true;
                            }
                        }

                    } else {

                        $con = array();
                        $con['channel'] = $callIndex;
                        $con['type'] = 1;
                        $tableConfig = M('SystemChannelTableConfig')->where($con)->field('table_name')->find();

                        if (count($tableConfig) > 0) {
                            $channelTable = $tableConfig['table_name'];
                            $sql = "SELECT COUNT(1) t_count FROM " . $channelTable;
                            $ret = M()->query($sql);
                            $count = $ret[0]['t_count'];

                            if ($count > 0) {
                                $allowDelete = false;
                            } else {
                                $allowDelete = true;
                            }
                        } else {
                            $allowDelete = true;
                        }

                    }

                    if ($allowDelete) {
                        //删除相关菜单
                        $ret = M('SystemModule')->where("channel='" . $callIndex . "'")->delete();

                        //删除表单字段配置
                        $ret = M('SystemChannelFormField')->where("channel='" . $callIndex . "'")->delete();

                        //删除子表单记录
                        $ret = M('SystemChannelChild')->where("channel_index='" . $callIndex . "'")->delete();
                        //删频道表
                        $con = array();
                        $con['channel'] = $callIndex;
                        $tableConfig = M('SystemChannelTableConfig')->where($con)->select();
                        foreach ($tableConfig as $config) {
                            $delSql = "DROP TABLE IF EXISTS `" . $config['table_name'] . "`;";
                            M()->execute($delSql);
                        }
                        //删除  站点_频道名_view_record表
                        $site = get_site_name();
                        $prefix = $site . '_';
                        $channelTable = strtolower($prefix.$channel['base_module'].'_'.$callIndex.'_view_record');
                        $delRecordSql = "DROP TABLE IF EXISTS `" . $channelTable . "`;";
                        M()->execute($delRecordSql);
                        //删除频道表配置
                        $ret = M('SystemChannelTableConfig')->where("channel='" . $callIndex . "'")->delete();
                        //删除列表样式
                        $ret2 = M('MobileChannelPage')->where("channel= '$callIndex'")->delete();
                        //删除导出数据相应字段
                        $ret2 = M('SystemChannelExportField')->where("channel= '$callIndex'")->delete();
                        //删除频道的列表html文件
                        $siteName = get_site_name();
                        $base = $channel['base_module'];
                        $listhtml = $callIndex.'_list.html';
                        $infohtml = $callIndex.'_info.html';
                        $fileDir = "Template/$siteName/mobile/$base/$listhtml";
                        $result = @unlink ($fileDir);
                        $fileDir2 = "Template/$siteName/mobile/$base/$infohtml";
                        $result = @unlink ($fileDir2);
                        //删除频道
                        $result = M('SystemChannel')->where('id=' . $id)->delete();

                        if ($result) {
                            $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);
                        } else {
                            $returnArr = array("result" => 0, "msg" => "删除失败", "code" => 402, "data" => null);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "删除失败，模块仍存在业务数据，请先清除业务数据并清空回收站再删除!", "code" => 403, "data" => null);
                    }
                } else {
                    $returnArr = array("result" => 0, "msg" => "删除失败", "code" => 404, "data" => null);
                }
                break;

            case "list":
                $model = M('SystemChannel');
                if($_POST['title']){
                    $condition['channel_title'] = array('LIKE', '%'.$_POST['title'].'%');
                }

                $condition['is_active'] = 1;
                $count = $model->where($condition)->count();

                $page_num = I('post.page_num', 8);   //$page_num 每页几条数据
                $page_now = I('post.page_now', 1);   //$page_now 第几页

                $list = $model->where($condition)->page($page_now, $page_num)->select();

                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                $data['list'] = $list;
                $data['page'] = $page;

                $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $data);
                break;
            case "type":
                $where['A.channel'] = $_GET['channel'];
                $info = M('SystemChannelTableConfig')->alias('A')
                                                ->join('__SYSTEM_CHANNEL_CHILD__ B ON A.channel=B.channel_index AND A.type=B.type', 'LEFT')
                                                ->field('A.channel,A.type,A.base_module,B.title')
                                                ->where($where)
                                                ->order('A.type')
                                                ->select();
                if($info === false){
                    $returnArr = array("result" =>0, "msg" => "获取类型失败!", "code" => 401, "data" => null);
                }else{
                    foreach($info as $key=>$item){
                        if(empty($item['title'])){
                            $info[$key]['title'] = $this->getTypeName($item['channel'], $item['base_module'], $item['type']);
                        }
                    }
                    $returnArr = array("result" =>1, "msg" => "获取类型成功!", "code" => 200, "data" => $info);
                }



                break;
            case "sort":
                $channel = M('SystemChannel')->where("id=" . $id)->find();
                $channel['sort_id'] = empty($_GET["sort_id"]) ? "99" : $_GET["sort_id"];
                $ret = M('SystemChannel')->save($channel);
                if ($ret) {
                    $returnArr = array("result" =>1, "msg" => "修改成功!", "code" => 200, "data" => null);
                }
                else
                {
                    $returnArr = array("result" =>0, "msg" => "修改失败!", "code" => 401, "data" => null);
                }
                break;

            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
                break;
        }
        json_return($returnArr);
    }

    private function getTypeName($channel, $baseModule, $type){

        $typeName = null;
        switch($type){
            case 1:
                $typeName = M('SystemChannel')->where("call_index='".$channel."'")->getField('channel_title');
                break;
            case 2:
                $typeName = '栏目类别';
                break;
            case 3:
                if($baseModule == 'Activity'){
                    $typeName = '活动订单';
                }else if($baseModule == 'Company'){
                    $typeName = '企业级别';
                }
                break;
            case 4:
                $typeName = "标签";
                break;
            case 5:
                $typeName = "标签关系";
                break;
            case 6:
                if($baseModule == 'Activity'){
                    $typeName = '门票类型';
                }else if($baseModule == 'Company'){
                    $typeName = '招聘信息';
                }
                break;
            case 7:
                if($baseModule == 'Company'){
                    $typeName = '企业资料';
                }
                break;
            case 8:
                if($baseModule == 'Company'){
                    $typeName = '企业动态';
                }
                break;
            case 9:
                if($baseModule == 'Company'){
                    $typeName = '招聘分类';
                }
                break;
        }
        if(empty($typeName)){
            $typeName = $type;
        }
        return $typeName;
    }

    //选择频道的类型
    public function channel_type()
    {
        $this->display('channel_type');
    }

    //频道下不同的列表和详情类型
    public function channelListType()
    {
        $channel_type = $_GET["channel_type"];
        $this->assign('channel_type',$channel_type);
        $this->display('channel_list_type');
    }

    /**
     * 生成频道主题到站点模板中
     * @param $themeId 选中主题ID
     * @param $channel 频道模块
     */
    private function genChannelTheme($themeId, $channel)
    {

        $BASE_PATH = $_SERVER['DOCUMENT_ROOT'];
        // 选中频道主题模板的存放路径
        $theme = D('ChannelTheme')->where('id=' . $themeId)->find();
        $themePath = $BASE_PATH . $theme['file_path'];
        if (!is_dir($themePath)) {
            return false;
        }

        $moduleType = $theme['module_type'];
        // 当前站点模板路径
        $site_name = session('site_name');
        $siteTemplateConfig = D('SiteTemplateConfig')->where("site_name='" . $site_name . "'")->find();
        $template = D('Site/Template')->where("tmpl_dir='" . $siteTemplateConfig['default_theme'] . "'")->find();

        $siteTemplatePath = $BASE_PATH . $siteTemplateConfig['tmpl_path'];

        //判断站点模板中频道模块的文件是否存在
        $channelModuleTypePath = $siteTemplatePath . DIRECTORY_SEPARATOR . $moduleType;
        if (!is_dir($channelModuleTypePath)) {
            mkdir($channelModuleTypePath, 0777, true);
        }

        /**
         * 1. 将频道主题模板文件复制一份到站点的频道模块文件夹
         * 2. 并将文件名改掉: channel_oldFileName.html
         */
        $prefix = $channel['call_index'] . '_';
        try {
            copy_and_rename($themePath, $channelModuleTypePath, $prefix);

            $Model = M('SystemTemplateChannel');
            $TC['template_id'] = $template['id'];
            $TC['template_name'] = $template['tmpl_dir'];
            $TC['channel_id'] = $channel['id'];
            $TC['channel_index'] = $channel['call_index'];
            $TC['is_sys'] = 0;

            $count = $Model->where($TC)->count();
            if ($count == 0) {
                $Model->add($TC);
            }

        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * 变更频道主题
     * @param $themeId 主题ID
     * @param $channel 频道模块
     */
    private function changeChannelTheme($themeId, $channel)
    {
        $BASE_PATH = $_SERVER['DOCUMENT_ROOT'];

        // 1. 找到选中主题数据
        $theme = D('ChannelTheme')->where("id=" . $themeId)->find();
        $moduleType = $theme['module_type'];
        $themePath = $BASE_PATH . $theme['file_path'];
        //2. 找到站点存放手机端模板的路径
        $siteName = session('site_name');
        if (empty($siteName)) {
            $siteName = get_site_name();
        }
        $siteTemplate = D('SiteTemplateConfig')->where("site_name='" . $siteName . "'")->find();
        $siteTemplatePath = $BASE_PATH . str_replace('./', '', $siteTemplate['view_path']);

        $arr = scandir($siteTemplatePath);
        foreach ($arr as $key => $val) {
            if ($val == '.' || $val == '..')
                continue;

            if (is_dir($siteTemplatePath . DIRECTORY_SEPARATOR . $val)) {

                $template = D('Site/Template')->where("tmpl_dir='" . $val . "'")->find();

                $channelModuleTypePath = $siteTemplatePath . DIRECTORY_SEPARATOR . $val . DIRECTORY_SEPARATOR . $moduleType;

                if (!is_dir($channelModuleTypePath)) {
                    mkdir($channelModuleTypePath, 0777, true);
                }

                /**
                 * 1. 将频道主题模板文件复制一份到站点的频道模块文件夹
                 * 2. 并将文件名改掉: channel_oldFileName.html
                 */
                $prefix = $channel['call_index'] . '_';
                try {

                    copy_and_rename($themePath, $channelModuleTypePath, $prefix);

                    $Model = M('SystemTemplateChannel');

                    $TC['template_id'] = $template['id'];
                    $TC['channel_id'] = $channel['id'];
                    $TC['template_name'] = $template['tmpl_dir'];
                    $TC['channel_index'] = $channel['call_index'];
                    $TC['is_sys'] = 0;

                    $count = $Model->where($TC)->count();
                    if ($count == 0) {
                        $Model->add($TC);
                    }

                } catch (\Exception $e) {
                    return false;
                }

            }
        }
        return true;
    }

    /**
     * 生成频道菜单
     * @param $moduleType 频道模块类型
     * @param $channelTitle 频道名称
     * @param $channelIndex 频道别名
     * @param $POST 表单数据
     */
    public function genChannelMenu($moduleType, $channelTitle, $channelIndex, $POST)
    {

        try{
            $modules = D('Module')->where("module_type='$moduleType'")->order('type')->select();

            //增加菜单
            // 1)二级菜单
            //需要再添加业务数据里面的模块就去config.php里添加数组yewu_data_module_type的值
            $yewuDataModuleType = C("yewu_data_module_type");

            if (in_array($moduleType, $yewuDataModuleType)) {
                $m = M('SystemModule')->where("call_index='business'")->find();
            } else {
                $index = strtolower($moduleType);
                $m = M('SystemModule')->where("call_index='" . $index . "'")->find();
            }

            $menu['channel'] = $channelIndex;
            $menu['module'] = 'menu';
            $menu['level'] = 2;
            $menu['action'] = '{"show": 1}';
            $menu['title'] = $channelTitle;
            $menu['visible'] = 1;
            $menu['parent_id'] = $m['mod_id'];
            $menu['parent_id_path'] = '_0_'.$m['mod_id'].'_';
            $menu['orderby'] = 50;
            $menu['icon'] = 'fa-flag';
            $menu['is_sys'] = 0;
            $menu['call_index'] = $moduleType . '_' . $channelIndex;
            $secondId = M('SystemModule')->add($menu);

            if ($secondId) {
                //2)增加三级菜单
                $menus = array();

                $menuIndex = strtoupper($moduleType . '_MENU_SET');
                $menuSet = C($menuIndex);
                $i = 0;
                foreach ($modules as $module) {
                    if (!in_array($module['type'], $menuSet)) {
                        continue;
                    }
                    $menus[$i]['channel'] = $channelIndex;
                    $menus[$i]['module'] = 'module';
                    $menus[$i]['level'] = 3;
                    $menus[$i]['action'] = $module['config'];
                    $menus[$i]['title'] = $module['module_title'];
                    $menus[$i]['visible'] = 1;
                    $menus[$i]['parent_id'] = $secondId;
                    $menus[$i]['parent_id_path'] = '_0_'.$m['mod_id'].'_'.$secondId.'_';
                    $menus[$i]['orderby'] = 50;
                    $menus[$i]['is_sys'] = 0;
                    $moduleIndex = $channelIndex . '_' . $module['module_name'];
                    $menus[$i]['call_index'] = $moduleIndex;
                    $type = $module['type'];

                    $menus[$i]['url'] = $module['url'] . '/channel/' . $channelIndex . '/type/' . $type;
                    $i++;
                }
                $success = M('SystemModule')->addAll($menus);

                return $success;
            } else {
                return false;
            }
        }catch(\Exception $e){
            Log::write("频道生成菜单出错【".$e->getMessage()."】");
            return false;
        }
    }

    /**
     * 频道字段自定义
     */
    public function channelField()
    {

        $action = $_GET['action'];
        $channelIndex = $_GET['channel'];
        $type = $_GET['type'];
        $this->assign('channel', $channelIndex);
        $this->assign('type', $type);
        $flow = $_GET['flow'];
        if (empty($flow)) {
            $flow = $_POST['flow'];
        }
        $this->assign('flow', $flow);

        $page = '';
        switch ($action) {

            case 'channel_add':
                $frmContent = $_POST['FrmContent'];
                $condition['call_index'] = $channelIndex;
                $channel = M('SystemChannel')->where($condition)->find();

                //1. 先将json字段名转为全拼
                $frmContent = urldecode($frmContent);
                $fields = $this->changeFiledToChinese($frmContent);
                //2. 保存页面初始数据
                $this->saveChannelPageDefaultData($fields, $channel);

                //3. 生成频道表
                $flag = $this->createChannelTableFlow($channel, $fields);
                if ($flag) {
                    $returnArr = array("result" => 1, "msg" => "配置频道表成功", "code" => 200, "data" => $flag);
                    $this->exportField($channelIndex);
                } else {
                    $returnArr = array("result" => 0, "msg" => "配置频道表失败", "code" => 401, "data" => $flag);
                }

                exit(json_encode($returnArr));
                break;

            case 'channel_edit':
                $frmContent = $_POST['FrmContent'];
                $flag = $this->editChannelTable($channelIndex, $type, $frmContent);
                $ifExport =M('SystemChannel')->where("call_index='" . $channelIndex . "'")->getField("is_export_data");
                $ifHaveExportField = M("SystemChannelFormField")->where("channel='" . $channelIndex . "'")->count();
                if ($flag) {
                    if($ifExport == 1 && $ifHaveExportField<1) {
                        $this->exportField($channelIndex);
                    }

                    $returnArr = array("result" => 1, "msg" => "修改频道表成功", "code" => 200, "data" => $flag);
                } else {
                    $returnArr = array("result" => 0, "msg" => "修改频道表失败", "code" => 401, "data" => $flag);
                }

                exit(json_encode($returnArr));
                break;

            case 'list':
                $channel = M('SystemChannel')->where("call_index='" . $channelIndex . "'")->find();
                $dao = new ChannelFormFieldDao();
                $list = $dao->getFormField($channelIndex, $type, 'mobile_sort');

                $this->assign('channel_title', $channel['channel_title']);
                $this->assign('list', $list);
                $page = 'channel_field_list';
                break;

            case 'edit':
                $id = $_GET['id'];
                $filed = M('SystemChannelFormField')->where('id=' . $id)->find();

                if (isset($_POST['title'])) {
                    $filed['title'] = $_POST['title'];
                }
                if (isset($_POST['admin_sort'])) {
                    $filed['admin_sort'] = $_POST['admin_sort'];
                }
                if (isset($_POST['width'])) {
                    $filed['width'] = $_POST['width'];
                }
                if (isset($_POST['mobile_sort'])) {
                    $filed['mobile_sort'] = $_POST['mobile_sort'];
                }

                $ret = M('SystemChannelFormField')->save($filed);
                if ($ret) {
                    $returnArr = array("result" => 1, "msg" => "更新数据成功", "code" => 200, "data" => NULL);
                } else {
                    $returnArr = array("result" => 0, "msg" => "修改数据失败", "code" => 401, "data" => $ret);
                }
                exit(json_encode($returnArr));
                break;

            case 'update_field':

                $dataJson = $_POST['data'];
                $fieldName = $_POST['field'];
                $fieldTitle = $_POST['title'];

                $arr = json_decode($dataJson, true);
                $model = M('SystemChannelFormField');
                if (count($arr) > 0) {
                    $model->startTrans();
                    foreach ($arr as $set) {
                        $ret = $model->where('id=' . $set['id'])->setField($fieldName, $set[$fieldName]);
                        if (!$ret) {
                            $model->rollback();
                            $returnArr = array("result" => 0, "msg" => "修改字段[" . $fieldTitle . "]失败", "code" => 402, "data" => $ret);
                            exit(json_encode($returnArr));
                        }
                    }
                    $model->commit();
                    $returnArr = array("result" => 1, "msg" => "更新字段[" . $fieldTitle . "]成功", "code" => 200, "data" => NULL);
                    exit(json_encode($returnArr));
                } else {
                    $returnArr = array("result" => 1, "msg" => "处理完成, 没有数据变更!", "code" => 300, "data" => NULL);
                    exit(json_encode($returnArr));
                }

                break;

            case 'popup':
                $channel = M('SystemChannel')->where("call_index='" . $channelIndex . "'")->find();
                $moduleType = D('Module')->field('module_name, module_title')->where("module_type='" . $channel['base_module'] . "'")->order('type')->select();

                $module = $moduleType[0]['module_name'];

                $this->assign('module', $module);
                $this->assign('channel', $channel);
                $this->assign('moduleType', $moduleType);
                $page = 'channel_field_popup';
                break;

            case 'channel_field':
                $channel = M('SystemChannel')->where("call_index='" . $channelIndex . "'")->find();
                $this->assign('channel_title', $channel['channel_title']);
                $page = 'channel_field';
                break;

            case 'field_config':
                if ($flow == 1) {
                    if ($channelIndex && $type) {
                        $channel = M('SystemChannel')->where("call_index='" . $channelIndex . "'")->find();
                        $index = 'TABLE_FIELD_' . $type . '_' . $channel['base_module'];
                        $fieldJson = C($index);
                        if(empty($fieldJson)){
                            $index = 'TABLE_FIELD_' . $type;
                            $index = strtoupper($index);
                        }

                        $config['FrmContent'] = C($index);

                        $returnArr = array("result" => 1, "msg" => "获取字段配置成功", "code" => 200, "data" => $config);
                    } else {
                        $returnArr = array("result" => 0, "msg" => "缺少必要参数", "code" => 404, "data" => NULL);
                    }
                } else {
                    if ($channelIndex && $type) {
                        
                        $condition['channel'] = $channelIndex;
                        $condition['type'] = $type;
                        $tableConfig = M('SystemChannelTableConfig')->where($condition)->find();
                        $config['FrmContent'] = $tableConfig['field_config'];
                        $returnArr = array("result" => 1, "msg" => "获取字段配置成功", "code" => 200, "data" => $config);
                    } else {
                        $returnArr = array("result" => 0, "msg" => "缺少必要参数", "code" => 404, "data" => NULL);
                    }
                }

                exit(json_encode($returnArr));
                break;

            case 'fields':
                $SystemChannelFormFieldLogic = D('SystemChannelFormField', 'Logic');
                if ($channelIndex && $type) {

                    $fields = $SystemChannelFormFieldLogic->getFields($channelIndex, $type);

                    $returnArr = array("result" => 1, "msg" => "获取字段配置成功", "code" => 200, "data" => $fields);
                } else {
                    $returnArr = array("result" => 0, "msg" => "缺少必要参数", "code" => 404, "data" => NULL);
                }

                exit(json_encode($returnArr));
                break;


            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                break;
        }
        if (empty($page)) {
            $this->display();
        } else {
            $this->display($page);
        }

    }

    //初始化开启了‘导出数据’的数据字段
    public function exportField($channel) {
        try{
            $isExport = M("SystemChannel")->where("call_index = '$channel'")->getField("is_export_data");
            if($isExport == 1) {

                $type = [1,2];  //type=1为内容管理，2为栏目管理，4为标签管理
                foreach ($type as $value) {
                    $tableName[] = M("SystemChannelTableConfig")->where("channel = '$channel' AND type = '$value'")->getField("table_name");
                }
                //获取相应表的对应字段
                foreach ($tableName as $value) {
                    $info[$value] = M("SystemChannelFormField")->field("name,title")->where("channel = '$channel' AND table_name = '$value'")->select();
                }
               foreach ($info as $item => $value1) {
                   foreach ($value1 as $value2) {
                       $data['channel'] = $channel;
                       $data['table_name'] = $item;
                       $data['field_name'] = $value2['name'];
                       $data['field_title'] = $value2['title'];
                       $data['create_time'] = date("Y-m-d H:i:s",time());
                       M("SystemChannelExportField")->add($data);
                   }
               }

            }
        }catch(\Exception $e){
            Log::write("初始化导出字段出错: ".$e->getMessage());
        }
    }
    /**
     * 修改频道表
     * @param $channel 频道表名
     * @param $type
     * @param $formFieldJson 字段配置json
     * @return status
     */
    private function editChannelTable($channel, $type, $formFieldJson)
    {
        try {
            $condition = array();
            $condition['channel'] = $channel;
            $condition['type'] = $type;
            $tableConfig = M('SystemChannelTableConfig')->where($condition)->find();
            $datas = $this->changeFiledToChinese($formFieldJson);
            if($tableConfig) {
                //2. 修改字段配置
                $ChannelFormField = M('SystemChannelFormField');
                $newDatas = array();
                $dataFieldNameArr = array();
                $i = 0;
                foreach ($datas as $data) {
                    if($data['control_type'] != 'relation') {
                        $dataFieldNameArr[$i] = $data['control_field'];
                        $con = array();
                        $con['name'] = $data['control_field'];
                        $con['table_config_id'] = $tableConfig['id'];
                        $con['channel'] = $channel;

                        $formField = $ChannelFormField->where($con)->find();
                        //2.1. 修改
                        if (count($formField) > 0) {
                            //2.1.1 修改表字段
                            $this->alterChannelTableFiled($data, $tableConfig['table_name']);
                            //2.1.2 更新字段配置
                            $formField['title'] = $data['control_label'];
                            $formField['form_type'] = $data['control_type'];
                            $formField['is_required'] = $data['control_required'];
                            $formField['valid_tip_msg'] = $data['control_label'];
                            $formField['admin_sort'] = $data['order'];
                            $formField['mobile_sort'] = $data['order'];
                            if ($data['control_required'] == 1) {
                                $formField['valid_error_msg'] = $data['control_label'] . "不能为空!";
                                $formField['valid_pattern'] = '*';
                            } else {
                                $formField['valid_error_msg'] = '';
                                $formField['valid_pattern'] = '';
                            }
                            if ($data['control_verify']) {
                                if ($data['control_verify'] == 'Num' || $data['control_verify'] == 'Dobule') {
                                    $formField['valid_pattern'] = 'n';
                                } else if ($data['control_verify'] == 'Mobile') {
                                    $formField['valid_pattern'] = 'm';
                                } else if ($data['control_verify'] == 'Email') {
                                    $formField['valid_pattern'] = 'e';
                                }
                            }

                            if ($data['control_item'] && count($data['control_item']) > 0) {
                                $items = array();
                                $j = 0;
                                foreach ($data['control_item'] as $item) {
                                    $items[$j]['value'] = ($j + 1);
                                    $items[$j]['name'] = $item['name'];
                                    $items[$j]['checked'] = $item['defaults'];
                                    $j++;
                                }
                                $formField['item_option'] = json_encode($items);
                            } else {
                                $formField['item_option'] = '';
                            }
                            $ChannelFormField->save($formField);
                        } else {
                            $newDatas[] = $data;
                        }
                        $i++;
                    }else {
                        $fieldLogic = D('SystemChannelFormField', 'Logic');
                        $fieldName = 'name,title,form_type';
                        $channelFields = $fieldLogic->getFields($data['control_channel_index'], $data['control_channel_type'], $fieldName);
                        $channelFields = $fieldLogic->formatFields($channelFields);
                        $fromRelationChannelFields = $data['control_channel_fields'];

                        foreach($fromRelationChannelFields as $key=>$val){
                            if($val != 0){
                                $fieldConfig = $channelFields[$key];
                                $dataFieldNameArr[$i] = $key;
                                $con = array();
                                $con['name'] = $key;
                                $con['table_config_id'] = $tableConfig['id'];
                                $con['channel'] = $channel;

                                $formField = $ChannelFormField->where($con)->find();

                                //关联频道的字段不修改，只增加或删除
                                if(!$formField){
                                    $this->addRelationField($channel, $type, $tableConfig, $fieldConfig);
                                }
                                $i++;
                            }
                        }
                    }
                }

                //2.2 .新增
                if (count($newDatas) > 0) {

                    //2.2.1 新增表字段
                    $this->addChannelTableField($newDatas, $tableConfig['table_name']);

                    //2.2.2 新增字段配置
                    $this->addChannelFormField($newDatas, $channel, $type, $tableConfig['table_name'], $tableConfig['id']);
                }
                //2.3 删除字段配置
                $condition = array();
                $condition['channel'] = $channel;
                $condition['table_config_id'] = $tableConfig['id'];
                $channelFiled = M('SystemChannelFormField')->where($condition)->select();
                foreach ($channelFiled as $field) {
                    if (!in_array($field['name'], $dataFieldNameArr)) {

                        M('SystemChannelFormField')->where("id=" . $field['id'])->delete();
                    }
                }
                //1. 修改表配置
                $tableConfig['field_config'] = json_encode($datas);
                $flag = M('SystemChannelTableConfig')->save($tableConfig);
            }else{
                $tableConfig = $this->getChildTableConfig($channel, $type);
                $conf['call_index'] = $channel;
                $channelInfo = M('SystemChannel')->where($conf)->find();
                $flag = $this->createChannelTable($channelInfo, $type, $datas, $tableConfig);
            }
        } catch (\Exception $e) {
            Log::write("修改频道表出错,channel[".$channel."],type[".$type."],错误信息[".$e->getMessage()."]");
            return false;
        }
        return true;
    }


    /*
     * 新增关联字段
     * **/
    private function addRelationField($channel, $type, $tableConfig, $fieldConfig)
    {
        try{
            //新增表字段
            $fieldType['control_type'] = $fieldConfig['form_type'];
            $name = $fieldConfig['name'];
            $dataType = $this->getDataType($fieldType);
            $fieldSql = "ALTER TABLE `" . $tableConfig['table_name'] . "` ADD `" . $name . "` " . $dataType . " DEFAULT NULL COMMENT  '" . $fieldConfig['title'] . "';";
            M()->execute($fieldSql);

            $formField['channel'] = $channel;
            $formField['type'] = $type;
            $formField['width'] = 80;
            $formField['show_list'] = 1;
            $formField['admin_use'] = 1;
            $formField['mobile_use'] = 1;
            $formField['table_name'] = $tableConfig['table_name'];
            $formField['table_config_id'] = $tableConfig['id'];
            $formField['name'] = $name;
            $formField['title'] = $fieldConfig['title'];
            $formField['form_type'] = $fieldConfig['form_type'];
            $formField['is_required'] = 0;
            $formField['valid_tip_msg'] = $fieldConfig['title'];
            $formField['mobile_sort'] = 99;
            $formField['admin_sort'] = 99;

            $formField['valid_error_msg'] = '';
            $formField['valid_pattern'] = '';
            $formField['item_option'] = '';
            $formField['is_relation'] = 1;

            M('SystemChannelFormField')->add($formField);
        }catch(\Exception $e){
            Log::write("增加表[".$tableConfig['table_name']."]关联字段出错: ".$e->getMessage());
        }
    }

    /**
     * 增加表字段
     * @param $datas 新增字段配置
     * @param $tableName 表名
     */
    private function addChannelTableField($datas, $tableName)
    {
        try{
            foreach ($datas as $data) {
                $dataType = $this->getDataType($data);
                $nullStr = "";
                if ($data['control_required'] == 1) {
                    $nullStr = " NOT NULL";
                }
                $defaultStr = "";
                if (!empty($data['control_default'])) {
                    " DEFAULT '" . $data['control_default'] . "'";
                }
                $fieldSql = "ALTER TABLE `" . $tableName . "` ADD `" . $data['control_field'] . "` " . $dataType . $nullStr . $defaultStr . " COMMENT '" . $data['control_label'] . "';";
                M()->execute($fieldSql);
            }
        }catch(\Exception $e){
            Log::write("增加表[".$tableName."]字段出错: ".$e->getMessage());
        }
    }

    /**
     * 修改表字段
     * @param $data 字段配置
     * @param $tableName 表名
     */
    private function alterChannelTableFiled($data, $tableName)
    {
        try{
            $dataType = $this->getDataType($data);

            $nullStr = "";
            if ($data['control_required'] == 1) {
                $nullStr = " NOT NULL";
            }
            $defaultStr = "";
            if (!empty($data['control_default'])) {
                " DEFAULT '" . $data['control_default'] . "'";
            }
            $fieldSql = "ALTER TABLE `" . $tableName . "` MODIFY `" . $data['control_field'] . "` " . $dataType . $nullStr . $defaultStr . " COMMENT '" . $data['control_label'] . "';";
            M()->execute($fieldSql);
        }catch(\Exception $e){
            Log::write("修改表[".$tableName."]字段出错: ".$e->getMessage());
        }
    }

    private function addChannelFormField($datas, $channel, $type, $channelTable, $tableConfigId)
    {
        try{
            $ChannelFormField = M('SystemChannelFormField');
            $i = 0;
            foreach ($datas as $data) {

                if($data['control_type'] != 'relation'){
                    $formField[$i]['channel'] = $channel;
                    $formField[$i]['type'] = $type;
                    $formField[$i]['width'] = 80;
                    $formField[$i]['show_list'] = 1;
                    $formField[$i]['admin_use'] = 1;
                    $formField[$i]['mobile_use'] = 1;
                    $formField[$i]['table_name'] = $channelTable;
                    $formField[$i]['table_config_id'] = $tableConfigId;

                    $formField[$i]['name'] = $data['control_field'];
                    $formField[$i]['title'] = $data['control_label'];
                    $formField[$i]['form_type'] = $data['control_type'];
                    $formField[$i]['is_required'] = $data['control_required'];
                    $formField[$i]['valid_tip_msg'] = $data['control_label'];
                    $formField[$i]['mobile_sort'] = $data['order'];
                    $formField[$i]['admin_sort'] = $data['order'];
                    if ($data['control_required'] == 1) {
                        $formField[$i]['valid_error_msg'] = $data['control_label'] . "不能为空!";
                        $formField[$i]['valid_pattern'] = '*';
                    } else {
                        $formField[$i]['valid_error_msg'] = '';
                        $formField[$i]['valid_pattern'] = '';
                    }
                    if ($data['control_verify']) {
                        if ($data['control_verify'] == 'Num' || $data['control_verify'] == 'Double') {
                            $formField[$i]['valid_pattern'] = 'n';
                        } else if ($data['control_verify'] == 'Mobile') {
                            $formField[$i]['valid_pattern'] = 'm';
                        } else if ($data['control_verify'] == 'Email') {
                            $formField[$i]['valid_pattern'] = 'e';
                        }
                    }

                    if ($data['control_item'] && count($data['control_item']) > 0) {
                        $items = array();
                        $j = 0;
                        foreach ($data['control_item'] as $item) {
                            $items[$j]['value'] = ($j + 1);
                            $items[$j]['name'] = $item['name'];
                            $items[$j]['checked'] = $item['defaults'];
                            $j++;
                        }
                        $formField[$i]['item_option'] = json_encode($items);
                    } else {
                        $formField[$i]['item_option'] = '';
                    }
                    $formField[$i]['is_relation'] = 0;
                    $i++;

                }else{
                    $fieldLogic = D('SystemChannelFormField', 'Logic');
                    $fieldName = 'name,title,form_type';
                    $channelFields = $fieldLogic->getFields($data['control_channel_index'], $data['control_channel_type'], $fieldName);
                    $channelFields = $fieldLogic->formatFields($channelFields);
                    $fromRelationChannelFields = $data['control_channel_fields'];

                    foreach($fromRelationChannelFields as $key=>$val){
                        if($val != 0){
                            $fieldConfig = $channelFields[$key];
                            $formField[$i]['channel'] = $channel;
                            $formField[$i]['type'] = $type;
                            $formField[$i]['width'] = 80;
                            $formField[$i]['show_list'] = 1;
                            $formField[$i]['admin_use'] = 1;
                            $formField[$i]['mobile_use'] = 1;
                            $formField[$i]['table_name'] = $channelTable;
                            $formField[$i]['table_config_id'] = $tableConfigId;
                            $formField[$i]['name'] = $key;
                            $formField[$i]['title'] = $fieldConfig['title'];
                            $formField[$i]['form_type'] = $fieldConfig['form_type'];
                            $formField[$i]['is_required'] = 0;
                            $formField[$i]['valid_tip_msg'] = $fieldConfig['title'];
                            $formField[$i]['mobile_sort'] = 99;
                            $formField[$i]['admin_sort'] = 99;

                            $formField[$i]['valid_error_msg'] = '';
                            $formField[$i]['valid_pattern'] = '';
                            $formField[$i]['item_option'] = '';
                            $formField[$i]['is_relation'] = 1;
                            $i++;
                        }
                    }

                }


            }

            $flag = $ChannelFormField->addAll($formField);
            return $flag;
        }catch(\Exception $e){
            Log::write("方法(addChannelFormField)出错! channel[".$channel."], type[".$type."],错误信息[".$e->getMessage()."]");
            return false;
        }
        return true;
    }

    private function getDataType($data)
    {
        $type = $data['control_type'];
        switch ($type) {
            case 'text':

                if ($data['control_verify'] == 'Num') {
                    $dataType = 'INT(9)';
                } else if ($data['control_verify'] == 'Double') {
                    $dataType = 'DECIMAL(10,2)';
                } else {
                    $dataType = 'VARCHAR(150)';
                }
                break;
            case 'textarea':
                $dataType = 'VARCHAR(255)';
                break;
            case 'texteditor':
                $dataType = 'TEXT';
                break;

            case 'image':
                $dataType = 'VARCHAR(255)';
                break;

            case 'upload':
                $dataType = 'VARCHAR(255)';
                break;


            case 'checkbox':
                $dataType = 'VARCHAR(255)';
                break;

            case 'radio':
                $dataType = 'VARCHAR(255)';
                break;

            case 'select':
                $dataType = 'VARCHAR(255)';
                break;

            case 'datetime':
                $dataType = 'VARCHAR(255)';
                break;

            default:
                $dataType = 'VARCHAR(255)';
                break;

        }
        return $dataType;
    }

    private function formatTableName($realTableName)
    {

        $tableFormat = '';
        if (strpos($realTableName, '_')) {
            $parts = explode('_', $realTableName);
            foreach ($parts as $part) {
                $tableFormat .= ucfirst($part);
            }
        }

        if ($tableFormat == '') {
            $tableFormat = $realTableName;
        }

        return $tableFormat;

    }

    //生成html和文件目录
    private function saveHtmlFile($html, $dir='Index', $fileName='index.html'){

        $siteName = get_site_name();
        $fileDir = "Template/$siteName/mobile/$dir";
        $file = $fileDir. '/'. $fileName;

        if(!is_dir($fileDir)){
            mkdir($fileDir, 0777, true);
        }

        file_put_contents($file, $html);
    }

    private function changeFiledToChinese($frmContentJson){
        try{
            $datas = json_decode($frmContentJson, true);
            $i=0;
            foreach ($datas as $value){
                $field = $value['control_field'];
                $fieldName =$value['control_label'];
                $len = strlen($field);
                $checkArr = array();
                if ($len == 36) {
                    //1) 如果为UUID将中文名称转为拼音首字母作为字段名
                    $getPinyin = new GetFirstCharterUtil();
                    $fieldName1 = $getPinyin->getAllChar($fieldName);

                    if(strlen($fieldName1)<=2){//如果太短，获取全拼
                        $fieldName1 = mb_convert_encoding($fieldName, 'gbk', 'utf-8');
                        $fieldName1 = $getPinyin->getFullSpell($fieldName1);
                    }
                    $fieldName = $fieldName1;

                    //2）替换原来json里面的control_feild，如果字段名重复则，则新字段名 = 就字段名 . $i
                    if(count($checkArr) > 0 && in_array($fieldName, $checkArr)){
                        $fieldName .= $i;
                    }
                    $datas[$i]['control_field'] = $fieldName;

                    //3)将字段名加入校验重复的数组
                    $checkArr[$i] = $fieldName;

                } else {
                    $checkArr[$i] =  $field;
                }
                $i++;
            }

            return $datas;
        }catch(\Exception $e){
            Log::write("字段配置转中文拼音出错: ".$e->getMessage());
            return null;
        }

    }

    private function saveChannelPageDefaultData($datas, $channel){
        try{
            $i=0;
            foreach ($datas as $value){
                $filed = $value['control_field'];
                $filedName = urlencode($value['control_label']);

                $json_data[$i]['value'] = $filed;
                $json_data[$i]['label'] = $filedName;
                if($i == 0){
                    $json_data[$i]['selected'] = true;
                } else {
                    $json_data[$i]['selected'] = false;
                }
                $i++;
            }
            $json_data[$i]['value'] = 'id';
            $json_data[$i]['label'] = 'ID';
            $json_data[$i]['selected'] = false;$i++;
            $json_data[$i]['value'] = 'create_time';
            $json_data[$i]['label'] = urlencode('创建时间');
            $json_data[$i]['selected'] = false;$i++;
            $json_data[$i]['value'] = 'create_user';
            $json_data[$i]['label'] = urlencode('发布人');
            $json_data[$i]['selected'] = false;$i++;
            $json_data[$i]['value'] = 'reads';
            $json_data[$i]['label'] = urlencode('浏览量');
            $json_data[$i]['selected'] = false;$i++;

            $defaultJson = M("MobileListType")->where("id='" . $channel['list_type_id'] . "'")->getField("json");
            $defaultData = json_decode($defaultJson,true);
            $a = 0 ;
            foreach ($defaultData as $value1) {
                $jsonDatas[$a] = $value1;
                foreach ($value1 as $value2) {
                    $jsonDatas[$a]['title'] = urlencode ($value1['title']);
                    $jsonDatas[$a]['fields'] = $value1['fields'];
                    foreach ($value2 as $item=>$value3) {
                        $jsonDatas[$a]['fields'][$item] = $value3;
                        foreach ($value3 as $value4){
                            $jsonDatas[$a]['fields'][$item]['label'] = urlencode($value3['label']) ;
                            $jsonDatas[$a]['fields'][$item]['type'] = urlencode($value3['type']) ;
                            $jsonDatas[$a]['fields'][$item]['value'] = $json_data ;
                        }
                    }
                }
                $a++;
            }

            $dataJson['data_json'] = urldecode (json_encode($jsonDatas));
            $state = M('mobileChannelPage')->where("channel='" . $channel['call_index'] . "'")->save($dataJson);
            return $state;
        }catch(\Exception $e){
            Log::write("生成频道[".$channel['channel_title']."]默认页面出错: ".$e->getMessage());
            return false;
        }
    }


    /*
     * 创建频道表流程
     * @param $channel 频道
     * @baseTableFields 基础表字段
     * **/
    private function createChannelTableFlow($channel, $baseTableFields){
        try{
            //1. 获取频道基础模块对应的建表步骤
            $baseModule = $channel['base_module'];
            $index = strtoupper($baseModule . '_FLOW');
            $flowStep = C($index);

            $state = false;
            foreach($flowStep as $step){

                // 获取初始字段json, step=1时为传入的baseTableFields
                $baseModule = $channel['base_module'];

                $fields = $baseTableFields;
                if($step != 1){
                    $index = strtoupper('TABLE_FIELD_' . $step . '_' . $channel['base_module']);
                    $fieldJson = C($index);
                    if(empty($fieldJson)){
                        $index = strtoupper('TABLE_FIELD_' . $step);
                    }
                    $fields = json_decode(C($index), true);

                }

               $state =  $this->createChannelTable($channel, $step, $fields);
               if(!$state){
                    break;
               }
            }

            //创建 站点_频道名_view_record 表
            $this->createViewRecordTable($channel['call_index'], $baseModule);
            return $state;
        }catch(\Exception $e){
            Log::write("创建频道[".$channel['channel_title']."]表流程出错: ".$e->getMessage());
            return false;
        }
    }

    /**
     * 创建频道表
     * **/
    private function createChannelTable($channel, $step, $fields, $tableConfig=null){
        try{
            //生成表名
            if(!$tableConfig){
                $tableConfig = $this->getChannelTable($channel, $step);
            }
            $channelTable = $tableConfig['name'];
            $tableFormat = $tableConfig['format'];

            if($step == 5){
                // step=5，为标签关系表，关系表特殊处理，不需要在页面配置或修改
                $state = $this->createTagRelationTable($channel, $step);
                return $state;

            }else{
                //1. 保存表配置
                $tableConfigId = $this->saveTableConfig($channel, $channelTable, $tableFormat, $step, json_encode($fields));
                if($tableConfigId === false){
                    return $tableConfigId;
                }

                //2. 建表
                if($step == 3 && $channel['base_module'] == 'Activity'){
                    $sql = $this->getOrderTableSql($channelTable, $fields);
                }else{
                    $sql = $this->getTableSql($channelTable, $fields, $step, $channel);
                }

                $Model = new Model();
                $delTableSql = "DROP TABLE IF EXISTS `".$channelTable."`;";
                $state = $Model->execute($delTableSql);
                if($state === false){
                    return $state;
                }
                $state = $Model->execute($sql);
                if($state === false){
                    return $state;
                }

                //3. 生成字段配置
                $state = $this->addChannelFormField($fields, $channel['call_index'], $step, $channelTable, $tableConfigId);
                if($state === false){
                    return $state;
                }
            }
        }catch(\Exception $e){
            Log::write("生成频道表[".$channelTable."]出错,channel[".$channel."], type[".$step."]: ".$e->getMessage());
            return false;
        }
        return true;
    }

    /**
     * 创建view_record表
     * **/
    private function createViewRecordTable($channelIndex,$base_module){
        try{
            $site = get_site_name();
            $prefix = $site . '_';
            $channelTable = strtolower($prefix.$base_module.'_'.$channelIndex.'_view_record');
            $sql = "CREATE TABLE `" . $channelTable . "` (";

            //id字段
            $sql .= " `id` int(11) NOT NULL AUTO_INCREMENT,";
            $sql .= "`channel_id` int(11) DEFAULT NULL COMMENT '频道id',";
            $sql .= "`category_id` int(11) DEFAULT NULL COMMENT '分类id',";
            $sql .= "`data_id` int(11) DEFAULT NULL COMMENT '数据id',";
            $sql .= " `user_id` int(11) DEFAULT NULL COMMENT '用户id',";
            $sql .= "`user_ip` varchar(255) DEFAULT NULL COMMENT '用户IP地址',";
            $sql .= " `create_time` datetime DEFAULT NULL COMMENT '创建时间',";
            $sql .= " PRIMARY KEY (`id`)";
            $sql .= ") ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";

            $delTableSql = "DROP TABLE IF EXISTS `".$channelTable."`;";
            $Model = new Model();
            $state = $Model->execute($delTableSql);
            if($state === false){
                return $state;
            }

            $state = $Model->execute($sql);
            return $state;
        }catch(\Exception $e){
            Log::write("创建view_record表[".$channelTable."]出错:".$e->getMessage());
            return false;
        }
    }

    /*
     * 获取订单表SQL
     * **/
    private function getOrderTableSql($channelTable, $fields){
        try{
            $orderSql = "CREATE TABLE `" . $channelTable . "` (";
            $orderSql .="`order_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单id',";
            $orderSql .="`order_sn` varchar(20) NOT NULL COMMENT '订单编号',";
            $orderSql .="`user_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',";
            $orderSql .="`order_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态订单状态:-1为待审核, 0为待付款（生成订单），1为待参与，2为待评价（已确认订单），3为已评价（完成订单），4取消订单，5为作废订单，6为退款中，7为已退款',";
            $orderSql .="`pay_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '支付状态、0为未付款，1为已付款',";
            $orderSql .= "`sign_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '签到状态、0为未签到，1为已签到',";
            $orderSql .=" `name` varchar(255) DEFAULT NULL COMMENT '姓名',";
            $orderSql .="`mobile` varchar(60) NOT NULL COMMENT '手机',";
            $orderSql .="`email` varchar(60) NOT NULL COMMENT '邮件',";
            $orderSql .="`address` varchar(255) DEFAULT NULL COMMENT '地址',";
            foreach ($fields as $data) {
                $dataType = $this->getDataType($data);
                $nullStr = "";
                if ($data['control_required'] == 1) {
                    $nullStr = " NOT NULL ";
                }
                $defaultStr = "";
                if (!empty($data['control_default'])) {
                    " DEFAULT '" . $data['control_default'] . "'";
                }
                $fieldSql = "`" . $data['control_field'] . "` " . $dataType . $nullStr . $defaultStr . " COMMENT '" . $data['control_label'] . "',";
                $orderSql .= $fieldSql;
            }
            $orderSql .="`pay_code` varchar(32) NOT NULL COMMENT '支付code',";
            $orderSql .="`pay_name` varchar(120) NOT NULL COMMENT '支付方式名称',";
            $orderSql .="`invoice_title` varchar(256) DEFAULT NULL COMMENT '发票抬头',";
            $orderSql .="`goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品单价',";
            $orderSql .="`goods_num` int(11) NOT NULL DEFAULT '0' COMMENT '商品数量',";
            $orderSql .="`coupon_price` decimal(10,2) DEFAULT '0.00' COMMENT '优惠券抵扣',";
            $orderSql .="`activity_id` bigint(11) NOT NULL DEFAULT '0' COMMENT '活动id',";
            $orderSql .="`ticket_cat_id` int(6) DEFAULT '0' COMMENT '门票类型id',";
            $orderSql .=" `activity_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '活动优惠金额',";
            $orderSql .=" `integral` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '使用积分',";
            $orderSql .="`integral_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '使用积分抵多少钱',";
            $orderSql .="`order_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '应付款金额',";
            $orderSql .="`total_amount` decimal(10,2) DEFAULT '0.00' COMMENT '订单总价',";
            $orderSql .="`add_time` datetime NOT NULL COMMENT '下单时间',";
            $orderSql .="`pay_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '支付时间',";
            $orderSql .="`discount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格调整(折扣，返现)',";
            $orderSql .="`user_note` varchar(255) NOT NULL COMMENT '用户备注',";
            $orderSql .="`admin_note` varchar(255) DEFAULT NULL COMMENT '管理员备注',";
            $orderSql .=" `activity_user_id` int(11) DEFAULT '0' COMMENT '此订单对应的活动的创建用户ID',";
            $orderSql .="`channel_id` int(11) DEFAULT '0' COMMENT '频道id',";
            $orderSql .=" PRIMARY KEY (`order_id`),";
            $orderSql .=" KEY `order_sn` (`order_sn`),";
            $orderSql .=" KEY `order_status` (`order_status`),";
            $orderSql .=" KEY `pay_id` (`pay_code`),";
            $orderSql .=" KEY `pay_status` (`pay_status`)";
            $orderSql .=") ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='活动订单表';";
            return $orderSql;
        }catch(\Exception $e){
            Log::write("生成订单表[".$channelTable."]SQL出错: ".$e->getMessage());
            return null;
        }
    }

    private function getTableSql($channelTable, $fields, $type, $channel){
        try{
            // 1.1拼接建表sql
            $sql = "CREATE TABLE `" . $channelTable . "` (";

            //id字段
            $sql .= "`id` bigint(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',";
            $sql .= "`channel_id` bigint(11) NOT NULL COMMENT '频道ID',";
            $sql .= "`category_id` bigint(20) DEFAULT NULL COMMENT '分类ID',";
            if($type == 6){
                $sql .= " `second_recruit_id` int(11) DEFAULT NULL COMMENT '招聘二级分类ID',";
            }else if($type != 1){
                $sql .= "`relation_data_id` bigint(11) DEFAULT NULL COMMENT '关联频道数据ID',";
            }
            // 动态字段
            foreach ($fields as $data) {
                if($data['control_type'] != 'relation'){
                    $dataType = $this->getDataType($data);
                    $nullStr = "";
                    if ($data['control_required'] == 1) {
                        $nullStr = " NOT NULL ";
                    }
                    $defaultStr = "";
                    if (!empty($data['control_default'])) {
                        " DEFAULT '" . $data['control_default'] . "'";
                    }
                    $fieldSql = "`" . $data['control_field'] . "` " . $dataType . $nullStr . $defaultStr . " COMMENT '" . $data['control_label'] . "',";
                    $sql .= $fieldSql;
                }else{
                    $fieldLogic = D('SystemChannelFormField', 'Logic');
                    $fieldName = 'name,title,form_type';
                    $channelFields = $fieldLogic->getFields($data['control_channel_index'], 1, $fieldName);
                    $channelFields = $fieldLogic->formatFields($channelFields);
                    $fromRelationChannelFields = $data['control_channel_fields'];

                    foreach($fromRelationChannelFields as $key=>$val){
                        if($val != 0){
                            $fieldConfig = $channelFields[$key];
                            $fieldType['control_type'] = $fieldConfig['form_type'];
                            $name = $key;
                            $dataType = $this->getDataType($fieldType);

                            $fieldSql = "`" . $name . "` " . $dataType  . " DEFAULT NULL COMMENT '" . $fieldConfig['title'] . "',";
                            $sql .= $fieldSql;
                        }
                    }
                    $where = array();
                    $where['channel'] = $channel['call_index'];
                    $where['type'] = $type;

                    $relationData = array(
                        'relation_channel' => $data['control_channel_index'],
                        'relation_type' => $data['control_channel_type']
                    );
                    M('SystemChannelTableConfig')->where($where)->save($relationData);
                    unset($where['channel']);
                    $where['channel_index'] = $channel['call_index'];

                    $relationData['has_relation'] = 1;
                    M('SystemChannelChild')->where($where)->save($relationData);
                }

            }

            //默认字段
            if($type == 1){ //基础表的字段

                $sql .= "`department_id` bigint(20) DEFAULT NULL COMMENT '组织机构ID',";
                $sql .= "`clicks` int(11) DEFAULT '0' COMMENT '浏览量',";
                $sql .= "`reads` int(11) DEFAULT '0' COMMENT '被阅读次数',";
                $sql .= "`favorites` int(11) DEFAULT '0' COMMENT '被收藏次数',";
                $sql .= "`is_active` tinyint(1) DEFAULT '1' COMMENT '是否启用(1:启用;0:停用)',";
                $sql .= "`is_red` tinyint(1) DEFAULT '1' COMMENT '是否设置推荐(1:启用;0:停用)',";
                $sql .= "`is_hot` tinyint(1) DEFAULT '1' COMMENT '是否设置热门(1:启用;0:停用)',";
                if($channel['base_module'] == 'Company'){
                    $sql .= "`level_id` int(11) DEFAULT '0' COMMENT '级别ID',";
                    $sql .= "`level_expiry` datetime DEFAULT NULL COMMENT '级别有效期',";
                    $sql .= " `level_data` int(11) DEFAULT NULL COMMENT '级别大小',";

                }
            }else{
                $sql .= "`data_id` bigint(11) NOT NULL COMMENT '数据ID',";
                $sql .= "`order_id` bigint(11) NOT NULL COMMENT '数据ID',";
            }
            $sql .= "`likes` int(11) DEFAULT '0' COMMENT '被点赞次数',";
            $sql .= "`status` tinyint(1) DEFAULT '1' COMMENT '状态:-1为禁用，0为正常，1为审核中；默认为0',";
            $sql .= "`create_time` datetime NOT NULL COMMENT '创建时间',";
            $sql .= "`create_user` varchar(150) NOT NULL COMMENT '创建人',";
            $sql .= "`create_user_id` smallint(6) NOT NULL COMMENT '创建人id',";
            $sql .= "`update_time` datetime DEFAULT NULL COMMENT '更新时间',";
            $sql .= "`update_user_id` smallint(6) DEFAULT NULL COMMENT '更新人id',";
            $sql .= "`delete_time` datetime DEFAULT NULL COMMENT '删除时间',";
            $sql .= "`delete_user_id` smallint(6) DEFAULT NULL COMMENT '删除人id',";
            $sql .= "`is_deleted` smallint(1) DEFAULT '0' COMMENT '是否删除',";
            $sql .= " PRIMARY KEY (`id`) ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8";

            return $sql;
        }catch(\Exception $e){
            Log::write("生成频道表[".$channelTable."]SQL出错!channel[".$channel."],type[".$type."],错误信息: ".$e->getMessage());
            return null;
        }
    }

    /*
     * 保存表配置
     * **/
    private function saveTableConfig($channel, $tableName, $tableFormat, $type, $json){
        try{
            $config['channel'] = $channel['call_index'];
            $config['table_name'] = $tableName;
            $config['table_format'] = $tableFormat;
            $config['base_module'] = $channel['base_module'];
            $config['type'] = $type;
            $config['field_config'] = $json;
            $state = M('SystemChannelTableConfig')->add($config);
            return $state;
        }catch(\Exception $e){
            Log::write("保存表[".$tableName."]配置出错: ".$e->getMessage());
            return false;
        }
    }

    private function getChannelTable($channel, $type){
        $site = get_site_name();
        $prefix = $site . '_';

        $where['module_type'] = $channel['base_module'];
        $where['type'] = $type;

        $module = D('Module')->where($where)->find();
        $tableName['name'] = $prefix . $module['table_name'] . '_' . $channel['call_index'];

        $tableName['format'] = $this->formatTableName($module['table_name'] . '_' . $channel['call_index']);

        return $tableName;
    }

    /*
     * 生成标签关系表
     * **/
    private function createTagRelationTable($channel, $step){
        try{
            $site = get_site_name();
            $prefix = $site . '_';

            $tableName = strtolower($prefix . $channel['base_module'] . '_tags_relation_' . $channel['call_index']);
            $tableFormat = ucfirst($channel['base_module']) . 'TagsRelation' . ucfirst($channel['call_index']);

            // tags_relation建表sql
            $sql = "CREATE TABLE `" . $tableName . "` (";
            $sql .="`id` int(11) NOT NULL AUTO_INCREMENT,";
            $sql .="`channel_id` int(11) DEFAULT NULL,";
            $sql .="`tag_id` int(11) DEFAULT NULL,";
            $sql .=" `data_id` int(11) DEFAULT NULL COMMENT '对应频道表里面数据的id',";
            $sql .="`remark` varchar(255) DEFAULT NULL COMMENT '备注',";
            $sql .="`status` tinyint(1) DEFAULT '0' COMMENT '状态:1为显示，0为隐藏；默认为0',";
            $sql .="`create_time` datetime NOT NULL COMMENT '创建时间',";
            $sql .=" PRIMARY KEY (`id`) ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8";

            $delTableSql = "DROP TABLE IF EXISTS `".$tableName."`;";
            $Model = new Model();
            $state = $Model->execute($delTableSql);
            if($state === false){
                return $state;
            }
            $state = $Model->execute($sql);
            if($state === false){
                return $state;
            }

            //2. 保存表配置
            $state = $this->saveTableConfig($channel, $tableName, $tableFormat, $step, null);
            if($state === false){
                return $state;
            }
        }catch(\Exception $e){
            Log::write("生成标签关系表[".$tableName."]失败: ".$e->getMessage());
            return false;
        }
        return true;
    }


    /**
     * DEMO显示
     */
    public function app_Demo()
    {
        $this->assign('channel_type', $_GET['channel_type']);
        $this->assign('list_type_id', $_GET['list_type_id']);
        $this->display('demo_pc_list');
    }


    /*public function child_module(){

        $channel = $_GET['channel'];
        $type = $_GET['type'];

        $action = $_GET["action"];
        $getId = $_GET["id"];

        switch ($action) {
            case "page_list":

                break;
            case "page_add":
                $this->assign('channel_id', $_GET['channel_id']);
                $this->display('child_module_info');
                break;
            case "page_edit":

                break;

            case 'list':

                break;
            case "add":
                $data = I('post.');
                $channel = M('SystemChannel')->where("id=".$data['channel_id'])->find();
                $data['channel_index'] = $channel['call_index'];

                $sql = "SELECT IFNULL(MAX(`type`),0) fill_type FROM __SYSTEM_CHANNEL_CHILD__";
                $result = M()->query($sql);

                $type = $result[0]['fill_type'];
                if(!$type){
                    $type = 9;
                }else{
                    ++$type;
                }

                $data['type'] = $type;
                $flag = M('SystemChannelChild')->add($data);
                if ($flag) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加频道[".$channel['title']."]子表单" . $data["title"] . "成功",2);
                    $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => $type);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加频道[".$channel['title']."]子表单" . $data["title"] . "失败",2);
                    $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
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
    }*/

    /*
     * 填报配置
     * */
    public function child_config()
    {
        $channelIndex = $_GET['channel'];
        $type = $_GET['type'];
        $flow = $_GET['flow'];
        if (empty($flow)) {
            $flow = $_POST['flow'];
        }
        $action = $_GET["action"];
        $getId = $_GET["id"];
        switch ($action) {

            case 'field_list':
                $channel = M('SystemChannel')->where("call_index='" . $channelIndex . "'")->find();
                $dao = new ChannelFormFieldDao();
                $list = $dao->getFormField($channelIndex, $type, 'mobile_sort');

                $conf['channel_index'] = $channelIndex;
                $conf['type'] = $type;
                $child = M('SystemChannelChild')->where($conf)->find();

                $this->assign('child', $child);
                $this->assign('channel', $channelIndex);
                $this->assign('type', $type);
                $this->assign('flow', $flow);
                $this->assign('channel_title', $channel['channel_title']);
                $this->assign('channel_id', $channel['id']);
                $this->assign('list', $list);
                $this->display("child_field_list");
                break;

            case "add":
                $data = I('post.');
                $channel = M('SystemChannel')->where("id=".$data['channel_id'])->find();
                $data['channel_index'] = $channel['call_index'];

                $sql = "SELECT IFNULL(MAX(`type`),0) fill_type FROM __SYSTEM_CHANNEL_CHILD__";
                $result = M()->query($sql);

                $type = $result[0]['fill_type'];
                if(!$type){
                    $type = 11;
                }else{
                    ++$type;
                }

                $data['type'] = $type;

                $chineseChanger = new GetFirstCharterUtil();
                $childIndex = $chineseChanger->getAllChar($data['title']);
                $data['child_index'] = $childIndex;

                $flag = M('SystemChannelChild')->add($data);
                if ($flag) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加频道[".$channel['title']."]子表单" . $data["title"] . "成功",2);
                    $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => $type);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加频道[".$channel['title']."]子表单" . $data["title"] . "失败",2);
                    $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
                }

                break;

            case 'child_field':
                $channel = M('SystemChannel')->where("call_index='" . $channelIndex . "'")->find();
                $conf['channel_index'] = $channelIndex;
                $conf['type'] = $type;
                $child = M('SystemChannelChild')->where($conf)->find();

                $this->assign('child', $child);
                $this->assign('channel_title', $channel['channel_title']);
                $this->assign('channel_id', $channel['id']);
                $this->assign('channel', $channelIndex);
                $this->assign('type', $type);
                $this->assign('flow', $flow);
                $this->display("child_field");
                break;

            case "add_field": //生成表
                $frmContent = $_POST['FrmContent'];
                //1. 先将json字段名转为全拼
                $frmContent = urldecode($frmContent);
                $fields = $this->changeFiledToChinese($frmContent);

                //2. 生成频道表
                $tableConfig = $this->getChildTableConfig($channelIndex, $type);
                $conf['call_index'] = $channelIndex;
                $channel = M('SystemChannel')->where($conf)->find();
                $flag = $this->createChannelTable($channel, $type, $fields, $tableConfig);
                if ($flag) {
                    $returnArr = array("result" => 1, "msg" => "配置频道表成功", "code" => 200, "data" => $flag);

                } else {
                    $returnArr = array("result" => 0, "msg" => "配置频道表失败", "code" => 401, "data" => $flag);
                }

                break;

            case "edit_field": //生成表
                $frmContent = $_POST['FrmContent'];
                $flag = $this->editChannelTable($channelIndex, $type, $frmContent);

                if ($flag) {
                    $returnArr = array("result" => 1, "msg" => "修改频道表成功", "code" => 200, "data" => $flag);
                } else {
                    $returnArr = array("result" => 0, "msg" => "修改频道表失败", "code" => 401, "data" => $flag);
                }

                exit(json_encode($returnArr));

                break;

            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
                break;
        }
        json_return($returnArr);
    }

    /*
     * 生成子表名称
     * 格式: channel[base_module] + child['child_index'] + channel[call_index]
     * **/
    private function getChildTableConfig($channelIndex, $type){

        $channel = M('SystemChannel')->where("call_index='".$channelIndex."'")->find();
        $conf['channel_index'] = $channelIndex;
        $conf['type'] = $type;
        $child = M('SystemChannelChild')->where($conf)->find();

        $prefix = get_site_name() . '_';

        $childIndex = $child['child_index'];

        $tableConfig['name'] = strtolower($prefix . $channel['base_module']  . '_' . $childIndex . '_' . $channel['call_index']);
        $tableConfig['format'] = ucfirst($channel['base_module']) . ucfirst($childIndex) . ucfirst($channel['call_index']);

        return $tableConfig;
    }

    public function bindchannelfield($channelIndex)
    {
        $this->display('channel_select_field');
    }

}
