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

    <link href="<?php echo (CSS); ?>/style.css" rel="stylesheet">
    <link href="<?php echo (CSS); ?>/style-responsive.css" rel="stylesheet">

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
    <style>
        .form-group:nth-of-type(2){display:none !important;}
    </style>
</head>

<body class="sticky-header">
<section>
    <div class="main-content" width="100%" style="margin:0px;">
        <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            栏目类别
                            <div class="pull-right">
                                <div class="btn-group">


                                    <a href="javascript:history.go(-1)" data-toggle="tooltip" title=""
                                       class="btn btn-default"><i class="fa fa-reply"></i>返回</a>
                                </div>
                            </div>
                        </header>
                        <div class="panel-body">
                            <!--表单数据-->
                            <form class="form-horizontal adminex-form" method="post" id="form_id_name">
                                <?php if($data["hzjg_id"] == null): ?><input type="hidden" id="hzjg_id" name="hzjg_id" value="<?php echo ($hzjg_id); ?>">
                                    <?php else: ?>
                                    <input type="hidden" id="hzjg_id" name="hzjg_id" value="<?php echo ($data["hzjg_id"]); ?>"><?php endif; ?>
                                <input type="hidden" id="data_id" name="data_id" value="<?php echo ($data["id"]); ?>">
                                <input type="hidden" id="content" name="content" value="<?php echo ($data["content"]); ?>">
                                <div id="extends_div" class="extends_group">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            标题：
                                        </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control form-input" id="title" name="title" value="<?php echo ($data["title"]); ?>" placeholder="标题">
                                        </div>
                                    </div>
                                    <div class="form-group">

                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            描述：
                                        </label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control form-input" id="desc" name="desc"><?php echo ($data["desc"]); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            技术领域：
                                        </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control form-input" id="jsly" name="jsly" value="<?php echo ($data["jsly"]); ?>" placeholder="技术领域">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            合作方式：
                                        </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control form-input" id="hzfs" name="hzfs" value="<?php echo ($data["hzfs"]); ?>" placeholder="合作方式">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            交付方式：
                                        </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control form-input" id="jffs" name="jffs" value="<?php echo ($data["jffs"]); ?>" placeholder="交付方式">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            具体内容：
                                        </label>
                                        <div class="col-sm-9">
                                            <script id="editor" type="text/plain" style="width:800px;height:300px;"><?php echo ($data["content"]); ?></script>
                                        </div>
                                    </div>

                                    <div class="form-group" style="text-align: center;">
                                        <?php if($data == null): ?><button type="button" id="postbutton" class="btn btn-default "
                                                onclick="ajax_submit_form('form_id_name','add')"><i class="fa fa-floppy-o"></i>保存
                                        </button>
                                            <?php else: ?>
                                            <button type="button" id="postbutton" class="btn btn-default "
                                        onclick="ajax_submit_form('form_id_name','edit')"><i class="fa fa-floppy-o"></i>提交
                                            </button><?php endif; ?>

                                        <a href="javascript:history.go(-1)" data-toggle="tooltip" title=""
                                           class="btn btn-default"><i class="fa fa-reply"></i>返回</a>
                                    </div>

                                </div>
                            </form><!--表单数据-->
                        </div>
                    </section>
                </div>

            </div>
        </section>
    </div>
</section>

<!-- Placed js at the end of the document so the pages load faster -->
<script src="<?php echo (JS); ?>/jquery-1.10.2.min.js"></script>
<script src="<?php echo (JS); ?>/jquery-ui-1.9.2.custom.min.js"></script>
<script src="<?php echo (JS); ?>/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo (JS); ?>/bootstrap.min.js"></script>
<script src="<?php echo (JS); ?>/modernizr.min.js"></script>
<script src="<?php echo (JS); ?>/jquery.nicescroll.js"></script>
<!-- <script src="/Public/js/layer/layer-min.js"></script> -->
<script src="/Public/js/layer/layer.js"></script>
<!--common scripts for all pages-->
<script src="<?php echo (JS); ?>/scripts.js"></script>
<!-- ueditor start-->
<script src="<?php echo (JS); ?>/ueditor/ueditor.config.js"></script>
<script src="<?php echo (JS); ?>/ueditor/ueditor.all.min.js"></script>
<script src="<?php echo (JS); ?>/ueditor/lang/zh-cn/zh-cn.js"></script>
<script src="<?php echo (JS); ?>/extends.js"></script>
<script src="<?php echo (JS); ?>/laydate/laydate.js"></script>
<script src="<?php echo (JS); ?>/Validform_v5.3.2_min.js"></script>
<script src="/Public/js/vue.js"></script>
<script type="text/javascript">

    var ue = UE.getEditor('editor');
    function getLocalData() {
        //document.getElementById("content").value = UE.getEditor('editor').execCommand("getlocaldata");
        document.getElementById("content").value = UE.getEditor('editor').getContent();
    }
    function ajax_submit_form(id,action) {
        getLocalData();
        var data = {};
        var t = $('#'+id).serializeArray();
        $.each(t, function() {
            data[this.name] = this.value;
        });
        if(action=="add"){
            var url="/index.php/Admin/Article/use_example/action/add_data";
        }else{
            var url="/index.php/Admin/Article/use_example/action/save?id="+data['data_id'];
        }
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            dataType: "json",
            success: function(response){
                if(response.result){
                    alert("保存成功");
                    window.location.reload();
                }else{
                    alert("保存失败");
                    window.location.reload();
                }

            }
        });
    }

</script>

</body>
</html>