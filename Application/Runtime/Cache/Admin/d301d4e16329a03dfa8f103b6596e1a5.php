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

    <!-- jQuery 2.1.4 -->
    <script src="/Public/js/global.js"></script>

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

    .fr {
        float: right;
    }

    .caption h2 {
        font-size: 24px;
        line-height: 18px;
        font-weight: 700;
    }

    .option {
        height: 27px;
        width: 145px;
    }

    .panel-body {
        padding: 15px;
        border: 1px solid #e6e8eb;
        margin-top: -1px;
    }

    .radio input[type=radio], .radio-inline input[type=radio], .checkbox input[type=checkbox], .checkbox-inline input[type=checkbox] {
        float: none;
        margin-left: 10px;
    }

    .input-group-addon {
        padding: 5px 20px;
    }

    .commen-ttitle {
        font-weight: bold;
        padding: 5px;
    }
</style>

<body class="sticky-header">
<section>
    <!-- main content start-->
    <div class="main-content" width="100%" style="margin:0px;">
        <!--body wrapper start-->
        <section class="wrapper">
            <!-- page start-->
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <!--表单数据-->
                        <form method="post" id="form_id_name" action="#">
                            <header class="panel-heading">
                                添加公众号
                                <div class="pull-right">
                                    <div class="btn-group">
                                        <button type="button" id="postbutton" class="btn btn-default "
                                                onclick="ajax_submit_form('form_id_name')"><i class="fa fa-save"></i>保存
                                        </button>
                                        <a href="javascript:history.go(-1)" data-toggle="tooltip" title=""
                                           class="btn btn-default"><i class="fa fa-reply"></i>返回</a>
                                    </div>
                                </div>
                            </header>
                            <input type="text" id="id" value="<?php echo ($info["id"]); ?>" hidden>
                            <div class="panel-body">
                                <div class="nav-button ">
                                    <span class="col-md-2">* 公众号名称:</span><input
                                        class="form-control form-input" datatype="*" nullmsg="公众号名称不得为空"
                                        type="text" name="wxname" value="<?php echo ($info["wxname"]); ?>"/>
                                </div>
                            </div>

                            <!--<div class="panel-body">-->
                            <!--<div class="nav-button ">-->
                            <!--<span class="col-md-2">* 微信号：</span><input-->
                            <!--class="form-control form-input" datatype="*" nullmsg="公众号原始id不得为空"-->
                            <!--type="text" name="weixin" value="<?php echo ($info["weixin"]); ?>"/>-->
                            <!--</div>-->
                            <!--</div>-->
                            <!--<div class="panel-body">-->
                                <!--<div class="nav-button ">-->
                                    <!--<span class="col-md-2">* 微信号：</span><input-->
                                        <!--class="form-control form-input" datatype="*" nullmsg="微信号不得为空"-->
                                        <!--type="text" name="wxid" value="<?php echo ($info["wxid"]); ?>"/>-->
                                <!--</div>-->
                            <!--</div>-->
                            <!--<div class="panel-body">-->
                                <!--<div class="form-group">-->
                                    <!--<span class="col-md-2">* 头像地址：</span>-->
                                    <!--<input type="text" class=" form-control form-input" readonly="readonly"-->
                                           <!--name="headerpic" datatype="*" nullmsg="头像地址不得为空"-->
                                           <!--value="<?php echo ($info["headerpic"]); ?>" id="headerpic" style="float: left;"/>-->
                                    <!--<div class="col-sm-3">-->
                                        <!--<input class="btn btn-info" style="float: left;" type="button"-->
                                               <!--value="上传头像"-->
                                               <!--onclick="GetUploadify(1,'headerpic','weixin');"/>-->
                                        <!--&nbsp;&nbsp;&nbsp;&nbsp;-->
                                        <!--<button class="btn btn-info " type="button"-->
                                                <!--onclick="preview('headerpic')">预览-->
                                        <!--</button>-->
                                    <!--</div>-->
                                <!--</div>-->
                            <!--</div>-->
                            <!--<div class="panel-body">-->
                                <!--<div class="form-group">-->
                                    <!--<span class="col-md-2">* 二维码：</span>-->
                                    <!--<input type="text" class="form-control form-input" readonly="readonly"-->
                                           <!--datatype="*" nullmsg="二维码不得为空" style="float: left;" id="qr"-->
                                           <!--name="qr" value="<?php echo ($info["qr"]); ?>"/>-->
                                    <!--<div class="col-sm-3">-->
                                        <!--<input class="btn btn-info" type="button" value="上传图片"-->
                                               <!--onclick="GetUploadify(1,'qr','weixin');"/>-->
                                        <!--&nbsp;&nbsp;&nbsp;&nbsp;-->
                                        <!--<button class="btn btn-info " type="button" onclick="preview('qr')">-->
                                            <!--预览-->
                                        <!--</button>-->
                                    <!--</div>-->
                                <!--</div>-->
                            <!--</div>-->
                            <div class="panel-body">
                                <div class="nav-button ">
                                    <span class="col-md-2">* AppID：</span><input
                                        class="form-control form-input" datatype="*" nullmsg="AppID不得为空"
                                        type="text" name="appid" value="<?php echo ($info["appid"]); ?>"/>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="nav-button ">
                                    <span class="col-md-2">* AppSecret：</span><input
                                        class="form-control form-input" datatype="*" nullmsg="AppSecret不得为空"
                                        type="text" name="appsecret" value="<?php echo ($info["appsecret"]); ?>"/>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="nav-button ">
                                    <span class="col-md-2">* Token:</span><input
                                        class="form-control form-input" datatype="*" nullmsg="Token不得为空"
                                        type="text" name="token" value="<?php echo ($info["token"]); ?>"/>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="nav-button ">
                                    <span class="col-md-2">* EncodingAESKey:</span><input
                                        class="form-control form-input" nullmsg="EncodingAESKey不得为空"
                                        type="text" name="encodingaesKey" value="<?php echo ($info["encodingaeskey"]); ?>"/>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="form-group">
                                    <span class="col-md-2">商户号（mchid）</span>
                                    <input type="text" class="form-control form-input" id="qr" name="mchid"
                                           value="<?php echo ($info["mchid"]); ?>"/>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <span class="col-md-2">支付密钥（paykey）</span>
                                    <input type="text" class="form-control form-input" id="qr" name="paykey"
                                           value="<?php echo ($info["paykey"]); ?>"/>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <span class="col-md-2">默认回复</span>
                                    <input type="text" class="form-control form-input" id="default_response" name="default_response"
                                           value="<?php echo ($info["default_response"]); ?>"/>
                                </div>
                            </div>
                            <!--<div class="panel-body">-->
                                <!--<div class="nav-button ">-->
                                    <!--<span class="col-md-2">* 微信号类型：</span>-->
                                    <!--<select name="type" id="" class="form-option">-->
                                        <!--<option-->
                                        <!--<?php if($info['type'] == 1): ?>selected<?php endif; ?>-->
                                        <!--value="1">订阅号</option>-->
                                        <!--<option-->
                                        <!--<?php if($info['type'] == 2): ?>selected<?php endif; ?>-->
                                        <!--value="2">认证订阅号</option>-->
                                        <!--<option-->
                                        <!--<?php if($info['type'] == 3): ?>selected<?php endif; ?>-->
                                        <!--value="3">服务号</option>-->
                                        <!--<option-->
                                        <!--<?php if($info['type'] == 4): ?>selected<?php endif; ?>-->
                                        <!--value="4">认证服务号</option>-->
                                    <!--</select>-->
                                <!--</div>-->
                            <!--</div>-->
                        </form>
                    </section>
                </div>
            </div>
        </section><!--表单数据-->
    </div><!-- main content end-->
</section>

<script type="text/javascript" src="<?php echo (JS); ?>/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo (JS); ?>/Validform_v5.3.2_min.js"></script>
<script type="text/javascript">
    $('#handlepost').Validform({
        tiptype: 3
    });
    //表单提交判断，id为空则URL表示添加，否则表示编辑
    function ajax_submit_form(form_id) {
        //判断id值是否存在
        var id = $("#id").val();
        var action = '';
        if (id == '') {
            //不存在，表示添加

            action = "/index.php/Admin/Wechat/wechat/action/add";
        } else {
            //存在，表示编辑
            action = "/index.php/Admin/Wechat/wechat/action/edit/id/<?php echo ($info["id"]); ?>";
        }
        //异步提交表单数据
        $.ajax({
            type: "post",
            url: action,
            data: $('#' + form_id).serialize(),
            dataType: 'json',
            success: function (res) {
                if (res.result == 1) {
                    layer.msg(res.msg);
                    setTimeout(function () {
                        window.location.href = "/index.php/Admin/Wechat/wechat/action/page_list";
                    }, 1000);
                }
                if (res.result == 0) {
                    layer.msg(res.msg);
                }
            }
        })
    }
</script>
<!-- Placed js at the end of the document so the pages load faster -->
<script src="<?php echo (JS); ?>/jquery-1.10.2.min.js"></script>
<script src="<?php echo (JS); ?>/jquery-ui-1.9.2.custom.min.js"></script>
<script src="<?php echo (JS); ?>/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo (JS); ?>/bootstrap.min.js"></script>
<script src="<?php echo (JS); ?>/modernizr.min.js"></script>
<script src="<?php echo (JS); ?>/jquery.nicescroll.js"></script>
<script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
<!--common scripts for all pages-->
<script src="<?php echo (JS); ?>/scripts.js"></script>

</body>
</html>