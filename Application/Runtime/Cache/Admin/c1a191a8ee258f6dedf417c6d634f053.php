<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="#" type="image/png">

    <title><?php echo ($gemmap_config['shop_info_store_title']); ?></title>
    <meta name="keywords" content="<?php echo ($gemmap_config['shop_info_store_keyword']); ?>"/>
    <meta name="description" content="<?php echo ($gemmap_config['shop_info_store_desc']); ?>"/>

    <!--dynamic table-->
    <link href="<?php echo (JS); ?>/advanced-datatable/css/demo_page.css" rel="stylesheet"/>
    <link href="<?php echo (JS); ?>/advanced-datatable/css/demo_table.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo (JS); ?>/data-tables/DT_bootstrap.css"/>
    <link href="<?php echo (CSS); ?>/style.css" rel="stylesheet">
    <link href="<?php echo (CSS); ?>/style-responsive.css" rel="stylesheet">
    <!--GEMMAP自带的矢量图标库 font-awesome.min.css-->
    <link href="/Public/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>

    <script src="/Public/js/myAjax.js"></script>

    <!-- jQuery 2.1.4 -->
    <script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="/Public/js/global.js"></script>
    <script src="/Public/js/myFormValidate.js"></script>
    <script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
    <script src="/Public/js/myAjax.js"></script>
</head>
<style type="text/css">
    .navbar-default {
        background-color: #fff;
        border-bottom: 1px solid #e7e7e7;
    }

    .panel {
        border: 1px solid #ddd;
    }

    .navbar-default {
        background-color: #fff;
        border-bottom: 1px solid #e7e7e7;
    }

    .panel {
        border: 1px solid #e7e7e7;
    }

    .formadd {
        padding: 0px;
    }

    .pagination {
        margin: 0;
    }

    .dataTables_paginate {
        padding: 0;
    }
    .panel-heading {
    border-bottom: 0px solid #ddd;
   
}
</style>

<body class="sticky-header">
<section>
    <!-- main content start-->
    <div class="main-content" width="100%" style="margin:0px;">
        <form action="" id="search" role="search" method="post">
            <!--body wrapper start-->
            <div class="wrapper">
                <!--  -->
                <div class="row">
                    <div class="col-sm-12">
                        <section class="panel">
                            <header class="panel-heading panel-body">
                                <div class="pull-left">
                                    意见反馈
                                </div>
                                <div class="collapse navbar-collapse pull-right">
                                    <div class="form-group">
                                        <select name="msg_status_top" onchange="search()" class="form-control">
                                            <?php if($msg_status_top == null): ?><option value="9" selected="selected">全部</option>
                                                <option value="0">未处理</option>
                                                <option value="1">已处理</option>
                                                <?php elseif($msg_status_top == 1): ?>
                                                <option value="9">全部</option>
                                                <option value="0">未处理</option>
                                                <option value="1" selected="selected">已处理</option><?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="collapse navbar-collapse pull-right">
                                    <div class="navbar-right">
                                        <div class="input-group search-form">
                                            <input type="text" class="form-control" placeholder="搜索内容" name="content"/>
                                            <span class="input-group-btn"><button class="btn btn-default" type="submit">筛选</button></span>
                                        </div>
                                    </div>
                                </div>
                            </header>

                            <div class="">
                                <div class="adv-table">
                                    <table class="display table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th class="text-center">
                                                发布人
                                            </th>
                                            <th class="text-center">
                                                发布内容
                                            </th>
                                            <th class="text-center">
                                                反馈类型
                                            </th>
                                            <th class="text-center">
                                                发布时间
                                            </th>
                                            <th class="text-center">
                                                ip地址
                                            </th>
                                            <th class="text-center">
                                                处理状态
                                            </th>
                                            <th class="text-center">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(is_array($feedback_list)): $i = 0; $__LIST__ = $feedback_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr role="row" align="center" style="background:#FFFFFF;">
                                                <td class="text-center"></td>
                                                <td class="text-center"><?php echo ($list["msg_content"]); ?></td>
                                                <td class="text-center"><?php echo ($msg_type[$list['msg_type']]); ?></td>
                                                <td class="text-center"><?php echo ($list["msg_time"]); ?></td>
                                                <td class="text-center"><?php echo ($list["ip_address"]); ?></td>
                                                <td class="text-center"><?php echo ($msg_status[$list['msg_status']]); ?></td>
                                                <td class="text-center">
                                                    <a href="/index.php/Admin/User/feedback/action/page_edit/id/<?php echo ($list["msg_id"]); ?>"
                                                       data-toggle="tooltip" title="" class="btn btn-default"
                                                       data-original-title="编辑"><i class="fa fa-pencil"></i></a>
                                                </td>
                                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                                        </tbody>
                                    </table>
                                    <div class="row-fluid panel-body">
                                        <div class="span6">
                                            <div class="dataTables_info" id="dynamic-table_info">
                                                <label style="float:left">
                                                    <select class="form-control" size="1" id="page_num" name="page_num"
                                                            aria-controls="dynamic-table" onchange="search()">
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
                                                            <a href="<?php echo U('Admin/User/feedback_list/page_now');?>/<?php echo ($page_now-1); ?>/page_num/<?php echo ($page_num); ?>">
                                                                上一页
                                                            </a>
                                                        </li><?php endif; ?>   <!-- 上一页 end -->

                                                    <?php if($page < 5): ?><!-- 页码条 -->
                                                        <?php $__FOR_START_11009__=1;$__FOR_END_11009__=$page+1;for($i=$__FOR_START_11009__;$i < $__FOR_END_11009__;$i+=1){ ?><!-- 循环四条以内 -->
                                                            <?php if($i == $page_now ): ?><li class="active"><a href=""><?php echo ($i); ?></a></li>
                                                                <?php elseif($i < $page_now ): ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/feedback_list/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/feedback_list/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php elseif($page_now < 3): ?>
                                                        <?php $__FOR_START_19878__=1;$__FOR_END_19878__=6;for($i=$__FOR_START_19878__;$i < $__FOR_END_19878__;$i+=1){ ?><!-- 循环1-5 -->

                                                            <?php if($i == $page_now ): ?><li class="active"><a href=""><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page_now ): ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/feedback_list/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/feedback_list/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php elseif($page_now == $page-1): ?>
                                                        <?php $__FOR_START_21479__=$page_now-3;$__FOR_END_21479__=$page+1;for($i=$__FOR_START_21479__;$i < $__FOR_END_21479__;$i+=1){ ?><!-- 循环当前页为倒数第二页时 -->
                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page ): ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/feedback_list/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/feedback_list/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php elseif($page_now == $page): ?>
                                                        <?php $__FOR_START_19348__=$page_now-4;$__FOR_END_19348__=$page+1;for($i=$__FOR_START_19348__;$i < $__FOR_END_19348__;$i+=1){ ?><!-- 循环当前页为最后一页时 -->
                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page ): ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/feedback_list/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/feedback_list/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php else: ?>
                                                        <?php $__FOR_START_30269__=$page_now-2;$__FOR_END_30269__=$page_now+3;for($i=$__FOR_START_30269__;$i < $__FOR_END_30269__;$i+=1){ ?><!-- 循环除了前五条 和后五条 -->

                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page ): ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/feedback_list/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/feedback_list/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } endif; ?>   <!-- 页码条 end -->

                                                     <?php if(($page_now != $page) AND ($page != 0)): ?><!-- 下一页 -->
                                                        <li class="next ">
                                                            <a href="<?php echo U('Admin/User/feedback_list/page_now/');?>/<?php echo ($page_now+1); ?>/page_num/<?php echo ($page_num); ?>">
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
    // $(document).ready(function(){
    //     $("input[name='msg_status']").val(0);
    //     });
    function search() {
        $('#search').submit();
    }
    $(document).ready(function () {
        //默认选中 
        $("#page_num").val(<?php echo ($page_num); ?>);
    });
</script>
</body>
</html>