<?php
/**
 * Created by PhpStorm.
 * User: huanggui
 */

namespace Mobile\Controller;
use Think\Log;
class CompanyController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        parent::checkUrl();
    }

    /*
     * 数据列表
     */
    public function data_list(){
        $channel=$_GET['channel'];
        $this->assign("channel", $channel);
        $this->display($channel."_list");
    }

    /*
     * 详细数据
     */
    public function detail(){

        $channel=$_GET['channel'];
        $data_id = $_GET["data_id"];
        $this->assign("data_id", $data_id);
        $this->assign("channel", $channel);
        $wechatData = $this->getWxParameter();
        $this->assign("wecaht_data", $wechatData);
        $this->display($channel."_detail");
    }

    /*
     * 新增数据
     */
    public function add(){
        $channel=$_GET['channel'];
        $data_id = $_GET["data_id"];
        $this->assign("data_id", $data_id);
        $this->assign("channel", $channel);
        $this->display($channel."_add");
    }

    /*
    * 编辑数据
    */
    public function edit(){
        $channel=$_GET['channel'];
        $data_id = $_GET["data_id"];
        $this->assign("data_id", $data_id);
        $this->assign("channel", $channel);
        $this->display($channel."_edit");
    }

    /*
     * 删除数据
     */
    public function del(){
        $channel=$_GET['channel'];
        $data_id = $_GET["data_id"];
        $this->assign("data_id", $data_id);
        $this->assign("channel", $channel);
        $this->display($channel."_del");
    }

    /*
     * 查询数据
     */
    public function search(){
        $search = $_POST['search'];
        $is_search = $_GET['is_search'];
        $city = $_GET['city'];
        $tagId = $_GET['tag_id'];
        $channel=$_GET['channel'];
        $this->assign('city',$city);
        $this->assign('is_search',$is_search);
        $this->assign("search",$search);
        $this->assign('tag_id',$tagId);
        $this->assign("channel", $channel);
        $this->display($channel."_search");
    }

    /*
     * 获取新闻
     */
    public function news_list(){
        $data_id = $_GET["data_id"];
        $channel=$_GET['channel'];
        $this->assign("channel", $channel);
        $this->assign("data_id", $data_id);
        $this->display($channel."_news_list");
    }

    /*
     * 获取招聘职位
     */
    public function job_list(){
        $channel=$_GET['channel'];
        $this->assign("channel", $channel);
        $this->assign("data_id", $_GET["data_id"]);
        $this->display($channel."_job_list");
    }

    /*
    * 获取招聘职位详细
    */
    public function job_detail(){
        $channel=$_GET['channel'];
        $this->assign("channel", $channel);
        $wechatData = $this->getWxParameter();
        $this->assign("wecaht_data", $wechatData);
        $this->assign("data_id",  $_GET["data_id"]);
        $this->assign("company_id",  $_GET["company_id"]);
        $this->display($channel."_job_detail");
    }

    /*
    * 获取招聘职位查询结果
    */
    public function job_search(){
        $keyword = $_GET["keyword"];
        $data_id = $_GET["data_id"];
        $channel=$_GET['channel'];
        $this->assign("channel", $channel);
        $this->assign("data_id", $data_id);
        $this->assign("keyword", $keyword);
        $this->display($channel."_job_search");
    }

    /*
    * 企业用户个人中心
    */
    public function user_center()
    {
        $account = session('company_account');
        $this->assign('channel', $account['channel']);
        $this->display();
    }

    public function user_fans()
    {
        $account = session('company_account');
        $this->assign('channel', $account['channel']);
        $this->display();
    }

    public function user_login(){
        $channel = $_GET['channel'];
        if(!$channel){
            $account = session('company_account');
            if($account){
                $channel = $account['channel'];
            }
        }
        $this->assign('channel', $_GET['channel']);
        $this->display();
    }

    public function user_info(){
        $account = session('company_account');
        $where['channel_index'] = $account['channel'];
        $where['user_id'] = $account['user_id'];
        $dataId = M('SystemRelation')->where($where)->getField('data_id');
        $this->assign('channel', $account['channel']);
        $this->assign('company_id', $dataId);
        $this->display();
    }

    public function user_tags(){
        $account = session('company_account');
        $this->assign('channel', $account['channel']);
        $this->display();
    }

    public function user_file(){
        $account = session('company_account');
        $this->assign('channel', $account['channel']);
        $this->assign('id', $account['data_id']);
        $this->display();
    }

    public function user_register(){
        $this->assign('channel', $_GET['channel']);
        $this->display();
    }

    public function user_reset_pw(){
        $this->assign('channel', $_GET['channel']);
        $this->display();
    }

    public function user_update_pw(){
        $account = session('company_account');
        $this->assign('channel', $account['channel']);
        $this->display();
    }

    //动态详情
    public function company_news()
    {
        $account = session('company_account');
        $this->assign('channel', $account['channel']);
        $this->assign('company_id', $account['data_id']);
        $this->display();
    }

    //发布动态
    public function publish_news()
    {
        $channel = $_GET['channel'];
        $this->assign('channel',$channel);
        $account = session('company_account');
        $this->assign('channel', $account['channel']);
        $this->assign('company_id', $account['data_id']);
        $this->display();
    }

    //发布动态
    public function ztxz()
    {
        $account = session('company_account');
        $this->assign('channel', $account['channel']);
        $this->display();
    }
//    //招聘
//    public function recruit()
//    {
//        $this->assign('channel','qygl');
//        $userType = session('user_type');
//        $this->assign('user_type', $userType);
//        $this->display();
//    }
//
    public function company_recruit()
    {
        $account = session('company_account');
        $this->assign('channel', $account['channel']);
        $this->assign('data_id', $account['data_id']);
        $this->display();
    }

//    //发布招聘
    public function publish_recruit()
    {

        $account = session('company_account');
        $this->assign('channel', $account['channel']);
        $this->assign('company_id', $account['data_id']);
        $this->display();
    }

    //公司对应下的招聘列表
//    public function recruit_list()
//    {
//        $channel = $_GET['channel'];
//        $this->assign('channel',$channel);
//        $companyId = $_GET['company_id'];
//        $parentId = $_GET['parent_id'];
//        $secondLevelId = $_GET['second_level_id'];
//        $this->assign("company_id",$companyId);
//        $this->assign("parent_id",$parentId);
//        $this->assign("second_level_id",$secondLevelId);
//        $this->display();
//    }
//
//    //公司对应下的招聘列表
//    public function company_recruit_list()
//    {
//        $channel = $_GET['channel'];
//        $this->assign('channel',$channel);
//        $parentId = $_GET['parent_id'];
//        $secondLevelId = $_GET['second_level_id'];
//        $this->assign("parent_id",$parentId);
//        $this->assign("second_level_id",$secondLevelId);
//        $this->assign("company_id", session('company_account')['data_id']);
//        $this->display();
//    }
//
//    //招聘详情
//    public function recruit_info()
//    {
//        $channel = $_GET['channel'];
//        $this->assign('channel',$channel);
//        $recruitId = $_GET['recruit_id'];
//        $channel = $_GET['channel'];
//        $compayTable = M("SystemChannelTableConfig")
//            ->where("channel= '$channel' AND type=6")
//            ->getField("table_format");
//        $companyId = M($compayTable)
//            ->where("id = $recruitId")
//            ->getField("data_id");
//        $this->assign("recruit_id",$recruitId);
//        $this->assign("company_id",$companyId);
//        $this->display();
//    }
}


