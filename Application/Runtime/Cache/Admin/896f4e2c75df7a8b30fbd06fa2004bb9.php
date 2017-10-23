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
        background-color: #f8f8f8;
        border: 1px solid #e7e7e7;
    }

    .panel {
        border: 1px solid #ddd;
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
                        <header class="panel-heading">
                            数据还原
                        </header>
                        <div class="collapse navbar-collapse navbar-default panel-body">
                            <form class="navbar-form form-inline" id="restoreForm"
                                  action="/index.php/Admin/Tools/restore/action/restoreUpload"
                                  name="change_System" method="post" enctype="multipart/form-data">

                                <div class="form-group pull-left">
                                    <div class="form-group">
                                        要导入的SQL文件:　
                                    </div>
                                </div>
                                <div class="form-group pull-left">
                                    <div class="form-group">
                                        <input type="file" class="btn btn-default" name="sqlfile"
                                               style="padding: 5px;margin-bottom:5px;"/>
                                    </div>
                                </div>
                                <div class="form-group pull-right">
                                    <div class="form-group">
                                        <!--<i class="fa fa-eject"></i><input type="submit" class="btn btn-default" value="提交">-->
                                        <a id="restoreBtn" class="btn btn-default "><i class="fa fa-eject"></i> 备份</a>
                                        <label class="text-danger">导入的SQL语句必须按照MYSQL的语法编写</label>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="panel-body">
                            <div class="adv-table">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th class="text-center" style="width: 2px;"><input type="checkbox"
                                                                                           onclick="javascript:$('input[name*=backs]').prop('checked',this.checked);">
                                        </th>
                                        <th class="sorting" tabindex="0">文件名称</th>
                                        <th class="sorting" tabindex="0">文件大小</th>
                                        <th class="sorting" tabindex="0">备份时间</th>
                                        <th class="sorting" tabindex="0">卷号</th>
                                        <th class="sorting" tabindex="0">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($vlist)): foreach($vlist as $k=>$vo): ?><tr>
                                            <td class="text-center"><input type="checkbox" name="backs[]" value="<?php echo ($vo["name"]); ?>"></td>
                                            <td class="text-center"><?php echo ($vo["name"]); ?></td>
                                            <td class="text-center"><?php echo (format_bytes($vo["size"])); ?></td>
                                            <td class="text-center"><?php echo (date("Y-m-d H:i:s",$vo["time"])); ?></td>
                                            <td class="text-center"><?php echo ($vo["number"]); ?></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a class="btn btn-default"
                                                       href="/index.php/Admin/Tools/restore/action/restoreData/sqlfilepre/<?php echo ($vo["name"]); ?>"
                                                       data-url="">恢复</a>
                                                    <a class="btn btn-default"
                                                       href="/index.php/Admin/Tools/restore/action/downFile/type/sql/file/<?php echo ($vo["name"]); ?>">下载</a>
                                                    <a class="btn btn-default"
                                                       href="/index.php/Admin/Tools/restore/action/delSqlFiles/sqlfilename/<?php echo ($vo["name"]); ?>">删除</a>
                                                </div>
                                            </td>
                                        </tr><?php endforeach; endif; ?>
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>

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
<script type="text/javascript">

    $('#restoreBtn').click(function () {
        $('#restoreForm').submit();
    });


    function gobackup(obj) {
        var a = [];
        $('input[name*=backs]').each(function (i, o) {
            if ($(o).is(':checked')) {
                a.push($(o).val());
            }
        });


        if (a.length == 0) {
            layer.alert('请选择要备份的数据表', {icon: 2});  //alert('请选择要备份的数据表');
            return;
        } else {
            $(obj).addClass('disabled');
            $(obj).html('备份进行中...');
            $.ajax({
                type: 'post',
                url: "<?php echo U('Admin/Tools/backup');?>",
                datatype: 'json',
                data: {tables: a},
                success: function (data) {
                    data = eval('(' + data + ')');
                    if (data.stat == 'ok') {
                        layer.alert(data.msg, {icon: 2});  // alert(data.msg);
                    } else {
                        layer.alert(data.msg, {icon: 2});  //alert(data.msg);
                    }
                }
            })
        }
    }
</script>
</body>
</html>