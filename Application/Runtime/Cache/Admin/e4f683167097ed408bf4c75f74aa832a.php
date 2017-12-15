<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="#" type="image/png">

    <title>模块类别管理</title>
    <meta name="keywords" content="<?php echo ($gemmap_config['shop_info_store_keyword']); ?>"/>
    <meta name="description" content="<?php echo ($gemmap_config['shop_info_store_desc']); ?>"/>

    <link href="<?php echo (CSS); ?>/style.css" rel="stylesheet">
    <link href="<?php echo (CSS); ?>/style-responsive.css" rel="stylesheet">

    <script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="/Public/js/global.js"></script>
    <script src="/Public/js/myFormValidate.js"></script>
    <script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
    <script src="/Public/js/myAjax.js"></script>
    <script src="/Public/js/common.js" type="text/javascript"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<style type="text/css">
    .ch_label{
        margin-right: 10px;
        background-color: rgb(255, 255, 0);
    }
    .ch_tags{
        width: 400px;
        min-height: 100px;
        height: 100%;
        border: 1px solid #CCC;
        padding:10px;
        margin-bottom: 10px;

    }
    .table-bordered {
     border-top: none ;
}

#spec_form{width:50%;float: left;overflow: hidden;padding-top:15px;padding-left: 20px;}
.right_show{width: 50%;float: right;margin-top:55px;padding-top:15px;padding-left:20px;padding-right: 20px;;}
.form-group{margin:0 !important;}
.box_ts{padding:0 15px ;width:90%;box-sizing: border-box;margin-bottom: 20px;}
.box_ts>button{float: right;}
</style>

<body class="sticky-header">

<section>
    <div class="main-content" width="100%" style="margin:0px;">
        <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel">
                        <header class="panel-heading">
                            关于我们
                           <div class="pull-right">
                                        <div class="btn-group">
                                            <button type="button" id="postbutton" class="btn btn-default "
                                                    onclick="ajax_submit_form('spec_form')"><i class="fa fa-save"></i>提交
                                            </button>
                                            <button class="btn btn-default alert_btn" type="button"  onclick="getLocalData()"  id="preview"><i class="fa fa-eye"></i>预览</button>
                                        </div>
                                    </div>
                        </header>
                        <!-- /.box-header -->
                        <div class="panel-body">
                            <form class="form-horizontal adminex-form" method="post" id="spec_form">

                                <div class="form-group">
                                    <div class="col-sm-9" style="min-width:90%;">
                                        <textarea name="content" id="content"><?php echo ($vo["introduction_aboutus"]); ?></textarea>
                                    </div>
                                </div>
                            </form>
                            <section class="right_show"></section>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>

<script type="text/javascript" src="<?php echo (JS); ?>/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo (JS); ?>/Validform_v5.3.2_min.js"></script>
<!-- Placed js at the end of the document so the pages load faster -->
<script src="<?php echo (JS); ?>/jquery-1.10.2.min.js"></script>
<script src="<?php echo (JS); ?>/jquery-ui-1.9.2.custom.min.js"></script>
<script src="<?php echo (JS); ?>/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo (JS); ?>/bootstrap.min.js"></script>
<script src="<?php echo (JS); ?>/modernizr.min.js"></script>
<script src="<?php echo (JS); ?>/jquery.nicescroll.js"></script>
<script src="/Public/js/layer/layer-min.js"></script>
<script src="/Public/js/layer/layer-min.js"></script>
<!--common scripts for all pages-->
<script src="<?php echo (JS); ?>/scripts.js"></script>
<script type="text/javascript" src="<?php echo (JS); ?>/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="<?php echo (JS); ?>/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" src="<?php echo (JS); ?>/ueditor/lang/zh-cn/zh-cn.js"></script>

</body>
</html>

</body>
</html>
<script >

    $(document).ready(function () {
        var site = "<?php echo session('site_name');?>";
        initUEditor(site, 'content',{initialFrameHeight: 500});
    });

    function ajax_submit_form(form_id) {

        var action ="/index.php/Admin/System/about/action/edit";

        //异步提交表单数据
        $.ajax({
            type: "post",
            url: action,
            data: $("#"+form_id).serialize(),
            dataType: 'json',
            success: function (res) {
                if (res.result == 1) {
                    layer.msg(res.msg);
                }
            }
        })
    }
 

// -----
function getLocalData () {

        // 判断有无内容 
        var arr = [];
        arr.push("使用editor.hasContents()方法判断编辑器里是否有内容");
        arr.push("判断结果为：");
        arr.push(UE.getEditor('content').hasContents());
    
        var ue = UE.getEditor('content').hasContents();

        var preview = UE.getEditor('content').execCommand( "getlocaldata" );

        if (ue == true) {
                $('.right_show').html('');//内容为空;
                $('.right_show').append(preview);//预览内容
            }; 

    }


</script>