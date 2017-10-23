<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="author" content="ThemeBucket">
    <meta name="keywords" content="<?php echo ($tpshop_config['shop_info_store_keyword']); ?>"/>
    <meta name="description" content="<?php echo ($tpshop_config['shop_info_store_desc']); ?>"/>

    <title><?php echo ($gemmapshop_config['shop_info_store_title']); ?></title>

    <link rel="shortcut icon" href="#" type="image/png">
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


        <form action="#" id="search" role="search" method="post">
            <!--body wrapper start-->
            <div class="wrapper">
                <!--  -->
                <div class="row">
                    <div class="col-sm-12">
                        <section class="panel">
                            <header class="panel-heading panel-body">
                                <div class="pull-left ">
                                   功能介绍
                                </div>
                                <div class="pull-right">
                                    <div class="formadd">
                                        <a href="/index.php/Admin/System/introduction/action/page_add" class="btn btn-default pull-right"><i
                                                class="fa fa-plus"></i>添加介绍</a>
                                    </div>
                                </div>
                               
                            </header>
                            

                            <div class="">
                                <div class="adv-table">
                                    <table class="display table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>标题</th>
                                            <th width="35%">详细</th>
                                            <th width="20%">创建时间</th>
                                            <th width="10%">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(is_array($list)): foreach($list as $k=>$vo): ?><tr role="row" align="center" style="background:#FFFFFF;">
                                                <td><?php echo ($vo["title"]); ?></td>
                                                <td><?php echo ($vo["content"]); ?></td>
                                                <td><?php echo ($vo["create_time"]); ?></td>
                                                <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-default "
                                                               href="/index.php/Admin/System/introduction/action/page_edit/id/<?php echo ($vo["id"]); ?>"><i
                                                                    class="fa fa-pencil"></i></a>
                                                            <a href="#delModal" data-toggle="modal" class="btn btn-default"
                                                               data-name="<?php echo ($vo["title"]); ?>" title="删除"
                                                               data-url="/index.php/Admin/System/introduction/action/del/id/<?php echo ($vo["id"]); ?>"
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
                                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×
                                                    </button>
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
                                                            <a href="/index.php/Admin/System/introduction/action/page_list/page_now/<?php echo ($page_now-1); ?>/page_num/<?php echo ($page_num); ?>">
                                                                上一页
                                                            </a>
                                                        </li><?php endif; ?>   <!-- 上一页 end -->
                                                    <?php if($page < 5): ?><!-- 页码条 -->
                                                        <?php $__FOR_START_1587917546__=1;$__FOR_END_1587917546__=$page+1;for($i=$__FOR_START_1587917546__;$i < $__FOR_END_1587917546__;$i+=1){ ?><!-- 循环四条以内 -->
                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($i); ?></a></li>
                                                                <?php elseif($i < $page_now ): ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/System/introduction/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/System/introduction/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php elseif($page_now < 3): ?>
                                                        <?php $__FOR_START_1413805654__=1;$__FOR_END_1413805654__=6;for($i=$__FOR_START_1413805654__;$i < $__FOR_END_1413805654__;$i+=1){ ?><!-- 循环1-5 -->

                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page_now ): ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/System/introduction/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/System/introduction/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php elseif($page_now == $page-1): ?>
                                                        <?php $__FOR_START_115586934__=$page_now-3;$__FOR_END_115586934__=$page+1;for($i=$__FOR_START_115586934__;$i < $__FOR_END_115586934__;$i+=1){ ?><!-- 循环当前页为倒数第二页时 -->
                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page ): ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/System/introduction/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/System/introduction/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php elseif($page_now == $page): ?>
                                                        <?php $__FOR_START_106209352__=$page_now-4;$__FOR_END_106209352__=$page+1;for($i=$__FOR_START_106209352__;$i < $__FOR_END_106209352__;$i+=1){ ?><!-- 循环当前页为最后一页时 -->
                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page ): ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/System/introduction/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/System/introduction/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php else: ?>
                                                        <?php $__FOR_START_793417196__=$page_now-2;$__FOR_END_793417196__=$page_now+3;for($i=$__FOR_START_793417196__;$i < $__FOR_END_793417196__;$i+=1){ ?><!-- 循环除了前五条 和后五条 -->

                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page ): ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/System/introduction/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/System/introduction/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } endif; ?>   <!-- 页码条 end -->

                                                     <?php if(($page_now != $page) AND ($page != 0)): ?><!-- 下一页 -->
                                                        <li class="next ">
                                                            <a href="/index.php/Admin/System/introduction/action/page_list/page_now/<?php echo ($page_now+1); ?>/page_num/<?php echo ($page_num); ?>">
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