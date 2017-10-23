<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="author" content="ThemeBucket">
    <meta name="keywords" content="<?php echo ($tpshop_config['shop_info_store_keyword']); ?>"/>
    <meta name="description" content="<?php echo ($tpshop_config['shop_info_store_desc']); ?>"/>

    <title><?php echo ($gemmapshop_config['shop_info_store_title']); ?></title>

    <!--dynamic table-->
    <link href="<?php echo (CSS); ?>/style.css" rel="stylesheet">
    <link href="<?php echo (CSS); ?>/style-responsive.css" rel="stylesheet">
    <!--multi-select-->
    <link rel="stylesheet" type="text/css" href="<?php echo (JS); ?>/jquery-multi-select/css/multi-select.css" />
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<style type="text/css">
.navbar-default { background-color: #fff; border-bottom: 1px solid #e7e7e7; }
.panel{ border: 1px solid #e7e7e7; }
.formadd { padding: 0px; }
.pagination { margin:0; }
.dataTables_paginate { padding:0; }
.panel-heading { border-bottom: 0px solid #ddd; }
    .deleted{display: none;}
.cur_1{display:none;}
.cur_2{display:block !important;}
    .ms-repetition,.ms-select li{cursor: pointer;}
.ms-repetition{margin-top: 44px !important;}
.ms-repetition li{
    border-bottom: 1px #eee solid;
    padding: 2px 10px;
    color: #555;
    font-size: 14px;}
</style>
<body class="sticky-header">

<section>

    <!-- main content start-->
    <div class="main-content " width="100%" style="margin:0px;">


        <form action="<?php echo U('Admin/role_user');?>" id="search" role="search" method="post">

            <!--body wrapper start-->
            <div class="wrapper">
                <!--  -->
                <div class="row">
                    <div class="col-sm-12">
                        <section class="panel">
                            <header class="panel-heading panel-body">
                                <div class="pull-left ">
                                    【超级管理员】用户管理
                                </div>
                                <div class="pull-right">
                                    <div class="formadd">
                                        <a href="#myModal" data-toggle="modal"  class="btn btn-default pull-right"><i
                                                class="fa fa-plus"></i>添加用户</a>
                                    </div>
                                </div>
                               
                            </header>

                            <div class="">
                                <div class="adv-table">
                                    <table class="display table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th width="25%">用户名</th>
                                            <th width="25%">用户昵称</th>
                                            <th width="15%">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(is_array($data)): foreach($data as $k=>$vo): ?><tr role="row" align="center" style="background:#FFFFFF;">
                                                <td><?php echo ($vo["user_name"]); ?></td>
                                                <td><?php echo ($vo["role_name"]); ?></td>
                                                <td>
                                                        <div class="btn-group">
                                                            <?php if($vo["user_id"] != ''): ?><a href="#delModal" data-toggle="modal" class="btn btn-default"
                                                               data-name="<?php echo ($vo["user_name"]); ?>" title="删除用户"
                                                                data-url="/index.php/Admin/Admin/role_user/action/del/id/<?php echo ($vo["user_id"]); ?>"
                                                               onclick="delModal(this)"><i class="fa fa-trash-o"></i></a><?php endif; ?>
                                                        </div>
                                                </td>
                                            </tr><?php endforeach; endif; ?>
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
                                                            <a href="<?php echo U('Admin/Admin/role_user/page_now');?>/<?php echo ($page_now-1); ?>/page_num/<?php echo ($page_num); ?>">
                                                                上一页
                                                            </a>
                                                        </li><?php endif; ?>   <!-- 上一页 end -->
                                                    <?php if($page < 5): ?><!-- 页码条 -->
                                                        <?php $__FOR_START_3384__=1;$__FOR_END_3384__=$page+1;for($i=$__FOR_START_3384__;$i < $__FOR_END_3384__;$i+=1){ ?><!-- 循环四条以内 -->
                                                            <?php if($i == $page_now ): ?><li class="active"><a href=""><?php echo ($i); ?></a></li>
                                                                <?php elseif($i < $page_now ): ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/Admin/role_user/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/Admin/role_user/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php elseif($page_now < 3): ?>
                                                        <?php $__FOR_START_24849__=1;$__FOR_END_24849__=6;for($i=$__FOR_START_24849__;$i < $__FOR_END_24849__;$i+=1){ ?><!-- 循环1-5 -->

                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page_now ): ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/Admin/role_user/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/Admin/role_user/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php elseif($page_now == $page-1): ?>
                                                        <?php $__FOR_START_12918__=$page_now-3;$__FOR_END_12918__=$page+1;for($i=$__FOR_START_12918__;$i < $__FOR_END_12918__;$i+=1){ ?><!-- 循环当前页为倒数第二页时 -->
                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page ): ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/Admin/role_user/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/Admin/role_user/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php elseif($page_now == $page): ?>
                                                        <?php $__FOR_START_8311__=$page_now-4;$__FOR_END_8311__=$page+1;for($i=$__FOR_START_8311__;$i < $__FOR_END_8311__;$i+=1){ ?><!-- 循环当前页为最后一页时 -->
                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page ): ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/Admin/role_user/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/Admin/role_user/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } ?>
                                                        <?php else: ?>
                                                        <?php $__FOR_START_17636__=$page_now-2;$__FOR_END_17636__=$page_now+3;for($i=$__FOR_START_17636__;$i < $__FOR_END_17636__;$i+=1){ ?><!-- 循环除了前五条 和后五条 -->

                                                            <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                                <?php elseif($i < $page ): ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/Admin/role_user/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li>
                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="<?php echo U('Admin/Admin/role_user/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                                </li><?php endif; } endif; ?>   <!-- 页码条 end -->

                                                     <?php if(($page_now != $page) AND ($page != 0)): ?><!-- 下一页 -->
                                                        <li class="next ">
                                                            <a href="<?php echo U('Admin/Admin/role_user/page_now/');?>/<?php echo ($page_now+1); ?>/page_num/<?php echo ($page_num); ?>">
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

                        <!-- 新增用户窗口 -->
                        <div aria-hidden="true" aria-labelledby="myModalLabel"  role="dialog" tabindex="-1" id="myModal" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title">添加用户</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="panel-body">
                                            <form  class="form-horizontal" method="post" id="form_id_name">
                                                <input type="hidden" id="id" name="id" value="<?php echo ($info["user_id"]); ?>">
                                                <input type="hidden" id="role_id" name="role_id" value="<?php echo ($role_id); ?>">
                                                <div class="form-group last" >
                                                    <div class="col-md-6" id="ComboBox">
                                                        <div class="ms-container" id="ms-my_multi_select3">
                                                            <div class="ms-selectable">
                                                                <input type="text" class="form-control search-input" id="keyword" onKeyUp ="loadRole(0)" autocomplete="off" placeholder="search...">

                                                                <ul class="ms-list ms-select" tabindex="-1">
                                                                    <?php if(is_array($info)): foreach($info as $key=>$vol): ?><li class="ms-elem-selectable"  style=""   id="<?php echo ($vol["user_id"]); ?>" >
                                                                            <span ><?php echo ($vol["user_name"]); ?></span>
                                                                        </li><?php endforeach; endif; ?>
                                                                </ul>
                                                            </div>
                                                            <div class="ms-selection">

                                                            <ul class="ms-list ms-repetition" tabindex="-1">
                                                                <?php if(is_array($into)): foreach($into as $key=>$vo2): ?><li class="ms-elem-selectable ms-selectdata"  style="display:none;" id="<?php echo ($vo2["user_id"]); ?>" >
                                                                        <span><?php echo ($vo2["user_name"]); ?></span>
                                                                    </li><?php endforeach; endif; ?>
                                                            </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                        <button type="button" class="btn btn-success" onclick="confirm('form_id_name')">确认</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 新增用户窗口 -->
                    </div>
                </div>
            </div>
            <!--body wrapper end-->
        </form>


    </div>
    <!-- main content end-->
</section>

<!-- Placed js at the end of the document so the pages load faster -->
<script type="text/javascript" src="<?php echo (JS); ?>/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="<?php echo (JS); ?>/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo (JS); ?>/bootstrap.js"></script>
<script type="text/javascript" src="<?php echo (JS); ?>/jquery.nicescroll.js"></script>
<!--common scripts for all pages-->
<script type="text/javascript" src="<?php echo (JS); ?>/scripts.js"></script>

<script type="text/javascript" src="/Public/js/myAjax.js"></script>
<script type="text/javascript" src="/Public/js/myFormValidate.js"></script>
<script type="text/javascript" src="/Public/js/layer/layer-min.js"></script>

</body>
</html>


<script type="text/javascript">


//    $(function(){
//        $('.ms-select li').click(function(){
//            $(this).addClass('cur_1');
//            $('.ms-repetition li').eq($(this).index()).addClass('cur_2');
//        });
//
//        $('.ms-repetition li').click(function(){
//            $(this).removeClass('cur_2');
//            $('.ms-select li').eq($(this).index()).removeClass('cur_1');
//        });
//    })

$(function (){
    load();
})

    function  load(){
        $('.ms-select li').click(function(){
            $(this).addClass('cur_1');
            $('.ms-repetition li').eq($(this).index()).addClass('cur_2');
        });

        $('.ms-repetition li').click(function(){
            $(this).removeClass('cur_2');
            $('.ms-select li').eq($(this).index()).removeClass('cur_1');
        });
    }

//{
//    var id = $(".ms-elem-selectable.cur_2").attr("id");
//
//
//
//
//    var action="/index.php/Admin/Admin/role_user/action/confirm";
//
//
//
//    $.ajax({
//        type:'post',
//        url:action,
//        data:$("#" + form_id).serialize(),
//        dataType:'json',
//        success:function(ret){
//            if(ret.result==1){
//                layer.msg=(ret.msg);
//                setTimeout(function(){
//                    window.location.href = "/index.php/Admin/Admin/role_user/action/page_list";
//                },1000)
//            }
//            if(ret.msg==0){
//                layer.msg(ret.msg);
//            }
//        }
//
//    })
//
//}


    function confirm(form_id){
       //遍历选中的值
//      $(".ms-elem-selectable.ms-selected").find("span").each(function(){
//            var id=$(this).text();
//        });
        //获得选中的ID值
//       var index = $(".cur_2").find("span").each(function(){
//         $(this).text();
//       });
        var id = "";
        $(".ms-elem-selectable.cur_2").each(function(){
            id += $(this).attr("id") + ',';
        });
        var id = id.substring(0,id.length-1);
        var role_id=$("#role_id").val();
        var action='/index.php/Admin/Admin/role_user/action/confirm';
        var data = {'id': id,"role_id":role_id};
        $.ajax({
            type: "post",
            url: action,
            data: data,
            dataType: 'json',
            success: function (res) {
                if (res.result == 1) {
                    layer.msg(res.msg);
                    setTimeout(function () {
                        window.location.href = "/index.php/Admin/Admin/role_user/action/page_list/id/"+role_id;
                    }, 1000);
                }
                if (res.result == 0) {
                    layer.msg(res.msg);
                }
            }
        })

    }

//$(function(){
//    loadThis();
//});
//    function loadThis(){
//        $(".ms-elem-selectable").on('click',function(){
//           $(this).attr('style',"display:none;");
//        });
//    }

//$(function(){
//    var url ="/index.php/Admin/Admin/role_user/action/gain";
//
//    $.post(url,function(ret){
//        if(ret.result==1){
//            var data=ret;
//            for (var key in data){
//                var value=data[key];
//                var str='<li class="ms-elem-selectable" id="'+value.user_id+'">';
//                str  +='<span>'+value.user_name+'</span>';
//                str +='</li>';
//
//                $('.ms-select li').click(function(){
//                    $(this).css('display','none');
//                    $('.ms-repetition').append(str);
//                })
//            }
//
//        }
//
//    },"json");
//
//
//})


    function loadRole(){
        var url ="/index.php/Admin/Admin/role_user/action/list";
        var user_name=$("#keyword").val();
        var data={"user_name":user_name};
        $.post(url,data,function(res){
            if(res.result==1){
                $(".ms-select").empty();
                $(".ms-repetition").empty();
                var data = res.data;
                for (var key in data){
                    var value = data[key];
                        var str='<li class="ms-elem-selectable" onclick="load()" id="'+value.user_id+'">';
                            str  +='<span>'+value.user_name+'</span>';
                            str +='</li>';

                    var ste='<li class="ms-elem-selectable" style="display:none;"  id="'+value.user_id+'">';
                    ste  +='<span>'+value.user_name+'</span>';
                    ste +='</li>';
                    $(".ms-repetition").append(ste);
                    $(".ms-select").append(str);
                }



            }
        },'json');
    }



    var modal_url;
    var modal_name;
    var modal_object;
    //删除菜单
    function delModal(obj) {
        modal_object = $(obj);
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
</script>