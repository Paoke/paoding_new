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
        border: 1px solid #e7e7e7;
    }

   .panel{
        border: 1px solid #ddd;
    }

    .formadd {
        padding: 0px;
    }
    .panel-heading {
    border-bottom: 0px solid #ddd;
   
}
</style>

<body class="sticky-header">

<section>

    <!-- main content start-->
    <div class="main-content" width="100%" style="margin:0px;">


        <!--body wrapper start-->
        <div class="wrapper" >
            <!--  -->
            <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <?php if($type == payment): ?>支付插件
                                <?php else: ?>
                                第三方登录<?php endif; ?>
                            <div class="pull-right">
                                <form class="navbar-form form-inline" role="search">
                                    <div class="panel-body formadd">
                                        <a href="javascript:void(0);" id="btnclick" class="btn btn-default pull-right"
                                           style="margin-right:10px;"><i class="fa fa-refresh"></i> 重新排序</a>
                                    </div>
                                </form>
                            </div>
                        </header>
                        

                        <div class="">
                            <div class="adv-table">
                                <table id="list-table" class="table table-bordered table-striped dataTable" role="grid"
                                       aria-describedby="example1_info">
                                    <thead>
                                    <tr role="row">
                                        <th valign="middle" width="10%">名称</th>
                                        <th valign="middle">备注</th>
                                        <th valign="middle" width="10%">是否启用</th>
                                        <th valign="middle" width="10%">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($list)): foreach($list as $k=>$vo): ?><tr role="row" align="center">
                                            <td><?php echo ($vo["name"]); ?></td>
                                            <td><?php echo ($vo["desc"]); ?></td>

                                            <td>
                                                <img width="20" height="20"
                                                     src="/Public/images/<?php if($vo["is_open"] == 1): ?>yes.png<?php else: ?>cancel.png<?php endif; ?>"
                                                <?php if($mod_id): ?>onclick="changeTableVal('<?php echo ($mod_id); ?>','plugin','id','<?php echo ($vo["id"]); ?>','is_open',this)"/><?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if($vo["status"] == 0): else: ?>
                                                    <a
                                                    <?php if($type == payment): ?>href="/index.php/Admin/Plugin/paymentList/action/page_edit/type/<?php echo ($vo["type"]); ?>/code/<?php echo ($vo["code"]); ?>"
                                                        <?php else: ?>
                                                        href="/index.php/Admin/Plugin/loginList/action/page_edit/type/<?php echo ($vo["type"]); ?>/code/<?php echo ($vo["code"]); ?>"<?php endif; ?>
                                                    class="btn btn-default " role="button"><i class="fa fa-pencil"></i></a><?php endif; ?>
                                            </td>
                                        </tr><?php endforeach; endif; ?>
                                    </tbody>
                                </table>


                                <!-- Modal -->
                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                                     id="myModal1" class="modal fade" style="top: 10%;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close"
                                                        type="button">×
                                                </button>
                                                <h4 class="modal-title">信息</h4>
                                            </div>
                                            <div class="modal-body" id="myModal1-body">

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        onclick="gettrue();"> 确定
                                                </button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal"> 取消
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- modal -->
                                <!-- Modal -->
                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                                     id="myModal2" class="modal fade" style="top: 10%;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close"
                                                        type="button">×
                                                </button>
                                                <h4 class="modal-title">信息</h4>
                                            </div>
                                            <div class="modal-body" id="myModal2-body"></div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        onclick="gettrue();"> 确定
                                                </button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal"> 取消
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- modal -->
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <!--body wrapper end-->


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
<script type="text/javascript">
    $("#btnclick").click(function () {
        window.location.reload();
    });


    //插件安装(卸载)
    function installPlugin(type, code, type2) {
        var action = '';
        if (type2 == '1')
            action = 'install' + type;
        else if (type2 == '0')
            action = 'uninstall' + type;
        var url = '/index.php?m=Admin&c=Plugin&a=' + action + '&type=' + type + '&code=' + code + '&install=' + type2;
        $.get(url, function (data) {
            if (data.info)
                layer.alert(data.info);
            else {
                var obj = JSON.parse(data);
                if (obj.status == 1) {
                    location.reload();
                } else
                    layer.msg(obj.msg);
            }
        })
    }
    var str;
    var plu_name;
    //删除菜单
    $('.btn').click(function () {
        str = $(this).attr('data-url');
        plu_name = $(this).attr('plu-name');
        $("#myModal2-body").html("确定删除插件： " + plu_name + "  ?");
        $("#myModal1-body").html("确定启用插件： " + plu_name + "  ?");
    });
    function gettrue() {
        // 'payment','cod',0
        var n = 1;
        var val1 = '';
        var val2 = '';
        var val3 = '';

        for (var i = 0; i < str.length; i++) {
            if (str[i] != ',')val1 += str[i];
            else {
                for (var j = i + 1; j < str.length; j++) {
                    if (str[j] != ',')val2 += str[j];
                    else {
                        for (var k = j + 1; k < str.length; k++) {
                            if (str[k] != ',')val3 += str[k];
                            else break;
                        }
                        break;
                    }
                }
                break;
            }
        }
        installPlugin(val1, val2, val3);
    }
</script>
</body>
</html>