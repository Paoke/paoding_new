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
    <link href="<?php echo (JS); ?>/advanced-datatable/css/demo_page.css" rel="stylesheet"/>
    <link href="<?php echo (JS); ?>/advanced-datatable/css/demo_table.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo (JS); ?>/data-tables/DT_bootstrap.css"/>
    <link href="<?php echo (CSS); ?>/style.css" rel="stylesheet">
    <link href="<?php echo (CSS); ?>/style-responsive.css" rel="stylesheet">
    <!-- tpshop自带的矢量图标库 font-awesome.min.css-->
    <link href="/Public/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
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
    .pull-right{margin-bottom:5px;}
    .navbar-form{overflow: hidden;}
    .panel-body.formadd{float: right;}
    .table-bordered {
     border-top: none ;
}

</style>

<body class="sticky-header">

<section>

    <!-- main content start-->
    <div class="main-content" width="100%" style="margin:0px;">


        <!--body wrapper start-->
        <div class="wrapper">
            <!--  -->
            <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading panel-body ">
                            <div class="pull-left ">
                                应用频道列表
                            </div>
                            <div class="pull-right">
                                <div class="btn-group">

                                    <a href="/index.php/Admin/Channel/channel_type" class="btn btn-default"><i
                                            class="fa fa-plus"></i>新增频道</a>

                                </div>
                            </div>
                        </header>

                        <form id="search" role="search" method="post">
                        <div class="panel-body">
                            <div class="adv-table">
                                <table id="list-table" class="table table-bordered table-striped dataTable" role="grid"
                                       aria-describedby="example1_info">
                                    <thead>
                                    <tr role="row">
                                        <th valign="middle" align="left">频道名称</th>
                                        <th valign="middle" width="15%">基础模型</th>
                                        <th valign="middle" width="15%">调用别名</th>
                                        <th valign="middle" width="10%">排序</th>
                                        <th valign="middle" width="10%">启用</th>
                                        <th valign="middle" width="30%">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($list)): foreach($list as $k=>$vo): ?><tr role="row" align="center" id="<?php echo ($vo["id"]); ?>">
                                            <td >
                                                <?php echo ($vo["channel_title"]); ?>
                                            </td>
                                            <td><?php echo ($vo["base_module"]); ?></td>
                                            <td><?php echo ($vo["call_index"]); ?></td>


                                            <td>
                                                <input type="text"
                                                       onchange="updateSort('<?php echo ($vo["id"]); ?>',this)"
                                                       onkeyup="this.value=this.value.replace(/[^\d]/g,'')" maxlength="4" size="4"
                                                       value="<?php echo ($vo["sort_id"]); ?>"
                                                       class="input-sm"/>
                                            </td>

                                            <td>
                                                <img width="20" height="20" src="/Public/images/<?php if($vo[is_active] == 1): ?>yes.png<?php else: ?>cancel.png<?php endif; ?>"
                                                     onclick="changeTableVal('<?php echo ($mod_id); ?>','Admin','admin_id','<?php echo ($vo["admin_id"]); ?>','is_active',this)"/>
                                            </td>

                                            <td>
                                                <div class="btn-group">
                                                    <a class="btn btn-default"
                                                       href="/index.php/Admin/ChannelConfig/page_config/action/page_edit/id/<?php echo ($vo["list_type_data_id"]); ?>" title="编辑"><i class="fa fa-heart-o"></i>风格</a>
                                                    <a class="btn btn-default"
                                                       href="/index.php/Admin/Channel/channel/action/page_edit/id/<?php echo ($vo["id"]); ?>/flow/2" title="编辑"><i class="fa fa-laptop"></i>配置 </a>
                                                    <a href="#myModal" data-toggle="modal" class="btn btn-default del-channel"
                                                       channel-name="<?php echo ($vo["channel_title"]); ?>"
                                                       data-url="/index.php/Admin/Channel/channel/action/del/id/<?php echo ($vo["id"]); ?>" data-id="<?php echo ($vo["id"]); ?>"
                                                       title="删除"><i class="fa fa-trash-o"></i>删除</a>

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
                                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                <h4 class="modal-title">信息</h4>
                                            </div>
                                            <div class="modal-body" id="del_info">

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="del_channel();">
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
                                                <span class="wenzi" style="float:left">条每页，总共 <?php echo ($count); ?> 条</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="dataTables_paginate paging_bootstrap pagination">
                                            <ul>
                                                <?php if($page_now <= 1): ?><!-- 上一页 -->
                                                    <li class="prev disabled">
                                                        <a href="#">
                                                            上一页
                                                        </a>
                                                    </li>
                                                    <?php else: ?>
                                                    <li class="prev">
                                                        <a href="/index.php/Admin/Channel/channel/action/page_list/page_now/<?php echo ($page_now-1); ?>/page_num/<?php echo ($page_num); ?>">
                                                            上一页
                                                        </a>
                                                    </li><?php endif; ?>   <!-- 上一页 end -->

                                                <?php if($page < 5): ?><!-- 页码条 -->
                                                    <?php $__FOR_START_19840__=1;$__FOR_END_19840__=$page+1;for($i=$__FOR_START_19840__;$i < $__FOR_END_19840__;$i+=1){ ?><!-- 循环四条以内 -->
                                                        <?php if($i == $page_now ): ?><li class="active"><a href=""><?php echo ($i); ?></a></li>
                                                            <?php elseif($i < $page_now ): ?>
                                                            <li><a href="/index.php/Admin/Channel/channel/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                            </li>
                                                            <?php else: ?>
                                                            <li><a href="/index.php/Admin/Channel/channel/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                            </li><?php endif; } ?>
                                                    <?php elseif($page_now < 3): ?>
                                                    <?php $__FOR_START_12217__=1;$__FOR_END_12217__=6;for($i=$__FOR_START_12217__;$i < $__FOR_END_12217__;$i+=1){ ?><!-- 循环1-5 -->

                                                        <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                            <?php elseif($i < $page_now ): ?>
                                                            <li><a href="/index.php/Admin/Channel/channel/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                            </li>
                                                            <?php else: ?>
                                                            <li><a href="/index.php/Admin/Channel/channel/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                            </li><?php endif; } ?>
                                                    <?php elseif($page_now == $page-1): ?>
                                                    <?php $__FOR_START_24574__=$page_now-3;$__FOR_END_24574__=$page+1;for($i=$__FOR_START_24574__;$i < $__FOR_END_24574__;$i+=1){ ?><!-- 循环当前页为倒数第二页时 -->
                                                        <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                            <?php elseif($i < $page ): ?>
                                                            <li><a href="/index.php/Admin/Channel/channel/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                            </li>
                                                            <?php else: ?>
                                                            <li><a href="/index.php/Admin/Channel/channel/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                            </li><?php endif; } ?>
                                                    <?php elseif($page_now == $page): ?>
                                                    <?php $__FOR_START_29535__=$page_now-4;$__FOR_END_29535__=$page+1;for($i=$__FOR_START_29535__;$i < $__FOR_END_29535__;$i+=1){ ?><!-- 循环当前页为最后一页时 -->
                                                        <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                            <?php elseif($i < $page ): ?>
                                                            <li><a href="/index.php/Admin/Channel/channel/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                            </li>
                                                            <?php else: ?>
                                                            <li><a href="/index.php/Admin/Channel/channel/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                            </li><?php endif; } ?>
                                                    <?php else: ?>
                                                    <?php $__FOR_START_16812__=$page_now-2;$__FOR_END_16812__=$page_now+3;for($i=$__FOR_START_16812__;$i < $__FOR_END_16812__;$i+=1){ ?><!-- 循环除了前五条 和后五条 -->

                                                        <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                            <?php elseif($i < $page ): ?>
                                                            <li><a href="/index.php/Admin/Channel/channel/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                            </li>
                                                            <?php else: ?>
                                                            <li><a href="/index.php/Admin/Channel/channel/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                            </li><?php endif; } endif; ?>   <!-- 页码条 end -->

                                                 <?php if(($page_now != $page) AND ($page != 0)): ?><!-- 下一页 -->
                                                    <li class="next ">
                                                        <a href="/index.php/Admin/Channel/channel/action/page_list/page_now/<?php echo ($page_now+1); ?>/page_num/<?php echo ($page_num); ?>">
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
                        </form>
                    </section>
                </div>
            </div>
        </div>
        <!--body wrapper end-->
    </div>
    <!-- main content end-->
</section>

<script src="/Public/js/jquery-1.9.1.min.js" type="text/javascript"></script>
<!--common scripts for all pages-->
<script src="<?php echo (JS); ?>/jquery.nicescroll.js"></script>
<script src="<?php echo (JS); ?>/scripts.js"></script>


</body>
</html>
<script>
    var url;
    var channel_id;
    var channel_name;
    var obj;
    //删除菜单
    $('.del-channel').click(function(){
        obj=$(this);
        url = $(this).attr('data-url');
        channel_id = $(this).attr('data-id');
        channel_name = $(this).attr('channel-name');
        $("#del_info").html(" 是否确认删除【"+channel_name+"】频道?");
    });

    function del_channel(){

        $.get(url, function(ret){
            if (ret.result == 1) {
                layer.msg(ret.msg);
                obj.parent().parent().parent().remove();
            } else {
                layer.msg(ret.msg);
            }

        }, 'json');

    }

    function search(){
        $('#search').submit();
    }
    $(document).ready(function () {
        //默认选中
        $("#page_num").val(<?php echo ($page_num); ?>);
    });

    // 修改指定表的排序字段
    function updateSort(id_value,obj)
    {
        var value = $(obj).val();
        $.get("/index.php?m=Admin&c=Channelm&a=channel&action=sort&id="+id_value+"&sort_id="+value, function(ret){
            if (ret.result == 1) {
                layer.msg(ret.msg);
                obj.parent().parent().parent().parent().parent().remove();
            } else {
                layer.msg(ret.msg);
            }

        }, 'json');
    }
</script>