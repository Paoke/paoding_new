<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="#" type="image/png">

    <title>模块类别管理</title>
    <meta name="keywords" content="<?php echo ($gemmap_config['shop_info_store_keyword']); ?>"/>
    <meta name="description" content="<?php echo ($gemmap_config['shop_info_store_desc']); ?>"/>

    <!--dynamic table-->
    <link href="<?php echo (CSS); ?>/style.css" rel="stylesheet">
    <link href="<?php echo (CSS); ?>/style-responsive.css" rel="stylesheet">
    <link href="<?php echo (CSS); ?>/chanel-type.css" rel="stylesheet">
    <!--GEMMAP自带的矢量图标库 font-awesome.min.css-->
    <link href="/Public/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="/Public/js/html5shiv.js"></script>
    <script src="/Public/js/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery 2.1.4 -->
    <script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="/Public/js/global.js"></script>
<!--     <script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> -->
    <script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->

</head>
<style type="text/css">
/* CSS Document */
html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video, select{margin: 0;padding: 0;border: 0;}
.pa{position: absolute;}
.center {
    right: 15px;
    top: 12px;
}
a:hover{ text-decoration:none;}
img,a{border:0; text-decoration:none;}
ol, ul,li {list-style: none; }
.main-content { margin-left: 172px; background: #eff0f4; min-height: 1000px; }
.panel{ margin-bottom: 0px; }
.panel-body { padding:10px; }
.panel-heading{ border-bottom: 1px solid #e7e7e7; font-size:18px; }

.tb-conve{border-bottom: 1px solid #e7e7e7; overflow: hidden; padding:10px;}  
.first{width: 320px;height: 650px; margin-left:20px;float: left;overflow: hidden;}
.first img{width: 320px; height: 560px;}
.first section{width: 320px; height: 560px;margin:0px;padding:0px;}
.line{display:block; width: 80px;height: 30px;line-height: 30px;text-align: center;font-size: 14px; background: #24dabb;color:#fff;border-radius: 5px;margin-top:15px;text-decoration:none;float: left;margin-right: 20px}

.head{overflow: hidden;}
.head li{ float: left; width: 25%;}
.head li a{ margin:10px;    display: block;box-sizing: border-box;position: relative;}
.head li a.cur:after{content:"";position: absolute;width: 100%;height:100%;left:0;top:0;border:4px solid #3c9;box-sizing: border-box;}
.head img{ width:100%;}

.table th{ vertical-align: bottom; border-bottom: 1px solid #ddd; padding: 10px; text-align:center; }
.table td{ vertical-align: bottom; border-bottom: 1px solid #ddd; padding: 5px; text-align:center; }
.back_2{ position: fixed; left:0; top:0; right:0; bottom:0; margin:auto; background:#000; opacity:0.6; z-index: 99; display:none; }
.hannel{width:20%;float: left;font-size: 14px;color:#333;line-height: 40px;}
.container h1 { width: 70%; margin: 0 auto; font-weight: normal; font-size: 20px; text-align: center; height: 40px; line-height: 40px; overflow: hidden.; color: #fff; }
.container{ width: 100%; height: 40px; overflow: hidden; background:#65cea7; }
.container .center a { display: block; width: 24px;height:24px; border-radius: 100%; }
.container .center a  img{ width: 100%; }
.container .center { right:15px; top: 5px; }

.tit{height: 190px;width: 100%; background:#000;opacity:0.5;position: absolute;top:0;left:0;display:none;color:#fff;line-height: 190px;text-align: center;font-size: 24px;font-weight: 500;}
.notice:hover .tit{display:block;}

.alert_box{width: 700px;height:500px;;position: fixed;left:30%;top:15%;display:none;z-index: 99;background-color: #fff;}
.bn-headnav li{ display:inline; float: left; font-size:16px; font-family:微软雅黑; cursor:pointer; width:100px; text-align:center; line-height: 40px;border: 1px solid #e7e7e7;margin-right:5px;height:40px;}
.bn-headnav li a{ color:#666; margin-left:4px; }
.bn-headnav li a:hover{ text-decoration:none; }
.bn-headnav li.curr{ color:#333; background: #dadada; height:42px;border: 1px solid #e7e7e7;  }
.bn-headnav li.curr a{ color:#333; text-decoration:none;}
#qwe>.panel{display:none;}
.panel.the_show{display:block !important;}

.infoBox { width: 740px; height: 480px; position: fixed; left: 0; bottom: 0; top: 0; right: 0; background: #cacaca; margin: auto; z-index: 9999; display: none; }
.secondInfo li { margin-bottom: 10px; height: 190px; }
.box-shadow { width: 100%; height: 50px; overflow: hidden; background: #fff; }
.box-shadow h1 { width: 70%; margin: 0 auto; font-weight: normal; font-size: 20px; text-align: center; height: 40px; line-height: 50px; overflow: hidden; color: #333; background: #fff; }

.golp{position: absolute;;bottom:30px;right:30px; }

.input-sm{
    width: 40px;
    height: 25px;
    padding: 5px 10px;
    font-size: 12px;
    line-height: 1.5;
    border-radius: 3px;
}

.mainw{width:320px; margin:auto; position:relative}
.div1{ width:320px;height:560px; position:absolute; left:0; top:0;background:white; filter: grayscale(1%);opacity:0.0;position:absolute;width:100%;top:0; z-index:1}
</style>


<body class="sticky-header">

    <!-- main content start-->
    <div class="main-content" width="100%" style="margin:0px;">

            <!--body wrapper start-->
            <div class="wrapper">
                <div class="panel">
                    <header class="panel-body panel-heading ">
                        <div class="pull-left ">
                            全局导航器模型设置
                        </div>
                        <!--<div class="pull-right">
                            <div class="btn-group">
                                <button id="saveBtn" class="btn btn-default">保存</button>
                                <a href="javascript:;" class="btn btn-default">取消</a>
                            </div>
                        </div>-->
                    </header>
                </div>
                <!-- 选择模块 -->
                <div class="tb-conve panel">
                    <div class="first mainw">
                        <div class="div1"></div>
                        <section class="content-wrapper" style="border: 1px solid #eee;">
                            <iframe id="navigationContent" name='navigationContent' src="/index.php/Admin/Navigation/index/action/bottom/id/1" width='100%' height='100%' frameborder="0" style="height:100%;background:#FFFFFF;"></iframe>
                        </section>
                        <!--<img src="/Public/images/channel_list/u747.png" alt="" />-->
                        <a id="change_temp" class="line btn-de" href="javascript:;">更改模板</a>
                        <a id="gen_temp" class="line btn-de" href="javascript:;">生成页面</a>
                    </div>
                    <section class="secondBanner">
                        <div class="back_2"></div>
                        <div class="infoBox" >
                            <div class="box-shadow">
                                <div class="pa center">
                                    <a class="x" href="javascript:;">
                                        <img src="/Public/images/channel_list/02.png" height="20" width="20" alt="" />
                                    </a>
                                </div>
                                <h1>选中全局导航器模板</h1>
                            </div>
                            <div class="secondInfo">
                                <div class="head">
                                    <ul>
                                        <li class="notice">
                                            <a href="/index.php/Admin/Navigation/index/action/bottom/id/1" target="navigationContent" data-id="1">
                                                <img src="/Public/images/channel_list/u749.jpg" height="190" alt="" />
                                                <div class="tit">选择模板</div>
                                            </a>
                                        </li>
                                        <li class="notice">
                                            <a href="/index.php/Admin/Navigation/index/action/bottom2/id/2" target="navigationContent" data-id="2">
                                                <img src="/Public/images/channel_list/u755.jpg" height="190" alt="" />
                                                <div class="tit">选择模板</div>
                                            </a>
                                        </li>
                                        <li class="notice">
                                            <a href="/index.php/Admin/Navigation/index/action/side/id/3" target="navigationContent" data-id="3">
                                                <img src="/Public/images/channel_list/u745.jpeg" height="190" alt="" />
                                                <div class="tit">选择模板</div>
                                            </a>
                                        </li>
                                        <li class="notice">
                                            <a href="/index.php/Admin/Navigation/index/action/side2/id/4" target="navigationContent" data-id="4">
                                                <img src="/Public/images/channel_list/u7479.png" height="190" alt="" />
                                                <div class="tit">选择模板</div>
                                            </a>
                                        </li>
                                        <li class="notice">
                                            <a href="/index.php/Admin/Navigation/index/action/top/id/5" target="navigationContent" data-id="5">
                                                <img src="/Public/images/channel_list/u755.jpg" height="190" alt="" />
                                                <div class="tit">选择模板</div>
                                            </a>
                                        </li>
                                        <li class="notice">
                                            <a href="/index.php/Admin/Navigation/index/action/top2/id/6" target="navigationContent" data-id="6">
                                                <img src="/Public/images/channel_list/u755.jpg" height="190" alt="" />
                                                <div class="tit">选择模板</div>
                                            </a>
                                        </li>
                                        <li class="notice">
                                            <a href="/index.php/Admin/Navigation/index/action/bottom/id/1" target="navigationContent" data-id="1">
                                                <img src="/Public/images/channel_list/u755.jpg" height="190" alt="" />
                                                <div class="tit">选择模板</div>
                                            </a>
                                        </li>
                                        <li class="notice">
                                            <a href="/index.php/Admin/Navigation/index/action/bottom/id/1" target="navigationContent" data-id="1">
                                                <img src="/Public/images/channel_list/u755.jpg" height="190" alt="" />
                                                <div class="tit">选择模板</div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="panel col-sm-8" style="margin-left: 50px;">
                        <header class="panel-heading panel-body ">
                            <div class="pull-left ">
                                填充导航器子项
                            </div>
                            <div class="btn-group pull-right">
                                <button id="addBtn" class="btn btn-default btn-sm btn-success"><i class="fa fa-plus-square"></i>更换分格</button>
                                <button id="saveBtn" class="btn btn-default btn-sm btn-warning"><i class="fa fa-save"></i>保存</button>
                            </div>
                        </header>
                        <table class="table ">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>子项名称</th>
                                <th>默认图标</th>
                                <th>选中图标</th>
                                <th>链接到</th>
                                <th>子项类型</th>
                                <th>初始页</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody id="item_tbody">
                                <?php if(!empty($nvList)): if(is_array($nvList)): foreach($nvList as $k=>$vo): ?><tr>
                                        <td><input name="sort[]" value="<?php echo ($vo["sort"]); ?>" class="input-sm"/></td>
                                        <td><input name="title[]" value="<?php echo ($vo["title"]); ?>" class="input-sm" style="width: 60px" maxlength="3"/></td>
                                        <td>
                                            <img id="default_icon_<?php echo ($vo["id"]); ?>" width="20" height="20" src="<?php echo ($vo["default_icon"]); ?>" onclick="GetUploadifyImage(1,'default_icon_<?php echo ($vo["id"]); ?>','images','');"/></td>
                                        <td>
                                            <img id="checked_icon_<?php echo ($vo["id"]); ?>" width="20" height="20" src="<?php echo ($vo["checked_icon"]); ?>" onclick="GetUploadifyImage(1,'checked_icon_<?php echo ($vo["id"]); ?>','images','');"/></td>
                                        </td>
                                        <td id="item<?php echo ($k); ?>_1"><?php echo ($vo["link_to"]); ?><input type="hidden" name="link_id" value="<?php echo ($vo["link_id"]); ?>"></td>
                                        <td id="item<?php echo ($k); ?>_2">
                                            <?php if($vo["item_type"] == 1): ?>频道
                                                <?php elseif($vo["item_type"] == 2): ?>自定义页面
                                                <?php elseif($vo["item_type"] == 3): ?>自定义外链
                                                <?php else: endif; ?>
                                            <input type="hidden" name="item_type" value="<?php echo ($vo["item_type"]); ?>">
                                        </td>
                                        <td>
                                            <input name="is_home" type="radio" value="1"
                                                <?php if($vo["is_home"] == 1): ?>checked<?php endif; ?>
                                            >
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="javascript:;" class="btn btn-default alert_btn btn-sm" onclick='popup("item<?php echo ($k); ?>")'>修改</a>
                                               <a href="javascript:;" class="btn btn-default btn-sm" onclick="del(this)">删除</a>
                                            </div>
                                        </td>
                                    </tr><?php endforeach; endif; endif; ?>
                                <?php if(empty($nvList)): $__FOR_START_26295__=1;$__FOR_END_26295__=5;for($i=$__FOR_START_26295__;$i < $__FOR_END_26295__;$i+=1){ ?><tr>
                                            <td><input name="sort" value="9" class="input-sm"></td>
                                            <td><input name="title" value="子项" class="input-sm" style="width: 60px" maxlength="3"></td>
                                            <td><img id="default_icon_<?php echo ($i); ?>" width="20" height="20" src="/Public/images/site_small.png" onclick="GetUploadifyImage(1,'default_icon_<?php echo ($i); ?>','images','');"></td>
                                            <td><img id="checked_icon_<?php echo ($i); ?>" width="20" height="20" src="/Public/images/site_small.png" onclick="GetUploadifyImage(1,'checked_icon_<?php echo ($i); ?>','images','');"></td>
                                            <td id="item<?php echo ($i); ?>_1">暂未设置</td>
                                            <td id="item<?php echo ($i); ?>_2">暂未设置</td>
                                            <td>
                                                <input name="is_home" type="radio" value="1">
                                            </td>
                                            <td class="numeric" data-title="Volume">
                                                <div class="btn-group">
                                                    <a href="javascript:;" class="btn btn-default alert_btn btn-sm" onclick='popup("item<?php echo ($i); ?>")'>设置</a>
                                                    <!--<a href="javascript:;" class="btn btn-default btn-sm" onclick="del(this)">删除</a>-->
                                                </div>
                                            </td>
                                        </tr><?php } endif; ?>

                            </tbody>
                        </table>

                    </section>

                    <section class="">
                        <div class="back_2"></div>
                        <div class="alert_box">
                            <div class="box-shadow">
                                <div class="pa center">
                                    <a class="x" href="javascript:;">
                                        <img src="/Public/images/channel_list/02.png" height="20" width="20" alt="" />
                                    </a>
                                </div>
                                <h1 style="text-align: left;font-size: 18px;margin-left: 30px">请选择链接到的地址</h1>
                            </div>
                            <div class="">
                                <div class="panel-body" id="qwe">
                                    <div class="nav-button">
                                        <div class="nav">
                                            <ul id="choose_tab" class="bn-headnav">
                                                <li data-type="1" class="curr"><a href="javascript:;">频道</a></li>
                                                <li data-type="2"><a href="javascript:;">自定义页面</a></li>
                                                <li data-type="3"><a href="javascript:;">自定义外链</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <section class="panel the_show">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>选择</th>
                                                <th>频道名称</th>
                                                <th>基础模型</th>
                                                <th>主题</th>
                                            </tr>
                                            </thead>
                                            <tbody id="ch_tbody">
                                            <?php if(is_array($chList)): $i = 0; $__LIST__ = $chList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ch): $mod = ($i % 2 );++$i;?><tr>
                                                    <td>
                                                        <input type="radio" name="page_link" value="<?php echo ($ch["id"]); ?>"></td>
                                                    <td><?php echo ($ch["channel_title"]); ?></td>
                                                    <td>
                                                        <?php if($ch["base_module"] == 'Article'): ?>资讯
                                                            <?php elseif($ch["base_module"] == 'Activity'): ?>活动
                                                            <?php else: endif; ?>

                                                    </td>
                                                    <td>暂无</td>
                                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                                            </tbody>
                                        </table>
                                        <div class="col-md-12 text-center clearfix">
                                            <ul class="pagination btn-group" id="ch_pagination">
                                                <li class="disabled btn-sm"><a>上一页</a></li>
                                                <li class="disabled btn-sm"><a>下一页</a></li>
                                            </ul>
                                        </div>
                                    </section>

                                    <section class="panel">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>选择</th>
                                                <th>页面名称</th>
                                                <th>模板</th>
                                            </tr>
                                            </thead>
                                            <tbody id="pg_tbody">
                                            <?php if(is_array($pageList)): $i = 0; $__LIST__ = $pageList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$page): $mod = ($i % 2 );++$i;?><tr>
                                                    <td>
                                                        <input type="radio" name="page_link" value="<?php echo ($page["id"]); ?>"></td>
                                                    <td><?php echo ($page["title"]); ?></td>
                                                    <td>无</td>
                                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </tbody>
                                        </table>
                                        <div class="col-md-12 text-center clearfix">
                                            <ul class="pagination btn-group" id="p_pagination">
                                                <li class="disabled btn-sm"><a>上一页</a></li>
                                                <li class="disabled btn-sm"><a>下一页</a></li>
                                            </ul>
                                        </div>
                                    </section>

                                    <section class="panel">
                                        <div class="panel-body">
                                            <span class="col-md-3">请输入自定义外链:</span>
                                            <input id="define_link" class="default-date-picker col-md-6" size="26" type="text" value="" placeholder="例如：http//:www.baidu.com" />
                                        </div>
                                    </section>

                                    <input id="prefix" type="hidden" value=""/>
                                </div>
                            </div>

                            <div class="golp">
                                <a id="confirmBtn" class="btn btn-default btn-sm " style="float:right">确定</a>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <!--body wrapper end-->
    </div>
    <!-- main content end-->
    <form id="temp_from" method="post" target="navigationContent" action="/index.php/Admin/Navigation/index/action/bottom/id/1">
        <input id="params" name="params" value="">
        <input id="template_id" name="template_id" value="1">
    </form>

<!-- Placed js at the end of the document so the pages load faster -->
<script src="<?php echo (JS); ?>/jquery-ui-1.9.2.custom.min.js"></script>
<script src="<?php echo (JS); ?>/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo (JS); ?>/bootstrap.min.js"></script>
<script src="<?php echo (JS); ?>/modernizr.min.js"></script>
<script src="<?php echo (JS); ?>/jquery.nicescroll.js"></script>
<script src="<?php echo (JS); ?>/jquery.base64.js"></script>
<!--common scripts for all pages-->
<script src="<?php echo (JS); ?>/scripts.js"></script>

</body>
</html>
<script type="text/javascript">

    $('#change_temp').click(function (event) {
        $('.secondBanner').show()
        $('.infoBox').show();
        $('.back_2').show();
    });

    $('.x').click(function (event) {
        $('.infoBox').hide();
        $('.alert_box').hide();
        $('.back_2').hide();
    });
    $('.back_2').click(function (event) {
        $('.infoBox').hide();
        $('.alert_box').hide();
        $('.back_2').hide();
    });

    $('.alert_btn').click(function (event) {
        $('.alert_box').show();
        $('.back_2').show();
    });
    $('.bn-headnav li').click(function () {
        $('.bn-headnav li').removeClass('curr');
        $(this).addClass('curr');
        $('#qwe>.panel').removeClass('the_show');
        $('#qwe>.panel').eq($(this).index()).addClass('the_show');
     });

    $('.tit').click(function (event) {

        var action = $(this).parent().attr("href");
        var id = $(this).parent().attr("data-id");
        if(id != $("#template_id").val()){
            $("#temp_from").attr('action', action);
            $("#template_id").val(id);

            var len = 4;
            if(id == 2){
                len = 5;
            }
            initNavi(len);
        }
        $('.infoBox').hide();
        $('.back_2').hide();
    });

    function initNavi(length){
        $("#item_tbody").empty();
        for(var i=1; i<=length; i++){
            var html = '<tr><td><input name="sort" value="9" class="input-sm"></td>'+
                    '<td><input name="title" value="子项" class="input-sm" style="width: 60px" maxlength="3"></td>'+
                    '<td><img id="default_icon_'+i+'" width="20" height="20" src="/Public/images/site_small.png" onclick="GetUploadifyImage(1,\'default_icon_'+i+'\',\'images\',\'\');"></td>'+
                    '<td><img id="checked_icon_'+i+'" width="20" height="20" src="/Public/images/site_small.png" onclick="GetUploadifyImage(1,\'checked_icon_'+i+'\',\'images\',\'\');"></td>'+
                    '<td id="item'+i+'_1">暂未设置</td>'+
                    '<td id="item'+i+'_2">暂未设置</td>'+
                    '<td><input name="is_home" type="radio" value="1"></td>'+
                    '<td><div class="btn-group">'+
                    '<a href="javascript:;" class="btn btn-default alert_btn btn-sm" onclick="popup(\'item'+i+'\')">设置</a>'+
                    '<a href="javascript:;" class="btn btn-default btn-sm" onclick="del(this)">删除</a>'+
                    '</div></td></tr>';

            $("#item_tbody").append(html);
        }
    }


    function showImg(path, ele_id){
        layer.msg(ele_id+": ["+path+"]");
        $("#"+ele_id).attr('src', path);
    }

    function del(obj){
        layer.confirm('确认删除？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $(obj).parent().parent().parent().remove();
            layer.closeAll();
        }, function(){
            layer.closeAll();
        });
    }

    var index = 9;
    $("#addBtn").click(function(){

        var html = '<tr><td><input name="sort" value="9" class="input-sm"/></td><td>' +
                '<input name="title" value="子项" class="input-sm" style="width: 60px" maxlength="3"/></td>'+
                '<td><img id="default_icon_'+index+'" width="20" height="20"  src="/Public/images/site_small.png" /></td>'+
                '<td><img id="checked_icon_'+index+'" width="20" height="20" src="/Public/images/site_small.png" /></td>'+
                '<td id="item'+index+'_1">暂未设置</td><td id="item'+index+'_2">暂未设置</td>'+
                '<td><input name="is_home" type="radio" value="1"></td>'+
                '<td><div class="btn-group">'+
                '<a href="javascript:;" class="btn btn-default alert_btn btn-sm" onclick="popup(\'item'+index+'\')">设置</a>'+
                '<a href="javascript:;" class="btn btn-default btn-sm" onclick="del(this)">删除</a>'+
                '</div></td></tr>';

        $("#item_tbody").append(html);

        $('.alert_btn').click(function (event) {
            $('.alert_box').show();
            $('.back_2').show();
        });
        ++index;
    });

    $("#confirmBtn").click(function(){

        var type = $("#choose_tab .curr").attr('data-type');
        var checked_el = $('input:radio[name="page_link"]:checked');
        var value = checked_el.val();
        if(type == 3){
            value = 0;
        }
        var p_el = checked_el.parent().parent();
        var title;
        var type_desc;
        if(type == 1){
            title = p_el.find('td').eq(1).text();
            type_desc = "频道";
        }else if(type == 2){
            title = p_el.find('td').eq(1).text();
            type_desc = "自定义页面";
        }else {
            title = $("#define_link").val();
            type_desc = "自定义链接";
        }

        var prefix = $("#prefix").val();

        $("#"+prefix+'_1').text(title);
        $("#"+prefix+'_1').append('<input type="hidden" name="link_id" value="'+value+'">');
        $("#"+prefix+'_2').text(type_desc);
        $("#"+prefix+'_2').append('<input type="hidden" name="item_type" value="'+type+'">');

        $('.alert_box').hide();
        $('.back_2').hide();

    });

    function popup(prefix){
        $('#prefix').val(prefix);
    }

    $("#saveBtn").click(function(){

        var datas = {};
        var flag = false;
        $("#item_tbody").find('tr').each(function(i, tr){
            var item = {};
            $(this).children().each(function(i, td){
                if(i<=6){
                    var val;
                    switch (i){
                        case 0:
                            val = $(td).find('input').val();
                            item['sort'] = val;
                            break;
                        case 1:
                            val = $(td).find('input').val();
                            item['title'] = val;
                            break;
                        case 2:
                            val = $(td).find('img').attr('src');
                            item['default_icon'] = val;
                            break;
                        case 3:
                            val = $(td).find('img').attr('src');
                            item['checked_icon'] = val;
                            break;
                        case 4:
                            val = $(td).text();
                            item['link_to'] = val;

                            val = $(td).find('input').val() == undefined ? 0 : $(td).find('input').val();
                            item['link_id'] = val;
                            break;
                        case 5:
                            val = $(td).find('input').val() == undefined ? 0 : $(td).find('input').val();
                            item['item_type'] = val;
                            break;
                        case 6:
                            val = $(td).find('input').is(':checked') ? 1 : 0;
                            item['is_home'] = val;
                            break;
                    }
                }

            });

            if(item['is_home'] == 1 && item['item_type'] != 2){
                layer.msg('初始页必须为自定义页面，请重新选择!');
                flag = false;
                return false;
            }else{
                //item['template_id'] = $("#template_id").val();
                item['id'] = i;
                datas[i] = item;
                flag = true;
            }
        });

        if(flag){

            var url = "/index.php/Admin/AppConfig/global_info/action/save";
            var json = encodeURI(JSON.stringify(datas));
            var template_id = $("#template_id").val();
            var data = {'json': json, 'template_id': template_id};
            $.post(url, data, function(ret){
                layer.msg(ret.msg);
                if(ret.result == 1){
                    reloadTemplate(datas);
                }

            },'json');

        }
    });

    function reloadTemplate(data){

        var params =  encodeURI(JSON.stringify(data));
        $("#params").val(params);

        $("#temp_from").submit();

    }


    $("#gen_temp").click(function(){

        var loading =layer.msg('请稍后', {
            icon: 16
            ,shade: 0.01
        });

        var html = getIframeHtml();
        var template_id = $("#template_id").val();
        var data = {'html': html, 'template_id': template_id};
        var url = "/index.php/Admin/AppConfig/global_info/action/gen_temp";

        $.post(url, data, function(ret){
            layer.close(loading);
            if(ret.result == 1){
                layer.msg("生成页面成功!");
            }else{
                layer.msg("生成页面成功!");
            }

        }, 'json');
    });


    function getIframeHtml(){
        var html = $(window.frames["navigationContent"].document).find('html').prop("outerHTML");
        html = '<!doctype html>' + html;
        html = encodeURI(html);
        return html;
    }

</script>
<script>

    var ch_count = "<?php echo ($chCount); ?>";
    var pg_count = "<?php echo ($pgCount); ?>";
    var prep_num = 8;
    var ch_current = 1;
    var pg_current = 1;

    $(function(){

        if(ch_count > prep_num){
            $("#ch_pagination li").eq(1).removeClass('disabled');
            $("#ch_pagination li").eq(1).click(function(){
                channel_page(1);
            });
        }

        if(pg_count > prep_num){
            $("#p_pagination li").eq(1).removeClass('disabled');
            $("#p_pagination li").eq(1).click(function(){
                pg_page(1);
            });
        }


    });

    function channel_page(go){
        ch_current += go;

        var data = {'page_now': ch_current, 'page_num': prep_num};
        var url = "/index.php/Admin/System/channel/action/list";
        $.post(url, data, function(ret){

            if(ret.result == 1){
                $("#ch_tbody").empty();
                $(ret.data.list).each(function(i, item){

                    var module = "资讯";
                    if(item.module == 'Activity'){
                        module = "活动";
                    }

                    var html = '<tr><td><input type="radio" name="page_link" value="'+item.id+'"></td>'+
                            '<td>'+item.channel_title+'</td><td>'+module+'</td><td>暂无</td></tr>';
                    $("#ch_tbody").append(html);
                });

                $("#ch_pagination").empty();
                var html = '<li class="btn-sm" onclick="channel_page(-1)"><a>上一页</a></li><li class="btn-sm"  onclick="channel_page(1)"><a>下一页</a></li>';
                if(ch_current == 1){
                    html = '<li class="disabled btn-sm"><a>上一页</a></li><li class="btn-sm"  onclick="channel_page(1)"><a>下一页</a></li>';
                }else if(ch_current == ret.data.page){
                    html = '<li class="btn-sm" onclick="channel_page(-1)"><a>上一页</a></li><li class="disabled btn-sm"><a>下一页</a></li>';
                }

                $("#ch_pagination").append(html);
            }

        }, 'json');

    }

    function pg_page(go){
        pg_current += go;

        var data = {'page_now': pg_current, 'page_num': prep_num};
        var url = "/index.php/Admin/PageConfig/page_config/action/list";
        $.post(url, data, function(ret){

            if(ret.result == 1){
                $("#pg_tbody").empty();
                $(ret.data.list).each(function(i, item){

                    var html = '<tr><td><input type="radio" name="page_link" value="'+item.id+'"></td>' +
                            '<td>'+item.title+'</td><td>无</td></tr>';
                    $("#pg_tbody").append(html);
                });

                $("#pg_pagination").empty();
                var html = '<li class="btn-sm" onclick="pg_page(-1)"><a>上一页</a></li><li class="btn-sm"  onclick="pg_page(1)"><a>下一页</a></li>';
                if(ch_current == 1){
                    html = '<li class="disabled btn-sm"><a>上一页</a></li><li class="btn-sm"  onclick="pg_page(1)"><a>下一页</a></li>';
                }else if(ch_current == ret.data.page){
                    html = '<li class="btn-sm" onclick="pg_page(-1)"><a>上一页</a></li><li class="disabled btn-sm"><a>下一页</a></li>';
                }

                $("#pg_pagination").append(html);
            }

        }, 'json');

    }

</script>