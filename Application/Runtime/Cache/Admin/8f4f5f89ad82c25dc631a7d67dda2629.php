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


    .panel-left-content {
        margin-left: 10px;
        margin-top: 10px;
        border: 1px solid #ddd;
    }

    .panel-right-content {
        margin-left: 20px;
        margin-top: 10px;
        border: 1px solid #ddd;
        margin-right: 10px;
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
        padding-left: 20px;
    }
    .btn-setting {
        color: #333;
        background-color: #fff;
        border-color: #ccc;
        width: 250px;

    }




</style>

<body class="sticky-header">

<div class="main-content" width="100%" style="margin:0px;">
    <section class="wrapper">


        <form class="form-horizontal adminex-form" method="post" id="channel_form">
            <input type="hidden"  id="flow" name="flow" value="<?php echo ($flow); ?>">
            <div class="row">
                <div class="col-sm-12">
                    <div class="nav-panel">
                        <header class="panel-body panel-heading ">
                            <div class="pull-left ">
                                全局导航器模型设置
                            </div>
                            <div class="pull-right">
                                <div class="btn-group">
                                    <a class="btn btn-default" onclick="ajax_submit_form('channel_form')">
                                        <i class="fa fa-floppy-o"></i> &nbsp;保存
                                    </a>

                                </div>
                            </div>
                        </header>
                    </div>


                </div>
            </div>
            <div class="mail-box">

                <div class="mail-nav-body">
                    <div class="panel-left-content">
                        <header class="content-heading panel-body ">
                            <div class="pull-left ">
                                基础设置
                            </div>
                            <div class="pull-right ">

                            </div>
                        </header>
                        <div class="panel-body">
                            <div class="form-horizontal adminex-form">
                                <div class="col-md-12   ">
                                    <input type="hidden" id="id" name="id" value="<?php echo ($info["id"]); ?>">
                                    <?php if(!empty($extends)): if(is_array($extends)): foreach($extends as $key=>$extend): ?><input type="hidden" id="<?php echo ($extend["module"]); ?>_ex" value="<?php echo ($extend["extends"]); ?>"><?php endforeach; endif; endif; ?>


                                    <div class="form-group" onclick="" style="border:none;">
                                        <label class="col-sm-2 control-label">频道名称：</label>
                                        <div class="col-sm-9">
                                            <input type="text" placeholder="模块名称"
                                                   class="form-control form-input large"
                                                   name="channel_title" id="channel_title" datatype="s2-16"
                                                   nullmsg="模块名称为空" value="<?php echo ($info["channel_title"]); ?>">
                                        </div>
                                    </div>

                                    <div class="form-group" onclick="" style="border:none;">
                                        <label class="col-sm-2 control-label">频道模型：</label>
                                        <div class="col-sm-9">
                                            <input type="text"
                                                   class="form-control form-input large"
                                                   id="module_type" name='module_type' datatype="s2-16"
                                                   nullmsg="调用名称为空" value="<?php echo ($channel_type); ?>" readonly>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="mail-nav-body" >
                    <div class="panel-left-content">
                        <header class="content-heading panel-body">
                            <div class="pull-left ">
                                全局模块设置
                            </div>
                        </header>
                        <div class="panel-body">
                            <div class="col-sm-4" >
                                <div class="form-group">
                                    <label class="control-label col-sm-8">绑定用户：</label>
                                    <input type="checkbox" class="js-switch" name="is_bind_user" value="1"<?php if($info['is_bind_user'] == 1): ?>checked<?php endif; ?>>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mail-nav-body" >
                    <div class="panel-left-content">
                        <header class="content-heading panel-body">
                            <div class="pull-left ">
                                前端功能开启
                            </div>
                        </header>
                        <div class="panel-body">
                            <div class="col-sm-4" >
                                <div class="form-group">
                                    <label class="control-label col-sm-8">开启评论：</label>
                                    <input type="checkbox" class="js-switch form-control" name="is_comment" value="1"
                                    <?php if($info['is_comment'] == 1): ?>checked<?php endif; ?>
                                    >
                                </div>

                            </div>
                            <div class="col-sm-4" >
                                <div class="form-group">
                                    <label class="control-label col-sm-8">开启评论审核：</label>
                                    <input type="checkbox" class="js-switch" name="is_comment_reviewed" value="1"
                                    <?php if($info['is_comment_reviewed'] == 1): ?>checked<?php endif; ?>
                                    >
                                </div>
                            </div>

                            <div class="col-sm-4" >
                                <div class="form-group">
                                    <label class="control-label col-sm-8">自动审核：</label>
                                    <input type="checkbox" class="js-switch" name="is_content_reviewed" value="1"
                                    <?php if($info['is_content_reviewed'] == 1): ?>checked<?php endif; ?>
                                    >
                                </div>
                            </div>
                            <div class="col-sm-4" >

                                <div class="form-group">
                                    <label class="control-label col-sm-8">开启点赞：</label>
                                    <input type="checkbox" class="js-switch" name="is_like" value="1"
                                    <?php if($info['is_like'] == 1): ?>checked<?php endif; ?>
                                    >
                                </div>
                            </div>

                            <div class="col-sm-4" >
                                <div class="form-group">
                                    <label class="control-label col-sm-8">开启收藏：</label>
                                    <input type="checkbox" class="js-switch" name="is_collect" value="1"
                                    <?php if($info['is_collect'] == 1): ?>checked<?php endif; ?>
                                    >
                                </div>
                            </div>

                            <div class="col-sm-4" >
                                <div class="form-group">
                                    <label class="control-label col-sm-8">开启标签：</label>
                                    <input type="checkbox" class="js-switch" name="is_tag" value="1"
                                    <?php if($info['is_tag'] == 1): ?>checked<?php endif; ?>
                                    >
                                </div>
                            </div>
                            <div class="col-sm-4" >
                                <div class="form-group">
                                    <label class="control-label col-sm-8">开启打赏：</label>
                                    <input type="checkbox" class="js-switch" name="is_award" value="1"
                                    <?php if($info['is_award'] == 1): ?>checked<?php endif; ?>
                                    >
                                </div>
                            </div>

                            <div class="col-sm-4" >
                                <div class="form-group">
                                    <label class="control-label col-sm-8">开启抢红包：</label>
                                    <input type="checkbox" class="js-switch" name="is_red_packet" value="1"
                                    <?php if($info['is_red_packet'] == 1): ?>checked<?php endif; ?>
                                    >
                                </div>
                            </div>

                            <div class="col-sm-4" >
                                <div class="form-group">
                                    <label class="control-label col-sm-8">开启置顶：</label>
                                    <input type="checkbox" class="js-switch" name="is_top" value="1"
                                    <?php if($info['is_top'] == 1): ?>checked<?php endif; ?>
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mail-nav-body" >
                    <div class="panel-left-content">
                        <header class="content-heading panel-body">
                            <div class="pull-left ">
                                后台模块开启
                            </div>
                        </header>
                        <div class="panel-body">

                            <div class="col-sm-4" >

                                <div class="form-group">
                                    <label class="control-label col-sm-8">开启导入数据：</label>
                                    <input type="checkbox" class="js-switch" name="is_import_data" value="1"<?php if($info['is_import_data'] == 1): ?>checked<?php endif; ?>>
                                </div>
                            </div>
                            <div class="col-sm-4" >

                                <div class="form-group">
                                    <label class="control-label col-sm-8">开启导出数据：</label>
                                    <input type="checkbox" class="js-switch" name="is_export_data" value="1"<?php if($info['is_export_data'] == 1): ?>checked<?php endif; ?>>
                                </div>
                            </div>
                            <div class="col-sm-4" >
                                <div class="form-group">
                                    <label class="control-label col-sm-8">开启复制：</label>
                                    <input type="checkbox" class="js-switch" name="is_copy" value="1"<?php if($info['is_copy'] == 1): ?>checked<?php endif; ?>>
                                </div>
                            </div>
                            <div class="col-sm-4" >
                                <div class="form-group">
                                    <label class="control-label col-sm-8">自动审核：</label>
                                    <input type="checkbox" class="js-switch" name="is_auto_review" value="1"<?php if($info['is_auto_review'] == 1): ?>checked<?php endif; ?>>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="mail-nav">
                    <div class="panel-right-content">
                        <header class="panel-body content-heading">
                            <div class="pull-left ">
                                表单及功能配置
                            </div>
                        </header>
                        <!-- /.box-header -->
                        <div class="panel-body">
                            <div class="form-horizontal adminex-form">
                                <div class="panel-setting" onclick="" style="border:none;">
                                    <a class="btn btn-setting"
                                       href="/index.php/Admin/Channel/channelField/action/channel_field/channel/<?php echo ($info["call_index"]); ?>/type/1/flow/2/id/<?php echo ($info["id"]); ?>" title="编辑"><i class="fa fa-laptop"></i>表单模型配置 </a>
                                </div>

                                <div class="panel-setting" onclick="" style="border:none;">
                                    <a class="btn btn-setting"
                                       href="/index.php/Admin/ExportData/exportField/action/page_list/channel/<?php echo ($info[call_index]); ?>" title="导出"><i class="fa fa-external-link"></i>导出字段配置</a>
                                </div>

                                <div class="panel-setting" onclick="" style="border:none;">
                                    <a class="btn btn-setting"
                                       href="/index.php/Admin/ExportData/exportField/action/page_list/channel/<?php echo ($info[call_index]); ?>" title="导入"><i class="fa fa-external-link"></i>导入字段配置</a>
                                </div>


                            </div>
                        </div>

                    </div>

                    <div class="panel-right-content">

                        <header class="panel-body content-heading">
                            <div class="pull-left ">
                                父级信息配置
                            </div>
                        </header>
                        <!-- /.box-header -->
                        <div class="panel-body">
                            <div class="form-horizontal adminex-form">

                                <div class="panel-setting" onclick="" style="border:none;">
                                  <a class="btn btn-setting"
                                     href="/index.php/Admin/Channel/channel_field_config/action/field/channel/<?php echo ($info[call_index]); ?>/type/2/flow/2" title="编辑"><i class="fa fa-folder-open-o"></i>栏目模型配置</a>
                                </div>
                                <div class="panel-setting" onclick="" style="border:none;">
                                    <a class="btn btn-setting"
                                       href="/index.php/Admin/Channel/channel_field_config/action/field/channel/<?php echo ($info[call_index]); ?>/type/4/flow/2" title="标签"><i class="fa fa-tags"></i>标签模型配置 </a>
                                </div>


                                <?php if($info[have_order] == 1): ?><div class="panel-setting" onclick="" style="border:none;">
                                        <a class="btn btn-setting"
                                           href="/index.php/Admin/Channel/channel_field_config/action/field/channel/<?php echo ($info[call_index]); ?>/type/3/flow/2" title="订单"><i class="fa fa-file-text-o"></i>订单模型配置 </a>
                                    </div><?php endif; ?>

                                <?php if($info[base_module] == 'Company'): ?><div class="panel-setting" onclick="" style="border:none;">
                                        <a class="btn btn-setting"
                                           href="/index.php/Admin/Channel/channel_field_config/action/field/channel/<?php echo ($info[call_index]); ?>/type/3/flow/2" title="级别"><i class="fa fa-star"></i>级别模型设置  </a>
                                   </div>
                                    <div class="panel-setting" onclick="" style="border:none;">
                                        <a class="btn btn-setting"
                                           href="/index.php/Admin/Channel/channel_field_config/action/field/channel/<?php echo ($info[call_index]); ?>/type/6/flow/2" title="招聘"><i class="fa fa-user"></i>招聘模型设置 </a>
                                    </div>
                                    <div class="panel-setting" onclick="" style="border:none;">
                                        <a class="btn btn-setting"
                                           href="/index.php/Admin/Channel/channel_field_config/action/field/channel/<?php echo ($info[call_index]); ?>/type/7/flow/2" title="资料"><i class="fa fa-file-text"></i>资料模型设置 </a>
                                    </div>
                                    <div class="panel-setting" onclick="" style="border:none;">
                                        <a class="btn btn-setting"
                                           href="/index.php/Admin/Channel/channel_field_config/action/field/channel/<?php echo ($info[call_index]); ?>/type/8/flow/2" title="动态"><i class="fa fa-clock-o"></i>动态模型设置 </a>
                                    </div>
                                    <div class="panel-setting" onclick="" style="border:none;">
                                        <a class="btn btn-setting"
                                           href="/index.php/Admin/Channel/channel_field_config/action/field/channel/<?php echo ($info[call_index]); ?>/type/9/flow/2" title="招聘分类"><i class="fa fa-folder-open-o"></i>招聘分类模型设置 </a>
                                    </div><?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="panel-right-content">
                         <header class="panel-body content-heading">
                        <div class="pull-left ">
                            子表单模块配置
                        </div>
                        <?php if($flow == 2): ?><div class="pull-right">
                                <button id="add_child" class="btn btn-success btn-sm" type="button">添加</button>
                            </div><?php endif; ?>
                    </header>
                         <div class="panel-body">
                        <div class="form-horizontal adminex-form">
                            <?php if(is_array($child)): $i = 0; $__LIST__ = $child;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="panel-setting" style="border:none;">
                                    <a class="btn btn-setting"
                                       href="/index.php/Admin/Channel/child_config/action/child_field/flow/2/channel/<?php echo ($vo["channel_index"]); ?>/type/<?php echo ($vo["type"]); ?>" title="<?php echo ($vo["title"]); ?>"><i class="fa fa-laptop"></i><?php echo ($vo["title"]); ?>配置 </a>
                                </div><?php endforeach; endif; else: echo "" ;endif; ?>

                        </div>
                    </div>
                    </div>
                </div>

            <input type="hidden" id="theme_id" name="theme_id" value="<?php echo ($info["theme_id"]); ?>">
            </div>
        </form>
        <input type="hidden" id="module_name" value="">
    </section>
</div>

<script type="text/javascript" src="<?php echo (JS); ?>/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo (JS); ?>/Validform_v5.3.2_min.js"></script>
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

    //表单提交判断，id为空则URL表示添加，否则表示编辑
    function ajax_submit_form(form_id) {
        var index = $("#channel_title").val();

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
                        var redirectUrl = "/index.php/Admin/Channel/channelField/action/channel_field/channel/"+call_index+"/type/1/flow/<?php echo ($flow); ?>";
                        setTimeout(function () {
                            window.location.href = redirectUrl;
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
                layer.alert('配置完成，请刷新页面!', function(){
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

    $("#add_child").click(function(){
        /*var title = "添加子表单模块";
        var id = $("#id").val();
        var url = "/index.php/Admin/Channel/child_module/action/page_add/channel_id/"+id;

        layer_window(title, url);*/
        var html ='<div class="form-group" style="margin-top: 15%;padding-left: 30px">'+
                '<label class="pull-left" style="padding: 7px">子表单名称:</label>'+
                '<div class="col-lg-8"><div class="input-group m-bot15">' +
                '<input id="child_title" type="text" class="form-control" style="border-bottom-left-radius: 5px;border-top-left-radius: 5px;">'+
                '<span class="input-group-btn"><button onclick="create_child();" class="btn btn-default" type="button">保存</button></span>' +
                '</div></div></div>';
        //页面层
        layer.open({
            type: 1,
            title: '请输入子表单模块名称:',
            //skin: 'layui-layer-rim', //加上边框
            area: ['420px', '240px'], //宽高
            content: html
        });
    });

    function create_child(){
        var title = $("#child_title").val();
        if(title == null || title.length == 0){
            layer.msg("请先填写子表单模块名称!");
        }
        layer.closeAll();//关闭弹窗
        layer.load(2);
        var id = $("#id").val();
        var url = "/index.php/Admin/Channel/child_config/action/add";
        var data = {'channel_id':id, 'title':title};

        $.post(url, data, function(ret){

            if(ret.result == 1){
                layer.msg("新增子表单模块["+title+"]成功!");
                var type = ret.data;
                setTimeout(function(){
                    window.location.href = "/index.php/Admin/Channel/child_config/action/child_field/flow/1/channel/<?php echo ($info["call_index"]); ?>/type/"+type;
                },1500);

            }else{
                layer.msg(ret.msg);
            }
        });

    };


</script>