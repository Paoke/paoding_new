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
    <!-- form -->
    <link href="<?php echo (JS); ?>/form/scripts/plugins/wizard/wizard.css" rel="stylesheet"/>

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

    .panel {
        border: 1px solid #e7e7e7;
    }

    .formadd {
        padding: 0px;
    }

    .pull-right {

        margin-bottom: 5px;
    }

    .navbar-form {
        overflow: hidden;
    }

    .panel-body.formadd {
        float: right;
    }

    .update-btn {
        height: 30px;
        border: 1px solid #e7e7e7;
        background: #e0e0e0;
    }

    .table-bordered {
        border-top: none;
    }

</style>

<body style="overflow-y: scroll;">

<section>

    <!-- main content start-->
    <div class="main-content" width="100%" style="margin:0px;">
        <section class="wrapper">

            <div class="wizard" data-target="#wizard-steps" style="margin-bottom: 5px">

                <?php if($flow == 2): ?><ul class="flow-steps">
                        <li data-target="#step-1" class="active"
                            href="/index.php/Admin/Channel/channel/action/page_edit/flow/<?php echo ($flow); ?>/channel/<?php echo ($channel); ?>">
                            <span class="step">1</span>基本配置<span class="chevron"></span>
                        </li>
                        <li data-target="#step-2" class="active"
                            href="/index.php/Admin/Channel/channelField/action/channel_field/type/1/channel/<?php echo ($channel); ?>/flow/<?php echo ($flow); ?>">
                            <span class="step">2</span>表单内容配置<span class="chevron"></span>
                        </li>

                        <li data-target="#step-3"
                        <?php if($type == 1): ?>class="complete"
                            <?php else: ?>
                            class="active"<?php endif; ?>
                        href="/index.php/Admin/Channel/channelField/action/list/type/1/channel/<?php echo ($channel); ?>/flow/<?php echo ($flow); ?>">
                        <span class="step">3</span>表单列表配置<span class="chevron"></span>
                        </li>
                        <li data-target="#step-6" class="active"><span class="step">4</span>配置完成<span
                                class="chevron"></span></li>
                    </ul>

                    <?php else: ?>
                    <ul class="flow-steps">
                        <li data-target="#step-1"><span class="step">1</span>基本配置<span class="chevron"></span></li>
                        <li data-target="#step-2"><span class="step">2</span>表单内容配置<span class="chevron"></span></li>
                        <li data-target="#step-3"
                        <?php if($type == 1): ?>class="active"<?php endif; ?>
                        ><span class="step">3</span>表单列表配置<span class="chevron"></span>
                        </li>
                        <li id="finish_li" data-target="#step-6"><span class="step">6</span>配置完成<span
                                class="chevron"></span></li>
                    </ul><?php endif; ?>
            </div>

            <!--body wrapper start-->
            <div class="wrapper-content">
                <div class="row">
                    <div class="col-sm-12">
                        <section class="panel">
                            <header class="panel-heading">
                                <div class="pull-left">
                                    <?php if($type == 1): ?>表单内容字段列表配置
                                        <?php else: ?>
                                        栏目内容字段列表配置<?php endif; ?>
                                </div>

                                <div class="pull-right ">
                                    <div class="btn-group">

                                        <a href="javascript:void(0);" id="update_width" class="btn btn-default"><i
                                                class="fa fa-floppy-o"></i>保存配置</a>
                                        <a class="btn btn-default" onclick="flowFinish()";>
                                        <i class="fa fa-mail-forward"></i> &nbsp;下一步
                                        </a>

                                    </div>
                                </div>
                            </header>
                            <input type="hidden" id="flow" name="flow" value="<?php echo ($flow); ?>">
                            <div class="panel-body">
                                <div class="adv-table">
                                    <table id="list-table" class="table table-bordered table-striped dataTable"
                                           role="grid"
                                           aria-describedby="example1_info">
                                        <thead>
                                        <tr role="row">
                                            <th valign="middle" width="10%" style="display: none; text-align: left">ID
                                            </th>
                                            <th valign="middle">应用模块名称</th>
                                            <th valign="middle">字段名称</th>
                                            <th valign="middle">表头列名</th>
                                            <th valign="middle">列宽(px)</th>
                                            <th valign="middle">列表显示</th>
                                            <th valign="middle">管理后台启用</th>
                                            <th valign="middle">手机模板启用</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tb">
                                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr role="row" align="center" id="tr_<?php echo ($vo["id"]); ?>">
                                                <td><?php echo ($channel_title); ?></td>
                                                <td><?php echo ($vo["name"]); ?></td>
                                                <td><?php echo ($vo["title"]); ?></td>
                                                <td><input type="text" name="width" class="width_input input-sm"
                                                           style="width: 60px" data-id="<?php echo ($vo["id"]); ?>" data="<?php echo ($vo["width"]); ?>"
                                                           value="<?php echo ($vo["width"]); ?>"></td>
                                                <td><img width="20" height="20"
                                                    <?php if($vo["show_list"] == 1): ?>src="/Public/images/yes.png"
                                                        <?php else: ?>
                                                        src="/Public/images/cancel.png"<?php endif; ?>
                                                    onclick="changeTableVal('channelFiled', 'SystemChannelFormField',
                                                    'id', <?php echo ($vo["id"]); ?>, 'show_list', this)">
                                                </td>
                                                <td><img width="20" height="20"
                                                    <?php if($vo["admin_use"] == 1): ?>src="/Public/images/yes.png"
                                                        <?php else: ?>
                                                        src="/Public/images/cancel.png"<?php endif; ?>
                                                    onclick="changeTableVal('channelFiled', 'SystemChannelFormField',
                                                    'id', <?php echo ($vo["id"]); ?>, 'admin_use', this)">
                                                </td>
                                                <td><img width="20" height="20"
                                                    <?php if($vo["mobile_use"] == 1): ?>src="/Public/images/yes.png"
                                                        <?php else: ?>
                                                        src="/Public/images/cancel.png"<?php endif; ?>
                                                    "
                                                    onclick="changeTableVal('channelFiled', 'SystemChannelFormField',
                                                    'id', <?php echo ($vo["id"]); ?>, 'mobile_use', this)">
                                                </td>

                                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </tbody>
                                    </table>
                                    <!-- Modal -->
                                    <div id="myModal">
                                    </div>
                                    <!-- modal -->
                                    <div class="row-fluid">
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
                                                            <a href="<?php echo U('Admin/Template/specList/page_now');?>/<?php echo ($page_now-1); ?>/page_num/<?php echo ($page_num); ?>">
                                                                上一页
                                                            </a>
                                                        </li><?php endif; ?>   <!-- 上一页 end -->

                                                    <?php if($page < 5): ?><!-- 页码条 -->
                                                        <?php $__FOR_START_16719__=1;$__FOR_END_16719__=$page+1;for($i=$__FOR_START_16719__;$i < $__FOR_END_16719__;$i+=1){ ?><!-- 循环四条以内 -->
                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($i); ?></a></li>
                                                                <?php elseif($i < $page_now ): ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php elseif($page_now < 3): ?>
                                                        <?php $__FOR_START_4316__=1;$__FOR_END_4316__=6;for($i=$__FOR_START_4316__;$i < $__FOR_END_4316__;$i+=1){ ?><!-- 循环1-5 -->

                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page_now ): ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php elseif($page_now == $page-1): ?>
                                                        <?php $__FOR_START_26085__=$page_now-3;$__FOR_END_26085__=$page+1;for($i=$__FOR_START_26085__;$i < $__FOR_END_26085__;$i+=1){ ?><!-- 循环当前页为倒数第二页时 -->
                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page ): ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php elseif($page_now == $page): ?>
                                                        <?php $__FOR_START_22714__=$page_now-4;$__FOR_END_22714__=$page+1;for($i=$__FOR_START_22714__;$i < $__FOR_END_22714__;$i+=1){ ?><!-- 循环当前页为最后一页时 -->
                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page ): ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php else: ?>
                                                        <?php $__FOR_START_9067__=$page_now-2;$__FOR_END_9067__=$page_now+3;for($i=$__FOR_START_9067__;$i < $__FOR_END_9067__;$i+=1){ ?><!-- 循环除了前五条 和后五条 -->

                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page ): ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/User/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } endif; ?>   <!-- 页码条 end -->

                                                    <?php if(($page_now != $page) AND ($page != 0)): ?><!-- 下一页 -->
                                                        <li class="next ">
                                                            <a href="<?php echo U('Admin/User/index/page_now/');?>/<?php echo ($page_now+1); ?>/page_num/<?php echo ($page_num); ?>">
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
        </section>
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
<script type="text/javascript" language="javascript"
        src="<?php echo (JS); ?>/advanced-datatable/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo (JS); ?>/data-tables/DT_bootstrap.js"></script>
<!--dynamic table initialization -->
<script src="<?php echo (JS); ?>/dynamic_table_init.js"></script>

<!--common scripts for all pages-->
<script src="<?php echo (JS); ?>/scripts.js"></script>

</body>
</html>
<script>


    $("#update_width").click(function () {
        var url = "/index.php/Admin/Channel/channelField/action/update_field";

        var data = '[';

        var update = '';
        //var size = $('.width_input').size();
        $('.width_input').each(function (i, e) {
            var obj = $(e);
            var id = obj.attr('data-id');
            var old_width = obj.attr('data');
            var width = obj.val();
            if (old_width != width) {
                update += '{"id": ' + id + ', "width": ' + width + '},';
            }
        });
        if (update == '') {
            layer.msg('没有变更的数据!', {time: 2000});
            return;
        }
        data += update.substring(0, update.length - 1);
        data += ']';

        $.ajax({
            url: url,
            type: 'post',
            data: {'data': data, 'field': 'width', 'title': '列宽'},
            dataType: 'json',
            success: function (ret) {
                //alert(JSON.stringify(ret));
                layer.msg(ret.msg, {time: 3000});
                setTimeout("window.location.reload()", 2000);
            }
        });
    });

    $("#update_mobile_sort").click(function () {
        var url = "/index.php/Admin/Channel/channelField/action/update_field";

        var data = '[';

        var update = '';
        var sort_inputs = $("input[name='mobile_sort']");
        sort_inputs.each(function (i, e) {
            var obj = $(e);
            var id = obj.attr('data-id');
            var old_sort = obj.attr('data');
            var mobile_sort = obj.val();
            if (mobile_sort != old_sort) {
                update += '{"id": ' + id + ', "mobile_sort": ' + mobile_sort + '},';
            }
        });
        if (update == '') {
            layer.msg('没有变更的数据!', {time: 2000});
            return;
        }
        data += update.substring(0, update.length - 1);
        data += ']';

        $.ajax({
            url: url,
            type: 'post',
            data: {'data': data, 'field': 'mobile_sort', 'title': '手机模板排序'},
            dataType: 'json',
            success: function (ret) {
                //alert(JSON.stringify(ret));
                layer.msg(ret.msg, {time: 3000});
                setTimeout("window.location.reload()", 2000);
            }
        });
    });

    $("#update_admin_sort").click(function () {
        var url = "/index.php/Admin/Channel/channelField/action/update_field";

        var data = '[';

        var update = '';
        var sort_inputs = $("input[name='admin_sort']");
        sort_inputs.each(function (i, e) {
            var obj = $(e);
            var id = obj.attr('data-id');
            var old_sort = obj.attr('data');
            var mobile_sort = obj.val();
            if (mobile_sort != old_sort) {
                update += '{"id": ' + id + ', "admin_sort": ' + mobile_sort + '},';
            }
        });
        if (update == '') {
            layer.msg('没有变更的数据!', {time: 2000});
            return;
        }
        data += update.substring(0, update.length - 1);
        data += ']';

        $.ajax({
            url: url,
            type: 'post',
            data: {'data': data, 'field': 'admin_sort', 'title': '后台表单排序'},
            dataType: 'json',
            success: function (ret) {
                //alert(JSON.stringify(ret));
                layer.msg(ret.msg, {time: 3000});
                setTimeout("window.location.reload()", 2000);
            }
        });
    });

    function saveField(obj, id) {
        var $tr = $(obj).parent().parent();
        var title = $tr.find("input[name='title']").val();
        var admin_sort = $tr.find("input[name='admin_sort']").val();
        var width = $tr.find("input[name='width']").val();
        var mobile_sort = $tr.find("input[name='mobile_sort']").val();

        layer.confirm('确认更改字段"' + title + '"数据?', {
            skin: 'layui-layer-molv',
            btn: ['确定', '取消'] //按钮
        }, function () {
            var url = "/index.php/Admin/Channel/channelField/action/edit/id/" + id;

            var data = {'title': title, 'admin_sort': admin_sort, 'width': width, 'mobile_sort': mobile_sort};

            $.ajax({
                url: url,
                type: 'post',
                data: data,
                dataType: 'json',
                success: function (ret) {
                    layer.msg(ret.msg, {time: 3000});
                    setTimeout("window.location.reload()", 2000);
                }
            });
        });
    }

    $(".flow-steps li").click(function () {
        var obj = $(this);
        var flow = $("#flow").val();
        if (flow == 2) {

            if (obj.hasClass('complete')) {
                return;
            }
            $(".flow-steps li").removeClass('complete').addClass('active');
            obj.removeClass().addClass('complete');

            var url = obj.attr('href');
            var step = obj.attr('data-target');
            if (step == '#step-6') {
                layer.alert('应用模块配置完成，请刷新网站以加载模块菜单!', function () {
                    window.location.href = '/index.php/Admin/Channel/channel/action/page_list';
                });
                setTimeout("window.location.href = '/index.php/Admin/Channel/channel/action/page_list'", 2000);
            } else {
                if (url != undefined && url != null && url != '') {
                    window.location.href = url;
                }
            }
        }
    });

    function flowFinish(obj) {
        $(".flow-steps li").removeClass('active');
        $("#finish_li").addClass('complete');
        layer.alert('应用模块配置完成，请刷新网站以加载模块菜单!', function () {
            window.location.href = '/index.php/Admin/Channel/channel/action/page_list';
        });
        setTimeout("window.location.href = '/index.php/Admin/Channel/channel/action/page_list'", 2000);
    }

</script>