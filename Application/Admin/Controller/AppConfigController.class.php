<?php
/**
 * Created by PhpStorm.
 * User: Sing
 * Date: 2016/10/20
 * Time: 14:58
 */

namespace Admin\Controller;


use Think\Exception;
use Think\Log;
use Think\Model;
//应用配置
class AppConfigController extends BaseController
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
     * 全局设置
     */
    public function global_info()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $DAO = M('MobileNavigation');
        switch ($action) {

            case "page_list":
                // 子项
                $nvList = $DAO->where('template_id=1')->getField('navigation_json');
                $nvList = json_decode($nvList, true);

                // 频道
                $chList = M('SystemChannel')->page('1,8')->where('is_active=1')->select();
                $chCount = M('SystemChannel')->where('is_active=1')->count();


                //自定义页面
                $pageList = M('MobileDefinePage')->where('deleted=0')->order('sort')->select();
                $pgCount = M('MobileDefinePage')->where('deleted=0')->count();

                $this->assign('chList', $chList);
                $this->assign('chCount', $chCount);
                $this->assign('nvList', $nvList);
                $this->assign('pgCount', $pgCount);
                $this->assign('pageList', $pageList);

                $this->display('global_info');

                break;

            case "page_add":

                break;

            case "page_edit":

                break;

            case "save":
                //清除原数据
                $DAO -> where('template_id=1') -> delete();

                $json = urldecode($_POST['json']);

                $data['navigation_json'] = $json;
                $data['template_id'] = $_POST['template_id'];

                $state = $DAO -> add($data);

                if($state){
                    $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                }else{
                    $returnArr = array("result" => 0, "msg" => "保存错误", "code" => 402, "data" => $state);
                }

                break;

            case "del":

                break;

            case "gen_temp":
                $html = $_POST['html'];
                $templateId = $_POST['template_id'];
                if($html && $templateId){

                    $html = urldecode($html);
                    $data = M('MobileNavigation')->where("template_id=".$templateId)->find();

                    $json = json_decode($data['navigation_json'], true);
                    $html = $this->addLink($html, $json);

                    $this->getNavigationHtml($html, $data);

                    $this->saveHomePage($html, 'Index', 'index.html');
                    $flag = $this->saveTemplateConfig();
                    if($flag){
                        $this->logRecord(6, "保存设置失败",3);
                        $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                    }else{
                        $this->logRecord(6, "保存设置失败",3);
                        $returnArr = array("result" => 0, "msg" => "保存失败！", "code" => 406, "data" => null);
                    }
                    $this->addNavigation($json, $templateId);
                }else{
                    $this->logRecord(5, "非法参数",-1);
                    $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 405, "data" => null);
                }

                break;

            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
        }
        json_return($returnArr);

    }

    /**
     * 启动页
     */
    public function start_page()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $getData = I("get.");
        $postData = I("post.");
        $start=M("MobileStartPage");

        switch ($action) {

            case "page_list":
                $data=$start->where("sort=1")->find();
                //dump($data);
                $title=$start->where("sort!=1")->select();
                //dump($title);
                $this->assign("title",$title);
                $this->assign("data",$data);
                $this->display('start_page');
                break;

            case "page_add":

                break;

            case "page_edit":

                break;

            case "add":
                //删除原有的数据
                $start->where("1")->delete();
                $json = urldecode($_POST['json']);
                $data = json_decode($json, true);
                //Log::write("数据【".json_encode($data)."】");

                $state = $start->addAll($data);

                if($state){
                    $this->logRecord(6, "添加启动页成功",2);
                    $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                }else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "添加启动页成功",2);
                    $returnArr = array("result" => 0, "msg" => "保存失败", "code" => 402, "data" => null);
                }
                break;

            case "edit":

                break;

            case "del":

                break;

            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
                break;
        }
        json_return($returnArr);

    }

    /**
     * 引导页
     */
    public function guide_page()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $postData=$_POST["id"];
        $guide=M("MobileGuidePage");
        switch ($action) {

            case "page_list":
                $data=$guide->select();
                $this->assign("data",$data);
                $this->display('guide_page');

                break;

            case "page_add":

                break;

            case "page_edit":
                $data=$guide->select();
                $this->assign('data', $data);
                $this->display('guide_page');
                break;

            case "add":
                //删除原有的数据
                    $guide->where("1")->delete();
                   $json = urldecode($_POST['json']);
                   $data = json_decode($json, true);
                   //Log::write("数据【".json_encode($data)."】");

                $state = $guide->addAll($data);

                   if($state){
                       $this->logRecord(6, "添加启动页成功",2);
                       $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);
                   }else {
                       //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                       $this->logRecord(6, "添加启动页失败",2);
                       $returnArr = array("result" => 0, "msg" => "保存失败", "code" => 402, "data" => null);
                   }
                break;

            case "edit":
                $data=I("post.");
                $info=$guide->save($data);
                if($info){
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "修改启动页成功" ,3);
                    $returnArr = array("result" => 1, "msg" => "修改成功", "code" => 200, "data" => null);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6,"修改启动页失败" ,3);
                    $returnArr = array("result" => 0, "msg" => "修改失败", "code" => 402, "data" => null);
                }
                break;

            case "del":

                break;

            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
                break;
        }
        json_return($returnArr);

    }

    /**
     * 水印设置
     */
    public function watermark_info()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        switch ($action) {

            case "page_list":
                $this->display('watermark_info');

                break;

            case "page_add":

                break;

            case "page_edit":

                break;

            case "add":

                break;

            case "edit":
                $model = M('Config');
                $data = I('post.');
                unset($data['__hash__']);

                foreach ($data as $key => $value) {
                    $model->where(array('name' => $key))->data(array('value' => $value))->save();
                }
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(6, "修改水印设置成功",3);
                $returnArr = array("result" => 1, "msg" => "保存成功", "code" => 200, "data" => null);

                break;

            case "del":

                break;

            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "网络繁忙，请重试", "code" => 402, "data" => null);
                break;
        }
        json_return($returnArr);

    }



    private function saveHomePage($html, $dir='Index', $fileName='index.html'){

        try{
            $siteName = get_site_name();
            $fileDir = "Template/$siteName/mobile/$dir";
            $file = $fileDir. '/'. $fileName;

            if(!is_dir($fileDir)){
                mkdir($fileDir, 0777, true);
            }

            file_put_contents($file, $html);
            return true;
        }catch(\Exception $e){
            return false;
        }
    }

    private function addLink($html, $data){

        foreach($data as $item){
            $link = "#";
            if($item['is_home'] == 1){
                $link = "__APP__/mobile";
            }else{
                if($item['item_type'] == 1){
                    $link = "__APP__/Api/ChannelPage/index/id/" . $item['link_id'];
                }else if($item['item_type'] == 2){
                    $link = "__APP__/Mobile/Index/page/id/" . $item['link_id'];
                }else if($item['item_type'] == 3){
                    $link = $item['link_to'];
                }
            }

            $search = '#'.$item['title'].'#';
            $html = str_replace($search, $link, $html);

        }

        return $html;
    }


    private function saveTemplateConfig(){

        $siteName = get_site_name();
        if($siteName){
            //先删除站点记录
            $DAO = D('SiteTemplateConfig');
            $DAO->where("site_name='".$siteName."'")->delete();

            $config['site_name'] = $siteName;
            $config['tmpl_type'] = 1;
            $config['tmpl_path'] = "Template/$siteName/mobile";
            $config['view_path'] = "./Template/$siteName/";
            $config['default_theme'] = "mobile";
            $config['tmpl_parse_string_static'] = "/Template/$siteName/mobile/Static";

            $DAO->add($config);
            return true;
        }

        return false;
    }

    private function getNavigationHtml($html,$data){

        //footer
        $patten = '%<footer.*?>(.*?)</footer>%si';
        preg_match($patten, $html, $match);

        $footer = $match[0];
        $data['navigation_html'] = $footer;
        //script
        $patten = '%<script.*?>(.*?)</script>%si';
        preg_match_all($patten, $html, $matchs);

        $script = "";
        foreach($matchs[0] as $key=>$item){
            $script .= $item;
        }
        $data['navigation_js'] = $script;
        //css
        $patten = '/<link.*?>/is';
        preg_match_all($patten, $html, $matchs);

        $link = "";
        foreach($matchs[0] as $key=>$item){
            $link .= $item;
        }

        $patten = '%<style.*?>(.*?)</style>%si';
        preg_match($patten, $html, $match);
        $style = $match[0];

        $css = $link . $style;
        $data['navigation_css'] = $css;

        M('MobileNavigation')->save($data);
    }

    private function addNavigation($data, $templateId){

        $site = get_site_name();
        $config = D('SiteTemplateConfig')->where("site_name='".$site."'")->find();
        $tmplPath = $config['tmpl_path'];

        $navigation = M('MobileNavigation')->where('template_id='.$templateId)->find();

        $html = $navigation['navigation_html'];
        $i = 0;
        foreach($data as $item){

            if($item['is_home'] == 0){
                if($item['item_type'] == 1){
                    $channel = M('SystemChannel')->where('id='.$item['link_id'])->find();

                    $file = $tmplPath . '/' . $channel['base_module'] . '/' . $channel['call_index'] . '_list.html';
                    $html = file_get_contents($file);

                    $html = str_replace('</head>', $navigation['navigation_css'].'</head>', $html);
                    $footer = $this->chooseNavigation($navigation['navigation_html'], ($i+1));

                    $html = str_replace('</body>', $footer.'</body>', $html);
                    $html = str_replace('</html>', $navigation['navigation_js'].'</html>', $html);

                    file_put_contents($file, $html);

                }else if($item['item_type'] == 2){
                    $page = M('MobileDefinePage')->where('id='.$item['link_id'])->find();

                    $file = $tmplPath . '/Index/' . $page['call_index'] . '.html';
                    $html = file_get_contents($file);

                    $html = str_replace('</head>', $navigation['navigation_css'].'</head>', $html);
                    $footer = $this->chooseNavigation($navigation['navigation_html'], ($i+1));
                    $html = str_replace('</body>', $footer.'</body>', $html);

                    $addScript = '$(".form-horizontal").css("margin-bottom","50px");</script>';

                    $script = str_replace("</script>", $addScript, $navigation['navigation_js']);

                    $html = str_replace('</html>', $script.'</html>', $html);

                    file_put_contents($file, $html);
                }
            }

            $i++;
        }

    }

    private function chooseNavigation($footer, $len){

        //1. 去掉原来选中的class[aui-active]
        $html = str_replace("aui-active", '', $footer);

        //2. 在指定位置加class[aui-active]
        $pos = 0;

        for($i=0; $i<$len; $i++){
            $pos += 1;
            $pos = strpos($html, 'aui-bar-tab-item', $pos);
            $pos += strlen('aui-bar-tab-item');
            if($i == ($len-1)){
                $begin = substr($html, 0, $pos);
                $end = substr($html, $pos, strlen($html));

                $html = $begin . ' aui-active' . $end;
                return $html;
            }
        }
        return $html;
    }

}