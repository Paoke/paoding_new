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

    <!--dynamic table-->
    <link href="<?php echo (JS); ?>/advanced-datatable/css/demo_page.css" rel="stylesheet"/>
    <link href="<?php echo (JS); ?>/advanced-datatable/css/demo_table.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo (JS); ?>/data-tables/DT_bootstrap.css"/>
    <link href="<?php echo (CSS); ?>/style.css" rel="stylesheet">
    <link href="<?php echo (CSS); ?>/style-responsive.css" rel="stylesheet">


    <!-- jQuery 2.1.4 -->
    <script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="/Public/js/global.js"></script>
    <script src="/Public/js/myFormValidate.js"></script>
    <script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
    <script src="/Public/js/myAjax.js"></script>

    <!--GEMMAP自带的矢量图标库 font-awesome.min.css-->
    <link href="/Public/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
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

    .formadd {
        padding: 0px 0 8px 0;
        float: right;
    }

    .form-group .control-label {
        float: left;
        width: 150px;
        padding-top: 5px;
        text-align: right;
    }

    .form-group .controls {
        margin-left: 170px;
    }

    .form-group .controls .radio {
        display: inline;
        padding-left: 0px;
        padding-right: 20px;
        vertical-align: baseline;
    }

    .form-group .controls .large {
        width: 60%;
    }

    .form-group .controls select {
        width: 60%;
    }

    .form-group .controls .form-control {
        display: inline;
    }

    .form-group .controls .help-inline {
        padding-left: 10px;
        color: #595959;
    }

    .form-actions {
        margin-left: 170px;
    }

    .dropdown-checkboxes div {
        padding: 1px;
        padding-left: 10px;
    }

    .btn {
        margin: 2px;
    }

    .pagination {
        margin: 0px 0;
    }

    .table-bordered {
        border-top: none;
    }

    #tbody td{width:35% !important;}
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
                        <header class="panel-heading">
                            微信菜单管理 选择公众号:
                            <select id="select_wx">
                                <?php if(is_array($wechat_list)): $i = 0; $__LIST__ = $wechat_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><option value="<?php echo ($list["id"]); ?>"
                                    <?php if($list['id'] == $wechat_id): ?>selected<?php endif; ?>
                                    ><?php echo ($list["wxname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button class="btn btn-default " type="button" onclick="addpmenu()">
                                        <i class="fa fa-plus"></i>添加菜单</button>
                                    <button  type="button" onclick="submit()" class="btn btn-default">
                                        <i class="fa fa-save"></i>保存菜单</button>
                                </div>
                            </div>
                        </header>
                        <div class="panel-body">
                            <div class="adv-table">
                                <div class="box-body">
                                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                        <div class="row">
                                            <div class="col-sm-6"></div>
                                            <div class="col-sm-6"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12" style="height: 700px;overflow-y: auto;">
                                                <form id="submit" action="" method="post">
                                                    <table class="table table-bordered table-hover dataTable" id="example2" role="grid"
                                                           aria-describedby="example2_info">
                                                        <thead>
                                                        <tr role="row">
                                                            <th style="width: 30%" tabindex="0" aria-controls="example2"
                                                                aria-label="Rendering engine: activate to sort column ascending">菜单名称
                                                            </th>
                                                            <th style="width: 20%" tabindex="0" aria-controls="example2"
                                                                aria-label="Browser: activate to sort column ascending"
                                                                aria-sort="descending">类型
                                                            </th>
                                                            <th style="width: 50%" tabindex="0" aria-controls="example2"
                                                                aria-label="Platform(s): activate to sort column ascending">类型值
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="tbody">
                                                        <?php if(is_array($p_lists)): $i = 0; $__LIST__ = $p_lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><!--父级操作-->
                                                            <tr role="row" class=" pmenu<?php echo ($list["id"]); ?> menu<?php echo ($list["id"]); ?>">
                                                                <td>
                                                                    <input type="text" name="menu[<?php echo ($list["id"]); ?>][name]"
                                                                           style="width: 73%;" class="topmenu form-control"
                                                                           value="<?php echo ($list["name"]); ?>" placeholder="菜单名称"
                                                                           id="name-<?php echo ($list["id"]); ?>">
                                                                    <a onclick="addcmenu(<?php echo ($list["id"]); ?>);" class="btn btn-primary"><i
                                                                            class="fa fa-plus"></i></a>
                                                                    <!--  <a onclick="delmenu(<?php echo ($list["id"]); ?>);" class="btn btn-danger"><i class="fa fa-trash-o"></i></a> -->
                                                                    <a href="#myModal" data-toggle="modal"
                                                                       class="btn btn-danger del-good-attr" href="javascript:void(0)"
                                                                       data-id="<?php echo ($list['id']); ?>"><i class="fa fa-trash-o"></i></a>

                                                                </td>
                                                                <td class="sorting_1">
                                                                    <select name="menu[<?php echo ($list["id"]); ?>][type]" class="form-option"
                                                                            style="width: 95%">
                                                                        <option
                                                                        <?php if($list['type'] == 'view'): ?>selected<?php endif; ?>
                                                                        value="view">链接</option>
                                                                        <option
                                                                        <?php if($list['type'] == 'click'): ?>selected<?php endif; ?>
                                                                        value="click">触发关键字</option>
                                                                        <option
                                                                        <?php if($list['type'] == 'scancode_push'): ?>selected<?php endif; ?>
                                                                        value="scancode_push">扫码</option>
                                                                        <option
                                                                        <?php if($list['type'] == 'scancode_waitmsg'): ?>selected<?php endif; ?>
                                                                        value="scancode_waitmsg"> 扫码（等待信息）</option>
                                                                        <option
                                                                        <?php if($list['type'] == 'pic_sysphoto'): ?>selected<?php endif; ?>
                                                                        value="pic_sysphoto">系统拍照发图</option>
                                                                        <option
                                                                        <?php if($list['type'] == 'pic_photo_or_album'): ?>selected<?php endif; ?>
                                                                        value="pic_photo_or_album">拍照或者相册发图</option>
                                                                        <option
                                                                        <?php if($list['type'] == 'pic_weixin'): ?>selected<?php endif; ?>
                                                                        value="pic_weixin">微信相册发图</option>
                                                                        <option
                                                                        <?php if($list['type'] == 'location_select'): ?>selected<?php endif; ?>
                                                                        value="location_select">地理位置</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input style="width: 100%" class="form-control" type="text"
                                                                           value="<?php echo ($list["value"]); ?>" name="menu[<?php echo ($list["id"]); ?>][value]"
                                                                           placeholder="菜单值">
                                                                </td>
                                                                <input style="width: 100%" name="menu[<?php echo ($list["id"]); ?>][pid]" type="hidden"
                                                                       value="0">
                                                            </tr>
                                                            <!--父级操作-->

                                                            <?php if(is_array($c_lists)): $i = 0; $__LIST__ = $c_lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$clist): $mod = ($i % 2 );++$i; if($clist['pid'] == $list['id']): ?><tr role="row" class="  pmenu<?php echo ($list["id"]); ?> menu<?php echo ($clist["id"]); ?>">
                                                                        <td
                                                                        <?php if($clist['pid'] > 0): ?>style="padding-left: 5em"<?php endif; ?>
                                                                        >
                                                                        <input type="text" name="menu[<?php echo ($clist["id"]); ?>][name]"
                                                                               value="<?php echo ($clist["name"]); ?>" class="form-control"
                                                                               style="width: 75%;" placeholder="菜单名称"
                                                                               id="name-<?php echo ($clist["id"]); ?>">
                                                                        <!-- <a onclick="delmenu(<?php echo ($clist["id"]); ?>);" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>-->
                                                                        <a href="#myModal" data-toggle="modal"
                                                                           class="btn btn-danger del-good-attr"
                                                                           href="javascript:void(0)" data-id="<?php echo ($clist['id']); ?>"><i
                                                                                class="fa fa-trash-o"></i></a>
                                                                        </td>
                                                                        <td class="sorting_1">
                                                                            <select name="menu[<?php echo ($clist["id"]); ?>][type]" class="form-option"
                                                                                    style="width: 95%">
                                                                                <option
                                                                                <?php if($clist['type'] == 'view'): ?>selected<?php endif; ?>
                                                                                value="view">链接</option>
                                                                                <option
                                                                                <?php if($clist['type'] == 'click'): ?>selected<?php endif; ?>
                                                                                value="click">触发关键字</option>
                                                                                <option
                                                                                <?php if($clist['type'] == 'scancode_push'): ?>selected<?php endif; ?>
                                                                                value="scancode_push">扫码</option>
                                                                                <option
                                                                                <?php if($clist['type'] == 'scancode_waitmsg'): ?>selected<?php endif; ?>
                                                                                value="scancode_waitmsg"> 扫码（等待信息）</option>
                                                                                <option
                                                                                <?php if($clist['type'] == 'pic_sysphoto'): ?>selected<?php endif; ?>
                                                                                value="pic_sysphoto">系统拍照发图</option>
                                                                                <option
                                                                                <?php if($clist['type'] == 'pic_photo_or_album'): ?>selected<?php endif; ?>
                                                                                value="pic_photo_or_album">拍照或者相册发图</option>
                                                                                <option
                                                                                <?php if($clist['type'] == 'pic_weixin'): ?>selected<?php endif; ?>
                                                                                value="pic_weixin">微信相册发图</option>
                                                                                <option
                                                                                <?php if($clist['type'] == 'location_select'): ?>selected<?php endif; ?>
                                                                                value="location_select">地理位置</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <input style="width: 100%" type="text" class="form-control"
                                                                                   value="<?php echo ($clist["value"]); ?>"
                                                                                   name="menu[<?php echo ($clist["id"]); ?>][value]" placeholder="菜单值">
                                                                        </td>
                                                                        <input style="width: 100%" name="menu[<?php echo ($clist["id"]); ?>][pid]"
                                                                               type="hidden" value="<?php echo ($clist["pid"]); ?>">
                                                                    </tr><?php endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
                                                        </tbody>

                                                    </table>
                                                    <!-- Modal -->
                                                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                                                         id="myModal" class="modal fade">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button aria-hidden="true" data-dismiss="modal" class="close"
                                                                            type="button">×
                                                                    </button>
                                                                    <h4 class="modal-title">信息</h4>
                                                                </div>
                                                                <div class="modal-body" id="del_info">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                                            onclick="gettrue();"> 确定
                                                                    </button>
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                                                        取消
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- modal -->
                                                    <!--<button class="btn btn-primary " type="button" onclick="addpmenu()">-->
                                                        <!--<i class="fa fa-plus"></i>添加一级菜单-->
                                                    <!--</button>-->
                                                    <input type="hidden" name="wechat_id" value="<?php echo ($wechat_id); ?>">
                                                    <!--<button class="Preservation" type="submit">-->
                                                        <!--保存-->
                                                    <!--</button>-->
                                                </form>
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


<!-- Placed js at the end of the document so the pages load faster -->
<script src="<?php echo (JS); ?>/jquery-ui-1.9.2.custom.min.js"></script>
<script src="<?php echo (JS); ?>/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo (JS); ?>/bootstrap.min.js"></script>
<script src="<?php echo (JS); ?>/modernizr.min.js"></script>
<script src="<?php echo (JS); ?>/jquery.nicescroll.js"></script>

<!--dynamic table-->
<script type="text/javascript" language="javascript" src="<?php echo (JS); ?>/advanced-datatable/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo (JS); ?>/data-tables/DT_bootstrap.js"></script>
<!--dynamic table initialization -->
<script src="<?php echo (JS); ?>/dynamic_table_init.js"></script>

<!--common scripts for all pages-->
<script src="<?php echo (JS); ?>/scripts.js"></script>
<script>
    //切换公众号
    $("#select_wx").change(function () {
        var id = $(this).val();
        location.href = "<?php echo U('Wechat/menu/action/page_list');?>" + "/id/" + id;
    });
    //提交表单
    function submit() {
        document.getElementById("submit").submit();
    }
    //添加菜单
    var i = <?php echo ($max_id); ?>;
    function addpmenu() {
        var pmenu = $('.topmenu');
//    alert(pmenu.length);
        if (pmenu.length >= 3) {
            layer.msg('最多三个一级菜单', {icon: 2});  //alert('最多三个一级菜单');
            return;
        }
        i++;
        var id = i;
        var tpl = '<tr  role="row" class="  pmenu__id__ menu__id__"><td><input type="text" name="menu[__id__][name]" class="form-control" style="width: 73%;" value="" placeholder="菜单名称"><a onclick="addcmenu(__id__);" class="btn btn-primary"><i class="fa fa-plus"></i></a><a onclick="delmenu(__id__);" class="btn btn-danger"><i class="fa fa-trash-o"></i></a></td><td class="sorting_1"><select name="menu[__id__][type]" class="form-option" style="width: 95%"><option value="view">链接</option><option value="click">触发关键字</option><option value="scancode_push">扫码</option><option value="scancode_waitmsg"> 扫码（等待信息）</option><option value="pic_sysphoto">系统拍照发图</option><option value="pic_photo_or_album">拍照或者相册发图</option><option value="pic_weixin">微信相册发图</option><option value="location_select">地理位置</option></select></td><td><input style="width: 100%" class="form-control" type="text" value="" name="menu[__id__][value]" placeholder="菜单值"></td><input style="width: 100%" name="menu[__id__][pid]" type="hidden" value="0"></tr>';
        tpl = tpl.replace(/__id__/g, id);
        $('#tbody').append(tpl);
    }
    function addcmenu(pid) {
        var cmenu = $('.pmenu' + pid);
        if (cmenu.length >= 6) {
            layer.msg('一级菜单下最多5个二级菜单', {icon: 2});  //alert('一级菜单下最多5个二级菜单');
            return;
        }
        i++;
        var id = i;
        var tpl = '<tr role="row" class=" pmenu__pid__ menu__id__" ><td class="" style="padding-left: 4em"><input type="text" class="form-control" style="width: 85%;" name="menu[__id__][name]" value="" placeholder="菜单名称"><a onclick="delmenu(__id__);" class="btn btn-danger"><i class="fa fa-trash-o"></i></a></td><td class="sorting_1"><select  name="menu[__id__][type]" class="form-option" style="width: 95%"><option value="view">链接</option><option value="click">触发关键字</option><option value="scancode_push">扫码</option><option value="scancode_waitmsg"> 扫码（等待信息）</option><option value="pic_sysphoto">系统拍照发图</option><option value="pic_photo_or_album">拍照或者相册发图</option><option value="pic_weixin">微信相册发图</option><option value="location_select">地理位置</option></select></td><td><input style="width: 100%" type="text" value="" name="menu[__id__][value]" class="form-control" placeholder="菜单值"></td><input style="width: 100%" name="menu[__id__][pid]" type="hidden" value="__pid__"></tr>';
        tpl = tpl.replace(/__id__/g, id);
        tpl = tpl.replace(/__pid__/g, pid);
        $(cmenu.last()).after(tpl);
    }
    // 删除操作
    var menu_id;
    $('.del-good-attr').click(function () {
        menu_id = $(this).attr('data-id');
        $("#del_info").html("确定删除:  " + $("#name-" + menu_id).val() + " ?");
    });
    function gettrue() {
        delmenu(menu_id);
    }
    function delmenu(id) {
        $.ajax({
            url: '/index.php/Admin/Wechat/menu/action/del/id/' + id,
            type: 'get',
            success: function (data) {
                if (data == 'success') {
                    //删除子分类
                    $('.pmenu' + id).remove();
                    $('.menu' + id).remove();
                } else {
                    layer.msg('删除失败');
                }
            }
        });
        /*
         //删除子分类
         $('.pmenu'+id).remove();
         $('.menu'+id).remove();
         */
    }

</script>
</body>
</html>