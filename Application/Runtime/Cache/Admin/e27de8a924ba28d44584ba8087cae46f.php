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
    <script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
    <!--dynamic table-->
    <link href="<?php echo (JS); ?>/advanced-datatable/css/demo_page.css" rel="stylesheet"/>
    <link href="<?php echo (JS); ?>/advanced-datatable/css/demo_table.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo (JS); ?>/data-tables/DT_bootstrap.css"/>
    <link href="<?php echo (CSS); ?>/style.css" rel="stylesheet">
    <link href="<?php echo (CSS); ?>/style-responsive.css" rel="stylesheet">
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
        <form action="<?php echo U('User/level');?>" id="search" role="search" method="post">
            <!--body wrapper start-->
            <div class="wrapper">
                <!---->
                <div class="row">
                    <div class="col-sm-12">
                        <section class="panel">
                            <header class="panel-heading panel-body">
                                <div class="pull-left" style="line-height: 24px;">
                                    会员等级
                                </div>
                                <div class="collapse navbar-collapse pull-right">
                                    <div class="navbar-right">
                                            <a href="/index.php/Admin/User/level/action/page_add" class="btn btn-default pull-right"><i
                                                    class="fa fa-plus"></i>新增等级</a>
                                    </div>
                                </div>
                            </header>


                            <div class="">
                                <div class="adv-table">
                                    <table class="display table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th width="10%">等级</th>
                                            <th>等级名称</th>
                                            <th>消费额度</th>
                                            <th>折扣率</th>
                                            <th>等级描述</th>
                                            <th width="10%">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(is_array($list)): foreach($list as $k=>$vo): ?><tr role="row" align="center" style="background:#FFFFFF;" id="mod-<?php echo ($vo["level_id"]); ?>">
                                                <td><?php echo ($vo["level_id"]); ?></td>
                                                <td id="name-<?php echo ($vo["level_id"]); ?>"><?php echo ($vo["level_name"]); ?></td>
                                                <td><?php echo ($vo["amount"]); ?></td>
                                                <td><?php echo ($vo["discount"]); ?>%</td>
                                                <td><?php echo ($vo["describe"]); ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-default"
                                                           href="/index.php/Admin/User/level/action/page_edit/id/<?php echo ($vo["level_id"]); ?>"><i
                                                                class="fa fa-pencil"></i></a>
                                                        <a href="#myModal" data-toggle="modal" class="btn btn-default del-level"
                                                           href="javascript:void(0)" data-url="/index.php/Admin/User/level/action/del"
                                                           data-id="<?php echo ($vo["level_id"]); ?>"><i class="fa fa-trash-o"></i></a>
                                                    </div>
                                                </td>
                                            </tr><?php endforeach; endif; ?>

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
                                                            <a href="<?php echo U('Admin/User/level/page_now');?>/<?php echo ($page_now-1); ?>/page_num/<?php echo ($page_num); ?>">
                                                                上一页
                                                            </a>
                                                        </li><?php endif; ?>   <!-- 上一页 end -->

                                                    <?php if($page < 5): ?><!-- 页码条 -->
                                                        <?php $__FOR_START_29905__=1;$__FOR_END_29905__=$page+1;for($i=$__FOR_START_29905__;$i < $__FOR_END_29905__;$i+=1){ ?><!-- 循环四条以内 -->
                                                            <?php if($i == $page_now ): ?><li class="active"><a href=""><?php echo ($i); ?></a></li>
                                                                <?php elseif($i < $page_now ): ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/level/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/level/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php elseif($page_now < 3): ?>
                                                        <?php $__FOR_START_6966__=1;$__FOR_END_6966__=6;for($i=$__FOR_START_6966__;$i < $__FOR_END_6966__;$i+=1){ ?><!-- 循环1-5 -->

                                                            <?php if($i == $page_now ): ?><li class="active"><a href=""><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page_now ): ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/level/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/level/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php elseif($page_now == $page-1): ?>
                                                        <?php $__FOR_START_14903__=$page_now-3;$__FOR_END_14903__=$page+1;for($i=$__FOR_START_14903__;$i < $__FOR_END_14903__;$i+=1){ ?><!-- 循环当前页为倒数第二页时 -->
                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page ): ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/level/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/level/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php elseif($page_now == $page): ?>
                                                        <?php $__FOR_START_15268__=$page_now-4;$__FOR_END_15268__=$page+1;for($i=$__FOR_START_15268__;$i < $__FOR_END_15268__;$i+=1){ ?><!-- 循环当前页为最后一页时 -->
                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page ): ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/level/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/level/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php else: ?>
                                                        <?php $__FOR_START_3341__=$page_now-2;$__FOR_END_3341__=$page_now+3;for($i=$__FOR_START_3341__;$i < $__FOR_END_3341__;$i+=1){ ?><!-- 循环除了前五条 和后五条 -->

                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page ): ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/level/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/level/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } endif; ?>   <!-- 页码条 end -->

                                                     <?php if(($page_now != $page) AND ($page != 0)): ?><!-- 下一页 -->
                                                        <li class="next ">
                                                            <a href="<?php echo U('Admin/User/level/page_now/');?>/<?php echo ($page_now+1); ?>/page_num/<?php echo ($page_num); ?>">
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
<script>

    var url;
    var level_id;
    //删除菜单
    $('.del-level').click(function () {
        url = $(this).attr('data-url');
        level_id = $(this).attr('data-id');
        $("#del_info").html("确定删除:  " + $("#name-" + level_id).html() + " ?");
    });
    function gettrue() {
        $.ajax({
            type: 'post',
            url: url,
            data: {act: 'del', level_id: level_id},
            dataType: 'json',
            success: function (data) {
                if (data.info)
                    layer.alert(data.info);
                else {
                    if (data) {
                        layer.msg('删除成功', {icon: 1});
                        $('#mod-' + level_id).remove();
                    } else {
                        layer.alert('删除失败', {icon: 2});  //alert('删除失败');
                    }
                }
            }
        })
    }

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