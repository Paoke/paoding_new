<?php
/**
 * tpshop
 * ============================================================================
 * * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: IT宇宙人 2015-08-10 $
 */ 
namespace Site\Controller;
use Think\Controller;
use Think\Model;
use Think\Log;

class IndexController extends BaseController {
    public function index(){

        //加载模板分类
        $Model = D('TemplateCat');
        $data = $Model -> order('sort_order') ->field('cat_id, cat_name, parent_id, sort_order, cat_icon, cat_cover') -> select();
        $this->assign('cat_list', $data);
        $this->display();
    }

    public function step2(){
        $this->display();
    }

    public function step3(){
        //加载当前分类的模板列表
        $PCatId = trim($_POST['catid']);
        $catId = trim($_GET['catid']) == '' ? $PCatId : trim($_GET['catid']);
        if($catId){
            $Template = D('Template');
            $tmplList = $Template -> where("cat_id=$catId") -> order('orders') -> field('id, title, description, image, orders, cat_id, cat_name, real_price, trail_price') -> select();
            if($PCatId){
                Log::write("catid[$PCatId], sql[".$Template->getLastSql()."], tmpl list count[".count($tmplList)."]");
                echo json_encode($tmplList);
                exit;
            }

            $this->assign('tmpl_list', $tmplList);
        }
        $this->assign('current', $catId);

        //加载模板分类
        $catList = D('TemplateCat') -> order('sort_order') ->field('cat_id, cat_name, parent_id, sort_order, cat_icon, cat_cover') -> select();
        $this->assign('cat_list', $catList);

        $this->display();
    }

    public function step4(){

        $tmplId = $_GET['tmpl_id'];
        $vo = $this->getTemplate($tmplId);
        $this->assign('vo', $vo);
        $this->display();
    }

    public function step5(){
        $tmplId = $_GET['tmpl_id'];
        $type = $_GET['type'];
        $vo = $this->getTemplate($tmplId);
        $vo['buy_type'] = $type;
        if($type == 1){
            $vo['cost'] = $vo['real_price'];
        }else{
            $vo['cost'] = $vo['trail_price'];
        }

        $this->assign('vo', $vo);
        $this->display();
    }

    private function getTemplate($id){
        if($id){
            $Template = D('Template');
            $data = $Template -> where("id=$id") -> select();
            $vo = $data[0];
            return $vo;
        }
    }

    public function checkSite(){

        $siteName = $_POST['site_name'];
        if($siteName){
            $Model = D('TemplateSellRecord');
            $count = $Model -> where("site_name='$siteName'") -> count();

            if($count > 0){
                exit(json_encode(1));
            }
        }
        exit(json_encode(0));
    }

    public function buy(){
        $siteName = trim($_POST['site_name']);
        $mobile = trim($_POST['mobile']);
        if($siteName=='' || $mobile=='' ){
            $this->display('error');
            exit;
        }
        $data['order_id'] = 'GM' . get_rand_str(6, 1, 1);
        $data['cost'] = trim($_POST['cost']);
        $data['status'] = 0;
        $data['template_id'] = trim($_POST['template_id']);
        $data['buy_time'] = date("Y-m-d H:i:s",time());
        $data['buy_type'] = trim($_POST['buy_type']);
        $data['user'] = trim($_POST['user']);
        $data['mobile'] = $mobile;
        $data['company'] = trim($_POST['company']);
        $data['site_name'] = $siteName;
        $data['create_time'] = date("Y-m-d H:i:s",time());

        $Model = D('TemplateSellRecord');
        $count = $Model -> where("site_name='$siteName'") -> count();

        if($count > 0){
            //错误页面
            $this->display('error');
            exit;
        } else {
            $Model->data($data)->add();
            $this->display('success');
        }

    }

}