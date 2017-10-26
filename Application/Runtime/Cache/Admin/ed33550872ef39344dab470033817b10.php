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
    .navbar-default {
        background-color: #ffffff;
        border: 1px solid #e7e7e7;
    }

    .panel {
        border: 1px solid #dddddd;
    }
    .panel-heading {
        border-bottom: 0px solid #ddd;

    }
    .pagination { margin:0; }
    .dataTables_paginate { padding:0; }
</style>

<body class="sticky-header">

<section>

    <!-- main content start-->
    <div class="main-content" width="100%" style="margin:0px;">


        <form id="search" role="search" method="post" action="/index.php/Admin/Admin/log/action/page_list">
            <!--body wrapper start-->
            <div class="wrapper">
                
                <div class="row">
                    <div class="col-sm-12">
                        <section class="panel">
                            <header class="panel-heading panel-body">
                                <div class="pull-left">
                                    用户日志
                                </div>
                                <div class="collapse navbar-collapse pull-right">
                                    <div class=" navbar-right">
                                            <div class="pull-left ">
                                                <div class="input-group search-form">
                                                    <input type="text" class="form-control" name="keyword" id="keyword"
                                                           placeholder="查询用户名" value="<?php echo ($_POST['keyword']); ?>">
                                                </div>
                                            </div>
                                            <div class="pull-left ">
                                                <div class="input-group search-form">
                                                    <input type="text" class="form-control"   name="start1"  id="start"
                                                           placeholder="日期从" style="width: 180px;" value="<?php echo ($_POST['start1']); ?>">
                                                    <span class="input-group-addon">To</span>
                                                    <input type="text" class="form-control"  name="start2"  id="end"
                                                           placeholder="日期到" style="width: 180px;" value="<?php echo ($_POST['start2']); ?>">
                                                </div>
                                            </div>
                                            <div class="pull-left ">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default" onclick="search()">
                                                        <i class="fa fa-search"></i>查询</button>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </header>

                            <div class="">
                                <div class="adv-table">
                                    <table class="display table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th width="15%">用户名</th>
                                            <th width="15%">IP</th>
                                            <th width="25%">操作时间</th>
                                            <th width="55%">描述</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(is_array($list)): foreach($list as $k=>$vo): ?><tr role="row" align="center" style="background:#FFFFFF;">
                                                <td ><?php echo ($vo["user_name"]); ?></td>
                                                <td ><?php echo ($vo["log_ip"]); ?></td>
                                                <td width="25%"><?php echo ($vo["log_time"]); ?></td>
                                                <td width="55%" align="left"><?php echo ($vo["log_info"]); ?></td>
                                            </tr><?php endforeach; endif; ?>

                                        </tbody>
                                    </table>
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
                                                    <span class=" wenzi" style="float:left">条每页，总共 <?php echo ($count); ?> 条</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="span6">
                                            <div class="dataTables_paginate paging_bootstrap pagination">
                                                <ul>
                                                    <?php if($page_now == 1): ?><!-- 上一页 -->
                                                        <li class="prev disabled">
                                                            <a href="">
                                                                上一页
                                                            </a>
                                                        </li>
                                                        <?php else: ?>
                                                        <li class="prev">
                                                            <a href="/index.php/Admin/Admin/log/action/page_list/page_now/<?php echo ($page_now-1); ?>/page_num/<?php echo ($page_num); ?>">
                                                                上一页
                                                            </a>
                                                        </li><?php endif; ?>   <!-- 上一页 end -->
                                                    <?php if($page < 5): ?><!-- 页码条 -->
                                                        <?php $__FOR_START_28456__=1;$__FOR_END_28456__=$page+1;for($i=$__FOR_START_28456__;$i < $__FOR_END_28456__;$i+=1){ ?><!-- 循环四条以内 -->
                                                            <?php if($i == $page_now ): ?><li class="active">
                                                                    <a href=""><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php elseif($i < $page_now ): ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/Admin/log/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/Admin/log/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php elseif($page_now < 3): ?>
                                                        <?php $__FOR_START_13377__=1;$__FOR_END_13377__=6;for($i=$__FOR_START_13377__;$i < $__FOR_END_13377__;$i+=1){ ?><!-- 循环1-5 -->

                                                            <?php if($i == $page_now ): ?><li class="active"><a href=""><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page_now ): ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/Admin/log/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/Admin/log/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php elseif($page_now == $page-1): ?>
                                                        <?php $__FOR_START_15846__=$page_now-3;$__FOR_END_15846__=$page+1;for($i=$__FOR_START_15846__;$i < $__FOR_END_15846__;$i+=1){ ?><!-- 循环当前页为倒数第二页时 -->
                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page ): ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/Admin/log/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/Admin/log/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php elseif($page_now == $page): ?>
                                                        <?php $__FOR_START_7975__=$page_now-4;$__FOR_END_7975__=$page+1;for($i=$__FOR_START_7975__;$i < $__FOR_END_7975__;$i+=1){ ?><!-- 循环当前页为最后一页时 -->
                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page ): ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/Admin/log/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/Admin/log/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php else: ?>
                                                        <?php $__FOR_START_21972__=$page_now-2;$__FOR_END_21972__=$page_now+3;for($i=$__FOR_START_21972__;$i < $__FOR_END_21972__;$i+=1){ ?><!-- 循环除了前五条 和后五条 -->

                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page ): ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/Admin/log/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/Admin/log/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } endif; ?>   <!-- 页码条 end -->

                                                    <?php if(($page_now != $page) AND ($page != 0)): ?><!-- 下一页 -->
                                                        <li class="next ">
                                                            <a href="/index.php/Admin/Admin/log/action/page_list/page_now/<?php echo ($page_now+1); ?>/page_num/<?php echo ($page_num); ?>">
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
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <!--body wrapper end-->
        </form>


    </div>
    <!-- main content end-->
</section>

<!-- Placed js at the end of the document so the pages load faster -->
<script src="<?php echo (JS); ?>/jquery-1.10.2.min.js"></script>
<script src="<?php echo (JS); ?>/jquery-ui-1.9.2.custom.min.js"></script>
<script src="<?php echo (JS); ?>/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo (JS); ?>/bootstrap.min.js"></script>
<script src="<?php echo (JS); ?>/modernizr.min.js"></script>
<script src="<?php echo (JS); ?>/jquery.nicescroll.js"></script>

<script src="/Public/js/laydate/laydate.js"></script>
<script src="/Public/js/layer/layer-min.js"></script>
<script src="/Public/js/bootstrap.js" type="text/javascript"></script>



<!--common scripts for all pages-->
<script src="<?php echo (JS); ?>/scripts.js"></script>
<script type="text/javascript">
    var start = {
        elem: '#start',
        format: 'YYYY-MM-DD hh:mm:ss',
        max: '2099-06-16 23:59:59', //最大日期
        istime: true,
        istoday: false,
        choose: function(datas){
            end.min = datas; //开始日选好后，重置结束日的最小日期
            end.start = datas //将结束日的初始值设定为开始日
        }
    };
    var end = {
        elem: '#end',
        format: 'YYYY-MM-DD hh:mm:ss',
        min: laydate.now(),
        max: '2099-06-16 23:59:59',
        istime: true,
        istoday: false,
        choose: function(datas){
            start.max = datas; //结束日选好后，重置开始日的最大日期
        }
    };
    laydate(start);
    laydate(end);

    function search() {
        var keyword=$("#keyword").val();
        if(keyword==''){
            layer.msg("用户名不能为空");
            return false;
        }
        var start=$("#start").val();
        var end =$("#end").val();
            if(start==''&&end!=''){
                layer.msg("请选择开始日期");
                return false;
            }
            if(start!=''&&end==''){
                layer.msg("请选择结束日期");
                return false;
            }
        $('#search').submit();
    }
    $(document).ready(function () {
        //默认选中
        $("#page_num").val(<?php echo ($page_num); ?>);
    });
</script>
</body>
</html>