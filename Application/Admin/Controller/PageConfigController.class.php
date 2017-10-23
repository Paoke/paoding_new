<?php
/**
 * Created by PhpStorm.
 * User: leyi
 * Date: 2017/1/17
 * Time: 15:11
 */

namespace Admin\Controller;
use Admin\Util\GetFirstCharterUtil;
use Common\Util\File;
use Think\AjaxPage;
use Think\Log;

class PageConfigController extends BaseController
{
    public function page_config()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $DAO = M('MobileDefinePage');
        C('TOKEN_ON',false);
        $firstChar = new GetFirstCharterUtil();
        switch ($action) {

            case "page_list":
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $list = $DAO->where('deleted=0')->order('create_time')->select();
                $count=$DAO->where("deleted=0")->count();
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页

                $this->assign("page_num",$page_num);
                $this->assign("page_now",$page_now);
                $this->assign("page",$page);
                $this->assign("count",$count);
                $this->assign('list', $list);
                $this->display('page_list');
                break;

            case "page_add":
                $this->display('page_config');
                break;

            case "page_edit":
                $this->assign('edit', 1);
                $this->assign('id', $getId);
                $this->display('page_config');
                break;

            case "add":

                $page['title'] = $_POST['title'];
                $page['call_index'] = $firstChar->getAllChar($page['title']);
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
                $this->saveHtmlFile($page, 'Index', $page['call_index'].'.html');
                break;

            case "edit":

                $page = $DAO->where('id='.$getId)->find();

                $page['title'] = $_POST['title'];
                $page['call_index'] = $firstChar->getAllChar($page['title']);
                $page['html'] = urldecode($_POST['html']);
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

                $state = $DAO->save($page);
                if($state === false){
                    $returnArr = array("result" => 0, "msg" => "修改失败", "code" => 402, "data" => null);
                }else{
                    $returnArr = array("result" => 1, "msg" => "修改成功", "code" => 200, "data" => null);

                }
                $this->saveHtmlFile($page, 'Index', $page['call_index'].'.html');
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

            case "list":


                $condition['is_deleted'] = 0;
                $count = $DAO->where($condition)->count();

                $page_num = I('post.page_num', 8);   //$page_num 每页几条数据
                $page_now = I('post.page_now', 1);   //$page_now 第几页

                $list = $DAO->where($condition)->page($page_now, $page_num)->select();

                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                $data['list'] = $list;
                $data['page'] = $page;

                $returnArr = array("result" => 1, "msg" => "获取数据成功", "code" => 200, "data" => $data);

                break;

            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法");
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


    private function saveHtmlFile($page, $dir='Index', $fileName){

        $file = MODULE_PATH."/Conf/page.html";
        $html = file_get_contents($file);

        $html = str_replace("#title#", $page['title'], $html);
        $html = str_replace("#link#", '', $html);
        $html = str_replace("#style#", '', $html);
        $html = str_replace("#content#", $page['html'], $html);
        $html = str_replace("#script#", '', $html);

        if(!$fileName){
            $fileName = $page['call_index'] . ".html";
        }

        $siteName = get_site_name();
        $fileDir = "Template/$siteName/mobile/$dir";
        $file = $fileDir. '/'. $fileName;

        if(!is_dir($fileDir)){
            mkdir($fileDir, 0777, true);
        }

        file_put_contents($file, $html);
    }

    public function center_page(){

        $action = $_GET["action"];
        $getId = $_GET["id"];
        $DAO = M('MobileCenterTheme');
        C('TOKEN_ON',false);
        switch ($action) {

            case "page_list":

                $where['is_deleted'] = 0;
                $list = $DAO->where($where)->select();


                $this->assign('list', $list);
                $this->display('center_list');
                break;


            case "edit":


                $flag = $this->useNewTheme($getId);
                if($flag === false){
                    $returnArr = array("result" => 0, "msg" => "更新出错", "code" => 403, "data" => null);
                }else{
                    $where['is_deleted'] = 0;
                    //先清除之前选中的主题
                    $DAO->where($where)->setField('is_selected', 0);

                    $where['id'] = $getId;
                    //设定选中的新主题
                    $flag = $DAO->where($where)->setField('is_selected', 1);

                    if($flag === false){
                        $returnArr = array("result" => 0, "msg" => "更新出错", "code" => 402, "data" => null);
                    }else{
                        $returnArr = array("result" => 1, "msg" => "更新成功", "code" => 200, "data" => null);
                    }
                }

                break;

            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法");
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 401, "data" => null);
        }
        json_return($returnArr);


    }

    /**
     * 使用新主题
     * **/
    private function useNewTheme($themeId){

        //获取主题路径
        $theme = M('MobileCenterTheme')->where('id='.$themeId)->find();
        $themePath = $theme['path'];
        $themeUserPath = $themePath . '/User';

        //获取站点模板路径
        $site = get_site_name();
        $config = D('SiteTemplateConfig')->where("site_name='".$site."'")->find();
        $tmplPath = $config['tmpl_path'];
        $userPath = $tmplPath  . '/User';

        //删除静态资源
        $tmplUserStatic = $tmplPath . '/Static/user';
        if(is_dir($tmplUserStatic)){
            $flag = File::delAll($tmplUserStatic);
            if($flag === false){
                Log::write("使用新主题出错，删除静态资源出错！");
                return false;
            }
        }
        //复制静态资源文件
        $themeStatic = $themePath . '/Static';
        if(!is_dir($tmplUserStatic)){
            File::makeDir($tmplUserStatic);
        }
        $flag = File::copyDir($themeStatic, $tmplUserStatic);

        if($flag === false){
            Log::write("使用新主题出错，静态资源错误！");
            return false;
        }

        //删除html文件
        if(is_dir($userPath)){
            $flag = File::delAll($userPath);
        }

        if($flag === false){
            Log::write("使用新主题出错，删除原个人中心文件出错！");
            return false;
        }
        //复制html文件
        if(!is_dir($userPath)){
            File::makeDir($userPath);
        }
        $flag = File::copyDir($themeUserPath, $userPath);

        if($flag === false){
            Log::write("使用新主题出错，复制文件错误！");
            return false;
        }

        return true;
    }


}