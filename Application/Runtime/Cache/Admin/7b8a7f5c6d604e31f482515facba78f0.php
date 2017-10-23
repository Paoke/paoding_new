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
    <script src="/Public/js/myAjax.js"></script>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<style type="text/css">
 .table-bordered   {
   
    border: none;
}

table{
     border-bottom:1px solid #ddd !important;;
}
.dataTables_paginate {
     padding:0;
}
.pagination {
    margin:0;
}

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
                        <header class="panel-heading panel-body  ">
                            <div class="pull-left ">
                                菜单管理
                            </div>
                            <div class="pull-right ">
                                <div class="btn-group">
                                    <a href="/index.php/Admin/System/menu/action/page_add" class="btn btn-default "><i
                                            class="fa fa-plus"></i>新增菜单</a>
                                </div>
                            </div>
                        </header>

                        <div class="">
                            <div class="adv-table">
                                <table id="list-table" class="table table-bordered table-hover" role="grid"
                                       aria-describedby="example1_info">
                                    <thead>
                                    <tr>
                                        <th width="10%">标题</th>
                                        <th width="25%">调用别名</th>
                                        <th width="15%">显示/隐藏</th>
                                        <th class="hidden-phone" width="10%">排序</th>
                                        <th class="hidden-phone" width="10%">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($info)): foreach($info as $k=>$vo): ?><tr role="row" align="center" class="<?php echo ($vo["level"]); ?>" id="<?php echo ($vo["mod_id"]); ?>">
                                            <td  onclick="listSon(this,'<?php echo ($vo["mod_id"]); ?>')">
                                                <?php if($vo["infoSon"] >= 1): ?><span class="fa fa-caret-right" id="icon_<?php echo ($vo["level"]); ?>_<?php echo ($vo["mod_id"]); ?>"
                                                          onclick="listSon(this,'<?php echo ($vo["mod_id"]); ?>')">&nbsp;</span><?php endif; ?>
                                                <?php echo (getSubstr($vo["title"],0,20)); ?>
                                            </td>
                                            <td><?php echo ($vo["call_index"]); ?></td>
                                            <td>
                                                <img width="20" height="20"
                                                     src="/Public/images/<?php if($vo[visible] == 1): ?>yes.png<?php else: ?>cancel.png<?php endif; ?>"
                                                     onclick="changeTableVal('<?php echo ($mod_id); ?>','SystemModule','mod_id','<?php echo ($vo["mod_id"]); ?>','visible',this,'<?php echo ($vo["is_sys"]); ?>')"/>
                                            </td>
                                            <td>
                                                <input type="text"
                                                       onchange="updateSort('','system_module','mod_id','<?php echo ($vo["mod_id"]); ?>','orderby',this)"
                                                       onkeyup="this.value=this.value.replace(/[^\d]/g,'')" maxlength="4" size="4"
                                                       value="<?php echo ($vo["orderby"]); ?>"
                                                       class="input-sm"/>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a class="btn btn-default"
                                                       href="/index.php/Admin/System/menu/action/page_edit/id/<?php echo ($vo["mod_id"]); ?>"
                                                       title="编辑"><i
                                                            class="fa fa-pencil"></i></a>
                                                    <a href="#delModal" data-toggle="modal" class="btn btn-default"
                                                       data-name="<?php echo ($vo["title"]); ?>" title="删除"
                                                       data-url="/index.php/Admin/System/menu/action/del/id/<?php echo ($vo["mod_id"]); ?>"
                                                       onclick="delModal(this)"><i class="fa fa-trash-o"></i></a>
                                                </div>
                                            </td>
                                        </tr><?php endforeach; endif; ?>
                                    </tbody>
                                </table>
                                <!-- Modal -->
                                <div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <!--body wrapper end-->
    </div>
    <!-- main content end-->
</section>

<script src="/Public/js/jquery-1.9.1.min.js"></script>
<script src="/Public/js/myFormValidate.js"></script>
<script src="/Public/js/layer/layer-min.js"></script>
<script src="/Public/js/bootstrap.js" type="text/javascript"></script>
<!-- Placed js at the end of the document so the pages load faster -->
<script src="<?php echo (JS); ?>/jquery.nicescroll.js"></script>
<!--common scripts for all pages-->
<script src="<?php echo (JS); ?>/scripts.js"></script>
<script src="/Public/js/myAjax.js"></script>

<script type="text/javascript">

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
    function listSon(obj, id) {
        var str = '';
        var url = "/index.php/Admin/System/menu/action/page_list/id/" + id;
        var faClass = $(obj).children().attr("class");
        if (faClass == "fa fa-caret-right") {
            $.get(url, function (res) {
                $.each(res.data, function (i, item) {
                    str += '<tr role="row" align="center" class="' + item.mod_id + ' id=' + item.mod_id + '">';
                    if (item.infoSon >= 1) {
                        str += '<td  onclick="listSon(this,' + item.mod_id + ')" style="padding-left:' +
                                item.level * 15 + 'px;">';
                        str += '<span class="fa fa-caret-right">&nbsp;</span>';
                        str += item.title.substr(0, 20) + '</td>';
                    } else {
                        str += '<td  style="padding-left:' + item.level * 15 + 'px;">';
                        str += item.title.substr(0, 20) + '</td>';
                    }
                    str += '<td>' + item.call_index + '</td>';
                    str += '<td><img width="20" height="20"'
                    if (item.visible == 1) {
                        str += 'src=\'/Public/images/yes.png\'';
                    }else{
                        str += 'src=\'/Public/images/cancel.png\'';
                    }

                    str +='onclick="changeTableVal(\''+item.mod_id+'\',\'SystemModule\',\'mod_id\',\''+item.mod_id+'\',\'visible\',this,\''+item.visible+'\')"/> </td>' ;
                    str += '<td><input type="text" onchange=\'updateSort("","system_module","mod_id","' + item.mod_id +
                            '","orderby",this)\' onkeyup="this.value=this.value.replace(/[^\d]/g,"")" maxlength="4" ' +
                            'size="4" value="' + item.orderby + '" class="input-sm"/></td>';
                    str += '<td><div class="btn-group btn-group-sm">';
                    str += '<a class="btn btn-default" ' +
                            'href="/index.php/Admin/System/menu/action/page_edit/id/' + item.mod_id + '"' +
                            ' title="编辑"><i class="fa fa-pencil"></i></a>';
                    str += '<a href="#delModal" data-toggle="modal" class="btn btn-default delModal"' +
                            'data-name="' + item.title + '" data-id="' + item.mod_id + '"' +
                            'data-url="/index.php/Admin/System/menu/action/del/id/' + item.mod_id + '"' +
                            'title="删除" onclick="delModal(this)"><i class="fa fa-trash-o"></i></a>';
                    str += '</div></td></tr>';
                });
                $(obj).children("span").removeClass("fa-caret-right");
                $(obj).children("span").addClass("fa-caret-down");
                $(obj).parent().after(str);
                $('body').niceScroll().resize();
            });
        } else {
            var url = "/index.php/Admin/System/menu/action/page_list/id/" + id + "/getTreeSon/1";
            $.post(url, function (res) {
                $.each(res.data, function (i, item) {
                    $(obj).children("span").removeClass("fa-caret-down");
                    $(obj).children("span").addClass("fa-caret-right");
                    $("." + item.mod_id).remove();
                })
            })
        }
    }
</script>

</body>
</html>