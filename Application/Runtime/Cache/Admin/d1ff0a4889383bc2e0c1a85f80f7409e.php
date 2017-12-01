<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="author" content="ThemeBucket">
    <meta name="keywords" content="<?php echo ($tpshop_config['shop_info_store_keyword']); ?>"/>
    <meta name="description" content="<?php echo ($tpshop_config['shop_info_store_desc']); ?>"/>

    <link rel="shortcut icon" href="#" type="image/png">
    <title><?php echo ($gemmapshop_config['shop_info_store_title']); ?></title>

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
                            <?php if($info["mod_id"] == null): ?>添加菜单
                                <?php else: ?>
                                编辑菜单<?php endif; ?>
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" id="postbutton" class="btn btn-default "
                                            onclick="ajax_submit_form('form_id_name')"><i class="fa fa-save"></i>保存
                                    </button>
                                    <a href="javascript:history.go(-1)" data-toggle="tooltip" title=""
                                       class="btn btn-default" data-original-title="返回管理员列表"><i class="fa fa-reply"></i>返回</a>
                                </div>
                            </div>
                        </header>

                        <div class="panel-body">
                            <form class="form-horizontal adminex-form" method="post" id="form_id_name">
                                <input type="hidden" id="id" name="id" value="<?php echo ($info["mod_id"]); ?>">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">菜单名称：</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="菜单名称" class="form-control form-input large"
                                               name="title" datatype="*" nullmsg="不得为空"
                                               value="<?php echo ($info["title"]); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2">上级菜单：</label>
                                    <div class="col-sm-3">
                                        <select class="small form-option" id="parent_id" name="parent_id"
                                                style="font-size: 14px;">
                                            <option value="0">&nbsp;无上级菜单</option>
                                            <?php if(is_array($menuTree)): foreach($menuTree as $key=>$v): if($v["level"] == 2): if($info["parent_id"] == $v["mod_id"] ): ?><option value="<?php echo ($v["mod_id"]); ?>" selected>&nbsp;<?php echo ($v["title"]); ?></option>
                                                        <?php else: ?>
                                                        <option value="<?php echo ($v["mod_id"]); ?>">&nbsp;<?php echo ($v["title"]); ?></option><?php endif; ?>
                                                    <?php else: ?>
                                                    <?php if($info["parent_id"] == $v["mod_id"] ): ?><option value="<?php echo ($v["mod_id"]); ?>" selected>
                                                            <?php $__FOR_START_24320__=3;$__FOR_END_24320__=$v["level"];for($i=$__FOR_START_24320__;$i < $__FOR_END_24320__;$i+=1){ ?>&nbsp;&nbsp;<?php } ?>
                                                            ┣<?php echo ($v["title"]); ?>
                                                        </option>
                                                        <?php else: ?>
                                                        <option value="<?php echo ($v["mod_id"]); ?>">
                                                            <?php $__FOR_START_9017__=3;$__FOR_END_9017__=$v["level"];for($i=$__FOR_START_9017__;$i < $__FOR_END_9017__;$i+=1){ ?>&nbsp;&nbsp;<?php } ?>
                                                            ┣<?php echo ($v["title"]); ?>
                                                        </option><?php endif; endif; endforeach; endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2">URL模式：</label>
                                    <div class="col-sm-3">
                                        <select class="small form-option" id="urlMode" name="urlMode" style="font-size: 14px;"
                                                onchange="urlModel(this)">
                                            <option value="1">&nbsp;URL地址模式</option>
                                            <option value="2">&nbsp;控制器方法模式</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group urlNameDiv">
                                    <label class="col-sm-2 control-label">调用URL地址：</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="调用URL地址" class="form-control form-input large"
                                               name="url" id="url" datatype="*" nullmsg="不得为空" value="<?php echo ($info["url"]); ?>">
                                    </div>
                                </div>
                                <div class="form-group ctlNameDiv" hidden>
                                    <label class="col-sm-2 control-label">调用控制器：</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="调用控制器" class="form-control form-input large"
                                               name="ctl" id="ctl" datatype="*" nullmsg="不得为空" value="<?php echo ($info["ctl"]); ?>">
                                    </div>
                                </div>
                                <div class="form-group actNameDiv" hidden>
                                    <label class="col-sm-2 control-label">调用方法：</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="调用方法（方法包含参数）" class="form-control form-input large"
                                               name="act" id="act" datatype="*" nullmsg="不得为空" value="<?php echo ($info["act"]); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">调用别名：</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="请输入英文或数字" class="form-control form-input large"
                                               name="call_index"
                                               id="call_index" datatype="*" nullmsg="不得为空" value="<?php echo ($info["call_index"]); ?>"
                                               onkeyup='this.value=this.value.replace(/[^a-zA-Z0-9]+/,"")'>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">菜单图标：</label>
                                    <div class="col-sm-9 btn-group">
                                        <div class="row">&nbsp;&nbsp;
                                            <?php if($menu["icon"] == 'fa-tasks'): ?><span class="iconspan"><input type="radio" checked name="icon" value="fa-tasks">&nbsp;&nbsp;<i
                                                        class="fa fa-tasks"></i></span>
                                                <?php else: ?>
                                                <span class="iconspan"><input type="radio" name="icon" value="fa-tasks">&nbsp;&nbsp;<i
                                                        class="fa fa-tasks"></i></span><?php endif; ?>
                                            <?php if($menu["icon"] == 'fa-cog'): ?><span class="iconspan"><input type="radio" checked name="icon" value="fa-cog">&nbsp;&nbsp;<i
                                                        class="fa fa-cog"></i></span>
                                                <?php else: ?>
                                                <span class="iconspan"><input type="radio" name="icon" value="fa-cog">&nbsp;&nbsp;<i
                                                        class="fa fa-cog"></i></span><?php endif; ?>
                                            <?php if($menu["icon"] == 'fa-dashboard'): ?><span class="iconspan"><input type="radio" checked name="icon" value="fa-dashboard">&nbsp;&nbsp;<i
                                                        class="fa fa-dashboard"></i></span>
                                                <?php else: ?>
                                                <span class="iconspan"><input type="radio" name="icon" value="fa-dashboard">&nbsp;&nbsp;<i
                                                        class="fa fa-dashboard"></i></span><?php endif; ?>
                                            <?php if($menu["icon"] == 'fa-retweet'): ?><span class="iconspan"><input type="radio" checked name="icon" value="fa-retweet">&nbsp;&nbsp;<i
                                                        class="fa fa-retweet"></i></span>
                                                <?php else: ?>
                                                <span class="iconspan"><input type="radio" name="icon"
                                                                              value="fa-retweet">&nbsp;&nbsp;<i
                                                        class="fa fa-retweet"></i></span><?php endif; ?>
                                            <?php if($menu["icon"] == 'fa-align-left'): ?><span class="iconspan"><input type="radio" checked name="icon" value="fa-align-left">&nbsp;&nbsp;<i
                                                        class="fa fa-align-left"></i></span>
                                                <?php else: ?>
                                                <span class="iconspan"><input type="radio" name="icon" value="fa-align-left">&nbsp;&nbsp;<i
                                                        class="fa fa-align-left"></i></span><?php endif; ?>
                                            <?php if($menu["icon"] == 'fa-table'): ?><span class="iconspan"><input type="radio" checked name="icon" value="fa-table">&nbsp;&nbsp;<i
                                                        class="fa fa-table"></i></span>
                                                <?php else: ?>
                                                <span class="iconspan"><input type="radio" name="icon" value="fa-table">&nbsp;&nbsp;<i
                                                        class="fa fa-table"></i></span><?php endif; ?>
                                            <?php if($menu["icon"] == 'fa-bar-chart-o'): ?><span class="iconspan"><input type="radio" checked name="icon" value="fa-bar-chart-o">&nbsp;&nbsp;<i
                                                        class="fa fa-bar-chart-o"></i></span>
                                                <?php else: ?>
                                                <span class="iconspan"><input type="radio" name="icon" value="fa-bar-chart-o">&nbsp;&nbsp;<i
                                                        class="fa fa-bar-chart-o"></i></span><?php endif; ?>
                                        </div>
                                        <div class="row">&nbsp;&nbsp;
                                            <?php if($menu["icon"] == 'fa-google-plus-square'): ?><span class="iconspan"><input type="radio" checked name="icon"
                                                                              value="fa-google-plus-square">&nbsp;&nbsp;<i
                                                        class="fa fa-google-plus-square"></i></span>
                                                <?php else: ?>
                                                <span class="iconspan"><input type="radio" name="icon" value="fa-google-plus-square">&nbsp;&nbsp;<i
                                                        class="fa fa-google-plus-square"></i></span><?php endif; ?>
                                            <?php if($menu["icon"] == 'fa-book'): ?><span class="iconspan"><input type="radio" checked name="icon" value="fa-book">&nbsp;&nbsp;<i
                                                        class="fa fa-book"></i></span>
                                                <?php else: ?>
                                                <span class="iconspan"><input type="radio" name="icon" value="fa-book">&nbsp;&nbsp;<i
                                                        class="fa fa-book"></i></span><?php endif; ?>
                                            <?php if($menu["icon"] == 'fa-flag'): ?><span class="iconspan"><input type="radio" checked name="icon" value="fa-flag">&nbsp;&nbsp;<i
                                                        class="fa fa-flag"></i></span>
                                                <?php else: ?>
                                                <span class="iconspan"><input type="radio" name="icon" value="fa-flag">&nbsp;&nbsp;<i
                                                        class="fa fa-flag"></i></span><?php endif; ?>
                                            <?php if($menu["icon"] == 'fa-home'): ?><span class="iconspan"><input type="radio" checked name="icon" value="fa-home">&nbsp;&nbsp;<i
                                                        class="fa fa-home"></i></span>
                                                <?php else: ?>
                                                <span class="iconspan"><input type="radio" name="icon" value="fa-home">&nbsp;&nbsp;<i
                                                        class="fa fa-home"></i></span><?php endif; ?>
                                            <?php if($menu["icon"] == 'fa-pencil'): ?><span class="iconspan"><input type="radio" checked name="icon" value="fa-pencil">&nbsp;&nbsp;<i
                                                        class="fa fa-pencil"></i></span>
                                                <?php else: ?>
                                                <span class="iconspan"><input type="radio" name="icon"
                                                                              value="fa-pencil">&nbsp;&nbsp;<i
                                                        class="fa fa-pencil"></i></span><?php endif; ?>
                                            <?php if($menu["icon"] == 'fa-star'): ?><span class="iconspan"><input type="radio" checked name="icon" value="fa-star">&nbsp;&nbsp;<i
                                                        class="fa fa-star"></i></span>
                                                <?php else: ?>
                                                <span class="iconspan"><input type="radio" name="icon" value="fa-star">&nbsp;&nbsp;<i
                                                        class="fa fa-star"></i></span><?php endif; ?>
                                            <?php if($menu["icon"] == 'fa-user'): ?><span class="iconspan"><input type="radio" checked name="icon" value="fa-user">&nbsp;&nbsp;<i
                                                        class="fa fa-user"></i></span>
                                                <?php else: ?>
                                                <span class="iconspan"><input type="radio" name="icon" value="fa-user">&nbsp;&nbsp;<i
                                                        class="fa fa-user"></i></span><?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">菜单权限：</label>
                                    <div class="col-sm-9 btn-group" id="roleActionDiv"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2">排序：</label>
                                    <div class="col-sm-6">
                                        <?php if($info["orderby"] != null): ?><input type="text" placeholder="请输入排序值" datatype="*" nullmsg="请输入排序值"
                                                   class="form-control form-input large" name="orderby" id="orderby"
                                                   value="<?php echo ($info["orderby"]); ?>"/>
                                            <?php else: ?>
                                            <input type="text" placeholder="请输入排序值" datatype="*" nullmsg="请输入排序值"
                                                   class="form-control form-input large" name="orderby" value="99"
                                                   maxlength="4" onkeyup='this.value=this.value.replace(/\D/gi,"")'/><?php endif; ?>
                                        <span class="help-inline" style="color:#F00; display:none;" id="err_orderby_order"></span>
                                    </div>
                                </div>
                            </form>
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
<!--common scripts for all pages-->
<script src="<?php echo (JS); ?>/scripts.js"></script>
<script>
    //表单提交判断，id为空则URL表示添加，否则表示编辑
    function ajax_submit_form(form_id) {
        //判断id值是否存在
        var id = $("#id").val();
        var action = '';
        if (id == '') {
            //不存在，表示添加
            action = "/index.php/Admin/System/menu/action/add";
        } else {
            //存在，表示编辑
            action = "/index.php/Admin/System/menu/action/edit";
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
                        window.location.href = "/index.php/Admin/System/menu/action/page_list";
                    }, 1000);
                }
                if (res.result == 0) {
                    layer.msg(res.msg);
                }
            }
        })
    }
    //调用菜单模式选择。添加删除输入框
    function urlModel(obj) {
        var value = $(obj).val();
        if (value == 1) {
            $(".urlNameDiv").attr("hidden", false);
            $(".ctlNameDiv").attr("hidden", true);
            $(".actNameDiv").attr("hidden", true);
        } else if (value == 2) {
            $(".urlNameDiv").attr("hidden", true);
            $(".ctlNameDiv").attr("hidden", false);
            $(".actNameDiv").attr("hidden", false);
        }

    }
    $(function () {
        var roleActionDiv = $("#roleActionDiv");
        var str = '';
        var roleActionStr = '<?php echo ($info["action"]); ?>';
        if (roleActionStr != '') {
            roleActionStr = JSON.parse('<?php echo ($info["action"]); ?>');
            str += '<label class="checkbox-inline">' +
                    '<input type="checkbox" name="roleAction[show]" value="1"> 查看</label>';
            str += '<label class="checkbox-inline">' +
                    '<input type="checkbox" name="roleAction[add]"  value="1"> 添加</label>';
            str += '<label class="checkbox-inline">' +
                    '<input type="checkbox" name="roleAction[edit]"  value="1"> 修改</label>';
            str += '<label class="checkbox-inline">' +
                    '<input type="checkbox" name="roleAction[del]"  value="1"> 删除</label>';
        } else {
            str += '<label class="checkbox-inline">' +
                    '<input type="checkbox" name="roleAction[show]" value="1"> 查看</label>';
            str += '<label class="checkbox-inline">' +
                    '<input type="checkbox" name="roleAction[add]"  value="1"> 添加</label>';
            str += '<label class="checkbox-inline">' +
                    '<input type="checkbox" name="roleAction[edit]"  value="1"> 修改</label>';
            str += '<label class="checkbox-inline">' +
                    '<input type="checkbox" name="roleAction[del]"  value="1"> 删除</label>';
        }
        roleActionDiv.append(str);
    })
</script>
</body>
</html>