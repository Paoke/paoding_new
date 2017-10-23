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

    <!--ios7-->
    <!--[if lte IE 8]>
    <link href="/Public/js/common/multi-checkbox.ie8" rel="stylesheet"/>
    <![endif]-->
    <link href="/Public/js/common/multi-checkbox.css" rel="stylesheet"/>

    <!--dynamic table-->
    <link href="<?php echo (JS); ?>/advanced-datatable/css/demo_page.css" rel="stylesheet"/>
    <link href="<?php echo (JS); ?>/advanced-datatable/css/demo_table.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo (JS); ?>/data-tables/DT_bootstrap.css"/>
    <!-- form -->
    <link href="<?php echo (JS); ?>/form/scripts/plugins/wizard/wizard.css" rel="stylesheet" />

    <script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="/Public/js/global.js"></script>
    <script src="/Public/js/myFormValidate.js"></script>
    <script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
    <script src="/Public/js/myAjax.js"></script>
    <script src="/Public/js/common.js" type="text/javascript"></script>
    <!--ios7-->
    <link rel="stylesheet" type="text/css" href="/Public/bootstrap/js/ios-switch/switchery.css"/>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<style type="text/css">

    .mail-nav-body {
        padding-right: 20px;
    }
    .mail-nav {
        display: table-cell;
        float: none;
        height: 100%;
        vertical-align: top;
        width: 250px;
    }
    .panel-left-content {
        margin-left: 10px;
        margin-top: 10px;
        border: 1px solid #ddd;
        min-height: 380px;
    }

    .panel-right-content {
        margin-left: 20px;
        margin-top: 10px;
        border: 1px solid #ddd;
        margin-right: 10px;
        min-height: 380px;
    }

    nav {
        margin-bottom: 0;
        padding-left: 15px;
        list-style: none;
    }

    .nav > li > a:hover, .nav > li > a:focus {
        background: none;
        text-decoration: none;
    }

    label {
        display: inline-block;
        margin-bottom: -8px !important;
    }

    * {
        margin: 0;
        padding: 0;
        list-style-type: none;
    }

    a, img {
        border: 0;
    }
    .nav-panel {
        background-color: rgb(255, 255, 255);
        border-top: 1px solid rgb(221, 221, 221);
        border-right:  1px solid rgb(221, 221, 221);
        border-left:  1px solid rgb(221, 221, 221);
        border-image-source: initial;
        border-image-slice: initial;
        border-image-width: initial;
        border-image-outset: initial;
        border-image-repeat: initial;

    }

    .content-heading {
        border-bottom: 1px solid #ddd;
        text-transform: uppercase;
        color: #65CEA7;
        font-size: 16px;
        font-weight: bold;
        padding: 10px 15px;
        border-bottom: 1px solid #ddd;
        border-top-right-radius: 3px;
        border-top-left-radius: 3px;
    }

    .thumbnail{
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
    .thumbnail img{width: 400px;height: 200px;}

    .banner{width:335px; height:534px; position:relative; margin-left:30px; float: left;}
    .scroll{width:330px; height:534px; overflow:hidden; position:relative;}
    .banner ul{ width:9999px; position:absolute;}
    .banner ul li{ float: left;}
    .banner span{width:30px; height:30px; position:absolute; left:-29px; top:50%; margin-top: -26px; background: rgba(0, 0, 0, 0.23); }
    .banner span.rightBtn{  left:auto; right:-25px; background-position: right top;}
    .lang h6{text-align: center; margin:5px;}
    .size {height: 100px;width: 25%;background: #e8e6e6; margin:10px;line-height: 100px; text-align: center;float: left;position: relative;}
    .size img{margin-top:10px;}
    .panel-setting {
        margin-bottom: 10px;
        background-color: #fff;
        border: none;
        padding-left: 5px;
    }
    .btn-setting {
        color: #333;
        background-color: #fff;
        border-color: #ccc;
        width: 180px;

    }




</style>

<body class="sticky-header">

<div class="main-content" width="100%" style="margin:0px;">
    <section >
        <form class="form-horizontal adminex-form" method="post" id="channel_form">
            <input type="hidden"  id="flow" name="flow" value="<?php echo ($flow); ?>">
            <div class="row">
                <div class="col-sm-12">
                    <div class="nav-panel">
                        <header class="panel-body panel-heading ">
                            <div class="pull-left ">
                                <a class="btn btn-default" onclick="create_channel();">
                                    <i class="fa fa-check"></i> &nbsp;启用该模型
                                </a>
                            </div>
                            <div class="pull-right">
                                <div class="btn-group">
                                    <a class="btn btn-default"  >
                                        <i class="fa fa-tablet"></i> &nbsp;手机端
                                    </a>

                                    <a class="btn btn-primary" onclick="ajax_submit_form('channel_form')">
                                        <i class="fa fa-desktop"></i> &nbsp;电脑端
                                    </a>


                                </div>
                            </div>
                        </header>
                    </div>


                </div>
            </div>
            <div class="mail-box">

                <div class="mail-nav">

                    <div class="panel-right-content">

                        <header class="panel-body content-heading">
                            <div class="pull-left ">
                                菜单导航
                            </div>
                        </header>
                        <!-- /.box-header -->
                        <div class="panel-body">
                            <div class="form-horizontal adminex-form">
                                <div class="panel-setting" onclick="" style="border:none;">
                                    <a class="btn btn-setting"
                                       href="#" title=""><i class="fa fa-laptop"></i>菜单一 </a>
                                </div>

                                <div class="panel-setting" onclick="" style="border:none;">
                                    <a class="btn btn-setting"
                                       href="#" title=""><i class="fa fa-external-link"></i>菜单二</a>
                                </div>

                                <div class="panel-setting" onclick="" style="border:none;">
                                    <a class="btn btn-setting"
                                       href="#" title=""><i class="fa fa-external-link"></i>菜单三</a>
                                </div>




                            </div>
                        </div>

                    </div>


                </div>

                <div class="mail-nav-body">
                    <div class="panel-left-content">
                        <header class="content-heading panel-body ">
                            <div class="pull-left ">
                                应用标题
                            </div>
                            <div class="pull-right ">

                            </div>
                        </header>
                        <div class="panel-body">

                        </div>
                    </div>
                </div>





            </div>
            <input type="hidden" id="theme_id" name="theme_id" value="<?php echo ($info["theme_id"]); ?>">
        </form>
        <input type="hidden" id="module_name" value="">
    </section>
</div>

<script type="text/javascript" src="<?php echo (JS); ?>/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo (JS); ?>/Validform_v5.3.2_min.js"></script>
<!--<script type="text/javascript">
    var valid = $('#channel_form').Validform({
        tiptype: 3,
        postonce: true
    });
    var addFlag = "<?php echo ($add); ?>";
    if(addFlag == 1){
        valid.addRule([
            {
                ele: "#call_index",
                datatype: "s4-200",
                ajaxurl: "/index.php/Admin/Channel/channel/action/check",
                nullmsg: "英文频道别名为空!",
                sucmsg: "英文频道别名可用!",
                errormsg: "频道别名为4-100位的英文字符串!"
            }]);
    }else{
        valid.addRule([
            {
                ele: "#call_index",
                datatype: "s4-100",
                nullmsg: "英文频道别名为空!",
                sucmsg: "英文频道别名可用!",
                errormsg: "频道别名为4-100位的英文字符串!"
            }]);
    }

</script>-->
<!-- Placed js at the end of the document so the pages load faster -->
<script src="<?php echo (JS); ?>/jquery-1.10.2.min.js"></script>
<script src="<?php echo (JS); ?>/jquery-ui-1.9.2.custom.min.js"></script>
<script src="<?php echo (JS); ?>/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo (JS); ?>/bootstrap.min.js"></script>
<script src="<?php echo (JS); ?>/modernizr.min.js"></script>
<script src="<?php echo (JS); ?>/jquery.nicescroll.js"></script>
<script src="/Public/js/layer/layer-min.js"></script>
<script src="<?php echo (JS); ?>/pinyin.js"></script>
<!--common scripts for all pages-->
<script src="<?php echo (JS); ?>/scripts.js"></script>

<script>

    $(function () {
        var type = $("#module_type").val();
        $("#top_btn").click(function () {
            if (scroll == "off") return;
            $("html,body").animate({scrollTop: 0}, 600);
        });
    });

    function create_channel(){
        var url = "/index.php/Admin/Channel/channel/action/page_add/channel_type/<?php echo ($channel_type); ?>/list_type_id/<?php echo ($list_type_id); ?>/flow/1";
        parent.location.href = url;
    }


    //表单提交判断，id为空则URL表示添加，否则表示编辑
    function ajax_submit_form(form_id) {
        var index = $("#channel_title").val();
       /* var pp= pinyin.getFullChars(index);
        $('#call_index' ).val(pp);*/
      /*  if (!valid.check()) {
            layer.alert('请先将所有信息填写完整，再提交!', {icon: 2});
            return;
        }*/
        /*var module_type = $("#module_type").val();
         if(module_type != 'System'){
         var theme_id = $("#theme_id").val();
         if( theme_id == undefined || theme_id == null || theme_id == ''){
         layer.alert('请先选择主题模板，再提交!', {icon: 2});
         return;
         }
         }*/

        //判断id值是否存在
        var id = $("#id").val();
        var action = '';
        if (id == '') {
            //不存在，表示添加
            action = "/index.php/Admin/Channel/channel/action/add/list_type_id/<?php echo ($list_type_id); ?>";
        } else {
            //存在，表示编辑
            action = "/index.php/Admin/Channel/channel/action/edit/id/" + id;
        }

        //异步提交表单数据
        if(index == 0) {
            layer.alert('请先将频道名称填写完整，再点击下一步!', {icon: 2});
        } else {
            layer.load(2);
            $.ajax({
                type: "post",
                url: action,
                data: $('#channel_form').serialize(),
                dataType: 'json',
                success: function (res) {
                    layer.closeAll('loading');

                    if (res.result == 1) {
                        var call_index =  res.data;

                        setTimeout(function () {
                            //layer.msg(res.msg);
                        }, 1000);
                    }

                    layer.msg(res.msg);

                }
            });
        }

    }


    // 加载频道模板
    $(function(){
        var module_type = $("#module_type").val();
        loadChannelTemplate(module_type);

    });

    $("#module_type").bind('change', function(){
        var module_type = $(this).val();
        loadChannelTemplate(module_type);
    });

    function loadChannelTemplate(module_type){
        if(module_type == 'System'){ //System没有模板
            $("#select_channel_div").hide();
            return;
        }
        $("#tmpl_div").empty();
        $("#select_channel_div").show();
        var url = "/index.php/Admin/Template/channelTemplate/action/json_list/module/"+module_type;
        $.ajax({
            type: "post",
            url: url,
            dataType: 'json',
            success: function (res) {

                if (res.result == 1) {

                    $(res.data).each(function(i, item){
                        var button_class = "btn btn-default";
                        var theme_id = $("#theme_id").val();
                        if(item.id == theme_id){
                            button_class = "btn btn-success";
                        }

                        var html = '<div class="row col-lg-4 col-xs-6 col-md-4 col-sm-6" style="margin-left:10px;margin-top: 10px;">'+
                                '<section class="thumbnail"><img src="'+item.image+'" height="90px" width="150px">'+
                                '<div class="caption" style="overflow: hidden;"><span>'+item.theme_title+'</span>'+
                                '<button type="button" id="'+item.id+'" class="'+ button_class +'" style="float: right;" onclick="selectedTp(this);">选中</button>'+
                                '</div></section></div>';
                        $("#tmpl_div").append(html);
                    });

                }else{
                    layer.msg(res.msg);
                }
            }
        });

    }

    function selectedTp(obj){

        $(".btn").removeClass('btn-success');
        $(".btn").addClass('btn-default');

        $(obj).removeClass('btn-default');
        $(obj).addClass('btn-success');
        $("#theme_id").val($(obj).attr('id'));
    }
</script>

<!--ios7-->
<script src="/Public/bootstrap/js/ios-switch/switchery.js"></script>
<script src="/Public/bootstrap/js/ios-switch/ios-init.js"></script>

</body>
</html>
<script>
    $(".flow-steps li").click(function(){
        var obj = $(this);
        var flow = $("#flow").val();
        if(flow == 2){

            if(obj.hasClass('complete')){
                return;
            }
            $(".flow-steps li").removeClass('complete').addClass('active');
            obj.removeClass().addClass('complete');

            var url = obj.attr('href');
            var step = obj.attr('data-target');
            if(step == '#step-6'){
                layer.alert('应用模块配置完成，请刷新网站以加载模块菜单!', function(){
                    window.location.href = '/index.php/Admin/Channel/channel/action/page_list';
                });
                setTimeout("window.location.href = '/index.php/Admin/Channel/channel/action/page_list'", 2000);
            }else{
                if(url != undefined && url != null && url != ''){
                    window.location.href = url;
                }
            }
        }
    });


    // 自动轮播
    $(function(e) {
        var num = 0;
        var timer = null;

        //角标的工作
        $('.banner li').click(function(e) {
            var selfIndex = $(this).index()
            $(this).addClass('current').siblings().removeClass('current');
            $('.banner ul').animate({'left':-330*selfIndex},400)
            num = selfIndex;
        });


        //自动轮播
        function autoplay(){
            num++;
            if(num>5){
                num = 0;
            }

            $('.banner ul').animate({'left':-330*num},400)
        }
        timer = setInterval(autoplay,3000)

        //鼠标移上关闭定时器
        $('.banner').mouseenter(function(e) {
            clearInterval(timer)
        }).mouseleave(function(e) {
            timer = setInterval(autoplay,3000)
        });


        //按钮
        $('.rightBtn').click(function(e) {
            autoplay();
        });
        $('.leftBtn').click(function(e) {
            num--;
            if(num<0){
                num = 5;
            }

            $('.banner ul').animate({'left':-330*num},400)
        });
    });


</script>