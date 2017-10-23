<?php
namespace Mobile\Model;

use Think\Model\ViewModel;

class UserCollectViewModel extends ViewModel
{
    public $viewFields = array(
        'ArticleCollect' => array('id', 'article_id', 'collect_user_id', 'collect_time', '_type' => 'LEFT'),
        'Article' => array(
            'article_id',
            'title',                 //标题
            'description',   //简介
            'thumb',           //缩略图
            '_on' => 'Article.article_id = ArticleCollect.article_id'),
    );
}
