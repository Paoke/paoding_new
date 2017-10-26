<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
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
    <!-- gemmap自带的矢量图标库 font-awesome.min.css-->
    <link href="/Public/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<style type="text/css">
    .navbar-default {
        background-color: #fff;
        border-bottom: 1px solid #e7e7e7;
    }

    body {
        background: #eff0f4;
    }

    .main-content {
        min-height: 100%;
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
                                    消息列表
                                </div>
                                <div class="collapse navbar-collapse pull-right">
                                    <div class=" navbar-right">
                                            <a href="/index.php/Admin/User/message/action/page_add"
                                               class="btn btn-default pull-right"><i class="fa fa-plus"></i>发送消息</a>
                                    </div>
                                </div>
                            </header>


                            <div class="">
                                <div class="adv-table">
                                    <form method="post" enctype="multipart/form-data" target="_blank" id="form-order">
                                        <table class="display table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th class="text-center fontsize">消息ID</th>
                                                <th class="text-center fontsize">类型</th>
                                                <th class="text-center fontsize">发件人</th>
                                                <th class="text-center fontsize">收件人</th>
                                                <th class="text-center fontsize">内容</th>
                                                <th class="text-center fontsize">状态</th>
                                                <th class="text-center fontsize">发送时间</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if(is_array($messageList)): $i = 0; $__LIST__ = $messageList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr>
                                                    <td class="text-center" style="padding: 10px;"><?php echo ($list["id"]); ?></td>
                                                    <td class="text-center">
                                                        <?php if($list["type"] == 0): ?>系统消息
                                                            <?php else: ?>
                                                            其他消息<?php endif; ?>
                                                    <td class="text-center">
                                                        <?php if($list["is_sys"] == 1): echo ($list["user_name"]); ?>
                                                            <?php else: ?>
                                                            <?php echo ($list["nickname"]); endif; ?>
                                                    </td>
                                                    <td class="text-center"><?php echo ($list["accept_nickname"]); ?></td>
                                                    <td class="text-center" title="<?php echo ($list["contentall"]); ?>"><?php echo ($list["content"]); ?></td>
                                                    <td class="text-center">
                                                        <?php if($list["is_read"] == 1): ?>已阅
                                                            <?php else: ?>
                                                            未阅<?php endif; ?>
                                                    </td>
                                                    <td class="text-center"><?php echo ($list["post_time"]); ?></td>
                                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </tbody>
                                        </table>
                                        <!-- Modal -->
                                        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal"
                                             class="modal fade">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×
                                                        </button>
                                                        <h4 class="modal-title">信息</h4>
                                                    </div>
                                                    <div class="modal-body" id="del_info">

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                                onclick="gettrue();"> 确定
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
                                                        <select class="form-control" size="1" id="page_num"
                                                                name="page_num" aria-controls="dynamic-table"
                                                                onchange="search()">
                                                            <option value="25"
                                                            <?php if($page_num == 25): ?>selected<?php endif; ?>
                                                            >25</option>
                                                            <option value="50"
                                                            <?php if($page_num == 50): ?>selected<?php endif; ?>
                                                            >50</option>
                                                            <option value="100"
                                                            <?php if($page_num == 100): ?>selected<?php endif; ?>
                                                            >100</option>
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
                                                                <a href="<?php echo U('Admin/User/message/page_now');?>/<?php echo ($page_now-1); ?>/page_num/<?php echo ($page_num); ?>">
                                                                    上一页
                                                                </a>
                                                            </li><?php endif; ?>   <!-- 上一页 end -->
                                                        <?php if($page < 5): ?><!-- 页码条 -->
                                                            <?php $__FOR_START_1158__=1;$__FOR_END_1158__=$page+1;for($i=$__FOR_START_1158__;$i < $__FOR_END_1158__;$i+=1){ ?><!-- 循环四条以内 -->
                                                                <?php if($i == $page_now ): ?><li class="active"><a href=""><?php echo ($i); ?></a></li>
                                                                    <?php elseif($i < $page_now ): ?>
                                                                    <li>
                                                                        <a href="<?php echo U('Admin/User/message/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                    </li>
                                                                    <?php else: ?>
                                                                    <li>
                                                                        <a href="<?php echo U('Admin/User/message/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                    </li><?php endif; } ?>
                                                            <?php elseif($page_now < 3): ?>
                                                            <?php $__FOR_START_28999__=1;$__FOR_END_28999__=6;for($i=$__FOR_START_28999__;$i < $__FOR_END_28999__;$i+=1){ ?><!-- 循环1-5 -->

                                                                <?php if($i == $page_now ): ?><li class="active"><a href=""><?php echo ($page_now); ?></a></li>
                                                                    <?php elseif($i < $page_now ): ?>
                                                                    <li>
                                                                        <a href="<?php echo U('Admin/User/message/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                    </li>
                                                                    <?php else: ?>
                                                                    <li>
                                                                        <a href="<?php echo U('Admin/User/message/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                    </li><?php endif; } ?>
                                                            <?php elseif($page_now == $page-1): ?>
                                                            <?php $__FOR_START_3444__=$page_now-3;$__FOR_END_3444__=$page+1;for($i=$__FOR_START_3444__;$i < $__FOR_END_3444__;$i+=1){ ?><!-- 循环当前页为倒数第二页时 -->
                                                                <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                    <?php elseif($i < $page ): ?>
                                                                    <li>
                                                                        <a href="<?php echo U('Admin/User/message/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                    </li>
                                                                    <?php else: ?>
                                                                    <li>
                                                                        <a href="<?php echo U('Admin/User/message/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                    </li><?php endif; } ?>
                                                            <?php elseif($page_now == $page): ?>
                                                            <?php $__FOR_START_17053__=$page_now-4;$__FOR_END_17053__=$page+1;for($i=$__FOR_START_17053__;$i < $__FOR_END_17053__;$i+=1){ ?><!-- 循环当前页为最后一页时 -->
                                                                <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                    <?php elseif($i < $page ): ?>
                                                                    <li>
                                                                        <a href="<?php echo U('Admin/User/message/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                    </li>
                                                                    <?php else: ?>
                                                                    <li>
                                                                        <a href="<?php echo U('Admin/User/message/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                    </li><?php endif; } ?>
                                                            <?php else: ?>
                                                            <?php $__FOR_START_25362__=$page_now-2;$__FOR_END_25362__=$page_now+3;for($i=$__FOR_START_25362__;$i < $__FOR_END_25362__;$i+=1){ ?><!-- 循环除了前五条 和后五条 -->

                                                                <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                    <?php elseif($i < $page ): ?>
                                                                    <li>
                                                                        <a href="<?php echo U('Admin/User/message/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                    </li>
                                                                    <?php else: ?>
                                                                    <li>
                                                                        <a href="<?php echo U('Admin/User/message/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                    </li><?php endif; } endif; ?>   <!-- 页码条 end -->

                                                         <?php if(($page_now != $page) AND ($page != 0)): ?><!-- 下一页 -->
                                                            <li class="next ">
                                                                <a href="<?php echo U('Admin/User/message/page_now/');?>/<?php echo ($page_now+1); ?>/page_num/<?php echo ($page_num); ?>">
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
                                    </form>
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
<script src="<?php echo (JS); ?>/jquery-1.10.2.min.js"></script>
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
<script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
<script>
    function search() {
        $('#search').submit();
    }
</script>
</body>
</html>