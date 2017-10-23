<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class CommentGoodsViewModel extends ViewModel  {
    public $viewFields = array(
        'GoodsComment'=>array('comment_id','username','content','goods_id','is_show','add_time','ip_address','_type'=>'LEFT'),
        'Goods'=>array( 'goods_name','_on'=>'GoodsComment.goods_id=Goods.goods_id'),
    );
}
