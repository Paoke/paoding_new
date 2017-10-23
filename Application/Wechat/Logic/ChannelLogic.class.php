<?php
/**
 * Created by PhpStorm.
 * User: SingHome
 * Date: 2017/6/14
 * Time: 14:14
 */

namespace Wechat\Logic;


class ChannelLogic
{
    private $DAO = null;//当前表操作对象
    private $channel = null;
    private $type = null;

    public function __construct($channel, $type)
    {
        $this->channel = $channel;
        $this->type = $type;
        $this->DAO = $this->createDAO($channel, $type);
    }


    public function getChannel(){
        return $this->channel;
    }
    /*
     * 创建数据库操作对象
     * **/
    public function createDAO($channel, $type){
        $table = getTableStr($channel, $type, 'table_format');
        $DAO = D($table);
        return $DAO;
    }

    /*
     * 更新订单状态
     * **/
    public function updateOrderStatus($orderId, $orderStatus, $payStatus){
        if($this->DAO){
            $data['order_status'] = $orderStatus;
            $data['pay_status'] = $payStatus;
            return $this->DAO->where("order_id=".$orderId)->save($data);

        }else{
            return false;
        }
        return true;
    }

    /*
     * 订单是否已支付
     * **/
    public function isPayedOrder($orderId){
        if($this->DAO){
            $pay_status =  $this->DAO->where("order_id=".$orderId)->getField('pay_status');
            if($pay_status == 1){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }

    }

    /*
     * 获取订单信息
     * **/
    public function getOrder($orderId){
        if($this->DAO){
            $order =  $this->DAO->where("order_id=".$orderId)->find();
            return $order;
        }else{
            return false;
        }

    }

}