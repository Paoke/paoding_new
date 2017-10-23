<?php
/**
 * Created by PhpStorm.
 * User: lsh
 * Date: 2016/7/28
 * Time: 11:48
 */

namespace Mobile\Controller;
header("Content-Type: text/html;charset=utf-8");

include "wechatAply.class.php"; //加载php接口调用插件
class ActivityEnrollController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        parent::checkSite();
        parent::checkMp();
    }
    /*
     *  活动列表
     * */
    public function activity_detail()
    {
        $id = I('get.id');

        $sche_list = M('Activity_schedule')->where(array('is_deleted' => 0, 'order_prom_id' => $id))->order('create_time asc')->select();
        $list['content'] = html_entity_decode($list['content']);
        $list['booking_notes'] = html_entity_decode($list['booking_notes']);
        $list['special_restriction'] = html_entity_decode($list['special_restriction']);
        foreach ($sche_list as $key => $value) {
            $sche_list[$key]['content'] = html_entity_decode($sche_list[$key]['content']);
        }
        $this->assign('list', $list);
        $this->assign('sche_list', $sche_list);
        // var_dump($sche_list);exit;
        $this->display('activity_detail');
    }

    /*
     *  l.sh 活动报名 ：半接口
     * */
    public function activity_sign()
    {
        $user = session('user');//获取用户信息

        if (I('POST.')) { //提交报名
            $id = I('POST.order_prom_id');
            //获得活动信息
            $list = M('Activity')->where(array('is_deleted' => 0, 'id' => $id))->find();
            //整理信息存储在$data 插入activity_order;
            $data = I('POST.');
            // unset($data['order_prom_id']);
            $data['order_sn'] = time() . rand(1000, 9999);
            $data['user_id'] = $user['user_id'];
            $data['order_status'] = 0;  //订单状态 待确认
            $data['pay_status'] = 0;    //支付状态 已支付
            $data['pay_code'] = 'weixin';
            $data['pay_name'] = '微信支付';
            $data['pay_time'] = time();
            $data['add_time'] = time();
            $data['goods_price'] = $list['sell_price'] ? $list['sell_price'] : 0; //商品总价
            $data['order_amount'] = $data['goods_price']; // 应付金额
            $data['goods_price'] = $data['goods_price']; // 商品总价
            $data['shipping_price'] = 0; //物流费
            $data['total_amount'] = $data['goods_price']; // 订单总价


            $activity_order_id = M('Activity_order')->data($data)->add();
            //整理信息存储在$data_2 插入activity_order_goods;
            if ($activity_order_id) {
                $data_2['order_id'] = $activity_order_id;
                $data_2['goods_id'] = $id;
                $data_2['goods_name'] = $list['title'];
                $data_2['goods_sn'] = '';
                $data_2['goods_num'] = 1;
                $data_2['market_price'] = $list['market_price'] ? $list['market_price'] : 0;
                $data_2['goods_price'] = $list['sell_price'] ? $list['market_price'] : 0;
                $res = M('Activity_order_goods')->data($data_2)->add();
            }
            if ($res) {

                $json['status'] = 1;
                $json['msg']['title'] = '报名成功';
                $json['msg']['id'] = $activity_order_id;
                echo json_encode($json);
                exit;
            } else {
                $json['status'] = 0;
                $json['msg']['title'] = '请填写姓名、电话号码';
                echo json_encode($json);
                exit;
            }
        } else {
            $user['order_prom_id'] = I('get.id');
            $this->assign('list', $user);
            $this->display('activity_sign');
        }
    }

    /*
     *  我的活动列表  
     * */
    public function my_activity()
    {
        $user = session('user');
        $user_id = $user['user_id'];
        $Activity_order_goods = M('Activity_order_goods');
        $Activity = M('Activity');
        $res = M('Activity_order')->where(array('user_id' => $user_id))->select();
        foreach ($res as $key => $value) {
            $id = $value['order_id'];
            $res[$key]['activity_order_goods'] = $Activity_order_goods->where(array('order_id' => $id))->find();
            $goods_id = $res[$key]['activity_order_goods']['goods_id'];
            $res[$key]['activity'] = $Activity->where(array('order_id' => $goods_id))->find();
        }
        foreach ($res as $key => $value) {  //分状态显示
            if ($value['pay_status'] == 0) {
                if ($value['order_status'] == 0) $list[1][] = $value;
                else if ($value['order_status'] == 6 || $value['order_status'] == 4 || $value['order_status'] == 3 || $value['order_status'] == 5) $list[3][] = $value;
            } else if ($value['pay_status'] == 1) {
                if ($value['order_status'] == 6 || $value['order_status'] == 4 || $value['order_status'] == 3 || $value['order_status'] == 5) $list[3][] = $value;
                else $list[2][] = $value;
            } else $list[3][] = $value;
        }
        $this->assign('list1', $list[1]);
        $this->assign('list2', $list[2]);
        $this->assign('list3', $list[3]);
        // var_dump($list[1]);exit;
        $this->display('');
    }

    /*
     *  接口：检查用户是否登陆
     * */
    public function checkLogin()
    {
        if (session('user')) echo json_encode(1);
        else echo json_encode(0);
    }


    /*
     *  author: lsh
     *  接口：支付订单后，更改订单状态
     * */
    public function pay_order()
    {
        //1.获取订单id 
        $order_id = 485;
        //2.获取订单详情 取得应付金额
        $Order = M('Activity_order');
        $order = $Order->where(array('order_id' => $order_id))->find();
        //3.获取订单商品 取得商品名称
        $Order_goods = M('Activity_order_goods');
        $order_goods = $Order_goods->where(array('order_id' => $order_id))->find();

        $money = $order['order_amount'] * 100; //order_amount 应付金额
        $body = $order_goods['goods_name'];
        if (strlen($body) > 12) $body = substr($body, 0, 36) . '...';
        $values = array(
            'body' => $body,
            'total_fee' => $money,
            "goods_tag" => "",
            "attach" => "",
        );
        //获取opneid
        $user = session('user');
        $values['openid'] = $user['openid'];
        $values['appid'] = 'wx405ec4b619579508';
        $values['mch_id'] = '1381211202';
        $values['key'] = 'BD4144296C11049FEF13B3459C0AADBB';

        $aply = new WechatAply($values);
        $unifiedOrderResult = $aply->unifiedOrder();
        $res = $aply->GetJsApiParameters($unifiedOrderResult);
        // echo var_dump($unifiedOrderResult);
        echo $res;
    }

    /*
     *  author: lsh
     *  接口：支付订单后，更改订单状态
     * */
    public function check_status()
    {
        $order_status = I('post.order_status'); //订单状态
        $pay_status = I('post.pay_status');     //支付状态
        $order_id = I('post.order_id');     //支付状态
        if ($order_status) $res = M('Activity_order')->where(array('order_id' => $order_id))->setField('order_status', $order_status);
        if ($pay_status) $res = M('Activity_order')->where(array('order_id' => $order_id))->setField('pay_status', $pay_status);
        echo json_encode(1);
    }

    /*
     *  author: lsh
     *  接口：已经支付的活动详情
     * */
    public function activity_detail_pay()
    {
        $id = I('get.order_id');
        $res = M('Activity_order_goods')->where(array('order_id' => $id))->find();
        $res['order'] = M('Activity_order')->where(array('order_id' => $id))->find();
        $goods_id = $res['goods_id'];
        $res['activity'] = M('Activity')->where(array('order_id' => $goods_id))->find();
        // var_dump($res);exit;
        $this->assign('list', $res);
        $this->display();
    }

    /*
     *  author: lsh
     *  接口：待支付的活动详情
     * */
    public function activity_detail_Wpay()
    {
        $id = I('get.order_id');
        $res = M('Activity_order_goods')->where(array('order_id' => $id))->find();
        $res['order'] = M('Activity_order')->where(array('order_id' => $id))->find();
        $goods_id = $res['goods_id'];
        $res['activity'] = M('Activity')->where(array('order_id' => $goods_id))->find();
        // var_dump($res);exit;
        $this->assign('list', $res);
        $this->display();
    }


    //接口：测试支付
    public function testAply()
    {
        $this->display('testAply');
    }

    //接口：测试支付
    public function testAplys()
    {
        $money = 100;
        $body = '-尾款支付';

        // $money = $cart['shop_price']*$cart['attr_val_num']*100;
        $values = array(
            'body' => $body,
            'total_fee' => $money,
            "goods_tag" => "",
            "attach" => "",
        );
        $values['openid'] = 'oUfJ1wzMSrmteTd96xjP1UlXeINc';
        $values['appid'] = 'wx405ec4b619579508';
        $values['mch_id'] = '1381211202';
        $values['key'] = 'BD4144296C11049FEF13B3459C0AADBB';

        // $values['openid'] = 'oCg84w_SYl3oY3780baeqN1dbiYo';
        // $values['appid'] = 'wx91224c6dcc734791';
        // $values['mch_id'] = '1342226001';
        // $values['key'] = 'BD4144296C11049FEF13B3459C0AADBB';
        $aply = new WechatAply($values);
        $unifiedOrderResult = $aply->unifiedOrder();
        $res = $aply->GetJsApiParameters($unifiedOrderResult);
        echo $res;
    }

    public function activityList()
    {
        $this->display();
    }

    public function activity_info()
    {
        $this->display();
    }
}
