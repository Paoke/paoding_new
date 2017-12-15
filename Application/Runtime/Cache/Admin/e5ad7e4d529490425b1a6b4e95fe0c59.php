<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <meta name="author" content="ThemeBucket">
  <link rel="shortcut icon" href="#" type="image/png">

    <title><?php echo ($gemmap_config['shop_info_store_title']); ?></title>
   <meta name="keywords" content="<?php echo ($gemmap_config['shop_info_store_keyword']); ?>" />
    <meta name="description" content="<?php echo ($gemmap_config['shop_info_store_desc']); ?>" />

  <!--dynamic table-->
  <link href="<?php echo (JS); ?>/advanced-datatable/css/demo_page.css" rel="stylesheet" />
  <link href="<?php echo (JS); ?>/advanced-datatable/css/demo_table.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo (JS); ?>/data-tables/DT_bootstrap.css" />
  <link href="<?php echo (CSS); ?>/style.css" rel="stylesheet">
  <link href="<?php echo (CSS); ?>/style-responsive.css" rel="stylesheet">
      <!-- jQuery 2.1.4 -->
      <script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
      <script src="/Public/js/global.js"></script>
      <script src="/Public/js/myFormValidate.js"></script>    
      <script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
      <script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
      <script src="/Public/js/myAjax.js"></script>
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
</head>
<style type="text/css">
    .navbar-default{background-color: #fff;border-bottom: 1px solid #e7e7e7;}
    .panel{ border: 1px solid #ddd; }
    .navbar-default {
        background-color: #fff;
        border-bottom: 1px solid #e7e7e7;
    }

    .panel{
        border: 1px solid #e7e7e7;
    }

    .formadd {
        padding: 0px;
    }
    .pagination {
    margin:0;
}
.dataTables_paginate {
     padding:0; 
}
.panel-heading {
    border-bottom: 0px solid #ddd;
   
}
</style>

<body class="sticky-header" >

<section>   
    
    <!-- main content start-->
    <div class="main-content" width="100%" style="margin:0px;">
    <form action="<?php echo U('Ad/positionList');?>" id="search"  role="search" method="post">
        <!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            广告位
        </header>
        <!--<div class="collapse navbar-collapse navbar-default">-->
                <!--<form class="navbar-form form-inline" role="search">-->
                  <!--<div class="panel-body">-->
                    <!--<a href="<?php echo U('Admin/Ad/position');?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>新增广告位</a>-->
                  <!--</div>-->
                <!--</form>-->
        <!--</div>-->

        <div class="">
        <div class="adv-table">
        <table  class="display table table-bordered table-striped" >
        <thead>
        <tr role="row">
           <th>广告位名称</th>
           <th>广告位描述</th>
       </tr>
        </thead>
        <tbody>
        
              
		<?php if(is_array($list)): foreach($list as $k=>$vo): ?><tr role="row" align="center" style ="background:#FFFFFF; line-height: 35px;">
             <td><?php echo ($vo["position_name"]); ?></td>
             <td><?php echo ($vo["position_desc"]); ?></td>
           </tr><?php endforeach; endif; ?>
        </tbody>
        </table>
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
                        <?php if($page_now == 1): ?><!-- 上一页 -->
                            <li class="prev disabled">  
                                    <a href="#">
                                        上一页
                                    </a>
                            </li>
                        <?php else: ?>
                            <li class="prev">  
                                    <a href="<?php echo U('Admin/Ad/positionList/page_now');?>/<?php echo ($page_now-1); ?>/page_num/<?php echo ($page_num); ?>">
                                        上一页
                                    </a>
                            </li><?php endif; ?>   <!-- 上一页 end -->
                        
                        <?php if($page < 5): ?><!-- 页码条 -->
                            <?php $__FOR_START_23969__=1;$__FOR_END_23969__=$page+1;for($i=$__FOR_START_23969__;$i < $__FOR_END_23969__;$i+=1){ ?><!-- 循环四条以内 -->                                
                                <?php if($i == $page_now ): ?><li class="active"> <a href=""><?php echo ($i); ?></a></li>
                                <?php elseif($i < $page_now ): ?>
                                    <li > <a href="<?php echo U('Admin/Ad/positionList/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li>
                                <?php else: ?>
                                    <li > <a href="<?php echo U('Admin/Ad/positionList/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li><?php endif; } ?>  
                        <?php elseif($page_now < 3): ?>                        
                            <?php $__FOR_START_7110__=1;$__FOR_END_7110__=6;for($i=$__FOR_START_7110__;$i < $__FOR_END_7110__;$i+=1){ ?><!-- 循环1-5 -->
                                
                                <?php if($i == $page_now ): ?><li class="active"> <a href="#"><?php echo ($page_now); ?></a></li>
                                <?php elseif($i < $page_now ): ?>
                                    <li > <a href="<?php echo U('Admin/Ad/positionList/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li>
                                <?php else: ?>
                                    <li > <a href="<?php echo U('Admin/Ad/positionList/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li><?php endif; } ?> 
                        <?php elseif($page_now == $page-1): ?>  
                            <?php $__FOR_START_22407__=$page_now-3;$__FOR_END_22407__=$page+1;for($i=$__FOR_START_22407__;$i < $__FOR_END_22407__;$i+=1){ ?><!-- 循环当前页为倒数第二页时 -->
                                <?php if($i == $page_now ): ?><li class="active"> <a href="#"><?php echo ($page_now); ?></a></li>
                                <?php elseif($i < $page ): ?>
                                    <li > <a href="<?php echo U('Admin/Ad/positionList/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li>
                                <?php else: ?>
                                    <li > <a href="<?php echo U('Admin/Ad/positionList/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li><?php endif; } ?>
                        <?php elseif($page_now == $page): ?>  
                            <?php $__FOR_START_5812__=$page_now-4;$__FOR_END_5812__=$page+1;for($i=$__FOR_START_5812__;$i < $__FOR_END_5812__;$i+=1){ ?><!-- 循环当前页为最后一页时 -->
                                <?php if($i == $page_now ): ?><li class="active"> <a href="#"><?php echo ($page_now); ?></a></li>
                                <?php elseif($i < $page ): ?>
                                    <li > <a href="<?php echo U('Admin/Ad/positionList/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li>
                                <?php else: ?>
                                    <li > <a href="<?php echo U('Admin/Ad/positionList/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li><?php endif; } ?>
                        <?php else: ?>
                            <?php $__FOR_START_13021__=$page_now-2;$__FOR_END_13021__=$page_now+3;for($i=$__FOR_START_13021__;$i < $__FOR_END_13021__;$i+=1){ ?><!-- 循环除了前五条 和后五条 -->
                                
                                <?php if($i == $page_now ): ?><li class="active"> <a href="#"><?php echo ($page_now); ?></a></li>
                                <?php elseif($i < $page ): ?>
                                    <li > <a href="<?php echo U('Admin/Ad/positionList/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li>
                                <?php else: ?>
                                    <li > <a href="<?php echo U('Admin/Ad/positionList/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li><?php endif; } endif; ?>   <!-- 页码条 end -->

                         <?php if(($page_now != $page) AND ($page != 0)): ?><!-- 下一页 -->
                            <li class="next ">  
                                    <a href="<?php echo U('Admin/Ad/positionList/page_now/');?>/<?php echo ($page_now+1); ?>/page_num/<?php echo ($page_num); ?>">
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
<script src="<?php echo (JS); ?>/jquery-ui-1.9.2.custom.min.js"></script>
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
<script type="text/javascript">
  function delfun(obj){
  if(confirm('确认删除')){    
    $.ajax({
      type : 'post',
      url : $(obj).attr('data-url'),
      data : {act:'del',role_id:$(obj).attr('data-id')},
      dataType : 'json',
      success : function(data){
        if(data==1){
          $(obj).parent().parent().remove();
        }else{
          layer.alert(data, {icon: 2});
        }
      }
    })
  }
  return false;
}
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