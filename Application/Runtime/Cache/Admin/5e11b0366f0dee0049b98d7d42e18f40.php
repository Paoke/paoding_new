<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="#" type="image/png">

    <title>水印配置</title>
    <meta name="keywords" content="<?php echo ($gemmap_config['shop_info_store_keyword']); ?>"/>
    <meta name="description" content="<?php echo ($gemmap_config['shop_info_store_desc']); ?>"/>

    <!--dynamic table-->

    <link href="<?php echo (CSS); ?>/style.css" rel="stylesheet">
    <link href="<?php echo (CSS); ?>/style-responsive.css" rel="stylesheet">
    <link href="<?php echo (CSS); ?>/chanel-type.css" rel="stylesheet">
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
    <script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->

</head>
<style type="text/css">
    body {
        background: #f1f1f1;
    }

    .form-horizontal.adminex-form .form-group {
        border-bottom: 1px solid #eff2f7;
        padding-bottom: 15px;
        margin-bottom: 15px;
    }

    .button-next, .finish {
        float: right;
    }

    .fr {
        float: right;
    }

    .radio input[type=radio], .radio-inline input[type=radio], .checkbox input[type=checkbox], .checkbox-inline input[type=checkbox] {
        float: none;
        margin-left: 10px;
    }

    .panel-body {
        padding: 15px;
        border: 1px solid #e6e8eb;
        margin-top: -1px;
    }

    .nav-button span {
        display: inline-block;
    }

    #home .nav-button span {
        width: 12em;
    }

    #about .nav-button span {
        width: 8em;
    }

    #profile .nav-button span {
        width: 11em;
    }

    #Shopping .nav-button span {
        width: 11em;
    }

    #Mail .nav-button span {
        width: 11em;
    }

    #Watermark .nav-button span {
        width: 10em;
    }

    #Distribution .nav-button span {
        width: 9em;
    }

    .radio {
        display: inline-block;
        padding-left: 0px;
    }

    /*-LTJ-**********************/
    .form-input {
        width: 400px;
        display: inline-block;
    }

    .form-option {
        width: 400px;
        height: 34px;
    }

    .panel {
        border: 1px solid #ddd;
    }

    .custom-tab li a:hover, .custom-tab li.active a {
        background: #fff !important;
        color: #383838 !important;
        line-height: 8px !important;
        border-bottom-color: transparent !important;
        border: 1px solid #ddd !important;
        border-radius: 5px 5px 0 0 !important;
    }
    .control-label  input{    width: 20px;
        height: 20px;
        background-color: #ffffff;
        border: solid 1px #dddddd;
        -webkit-border-radius:50%;
        border-radius: 50%;
        font-size: 16px;
        margin: 0;
        padding: 0;
        position: relative;
        display: inline-block;
        vertical-align: top;
        cursor: default;
        -webkit-appearance: none;
        -webkit-user-select: none;
        user-select: none;
        -webkit-transition: background-color ease 0.1s;
        transition: background-color ease 0.1s;
    }
    .control-label  input:hover{cursor:pointer;}
    .control-label  input:focus { outline: none !important; }
    .control-label  input:checked{    background-color: #03a9f4;
        border: solid 1px #03a9f4;
        text-align: center;
        background-clip: padding-box;
        border:none;
    }
    .control-label  input:checked:before{    content: '';
        width: 10px;
        height: 6px;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-left: -5px;
        margin-top: -5px;
        background: transparent;
        border: 1px solid #ffffff;
        border-top: none;
        border-right: none;
        z-index: 2;
        -webkit-border-radius: 0;
        border-radius: 0;
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg);}

    .control-label  input:checked:after{    content: '';
        width: 10px;
        height: 6px;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-left: -5px;
        margin-top: -5px;
        background: transparent;
        border: 1px solid #ffffff;
        border-top: none;
        border-right: none;
        z-index: 2;
        -webkit-border-radius: 0;
        border-radius: 0;
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg);}


    /***********************/

</style>

<body class="sticky-header">

<section>
    <div class="main-content" width="100%" style="margin:0px;">
        <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel">
                        <header class="panel-heading">
                            <?php if($info["role_id"] == null): ?>水印设置<?php endif; ?>
                            <div class="pull-right">
                                <div class="btn-group">
                                    <input class="btn btn-default" type="submit" value="保存" onclick="ajax_submit_form('water_form')">
                                    <a href="javascript:history.go(-1)" data-toggle="tooltip" title=""
                                       class="btn btn-default"><i class="fa fa-reply"></i>取消</a>
                                </div>
                            </div>
                        </header>
                        <!-- /.box-header -->
                        <div class="tab-pane " id="Watermark">
                            <form id="water_form" method="post" action="/index.php/Admin/AppConfig/watermark_info/action/edit">
                                <div class="panel-body">
                                    <div class="nav-button ">
                                        <span class=" ">商品图片添加水印:</span>
                                        <div class="radio">
                                            <label class="control-label">
                                                <input type="radio" name="is_mark" id="is_mark1" value="1" checked="checked">
                                                是
                                            </label>
                                            <label class="control-label">
                                                <input type="radio" name="is_mark" id="is_mark0" value="0">
                                                否
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="nav-button ">
                                        <span class=" ">水印类型:</span>
                                        <div class="radio">
                                            <label class="control-label">
                                                <input type="radio" name="mark_type" id="mark_type0" value="0">
                                                文字
                                            </label>
                                            <label class="control-label">
                                                <input type="radio" name="mark_type" id="mark_type1" value="1" checked="checked">
                                                图片
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <!--<div class="form-group">-->
                                    <span style=" width: 10em;display:inline-block">水印图片:</span>
                                    <input type="text" name="mark_img" id="mark_img" class="form-control form-input" value="" readonly="readonly">

                                    <input class="btn btn-info" type="button" value="上传图片" onclick="GetUploadify(1,'mark_img','img','');">
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <button class="btn btn-default " type="button" onclick="preview('mark_img')"><i class="fa fa-search"></i>
                                    </button>


                                    <!--</div>-->
                                </div>

                                <div class="panel-body">
                                    <div class="nav-button ">
                                        <span class=" ">水印图片高度：</span>
                                        <input type="number" class="form-control form-input" onkeyup="this.value=this.value.replace(/\D/gi,&quot;&quot;)" min="0" name="mark_height" value="50">&nbsp;&nbsp;&nbsp;&nbsp; 单位像素(px)
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <div class="nav-button ">
                                        <span class=" ">水印图片宽度：</span>
                                        <input type="number" class="form-control form-input" onkeyup="this.value=this.value.replace(/\D/gi,&quot;&quot;)" min="0" name="mark_width" value="50">&nbsp;&nbsp;&nbsp;&nbsp; 单位像素(px)
                                    </div>
                                </div>


                                <div class="panel-body">
                                    <div class="nav-button ">
                                        <span class=" ">水印透明度（%）：</span>
                                        <input type="number" class="form-control form-input" onkeyup="this.value=this.value.replace(/\D/gi,&quot;&quot;)" min="0" max="100" name="mark_degree" value="53">
                                        &nbsp;&nbsp;&nbsp;&nbsp;0代表完全透明，100代表不透明
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <div class="nav-button ">
                                        <span>JPER水印质量（%）：</span>
                                        <input type="number" class="form-control form-input" onkeyup="this.value=this.value.replace(/\D/gi,&quot;&quot;)" min="0" max="100" name="mark_quality" value="55">
                                        &nbsp;&nbsp;&nbsp;&nbsp;水印质量请设置为0-100之间的数字,决定 jpg 格式图片的质量
                                    </div>
                                </div>

                                <div class="panel-body">
                                    商品图片添加水印：
                                    <div class="radio" style="display: block;">
                                        <label class="control-label">
                                            <input type="radio" name="sel" id="sel1" value="1">
                                            顶部居左
                                        </label>
                                        <label class="control-label">
                                            <input type="radio" name="sel" id="sel2" value="2">
                                            顶部居中
                                        </label>
                                        <label class="control-label">
                                            <input type="radio" name="sel" id="sel3" value="3">
                                            顶部居右
                                        </label>
                                    </div>

                                    <div class="radio" style="display: block;">
                                        <label class="control-label">
                                            <input type="radio" name="sel" id="sel4" value="4">
                                            中部居左
                                        </label>
                                        <label class="control-label">
                                            <input type="radio" name="sel" id="sel5" value="5">
                                            中部居中
                                        </label>
                                        <label class="control-label">
                                            <input type="radio" name="sel" id="sel6" value="6">
                                            中部居右
                                        </label>
                                    </div>
                                    <div class="radio" style="display: block;">
                                        <label class="control-label">
                                            <input type="radio" name="sel" id="sel7" value="7" checked="checked">
                                            底部居左
                                        </label>
                                        <label class="control-label">
                                            <input type="radio" name="sel" id="sel8" value="8">
                                            底部居中
                                        </label>
                                        <label class="control-label">
                                            <input type="radio" name="sel" id="sel9" value="9">
                                            底部居右
                                        </label>
                                    </div>
                                </div>

                                <input type="hidden" name="__hash__" value="9c687d266d2b21baea3f642a1874990d_8a12fa4b396257b8184e08ee3c4b3393">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>

<!-- Placed js at the end of the document so the pages load faster -->
<script src="<?php echo (JS); ?>/jquery-ui-1.9.2.custom.min.js"></script>
<script src="<?php echo (JS); ?>/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo (JS); ?>/bootstrap.min.js"></script>
<script src="<?php echo (JS); ?>/modernizr.min.js"></script>
<script src="<?php echo (JS); ?>/jquery.nicescroll.js"></script>


<!--common scripts for all pages-->
<script src="<?php echo (JS); ?>/scripts.js"></script>
<script>
    function ajax_submit_form() {
        //判断id值是否存在
        var id = $("#id").val();

        var action = '/index.php/Admin/System/setting/action/edit';

        //异步提交表单数据
        $.ajax({
            type: "post",
            url: action,
            data: $('#' + id).serialize(),
            dataType: 'json',
            success: function (res) {
                if (res.result == 1) {
                    layer.msg(res.msg);

                }
                if (res.result == 0) {
                    layer.msg(res.msg);
                }
            }
        })
    }




</script>
</body>
</html>