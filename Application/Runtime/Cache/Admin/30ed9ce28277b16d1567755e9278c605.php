<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <meta name="author" content="ThemeBucket">
  <link rel="shortcut icon" href="#" type="image/png">

    <title><?php echo ($tpshop_config['shop_info_store_title']); ?></title>
   <meta name="keywords" content="<?php echo ($tpshop_config['shop_info_store_keyword']); ?>" />
    <meta name="description" content="<?php echo ($tpshop_config['shop_info_store_desc']); ?>" />

  <!--dynamic table-->
  <link href="<?php echo (JS); ?>/advanced-datatable/css/demo_page.css" rel="stylesheet" />
  <link href="<?php echo (JS); ?>/advanced-datatable/css/demo_table.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo (JS); ?>/data-tables/DT_bootstrap.css" />
  <link href="<?php echo (CSS); ?>/style.css" rel="stylesheet">
  <link href="<?php echo (CSS); ?>/style-responsive.css" rel="stylesheet">
  <link href="/Public/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
</head>
<style type="text/css">
    .navbar-default{background-color: #fff;border-bottom: 1px solid #e7e7e7;}
    .panel{
        border: 1px solid #e7e7e7;
    }

    .modal-dialog {
        width: 950px;
        margin: 10px auto;
    }
    .wrapperrow {
        margin-top: 15px;
        border-top: 1px solid #e6e8eb;
        padding: 0px;
    }

    .modal-header {
        padding: 5px 20px;
    }

    .modal-footer {
        margin-top: 0px;
        padding: 0px 20px;
    }
    .paneltop {
        border: none;
        border-top: 1px solid #e6e8eb;
    }
    .margintop {margin-top:-1px;
        padding-left:15px;
    }
    .formbottom {
        margin-bottom:5px;
        margin-left:5px;
    }
    .pagination {
        margin:0px;
    }

    
 .table-bordered   {
   
    border: none;
}
.panel-heading {
    border-bottom: 0px solid #ddd;
}

table{
     border-bottom:1px solid #ddd !important;;
}
.dataTables_paginate {
     padding:0;
}
.pagination {
    margin:0;
}
</style>

<body class="sticky-header" >

    <section>  
        
    <!-- main content start-->
    <div class="main-content" width="100%" style="margin:0px;">

        <form action="" id="search"  role="search" method="post">


        <!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading panel-body">
            购买记录
        </header>

        <div class="collapse navbar-collapse navbar-default">
        </div>

        <div class="">
        <div class="adv-table">
        <table  class="display table table-bordered table-striped" >
        <thead>
        <tr>
            <th class="text-center">ID</th>
            <th class="text-center">订单号</th>
            <th class="text-center">站点名称</th>
            <th class="text-center">费用</th>
            <th class="text-center">处理状态</th>
            <th class="text-center">模板ID</th>
            <th class="text-center">模板名称</th>
            <th class="text-center">购买时间</th>
            <th class="text-center">购买类型</th>
            <th class="text-center">用户名</th>
            <th class="text-center">手机号</th>
            <th class="text-center">公司</th>
            <th class="text-center">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr role="row" align="center" style ="background:#FFFFFF;">
                <td class="text-center" id="name-<?php echo ($list["id"]); ?>"><?php echo ($list["id"]); ?></td>
                <td class="text-center"><?php echo ($list["order_id"]); ?></td>
                <td class="text-center"><?php echo ($list["site_name"]); ?></td>
                <td class="text-center"><?php echo ($list["cost"]); ?></td>
                <td class="text-center">
                    <?php if($list['status'] == 0): ?>未处理
                    <?php elseif($list['status'] == 1): ?>  已部署
                    <?php else: ?> 已退款<?php endif; ?>
                </td>
                <td class="text-center"><?php echo ($list["template_id"]); ?></td>
                <td class="text-center"><?php echo ($list["tmpl_dir"]); ?></td>
                <td class="text-center"><?php echo ($list["buy_time"]); ?></td>
                <td class="text-center">
                    <?php if($list['buy_type'] == 1): ?>完整购买
                        <?php else: ?> 试用<?php endif; ?>
                </td>
                <td class="text-center"><?php echo ($list["user"]); ?></td>
                <td class="text-center"><?php echo ($list["mobile"]); ?></td>
                <td class="text-center"><?php echo ($list["company"]); ?></td>
                <td class="text-center">
                    <?php if($list['status'] == 0): ?><a href="<?php echo U('Admin/Site/siteReview/action/page_add',array('id'=>$list['id']));?>" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="建站">建站</a>
                    <?php else: ?> <a href="<?php echo U('Admin/Site/show',array('id'=>$list['id']));?>" data-toggle="tooltip" title="" class="btn btn-default disabled" data-original-title="查看"><i class="fa fa-send-o"></i></a><?php endif; ?>

                </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>

        </tbody>
        </table>

            <!-- Modal -->
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal5" class="modal fade">
                <div class="modal-dialog" id="ajaxreturn">

                </div>
            </div>
            <!-- modal -->
            <!-- Modal -->
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                <div class="modal-dialog" style="width: 40%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">信息</h4>
                        </div>
                        <div class="modal-body" id="del_info">

                        </div>
                        <div class="modal-footer" style="padding:15px;margin-top: 15px;">
                            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="gettrue();"> 确定</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal"> 取消</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal -->
        <div class="row-fluid panel-body">
            <div class="span6">
                <div class="dataTables_info" id="dynamic-table_info">
                <label style="float:left">                
                    <select class="form-control" size="1" id="page_num" name="page_num" aria-controls="dynamic-table" onchange="search()">
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </label>
                <label style="float:left;margin-left:10px;margin-top:7px"> 
                    <span class=" wenzi" style="float:left">条每页，总共 <?php echo ($count); ?> 条</span>
                </label>
                </div>
            </div>
            <div class="span6">
                <div class="dataTables_paginate paging_bootstrap pagination">
                    <ul>
                        <?php if($page_now <= 1 ): ?><!-- 上一页 -->
                            <li class="prev disabled">  
                                    <a href="#">
                                        上一页
                                    </a>
                            </li>
                        <?php else: ?>
                            <li class="prev">  
                                    <a href="<?php echo U('Admin/Site/index/page_now');?>/<?php echo ($page_now-1); ?>/page_num/<?php echo ($page_num); ?>">
                                        上一页
                                    </a>
                            </li><?php endif; ?>   <!-- 上一页 end -->
                        
                        <?php if($page < 5): ?><!-- 页码条 -->
                            <?php $__FOR_START_31437__=1;$__FOR_END_31437__=$page+1;for($i=$__FOR_START_31437__;$i < $__FOR_END_31437__;$i+=1){ ?><!-- 循环四条以内 -->                                
                                <?php if($i == $page_now ): ?><li class="active"> <a href="#"><?php echo ($i); ?></a></li>
                                <?php elseif($i < $page_now ): ?>
                                    <li > <a href="<?php echo U('Admin/Coupon/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li>
                                <?php else: ?>
                                    <li > <a href="<?php echo U('Admin/Coupon/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li><?php endif; } ?>  
                        <?php elseif($page_now < 3): ?>                        
                            <?php $__FOR_START_28546__=1;$__FOR_END_28546__=6;for($i=$__FOR_START_28546__;$i < $__FOR_END_28546__;$i+=1){ ?><!-- 循环1-5 -->
                                
                                <?php if($i == $page_now ): ?><li class="active"> <a href="#"><?php echo ($page_now); ?></a></li>
                                <?php elseif($i < $page_now ): ?>
                                    <li > <a href="<?php echo U('Admin/Coupon/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li>
                                <?php else: ?>
                                    <li > <a href="<?php echo U('Admin/Coupon/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li><?php endif; } ?> 
                        <?php elseif($page_now == $page-1): ?>  
                            <?php $__FOR_START_18067__=$page_now-3;$__FOR_END_18067__=$page+1;for($i=$__FOR_START_18067__;$i < $__FOR_END_18067__;$i+=1){ ?><!-- 循环当前页为倒数第二页时 -->
                                <?php if($i == $page_now ): ?><li class="active"> <a href="#"><?php echo ($page_now); ?></a></li>
                                <?php elseif($i < $page ): ?>
                                    <li > <a href="<?php echo U('Admin/Coupon/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li>
                                <?php else: ?>
                                    <li > <a href="<?php echo U('Admin/Coupon/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li><?php endif; } ?>
                        <?php elseif($page_now == $page): ?>  
                            <?php $__FOR_START_1744__=$page_now-4;$__FOR_END_1744__=$page+1;for($i=$__FOR_START_1744__;$i < $__FOR_END_1744__;$i+=1){ ?><!-- 循环当前页为最后一页时 -->
                                <?php if($i == $page_now ): ?><li class="active"> <a href="#"><?php echo ($page_now); ?></a></li>
                                <?php elseif($i < $page ): ?>
                                    <li > <a href="<?php echo U('Admin/Coupon/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li>
                                <?php else: ?>
                                    <li > <a href="<?php echo U('Admin/Coupon/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li><?php endif; } ?>
                        <?php else: ?>
                            <?php $__FOR_START_30409__=$page_now-2;$__FOR_END_30409__=$page_now+3;for($i=$__FOR_START_30409__;$i < $__FOR_END_30409__;$i+=1){ ?><!-- 循环除了前五条 和后五条 -->
                                
                                <?php if($i == $page_now ): ?><li class="active"> <a href="#"><?php echo ($page_now); ?></a></li>
                                <?php elseif($i < $page ): ?>
                                    <li > <a href="<?php echo U('Admin/Coupon/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li>
                                <?php else: ?>
                                    <li > <a href="<?php echo U('Admin/Coupon/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li><?php endif; } endif; ?>   <!-- 页码条 end -->

                         <?php if(($page_now != $page) AND ($page != 0)): ?><!-- 下一页 -->
                            <li class="next ">  
                                    <a href="<?php echo U('Admin/Coupon/index/page_now/');?>/<?php echo ($page_now+1); ?>/page_num/<?php echo ($page_num); ?>">
                                        下一页
                                    </a>
                            </li>
                        <?php else: ?>
                            <li class="next disabled">  
                                    <a href="#">
                                        下一页
                                    </a>
                            </li><?php endif; ?><!-- 下一页 end-->
                    </ul>
                </div>
            </div>
        </div>

        </div>
        </div>
        </section>
        </div>
        </div>
        </div>
        <!--body wrapper end-->
        </form>
        


    </div>
    <!-- main content end-->
</section>

<!-- Placed js at the end of the document so the pages load faster -->
<script src="<?php echo (JS); ?>/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo (JS); ?>/bootstrap.min.js"></script>
<script src="<?php echo (JS); ?>/modernizr.min.js"></script>
<script src="<?php echo (JS); ?>/jquery.nicescroll.js"></script>

<!--dynamic table-->
<script type="text/javascript" language="javascript" src="<?php echo (JS); ?>/advanced-datatable/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo (JS); ?>/data-tables/DT_bootstrap.js"></script>
<!--dynamic table initialization -->
<script src="<?php echo (JS); ?>/dynamic_table_init.js"></script>

<!--common scripts for all pages-->
<script src="<?php echo (JS); ?>/scripts.js"></script>
<script>


//$('.send_user').click(function(){
//    var url = $(this).attr('data-url');
//    layer.open({
//        type: 2,
//        title: '发放优惠券',
//        shadeClose: true,
//        shade: 0.5,
//        area: ['70%', '85%'],
//        content: url,
//    });
//});

$(document).ready(function(){
    var cid = $('.send_user').attr('data-id');
    $.ajax({
        type : "GET",
        url:"/index.php/Admin/Coupon/send_coupon/cid/"+cid,//+tab,
        data : 'json',// 你的formid
        success: function(data){
            $("#ajaxreturn").html('');
            $("#ajaxreturn").append(data);
        }
    });

});

//// ajax 抓取页面
//function ajax_get_table(tab,page){
//    cur_page = page; //当前页面 保存为全局变量
//    $.ajax({
//        type : "GET",
//        url:"/index.php/Admin/Coupon/send_coupon/p/"+page,//+tab,
//        data : $('#'+tab).serialize(),// 你的formid
//        success: function(data){
//            $("#ajaxreturn").html('');
//            $("#ajaxreturn").append(data);
//        }
//    });
//}

// 删除操作

var url;
var coupon_id;
var obj;
$('.del-good-attr').click(function(){
    url = $(this).attr('data-url');
    coupon_id = $(this).attr('data-id');
    obj=$(this);
    $("#del_info").html("确定删除:  "+ $("#name-"+coupon_id).html()+" ?");
});
function gettrue() {
    $.ajax({
        type : 'post',
        url :url,

        success : function(data){
            if(data.info)
                layer.alert(data.info);
            else {
            if(data){
                obj.parent().parent().remove();
            }else{
                layer.alert('删除失败', {icon: 2});  //alert('删除失败');
            }
            }
        }
    })

}

//function delfun(obj){
//  if(confirm('确认删除')){
//    $.ajax({
//      type : 'post',
//      url : $(obj).attr('data-url'),
//      dataType : 'json',
//      success : function(data){
//        if(data){
//          $(obj).parent().parent().remove();
//        }else{
//          layer.alert('删除失败', {icon: 2});  //alert('删除失败');
//        }
//      }
//    })
//  }
//  return false;
//}
function search(){
   $('#search').submit();
}
$(document).ready(function(){     
    //默认选中 
    $("#page_num").val(<?php echo ($page_num); ?>); 
});
</script>
</body>
</html>