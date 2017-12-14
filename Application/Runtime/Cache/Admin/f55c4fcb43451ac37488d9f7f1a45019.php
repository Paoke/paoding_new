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
    <link rel="stylesheet" href="/Public/js/cityselect/cityselect.css"/>
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

        .warn_msg {
            padding-left: 20px;
            color: red;
        }

        .alian {
            width: 100%;
            float: left;
        }

        .bllan {
            width: 24%;
            float: left;
            margin-right: 10px;
        }

        .state-overview .panel {
            padding: 10px 20px;
        }

        h4, .h4 {
            font-size: 18px;
            color: #0c0c0c;
        }

        .control-label input {
            width: 20px;
            height: 20px;
            background-color: #ffffff;
            border: solid 1px #dddddd;
            -webkit-border-radius: 50%;
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

        .control-label input:hover {
            cursor: pointer;
        }

        .control-label input:focus {
            outline: none !important;
        }

        .control-label input:checked {
            background-color: #03a9f4;
            border: solid 1px #03a9f4;
            text-align: center;
            background-clip: padding-box;
            border: none;
        }

        .control-label input:checked:before {
            content: '';
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
            transform: rotate(-45deg);
        }

        .control-label input:checked:after {
            content: '';
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
            transform: rotate(-45deg);
        }
    </style>
</head>

<body class="sticky-header">
<section>

    <div class="page-heading panel-title">

        <h3 id="article_title">
            <?php if(empty($info)): ?>标题
                <?php else: ?>
                <?php echo ($info["title"]); endif; ?>
        </h3>
        <ul class="breadcrumb">
            <li>发布人：
                <?php if(empty($info)): echo ($currentUser); ?>
                    <?php else: ?>
                    <?php echo ($info["create_user"]); endif; ?>
            </li>
            <li>发布时间：
                <?php if(empty($info)): echo ($currentDate); ?>
                    <?php else: ?>
                    <?php echo ($info["create_time"]); endif; ?>
            </li>
            <li>浏览数：<?php echo ($lead["data_id"]); ?></li>
        </ul>
    </div>

    <div class="main-content" width="100%" style="margin:0px;">
        <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <div class="panel-body">
                            <form class="form-horizontal " id="content_form"
                                  onkeydown="if(event.keyCode==13){return false;}">
                                <div class="col-md-12 ">
                                    <div class="form-group">
                                        <ul id="module" class="nav nav-tabs">
                                            <li class="active"><a href="#base" data-toggle="tab">内容编辑</a></li>
                                            <?php if(!empty($ifadd)): ?><li class="" onclick="loadComment('all');"><a href="#commentlist"  data-toggle="tab">评论管理</a>
                                                </li>
                                                <li class=""><a href="#log" data-toggle="tab" tab_index="3">操作记录</a>
                                                </li>
                                                <?php if($channel == hzjg): ?><li class=""><a href="#chart" data-toggle="tab" tab_index="4">应用事例</a>
                                                </li><?php endif; endif; ?>
                                            <?php if(is_array($child)): $i = 0; $__LIST__ = $child;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class=""
                                                    onclick="loadChannelChild('<?php echo ($vo["channel_index"]); ?>', '<?php echo ($vo["type"]); ?>');">
                                                    <a href="#child" data-toggle="tab"><?php echo ($vo["title"]); ?></a>
                                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-content">
                                    <div id="base" class="tab-pane active">
                                        <div class="edit_list no_edit ">
                                            <span>注意：需要设置审核状态为“已通过”以及启用状态为“启用”，用户才能查阅。</span>
                                            <div class="pull-right">
                                                <div class="btn-group">
                                                    <a id="postbutton" class="btn btn-default "
                                                       onclick="ajax_submit_form('content_form')"><i
                                                            class="fa fa-save"></i>保存
                                                    </a>
                                                    <a href="javascript:history.go(-1)" data-toggle="tooltip" title=""
                                                       class="btn btn-default"><i class="fa fa-reply"></i>返回</a>

                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <input type="hidden" id="id" name="id" value="<?php echo ($id); ?>">
                                        <input type="hidden" id="channel" name="channel" value="<?php echo ($channel); ?>">
                                        <?php if($is_bind_user == 1): ?><div class="form-group">
                                                <label class="col-sm-2 control-label">绑定用户：</label>
                                                <div class="col-sm-9">
                                                    <input name="bind_user_name" class="form-control form-option" style="float: left;" id="bind_user_name" value="" placeholder="用户名/昵称/手机/邮箱搜索" />&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <select name="bind_user_id" style="height: 34px;" id="bind_user_id" class="option">
                                                        <?php if($bind_user_id != 0): ?><option value=<?php echo ($bind_user_id); ?> >账号：<?php echo ($bind_user_name); ?></option>
                                                            <?php else: ?>
                                                            <option value="a">--请搜索后选择--</option><?php endif; ?>
                                                    </select>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <button class="btn btn-info" type="button" onclick="search_user();"/>搜索
                                                </div>
                                            </div><?php endif; ?>
                                        <?php if($jschannel == js): ?><div class="form-group">
                                                <label class="col-sm-2 control-label">所属专题：</label>
                                                <div class="col-sm-9">
                                                    <select class="small form-option" id="sszt" name="sszt"
                                                            style="font-size: 14px;">
                                                            <option value="0"></option>
                                                            <?php if(is_array($zutiData)): foreach($zutiData as $key=>$cat): ?><option value="<?php echo ($cat["id"]); ?>"
                                                                <?php if($cat["id"] == $info[sszt]): ?>selected<?php endif; ?>
                                                                ><?php echo ($cat["title"]); ?></option><?php endforeach; endif; ?>

                                                    </select>
                                                    <!--<?php if(empty($category_data)): ?>-->
                                                        <!--<span class="warn_msg">-->
                                                            <!--请先新增"栏目类别"-->
                                                        <!--</span>-->
                                                    <!--<?php endif; ?>-->
                                                </div>
                                            </div><?php endif; ?>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">栏目类别：</label>
                                            <div class="col-sm-9">
                                                <select class="small form-option" id="category_id" name="category_id"
                                                        style="font-size: 14px;">
                                                    <?php if(empty($category_data)): ?><option value="0">无</option>
                                                        <?php else: ?>
                                                        <?php if(is_array($category_data)): $i = 0; $__LIST__ = $category_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cat): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cat["id"]); ?>"
                                                            <?php if($cat["id"] == $info[category_id]): ?>selected<?php endif; ?>
                                                            ><?php echo ($cat["cat_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                                                </select>
                                                <?php if(empty($category_data)): ?><span class="warn_msg">
                                                        请先新增"栏目类别"
                                                    </span><?php endif; ?>
                                            </div>
                                        </div>
                                        <?php if($hzjg == js): ?><div class="form-group">
                                                <label class="col-sm-2 control-label">所属企业：</label>
                                                <div class="col-sm-9">
                                                    <select class="small form-option" id="hzjg_id" name="hzjg_id"
                                                            style="font-size: 14px;">
                                                        <option value="0"></option>
                                                        <?php if(is_array($data_hzjg)): foreach($data_hzjg as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"
                                                            <?php if($vo["id"] == $info['hzjg_id']): ?>selected<?php endif; ?>
                                                            ><?php echo ($vo["title"]); ?></option><?php endforeach; endif; ?>

                                                    </select>
                                                    <!--<?php if(empty($category_data)): ?>-->
                                                    <!--<span class="warn_msg">-->
                                                    <!--请先新增"栏目类别"-->
                                                    <!--</span>-->
                                                    <!--<?php endif; ?>-->
                                                </div>
                                            </div><?php endif; ?>
                                        <?php if($hzjg == jtgs): ?><input type="hidden" id="hzjg_id" name="hzjg_id" value="<?php echo ($info['hzjg_id']); ?>">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">会员：</label>
                                                <div class="col-sm-9">
                                                    <?php if(is_array($data_hzjg)): foreach($data_hzjg as $key=>$vo): ?><input type="checkbox" value="<?php echo ($vo["id"]); ?>" onchange="check(this)"
                                                        <?php
 for($i=0;$i<count($arrHzjg);$i++) { if($vo['id']==$arrHzjg[$i]){ echo checked; } } ?>/><?php echo ($vo["title"]); ?><br><?php endforeach; endif; ?>

                                                </div>
                                            </div><?php endif; ?>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">标签：</label>
                                            <div class="col-sm-9">
                                                <?php if($if_tags == 0): ?><label class=" control-label" style="color: red">暂无标签，请添加</label>
                                                    <?php else: ?>
                                                    <?php if(is_array($tags_info)): foreach($tags_info as $vokey=>$vo): ?><label class=" control-label" style=""><input name="tag_name[]"
                                                                                                      type="checkbox"
                                                                                                      value="<?php echo ($vo["id"]); ?>"
                                                            <?php if($vo["checked"] == 1): ?>checked="checked"<?php endif; ?>
                                                            />&nbsp<?php echo ($vo["tag_name"]); ?> &nbsp&nbsp&nbsp</label><?php endforeach; endif; endif; ?>

                                            </div>
                                        </div>
                                        <?php if($is_top == '1'): ?><div class="form-group">
                                            <label class="col-sm-2 control-label">属性：</label>
                                            <div class="col-sm-9">
                                                    <label class=" control-label" style="">
                                                        <input   name="is_red" id="is_red" type="checkbox" value=1
                                                        <?php if($data["is_red"] == '1'): ?>checked="checked"<?php endif; ?>
                                                        /> 置顶 </label>

                                            </div>
                                        </div><?php endif; ?>
                                        <div id="extends_div" class="extends_group">
                                        </div>
                                    </div>
                                    <div id="commentlist" class="tab-pane" style="display: none;">
                                        <div class="edit_list no_edit ">

                                            <div class="pull-left">
                                                <div class="nav">
                                                    <ul class="bn-headnav">
                                                        <li class="curr"><a href="javascript:;"
                                                                            onclick="loadComment('all');"><i
                                                                class="fa fa-bars"></i>全部</a></li>
                                                        <li><a href="javascript:;" onclick="loadComment(0);"><i
                                                                class="fa fa-thumbs-up"></i>已通过</a></li>
                                                        <li><a href="javascript:;" onclick="loadComment(1);"><i
                                                                class="fa fa-tag"></i>待审核</a></li>
                                                        <li><a href="javascript:;" onclick="loadComment(-1);"><i
                                                                class="fa fa-exclamation-triangle"></i>不通过</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="pull-right ">
                                                <span> 1.开启审核后用户评论需要审核才能显示。</span>
                                                <div class="btn-group">
                                                    <a id="btn_verify" class="btn  btn-default "><i
                                                            class="fa fa-lock"></i>开启审核</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="nav-button">

                                            </div>
                                        </div>
                                        <div class="comment-panel">
                                            <ul id="comment_data" class="activity-list">
                                            </ul>
                                        </div>
                                    </div>
                                    <div id="log" class="tab-pane">

                                        <table id="list-table" class="table table-bordered  table-striped" role="grid"
                                               aria-describedby="example1_info">
                                            <thead>
                                            <tr role="row" align="center">
                                                <td style="font-weight:bold; padding: 10px;text-align: left;">LogID</td>
                                                <td style="font-weight:bold;text-align: left;">用户ID</td>
                                                <td style="font-weight:bold;text-align: left;">昵称</td>
                                                <td style="font-weight:bold;text-align: left;">操作时间</td>
                                                <td style="font-weight:bold;text-align: left;">日志内容</td>
                                                <td style="font-weight:bold;text-align: left;">IP地址</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if(is_array($system_log)): foreach($system_log as $vokey=>$vo): ?><tr role="row" align="center">
                                                    <?php if(is_array($vo)): foreach($vo as $vokey1=>$vo1): ?><td style="padding: 10px; text-align: left;"><?php echo ($vo1); ?></td><?php endforeach; endif; ?>
                                                </tr><?php endforeach; endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="chart" class="tab-pane">
                                        <div class="pull-right">
                                            <div class="btn-group">
                                                <a  class="btn btn-default "
                                                   href="/index.php/Admin/Article/use_example/action/add?id=<?php echo ($id); ?>"><i class="fa fa-save"></i>增加事例
                                                </a>


                                            </div>
                                        </div>
                                        <table id="list-table" class="table table-bordered  table-striped" role="grid"
                                               aria-describedby="example1_info">
                                            <thead>
                                            <tr role="row" align="center">

                                                <td style="font-weight:bold; padding: 10px;text-align: left;">ID</td>
                                                <td style="font-weight:bold;text-align: left;">标题</td>
                                                <td style="font-weight:bold;text-align: left;">技术领域</td>
                                                <td style="font-weight:bold;text-align: left;">合作方式</td>
                                                <td style="font-weight:bold;text-align: left;">交付方式</td>
                                                <td style="font-weight:bold;text-align: left;">时间</td>
                                                <td style="font-weight:bold;text-align: left;">操作</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if(is_array($yysl)): foreach($yysl as $vokey=>$vo): ?><tr role="row" align="center">
                                                    <td style="padding: 10px; text-align: left;"><?php echo ($vo["id"]); ?></td>
                                                    <td style="padding: 10px; text-align: left;"><?php echo ($vo["title"]); ?></td>
                                                    <td style="padding: 10px; text-align: left;"><?php echo ($vo["jsly"]); ?></td>
                                                    <td style="padding: 10px; text-align: left;"><?php echo ($vo["hzfs"]); ?></td>
                                                    <td style="padding: 10px; text-align: left;"><?php echo ($vo["jffs"]); ?></td>
                                                    <td style="padding: 10px; text-align: left;"><?php echo ($vo["create_time"]); ?></td>
                                                    <td style="font-weight:bold;text-align: left;">
                                                        <div class="btn-group">
                                                            <a class="btn btn-default"
                                                               href="/index.php/Admin/Article/use_example/action/edit?id=<?php echo ($vo["id"]); ?>"
                                                               title="编辑"><i class="fa fa-pencil"></i></a>
                                                            <a  data-toggle="modal" class="btn btn-default"
                                                               data-name="" title="删除"
                                                               status=""
                                                               onclick="delModal('<?php echo ($vo["id"]); ?>')" id=""><i class="fa fa-trash-o"></i></a>
                                                        </div>
                                                    </td>
                                                </tr><?php endforeach; endif; ?>
                                            </tbody>
                                        </table>


                                    </div>
                                    <div id="child" class="tab-pane">
                                        <div class="edit_list no_edit ">

                                            <div class="pull-left">
                                                <h4>列表数据</h4>
                                            </div>
                                            <div class="pull-right ">

                                                <div class="btn-group">
                                                    <a id="add_child_data" class="btn  btn-default"><i class="fa fa-plus"></i>添加</a>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="child_channel" value="">
                                        <input type="hidden" id="child_type" value="">
                                        <table id="child-list-data" class="table table-bordered  table-striped" role="grid"
                                               aria-describedby="example1_info">
                                            <thead>
                                            <tr role="row" align="center">
                                                <td style="font-weight:bold; padding: 10px;text-align: left;" v-for="item in titles">{{item}}</td>
                                                <td style="font-weight:bold; padding: 10px;text-align: center;width: 100px">操作</td>
                                            </tr>
                                            </thead>
                                            <tbody id="data_body">

                                                <tr role="row" align="center" v-for="row in child_data">
                                                    <td style="padding: 10px; text-align: left;" v-for="item in row">{{item}}</td>
                                                    <td style="padding: 10px; text-align: left;">
                                                        <div class="btn-group">
                                                            <a class="btn btn-default btn-sm" @click="update_child(row.id)" title="更新">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                            <a class="btn btn-default btn-sm" @click="delete_child(row.id)" title="删除">
                                                                <i class="fa fa-trash-o"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                        <div class="col-md-12 text-center clearfix">
                                            <ul class="pagination">
                                                <li id="prev" class="prev disabled">
                                                    <a>
                                                        上一页
                                                    </a>
                                                </li>
                                                <li id="next" class="next disabled">
                                                    <a>
                                                        下一页
                                                    </a>
                                                </li>

                                            </ul>
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
<script src="<?php echo (JS); ?>/jquery-1.10.2.min.js"></script>
<script src="<?php echo (JS); ?>/jquery-ui-1.9.2.custom.min.js"></script>
<script src="<?php echo (JS); ?>/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo (JS); ?>/bootstrap.min.js"></script>
<script src="<?php echo (JS); ?>/modernizr.min.js"></script>
<script src="<?php echo (JS); ?>/jquery.nicescroll.js"></script>
<!-- <script src="/Public/js/layer/layer-min.js"></script> -->
<script src="/Public/js/layer/layer.js"></script>
<!--common scripts for all pages-->
<script src="<?php echo (JS); ?>/scripts.js"></script>
<!-- ueditor start-->
<script src="<?php echo (JS); ?>/ueditor/ueditor.config.js"></script>
<script src="<?php echo (JS); ?>/ueditor/ueditor.all.min.js"></script>
<script src="<?php echo (JS); ?>/ueditor/lang/zh-cn/zh-cn.js"></script>
<script src="<?php echo (JS); ?>/extends.js"></script>
<script src="<?php echo (JS); ?>/laydate/laydate.js"></script>
<script src="<?php echo (JS); ?>/Validform_v5.3.2_min.js"></script>
<script src="/Public/js/vue.js"></script>

<!-- ueditor end-->
<script type="text/javascript">


    $(function () {

        $('.bn-headnav ').on('click', 'li', function (ev) {
            $('.bn-headnav  li').removeClass('curr');
            $(this).addClass('curr');
        });
    });

    /**
     * 初始化编辑工具
     */
    window.UEDITOR_HOME_URL = "<?php echo (JS); ?>/ueditor/";
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
        if ($("#category_id").val() == null || $("#category_id").val() == 0) {
            layer.alert('请新增并选择栏目类别，再提交内容', {icon: 2});
            return;
        }

        if (!form_check.check()) {
            layer.alert('请正确填写内容信息，再提交!', {icon: 2});
            return;
        }

        if ($("#content").length > 0) {
            var desc = UE.getEditor('content').getContentTxt().substr(0, 50) + '...';
            if ($("#desc").val() == undefined) {
                $("#" + form_id).append('<input type="hidden" name="desc" value="' + desc + '">');
            } else if ($("#desc").val() == null || $("#desc").val() == '') {
                $("#desc").val(desc);
            }
        }
        //判断id值是否存在
        var id = $("#id").val();
        var ifadd = "<?php echo ($ifadd); ?>";
        var action = '';
        if (ifadd == '') {
            //不存在，表示添加
            action = "/index.php/Admin/Article/article/action/add/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>/iscopy/<?php echo ($iscopy); ?>";
        } else if (ifadd == 'b') {
            //存在，表示编辑
            action = "/index.php/Admin/Article/article/action/edit/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>/id/<?php echo ($id); ?>";
        }
        var data=$('#' + form_id).serialize();
        //异步提交表单数据
        $.ajax({
            type: "post",
            url: action,
            data: data,
            dataType: 'json',
            success: function (res) {
                if (res.result == 1) {
                    setTimeout(function () {
                        window.location.href = "/index.php/Admin/Article/article/action/page_list/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>/page_now/<?php echo ($page_now); ?>/page_num/<?php echo ($page_num); ?>/category_id/<?php echo ($category_id); ?>/keyword/<?php echo ($keyword); ?>";
                    }, 1000);
                }
                if (res.result == 0) {
                    layer.msg(res.msg);
                }
            }
        })
    }


    function showImg(img_path) {
        $("#cover_url").val(img_path);
        $(".img_box").empty();
        $(".img_box").append('<img src="' + img_path + '">');
    }

    var form_check = null;
    $(function () {
        var url = "/index.php/Admin/Article/article/action/extends/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>/id/<?php echo ($id); ?>";
        var id = $("#id").val();
        var site = "<?php echo session('site_name');?>";
        loadExtends(site, url, id, 'extends_div');

        $("#feiyong").bind('keyup', function () {

            var value = $(this).val();

            value = value.replace(/[^0-9.]/g, '');

            $(this).val(value);
        });
        $("#youxiaoqi").bind('keyup', function () {

            var value = $(this).val();

            value = value.replace(/[^0-9.]/g, '');

            $(this).val(value);
        });

        form_check = $('#content_form').Validform({
            tiptype: 3,
            postonce: true
        });

        $("#title").blur(function () {

            var title = $(this).val();
            if (title != null && title != '') {
                $("#article_title").text(title);
            } else {
                $("#article_title").text('标题');
            }
        });


        $("#btn_verify").click(function () {
            if ($(this).text() == "开启审核") {
                $(this).html("<i class='fa fa-unlock'></i>关闭审核");
            }
            else {
                $(this).html("<i class='fa fa-lock'></i>开启审核");
            }


        });

    });

    function loadComment(sta1) {
        var url = "/index.php/Admin/Comment/channelComment/action/page_list/channel/<?php echo ($channel); ?>/data_id/<?php echo ($id); ?>/status/" + sta1;
        $.post(url, null, function (ret) {
            if (ret.result == 1) {
                $("#comment_data").empty();
                // $(ret.data).each(function(name, value){
                var data = ret.data;
                for (var key in data) {
                    var value = data[key];

                    var feedbackUrl = "";
                    var checkUrl = "";
                    var delUrl = "";

                    var rowLi = $('<li></li>');
                    var root_avatar = '<div class="avatar"><img src="' + value.comment_headimg + '" alt=""></div>';
                    var root_desk = '<div class="activity-desk"><h5><a href="#">' + value.comment_user_nickname + '：</a> <span>' + value.content + '</span></h5>' +
                            '<p class="text-muted"></p><div class="pull-left text-muted">【<i class="fa fa-thumbs-up"></i>' +
                            value.status +
                            '】 ' + value.comment_time + '</div>' +
                            '<div class="pull-right"><div class="btn-group">' +
                            '<a class="btn btn-default" href="javascript:;" title="回复"><i class="fa fa-pencil"></i>回复</a>' +
                            '<a href="javascript:;"  class="btn btn-default check_btn" title="审核"><i class="fa fa-check-square"></i>审核</a>' +
                            '<a href="javascript:;" class="btn btn-default" title="删除" ><i class="fa fa-trash-o"></i>删除</a>' +
                            '</div></div><p></p></div>';

                    rowLi.append(root_avatar);
                    rowLi.append(root_desk);


                    if (value._child != null) {

                        var child = $('<div class="comment-panel"><ul class="activity-list"></ul></div>');
                        appendFeedBack(child, value._child);

                        rowLi.append(child);
                    }

                    $("#comment_data").append(rowLi);

                    $('.check_btn').click(function () {

                        layer.msg('审核操作', {
                            btn: ['待审核', '通过', '不通过']
                        });
                        // 按钮1
                        $('.layui-layer-btn0').click(function (event) {
                            layer.msg('待审核')
                        });

                        // 按钮2
                        $('.layui-layer-btn1').click(function (event) {
                            layer.msg('通过')
                        });

                        // 按钮3
                        $('.layui-layer-btn2').click(function (event) {
                            layer.msg('不通过')
                        });
                    })

                }

                $("#commentlist").show();
                $('.sticky-header').css('overflow-y', 'auto');
                //$('.sticky-header').niceScroll();

            }

        }, 'json');


    }

    function appendFeedBack(ele, feedback) {

        $(feedback).each(function (i, item) {
            var content = '<li><div class="avatar"><img src="' + item.feedback_headimg + '" alt=""></div>' +
                    '<div class="activity-desk"><h5><a href="#">' + item.feedback_user_name + '@' + item.comment_user_nickname + '</a> <span>' + item.content + '</span></h5>' +
                    '<p class="text-muted"></p><div class="pull-left">' + item.feedback_time + '</div>' +
                    '<div class="pull-right"><div class="btn-group">' +
                    '<a class="btn btn-default" href="" title="回复"><i class="fa fa-pencil"></i>回复</a>' +
                    '<a href="" class="btn btn-default" title="审核"><i class="fa fa-check-square"></i>审核</a>' +
                    '<a href="" class="btn btn-default" title="删除" ><i class="fa fa-trash-o"></i>删除</a>' +
                    '</div></div><p></p></div></li>';
            ele.append(content);


            if (item._child != null) {
                appendFeedBack(ele, item._child);
            }
        });

    }

    function loadChannelChild(channel, type){
        if(child_win != null){
            layer.close(child_win);
        }
        layer.load(2);
        vm.page_now = 1;
        vm.child_data = [];
        getChildData(channel, type);
    }

    var child_win = null;
    var vm = new Vue({
        el: "#child",
        data:{
            titles: [],
            child_data:[],
            page_now:1,
            page_num:8
        },
        methods:{
            update_child : function(id){
                var channel = $("#child_channel").val();
                var type = $("#child_type").val();
                var title = "修改数据";
                var url = "/index.php/Admin/ChannelData/child_module/action/page_edit/channel/"+channel+"/type/"+type+"/id/"+id;

                child_win = layer_window(title, url);
            },
            delete_child : function(id){
                var index = layer.confirm('请确认是否删除该数据?', {
                    btn: ['确认','取消'] //按钮
                }, function(){
                    del_child(id);
                }, function(){
                    layer.close(index);
                });
            }

        }
    });
    function del_child(id){
        var channel = $("#child_channel").val();
        var type = $("#child_type").val();
        var url = "/index.php/Admin/ChannelData/child_module/action/del/channel/"+channel+"/type/"+type+"/id/"+id;
        $.get(url, function(ret){
            layer.msg(ret.msg);
            if(ret.result == 1){
                setTimeout(function(){
                    vm.page_now = 1;
                    var channel = $("#child_channel").val();
                    var type = $("#child_type").val();
                    getChildData(channel, type);
                },1500);

            }
        });
    }

    function getChildData(channel, type){
        var data_id = $("#id").val();
        var url = "/index.php/Admin/ChannelData/child_module/action/page_list/channel/"+channel+"/type/"+type+"/data_id/"+data_id;
        var data = {'page_num': vm.page_num, 'page_now': vm.page_now};
        $.post(url, data, function(ret){
            $("#child_channel").val(channel);
            $("#child_type").val(type);
            layer.closeAll();
            if(ret.result == 1){
                // alert(JSON.stringify(ret.data.list));
                vm.titles = ret.data.titles;
                vm.child_data = ret.data.list;
                vm.page_now = parseInt(ret.data.page.now);
                init_page(ret.data.page);
            }
        });
    }

    function init_page(page){
        if(page.now > 0 && page.total > 0){

            if(page.now == 1 && page.now != page.total){ //首页
                page_active('prev', 0, -1);//上一页
                page_active('next', 1, 1);//下一页
            }else if(page.now != 1 && page.now == page.total){ //尾页
                page_active('prev', 1, -1);//上一页
                page_active('next', 0, 1);//下一页
            }else if(page.now == 1 && page.now == page.total){
                page_active('prev', 0, -1);//上一页
                page_active('next', 0, 1);//下一页
            }else if(page.total > 2){
                page_active('prev', 1, -1);//上一页
                page_active('next', 1, 1);//下一页
            }
        }else{
            page_active('prev', 0, -1);//上一页
            page_active('next', 0, 1);//下一页
        }
    }
    /*
     * 是否激活
     * @param state 0:关闭，1：激活
     * **/
    function page_active(id, state, v){
        if(state == 1){
            $("#"+id).removeClass('disabled');
            $("#"+id).click(function(){
                go_page(v);
            });
        }else{
            $("#"+id).addClass('disabled');
            $("#"+id).unbind('click');
        }
    }

    function go_page(v){
        layer.load(2);
        vm.page_now = parseInt(v) + vm.page_now;
        var channel = $("#child_channel").val();
        var type = $("#child_type").val();
        getChildData(channel, type);
    }

    $("#add_child_data").click(function(){

        var channel = $("#child_channel").val();
        var type = $("#child_type").val();
        var data_id = $("#id").val();
        var title = "添加数据";
        var url = "/index.php/Admin/ChannelData/child_module/action/page_add/channel/"+channel+"/type/"+type+"/data_id/"+data_id;

        child_win = layer_window(title, url);
    });

    // 搜索用户
    function search_user()
    {
        var user_name = $('#bind_user_name').val();
        if($.trim(user_name) == '')
            return false;

        $.ajax({
            type : "POST",
            url:"/index.php?m=Admin&c=User&a=search_user",//+tab,
            data :{search_key:$('#bind_user_name').val()},// 你的formid
            success: function(data){
                if(!data)
                    data= '<option value="n">--没有搜索结果--</option>';
                $('#bind_user_id').html(data);
            }
        });
    }

    function delModal(id) {
        $.ajax({
            type : "GET",
            url:"/index.php/Admin/Article/use_example/action/delete?id="+id,//+tab,
            success: function(res){
                if(res.result=='1'){
                    alert('删除成功');
                    window.location.reload();
                }else{
                    alert('删除失败');
                }
            }
        });

    }

    function check(id) {
        $hzjg_id=$("#hzjg_id").val();
        $id=$(id).val();
        if($hzjg_id==null||$hzjg_id==""){
            $hzjg_id=$id;
        }else{
            $hzjg_id=$hzjg_id+','+$id;
        }
        $("#hzjg_id").val($hzjg_id);

    }
</script>
</body>
</html>