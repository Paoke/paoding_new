<?php

namespace Admin\Controller;
use Think\AjaxPage;
use Think\Log;

class ChannelConfigController extends BaseController
{

    /*
     * 页面配置
     * */
    public function page_config()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $DAO = M('MobileChannelPage');
        C('TOKEN_ON',false);
        switch ($action) {

            case "page_list":
                $list = $DAO->where('deleted=0')->order('create_time')->select();
                $this->assign('list', $list);
                $this->display('page_list');
                break;

            case "system_page_add":
                $this->display('system_page_config');
                break;

            case "page_edit":
                $imgid = $DAO->where("deleted=0 AND id = '$getId'")->getField("default_id");
                $this->assign('edit', 1);
                $this->assign('imgid', $imgid);
                $this->assign('id', $getId);
                $this->display('system_page_config');
                break;

            case "system_page_info":
                $this->display('system_page_info');
                break;

            case "add":

                $page['title'] = $_POST['title'];
                $page['html'] = urldecode($_POST['html']);
                $page['used_time'] = 0;
                $page['create_time'] = date('Y-m-d H:m:s', time());
                $page['deleted'] = 0;
                $form_data = $_POST['form_data'];

                $data_json = "[";
                foreach($form_data as $key=>$item){
                    $title = $item['title'];
                    $data = $item['data'];
                    $component = M('MobileComponentJson')->where("title='".$title."'")->find();
                    $template = $component['json'];


                    foreach ($data as $d) {
                        $mark = "<%".$d['name']."%>";
                        $val = $d['value'];

                        $template = str_replace($mark, $val, $template);
                    }

                    $data_json .= $template . ",";
                }
                $data_json = rtrim($data_json, ',');
                $data_json .= "]";

                $page['data_json'] = $data_json;

                $id = $DAO->add($page);
                if($id){
                    $returnArr = array("result" => 1, "msg" => "新增成功", "code" => 200, "data" => $id);
                }else{
                    $returnArr = array("result" => 0, "msg" => "新增错误", "code" => 402, "data" => null);
                }

                break;

            case "edit":

                $page = $DAO->where('id='.$getId)->find();
                $channel = $page['channel'];
                $page['title'] = $_POST['title'];
                $page['html'] = urldecode($_POST['html']);
                $form_data = $_POST['form_data'];
                foreach($form_data as $key=>$item){
                    $title = $item['title'];
                    $data = $item['data'];
                    foreach ($data as $d) {
                        $val = $d['value'];
                        $field[] =$val;
                    }

                }
                $fieldstr = implode(",", $field);
                $page['used_field'] = $fieldstr;
                $state = $DAO->save($page);
                $h = M("MobileHtmlFixed")->where("id = 1")->find();
                $list_html = $h['html_start'].$page['html']. $h['html_end'];
                $base_module = M("SystemChannel")->where("call_index = '$channel'")->getField("base_module");
                $this->saveHtmlFile($list_html, $base_module, $channel.'_list.html');

                if($state === false){
                    $returnArr = array("result" => 0, "msg" => "修改失败", "code" => 402, "data" => null);
                }else{
                    $returnArr = array("result" => 1, "msg" => "修改成功", "code" => 200, "data" => null);

                }

                break;

            case "info":

                $data = $DAO->where('id='.$getId)->find();

                if($data['data_json']){
                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $data['data_json']);
                }else{
                    $returnArr = array("result" => 0, "msg" => "获取失败", "code" => 404, "data" => null);
                }
                break;

            case "del":

                $state = $DAO->where('id='.$getId)->delete();
                if($state){
                    $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200, "data" => null);
                }else{
                    $returnArr = array("result" => 0, "msg" => "删除失败", "code" => 403, "data" => null);
                }
                break;

            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 401, "data" => null);
        }
        json_return($returnArr);
    }

    /*
     * 测试列表配置
     * */
    public function ceshi_list()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $channel = $_GET["channel"];
        switch ($action) {
            case "page_list":
                $html = M("MobileChannelPage")->where("channel = '$channel'") ->getField("html");

                $this->assign('page_html',$html);
                $this->assign('channel',$channel);
                $base_module = M("SystemChannel")->where("call_index = '$channel'")->getField("base_module");
                $url = './Template/5u/mobile/'.$base_module.'/'.$channel.'_list.html';
                $this->display($url);
                break;
            //列表
            case "list":
              
                $fieled = M("MobileChannelPage")->where("channel = '$channel'") ->getField("used_field");
                if($fieled == NULL){
                    $fieled = 'create_user,create_time,title,desc';
                }
                $tableName = M("SystemChannelTableConfig")->where("channel = '$channel'AND type=1")->getField("table_format");
                $info = M("$tableName")->field("id,cover_url,$fieled")->select();
                $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 401, "data" => null);
        }
        json_return($returnArr);
    }


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

    //生成html和文件目录
    private function saveHtmlFile($html, $dir='Index', $fileName='index.html'){

        $siteName = get_site_name();
        $fileDir = "Template/$siteName/mobile/$dir";
        Log::write("保存路径: ".$fileDir);
        $file = $fileDir. '/'. $fileName;
        Log::write("保存文件[".$file."]");

        if(!is_dir($fileDir)){
            mkdir($fileDir, 0777, true);
        }

        file_put_contents($file, $html);
    }
}