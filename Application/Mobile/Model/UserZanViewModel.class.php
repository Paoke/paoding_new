<?php
namespace Mobile\Model;

use Think\Model\ViewModel;

class UserZanViewModel extends ViewModel
{
    public $viewFields = array(
        'ArticleZan' => array('id', 'article_id', 'zan_user_id', 'zan_time', '_type' => 'LEFT'),
        'Article' => array(
            'article_id',
            'title',                 //标题
            'description',   //简介
            'thumb',           //缩略图
            '_on' => 'Article.article_id = ArticleZan.article_id'),
    );
}
