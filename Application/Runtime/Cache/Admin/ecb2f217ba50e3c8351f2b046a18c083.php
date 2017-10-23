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
                            <?php if($info["id"] == null): ?>添加组织机构
                                <?php else: ?>
                                编辑组织机构<?php endif; ?>
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="reset" class="btn btn-default">重填</button>
                                    <button type="button" id="postbutton" class="btn btn-default "
                                            onclick="ajax_submit_form('form_id_name')">提交
                                    </button>
                                    <a href="javascript:history.go(-1)" data-toggle="tooltip" title=""
                                       class="btn btn-default" data-original-title="返回管理员列表">返回</a>
                                </div>
                            </div>
                        </header>
                        
                        <div class="panel-body">
                            <form class="form-horizontal adminex-form" method="post" id="form_id_name">
                                <input type="hidden" id="id" name="id" value="<?php echo ($info["id"]); ?>">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">机构简称：</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="组织机构简称（默认显示简称）" class="form-control form-input large"
                                               name="name" id="name" datatype="*1-40" nullmsg="组织机构名称为空" value="<?php echo ($info["name"]); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">机构全称：</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="组织机构全称" class="form-control form-input large"
                                               name="full_name" id="full_name" datatype="*1-40" nullmsg="组织机构名称为空"
                                               value="<?php echo ($info["full_name"]); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">图标：</label>
                                    <div class="col-sm-9 btn-group">
                                        <input type="text" placeholder="图标或LOGO" class=" form-control" id="logo" name="logo"
                                               value="<?php echo ($info["logo"]); ?>" style="width:400px;float: left;" readonly/>
                                        <div class="col-sm-3">
                                            <input class="btn btn-default" style="float: left;" type="button" value="上传图片"
                                                   onclick="GetUploadify(1,'logo','manage_department','');"/>
                                            &nbsp;&nbsp;
                                            <button class="btn btn-default " type="button" onclick="preview('logo')">预览</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2">上级机构：</label>
                                    <div class="col-sm-3">
                                        <select class="small form-option" id="parent_id" name="parent_id" style="font-size: 14px;">
                                            <option value="0">&nbsp;无上级机构</option>
                                            <?php if(is_array($departmentTree)): foreach($departmentTree as $key=>$v): if($v["level"] == 2): if($info["parent_id"] == $v["id"] ): ?><option value="<?php echo ($v["id"]); ?>" selected>&nbsp;<?php echo ($v["name"]); ?></option>
                                                        <?php else: ?>
                                                        <option value="<?php echo ($v["id"]); ?>">&nbsp;<?php echo ($v["name"]); ?></option><?php endif; ?>
                                                    <?php else: ?>
                                                    <?php if($info["parent_id"] == $v["id"] ): ?><option value="<?php echo ($v["id"]); ?>" selected>
                                                            <?php $__FOR_START_18100__=3;$__FOR_END_18100__=$v["level"];for($i=$__FOR_START_18100__;$i < $__FOR_END_18100__;$i+=1){ ?>&nbsp;&nbsp;<?php } ?>
                                                            ┣<?php echo ($v["name"]); ?>
                                                        </option>
                                                        <?php else: ?>
                                                        <option value="<?php echo ($v["id"]); ?>">
                                                            <?php $__FOR_START_8925__=3;$__FOR_END_8925__=$v["level"];for($i=$__FOR_START_8925__;$i < $__FOR_END_8925__;$i+=1){ ?>&nbsp;&nbsp;<?php } ?>
                                                            ┣<?php echo ($v["name"]); ?>
                                                        </option><?php endif; endif; endforeach; endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2">是否外部机构：</label>
                                    <div class="col-sm-3">
                                        <div class="radio single-row">
                                            <?php if($info["is_out"] == 1): ?><input type="radio" name="is_out" value="1" checked>
                                                <?php else: ?>
                                                <input type="radio" name="is_out" value="1"><?php endif; ?>
                                            <label>是</label>
                                        </div>
                                        <div class="radio single-row">
                                            <?php if($info["is_out"] != 1): ?><input type="radio" name="is_out" value="0" checked>
                                                <?php else: ?>
                                                <input type="radio" name="is_out" value="0"><?php endif; ?>
                                            <label>否</label>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2">排序：</label>
                                    <div class="col-sm-6">
                                        <?php if($info["sort"] != null): ?><input type="text" placeholder="请输入排序值" datatype="*" nullmsg="请输入排序值"
                                                   class="form-control form-input large" name="sort" id="sort"
                                                   value="<?php echo ($info["sort"]); ?>"/>
                                            <?php else: ?>
                                            <input type="text" placeholder="请输入排序值" datatype="*" nullmsg="请输入排序值"
                                                   class="form-control form-input large" name="sort" value="99"
                                                   maxlength="4" onkeyup='this.value=this.value.replace(/\D/gi,"")'/><?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">备注：</label>
                                    <div class="col-sm-9">
                                        <textarea placeholder="备注" class="form-control form-input" rows="5" style="resize: none"
                                                  name="remark" id="remark"></textarea>
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
    //图片预览
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
            action = "/index.php/Admin/Admin/department/action/add";
        } else {
            //存在，表示编辑
            action = "/index.php/Admin/Admin/department/action/edit";
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
                        window.location.href = "/index.php/Admin/Admin/department/action/page_list";
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