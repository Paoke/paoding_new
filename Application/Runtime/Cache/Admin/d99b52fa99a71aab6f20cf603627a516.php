<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="#" type="image/png">
    <title><?php echo ($tpshop_config['shop_info_store_title']); ?></title>
    <meta name="keywords" content="<?php echo ($tpshop_config['shop_info_store_keyword']); ?>"/>
    <meta name="description" content="<?php echo ($tpshop_config['shop_info_store_desc']); ?>"/>

    <link href="<?php echo (CSS); ?>/style.css" rel="stylesheet">
    <link href="<?php echo (CSS); ?>/style-responsive.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<style type="text/css">
    body {
        background: #f1f1f1;
        overflow: scroll
    }

    .thumbnail {
        display: block;
        padding: 4px;
        margin-bottom: 20px;
        line-height: 1.42857143;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        -webkit-transition: border .2s ease-in-out;
        -o-transition: border .2s ease-in-out;
    }

    .thumbnail img {
        width: 400px;
        height: 200px;
    }

    .caption {
        padding: 9px;
        color: #333;
    }

    .caption span {
        font-size: 18px;
        line-height: 30px;
        font-weight: 500;
        float: left;
    }

</style>

<body>
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
                            新增站点
                            <div class="pull-right">
                                <div class="btn-group">
                                    <?php if(empty($info)): ?><button type="button" id="create_btn" class="btn btn-default ">创建
                                        </button><?php endif; ?>
                                    <a href="javascript:history.go(-1)" data-toggle="tooltip" title=""
                                       class="btn btn-default" data-original-title="返回">返回</a>
                                </div>
                            </div>
                        </header>
                        <div class="panel-body ">
                            <!--表单数据-->
                            <form class="form-horizontal adminex-form" method="post" id="siteform">
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">站点名称：</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-input" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')"   id="site_name"
                                               clientidmode="Static"   name="site_name" value="<?php echo ($info["site_name"]); ?>">
                                        <span style="color:green"  id='errorMsg'>只允许输入英文或数字</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">默认域名：</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-input" datatype="*"
                                               id="default_domain" name="domain" value="<?php echo ($info["default_domain"]); ?>"
                                               readonly>
                                        <span style="color:green">填写站点会自动分配域名</span>
                                    </div>
                                </div>
                                <!--<div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">指定域名：</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-input" datatype="e" name="domain2" value="" >
                                        <span style="color:green">指定域名为客户指定的域名，指定域名需要客户将域名指向平台的IP地址</span>
                                    </div>
                                </div>-->
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">公司名称：</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-input" datatype="m" name="company"
                                               value="<?php echo ($info["company"]); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">联系人姓名：</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-input" datatype="m" name="user"
                                               value="<?php echo ($info["contact"]); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">联系方式：</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-input" datatype="m" name="mobile"
                                               value="<?php echo ($info["mobile"]); ?>">
                                    </div>
                                </div>
                              <!--  <?php if(empty($info)): ?><div class="form-group">
                                        <label class="col-sm-2 col-sm-2 control-label">模板分类：</label>
                                        <div class="col-sm-10">
                                            <select name="template_cat" id="template_cat" class="form-option"
                                                    style="border-radius:5px">
                                                <option value="0">所有分类</option>
                                                <?php if(is_array($cat)): $i = 0; $__LIST__ = $cat;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cvo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cvo["cat_id"]); ?>"><?php echo ($cvo["cat_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-2 control-label">模板：</label>
                                        <div class="col-sm-10" id="tmpl_div">
                                        </div>
                                    </div>
                                    <?php else: ?>
                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-2 control-label">选中模板分类：</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-input" name="template_cat"
                                                   value="<?php echo ($template["cat_name"]); ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-2 control-label">选中模板：</label>
                                        <div class="col-sm-10">
                                            <div class="row col-lg-4 col-xs-6 col-md-4 col-sm-6"
                                                 style="margin-left:10px;margin-top: 10px;">
                                                <section class="thumbnail">
                                                    <img src="<?php echo ($template["image"]); ?>" height="90px" width="150px">
                                                    <div class="caption" style="overflow: hidden;"><span><?php echo ($template["title"]); ?></span>
                                                        <button type="button" id="39" class="btn btn-success"
                                                                style="float: right;">选中
                                                        </button>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                    </div><?php endif; ?>-->
                                <input type="hidden" id="template_id" name="template_id" value="<?php echo ($template["id"]); ?>">
                                <input type="hidden" id="cat_id" name="cat_id" value="<?php echo ($template["cat_id"]); ?>">
                                <input type="hidden" id="site_id" value="<?php echo ($info["id"]); ?>">
                            </form><!--表单数据-->
                        </div>

                    </section>
                </div>

            </div>
        </section>
        <div id="proccess_msg" style="text-align: center; display: none">
            <span style="color:darkgreen; font-size: 25px;"><b>正在建站，请稍后...</b></span><br/>
            <img src="/Public/images/process.gif">
        </div>
    </div>

    <!-- main content end-->
</section>
<script type="text/javascript" src="<?php echo (JS); ?>/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo (JS); ?>/Validform_v5.3.2_min.js"></script>
<script type="text/javascript">
    /*$('.adminex-form').Validform({
     tiptype:3
     });*/
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
<script>

    $("#site_name").focusout(function() {
        var site_name = $("#site_name").val();
        if(site_name != null && site_name != ''){
            checkSiteName(site_name);
        }
    });

    function checkSiteName(name){
        $.ajax({
                    url :"/index.php/Admin/Site/siteList/action/add",
                    type : "post",
                    dataType : 'JSON',
                    data : {site_name:name},
            success: function (res) {
                if (res.result == 1) {
                    layer.msg(res.msg);
                    $("#errorMsg").html("恭喜您，此站点名可用").css({color:"green"});
                }
                if (res.result == 0) {
                    layer.msg(res.msg);
                    $("#errorMsg").html("抱歉，此站点名不可用").css({color:"red"});
                    document.getElementById("site_name").value="";
                }
            }
                });
    }


    function selectedTp(obj) {

        $(".btn").removeClass('btn-success');
        $(".btn").addClass('btn-default');

        $(obj).removeClass('btn-default');
        $(obj).addClass('btn-success');
        $("#template_id").val($(obj).attr('id'));
    }

    $(function () {
        var catid = $("#template_cat").val();
        if (catid != undefined) {
            getTemplate(catid);
        }

    });

    $("#template_cat").bind('change', function () {
        var catid = $(this).val();
        $("#cat_id").val('');
        $("#template_id").val('');
        if (catid > 0) {
            $("#cat_id").val(catid);
        }
        getTemplate(catid);

    });

    function getTemplate(catid) {
        var url = "<?php echo U('Admin/Template/getTemplateByCat/catid');?>/" + catid;
        $.get(url, function (ret) {

            $("#tmpl_div").empty();
            if (ret != 0) {
                var data = JSON.parse(ret);

                $(data).each(function (i, item) {
                    var html = '<div class="row col-lg-4 col-xs-6 col-md-4 col-sm-6" style="margin-left:10px;margin-top: 10px;">' +
                            '<section class="thumbnail"><img src="' + item.image + '" height="90px" width="150px"/>' +
                            '<div class="caption" style="overflow: hidden;"><span>' + item.title + '</span> ' +
                            '<button type="button" id="' + item.id + '" class="btn btn-default" style="float: right;" onclick="selectedTp(this);">选中</button></div>' +
                            '</section></div>';
                    $("#tmpl_div").append(html);
                });
            }

        });
    }

    $("#create_btn").bind('click', function () {
        if (checkform()) {

            layer.load(0,{shade: [0.1,'#333']});
            var data = $("#siteform").serialize();
            $.ajax({
                type: "POST",
                data: data,
                url: "/index.php/Admin/Site/process",
                dataType: 'JSON',
                success: function (data) {
                    layer.closeAll();

                    if (data.result == 1) {

                        layer.msg("新站点已生成!", {time: 3000});

                        setTimeout('window.location.href = "/index.php/Admin/Site/siteList/action/page_list"', 3000);
                    } else {
                        layer.msg(data.msg, {time: 3000});
                    }
                }
            });
        }
    });

    $("#site_name").bind('blur', function () {
        if($("#site_id").val() > 0){
            return;
        }

        var site_name = $("#site_name").val();
        if (site_name == '') {
            $("#default_domain").val('');
            return;
        }
        var data = {'site_name': site_name};
        $.ajax({
            type: "POST",
            url: "/index.php/Admin/Site/checkSite",
            data: data,
            dataType: 'JSON',
            beforeSend: function () {
            },
            success: function (result) {
                //alert(JSON.stringify(result));
                if (result == 1) {
                    $("#site_name").val('');
                    $("#default_domain").val('');
                    layer.msg('系统名称已被使用，请重新输入!', {time: 2000});
                } else {
                    var domain = site_name + "<?php echo ($domain_suffix); ?>";
                    $("#default_domain").val(domain);
                }
            }
        });
    });

    function checkform() {

        if (!check('site_name', '站点名称为空!')) {
            return false;
        }
     /*   if (!check('template_id', '请先选择模板!')) {
            return false;
        }*/
        return true;
    }

    function check(id, errmsg) {
        if ($('#' + id).val() == null || $('#' + id).val() == '') {
            layer.msg(errmsg, {time: 2000});
            return false;
        }
        return true;
    }

</script>