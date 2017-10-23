<?php
/**
 * Created by PhpStorm.
 * User: 吴邦
 * Date: 2016/7/27
 * Time: 18:27
 */
namespace Mobile\Controller;

header("Content-Type: text/html;charset=utf-8");

class WorkEnrollController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        parent::checkMp();
    }

    /**
     * 初始化操作
     */
    public function _initialize()
    {
        parent::_initialize();
    }


    /**
     * 活动报名发布
     */
    public function release()
    {
        $this->display();
    }

    /**
     * 我的工作
     */
    public function my_work()
    {
        $user_id = $this->user_id;
        //我的工作  -  已报名的工作信息与用户可以操作的信息
        $info = M()->table('__REGISTER_ORDER__ ro')
            ->join('__REGISTER__ r')->join("__MANAGE_USERS__ u")
            ->field('r.id,r.title,r.img_url,r.salary,r.salary_type,r.start_time,r.end_time,r.work_start_time,r.work_end_time,ro.order_id,ro.order_status,ro.enroll_time')
            ->where("ro.user_id=$user_id AND u.user_id=$user_id AND ro.user_id=u.user_id
             AND r.id=ro.register_id")
            ->select();
        foreach ($info as $item => $value) {
            //未被录取的
            if ($info[$item]['order_status'] == 1) {
                //已报名,但未被录取的
                if (strtotime($info[$item]['end_time']) > time()) {
                    $info[$item]['status'] = "1";
                }
                //已报名,未被录取,且已过报名时间
                if (strtotime($info[$item]['end_time']) < time()) {
                    $info[$item]['status'] = "2";
                }
            }

            //被录取的
            if ($info[$item]['order_status'] == 2) {
                //未过报名时间，但已报名,且被录取的,等待工作
                if (strtotime($info[$item]['work_start_time']) > time()) {
                    $info[$item]['status'] = "3";
                }

                //已报名,且被录取的,工作中
                if (strtotime($info[$item]['work_start_time']) < time()) {
                    $info[$item]['status'] = "4";
                }

                //已报名,且被录取的,工作结束，等待评价
                if (strtotime($info[$item]['work_end_time']) < time()) {
                    $info[$item]['status'] = "5";
                    $info[$item]['answer'] = "0";
                }

            }

            //取消报名
            if ($info[$item]['order_status'] == 0) {
                //取消了报名时间未过，可以再报名
                if (strtotime($info[$item]['end_time']) > time()) {
                    $info[$item]['status'] = "6";
                }
                //取消了报名时间过了，不可以再报名
                if (strtotime($info[$item]['end_time']) < time()) {
                    $info[$item]['status'] = "7";
                }

            }
        }

        $this->assign('info', $info);//显示用户报名了的工作
        $this->display();
    }

    //统计用户的工作数量
    public function my_work_count()
    {
        $user_id = $this->user_id;
        //查询用户报名了的工作数量
        $s_count = M()->table('__REGISTER_ORDER__ ro')->field("ro.user_id")->join('__REGISTER__ r')->where("ro.user_id=$user_id AND r.id=ro.register_id AND order_status=1 AND end_time>now()")->count();
        //查询用户报名了被录取的工作数量
        $i_count = M()->table('__REGISTER_ORDER__ ro')->field("ro.user_id")->join('__REGISTER__ r')->where("ro.user_id=$user_id AND r.id=ro.register_id AND ro.order_status=2 AND r.work_start_time<=now() AND r.work_end_time>=now()")->count();
        //查询用户工作结束后的工作数量
        $e_count = M()->table('__REGISTER_ORDER__ ro')->field("ro.user_id")->join('__REGISTER__ r')->where("ro.user_id=$user_id AND r.id=ro.register_id AND ro.order_status=2 AND r.work_end_time<now()")->count();
        $data = array('s_count' => $s_count, 'i_count' => $i_count, 'e_count' => $e_count);
        return $data;
    }

    public function my_work_action()
    {
        $action = $_POST['action'];
        switch ($action) {
            case 'cancle':
                $id = $_POST['id'];
                $data['order_status'] = 0;
                $res = M('register_order')->where("order_id=$id")->save($data);
                if ($res) {
                    $return_arr = array('status' => 1, 'msg' => '已取消', 'data' => M()->getError());
                    exit(json_encode($return_arr));
                } else {
                    $return_arr = array('status' => -1, 'msg' => '网络繁忙，请重试', 'data' => M()->getError());
                    exit(json_encode($return_arr));

                }
                break;
            case 'add':
                $id = $_POST['id'];
                $data['order_status'] = 1;
                $res = M('register_order')->where("order_id=$id")->save($data);
                if ($res) {
                    $return_arr = array('status' => 1, 'msg' => '报名成功', 'data' => M()->getError());
                    exit(json_encode($return_arr));
                } else {
                    $return_arr = array('status' => -1, 'msg' => '网络繁忙，请重试', 'data' => M()->getError());
                    exit(json_encode($return_arr));

                }
                break;
            default:
                $return_arr = array('status' => -1, 'msg' => '操作有误，请联系客服', 'data' => M()->getError());
                exit(json_encode($return_arr));
        }

    }

    //手机端工作搜索
    public function word_search($str)
    {
//        //判断搜索的是否为空，为空的话则显示全部内容
//        if (empty($str)) {
//            $where = '1=1';
//            //查询工作信息sql语句，通如果查询字段为空，查则查询工作表的信息，并按报名信息添加的最新时间排列，
//            //并且查询到的工作信息都是没有达到报名截止日期
////            $sql = "SELECT * FROM __PREFIX__register WHERE $where AND title LIKE '%$str%' AND end_time>now()";
//            $sql = "SELECT r.*,rd.id rd_id,rd.title rd_title,rc.id rc_id,rc.title rc_title FROM __PREFIX__register r LEFT JOIN __PREFIX__register_department rd ON r.register_department_id=rd.id LEFT JOIN __PREFIX__register_category rc ON r.register_category_id=rc.id WHERE $where AND r.end_time>now()";
//            $search_info = M()->query($sql);
//            return $search_info;
//        }
        $where = '1=1';
        //查询工作信息sql语句，通过搜索的字符串，查询报名表的title，公司表的title，岗位表的title，分类表的title，
        //并且查询到的工作信息没有达到报名截止日期
        $sql = "SELECT r.*,rd.id rd_id,rd.title rd_title,rc.id rc_id,rc.title rc_title FROM __PREFIX__register r LEFT JOIN __PREFIX__register_department rd ON r.register_department_id=rd.id LEFT JOIN __PREFIX__register_category rc ON r.register_category_id=rc.id LEFT JOIN __PREFIX__register_spec rs ON r.register_spec_id=rs.id WHERE $where AND r.title LIKE '%$str%' OR  rd.title LIKE '%$str%' OR rc.title LIKE '%$str%' OR rs.title LIKE '%$str%'";
        $search_info = M()->query($sql);
//        var_dump($str);
//        var_dump($search_info);exit;
        return $search_info;
    }

    //工作分类查询搜索
    public function fl_search($son_id)
    {
//        //判断搜索的是否为空  如果为空
//        if (empty($son_id)) {
//            $return_arr = array("status" => -1, "msg" => "很抱歉，查询失败", "data" => M()->getError());
//            $this->ajaxReturn($return_arr);
//        } else {
        $where = "1=1";
        $sql = "SELECT r.id,r.title,r.salary,r.salary_type,r.need_num,r.img_url,rd.title rd_title,rc.title rc_title FROM __PREFIX__register r LEFT JOIN __PREFIX__register_department rd ON r.register_department_id=rd.id LEFT JOIN __PREFIX__register_category rc ON r.register_category_id=rc.id WHERE $where AND r.register_spec_id=$son_id AND r.is_deleted!=1";
        $search_info = M()->query($sql);
        return $search_info;
//        }
    }

    /**
     * 活动报名
     */
    public function work_enroll()
    {
        //活动报名的详情页
        $id = I('get.id');
        M('register')->where('id=' . $id)->setInc('num');//增加浏览量
        $user_id = $this->user_id;
        //判断是否登录，如果未登录，则查询该条工作信息，如果登录了，则显示对应的工作信息（我的报名）按钮，是否已报名或者已被录取。
        if ($user_id == 0 || $user_id == null) {
            $info = M()->table("__REGISTER__ r")->field("r.*")->where("r.id=$id")->find();
            $info['order_status'] = 0;
        } else {
            $res = M("register_order")->field("order_id")->where("user_id=$user_id AND register_id=$id")->find();
            if (!$res) {
                $info = M()->table("__REGISTER__ r")->field("r.*")->where("r.id=$id")->find();
                $info['order_status'] = 0;
            } else {
                $info = M()->table("__REGISTER__ r")->join("__REGISTER_ORDER__ ro")->field("r.*,ro.order_status")->where("r.id=$id AND ro.user_id=$user_id AND ro.register_id=$id")->find();
            }
        }
        $count = M()->table('__MANAGE_ADMIN__ ad')->join('__REGISTER__ r')->where('r.create_user_id=ad.admin_id AND r.is_deleted!=1')->count();
        $info['info'] = $count;
        $this->assign('info', $info);
        $this->display();
    }

    //添加用户报名了得工作信息
    public function add_work_enroll()
    {
        //判断用户是否登录，如果未登录，则提示不让继续操作
        $rid = I('post.id');
        $uid = I('post.uid');
        if (empty($uid)) {
            $this->redirect("Mobile/Login/login");
        } else {
            //在register表中查找对应数据，将相同的数据录入数据到register_order表中
            $r = M('register')->where('id=' . $rid)->find();
            $user = M('ManageUsers')->where('user_id=' . $uid)->find();
            $data['order_sn'] = date('YmdHis', time()) . mt_rand(1000, 9999);
            $data['user_id'] = $uid;
            $data['register_id'] = $rid;
            $data['order_status'] = 1;
            $data['amount'] = $r["salary"];
            $data['enroll_time'] = date("Y-m-d H:i:s", time());
            //查询到报名表中用户是否报名报名信息
            $ro_isset = M('register_order')->where("user_id=$uid AND register_id=$rid")->find();

            if ($ro_isset) {
                if ($ro_isset['order_status'] == 0) {
                    $ro_isset['order_status'] = 1;
                    $res = M('register_order')->save($ro_isset);
                    if ($res) {
                        $return_arr = array('status' => 1, 'msg' => '报名成功', 'data' => M()->getError());
                        exit(json_encode($return_arr));
                    } else {
                        //当ajax提交失败时，返回失败的数据
                        $return_arr = array('status' => -1, 'msg' => '系统繁忙，请重试', 'data' => M()->getError());
                        exit(json_encode($return_arr));
                    }
                } elseif ($ro_isset['order_status'] == 2) {
                    //如已报名，则显示 - 您已报名成功
                    $return_arr = array('status' => 2, 'msg' => '您已报名成功', 'data' => M()->getError());
                    exit(json_encode($return_arr));
                }

            } else {
                //如未报名，则显示 - 报名成功
                $res = M('register_order')->add($data);
                if ($res) {
                    $ro = M('register_order')->field('register_id')->where("order_id=$res")->find();
                    M('register')->where('id=' . $ro['register_id'])->setInc('all_num');
                    $return_arr = array('status' => 1, 'msg' => '报名成功', 'data' => M()->getError());
                    exit(json_encode($return_arr));
                } else {
                    //当ajax提交失败时，返回失败的数据
                    $return_arr = array('status' => -1, 'msg' => '系统繁忙，请重试', 'data' => M()->getError());
                    exit(json_encode($return_arr));
                }
            }

        }
    }

    /*
     * 手机端工作行程显示
     */
    public function getWorkItinerary()
    {
        $user_id = $this->user_id;
        $sql = "SELECT r.id,r.title,r.work_start_time,ro.order_id,ro.add_time FROM __PREFIX__register r LEFT JOIN __PREFIX__register_order ro ON r.id=ro.register_id WHERE ro.user_id=$user_id AND ro.order_status=2";
        $info = M()->query($sql);
        return $info;
    }

    /**
     * 管理活动
     */
    public function manage_activity()
    {
        $this->display();
    }

    /**
     * 管理报名
     */
    public function manage_enroll()
    {
        $this->display();
    }

    /**
     * 管理报名设置
     */
    public function manage_enroll_set()
    {
        $this->display();
    }

}