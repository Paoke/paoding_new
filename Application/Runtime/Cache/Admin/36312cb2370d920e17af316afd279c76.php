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
    <!--GEMMAP自带的矢量图标库 font-awesome.min.css-->
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

    .panel {
        border: 1px solid #ddd;
    }

    .formadd {
        padding: 5px 0;
        float: right;
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
   font-size:16px;
}

    .btn-primary,.btn-danger{background:#fff;border-color:#ccc ;}
    .btn-primary i,.btn-danger i{color:#333;}
    .del{background-color: #f12b2b !important;color: #333;}
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
                                    文本回复 选择公众号:
                                    <select id="select_wx">
                                        <?php if(is_array($wechat_list)): $i = 0; $__LIST__ = $wechat_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><option value="<?php echo ($list["id"]); ?>"
                                            <?php if($list['id'] == $wechat_id): ?>selected<?php endif; ?>
                                            ><?php echo ($list["wxname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </div>
                                <div class="collapse navbar-collapse pull-right">
                                    <div class="navbar-right">
                                            <a href="/index.php/Admin/Wechat/text/action/page_add/wechat_id/<?php echo ($wechat_id); ?>">
                                                <button type="button" class="btn btn-default">
                                                    <i class="ace-icon fa fa-plus bigger-110"></i>添加文本回复
                                                </button>
                                            </a>
                                    </div>
                                </div>
                            </header>

                            <div class="">
                                <div class="adv-table">
                                    <table class="display table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th class="text-center">
                                                关键词
                                            </th>
                                            <th class="text-center">
                                                回答
                                            </th>
                                            <th class="text-center" width="10%">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr role="row" align="center" style="background:#FFFFFF;">
                                                <td class="text-center"><?php echo ($list["keyword"]); ?></td>
                                                <td class="text-center"><?php echo ($list["text"]); ?></td>
                                                <td class="text-center">
                                                    <a href="/index.php/Admin/Wechat/text/action/page_edit/id/<?php echo ($list["id"]); ?>/wechat_id/<?php echo ($wechat_id); ?>"
                                                       data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="编辑"><i
                                                            class="fa fa-pencil"></i></a>
                                                    <a href="#delModal" data-toggle="modal" class="btn btn-danger del-text"
                                                       data-url="/index.php/Admin/Wechat/text/action/del/id/<?php echo ($list["id"]); ?>"
                                                       onclick="delModal(this)"
                                                       data-id="<?php echo ($list['id']); ?>" data-name="<?php echo ($list["keyword"]); ?>"><i
                                                            class="fa fa-trash-o"></i></a>

                                                </td>
                                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                                        </tbody>
                                    </table>
                                    <!-- Modal -->
                                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="delModal"
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
                                                    <button type="button" class="btn btn-danger del" data-dismiss="modal"
                                                            onclick="del_module();"> 确定
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
                                                            <a href="/index.php/Admin/Wechat/text/action/page_list/page_now/<?php echo ($page_now-1); ?>/page_num/<?php echo ($page_num); ?>">
                                                                上一页
                                                            </a>
                                                        </li><?php endif; ?>   <!-- 上一页 end -->
                                                    <?php if($page < 5): ?><!-- 页码条 -->
                                                        <?php $__FOR_START_809891752__=1;$__FOR_END_809891752__=$page+1;for($i=$__FOR_START_809891752__;$i < $__FOR_END_809891752__;$i+=1){ ?><!-- 循环四条以内 -->
                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($i); ?></a></li>
                                                                <?php elseif($i < $page_now ): ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/Wechat/text/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/Wechat/text/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php elseif($page_now < 3): ?>
                                                        <?php $__FOR_START_208858198__=1;$__FOR_END_208858198__=6;for($i=$__FOR_START_208858198__;$i < $__FOR_END_208858198__;$i+=1){ ?><!-- 循环1-5 -->

                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page_now ): ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/Wechat/text/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/Wechat/text/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php elseif($page_now == $page-1): ?>
                                                        <?php $__FOR_START_711347955__=$page_now-3;$__FOR_END_711347955__=$page+1;for($i=$__FOR_START_711347955__;$i < $__FOR_END_711347955__;$i+=1){ ?><!-- 循环当前页为倒数第二页时 -->
                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page ): ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/Wechat/text/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/Wechat/text/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php elseif($page_now == $page): ?>
                                                        <?php $__FOR_START_1967177349__=$page_now-4;$__FOR_END_1967177349__=$page+1;for($i=$__FOR_START_1967177349__;$i < $__FOR_END_1967177349__;$i+=1){ ?><!-- 循环当前页为最后一页时 -->
                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page ): ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/Wechat/text/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/Wechat/text/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php else: ?>
                                                        <?php $__FOR_START_9521441__=$page_now-2;$__FOR_END_9521441__=$page_now+3;for($i=$__FOR_START_9521441__;$i < $__FOR_END_9521441__;$i+=1){ ?><!-- 循环除了前五条 和后五条 -->

                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page ): ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/Wechat/text/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/Wechat/text/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } endif; ?>   <!-- 页码条 end -->

                                                     <?php if(($page_now != $page) AND ($page != 0)): ?><!-- 下一页 -->
                                                        <li class="next ">
                                                            <a href="/index.php/Admin/Wechat/text/action/page_list/page_now/<?php echo ($page_now+1); ?>/page_num/<?php echo ($page_num); ?>">
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
<script src="<?php echo (JS); ?>/jquery-1.10.2.min.js"></script>
<script src="<?php echo (JS); ?>/jquery-ui-1.9.2.custom.min.js"></script>

<script src="<?php echo (JS); ?>/bootstrap.min.js"></script>

<script src="<?php echo (JS); ?>/jquery.nicescroll.js"></script>
<!--dynamic table-->
<script type="text/javascript" language="javascript" src="<?php echo (JS); ?>/advanced-datatable/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo (JS); ?>/data-tables/DT_bootstrap.js"></script>
<!--dynamic table initialization -->
<script src="<?php echo (JS); ?>/dynamic_table_init.js"></script>

<!--common scripts for all pages-->
<script src="<?php echo (JS); ?>/scripts.js"></script>
<script src="/Public/js/layer/layer-min.js"></script>
<script>
    //切换公众号
    $("#select_wx").change(function () {
        var id = $(this).val();
        location.href = "/index.php/Admin/Wechat/text/action/page_list" + "/id/" + id;

    });
    var modal_url;
    var modal_name;
    var modal_object;
    //删除菜单
    function delModal(obj) {
        modal_object = $(obj);
        modal_url = $(obj).attr('data-url');
        modal_name = $(obj).attr('data-name');
        $("#del_info").html(" 是否删除关键字【" + modal_name + "】?");
    }

    function del_module() {
        $.get(modal_url, function (res) {
            if (res.result == 1) {
                layer.msg(res.msg);
                modal_object.parent().parent().remove();
            } else {
                layer.msg(res.msg);
            }

        });
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