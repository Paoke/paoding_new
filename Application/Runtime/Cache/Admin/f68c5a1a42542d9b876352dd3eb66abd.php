<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="author" content="ThemeBucket">
    <meta name="keywords" content="<?php echo ($tpshop_config['shop_info_store_keyword']); ?>"/>
    <meta name="description" content="<?php echo ($tpshop_config['shop_info_store_desc']); ?>"/>

    <title><?php echo ($gemmapshop_config['shop_info_store_title']); ?></title>

    <link rel="shortcut icon" href="#" type="image/png">
    <!--dynamic table-->
    <link href="<?php echo (CSS); ?>/style.css" rel="stylesheet">
    <link href="<?php echo (CSS); ?>/style-responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->

</head>

<style type="text/css">
    .panel {
        border: 1px solid #e7e7e7;
    }

    .formadd {
        padding: 0px;
    }

    .pagination {
        margin: 0;
    }

    .dataTables_paginate {
        padding: 0;
    }
    .panel-heading {
    border-bottom: 0px solid #ddd;

}
    #vague_tbody{text-align: center}
    .page{float:right;margin-right: 21px;height: 10px;}
    .size{font-size: 10px;margin-left: -3px;}
</style>
<body class="sticky-header">

<section>

    <!-- main content start-->
    <div class="main-content" width="100%" style="margin:0px;">


        <!--body wrapper start-->
        <div class="wrapper">
            <!--  -->
            <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading panel-body">
                            <div class="pull-left">
                                数据列表
                            </div>
                            <form role="search" method="post" action="/index.php/Admin/Article/article/action/page_list/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>">
                                <div class="collapse navbar-collapse pull-right">
                                    <div class="btn-group">
                                        <a href="/index.php/Admin/Article/article/action/page_add/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>" tile="新增内容"
                                           class="btn btn-default "><i class="fa fa-plus"></i></a>
                                        <?php if(is_array($lead)): foreach($lead as $key=>$vo): if($vo[is_import_data] == 1): ?><a href="/index.php/Admin/ExportData/exportData/action/1/channel/<?php echo ($channel); ?>/page_num/<?php echo ($page_num); ?>/category_id/<?php echo ($category_id); ?>/page_now/<?php echo ($page_now); ?>" title="导出数据" class="btn btn-default "><i class="fa fa-cloud-download"></i></a><?php endif; ?>
                                            <?php if($vo[is_export_data] == 1): ?><a href="/index.php/Admin/ImportData/ImportData/action/1/channel/<?php echo ($channel); ?>/page_num/<?php echo ($page_num); ?>/category_id/<?php echo ($category_id); ?>/page_now/<?php echo ($page_now); ?>" title="导入数据" class="btn btn-default "><i class="fa fa-cloud-upload"></i></a><?php endif; endforeach; endif; ?>
                                        <a href="/index.php/Admin/Article/article/action/recycle_page_list/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>" title="回收站"
                                           class="btn btn-default "><i class="fa fa-trash-o"></i></a>
                                    </div>
                                </div>
                                <div class="pull-right" style="margin-right:5px;">
                                    <div class="btn-group" id="op_div">
                                        <a href="#myModal2" id="sort" data-toggle="modal" class="btn btn-default" onclick="loadCategory(0)"><i class="fa fa-search"></i>全部分类</a>
                                    </div>
                                </div>
                                <div class="pull-right">
                                    <div class="input-group search-form">
                                        <input type="text" class="form-control" id="keyword" name="keyword" placeholder="搜索名称" value="<?php echo ($_POST['keyword']); ?>">
                                           <span class="input-group-btn">
                                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                           </span>
                                    </div>
                                </div>
                            </form>
                        </header>


                        <div class="">
                            <div class="adv-table">
                                <table id="list-table" class="table table-bordered table-hover" role="grid"
                                       aria-describedby="example1_info">
                                    <thead>
                                    <tr role="row ">
                                        <?php if($info_field): ?><th valign="middle">ID</th>
                                            <?php if(is_array($info_field)): foreach($info_field as $key=>$vo1): ?><th id="filed" width="" valign="middle"><?php echo ($vo1["title"]); ?></th><?php endforeach; endif; ?>
                                            <th valign="middle">栏目类别</th>
                                            <th valign="middle">状态</th>
                                            <th width="9%">启用/停用</th>
                                            <th valign="middle" width="15%">操作</th><?php endif; ?>
                                    </tr>
                                    </thead>
                                    <tbody id="boby_tbody">
                                    <!--二维数组-->
                                    <?php if(is_array($info)): foreach($info as $vokey=>$vo): ?><tr role="row" align="center" id="<?php echo ($vo["id"]); ?>">
                                            <?php if(is_array($vo)): foreach($vo as $vokey1=>$vo1): if($vo1["type"] == 'image'): ?><td class="text-center">
                                                        <img width="40" height="40" src="<?php echo ($vo1["data"]); ?>" onclick="preview(this)"/>
                                                    </td>
                                                 <?php elseif($vokey1 == 'is_active'): ?>
                                                 <td>
                                                     <img width="20" height="20"
                                                          src="/Public/images/<?php if($vo1["data"] == 1): ?>yes.png<?php else: ?>cancel.png<?php endif; ?>"
                                                          onclick="changeTableVal('<?php echo ($mod_id); ?>','<?php echo ($tableName); ?>','id','<?php echo ($vo["id"]["data"]); ?>','is_active',this)"/>
                                                 </td>
                                                 <?php else: ?>
                                                    <td><?php echo ($vo1["data"]); ?></td><?php endif; endforeach; endif; ?>

                                            <td>
                                                <div class="btn-group">
                                                    <a class="btn btn-default"
                                                       href="/index.php/Admin/Article/article/action/page_edit/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>/id/<?php echo ($vo["id"]["data"]); ?>/page_now/<?php echo ($page_now); ?>/page_num/<?php echo ($page_num); ?>/category_id/<?php echo ($category_id); ?>/keyword/<?php echo ($keyword); ?>"
                                                       title="编辑"><i class="fa fa-pencil"></i></a>
                                                    <?php if($is_copy == 1): ?><a class="btn btn-default"
                                                           href="/index.php/Admin/Article/article/action/page_add/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>/id/<?php echo ($vo["id"]["data"]); ?>"
                                                           title="复制"><i class="fa fa-copy"></i></a><?php endif; ?>

                                                    <a href="#delModal" data-toggle="modal" class="btn btn-default"
                                                       data-name="<?php echo ($vo["title"]["data"]); ?>" title="删除"
                                                       status="<?php echo ($vo1["data"]); ?>"
                                                       data-url="/index.php/Admin/Article/article/action/del/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>/id/<?php echo ($vo["id"]["data"]); ?>/status/0"
                                                       onclick="delModal(this)" id=""><i class="fa fa-trash-o"></i></a>
                                                </div>
                                            </td>
                                        </tr><?php endforeach; endif; ?>
                                    </tbody>
                                </table>
                                <!-- Modal -->
                                <div class="modal fade" id="delModal" tabtype="-1" role="dialog" aria-labelledby="myModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                <h4 class="modal-title">信息</h4>
                                            </div>
                                            <div class="modal-body" id="del_info">

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        onclick="del_module();">
                                                    确定
                                                </button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal"> 取消</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- modal -->
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
                                                <span id="all_count" class=" wenzi" style="float:left">条每页，总共 <?php echo ($count); ?> 条</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="span6">
                                        <div class="dataTables_paginate paging_bootstrap pagination">
                                            <ul>
                                                <?php if($page_now == 1): ?><!-- 上一页 -->
                                                    <li class="prev disabled">
                                                        <a href="#">
                                                            上一页
                                                        </a>
                                                    </li>
                                                    <?php else: ?>
                                                    <li class="prev">
                                                        <a href="/index.php/Admin/Article/article/action/page_list/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>/page_now/<?php echo ($page_now-1); ?>/page_num/<?php echo ($page_num); ?>/category_id/<?php echo ($category_id); ?>/keyword/<?php echo ($keyword); ?>">
                                                            上一页
                                                        </a>
                                                    </li><?php endif; ?>   <!-- 上一页 end -->
                                                <?php if($page < 5): ?><!-- 页码条 -->
                                                    <?php $__FOR_START_23719__=1;$__FOR_END_23719__=$page+1;for($i=$__FOR_START_23719__;$i < $__FOR_END_23719__;$i+=1){ ?><!-- 循环四条以内 -->
                                                        <?php if($i == $page_now ): ?><li class="active"><a href=""><?php echo ($i); ?></a></li>
                                                            <?php elseif($i < $page_now ): ?>
                                                            <li>
                                                                <a href="/index.php/Admin/Article/article/action/page_list/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>/category_id/<?php echo ($category_id); ?>/keyword/<?php echo ($keyword); ?>"><?php echo ($i); ?></a>
                                                            </li>
                                                            <?php else: ?>
                                                            <li>
                                                                <a href="/index.php/Admin/Article/article/action/page_list/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>/category_id/<?php echo ($category_id); ?>/keyword/<?php echo ($keyword); ?>"><?php echo ($i); ?></a>
                                                            </li><?php endif; } ?>
                                                    <?php elseif($page_now < 3): ?>
                                                    <?php $__FOR_START_1364__=1;$__FOR_END_1364__=6;for($i=$__FOR_START_1364__;$i < $__FOR_END_1364__;$i+=1){ ?><!-- 循环1-5 -->

                                                        <?php if($i == $page_now ): ?><li class="active"><a href=""><?php echo ($page_now); ?></a></li>
                                                            <?php elseif($i < $page_now ): ?>
                                                            <li>
                                                                <a href="/index.php/Admin/Article/article/action/page_list/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>/category_id/<?php echo ($category_id); ?>/keyword/<?php echo ($keyword); ?>"><?php echo ($i); ?></a>
                                                            </li>
                                                            <?php else: ?>
                                                            <li>
                                                                <a href="/index.php/Admin/Article/article/action/page_list/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>/category_id/<?php echo ($category_id); ?>/keyword/<?php echo ($keyword); ?>"><?php echo ($i); ?></a>
                                                            </li><?php endif; } ?>
                                                    <?php elseif($page_now == $page-1): ?>
                                                    <?php $__FOR_START_3325__=$page_now-3;$__FOR_END_3325__=$page+1;for($i=$__FOR_START_3325__;$i < $__FOR_END_3325__;$i+=1){ ?><!-- 循环当前页为倒数第二页时 -->
                                                        <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                            <?php elseif($i < $page ): ?>
                                                            <li>
                                                                <a href="/index.php/Admin/Article/article/action/page_list/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>/category_id/<?php echo ($category_id); ?>/keyword/<?php echo ($keyword); ?>"><?php echo ($i); ?></a>
                                                            </li>
                                                            <?php else: ?>
                                                            <li>
                                                                <a href="/index.php/Admin/Article/article/action/page_list/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>/category_id/<?php echo ($category_id); ?>/keyword/<?php echo ($keyword); ?>"><?php echo ($i); ?></a>
                                                            </li><?php endif; } ?>
                                                    <?php elseif($page_now == $page): ?>
                                                    <?php $__FOR_START_19954__=$page_now-4;$__FOR_END_19954__=$page+1;for($i=$__FOR_START_19954__;$i < $__FOR_END_19954__;$i+=1){ ?><!-- 循环当前页为最后一页时 -->
                                                        <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                            <?php elseif($i < $page ): ?>
                                                            <li>
                                                                <a href="/index.php/Admin/Article/article/action/page_list/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>/category_id/<?php echo ($category_id); ?>/keyword/<?php echo ($keyword); ?>"><?php echo ($i); ?></a>
                                                            </li>
                                                            <?php else: ?>
                                                            <li>
                                                                <a href="/index.php/Admin/Article/article/action/page_list/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>/category_id/<?php echo ($category_id); ?>/keyword/<?php echo ($keyword); ?>"><?php echo ($i); ?></a>
                                                            </li><?php endif; } ?>
                                                    <?php else: ?>
                                                    <?php $__FOR_START_7235__=$page_now-2;$__FOR_END_7235__=$page_now+3;for($i=$__FOR_START_7235__;$i < $__FOR_END_7235__;$i+=1){ ?><!-- 循环除了前五条 和后五条 -->

                                                        <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                            <?php elseif($i < $page ): ?>
                                                            <li>
                                                                <a href="/index.php/Admin/Article/article/action/page_list/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>/category_id/<?php echo ($category_id); ?>/keyword/<?php echo ($keyword); ?>"><?php echo ($i); ?></a>
                                                            </li>
                                                            <?php else: ?>
                                                            <li>
                                                                <a href="/index.php/Admin/Article/article/action/page_list/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>/category_id/<?php echo ($category_id); ?>/keyword/<?php echo ($keyword); ?>"><?php echo ($i); ?></a>
                                                            </li><?php endif; } endif; ?>   <!-- 页码条 end -->

                                                <?php if(($page_now != $page) AND ($page != 0)): ?><!-- 下一页 -->
                                                    <li class="next ">
                                                        <a href="/index.php/Admin/Article/article/action/page_list/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>/page_now/<?php echo ($page_now+1); ?>/page_num/<?php echo ($page_num); ?>/category_id/<?php echo ($category_id); ?>/keyword/<?php echo ($keyword); ?>">
                                                            下一页
                                                        </a>
                                                    </li>
                                                    <?php else: ?>
                                                    <li class="next disabled">
                                                        <a href="#">
                                                            下一页
                                                        </a>
                                                    </li><?php endif; ?><!-- 下一页 end-->
                                            </ul>
                                        </div>
                                    </div>
                                    <form role="search" method="post">
                                    <div class="span6 page">
                                        <input type="num" name="gotPage" id="gotPage" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"  placeholder='输入页数,共<?php echo ($page); ?>页' value="<?php echo ($_POST['gotPage']); ?>">
                                        <span>
                                            <button type="submit"  class="btn btn-default size"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </section>

                    <!-- Modal -->
                    <section class="panel">
                        <div aria-hidden="true" aria-labelledby="myModalLabel"
                             role="dialog" tabindex="-1" id="myModal2" class="modal fade">
                            <div class="modal-dialog">
                                <div class="clearfix">

                                    <div class="modal-content">
                                        <div class="wrapper">

                                            <div class="col-sm-12">

                                                <form class="navbar-form form-inline" role="sch" method="post">
                                                    <input type="text" class="form-control" name="search_keyword" id="search_keyword"
                                                           placeholder="选择分类"  style="width: 50%;float: left; margin-right: 20px;" />
                                                </form>
                                                <div class="btn-group">
                                                    <button class="btn btn-primary" onclick="loadCategory();">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </div>

                                                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">取消</button>
                                                <button id="choosed_all" onclick="searchByTitle(-1)" type="button" class="btn btn-info pull-right" style="margin-left: 10px; margin-right: 10px">全部</button>

                                                <div class="panel-body">
                                                    <table class="table" style="font-size: 13px;margin-bottom: 0;">
                                                        <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>类别名称</th>
                                                            <th>排序数字</th>
                                                            <th>操作</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="vague_tbody" >
                                                        <!--<?php if(is_array($data)): foreach($data as $key=>$vo): ?>-->
                                                            <!--<tr>-->
                                                                <!--<td><?php echo ($vo["id"]); ?></td>-->
                                                                <!--<td><?php echo ($vo["cat_name"]); ?></td>-->
                                                                <!--<td><?php echo ($vo["sort_num"]); ?></td>-->
                                                                <!--<td><a class="btn btn-info btn-xs" onclick="searchByTitle()"> <i class="icon-edit icon-white"></i> 选中</a></td>-->
                                                            <!--</tr>-->
                                                        <!--<?php endforeach; endif; ?>-->
                                                        </tbody>
                                                    </table>
                                                </div>


                                                <div class="col-md-12 text-center clearfix">
                                                    <div class="dataTables_paginate paging_bootstrap pagination">
                                                        <input type="hidden" id="page_now" name="page_now" value="1">
                                                        <input type="hidden" id="page" name="page" value="">
                                                        <ul id="pagination">


                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
</section>

<script src="/Public/js/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo (JS); ?>/modernizr.min.js"></script>

<script src="<?php echo (JS); ?>/jquery-1.10.2.min.js"></script>
<script src="<?php echo (JS); ?>/jquery-1.9.1.min.js"></script>
<script src="<?php echo (JS); ?>/bootstrap.js" type="text/javascript"></script>
<!-- Placed js at the end of the document so the pages load faster -->
<script src="<?php echo (JS); ?>/jquery.nicescroll.js"></script>
<!--common scripts for all pages-->
<script src="<?php echo (JS); ?>/scripts.js"></script>


<script src="/Public/js/myAjax.js"></script>
<script src="/Public/js/myFormValidate.js"></script>
<script src="/Public/js/laydate/laydate.js"></script>
<script src="/Public/js/layer/layer-min.js"></script>

</body>
</html>

<script type="text/javascript">

    function allcontent(obj){
        var url = "/index.php/Admin/Article/category/action/list/channel/<?php echo ($channel); ?>/type/2";
        var page_now=parseInt($("#page_now").val());
        var page=$("#page").val();
        var data={"page_num":8,"page_now":page_now+obj };
        $("#op_div").empty();
        var s='<a href="#myModal2" id="sort" data-toggle="modal" class="btn btn-default" onclick="loadCategory(0)">全部分类<i class="fa fa-search"></i> </a>';
        $("#op_div").append(s);
        $.get(url,data,function(res){
            $("#vague_tbody").empty();
            var data = res.data;
            var arr =res.arr;
            $('#page_now').val(arr.page_now);
            $('#page').val(arr.page);

            for( var key in data){
                var value = data[key];

                var tr = '<tr><td>'+value.id+'</td><td>'+value.cat_name+'</td><td>'+value.sort_num+'</td><td><a class="btn btn-info btn-xs" onclick="searchByTitle('+value.id+')" > <i class="icon-edit icon-white"></i> 选中</a></td></tr>';

                $("#vague_tbody").append(tr);

                if(arr.page_now > 0 && arr.page > 0){
                    $("#pagination").empty();
                    if(arr.page_now == 1 && arr.page_now !=arr.page){
                        $("#pagination").append('<li class="disabled"><a>上一页</a></li><li><a onclick="allcontent(1)">下一页</a></li>');
                    }else if(arr.page_now != 1 && arr.page_now ==arr.page){
                        $("#pagination").append('<li><a onclick="allcontent(-1)">上一页</a></li><li class="disabled"><a>下一页</a></li>');
                    }else if(arr.page_now == 1 && arr.page_now ==arr.page){
                        $("#pagination").append('<li class="disabled"><a>上一页</a></li><li class="disabled"><a>下一页</a></li>');
                    }else{
                        $("#pagination").append('<li><a onclick="allcontent(-1)">上一页</a></li><li><a onclick="allcontent(1)">下一页</a></li>');
                    }
                }

            }
        },'json')
    }

    function searchByTitle(id) {
        $("#myModal2").hide();
        $('.modal-backdrop').removeClass('in').hide();
       window.location.href=" /index.php/Admin/Article/article/action/page_list/channel/<?php echo ($channel); ?>/type/1/category_id/"+id+"/keyword/<?php echo ($keyword); ?>";

    }
    $(function(){

        var str="<?php echo ($keyword); ?>";//定义变量

        var oText=document.getElementById('keyword');
        oText.value=str;//给文本框赋值并显示
    });

    function loadCategory(obj){
        $("#myModal2").show();
        $('.modal-backdrop').addClass('in').show();

        var url = "/index.php/Admin/Article/category/action/list/channel/<?php echo ($channel); ?>/type/2";
        var name=$("#search_keyword").val();
        var page_now=parseInt($("#page_now").val());
        var page=$("#page").val();
        var data={"cat_name":name,"page_num":8,"page_now":page_now+obj };
        $.get(url,data, function(ret){

            if(ret.result == 1){
                $("#vague_tbody").empty();

                var data = ret.data;
                var arr =ret.arr;
                $('#page_now').val(arr.page_now);
                $('#page').val(arr.page);

                for( var key in data){
                    var value = data[key];

                    var tr = '<tr>' +
                            '<td>'+value.id+'</td>' +
                            '<td>'+value.cat_name+'</td>' +
                            '<td>'+value.sort_num+'</td>' +
                            '<td><a class="btn btn-info btn-xs" onclick="searchByTitle('+value.id+')" >' +
                            ' <i class="icon-edit icon-white"></i> 选中</a></td></tr>';

                    $("#vague_tbody").append(tr);

                    if(arr.page_now > 0 && arr.page > 0){
                        $("#pagination").empty();
                        if(arr.page_now == 1 && arr.page_now !=arr.page){
                            $("#pagination").append('<li class="disabled"><a>上一页</a></li><li><a onclick="loadCategory(1)">下一页</a></li>');
                        }else if(arr.page_now != 1 && arr.page_now ==arr.page){
                            $("#pagination").append('<li><a onclick="loadCategory(-1)">上一页</a></li><li class="disabled"><a>下一页</a></li>');
                        }else if(arr.page_now == 1 && arr.page_now ==arr.page){
                            $("#pagination").append('<li class="disabled"><a>上一页</a></li><li class="disabled"><a>下一页</a></li>');
                        }else{
                            $("#pagination").append('<li><a onclick="loadCategory(-1)">上一页</a></li><li><a onclick="loadCategory(1)">下一页</a></li>');
                        }
                    }

                }

            }
        }, 'json');
    }

    var modal_url;
    var modal_name;
    var modal_object;
    //删除菜单
    function delModal(obj) {
        modal_object=$(obj);
        modal_url = $(obj).attr('data-url');
        modal_name = $(obj).attr('data-name');
        $("#del_info").html(" 是否确认删除【" + modal_name + "】?");

    }

    function del_module() {
        $.get(modal_url, function (res) {
            if (res.result == 1) {
                layer.msg(res.msg);
                modal_object.parent().parent().parent().remove();
            } else {
                layer.msg(res.msg);
            }

        });
    }

    //图片预览
    function preview(id) {
        var src = "";
        if ($('#' + id).val()) {
            src = $('#' + id).val();
        } else {
            src = $('#' + id).attr("src");
        }
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
    function search() {
        $('#search').submit();
    }
    $(document).ready(function () {
        //默认选中
        $("#page_num").val(<?php echo ($page_num); ?>);
        var categoryName = "<?php echo ($category_name); ?>";
        if(categoryName) {
            document.getElementById("sort").innerHTML = categoryName;
        }
    });

</script>