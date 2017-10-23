<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

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
    <script src="/Public/js/vue.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<style type="text/css">
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

</style>

<body class="sticky-header">
<section>
    <div class="main-content" width="100%" id="data_list" style="margin:0px;">
        <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel">
                        <header class="panel-heading">
                            编辑导出数据字段
                            <div class="pull-right">
                                        <div class="btn-group">
                                            <button type="button" id="postbutton" class="btn btn-default "
                                                    onclick="ajax_submit_form('form_id_name')">提交
                                            </button>
                                            <a href="javascript:history.go(-1)" data-toggle="tooltip" title=""
                                               class="btn btn-default" data-original-title="返回频道列表">返回</a>
                                        </div>
                                    </div>

                        </header>
                        <!-- /.box-header -->
                        <div class="panel-body">
                            <form class="form-horizontal adminex-form" method="post" id="form_id_name">
                                <div class="form-group">
                                    <div class="col-sm-2 control-label" style="width:16%; height:auto;float:left;">
                                        内容字段选择：
                                    </div>
                                    <div style="width:64%; height:auto;float:left;">
                                        <label class=" control-label" style="" v-for="item in contentItems" >
                                            <input name="fields[]" type="checkbox"  v-bind:true-value="1" v-bind:false-value="0" v-model="item.is_checked" v-bind:value="item.field_name" />
                                            &nbsp<label v-text="item.field_title"></label>&nbsp&nbsp&nbsp
                                        </label>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <div class="col-sm-2 control-label" style="width:16%; height:auto;float:left;">
                                        栏目字段选择：
                                    </div>
                                    <div style="width:64%; height:auto;float:left;">
                                        <label class=" control-label" style="" v-for="item in categoryItems" >
                                            <input name="fields[]" type="checkbox"  v-bind:true-value="1" v-bind:false-value="0" v-model="item.is_checked" v-bind:value="item.field_name" />
                                            &nbsp<label v-text="item.field_title"></label>&nbsp&nbsp&nbsp
                                        </label>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <div class="col-sm-2 control-label" style="width:16%; height:auto;float:left;">
                                        标签字段选择：
                                    </div>
                                    <div style="width:64%; height:auto;float:left;">
                                        <label class=" control-label" style="" v-for="item in tagItems" >
                                            <input name="fields[]" type="checkbox"  v-bind:true-value="1" v-bind:false-value="0" v-model="item.is_checked" v-bind:value="item.field_name" />
                                            &nbsp<label v-text="item.field_title"></label>&nbsp&nbsp&nbsp
                                        </label>
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
        action = "/index.php/Admin/ExportData/exportField/action/edit/channel/<?php echo ($channel); ?>";
        //异步提交表单数据
        $.ajax({
            type: "post",
            url: action,
            data: $('#' + form_id).serialize(),
            dataType: 'json',
            success: function (res) {
                layer.msg(res.msg);
                if (res.result == 1) {
//                    setTimeout(function () {
//                        window.location.href = "/index.php/Admin/System/channel/action/page_list";
//                    }, 1000);
                }
            }
        })
    }

    var vm = new Vue({
        el:'#data_list',
        data:{
            contentItems : '',
            categoryItems : '',
            tagItems : ''
        },
        mounted: function () {
            this.$nextTick(function () {
                // 代码保证 this.$el 在 document 中
                this.getData();
            })
        },
        filters: {
        },
        methods:{
            getData:function () {
                var _this = this;
                var url = "/index.php/Admin/ExportData/exportField/action/page_edit/channel/<?php echo ($channel); ?>";
                $.get(url, function (res) {
                    var dataAll = res.data;
                    _this.contentItems = dataAll[1];
                    _this.categoryItems =dataAll[2];
                    _this.tagItems = dataAll[4];
                })
            }
        }
    });

</script>
</body>
</html>