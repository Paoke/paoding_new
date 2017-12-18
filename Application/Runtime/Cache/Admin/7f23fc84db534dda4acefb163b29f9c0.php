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
        .text_group{

            font-family: 'Arial Normal', 'Arial';
            font-weight: 400;
            line-height: normal;
            float: left;
            overflow: hidden;
            width: 10%;
        }
        .text_title{
            font-size: 12px;
            color: #999999;
        }
        .text_content{

            font-weight: 400;
            font-size: 23px;
            color: #333333;
            text-align: left;

        }
        .img{
            float: left;
            overflow: hidden;
        }
        .part_bar{
            font-size: 16px;
            font-weight: bold;
            color: black;
            width: 100%;
        }
        .bar-img{
            width: 15px;
            height: 15px;
            float: left;
            margin-top: 8px;
            margin-right: 10px;
        }
        .link{
            color: #428bca;
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
    </style>
</head>

<body class="sticky-header">
<section>

    <div class="page-heading panel-title">

        <h3 id="activity_title">
            <?php if(empty($info)): ?>标题
                <?php else: echo ($info["title"]); endif; ?>
        </h3>
        <ul class="breadcrumb">
            <li>发布人：
                <?php if(empty($info)): echo ($currentUser); ?>
                    <?php else: echo ($info["create_user"]); endif; ?></li>
            <li>发布时间：
                <?php if(empty($info)): echo ($currentDate); ?>
                    <?php else: echo ($info["create_time"]); endif; ?></li>
            <li>浏览数：<?php echo ($lead["data_id"]); ?></li>
        </ul>
    </div>

    <div class="main-content" width="100%" style="margin:0px;">
        <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <div class="panel-body">
                            <form class="form-horizontal " id="content_form" onkeydown="if(event.keyCode==13){return false;}">
                                <div class="col-md-12 ">
                                    <div class="form-group">
                                        <ul id="module" class="nav nav-tabs">
                                            <li class="active"><a href="#base" data-toggle="tab">内容编辑</a></li>
                                            <?php if(!empty($info)): ?><li class="" onclick="loadComment();"><a href="#commentlist" data-toggle="tab">评论管理</a></li>
                                                <li class=""><a href="#log" data-toggle="tab" tab_index="3">操作记录</a></li>
                                                <li class=""><a href="#apply" data-toggle="tab">报名管理</a></li>
                                                <!--<li class=""><a href="#chart" data-toggle="tab" tab_index="4">访问统计</a></li>--><?php endif; ?>
                                            <?php if(is_array($child)): $i = 0; $__LIST__ = $child;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class=""
                                                    onclick="loadChannelChild('<?php echo ($vo["channel_index"]); ?>', '<?php echo ($vo["type"]); ?>');">
                                                    <a href="#child" data-toggle="tab"><?php echo ($vo["title"]); ?></a>
                                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-content" >
                                    <div id="base" class="tab-pane active">
                                        <div class="edit_list no_edit">
                                            <span>注意：需要设置审核状态为“已通过”以及启用状态为“启用”，用户才能查阅。</span>
                                            <div class="pull-right">
                                                <div class="btn-group">
                                                    <a id="postbutton" class="btn btn-default "
                                                       onclick="ajax_submit_form('content_form')"><i class="fa fa-save"></i>保存
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
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">栏目类别：</label>
                                            <div class="col-sm-9">
                                                <select class="small form-option" id="category_id" name="category_id" style="font-size: 14px;">
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
                                        <div class="form-group" style="display: none">

                                            <label class="col-sm-2 control-label">审核状态：</label>
                                            <div class="col-sm-9">
                                                <!--<label class=" control-label" id="status" name="status">-->
                                                    <!--<input  type="radio" name="status"  value="1">启用-->
                                                <!--</label>-->
                                                <!--<label class=" control-label" id="status" name="status">-->
                                                    <!--<input  type="radio"  name="status"  value="0">禁止-->
                                                <!--</label>-->

                                                <select class="small form-option" id="status" name="status" style="font-size: 14px;">

                                                    <option value ="1">&nbsp;待审核</option>
                                                    <option value ="0">&nbsp;已发布</option>
                                                    <option value ="-1">&nbsp;不通过</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">

                                            <label class="col-sm-2 control-label">标签：</label>
                                            <div class="col-sm-9">
                                                <?php if($if_tags == 0): ?><label class=" control-label" style="color: red">暂无标签，请添加</label>
                                                    <?php else: ?>
                                                    <?php if(is_array($tags_info)): foreach($tags_info as $vokey=>$vo): ?><label class=" control-label" style="">
                                                            <input name="tag_name[]" id="tag_name" type="checkbox" value="<?php echo ($vo["id"]); ?>"
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
                                    <div id="apply" class="tab-pane">
                                        <div class="edit_list no_edit ">

                                            <div class="pull-left" style="clear: both;width: 70%;padding-left: 25px">
                                                <div class="text_group">
                                                    <div class="text_title">
                                                        <p><span>提交报名</span></p>
                                                    </div>
                                                    <div class="text_content">
                                                        <p><span><?php echo ($countArr["submit_apply"]); ?></span></p>
                                                    </div>
                                                </div>
                                                <!--<img class="img" src="/Public/images/split.png">-->
                                                <div class="text_group">
                                                    <div class="text_title">
                                                        <p><span>待审核</span></p>
                                                    </div>
                                                    <div class="text_content">
                                                        <p><span id="wait_audit_count"><?php echo ($countArr["wait_audit"]); ?></span></p>
                                                    </div>
                                                </div>
                                                <!--<img class="img" src="/Public/images/split.png">-->
                                                <div class="text_group">
                                                    <div class="text_title">
                                                        <p><span>报名人数</span></p>
                                                    </div>
                                                    <div class="text_content">
                                                        <p><span><?php echo ($countArr["apply_success"]); ?></span></p>
                                                    </div>
                                                </div>
                                                <!--<img class="img" src="/Public/images/split.png">-->
                                                <div class="text_group">
                                                    <div class="text_title">
                                                        <p><span>已取消</span></p>
                                                    </div>
                                                    <div class="text_content">
                                                        <p><span><?php echo ($countArr["cancel"]); ?></span></p>
                                                    </div>
                                                </div>
                                                <!--<img class="img" src="/Public/images/split.png">-->
                                                <div class="text_group">
                                                    <div class="text_title">
                                                        <p><span>待支付</span></p>
                                                    </div>
                                                    <div class="text_content">
                                                        <p><span id="not_pay_count"><?php echo ($countArr["not_pay"]); ?></span></p>
                                                    </div>
                                                </div>
                                                <!--<img class="img" src="/Public/images/split.png">-->
                                                <div class="text_group">
                                                    <div class="text_title">
                                                        <p><span>未通过</span></p>
                                                    </div>
                                                    <div class="text_content">
                                                        <p><span id="not_pass_count"><?php echo ($countArr["not_pass"]); ?></span></p>
                                                    </div>
                                                </div>
                                                <!--<img class="img" src="/Public/images/split.png">-->
                                                <div class="text_group">
                                                    <div class="text_title">
                                                        <p><span>活动收入(元)</span></p>
                                                    </div>
                                                    <div class="text_content">
                                                        <p><span><?php echo ($countArr["total_amount"]); ?></span></p>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="pull-left" style="clear: both;width: 70%;padding-left: 25px">
                                                <div class="text_group">
                                                    <div class="text_title">
                                                        <p><span>应签到</span></p>
                                                    </div>
                                                    <div class="text_content">
                                                        <p><span><?php echo ($countArr["should_sign"]); ?></span></p>
                                                    </div>
                                                </div>
                                                <!--<img class="img" src="/Public/images/split.png">-->
                                                <div class="text_group">
                                                    <div class="text_title">
                                                        <p><span>已签到</span></p>
                                                    </div>
                                                    <div class="text_content">
                                                        <p><span><?php echo ($countArr["sign_success"]); ?></span></p>
                                                    </div>
                                                </div>
                                                <!--<img class="img" src="/Public/images/split.png">-->
                                                <div class="text_group">
                                                    <div class="text_title">
                                                        <p><span>未签到</span></p>
                                                    </div>
                                                    <div class="text_content">
                                                        <p><span><?php echo ($countArr["not_sign"]); ?></span></p>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="panel-body " style="margin:10px;">
                                            <input type="hidden" id="page_now" value="1">
                                            <input type="hidden" id="page_count" value="<?php echo ($countArr["page_count"]); ?>">
                                            <table id="apply_table" class="table table-bordered  table-striped" role="grid"
                                                   aria-describedby="example1_info">
                                                <thead>
                                                <tr role="row" align="center">
                                                    <td style="font-weight:bold; padding: 10px;text-align: left;">ID</td>
                                                    <td style="font-weight:bold;text-align: left;">姓名</td>
                                                    <td style="font-weight:bold;text-align: left;">手机号码</td>
                                                    <td style="font-weight:bold;text-align: left;">订单号码</td>
                                                    <td style="font-weight:bold;text-align: left;">报名费用</td>
                                                    <td style="font-weight:bold;text-align: left;">报名状态</td>
                                                    <td style="font-weight:bold;text-align: left;">支付状态</td>
                                                    <td style="font-weight:bold;text-align: left;">签到状态</td>
                                                    <td style="font-weight:bold;text-align: left;">报名审核</td>
                                                    <!--<td style="font-weight:bold;text-align: left;">操作</td>-->
                                                </tr>
                                                </thead>
                                                <tbody id="order_tbody">
                                                <?php if(is_array($order_list)): $i = 0; $__LIST__ = $order_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$order): $mod = ($i % 2 );++$i;?><tr  role="row" align="center">
                                                        <td style="padding: 10px;text-align: left;"><?php echo ($order["order_id"]); ?></td>
                                                        <td style="padding: 10px;text-align: left;"><?php echo ($order["name"]); ?></td>
                                                        <td style="padding: 10px;text-align: left;"><?php echo ($order["mobile"]); ?></td>
                                                        <td style="padding: 10px;text-align: left;"><?php echo ($order["order_sn"]); ?></td>
                                                        <td style="padding: 10px;text-align: left;"><?php echo ($order["total_amount"]); ?></td>
                                                        <td style="padding: 10px;text-align: left;"  id="apply_status_<?php echo ($order["order_id"]); ?>">
                                                            <?php if($order["order_status"] == -1): ?>待审核
                                                                <?php elseif($order["order_status"] == 0): ?>待支付
                                                                <?php elseif($order["order_status"] == 1): ?>待参与
                                                                <?php elseif($order["order_status"] == 2): ?>已参与
                                                                <?php elseif($order["order_status"] == 3): ?>已评价
                                                                <?php elseif($order["order_status"] == 4): ?>已取消
                                                                <?php elseif($order["order_status"] == 5): ?>不通过
                                                                <?php elseif($order["order_status"] == 6): ?>退款中
                                                                <?php elseif($order["order_status"] == 7): ?>已退款
                                                                <?php else: endif; ?>
                                                        </td>
                                                        <td style="padding: 10px;text-align: left;" id="pay_status_<?php echo ($order["order_id"]); ?>">
                                                            <?php if($order["pay_status"] == 0): ?>未支付
                                                                <?php elseif($order["pay_status"] == 1): ?>已支付
                                                                <?php else: endif; ?>

                                                        </td>
                                                        <td style="padding: 10px;text-align: left;">
                                                            <?php if($order["sign_status"] == 1): ?>已签到
                                                                <?php elseif($order["sign_status"] == 0): ?>未签到<?php endif; ?>
                                                        </td>
                                                        <td style="padding: 10px;text-align: left;" id="approve_<?php echo ($order["order_id"]); ?>">
                                                            <?php if($order["order_status"] == -1): ?><a class="link" onclick="approve('<?php echo ($order["order_id"]); ?>',0);">通过</a> / <a class="link" onclick="approve('<?php echo ($order["order_id"]); ?>',4)">拒绝</a>
                                                                <?php else: ?>——<?php endif; ?>
                                                        </td>
                                                        <!--<td style="padding: 10px;text-align: left;"><a class="link">详情</a></td>-->
                                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                                </tbody>
                                            </table>
                                            <div class="col-md-12 text-center clearfix">
                                                <ul class="pagination" id="pagination">
                                                    <?php if($page_now == 1): ?><!-- 上一页 -->
                                                        <li class="prev disabled">
                                                            <a href="#">
                                                                上一页
                                                            </a>
                                                        </li>
                                                        <?php else: ?>
                                                        <li class="prev">
                                                            <a href="/index.php/Admin/Activity/activity/action/page_edit/page_now/<?php echo ($page_now-1); ?>/page_num/<?php echo ($page_num); ?>">
                                                                上一页
                                                            </a>
                                                        </li><?php endif; ?>
                                                    <?php if(($page_now != $page)): ?><!-- 下一页 -->
                                                        <li class="next ">
                                                            <a href="/index.php/Admin/Admin/Activity/activity/action/page_edit/page_now/<?php echo ($page_now+1); ?>/page_num/<?php echo ($page_num); ?>">
                                                                下一页
                                                            </a>

                                                        </li>
                                                        <?php else: ?>
                                                        <li class="next disabled">
                                                            <a href="#">
                                                                下一页
                                                            </a>
                                                        </li><?php endif; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="commentlist" class="tab-pane" style="display: none;">
                                        <div class="edit_list no_edit ">

                                            <div class="pull-left">
                                                <div class="nav">
                                                    <ul class="bn-headnav">
                                                        <li class="curr"><a href="javascript:;"><i class="fa fa-bars"></i>全部</a></li>
                                                        <li><a href="javascript:;"><i class="fa fa-thumbs-up"></i>已通过</a></li>
                                                        <li><a href="javascript:;"><i class="fa fa-tag"></i>待审核</a></li>
                                                        <li><a href="javascript:;"><i class="fa fa-exclamation-triangle"></i>不通过</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="pull-right ">
                                                <span> 1.开启审核后用户评论需要审核才能显示。</span>
                                                <div class="btn-group">
                                                    <a  id="btn_verify" class="btn  btn-default "><i class="fa fa-lock"></i>开启审核</a>
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
                                        <table class="table table-bordered table-hover" role="grid"
                                               aria-describedby="example1_info">
                                            <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
                                        </table>
                                        <div id="main" style="width:600px;height:400px;"></div>
                                        <script type="text/javascript">
                                            // 基于准备好的dom，初始化echarts实例
                                            var myChart = echarts.init(document.getElementById('main'));
                                            // 指定图表的配置项和数据
                                            var option = {
                                                title: {
                                                    text: '统计数据示例'
                                                },
                                                tooltip: {},
                                                legend: {
                                                    data: ['销量']
                                                },
                                                xAxis: {
                                                    data: ["衬衫", "羊毛衫", "雪纺衫", "裤子", "高跟鞋", "袜子"]
                                                },
                                                yAxis: {},
                                                series: [{
                                                    name: '销量',
                                                    type: 'bar',
                                                    data: [5, 20, 36, 10, 10, 20]
                                                }]
                                            };

                                            // 使用刚指定的配置项和数据显示图表。
                                            myChart.setOption(option);


                                        </script>
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
        if($("#category_id").val() == null || $("#category_id").val() == 0){
            layer.alert('请新增并选择栏目类别，再提交内容', {icon : 2});
            return;
        }

        if(!form_check.check()){
            layer.alert('请正确填写内容信息，再提交!', {icon : 2});
            return;
        }

        if($("#content") != undefined && $("#content") != null){
            var desc = UE.getEditor('content').getContentTxt().substr(0,50) + '...';
            if($("#desc").val() == undefined){
                $("#"+form_id).append('<input type="hidden" name="desc" value="'+desc+'">');
            }else if($("#desc").val() == null || $("#desc").val() == ''){
                $("#desc").val(desc);
            }
        }

        //判断id值是否存在
        var id = $("#id").val();

        var ifadd = "<?php echo ($ifadd); ?>";
        var action = '';
        if (ifadd == '') {
            //不存在，表示添加
            action = "/index.php/Admin/Activity/activity/action/add/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>";
        } else if(ifadd == 'b') {
            //存在，表示编辑
            action = "/index.php/Admin/Activity/activity/action/edit/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>/id/<?php echo ($id); ?>";
        }

        //异步提交表单数据
        $.ajax({
            type: "post",
            url: action,
            data: $('#' + form_id).serialize(),
            dataType: 'json',
            success: function (res) {
               // alert(JSON.stringify(res));
                if (res.result == 1) {
                    layer.msg(res.msg);
                    setTimeout(function () {
                        window.location.href = "/index.php/Admin/Activity/activity/action/page_list/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>/page_now/<?php echo ($page_now); ?>/page_num/<?php echo ($page_num); ?>";
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
    $(function(){
        var url = "/index.php/Admin/Activity/activity/action/extends/channel/<?php echo ($channel); ?>/type/<?php echo ($type); ?>/id/<?php echo ($id); ?>";
        var id = $("#id").val();
        var site = "<?php echo session('site_name');?>";
        loadExtends(site, url, id, 'extends_div');

        form_check = $('#content_form').Validform({
            tiptype: 3,
            postonce: true
        });

        $("#title").blur(function(){

            var title = $(this).val();
            if(title != null && title != ''){
                $("#activity_title").text(title);
            }else{
                $("#activity_title").text('标题');
            }
        });


        $("#btn_verify").click(function(){
            if($(this).text()=="开启审核")
            {
                $(this).html("<i class='fa fa-unlock'></i>关闭审核");
            }
            else
            {
                $(this).html("<i class='fa fa-lock'></i>开启审核");
            }



        });

    });

    function loadComment(){
        var url = "/index.php/Admin/Comment/channelComment/action/page_list/channel/<?php echo ($channel); ?>/data_id/<?php echo ($id); ?>";
        $.post(url, null, function(ret){
            if(ret.result == 1){
                $("#comment_data").empty();
                // $(ret.data).each(function(name, value){
                var data = ret.data;
                for( var key in data){
                    var value = data[key];

                    var feedbackUrl = "";
                    var checkUrl = "";
                    var delUrl = "";

                    var rowLi = $('<li></li>');
                    var root_avatar = '<div class="avatar"><img src="'+value.comment_headimg+'" alt=""></div>';
                    var root_desk = '<div class="activity-desk"><h5><a href="#">'+value.comment_user_nickname+'：</a> <span>'+value.content+'</span></h5>'+
                            '<p class="text-muted"></p><div class="pull-left text-muted">【<i class="fa fa-thumbs-up"></i>已审核】 '+value.comment_time+'</div>'+
                            '<div class="pull-right"><div class="btn-group">'+
                            '<a class="btn btn-default" href="'+feedbackUrl+'" title="回复"><i class="fa fa-pencil"></i>回复</a>'+
                            '<a href="'+checkUrl+'" id="audit_btn" class="btn btn-default" title="审核"><i class="fa fa-check-square"></i>审核</a>'+
                            '<a href="'+delUrl+'" class="btn btn-default" title="删除" ><i class="fa fa-trash-o"></i>删除</a>'+
                            '</div></div><p></p></div>';

                    rowLi.append(root_avatar);
                    rowLi.append(root_desk);

                    if(value._child != null){

                        var child = $('<div class="comment-panel"><ul class="activity-list"></ul></div>');
                        appendFeedBack(child, value._child);

                        rowLi.append(child);
                    }

                    $("#comment_data").append(rowLi);

                }

                $("#commentlist").show();
                $('.sticky-header').css('overflow-y', 'auto');
                //$('.sticky-header').niceScroll();

            }

        }, 'json');


    }


    function appendFeedBack(ele, feedback){

        $(feedback).each(function (i, item) {
            var content = '<li><div class="avatar"><img src="'+item.feedback_headimg+'" alt=""></div>'+
                    '<div class="activity-desk"><h5><a href="#">'+item.feedback_user_name+'@'+item.comment_user_nickname+'</a> <span>'+item.content+'</span></h5>'+
                    '<p class="text-muted"></p><div class="pull-left">'+item.feedback_time+'</div>'+
                    '<div class="pull-right"><div class="btn-group">'+
                    '<a class="btn btn-default" href="" title="回复"><i class="fa fa-pencil"></i>回复</a>'+
                    '<a href="" class="btn btn-default" title="审核"><i class="fa fa-check-square"></i>审核</a>'+
                    '<a href="" class="btn btn-default" title="删除" ><i class="fa fa-trash-o"></i>删除</a>'+
                    '</div></div><p></p></div></li>';
            ele.append(content);

            if(item._child != null){
                appendFeedBack(ele, item._child);
            }
        });

    }


</script>
</body>
</html>


<script type="text/javascript">
    $('#audit_btn').click(function(event) {
        layer.confirm('管理员审核操作！', {
            btn: ['通过','不通过'] //按钮
        }, function(){
            layer.msg('已通过', {icon: 1});
        }, function(){
            layer.msg('不通过');
        })
    });


    function approve(id, status){


        var url = "/index.php/Admin/Activity/activity_order/action/update/id/"+id;
        var data = {"field": 'order_status', "value": status};

        var wait_audit_count = parseInt($("#wait_audit_count").text().trim());
        var not_pay_count = parseInt($("#not_pay_count").text().trim());

        $.post(url, data, function(ret){
            // alert(JSON.stringify(ret));
            if(ret.result == 1){
                $("#wait_audit_count").text(wait_audit_count-1)
                if(status == 4){
                    $("#apply_status_"+id).text("未通过");

                }else if(status == 0){

                    $("#not_pay_count").text(1+not_pay_count)

                    $("#apply_status_"+id).text("待支付");
                    $("#pay_status_"+id).text("待支付");
                }
                $("#approve_"+id).text("--");

            }else {
                layer.msg(ret.msg);
            }

        },'json');

    }

    function order_list(next){

        var page_now = parseInt($("#page_now").val());
        var next_page = page_now + next;
        var activity_id = $("#id").val();
        var channel = $("#channel").val();

        var url = "/index.php/Admin/Activity/activity_order/action/page_list";
        var data = {"activity_id": activity_id, "channel":channel, "page_now":next_page};

        $.post(url, data, function(ret){

            if(ret.result == 1){
                $("#order_tbody").empty();
                $("#page_now").val(next_page);
                $("#page_count").val(ret.data.page);

                $(ret.data.list).each(function(i, order){

                    var apply_str,pay_str,sign_str;
                    var sign_str = "——";
                    var approve_str = "——";
                    if(order.order_status == 0){
                        apply_str = "待审核";
                        pay_str = "——";
                        approve_str = '<a class="link" onclick="approve('+order.order_id+',1);">通过</a> / <a class="link" onclick="approve('+order.order_id+',0)">拒绝</a>';
                    }else if(order.order_status == 1){
                        apply_str = "已取消";
                        pay_str = "已取消";
                    }else if(order.order_status == 2){
                        apply_str = "未通过";
                        pay_str = "——";
                    }else if(order.order_status == 3){
                        apply_str = "待支付";
                        pay_str = "待支付";
                    }else if(order.order_status == 4){
                        apply_str = "已报名";
                        pay_str = "已支付";
                        if(order.sign_in_status == 0){
                            sign_str = "未签到";
                        }else if(order.sign_in_status == 1){
                            sign_str = "已签到";
                        }else{
                            sign_str = "未开始";
                        }
                    }

                    var tr = $('<tr  role="row" align="center"></tr>');
                    tr.append('<td style="padding: 10px;text-align: left;">'+order.order_id+'</td>');
                    tr.append('<td style="padding: 10px;text-align: left;">'+order.user_note+'</td>');
                    tr.append('<td style="padding: 10px;text-align: left;">'+order.mobile+'</td>');
                    tr.append('<td style="padding: 10px;text-align: left;">'+order.order_sn+'</td>');
                    tr.append('<td style="padding: 10px;text-align: left;">'+order.total_amount+'</td>');


                    tr.append('<td style="padding: 10px;text-align: left;"  id="apply_status_'+order.order_id+'">'+apply_str+'</td>');
                    tr.append('<td style="padding: 10px;text-align: left;" id="pay_status_'+order.order_id+'">'+pay_str+'</td>');
                    tr.append('<td style="padding: 10px;text-align: left;">'+sign_str+'</td>');
                    tr.append('<td style="padding: 10px;text-align: left;" id="approve_'+order.order_id+'">'+approve_str+'</td>');

                    tr.append('<td style="padding: 10px;text-align: left;"><a class="link">详情</a></td>');
                    console.log(tr);

                    $("#order_tbody").append(tr);

                });

                pagination();

            }else{
                layer.msg("加载数据失败，请稍后再试!");
            }

        }, 'json');



    }

    $(function(){
        pagination();
    });

    function pagination(){

        var page_now = $("#page_now").val();
        var page_count = $("#page_count").val();
        if(page_now > 0 && page_count > 0){
            $("#pagination").empty();
            if(page_now == 1 && page_now !=page_count){
                $("#pagination").append('<li class="disabled"><a>上一页</a></li><li><a onclick="order_list(1)">下一页</a></li>');
            }else if(page_now != 1 && page_now ==page_count){
                $("#pagination").append('<li><a onclick="order_list(-1)">上一页</a></li><li class="disabled"><a>下一页</a></li>');
            }else if(page_now == 1 && page_now ==page_count){
                $("#pagination").append('<li class="disabled"><a>上一页</a></li><li class="disabled"><a>下一页</a></li>');
            }else{
                $("#pagination").append('<li><a onclick="order_list(-1)">上一页</a></li><li><a onclick="order_list(1)">下一页</a></li>');
            }
        }
    }

    //ajax请求报名管理数据
    function dj(num){
        $.get("{U('Activity/activity_order')}",{action:'page_list',page_now:num},function(data){
            console.log(data);
        })

    }
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
</script>