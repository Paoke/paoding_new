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
<body class="sticky-header" >

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
                                标签管理
                            </div>
                            <div class="collapse navbar-collapse pull-right">
                                <form role="search" method="post">
                                    <div class="panel-body formadd">
                                        <div class="pull-left">
                                            <div class="btn-group">
                                            </div>
                                        </div>
                                        <div class="pull-right">
                                            <div class="btn-group" style="margin-top: -5px;">
                                                <a href="/index.php/Admin/Activity/tags/action/page_add/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>"
                                                   class="btn btn-default "><i
                                                        class="fa fa-plus"></i>新增标签</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </header>


                        <div class="">
                            <div class="adv-table">
                                <table id="list-table" class="table table-bordered table-hover" role="grid"
                                       aria-describedby="example1_info">
                                    <thead>
                                    <tr role="row">
                                        <?php if($info_field): ?><th valign="middle">ID</th>
                                            <?php if(is_array($info_field)): foreach($info_field as $key=>$vo1): ?><th id="filed" width="" valign="middle"><?php echo ($vo1["title"]); ?></th><?php endforeach; endif; ?>
                                            <th  width="" valign="middle">显示/隐藏</th>
                                            <th valign="middle" width="12%">操作</th><?php endif; ?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($info)): foreach($info as $vokey=>$vo): ?><tr role="row" align="center" id="<?php echo ($vo["id"]["data"]); ?>">
                                            <?php if(is_array($vo)): foreach($vo as $vokey1=>$vo1): if($vo1["type"] == 'image'): ?><td class="text-center">
                                                        <img width="40" height="40" src="<?php echo ($vo1["data"]); ?>" onclick="preview(this)"/>
                                                    </td>
                                                    <?php elseif($vokey1 == 'status'): ?>
                                                    <td>
                                                        <img width="20" height="20"
                                                             src="/Public/images/<?php if($vo1["data"] == 1): ?>yes.png<?php else: ?>cancel.png<?php endif; ?>"
                                                             onclick="changeTableVal('<?php echo ($mod_id); ?>','<?php echo ($table_name); ?>','id','<?php echo ($vo["id"]["data"]); ?>','status',this)"/>
                                                    </td>
                                                    <?php else: ?>
                                                    <td><?php echo ($vo1["data"]); ?></td><?php endif; endforeach; endif; ?>

                                            <td>
                                                <div class="btn-group">
                                                    <a class="btn btn-default"
                                                       href="/index.php/Admin/Activity/tags/action/page_edit/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>/id/<?php echo ($vo["id"]["data"]); ?>"
                                                       title="编辑"><i class="fa fa-pencil"></i></a>
                                                    <a href="#delModal" data-toggle="modal" class="btn btn-default"
                                                       data-name="<?php echo ($vo["tag_name"]["data"]); ?>" title="删除"
                                                       data-url="/index.php/Admin/Activity/tags/action/del/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>/id/<?php echo ($vo["id"]["data"]); ?>"
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
                                                        <a href="<?php echo U('Admin/User/index/page_now');?>/<?php echo ($page_now-1); ?>/page_num/<?php echo ($page_num); ?>">
                                                            上一页
                                                        </a>
                                                    </li><?php endif; ?>   <!-- 上一页 end -->

                                                <?php if($page < 5): ?><!-- 页码条 -->
                                                    <?php $__FOR_START_28191__=1;$__FOR_END_28191__=$page+1;for($i=$__FOR_START_28191__;$i < $__FOR_END_28191__;$i+=1){ ?><!-- 循环四条以内 -->
                                                        <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($i); ?></a></li>
                                                            <?php elseif($i < $page_now ): ?>
                                                            <li>
                                                                <a href="<?php echo U('Admin/User/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                            </li>
                                                            <?php else: ?>
                                                            <li>
                                                                <a href="<?php echo U('Admin/User/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                            </li><?php endif; } ?>
                                                    <?php elseif($page_now < 3): ?>
                                                    <?php $__FOR_START_1388__=1;$__FOR_END_1388__=6;for($i=$__FOR_START_1388__;$i < $__FOR_END_1388__;$i+=1){ ?><!-- 循环1-5 -->

                                                        <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                            <?php elseif($i < $page_now ): ?>
                                                            <li>
                                                                <a href="<?php echo U('Admin/User/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                            </li>
                                                            <?php else: ?>
                                                            <li>
                                                                <a href="<?php echo U('Admin/User/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                            </li><?php endif; } ?>
                                                    <?php elseif($page_now == $page-1): ?>
                                                    <?php $__FOR_START_26421__=$page_now-3;$__FOR_END_26421__=$page+1;for($i=$__FOR_START_26421__;$i < $__FOR_END_26421__;$i+=1){ ?><!-- 循环当前页为倒数第二页时 -->
                                                        <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                            <?php elseif($i < $page ): ?>
                                                            <li>
                                                                <a href="<?php echo U('Admin/User/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                            </li>
                                                            <?php else: ?>
                                                            <li>
                                                                <a href="<?php echo U('Admin/User/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                            </li><?php endif; } ?>
                                                    <?php elseif($page_now == $page): ?>
                                                    <?php $__FOR_START_18378__=$page_now-4;$__FOR_END_18378__=$page+1;for($i=$__FOR_START_18378__;$i < $__FOR_END_18378__;$i+=1){ ?><!-- 循环当前页为最后一页时 -->
                                                        <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                            <?php elseif($i < $page ): ?>
                                                            <li>
                                                                <a href="<?php echo U('Admin/User/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                            </li>
                                                            <?php else: ?>
                                                            <li>
                                                                <a href="<?php echo U('Admin/User/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                            </li><?php endif; } ?>
                                                    <?php else: ?>
                                                    <?php $__FOR_START_19771__=$page_now-2;$__FOR_END_19771__=$page_now+3;for($i=$__FOR_START_19771__;$i < $__FOR_END_19771__;$i+=1){ ?><!-- 循环除了前五条 和后五条 -->

                                                        <?php if($i == $page_now ): ?><li class="active"><a href="#"><?php echo ($page_now); ?></a></li>
                                                            <?php elseif($i < $page ): ?>
                                                            <li>
                                                                <a href="<?php echo U('Admin/User/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                            </li>
                                                            <?php else: ?>
                                                            <li>
                                                                <a href="<?php echo U('Admin/User/index/page_now');?>/<?php echo ($i); ?>/page_num/<?php echo ($page_num); ?>"><?php echo ($i); ?></a>
                                                            </li><?php endif; } endif; ?>   <!-- 页码条 end -->

                                                 <?php if(($page_now != $page) AND ($page != 0)): ?><!-- 下一页 -->
                                                    <li class="next ">
                                                        <a href="<?php echo U('Admin/User/index/page_now/');?>/<?php echo ($page_now+1); ?>/page_num/<?php echo ($page_num); ?>">
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

</body>
</html>

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

    //图片预览
    function preview(id) {
        var src = $(id).attr("src");
        var content;
        if (src == "") {
            content = '没有图片可供预览';
            layer.msg(content);
        } else {
            content = "<img width='300px;' height='300px' src='" + src + "'>";
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
    function listSon(obj, id) {
        var str = '';
        var url = "/index.php/Admin/Activity/tags/action/page_list/id/" + id + "/type/<?php echo ($type); ?>";
        var faClass = $(obj).children().attr("class");
        if (faClass == "fa fa-caret-right") {
            $.get(url, function (res) {
                $.each(res.data, function (i, item) {
                    str += '<tr role="row" align="center" class="' + item.id + ' id=' + item.id + '">';
                    str += '<td>' + item.id + '</td>';
                    if (item.infoSon >= 1) {
                        str += '<td align="left" onclick="listSon(this,' + item.id + ')" style="padding-left:' +
                                item.level * 15 + 'px;">';
                        str += '<span class="fa fa-caret-right">&nbsp;</span>';
                        str += item.title.substr(0, 20) + '</td>';
                    } else {
                        str += '<td align="left" style="padding-left:' + item.level * 15 + 'px;">';
                        str += item.title.substr(0, 20) + '</td>';
                    }
                    str += '<td>' + item.call_index + '</td>';
                    str += '<td class="text-center">' +
                            '<img width="40" height="40" src="' + item.logo_url + '" onclick="preview(this)"/>' +
                            '</td>';
                    str += '<td class="text-center">' +
                            '<img width="40" height="40" src="' + item.icon_url + '" onclick="preview(this)"/>' +
                            '</td>';
                    str += '<td><input type="text" onchange=\'updateSort("","Activity_tags","id",' +
                            '"' + item.id + '","sort_id",this)\' ' +
                            'onkeyup="this.value=this.value.replace(/[^\d]/g,"")" maxlength="4" ' +
                            'size="4" value="' + item.sort_id + '" class="input-sm"/></td>';
                    str += '<td><div class="btn-group btn-group-sm">';
                    str += '<a class="btn btn-default" ' +
                            'href="/index.php/Admin/Activity/tags/action/page_edit/id/' + item.id +
                            '/channel/<?php echo ($channel); ?>" title="编辑"><i class="fa fa-pencil"></i></a>';
                    str += '<a href="#delModal" data-toggle="modal" class="btn btn-default delModal"' +
                            'data-name="' + item.name + '" data-id="' + item.id + '"' +
                            'data-url="/index.php/Admin/Activity/tags/action/del/id/' + item.id + '"' +
                            'title="删除" onclick="delModal(this)"><i class="fa fa-trash-o"></i></a>';
                    str += '</div></td></tr>';
                });
                $(obj).children("span").removeClass("fa-caret-right");
                $(obj).children("span").addClass("fa-caret-down");
                $(obj).parent().after(str);
                $('body').niceScroll().resize();
            });
        } else {
            var url = "/index.php/Admin/Activity/tags/action/page_list/id/" + id +
                    "/channel/<?php echo ($channel); ?>/getTreeSon/1";
            $.post(url, function (res) {
                $.each(res.data, function (i, item) {
                    $(obj).children("span").removeClass("fa-caret-down");
                    $(obj).children("span").addClass("fa-caret-right");
                    $("." + item.id).remove();
                })
            })
        }
    }
</script>