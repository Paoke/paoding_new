<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="#" type="image/png">

    <title>自定义页面</title>
    <meta name="keywords" content="<?php echo ($gemmap_config['shop_info_store_keyword']); ?>"/>
    <meta name="description" content="<?php echo ($gemmap_config['shop_info_store_desc']); ?>"/>

    <!--dynamic table-->

    <link href="<?php echo (CSS); ?>/style.css" rel="stylesheet">
    <link href="<?php echo (CSS); ?>/style-responsive.css" rel="stylesheet">
    <link href="<?php echo (CSS); ?>/chanel-type.css" rel="stylesheet">
    <!--GEMMAP自带的矢量图标库 font-awesome.min.css-->
    <link href="/Public/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery 2.1.4 -->
    <script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="/Public/js/global.js"></script>
    <script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->

</head>
<style type="text/css">
.navbar-default { background-color: #fff; border-bottom: 1px solid #e7e7e7; }
.panel { border: 1px solid #ddd; }
.table th{ vertical-align: bottom; border-bottom: 1px solid #ddd; padding: 10px; text-align:center; }
.table td{ vertical-align: bottom; border-bottom: 1px solid #ddd; padding: 5px; text-align:center; }
.pagination {
margin:0;
}
.dataTables_paginate {
padding:0;
}

</style>

<body class="sticky-header">
    <!-- main content start-->
    <div class="main-content" width="100%" style="margin:10px;">
            <!--  -->
            <div class=" panel-body panel" style="padding: 0;">
                <div class="row">
                <div class="col-sm-12">
                    <header class="panel-heading panel-body">
                        <div class="pull-left ">
                            自定义页面管理
                        </div>
                        <div class="collapse navbar-collapse pull-right">
                            <div class=" navbar-right">
                                <a href="/index.php/Admin/PageConfig/page_info/action/page_add" class="btn btn-default"><i
                                        class="fa fa-plus"></i>新增页面</a>
                            </div>
                        </div>
                    </header>
                </div>
                </div>
                <section  class=" ">
                    <table class="table">
                        <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th>页面名称</th>
                            <th width="15%">模板</th>
                            <th width="20%">创建时间</th>
                            <th width="20%">调用状态</th>
                            <th width="20%">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                            <td style="width:50px; "><?php echo ($vo["id"]); ?></td>
                            <td><?php echo ($vo["title"]); ?></td>
                            <td> <img width="20" height="20" src="/Public/images/add.png"
                                                     onclick="changeTableVal('<?php echo ($mod_id); ?>','Admin','admin_id','<?php echo ($vo["admin_id"]); ?>','is_active',this)"/></td>
                            <td><?php echo ($vo["create_time"]); ?></td>
                            <td>
                                <?php if($vo["used_time"] == 0): ?>未引用
                                    <?php else: ?>调用<?php echo ($vo["used_time"]); ?>次<?php endif; ?>

                            </td>
                            <td class="numeric" data-title="Volume">
                                <div class="btn-group">
                                    <a role="button" href="/index.php/Admin/PageConfig/page_config/action/page_edit/id/<?php echo ($vo["id"]); ?>" class="btn btn-default"><i class="fa fa-cog"></i>配置</a>
                                    <a role="button" href="javascript:;" onclick="del('<?php echo ($vo["id"]); ?>', '<?php echo ($vo["title"]); ?>')" class="btn btn-default"><i class="fa fa-trash-o"></i>删除</a>
                                </div>
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>
                </section>
                    
               <div class="panel-body footbg">
                    <div class="row-fluid  ">
                            <div  id="dynamic-table_info">
                                <label style="float:left">
                                    <select class="form-control" size="1" id="page_num" name="page_num"
                                            aria-controls="dynamic-table" onchange="search()">
                                        <option value="25">25条每页</option>
                                        <option value="50">50条每页</option>
                                        <option value="100">100条每页</option>
                                    </select>
                                </label>
                                <label style="float:left;margin-left:10px;margin-top:7px">
                                    <span class=" wenzi" style="float:left">共 <?php echo ($count); ?> 条</span>
                                </label>
                            </div>
                     </div>
                      <!-- modal -->
                      <div class="pull-right ">
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
                                        <a href="/index.php/Admin/PageConfig/page_config/action/page_list/page_now/<?php echo ($page_now-1); ?>/page_num/<?php echo ($page_num); ?>">
                                            上一页
                                        </a>
                                    </li><?php endif; ?>   <!-- 上一页 end -->

                                <?php if($page < 5): ?><!-- 页码条 -->
                                    <?php $__FOR_START_16156__=1;$__FOR_END_16156__=$page+1;for($i=$__FOR_START_16156__;$i < $__FOR_END_16156__;$i+=1){ ?><!-- 循环四条以内 -->
                                        <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($i); ?></a></li>
                                            <?php elseif($i < $page_now ): ?>
                                            <li><a href="/index.php/Admin/PageConfig/page_config/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                            </li>
                                            <?php else: ?>
                                            <li><a href="/index.php/Admin/PageConfig/page_config/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                            </li><?php endif; } ?>
                                    <?php elseif($page_now < 3): ?>
                                    <?php $__FOR_START_5925__=1;$__FOR_END_5925__=6;for($i=$__FOR_START_5925__;$i < $__FOR_END_5925__;$i+=1){ ?><!-- 循环1-5 -->

                                        <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                            <?php elseif($i < $page_now ): ?>
                                            <li><a href="/index.php/Admin/PageConfig/page_config/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                            </li>
                                            <?php else: ?>
                                            <li><a href="/index.php/Admin/PageConfig/page_config/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                            </li><?php endif; } ?>
                                    <?php elseif($page_now == $page-1): ?>
                                    <?php $__FOR_START_20730__=$page_now-3;$__FOR_END_20730__=$page+1;for($i=$__FOR_START_20730__;$i < $__FOR_END_20730__;$i+=1){ ?><!-- 循环当前页为倒数第二页时 -->
                                        <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                            <?php elseif($i < $page ): ?>
                                            <li><a href="/index.php/Admin/PageConfig/page_config/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                            </li>
                                            <?php else: ?>
                                            <li><a href="/index.php/Admin/PageConfig/page_config/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                            </li><?php endif; } ?>
                                    <?php elseif($page_now == $page): ?>
                                    <?php $__FOR_START_22187__=$page_now-4;$__FOR_END_22187__=$page+1;for($i=$__FOR_START_22187__;$i < $__FOR_END_22187__;$i+=1){ ?><!-- 循环当前页为最后一页时 -->
                                        <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                            <?php elseif($i < $page ): ?>
                                            <li><a href="/index.php/Admin/PageConfig/page_config/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                            </li>
                                            <?php else: ?>
                                            <li><a href="/index.php/Admin/PageConfig/page_config/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                            </li><?php endif; } ?>
                                    <?php else: ?>
                                    <?php $__FOR_START_12552__=$page_now-2;$__FOR_END_12552__=$page_now+3;for($i=$__FOR_START_12552__;$i < $__FOR_END_12552__;$i+=1){ ?><!-- 循环除了前五条 和后五条 -->

                                        <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                            <?php elseif($i < $page ): ?>
                                            <li><a href="/index.php/Admin/PageConfig/page_config/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                            </li>
                                            <?php else: ?>
                                            <li><a href="/index.php/Admin/PageConfig/page_config/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                            </li><?php endif; } endif; ?>   <!-- 页码条 end -->

                                 <?php if(($page_now != $page) AND ($page != 0)): ?><!-- 下一页 -->
                                    <li class="next ">
                                        <a href="/index.php/Admin/PageConfig/page_config/action/page_list/page_now/<?php echo ($page_now+1); ?>/page_num/<?php echo ($page_num); ?>">
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
            <!--  -->
    </div>
    <!--body wrapper end-->
 
</body>
</html>
<!-- Placed js at the end of the document so the pages load faster -->
<script src="<?php echo (JS); ?>/jquery-ui-1.9.2.custom.min.js"></script>
<script src="<?php echo (JS); ?>/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo (JS); ?>/bootstrap.min.js"></script>
<script src="<?php echo (JS); ?>/modernizr.min.js"></script>
<script src="<?php echo (JS); ?>/jquery.nicescroll.js"></script>
<script src="/Public/js/layer/layer.js"></script>

<!--common scripts for all pages-->
<script src="<?php echo (JS); ?>/scripts.js"></script>

<script>
    function del(id, title){

        layer.confirm('确定删除"'+title+'"？', {
            icon: 2,
            btn: ['确定','取消'] //按钮
        }, function(){

            var url = "/index.php/Admin/PageConfig/page_config/action/del/id/"+id;
            // 确定
            $.ajax({
                type : 'get',
                url : url,
                data : {id: id},
                dataType : 'json',
                success : function(data){
                    layer.msg('删除成功', {time: 1000});
                    setTimeout(function(){
                        window.location.reload();
                    },'1500');
                }
            })

        }, function(){
            //取消
            layer.closeAll();
        });

    }

</script>