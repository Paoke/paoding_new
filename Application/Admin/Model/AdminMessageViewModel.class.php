<?php
namespace Admin\Model;

use Think\Model\ViewModel;

class AdminMessageViewModel extends ViewModel
{
    public $viewFields = array(
        'userMessage' => array('*', '_type' => 'LEFT'),
        'Admin' => array(
            '_as' => 'Admin',
            'is_sys'=>'admin_is_sys',
            'admin_id' => 'post_user_id',
            'user_name' => 'post_nickname',
            'phone' => 'post_mobile',
            '_on' => 'Admin.admin_id=UserMessage.post_user_id',
            '_type' => 'LEFT'
        ),
        'Users' => array(
            'user_id' => 'accept_user_id',
            'nickname' => 'accept_nickname',
            'mobile' => 'accept_mobile',
            '_on' => 'Users.user_id=UserMessage.accept_user_id'
        ),
    );
}
