<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="#" type="image/png">


    <title><?php echo ($gemmap_config['shop_info_store_title']); ?></title>
    <meta name="keywords" content="<?php echo ($gemmap_config['shop_info_store_keyword']); ?>"/>
    <meta name="description" content="<?php echo ($gemmap_config['shop_info_store_desc']); ?>"/>


    <link href="<?php echo (JS); ?>/advanced-datatable/css/demo_page.css" rel="stylesheet"/>
    <link href="<?php echo (JS); ?>/advanced-datatable/css/demo_table.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo (JS); ?>/data-tables/DT_bootstrap.css"/>
    <link href="<?php echo (CSS); ?>/style.css" rel="stylesheet">
    <link href="<?php echo (CSS); ?>/style-responsive.css" rel="stylesheet">
    <!-- jQuery 2.1.4 -->
    <script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="/Public/js/global.js"></script>
    <script src="/Public/js/myFormValidate.js"></script>
    <script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
    <script src="/Public/js/myAjax.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->

</head>


<style type="text/css">
    body {
        background: #f1f1f1;
    }

    .caption h2 {
        font-size: 24px;
        line-height: 18px;
        font-weight: 500;
    }

    input {
        height: 30px;
        line-height: 30px;
        padding-left: 10px;
    }

    .panel {
        margin-bottom: 20px;
        border: 1px solid #ddd;
    }

    .panelarea {
        margin-bottom: 20px;
        background-color: #fff;
        border-radius: 4px;
        -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        height: 60px;
        line-height: 60px;
        padding-left: 10px;
        font-size: 16px;
        font-weight: 500;
    }

    .navbar-default {
        background-color: #fff;
        border: 1px solid #e7e7e7;
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
        <div class="wrapper">
            <div class="row">
                <div class="col-md-12">
                    <section class="panel">
                        <div class="panel-heading panel-body">
                            <div class="pull-left">
                                地区管理
                            </div>
                        </div>

                        <div class="collapse navbar-collapse navbar-default panel-body">
                            <div class="nav-button col-md-12">
                                <form class="navbar-form form-inline" action="/index.php/Admin/Tools/region/action/page_add" method="post">
                                    <input type="hidden" name="level" value="<?php echo ($parent["level"]); ?>">
                                    <input type="hidden" name="parent_id" value="<?php echo ($parent["id"]); ?>">
                                    增加地区 　<input type="text" class="form-control" name="name" placeholder="请输入地区"/>
                                    <button class="btn btn-default" type="submit">确定</button>
                                </form>

                            </div>
                        </div>

                        <div class="panel-body">


                            <div class="row">


                                <?php if(is_array($region)): foreach($region as $k=>$vo): if($k%3 == 0): endif; ?>
                                    <div class="col-md-4">
                                        <div class="panel panelarea">
                                            <?php echo ($vo["name"]); ?>&nbsp;&nbsp;

                                            <?php if($vo[level] < 4): ?><a href="/index.php/Admin/Tools/region/action/page_list/parent_id/<?php echo ($vo["id"]); ?>" role="button">
                                                    <button class="btn btn-info" type="button">管理</button>
                                                </a><?php endif; ?>

                                            <a href="/index.php/Admin/Tools/region/action/page_edit/id/<?php echo ($vo["id"]); ?>/pid/<?php echo ($pid); ?>" role="button">
                                                <button class="btn btn-primary" type="button">编辑</button>
                                                </button></a>
                                            <a href="javascript:void(0);" data-url="/index.php/Admin/Tools/region/action/del/<?php echo ($vo["id"]); ?>"
                                               onclick="delRegion(this)" role="button">
                                                <button class="btn btn-danger" type="button">删除</button>
                                                </button></a>
                                        </div>
                                    </div><?php endforeach; endif; ?>
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
<script type="text/javascript" src="<?php echo (JS); ?>/jquery-1.9.1.min.js"></script>
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
    function delRegion(obj) {
        layer.confirm('确定删除此地区？', {icon: 3, title: '提示删除'}, function (index) {
            layer.close(index);
            window.location.href = $(obj).attr('data-url');
        });
    }
</script>
</body>
</html>