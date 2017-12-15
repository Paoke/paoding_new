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
	<!-- GEMMAP自带的矢量图标库 font-awesome.min.css-->
	<link href="/Public/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->

	<!-- jQuery 2.1.4 -->
	<script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="/Public/js/global.js"></script>
	<script src="/Public/js/myFormValidate.js"></script>
	<script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
	<script src="/Public/js/myAjax.js"></script>
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
    <form  id="search"  role="search" method="post">

		<!--body wrapper start-->
		<div class="wrapper" >
			<!--  -->
			<div class="row">
				<div class="col-sm-12">
					<section class="panel">
						<header class="panel-heading panel-body">
                            <div class="pull-left">
                                广告列表
                            </div>
                            <div class="collapse navbar-collapse pull-right">
                                <div class="navbar-right">
                                    <a  href="/index.php/Admin/Ad/ad/action/page_add" class="btn btn-default pull-right"><i class="fa fa-plus"></i>新增广告</a>
                                    <!--  <a href="#" id="btnclick"
                                        class="btn btn-default "><i class="fa fa-refresh"></i>
                                         重新排序</a> -->
                                </div>
                            </div>
                            <div class="collapse navbar-collapse pull-right">
                                <div class="form-group">
                                    <div class="input-group search-form">
                                        <input type="text" class="form-control" name="keywords" placeholder="请输入广告名称">
                                                    <span class="input-group-btn">
                                                <button  type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                              </span>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="collapse navbar-collapse pull-right" style="padding-right:5px">-->
                                        <!--<div class="form-group">-->
                                            <!--<select name="pid" class="form-control" >-->
                                                <!--<option value="0">选择分类</option>-->
                                                <!--<?php if(is_array($ad_position_list)): $k = 0; $__LIST__ = $ad_position_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($k % 2 );++$k;?>-->
                                                    <!--<option value="<?php echo ($item["position_id"]); ?>"><?php echo ($item["position_name"]); ?></option>-->
                                                <!--<?php endforeach; endif; else: echo "" ;endif; ?>-->
                                            <!--</select>-->
                                        <!--</div>-->
                            <!--</div>-->
						</header>

						<div class="">
							<div class="adv-table">
								<table  class="display table table-bordered table-striped" >
									<thead>
									<tr>
										<th>广告位</th>
										<th>广告名称</th>
										<th>广告图片</th>
										<th>广告链接</th>
										<!--<th>新窗口</th>-->
										<!--<th>是否显示</th>-->
										<th>排序</th>
										<th>操作</th>
									</tr>
									</thead>
									<tbody>
									<?php if(is_array($list)): foreach($list as $k=>$vo): ?><tr role="row">
											<td class="text-center"><?php echo ($ad_position_list[$vo[pid]-1][position_name]); ?></td>
											<td class="text-center"><?php echo ($vo["ad_name"]); ?></td>
											<td class="text-center"><img alt="" src="<?php echo ($vo["ad_code"]); ?>" width="80px" height="50px"></td>
											<td class="text-center"><?php echo ($vo["ad_link"]); ?></td>
											<!--<td class="text-center">-->
												<!--<img width="20" height="20" src="/Public/images/<?php if($vo[target] == 1): ?>yes.png<?php else: ?>cancel.png<?php endif; ?>"-->
                                                <!--<?php if($mod_id): ?>-->
                                                    <!--onclick="changeTableVal('<?php echo ($mod_id); ?>','ad','ad_id','<?php echo ($vo["ad_id"]); ?>','target',this)"-->
                                                <!--<?php endif; ?>-->

                                                <!--/>-->
											<!--</td>-->
											<!--<td class="text-center">-->
												<!--<img width="20" height="20" src="/Public/images/<?php if($vo[enabled] == 1): ?>yes.png<?php else: ?>cancel.png<?php endif; ?>"-->
                                                <!--<?php if($mod_id): ?>-->
                                                     <!--onclick="changeTableVal('<?php echo ($mod_id); ?>','ad','ad_id','<?php echo ($vo["ad_id"]); ?>','enabled',this)"-->
                                                <!--<?php endif; ?>-->
                                                <!--/>-->
											<!--</td>-->
											<td class="text-center">
                                                <input type="text"
                                                       onchange="updateSort('','ad','id','<?php echo ($vo["id"]); ?>','orderby',this)"
                                                       onkeyup="this.value=this.value.replace(/[^\d]/g,'')" maxlength="4" size="4"
                                                       value="<?php echo ($vo["orderby"]); ?>"
                                                       class="input-sm"/>
											</td>
											<td class="text-center">
                                             <div class="btn-group">
												<a class="btn btn-default" href="/index.php/Admin/Ad/ad/action/page_edit/id/<?php echo ($vo["id"]); ?>"  title="编辑">
                                                    <i class="fa fa-pencil"></i></a>
                                                 <a href="#delModal" data-toggle="modal" class="btn btn-default"
                                                    data-name="<?php echo ($vo["ad_name"]); ?>" title="删除"
                                                    data-url="/index.php/Admin/Ad/ad/action/del/id/<?php echo ($vo["id"]); ?>"
                                                    onclick="delModal(this)"><i class="fa fa-trash-o"></i></a>
                                                </div>
											</td>
										</tr><?php endforeach; endif; ?>

									</tbody>
								</table>
                  <!-- Modal -->
                                <div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                <h4 class="modal-title">信息</h4>
                                            </div>
                                            <div class="modal-body" id="del_info">

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        onclick="del_module();">
                                                    确定
                                                </button>
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
                        <?php if($page_now == 1): ?><!-- 上一页 -->
                            <li class="prev disabled">  
                                    <a href="#">
                                        上一页
                                    </a>
                            </li>
                        <?php else: ?>
                            <li class="prev">  
                                    <a href="<?php echo U('Admin/Ad/ad/action/page_now');?>/<?php echo ($page_now-1); ?>/page_num/<?php echo ($page_num); ?>">
                                        上一页
                                    </a>
                            </li><?php endif; ?>   <!-- 上一页 end -->
                        
                        <?php if($page < 5): ?><!-- 页码条 -->
                            <?php $__FOR_START_12415__=1;$__FOR_END_12415__=$page+1;for($i=$__FOR_START_12415__;$i < $__FOR_END_12415__;$i+=1){ ?><!-- 循环四条以内 -->                                
                                <?php if($i == $page_now ): ?><li class="active"> <a href=""><?php echo ($i); ?></a></li>
                                <?php elseif($i < $page_now ): ?>
                                    <li > <a href="<?php echo U('Admin/Ad/ad/action/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li>
                                <?php else: ?>
                                    <li > <a href="<?php echo U('Admin/Ad/ad/action/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li><?php endif; } ?>  
                        <?php elseif($page_now < 3): ?>                        
                            <?php $__FOR_START_2124__=1;$__FOR_END_2124__=6;for($i=$__FOR_START_2124__;$i < $__FOR_END_2124__;$i+=1){ ?><!-- 循环1-5 -->
                                
                                <?php if($i == $page_now ): ?><li class="active"> <a href=""><?php echo ($page_now); ?></a></li>
                                <?php elseif($i < $page_now ): ?>
                                    <li > <a href="<?php echo U('Admin/Ad/ad/action/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li>
                                <?php else: ?>
                                    <li > <a href="<?php echo U('Admin/Ad/ad/action/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li><?php endif; } ?> 
                        <?php elseif($page_now == $page-1): ?>  
                            <?php $__FOR_START_24725__=$page_now-3;$__FOR_END_24725__=$page+1;for($i=$__FOR_START_24725__;$i < $__FOR_END_24725__;$i+=1){ ?><!-- 循环当前页为倒数第二页时 -->
                                <?php if($i == $page_now ): ?><li class="active"> <a href="#"><?php echo ($page_now); ?></a></li>
                                <?php elseif($i < $page ): ?>
                                    <li > <a href="<?php echo U('Admin/Ad/ad/action/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li>
                                <?php else: ?>
                                    <li > <a href="<?php echo U('Admin/Ad/ad/action/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li><?php endif; } ?>
                        <?php elseif($page_now == $page): ?>  
                            <?php $__FOR_START_13738__=$page_now-4;$__FOR_END_13738__=$page+1;for($i=$__FOR_START_13738__;$i < $__FOR_END_13738__;$i+=1){ ?><!-- 循环当前页为最后一页时 -->
                                <?php if($i == $page_now ): ?><li class="active"> <a href="#"><?php echo ($page_now); ?></a></li>
                                <?php elseif($i < $page ): ?>
                                    <li > <a href="<?php echo U('Admin/Ad/ad/action/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li>
                                <?php else: ?>
                                    <li > <a href="<?php echo U('Admin/Ad/ad/action/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li><?php endif; } ?>
                        <?php else: ?>
                            <?php $__FOR_START_21915__=$page_now-2;$__FOR_END_21915__=$page_now+3;for($i=$__FOR_START_21915__;$i < $__FOR_END_21915__;$i+=1){ ?><!-- 循环除了前五条 和后五条 -->
                                
                                <?php if($i == $page_now ): ?><li class="active"> <a href="#"><?php echo ($page_now); ?></a></li>
                                <?php elseif($i < $page ): ?>
                                    <li > <a href="<?php echo U('Admin/Ad/ad/action/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li>
                                <?php else: ?>
                                    <li > <a href="<?php echo U('Admin/Ad/ad/action/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a></li><?php endif; } endif; ?>   <!-- 页码条 end -->

                         <?php if(($page_now != $page) AND ($page != 0)): ?><!-- 下一页 -->
                            <li class="next ">  
                                    <a href="<?php echo U('Admin/Ad/ad/action/page_now/');?>/<?php echo ($page_now+1); ?>/page_num/<?php echo ($page_num); ?>">
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
<script type="text/javascript">
    var modal_url;
    var modal_name;
    var modal_object;
    //删除菜单
    function delModal(obj) {
        modal_object = $(obj);
        modal_url = $(obj).attr('data-url');
        modal_name = $(obj).attr('data-name');
        $("#del_info").html(" 是否确认删除【" + modal_name + "】?");
    }

function gettrue() {
    $.ajax({
        type : 'post',
        url : url,
        data : {act:'del',del_id:cate_id},

        success : function(data){
            if(data.info)
                layer.alert(data.info);
            else {
                if (data == 1) {
                    vate_obj.parent().parent().remove();
                } else {
                    layer.alert(data, {icon: 2});
                }
            }
        }
    })
}

	
function search(){
   $('#search').submit();
}
$(document).ready(function(){     
    //默认选中 
    $("#page_num").val(<?php echo ($page_num); ?>); 
});

function del_module() {
    $.get(modal_url, function (res) {
        if (res.result == 1) {
            layer.msg(res.msg);
            modal_object.parent().parent().parent().remove();
        } else {
            layer.msg(res.msg);
        }

    });
}
</script>
</body>
</html>