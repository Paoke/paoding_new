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
    <link rel="stylesheet" type="text/css" href="<?php echo (CSS); ?>/bootstrap.min.css" media="all"/>
    <link rel="stylesheet" type="text/css" href="<?php echo (CSS); ?>/bootstrap-reset.css" media="all"/>
    <link rel="stylesheet" href="/Public/js/cityselect/cityselect.css" />
    <script src="<?php echo (JS); ?>/cityselect/cityselect.js"></script>
    <script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="/Public/js/global.js"></script>
    <script src="/Public/js/myFormValidate.js"></script>
    <script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- <script src="/Public/js/layer/layer-min.js"></script> -->
    <script src="/Public/js/layer/layer.js"></script>
    <script src="/Public/js/myAjax.js"></script>
    <script src="/Public/js/echarts.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="/Public/js/html5shiv.js"></script>
    <script src="/Public/js/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">

        .panel-body {
            padding: 15px;
            margin-top: -1px;
        }

        .edit_list {
            background: #fff;
            border-bottom: 1px solid #d5d5d5;
            overflow: hidden;
            padding: 0px 30px 10px 30px;
            line-height: 34px;
            width: 100%;
            color: #C8C8C8;
        }

        * {
            margin: 0;
            padding: 0;
            list-style-type: none;
        }

        .bn-headnav li {
            display: inline;
            float: left;;
            font-size: 14px;
            font-family: 微软雅黑;
            cursor: pointer;
            width: 100px;
            text-align: center;
            line-height: 35px;
            border: 1px solid #d5d5d5;
        }

        .bn-headnav li.curr {
            color: #65CEA7;
            line-height: 35px;
            border: 1px solid #65CEA7;
        }

        .bn-headnav li.curr a {
            color: #65CEA7;
            text-decoration: none;
        }

        a {
            text-decoration: none;
            color: #969696;
            font-family: Microsoft YaHei, Tahoma, Arial, sans-serif;
        }

        .img_box img {
            height: 200px;
            width: 400px;
        }
        .warn_msg{
            padding-left: 20px;
            color: red;
        }

        .alian{ width: 100%; float: left; }
        .bllan{width: 24%;float: left; margin-right: 10px;}
        .state-overview .panel {
            padding: 10px 20px;
        }
        h4, .h4 {
            font-size: 18px;
            color: #0c0c0c;
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

        .main-content{    overflow: auto;  min-height: 100%;}
    </style>
</head>

<body class="sticky-header">
<section style="height:100%">

    <div class="page-heading panel-title">

        <h3 id="title">
            <?php if(empty($info)): ?>审核列表
                <?php else: echo ($info["title"]); endif; ?>
        </h3>
    </div>

    <div class="main-content" width="100%" style="margin:0px;height:100%;">
        <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <div class="panel-body">
                            <form class="form-horizontal " id="content_form" onkeydown="if(event.keyCode==13){return false;}">
                                <div class="col-md-12 ">
                                    <div class="form-group">
                                        <ul id="module" class="nav nav-tabs">
                                            <li class="active" tab_index="1"><a href="#audit" data-toggle="tab">待审核</a></li>
                                            <li class="" tab_index="2"><a href="#yes" data-toggle="tab">已通过</a></li>
                                            <li class="" tab_index="3"><a href="#no" data-toggle="tab">不通过</a></li>
                                            <li class="" tab_index="4"><a href="#all" data-toggle="tab">全部</a></li>
                                            <li class="" tab_index="5"><a href="#record" data-toggle="tab">审核记录</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-content" >

                                    <div id="audit" class="tab-pane active">
                                        <div class="adv-table">
                                            <table class="table table-bordered table-hover" role="grid" aria-describedby="example1_info">
                                                <thead>
                                                <tr role="row">
                                                    <th width="50" style="text-align:center;">审核内容</th>
                                                    <th width="38" style="text-align:center;">审核状态</th>
                                                    <th width="12%" style="text-align:center;">操作</th>
                                                </tr>
                                                </thead>
                                                <tbody id="audit_tbody">

                                                </tbody>
                                            </table>
                                            <!-- Modal -->

                                            <div class="row-fluid panel-body">
                                                <div class="span6">
                                                    <div class="dataTables_info" id="dynamic-table_info2">
                                                        <label style="float:left">
                                                            <select class="form-control" size="1" id="page_num2" name="page_num"
                                                                    aria-controls="dynamic-table" onchange="search()">
                                                                <option value="25">25</option>
                                                                <option value="50">50</option>
                                                                <option value="100">100</option>
                                                            </select>
                                                        </label>
                                                        <label style="float:left;margin-left:10px;margin-top:7px">
                                                            <span id="aud_count" class=" wenzi" style="float:left">条每页，总共 0 条</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="span6">
                                                    <div class="dataTables_paginate paging_bootstrap pagination">
                                                        <input type="hidden" id="page_now_into" name="page_now" value="1">
                                                        <input type="hidden" id="page_into" name="page" value="">
                                                        <ul id="auditpage">

                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div id="yes" class="tab-pane">
                                        <div class="adv-table">
                                            <table class="table table-bordered table-hover" role="grid" aria-describedby="example1_info">
                                                <thead>
                                                <tr role="row">
                                                    <th width="50" style="text-align:center;">审核内容</th>
                                                    <th width="38" style="text-align:center;">审核状态</th>
                                                    <th width="12%" style="text-align:center;">操作</th>
                                                </tr>
                                                </thead>
                                                <tbody id="yes_tbody">

                                                </tbody>
                                            </table>
                                            <!-- Modal -->

                                            <div class="row-fluid panel-body">
                                                <div class="span6">
                                                    <div class="dataTables_info" id="dynamic-table_info3">
                                                        <label style="float:left">
                                                            <select class="form-control" size="1" id="page_num3" name="page_num"
                                                                    aria-controls="dynamic-table" onchange="search()">
                                                                <option value="25">25</option>
                                                                <option value="50">50</option>
                                                                <option value="100">100</option>
                                                            </select>
                                                        </label>
                                                        <label style="float:left;margin-left:10px;margin-top:7px">
                                                            <span id="yes_count" class=" wenzi" style="float:left">条每页，总共 0 条</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="span6">
                                                    <div class="dataTables_paginate paging_bootstrap pagination">
                                                        <input type="hidden" id="page_now_info" name="page_now_info" value="1">
                                                        <input type="hidden" id="page_info" name="page_info" value="">
                                                        <ul id="notgo">

                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div id="no" class="tab-pane">
                                        <div class="adv-table">
                                            <table class="table table-bordered table-hover" role="grid" aria-describedby="example1_info">
                                                <thead>
                                                <tr role="row">
                                                    <th width="50" style="text-align:center;">审核内容</th>
                                                    <th width="38" style="text-align:center;">审核状态</th>
                                                    <th width="12%" style="text-align:center;">操作</th>
                                                </tr>
                                                </thead>
                                                <tbody id="release_tbody">

                                                </tbody>
                                            </table>
                                            <!-- Modal -->
                                            <!-- modal -->
                                            <div class="row-fluid panel-body">
                                                <div class="span6">
                                                    <div class="dataTables_info" id="dynamic-table_info1">
                                                        <label style="float:left">
                                                            <select class="form-control" size="1" id="page_num1" name="page_num"
                                                                    aria-controls="dynamic-table" onchange="search()">
                                                                <option value="25">25</option>
                                                                <option value="50">50</option>
                                                                <option value="100">100</option>
                                                            </select>
                                                        </label>
                                                        <label style="float:left;margin-left:10px;margin-top:7px">
                                                            <span id="no_count" class=" wenzi" style="float:left">条每页，总共 0 条</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="span6">
                                                    <div class="dataTables_paginate paging_bootstrap pagination">
                                                        <input type="hidden" id="page_now_issue" name="page_now_issue" value="1">
                                                        <input type="hidden" id="page_issue" name="page_issue" value="">
                                                        <ul id="issuepage">
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div id="all" class="tab-pane">
                                        <div class="adv-table" >
                                            <table  class="table table-bordered table-hover" role="grid" aria-describedby="example1_info">
                                                <thead>
                                                <tr role="row">
                                                    <th width="50" style="text-align:center;">审核内容</th>
                                                    <th width="38" style="text-align:center;">审核状态</th>
                                                    <th width="12%" style="text-align:center;">操作</th>
                                                </tr>
                                                </thead>
                                                <tbody id="wa_tbody">

                                                </tbody>
                                            </table>
                                            <!-- Modal -->
                                            <div class="row-fluid panel-body">
                                                <div class="span6">
                                                    <div class="dataTables_info" id="dynamic-table_info">
                                                        <label style="float:left">
                                                            <select class="form-control" size="1" id="page_num" name="page_num"
                                                                    aria-controls="dynamic-table" onchange="search()">
                                                                <option value="25">25</option>
                                                                <option value="50">50</option>
                                                                <option value="100">100</option>
                                                            </select>
                                                        </label>
                                                        <label style="float:left;margin-left:10px;margin-top:7px">
                                                            <span id="all_count" class=" wenzi" style="float:left">条每页，总共 0 条</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="span6">
                                                    <div class="dataTables_paginate paging_bootstrap pagination">
                                                        <input type="hidden" id="page_now" name="page_now" value="1">
                                                        <input type="hidden" id="page" name="page" value="">
                                                        <ul id="pageinfo">

                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <div id="record" class="tab-pane">
                                        <div class="adv-table">
                                            <table id="list-table" class="table table-bordered table-hover" role="grid" aria-describedby="example1_info">
                                                <thead>
                                                <tr role="row">
                                                    <th width="" style="text-align:center;">审核结果</th>
                                                    <th width="" style="text-align:center;">审核时间</th>
                                                    <th width="" style="text-align:center;">审核人用户名</th>
                                                </tr>
                                                </thead>
                                                <tbody id="record_tbody">
                                                </tbody>
                                            </table>

                                            <div class="row-fluid panel-body">
                                                <div class="span6">
                                                    <div class="dataTables_info" id="dynamic-table_info_record">
                                                        <label style="float:left">
                                                            <select class="form-control" size="1" id="page_num_record" name="page_num" aria-controls="dynamic-table" onchange="search()">
                                                                <option value="25">25</option>
                                                                <option value="50">50</option>
                                                                <option value="100">100</option>
                                                            </select>
                                                        </label>
                                                        <label style="float:left;margin-left:10px;margin-top:7px">
                                                            <span class=" wenzi" style="float:left">条每页，总共 0 条</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="span6">
                                                    <div class="dataTables_paginate paging_bootstrap pagination">
                                                        <input type="hidden" id="page_now_record" name="page_now_record" value="1">
                                                        <input type="hidden" id="page_record" name="page_record" value="">
                                                        <ul id="recordpage">
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </section>
                </div>
            </div>
        </section><!--表单数据-->

    </div>
    <!-- main content end-->
</section>

<!-- Placed js at the end of the document so the pages load faster -->
<!--<script src="<?php echo (JS); ?>/jquery-1.10.2.min.js"></script>-->
<script src="<?php echo (JS); ?>/jquery-ui-1.9.2.custom.min.js"></script>
<script src="<?php echo (JS); ?>/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo (JS); ?>/bootstrap.min.js"></script>
<script src="<?php echo (JS); ?>/modernizr.min.js"></script>
<script src="<?php echo (JS); ?>/jquery.nicescroll.js"></script>
<!-- <script src="/Public/js/layer/layer-min.js"></script> -->
<script src="/Public/js/layer/layer.js"></script>
<!--common scripts for all pages-->
<script src="<?php echo (JS); ?>/scripts.js"></script>

<script src="<?php echo (JS); ?>/extends.js"></script>

<!-- ueditor end-->
<script type="text/javascript">
    $(function(){
        get_audit(0);
    });


    function changeStatus(mod, id, status){
        var url = "/index.php/Admin/Article/examine/action/update_status/channel/<?php echo ($channel); ?>/type/1";
        var data = {'id': id, 'status': status};

        $.post(url, data, function(ret){
            if(ret.result == 1){

                if(mod == 'all'){
                    var status_text = "通过";
                    var op_link = '<a class="btn btn-default" href="javascript:;" onclick="changeStatus(\''+mod+'\', '+id+', -1)" title="不通过"><i class="fa fa-times"></i></a>';
                    if(status == -1){
                        status_text = "不通过";
                        op_link = '<a class="btn btn-default" href="javascript:;" onclick="changeStatus(\''+mod+'\', '+id+', 0)" title="通过"><i class="fa fa-check"></i></a>';
                    }

                    $("#"+mod+"_"+id).text(status_text);
                    $("#op_"+id).empty().append(op_link);
                }else{
                    $("#"+mod+"_"+id).parent().remove();
                }

                layer.msg('审核成功!');
            }else{
                layer.msg('审核失败，更新数据失败!');
            }
        });

    }

    //全部
    function get_all(obj){
        var url = "/index.php/Admin/Article/examine/action/list/channel/<?php echo ($channel); ?>/type/10";
        var page_now= parseInt ($("#page_now").val());
        var page_num=$("#page_num").val();
        var page=$("#page").val();
        var data= {"page_num":page_num,"page_now":page_now+obj};
        $.post(url,data,function(ret){
            if(ret.result == 1){
                //alert(JSON.stringify(ret));
                $("#wa_tbody").empty();
                var data = ret.data.data;
                var arr = ret.data.arr;
                $('#page_now').val(arr.page_now);
                $('#page').val(arr.page);
                var mod = "all";
                for (var key in data) {
                    var value = data[key];
                    var  str = '<tr role="row" align="center" > ' ;
                    str +=  '<td>'+value.title+'</td> ';
                    if(value.status==1){
                        str +=   '<td id="'+value.id+'">待审核</td>';
                    }else if(value.status==0){
                        str +='<td id="'+mod+'_'+value.id+'">通过</td>';
                    }else {
                        str+='<td id="'+mod+'_'+value.id+'">不通过</td>';
                    }
                    str+='<td> <div id="op_'+value.id+'" class="btn-group"> ';
                    if(value.status == 1){
                        str+='<a class="btn btn-default" href="javascript:;" onclick="changeStatus(\''+mod+'\','+value.id+', 0)" title="通过"><i class="fa fa-check"></i></a>' +
                                '<a class="btn btn-default" href="javascript:;" onclick="changeStatus(\''+mod+'\','+value.id+', -1)" title="不通过"><i class="fa fa-times"></i></a> ';
                    }else if(value.status == 0){
                        str+='<a class="btn btn-default" href="javascript:;" onclick="changeStatus(\''+mod+'\', '+value.id+', -1)" title="不通过"><i class="fa fa-times"></i></a>';
                    }else if(value.status == -1){
                        str+='<a class="btn btn-default" href="javascript:;" onclick="changeStatus(\''+mod+'\','+value.id+', 0)" title="通过"><i class="fa fa-check"></i></a>';
                    }
                    str+=' </div></td></tr>';


                    $("#wa_tbody").append(str);

                    if(arr.page_now > 0 && arr.page > 0){
                        $("#pageinfo").empty();
                        if(arr.page_now == 1 && arr.page_now !=arr.page){
                            $("#pageinfo").append('<li class="disabled"><a>上一页</a></li><li><a onclick="get_all(1);">下一页</a></li>');
                        }else if(arr.page_now != 1 && arr.page_now ==arr.page){
                            $("#pageinfo").append('<li><a onclick="get_all(-1);">上一页</a></li><li class="disabled"><a>下一页</a></li>');
                        }else if(arr.page_now == 1 && arr.page_now ==arr.page){
                            $("#pageinfo").append('<li class="disabled"><a>上一页</a></li><li class="disabled"><a>下一页</a></li>');
                        }else{
                            $("#pageinfo").append('<li><a onclick="get_all(-1);">上一页</a></li><li><a onclick="get_all(1);">下一页</a></li>');
                        }


                        $("#all_count").text('条每页，总共 '+arr.count+' 条');

                    }
                }
            }
        },'json');
    }
    //待审核
    function get_audit(obj){
        var url="/index.php/Admin/Article/examine/action/audit/channel/<?php echo ($channel); ?>/type/10";
        var page_now = parseInt ($("#page_now_into").val());
        var page=$("#page_into").val();
        var data= {"page_num":8,"page_now":page_now+obj};

        $.post(url,data,function(ret){
            if(ret.result==1){
                $("#audit_tbody").empty();
                var data = ret.data.data;
                var arr = ret.data.arr;
                $('#page_now_into').val(arr.page_now);
                $('#page_into').val(arr.page);
                var mod = "aud";
                for (var key in data) {
                    var value = data[key];
                    var str = '<tr role="row" align="center" > ' ;
                    str +=   '<td>' + value.title + '</td> ';
                    if (value.status==1){
                        str+='<td id="'+mod+'_'+value.id+'">待审核</td>';
                    }else {
                        str+='<td id="'+mod+'_'+value.id+'">不通过</td>';
                    }
                    str+='<td> <div class="btn-group">';
                    if(value.status==1){
                        str+='<a class="btn btn-default" onclick="changeStatus(\''+mod+'\','+value.id+', 0)" href="javascript:;" title="通过"><i class="fa fa-check"></i></a>' +
                                '<a class="btn btn-default" onclick="changeStatus(\''+mod+'\','+value.id+', -1)" href="javascript:;" title="不通过"><i class="fa fa-times"></i></a>';
                    }else {
                        str+='<a class="btn btn-default" href="javascript:;" onclick="changeStatus(\''+mod+'\','+value.id+', -1)" title="不通过"><i class="fa fa-times"></i></a>';
                    }
                    str+=' </div></td></tr>';

                    $("#audit_tbody").append(str);

                    if(arr.page_now > 0 && arr.page > 0){
                        $("#auditpage").empty();
                        if(arr.page_now == 1 && arr.page_now !=arr.page){
                            $("#auditpage").append('<li class="disabled"><a>上一页</a></li><li><a onclick="get_audit(1);">下一页</a></li>');
                        }else if(arr.page_now != 1 && arr.page_now ==arr.page){
                            $("#auditpage").append('<li><a onclick="get_audit(-1);">上一页</a></li><li class="disabled"><a>下一页</a></li>');
                        }else if(arr.page_now == 1 && arr.page_now ==arr.page){
                            $("#auditpage").append('<li class="disabled"><a>上一页</a></li><li class="disabled"><a>下一页</a></li>');
                        }else{
                            $("#auditpage").append('<li><a onclick="get_audit(-1);">上一页</a></li><li><a onclick="get_audit(1);">下一页</a></li>');
                        }

                        $("#aud_count").text('条每页，总共 '+arr.count+' 条');
                    }

                }
            }


        },'json');
    }
    //已通过
    function get_yes(obj){

        var url="/index.php/Admin/Article/examine/action/info/channel/<?php echo ($channel); ?>/type/10";
        var page_now=parseInt($("#page_now_info").val());
        var page=$("#page_info").val();
        var data={"page_num":8,"page_now":page_now+obj}
        $.post(url,data,function(ret){
            if(ret.result==1){
                $("#yes_tbody").empty();
                var data = ret.data.data;
                var arr = ret.data.arr;
                $('#page_now_info').val(arr.page_now);
                $('#page_info').val(arr.page);
                var mod = "yes";
                for (var key in data) {
                    var value = data[key];
                    var str = '<tr role="row" align="center" > ' ;
                    str +=   '<td>' + value.title + '</td> ';
                    if (value.status==0){
                        str+='<td id="'+mod+'_'+value.id+'">通过</td>';
                    }else {
                        str+='<td id="'+mod+'_'+value.id+'">不通过</td>';
                    }
                    str+='<td> <div class="btn-group">';
                    if(value.status==1){
                        str+='<a class="btn btn-default" onclick="changeStatus(\''+mod+'\','+value.id+', 0)" href="javascript:;" title="通过"><i class="fa fa-check"></i></a>' +
                                '<a class="btn btn-default" href="javascript:;" onclick="changeStatus(\''+mod+'\','+value.id+', -1)" title="不通过"><i class="fa fa-times"></i></a>';
                    }else {
                        str+='<a class="btn btn-default" onclick="changeStatus(\''+mod+'\','+value.id+', -1)" href="javascript:;" title="不通过"><i class="fa fa-times"></i></a>';
                    }
                    str+=' </div></td></tr>';

                    $("#yes_tbody").append(str);

                    if(arr.page_now > 0 && arr.page > 0){
                        $("#notgo").empty();
                        if(arr.page_now == 1 && arr.page_now !=arr.page){
                            $("#notgo").append('<li class="disabled"><a>上一页</a></li><li><a onclick="get_yes(1);">下一页</a></li>');
                        }else if(arr.page_now != 1 && arr.page_now ==arr.page){
                            $("#notgo").append('<li><a onclick="get_yes(-1);">上一页</a></li><li class="disabled"><a>下一页</a></li>');
                        }else if(arr.page_now == 1 && arr.page_now ==arr.page){
                            $("#notgo").append('<li class="disabled"><a>上一页</a></li><li class="disabled"><a>下一页</a></li>');
                        }else{
                            $("#notgo").append('<li><a onclick="get_yes(-1);">上一页</a></li><li><a onclick="get_yes(1);">下一页</a></li>');
                        }

                        $("#yes_count").text('条每页，总共 '+arr.count+' 条');
                    }
                }
            }
        },'json');
    }
    //不通过
    function get_no(obj){
        var url="/index.php/Admin/Article/examine/action/issue/channel/<?php echo ($channel); ?>/type/10";
        var page_now=parseInt($("#page_now_issue").val());
        var page=$("#page_issue").val();
        var data={"page_num":8,"page_now":page_now+obj}
        $.post(url,data,function(att){

            if(att.result==1){
                //alert(JSON.stringify(att));
                $("#release_tbody").empty();
                var data = att.data.data;
                var arr = att.data.arr;
                $('#page_now_issue').val(arr.page_now);
                $('#page_issue').val(arr.page);
                var mod = "no";
                for (var key in data) {
                    var value = data[key];
                    var str = '<tr role="row" align="center" > ' ;
                    str +=   '<td>' + value.title + '</td> ';
                    if (value.status==-1){
                        str+='<td id="'+mod+'_'+value.id+'">不通过</td>';
                    }
                    str+='<td> <div class="btn-group">';
                    if(value.status==1){
                        str+='<a class="btn btn-default" onclick="changeStatus(\''+mod+'\','+value.id+', 0)" href="javascript:;" title="通过"><i class="fa fa-check"></i></a>' +
                                '<a class="btn btn-default" href="javascript:;" onclick="changeStatus(\''+mod+'\','+value.id+', -1)" title="不通过"><i class="fa fa-times"></i></a> ';
                    }else {
                        str+='<a class="btn btn-default" onclick="changeStatus(\''+mod+'\','+value.id+ ', -1)" href="javascript:;" title="不通过"><i class="fa fa-check"></i></a>';
                    }
                    str+=' </div></td></tr>';

                    $("#release_tbody").append(str);

                    if(arr.page_now > 0 && arr.page > 0){
                        $("#issuepage").empty();
                        if(arr.page_now == 1 && arr.page_now !=arr.page){
                            $("#issuepage").append('<li class="disabled"><a>上一页</a></li><li><a onclick="get_no(1);">下一页</a></li>');
                        }else if(arr.page_now != 1 && arr.page_now ==arr.page){
                            $("#issuepage").append('<li><a onclick="get_no(-1);">上一页</a></li><li class="disabled"><a>下一页</a></li>');
                        }else if(arr.page_now == 1 && arr.page_now ==arr.page){
                            $("#issuepage").append('<li class="disabled"><a>上一页</a></li><li class="disabled"><a>下一页</a></li>');
                        }else{
                            $("#issuepage").append('<li><a onclick="get_no(-1);">上一页</a></li><li><a onclick="get_no(1);">下一页</a></li>');
                        }

                        $("#no_count").text('条每页，总共 '+arr.count+' 条');
                    }
                }
            }
        },'json');
    }

    function get_record(obj){
        var url="/index.php/Admin/Article/examine/action/record/channel/<?php echo ($channel); ?>/type/10";
        var page_now=parseInt($("#page_now_record").val());
        var page=$("#page_record").val();
        var data={"page_num":25,"page_now":page_now+obj};
        $.post(url,data,function(ret){
            if(ret.result==1){
                //alert(JSON.stringify(att));
                $("#record_tbody").empty();
                var data = ret.data;
                var arr = ret.arr;
                $('#page_now_record').val(arr.page_now);
                $('#page_record').val(arr.page);

                for (var key in data) {
                    var value = data[key];
                    var str = '<tr role="row" align="center" > ' ;

                    str +=   '<td>' + value.log_info + '</td> ';
                    str+='<td>'+value.log_time+'</td>';
                    str+='<td>'+value.admin_user_name+'</td> ';
                    str+='</tr>';

                    $("#record_tbody").append(str);

                    if(arr.page_now > 0 && arr.page > 0){
                        $("#recordpage").empty();
                        if(arr.page_now == 1 && arr.page_now !=arr.page){
                            $("#recordpage").append('<li class="disabled"><a>上一页</a></li><li><a onclick="get_record(1);">下一页</a></li>');
                        }else if(arr.page_now != 1 && arr.page_now ==arr.page){
                            $("#recordpage").append('<li><a onclick="get_record(-1);">上一页</a></li><li class="disabled"><a>下一页</a></li>');
                        }else if(arr.page_now == 1 && arr.page_now ==arr.page){
                            $("#recordpage").append('<li class="disabled"><a>上一页</a></li><li class="disabled"><a>下一页</a></li>');
                        }else{
                            $("#recordpage").append('<li><a onclick="get_record(-1);">上一页</a></li><li><a onclick="get_record(1);">下一页</a></li>');
                        }
                    }
                }
            }
        },'json');
    }


    $(".nav-tabs li").click(function(){
        var index = parseInt($(this).attr('tab_index'));
        switch (index){
            case 1:
                get_audit(0);
                break;
            case 2:
                get_yes(0);
                break;
            case 3:
                get_no(0);
                break;
            case 4:
                get_all(0);
                break;
            case 5:
                get_record(0);
                break;


        }
    });

</script>
</body>
</html>