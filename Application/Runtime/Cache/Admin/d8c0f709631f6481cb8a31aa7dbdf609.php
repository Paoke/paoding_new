<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="author" content="ThemeBucket">
    <meta name="keywords" content="<?php echo ($tpshop_config['shop_info_store_keyword']); ?>"/>
    <meta name="description" content="<?php echo ($tpshop_config['shop_info_store_desc']); ?>"/>

    <title><?php echo ($gemmapshop_config['shop_info_store_title']); ?></title>

    <!--dynamic table-->
    <link href="<?php echo (CSS); ?>/style.css" rel="stylesheet">
    <link href="<?php echo (CSS); ?>/style-responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<style type="text/css">
.navbar-default { background-color: #fff; border-bottom: 1px solid #e7e7e7; }
.panel{ border: 1px solid #e7e7e7; }
.formadd { padding: 0px; }
.pagination { margin:0; }
.dataTables_paginate { padding:0; }
.panel-heading { border-bottom: 0px solid #ddd; }
</style>
<body class="sticky-header">

<section>

    <!-- main content start-->
    <div class="main-content " width="100%" style="margin:0px;">


        <form action="<?php echo U('Admin/role');?>" id="search" role="search" method="post">
            <!--body wrapper start-->
            <div class="wrapper">
                <!--  -->
                <div class="row">
                    <div class="col-sm-12">
                        <section class="panel">
                            <header class="panel-heading panel-body">
                                <div class="pull-left ">
                                    角色权限管理
                                </div>
                                <div class="pull-right">
                                    <div class="formadd">
                                        <a href="/index.php/Admin/Admin/role/action/page_add" class="btn btn-default pull-right"><i
                                                class="fa fa-plus"></i>添加角色</a>
                                    </div>
                                </div>
                               
                            </header>
                            

                            <div class="">
                                <div class="adv-table">
                                    <table class="display table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th width="25%">角色名称</th>
                                            <th width="60%">角色描述</th>
                                            <th width="15%">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(is_array($list)): foreach($list as $k=>$vo): ?><tr role="row" align="center" style="background:#FFFFFF;">
                                                <td><?php echo ($vo["role_name"]); ?></td>
                                                <td><?php echo ($vo["role_desc"]); ?></td>
                                                <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-default"
                                                               href="/index.php/Admin/Admin/role_user/action/page_list/id/<?php echo ($vo["role_id"]); ?>"
                                                               title="分配角色"><i class="fa fa-group"></i></a>
                                                            <a class="btn btn-default " title="编辑角色"
                                                               href="/index.php/Admin/Admin/role/action/page_edit/id/<?php echo ($vo["role_id"]); ?>"><i
                                                                    class="fa fa-pencil"></i></a>
                                                            <?php if($vo["is_sys"] != 1): ?><a href="#delModal" data-toggle="modal" class="btn btn-default"
                                                               data-name="<?php echo ($vo["role_name"]); ?>" title="删除角色"
                                                               data-url="/index.php/Admin/Admin/role/action/del/id/<?php echo ($vo["role_id"]); ?>"
                                                               onclick="delModal(this)"><i class="fa fa-trash-o"></i></a><?php endif; ?>
                                                        </div>
                                                </td>
                                            </tr><?php endforeach; endif; ?>
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
                                                            <a href="<?php echo U('Admin/Admin/role/page_now');?>/<?php echo ($page_now-1); ?>/page_num/<?php echo ($page_num); ?>">
                                                                上一页
                                                            </a>
                                                        </li><?php endif; ?>   <!-- 上一页 end -->
                                                    <?php if($page < 5): ?><!-- 页码条 -->
                                                        <?php $__FOR_START_13506__=1;$__FOR_END_13506__=$page+1;for($i=$__FOR_START_13506__;$i < $__FOR_END_13506__;$i+=1){ ?><!-- 循环四条以内 -->
                                                            <?php if($i == $page_now ): ?><li class="active"><a href=""><?php echo ($i); ?></a></li>
                                                                <?php elseif($i < $page_now ): ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/Admin/role/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/Admin/role/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php elseif($page_now < 3): ?>
                                                        <?php $__FOR_START_17107__=1;$__FOR_END_17107__=6;for($i=$__FOR_START_17107__;$i < $__FOR_END_17107__;$i+=1){ ?><!-- 循环1-5 -->

                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page_now ): ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/Admin/role/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/Admin/role/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php elseif($page_now == $page-1): ?>
                                                        <?php $__FOR_START_28176__=$page_now-3;$__FOR_END_28176__=$page+1;for($i=$__FOR_START_28176__;$i < $__FOR_END_28176__;$i+=1){ ?><!-- 循环当前页为倒数第二页时 -->
                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page ): ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/Admin/role/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/Admin/role/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php elseif($page_now == $page): ?>
                                                        <?php $__FOR_START_27913__=$page_now-4;$__FOR_END_27913__=$page+1;for($i=$__FOR_START_27913__;$i < $__FOR_END_27913__;$i+=1){ ?><!-- 循环当前页为最后一页时 -->
                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page ): ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/Admin/role/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/Admin/role/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php else: ?>
                                                        <?php $__FOR_START_23310__=$page_now-2;$__FOR_END_23310__=$page_now+3;for($i=$__FOR_START_23310__;$i < $__FOR_END_23310__;$i+=1){ ?><!-- 循环除了前五条 和后五条 -->

                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page ): ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/Admin/role/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/Admin/role/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } endif; ?>   <!-- 页码条 end -->

                                                     <?php if(($page_now != $page) AND ($page != 0)): ?><!-- 下一页 -->
                                                        <li class="next ">
                                                            <a href="<?php echo U('Admin/Admin/role/page_now/');?>/<?php echo ($page_now+1); ?>/page_num/<?php echo ($page_num); ?>">
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

<script src="/Public/js/jquery-1.9.1.min.js"></script>
<script src="/Public/js/myFormValidate.js"></script>
<script src="/Public/js/layer/layer-min.js"></script>
<script src="/Public/js/bootstrap.js" type="text/javascript"></script>
<!-- Placed js at the end of the document so the pages load faster -->
<script src="<?php echo (JS); ?>/jquery.nicescroll.js"></script>
<!--common scripts for all pages-->
<script src="<?php echo (JS); ?>/scripts.js"></script>
<script src="/Public/js/myAjax.js"></script>

</body>
</html>


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