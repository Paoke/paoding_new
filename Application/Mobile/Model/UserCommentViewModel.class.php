<?php
namespace Mobile\Model;

use Think\Model\ViewModel;

class UserCommentViewModel extends ViewModel
{
    public $viewFields = array(
        'ArticleComment' => array('id','comment_user_id', 'comment_time', 'content','article_id', 'parent_id','_type' => 'LEFT'),
        'Users' => array(
            'user_id',
            'nickname',
            'head_pic',
            '_on' => 'Users.user_id = ArticleComment.comment_user_id'),
    );
}
