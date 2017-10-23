<?php
namespace Admin\Model;

use Think\Model\ViewModel;

class UserMessageViewModel extends ViewModel
{
    public $viewFields = array(
        'userMessage' => array('*', '_type' => 'LEFT'),
        'Admin' => array(
            '_as' => 'Admin',
            'is_sys'=>'admin_is_sys',
            'admin_id' => 'admin_id',
            'user_name' => 'post_admi_nname',
            'phone' => 'post_admin_mobile',
            '_on' => 'Admin.admin_id=UserMessage.post_user_id and UserMessage.is_sys=1',
            '_type' => 'LEFT'
        ),
        'Users1' => array(
            '_table' => '__MANAGE_USERS__',
            '_as' => 'Users1',
            'user_id' => 'user_id',
            'nickname' => 'post_nickname',
            'mobile' => 'post_mobile',
            '_on' => 'Users1.user_id=UserMessage.post_user_id and UserMessage.is_sys=0',
            '_type' => 'LEFT'),
        'Users2' => array(
            '_table' => '__MANAGE_USERS__',
            '_as' => 'Users2',
            'user_id' => 'accept_user_id',
            'nickname' => 'accept_nickname',
            'mobile' => 'accept_mobile',
            '_on' => 'Users2.user_id=UserMessage.accept_user_id'),
    );
}
