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

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<style type="text/css">
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
                        <header class="panel-heading">
                            修改密码
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button href="javascript:;" data-toggle="tooltip" title="" onclick="ajax_submit_form()" id="confrim"
                                       class="btn btn-default" ><i class="fa fa-floppy-o"></i>保存</button>
                                    <a href="javascript:history.go(-1)" data-toggle="tooltip" title=""
                                       class="btn btn-default" data-original-title="返回"><i class="fa fa-mail-reply"></i>返回</a>
                                </div>
                            </div>
                        </header>
                        <div class="panel-body ">
                            <!--表单数据-->
                            <form class="form-horizontal adminex-form" method="post" id="form_id_name"
                                  action="/index.php/Admin/Admin/action/page_list">
                                <input type="hidden" id="user_id" name="user_id" value="<?php echo ($info["user_id"]); ?>">
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">旧登陆密码：</label>
                                    <div class="col-sm-10">
                                        <input type="password" datatype="*6-15"
                                               errormsg="密码是6到15位的数字或字母" ignore="ignore" class="form-control form-input"
                                               id="password" name="password" value=""
                                               placeholder="请输入旧登录密码"> 密码长度为6-15个，只允许英文或数字,不能包含空格
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">新登陆密码：</label>
                                    <div class="col-sm-10">
                                        <input type="password" datatype="*6-15" nullmsg="请填写新密码"
                                               errormsg="密码是6到15位的数字或字母" class="form-control form-input"
                                               id="new_password" name="new_password" value=""
                                               placeholder="请输入新登录密码"> 密码长度为6-16个，只允许英文或数字,不能包含空格
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">新密码确认：</label>
                                    <div class="col-sm-10">
                                        <input type="password" datatype="*6-15" nullmsg="请填写密码确认"
                                               errormsg="密码确认不一致" recheck="new_password" class="form-control form-input"
                                               id="new_password2" name="new_password2" value=""
                                               placeholder="请再次新登录密码"> 密码长度为6-16个，只允许英文或数字,不能包含空格
                                    </div>
                                </div>
                            </form><!--表单数据-->
                        </div>

                    </section>
                </div>

            </div>

        </section>
    </div>
    </div>
    <!-- main content end-->
</section>
<script type="text/javascript" src="<?php echo (JS); ?>/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo (JS); ?>/Validform_v5.3.2_min.js"></script>
<script src="/Public/js/layer/layer-min.js"></script>
<script type="text/javascript">
//    $("#confrim").bind('click',function(){
//        var old=$("#old_password").val();
//        var now=$("#new_password").val();
//        var now1=$("#new_password2").val();
//        if(old=='',now=='',now1==''){
//            layer.msg("输入框不能为空");
//            return false;
//        }
//        $('form').submit();
//
//    });
    function ajax_submit_form() {
        //var form_id=$("#id").val();
        var user_id=$("#user_id").val();
        var old=$("#old_password").val();
        var now=$("#new_password").val();
        var now1=$("#new_password2").val();
        if(old==''|| now==''|| now1==''){
            layer.msg("输入框不能为空");
            return false;
        }
        var action="/index.php/Admin/Admin/admin_alter/action/edit";
        $.ajax({
            type:"post",
            data: $('#form_id_name').serialize(),
            url:action,
            dataType:"json",
            success:function (res) {
                    layer.msg(res.msg);

            }
        })
    }


    var pwd = $('.adminex-form').Validform({
        tiptype: 3
    });
    $("#old_password").click(function () {
        if ($('#old_password').val() != '') {
            pwd.ignore("#new_password,#new_password2");
        }
    });


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