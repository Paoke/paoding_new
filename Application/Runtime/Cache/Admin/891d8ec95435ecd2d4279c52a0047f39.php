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
    <link rel="stylesheet" type="text/css" href="<?php echo (CSS); ?>/jcDate.css" media="all"/>

    <script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="/Public/js/global.js"></script>
    <script src="/Public/js/myFormValidate.js"></script>
    <script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
    <script src="/Public/js/myAjax.js"></script>
    <script src="/Public/js/PCASClass.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
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

        /*.borderno{border-top:none;border-bottom:none;}*/
        .form-input {
            width: 400px;
            display: inline-block;
        }
        #jcDate * {
            margin: 0;
            padding: 0;
            font-size: 12px;
            color: #555555;
            list-style: none;
        }
        input.jcDate{cursor:pointer;width: 95%;}
    </style>

</head>
<style type="text/css">
</style>

<body class="sticky-header">
<section>
    <div class="main-content" width="100%" style="margin:0px;">
        <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel">
                        <header class="panel-heading">
                            <?php if($info): ?>编辑广告
                                <?php else: ?>
                                新增广告<?php endif; ?>
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" id="postbutton" class="btn btn-default "
                                            onclick="ajax_submit_form('form_id_name')"><i class="fa fa-save"></i>提交
                                    </button>
                                    <a href="javascript:history.go(-1)" data-toggle="tooltip" title=""
                                       class="btn btn-default"><i class="fa fa-reply"></i>返回</a>
                                </div>
                            </div>
                        </header>

                        <div class="panel-body">
                            <form class="form-horizontal adminex-form" method="post" id="form_id_name"
                            >
                            <div class="form-group">
                                <input type="hidden" id="id" name="id" value="<?php echo ($info["id"]); ?>">
                                <label class="col-sm-2 col-sm-2 control-label">广告标题：</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="自定义广告名称" class="form-control large form-input" name="ad_name"
                                           value="<?php echo ($info["ad_name"]); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2">广告位：</label>
                                <div class="col-sm-3">
                                    <select class="small form-control form-input" id="pid" name="pid">
                                        <option value="0">请选择广告位</option>
                                        <?php if(is_array($position)): foreach($position as $key=>$vo): ?><option value="<?php echo ($vo["position_id"]); ?>"

                                            <?php if($vo['position_id'] == $info['pid']): ?>selected="selected"<?php endif; ?>
                                            ><?php echo ($vo["position_name"]); ?></option><?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                            <!--<div class="form-group">-->
                            <!--<label class="control-label col-sm-2">广告类型：</label>-->
                            <!--<div class="col-sm-3">-->
                            <!--<select class="small form-control" id="media_type" name="media_type">-->
                            <!--<option value="0">请选择广告类型</option>-->
                            <!--<?php if(is_array($r)): foreach($r as $key=>$vo): ?>-->
                            <!--<option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["title"]); ?></option>-->
                            <!--<?php endforeach; endif; ?>-->
                            <!--</select>-->
                            <!--</div>-->
                            <!--</div>-->
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">链接地址：</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="链接地址" class="form-control large form-input" name="ad_link"
                                           value="<?php echo ($info["ad_link"]); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">广告图片：</label>
                                <div class="col-sm-9 btn-group">
                                    <input type="text" placeholder="广告图片" class=" form-control form-input" id="ad_code"
                                           name="ad_code"
                                           value="<?php echo ($info["ad_code"]); ?>" style="width:400px;float: left;" readonly/>
                                    <div class="col-sm-3">
                                        <input class="btn btn-info" style="float: left form-input;" type="button" value="上传图片"
                                               onclick="GetUploadify(1,'ad_code','ad','');"/>
                                        &nbsp;&nbsp;
                                        <button class="btn btn-info " type="button" onclick="preview('ad_code')">预览
                                        </button>
                                    </div>
                                    &nbsp;&nbsp;
                                </div>

                            </div>

                            <!--<div class="form-group">-->
                                <!--<label class="col-sm-2 col-sm-2 control-label">开始时间：</label>-->
                                <!--<div class="col-sm-6">-->
                                    <!--<span class="input-group-addon col-md-1" onclick="laydate({elem: '#start'})"><i class="fa fa-calendar"></i></span>-->
                                    <!--<input class="col-sm-3" type="text" name="start_time" id="start"-->
                                           <!--value="<?php echo ($info["start_time"]); ?>"/>-->
                                <!--</div>-->
                            <!--</div>-->
                            <!--<div class="form-group">-->
                                <!--<label class="col-sm-2 col-sm-2 control-label">结束时间：</label>-->
                                <!--<div class="col-sm-6">-->
                                    <!--<span class="input-group-addon col-md-1" onclick="laydate({elem:'#end'})"><i class="fa fa-calendar"></i></span>-->
                                    <!--<input class=" col-sm-3" type="text" name="end_time" id="end"-->
                                           <!--value="<?php echo ($info["end_time"]); ?>"/>-->
                                <!--</div>-->
                            <!--</div>-->
                            <!--<div class="form-group">-->
                                <!--<label class="col-sm-2 col-sm-2 control-label">显示排序：</label>-->
                                <!--<div class="col-sm-9 btn-group">-->
                                    <!--<input type="text" placeholder="99" class="form-control large form-input" name="orderby"-->
                                           <!--value="<?php if($info["id"] != null): echo ($info["orderby"]); else: ?>99<?php endif; ?>"/>-->
                                        <!--<span class="help-inline" style="color:#F00; display:none;"-->
                                              <!--id="err_sort_order"></span>-->
                                <!--</div>-->

                            <!--</div>-->
                            <!--<div class="form-group">-->
                                <!--<label class="col-sm-2 col-sm-2 control-label">备注：</label>-->
                                <!--<div class="col-sm-9">-->
                                        <!--<textarea placeholder="备注" class="form-control" rows="5" style="resize: none"-->
                                                  <!--name="remark"><?php if($r_info["id"] != null): echo ($r_info["remark"]); ?>-->
                                        <!--<?php endif; ?></textarea>-->
                                <!--</div>-->
                            <!--</div>-->
                            </form>
                        </div>
                    </div>
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
<script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
<script src="/Public/js/laydate/laydate.js"></script>
<!--common scripts for all pages-->
<script src="<?php echo (JS); ?>/scripts.js"></script>
<!--pickers initialization-->
<script src="<?php echo (JS); ?>/js/pickers-init.js"></script>

<script type="text/javascript">

    $(function () {
        $("input.jcDate").jcDate({
            IcoClass: "jcDateIco",
            Event: "click",
            Speed: 100,
            Left: 0,
            Top: 28,
            format: "-",
            Timeout: 100
        });
    });

    function preview(id) {
        var src = $('#' + id).val();
        var content;
        if (src == "") {
            content = '没有图片可供预览';
            layer.msg(content);
        }
        else {
            content = "<img width='300' height='300' src='" + src + "'>";
            layer.open({
                type: 1,
                title: false,
                closeBtn: false,
                area: ['300px', '300px'],
                skin: 'layui-layer-nobg', //没有背景色
                shadeClose: true,
                content: content
            });
        }
    }


    //表单提交判断，id为空则URL表示添加，否则表示编辑
    function ajax_submit_form(form_id) {
        //判断id值是否存在
        var id = $("#id").val();
        var action = '';
        if (id == '') {
            //不存在，表示添加
            action = "/index.php/Admin/Ad/ad/action/add";
        } else {
            //存在，表示编辑
            action = "/index.php/Admin/Ad/ad/action/edit";
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
                        window.location.href = "/index.php/Admin/Ad/ad/action/page_list";
                    }, 1000);
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