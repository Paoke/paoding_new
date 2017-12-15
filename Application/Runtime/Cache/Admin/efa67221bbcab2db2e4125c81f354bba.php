<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="#" type="image/png">

    <title><?php echo ($gemmap_config['shop_info_store_title']); ?></title>
    <meta name="keywords" content="<?php echo ($gemmap_config['shop_info_store_keyword']); ?>"/>
    <meta name="description" content="<?php echo ($gemmap_config['shop_info_store_desc']); ?>"/>
    <link href="<?php echo (CSS); ?>/style.css" rel="stylesheet">
    <link href="<?php echo (CSS); ?>/style-responsive.css" rel="stylesheet">

    <!-- jQuery 2.1.4 -->
    <script src="/Public/js/global.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<style type="text/css">
    .navbar-default {
        background-color: #fff;
        border-bottom: 1px solid #e7e7e7;
    }

    .panel {
        border: 1px solid #ddd;
    }

    .panel-border {
        padding: 10px;
        border: 1px solid #e6e8eb;
        margin-top: -1px;
    }

    .option {
        height: 26px;
    }

    .modal-dialog {
        width: 450px;
        height: 75%;
        overflow-y: auto;
        margin: 5% auto;
    }

    input[type=date] {
        line-height: 15px;
    }

    /*.borderno{border-top:none;border-bottom:none;}*/
    .panel-body .form-group select {
        margin-right: 10px;
    }

    .form-group a {
        margin-left: 10px;
    }

    .panel-body .form-group:last-of-type select {
        margin-right: 7px;
    }

    .navbar-default {
        background-color: #fff;
        border-bottom: 1px solid #e7e7e7;
    }

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
</style>

<body class="sticky-header" >

<section>
    <!-- main content start-->
    <div class="main-content" width="100%" style="margin:0px;">
        <form action="/index.php/Admin/User/user/action/page_list" id="search" role="search" method="post">
            <!--body wrapper start-->
            <div class="wrapper">
                <!--  -->
                <div class="row">
                    <div class="col-sm-12">
                        <section class="panel">
                            <header class="panel-heading panel-body">
                                <div class="pull-left">
                                    会员管理
                                </div>
                                <div class="collapse navbar-collapse pull-right">
                                    <div class=" navbar-right">
                                        <a href="/index.php/Admin/User/user/action/page_edit" class="btn btn-default"><i
                                                class="fa fa-plus"></i>新增用户</a>
                                    </div>
                                </div>
                                <div class="collapse navbar-collapse pull-right">
                                    <div class="input-group search-form">
                                        <input type="text" class="form-control" name="keyword" placeholder="用户名/昵称/手机/邮箱查询" value="<?php echo ($_POST['keyword']); ?>">
                                                    <span class="input-group-btn">
                                                <button type="submit" class="btn btn-default btn_re"><i class="fa fa-search"></i></button>
                                              </span>
                                    </div>

                                </div>

                            </header>


                            <div class="">
                                <div class="adv-table">
                                    <!-- <div class="adv-table" id="ajax_return"> -->
                                    <table class="display table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th class="text-center" width="10%">
                                                头像
                                            </th>
                                            <th class="text-center" width="15%">
                                                昵称
                                            </th>
                                            <th class="text-center" width="15%">
                                                用户名
                                            </th>
                                            <th class="text-center" width="15%">
                                                邮箱
                                            </th>
                                            <th class="text-center" width="15%">
                                                手机
                                            </th>
                                            <!--<th class="text-center">-->
                                                <!--余额-->
                                            <!--</th>-->
                                            <!--<th class="text-center">-->
                                                <!--会员等级-->
                                            <!--</th>-->
                                            <!--<th class="text-center">-->
                                                <!--积分-->
                                            <!--</th>-->
                                            <th class="text-center" width="10%">
                                                注册日期
                                            </th>
                                            <th class="text-center" width="10%">
                                                启用状态
                                            </th>
                                            <th class="text-center" width="10%">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(is_array($userList)): $n = 0; $__LIST__ = $userList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($n % 2 );++$n;?><tr role="row" align="center" style="background:#FFFFFF;">
                                                <td class="text-center">
                                                    <img width="40" height="40" src="<?php echo ($list["head_pic"]); ?>" id="head_pic"
                                                         onclick="preview(this)"/></td>
                                                <td class="text-center"><?php echo ($list["nickname"]); ?></td>
                                                <td class="text-center"><?php echo ($list["user_name"]); ?></td>
                                                <td class="text-center"><?php echo ($list["email"]); ?></td>
                                                <td class="text-center"><?php echo ($list["mobile"]); ?></td>
                                                <!--<td class="text-center"><?php echo ($list["user_money"]); ?></td>-->
                                                <!--<td class="text-center"><?php echo ($list["level"]); ?></td>-->
                                                <!--<td class="text-center"><?php echo ($list["pay_points"]); ?></td>-->
                                                <td class="text-center"><?php echo ($list["reg_time"]); ?></td>

                                                <td class="text-center">
                                                    <!--src="/Public/images/<?php if($list[is_lock] == 1): ?>yes.png<?php else: ?>cancel.png<?php endif; ?>"-->
                                                            <img width="20" height="20"
                                                             src="/Public/images/<?php if($list[is_lock] == 0): ?>yes.png<?php else: ?>cancel.png<?php endif; ?>"
                                                             onclick="changeTableField('<?php echo ($mod_id); ?>','ManageUsers','user_id','<?php echo ($list["user_id"]); ?>','is_lock',this)"  />
                                                </td>

                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <a href="/index.php/Admin/User/user/action/page_edit/id/<?php echo ($list["user_id"]); ?>"
                                                           data-toggle="tooltip" title="" class="btn btn-default"
                                                           data-original-title="查看详情"><i class="fa fa-pencil"></i></a>
                                                        <!--<a href="/index.php/Admin/User/user/action/address/id/<?php echo ($list["user_id"]); ?>"-->
                                                           <!--data-toggle="tooltip" title="" class="btn btn-default"-->
                                                           <!--data-original-title="收货地址"><i class="fa fa-home"></i></a>-->
                                                        <!--<a href="/index.php/Admin/Order/order/action/page_list/user_id/<?php echo ($list["user_id"]); ?>"-->
                                                           <!--data-toggle="tooltip" title="" class="btn btn-default"-->
                                                           <!--data-original-title="订单查看"><i class="fa fa-shopping-cart"></i></a>-->
                                                        <!--<a href="/index.php/Admin/User/user/action/account_log/id/<?php echo ($list["user_id"]); ?>"-->
                                                           <!--data-toggle="tooltip" title="" class="btn btn-default"-->
                                                           <!--data-original-title="账户"><i-->
                                                                <!--class="fa fa-rmb"></i></a>-->
                                                        <a href="#delModal"
                                                           data-toggle="modal" class="btn btn-default del-user"

                                                           data-url="/index.php/Admin/User/user/action/del/id/<?php echo ($list["user_id"]); ?>"
                                                           data-name="<?php echo ($list["nickname"]); ?>"

                                                            data-url="/index.php/Admin/User/user/action/del/id/<?php echo ($list["user_id"]); ?>"
                                                           data-name="<?php echo ($list["user_id"]); ?>"

                                                           onclick="delModal(this)"
                                                           ><i class="fa fa-trash-o"></i></a>
                                                    </div>
                                                </td>
                                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                                        </tbody>
                                    </table>
                                    <!-- Modal -->
                                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabajaxindex="-1" id="delModal"
                                         class="modal fade ">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×
                                                    </button>
                                                    <h4 class="modal-title">信息</h4>
                                                </div>
                                                <div class="modal-body" id="del_info">

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                            onclick="del_module();"> 确定
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
                                                    <span class=" wenzi" style="float:left">条每页，总共 <?php echo ($count); ?> 条</span>
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
                                                            <a href="/index.php/Admin/User/user/action/page_list/page_now/<?php echo ($page_now-1); ?>/page_num/<?php echo ($page_num); ?>">
                                                                上一页
                                                            </a>
                                                        </li><?php endif; ?>   <!-- 上一页 end -->

                                                    <?php if($page < 5): ?><!-- 页码条 -->
                                                        <?php $__FOR_START_22274__=1;$__FOR_END_22274__=$page+1;for($i=$__FOR_START_22274__;$i < $__FOR_END_22274__;$i+=1){ ?><!-- 循环四条以内 -->
                                                            <?php if($i == $page_now ): ?><li class="active"><a href=""><?php echo ($i); ?></a></li>
                                                                <?php elseif($i < $page_now ): ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/User/user/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/User/user/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php elseif($page_now < 3): ?>
                                                        <?php $__FOR_START_22547__=1;$__FOR_END_22547__=6;for($i=$__FOR_START_22547__;$i < $__FOR_END_22547__;$i+=1){ ?><!-- 循环1-5 -->

                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page_now ): ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/User/user/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/User/user/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>

                                                                </li><?php endif; } ?>
                                                        <?php elseif($page_now == $page-1): ?>
                                                        <?php $__FOR_START_31312__=$page_now-3;$__FOR_END_31312__=$page+1;for($i=$__FOR_START_31312__;$i < $__FOR_END_31312__;$i+=1){ ?><!-- 循环当前页为倒数第二页时 -->
                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page ): ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/User/user/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/User/user/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php elseif($page_now == $page): ?>
                                                        <?php $__FOR_START_9289__=$page_now-4;$__FOR_END_9289__=$page+1;for($i=$__FOR_START_9289__;$i < $__FOR_END_9289__;$i+=1){ ?><!-- 循环当前页为最后一页时 -->
                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page ): ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/User/user/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/User/user/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php else: ?>
                                                        <?php $__FOR_START_24910__=$page_now-2;$__FOR_END_24910__=$page_now+3;for($i=$__FOR_START_24910__;$i < $__FOR_END_24910__;$i+=1){ ?><!-- 循环除了前五条 和后五条 -->

                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page ): ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/User/user/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="/index.php/Admin/User/user/action/page_list/page_now/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } endif; ?>   <!-- 页码条 end -->

                                                    <?php if(($page_now != $page) AND ($page != 0)): ?><!-- 下一页 -->
                                                        <li class="next ">
                                                            <a href="/index.php/Admin/User/user/action/page_list/page_now/<?php echo ($page_now+1); ?>/page_num/<?php echo ($page_num); ?>">
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

<script type="text/javascript" src="<?php echo (JS); ?>/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo (JS); ?>/Validform_v5.3.2_min.js"></script>
<script type="text/javascript">
    $('.adminex-form').Validform({
        tiptype: 3
    });
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
<script src="/Public/js/myAjax.js"></script>
<script>

    $(function (e) {
        $('#add').click(function (e) {
            var myAdd = $('<div class="form-group">' +
                    '<select class="check option fl" name="searchfor[]" onchange="selectValue(this);">' +
                    '<option value="user_id" searchtype="1">ID</option>' +
                    '<option value="mobile" searchtype="1">用户名</option>' +
                    '<option value="nickname" searchtype="1">会员昵称</option>' +
                    '<option value="user_money" searchtype="1">余额</option>' +
                    '<option value="level" searchtype="1">会员等级</option>' +
                    '<option value="pay_points" searchtype="1">积分</option>' +
                    '<option value="reg_time" searchtype="7" propname="recentActivityRecordTime">注册日期</option>' +

                    '</select>' +
                    '<select name="select[]" id="" class="option fl">' +
                    '<option value="1">等于</option>' +
                    '<option value="2">不等于</option>' +
                    '<option value="3">小于</option>' +
                    '<option value="4">大于</option>' +
                    '<option value="5">小于等于</option>' +
                    '<option value="6">大于等于</option>' +
                    '<option value="7">包含</option>' +
                    '<option value="8">不包含</option>' +
                    '</select>' +
                    '<input type="text" name="content[]"/>' +
                    '<span><a style="margin-left:16px" class="del" href="javascript:;">' +
                    '<img src="<?php echo (IMG); ?>/details_close.png" alt="" /></a></span></div>')

            $('#qwe').prepend(myAdd);
        });

        $(document).on('click', '.del', function () {
            var self = $(this)

            setTimeout(function () {
                self.parent().parent().remove();
            }, 300)
        })

    });
    var searchtype;

    function selectValue(_this) {
        searchtype = $(_this).find("option:selected").attr('searchtype');
        console.log(searchtype)
        if (searchtype == 7) {
            $(_this).siblings('input')[0].type = 'date';
        } else {
            $(_this).siblings('input')[0].type = 'text'
        }
    }
    function preview(id) {
        var src=$(id).attr("src");

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
     //删除操作
    function del(id, t) {
        if (!confirm('确定要删除吗?'))
            return false;
        location.href = $(t).data('href');
    }
    function search() {
        $('#search').submit();
    }
    $(document).ready(function () {
        //默认选中
        $("#page_num").val(<?php echo ($page_num); ?>);
    });

    var url;
    var user_name;
    var user_del;
    //删除菜单
    function delModal(obj) {
        user_del = $(obj);
        url = $(obj).attr('data-url');
        user_name = $(obj).attr('data-name');
        $("#del_info").html("确定删除用户： 【" + user_name + "】  ")
    }
    function del_module() {
        $.get(url, function (res) {
            if (res.result == 1) {
                layer.msg(res.msg);
                user_del.parent().parent().parent().remove();
            } else if(res.result==0){
                layer.msg(res.msg);
            }
            //location.href = "<?php echo U('Admin/User/user');?>" + "/id/" + user_id;
        });
    }
//    function gettrue() {
//            location.href = "<?php echo U('Admin/User/user');?>" + "/id/" + user_id;
//    }


    function search() {
        $('#search').submit();
    }
    $(document).ready(function () {
        //默认选中
        $("#page_num").val(<?php echo ($page_num); ?>);
    });
</script>
</body>
</html>