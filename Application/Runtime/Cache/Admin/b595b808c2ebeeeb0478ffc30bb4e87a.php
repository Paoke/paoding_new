<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <title><?php echo ($gemmap_config['shop_info_store_title']); ?></title>
    <link rel="shortcut icon" href="<?php echo ($gemmap_config['shop_info_title_logo']); ?>" type="image/png">

    <meta name="keywords" content="<?php echo ($gemmap_config['shop_info_store_keyword']); ?>"/>
    <meta name="description" content="<?php echo ($gemmap_config['shop_info_store_desc']); ?>"/>

    <!--dashboard calendar-->
    <link rel="stylesheet" href="<?php echo (CSS); ?>/clndr.css">
    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="<?php echo (JS); ?>/morris-chart/morris.css">
    <link rel="stylesheet" href="<?php echo (P); ?>/css/font-awesome.min.css">

    <!--common-->
    <link rel="stylesheet" href="<?php echo (CSS); ?>/style.css">
    <link rel="stylesheet" href="<?php echo (CSS); ?>/style-responsive.css">

    <!-- jQuery 2.1.4 -->
    <script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->

    <style type="text/css">
        /* 初始化 */
        body, div, ul, li, ol, h1, h2, h3, h4, h5, h6, input, textarea, select, p, dl, dt, dd, a, img, button, form, table, th, tr, td, tbody, article,
        aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section {
            margin: 0;
            padding: 0;
            border: none;
        }

        body {
            font: normal 14px/1.5 Tahoma, "Lucida Grande", Verdana, "Microsoft Yahei", STXihei, hei;
        }

        em, i {
            font-style: normal;
        }

        strong {
            font-weight: normal;
        }

        a:hover {
            color: #fff;
            text-decoration: none;
        }

        ul, ol {
            list-style: none;
        }

        h1, h2, h3, h4, h5, h6 {
            font-size: 100%;
            font-family: Microsoft YaHei;
        }

        img {
            border: none;
        }

        .nav-menu {
            height: 50px;
            padding-right: 10px;
            float: left;
        }

        .bn-headnav li {
            float: left;
        }

        .bn-headnav li a {
            display: inline-block;
            margin: 0 20px;
            line-height: 50px;
            text-decoration: none;
            color: #333;
            font-size: 14px;
        }

        .bn-headnav li a:hover {
            text-decoration: none;
        }

        .bn-headnav li.curr {
            color: #65cea7;
            height: 50px;
            background: #65cea7;
        }

        .bn-headnav li.curr a {
            color: #fff;
        }
    </style>

    <script type="text/javascript">
        var menu = <?php echo ($menu_list); ?>;
        $(function () {
            $('.bn-headnav ').on('click', 'li', function (ev) {
                $('.bn-headnav  li').removeClass('curr');
                $(this).addClass('curr');
            });


            var str = '';
            var isMenu = $("#rightMenu").is(":empty");
            //            var isRegular = /[该菜单暂无数据]/.test($("#menuRight").html());
            $.each(menu, function (i, item) {
                if (item.parent_id == <?php echo ($first_menu["mod_id"]); ?>
                )
                {
                    str += '<li class="menu-list" id="' + item.mod_id + '" onclick="slideMenu(this,' + item.mod_id + ')">';
                    str += '<a href="javascript:void(0)">';
                    str += '<i class="fa ' + item.icon + '"></i><span>' + item.title + '</span>';
                    str += '</a>';
                    str += '<ul class="sub-menu-list">';
                    $.each(item.submenu, function (ii, iitem) {
                        str += '<li onclick="makecss(this,' + iitem.mod_id + ')" id="menu_' + iitem.mod_id + '">';
                        str += '<a href="/index.php/Admin/' + iitem.url + '" target="rightContent"><i class="fa fa-circle-o"></i>' + iitem.title + '</a>';
                        str += '</li>';
                    });
                    str += '</ul></li>';
                }

            });
            if (!isMenu) {
                $("#menuRight").html("");
                $("#menuRight").append(str);
                $("#<?php echo ($first_menu["mod_id"]); ?>").addClass("curr");
            }

            // come no
            $('.menu-list').mouseenter(function (event) {
                $('.menu-list').removeClass('nav-hover')
                $(this).addClass('nav-hover')
            });
            $('.menu-list').mouseleave(function (event) {
                $(this).removeClass('nav-hover')
            });
        });
        function topMenu(id) {
            var str = '';
            var isMenu = $("#menuRight").is(":empty");
            $.each(menu, function (i, item) {
                if (item.parent_id == id) {
                    str += '<li class="menu-list" id="' + item.mod_id + '" onclick="slideMenu(this,' + item.mod_id + ')">';
                    str += '<a href="javascript:void(0)">';
                    str += '<i class="fa ' + item.icon + '"></i><span>' + item.title + '</span></i>';
                    str += '</a>';
                    str += '<ul class="sub-menu-list">';
                    $.each(item.submenu, function (ii, iitem) {
                        str += '<li onclick="makecss(this,' + iitem.mod_id + ')" id="menu_' + iitem.mod_id + '">';
                        str += '<a href="/index.php/Admin/' + iitem.url + '" target="rightContent"><i class="fa fa-circle-o"></i>' + iitem.title + '</a>';
                        str += '</li>';
                    });
                    str += '</ul></li>';
                }
            })
            $("#menuRight").html("");
            $("#menuRight").append(str);

            // come no
            $('.menu-list').mouseenter(function (event) {
                $('.menu-list').removeClass('nav-hover')
                $(this).addClass('nav-hover')
            });
            $('.menu-list').mouseleave(function (event) {
                $(this).removeClass('nav-hover')
            });
        }

        function slideMenu(obj) {
//            if($(obj).hasClass("nav-active")){
//                $(obj).children("ul").slideUp(300);
//                $(obj).removeClass("nav-active");
//            }else if(!$(obj).hasClass("nav-active")){
            $(obj).children("ul").slideDown(300);
            $(obj).addClass("nav-active");
//            }
            $(obj).prevAll().children("ul").slideUp(300);
            $(obj).prevAll("li").removeClass("nav-active");
            $(obj).nextAll().children("ul").slideUp(300);
            $(obj).nextAll("li").removeClass("nav-active");

        }
    </script>
</head>

<body class="sticky-div">
<!-- header section start-->
<div class="header-section">

    <a class="toggle-btn"><i class="fa fa-bars"></i></a>
    <div class="nav-menu">
        <ul class="bn-headnav">
            <?php if($topmenu_list != null): if(is_array($topmenu_list)): foreach($topmenu_list as $k=>$vo): ?><li onclick="topMenu('<?php echo ($vo["mod_id"]); ?>')" id="<?php echo ($vo["mod_id"]); ?>">
                        <a href="javascript:;"><?php echo ($vo["title"]); ?></a>
                    </li><?php endforeach; endif; ?>
                <?php else: ?>
                <div style="font-size: large;margin-top: 10%;margin-left: 10px;">无菜单数据</div><?php endif; ?>
        </ul>


    </div>
    <!--notification menu start -->
    <div class="menu-right">
        <ul class="notification-menu">
            <li>
                <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <!--头像 -->
                    <img src="<?php echo ($user_info['head_pic']); ?>" alt=""/>
                    <?php echo ($user_info['nickname']); ?>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                    <li><a href="/index.php/Admin/Admin/admin_update/action/page_list" target="rightContent"><i class="fa fa-user"></i> 修改信息</a></li>
                    <li><a href="<?php echo U('Admin/admin_alter');?>" target="rightContent"><i class="fa fa-user"></i> 修改密码</a> </li>
                    <li><a href="<?php echo U('Admin/logout');?>"><i class="fa fa-sign-out"></i> 退出登录</a></li>
                </ul>
            </li>

        </ul>
    </div>
</div>

<script>
    function detectBrowser() {
        var browser = navigator.appName;

        if (navigator.userAgent.indexOf("MSIE") > 0) {
            var b_version = navigator.appVersion
            var version = b_version.split(";");
            var trim_Version = version[1].replace(/[ ]/g, "");
            if ((browser == "Netscape" || browser == "Microsoft Internet Explorer")) {
                if (trim_Version == 'MSIE8.0' || trim_Version == 'MSIE7.0' || trim_Version == 'MSIE6.0') {
                    window.location.href = "/index.php/Admin/Ieupdate";
                }
            }
        }
    }
    detectBrowser();
</script>



<style type="text/css">
    .menu-list {
        border-bottom: 1px solid #343b43;
    }
    .logo {
    padding-top: 0px;
   
}
.logo a {
    margin: 0 0 0 13px;
}
    .add_cont img{background-size: cover;width: 80px;height:80px;margin:0px auto 15px;}
    .add_cont h6{  text-align: center;overflow: hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;} 
    .add_cont_s { left: 0; bottom: -4px; height: 60px; width: 100%; background: rgba(65, 73, 86,0.95); border-bottom: 1px solid #535C69; position: relative; }
</style>
<section>
    <!-- left side start-->
    <div class="left-side sticky-left-side" style="background:#414956">

        <!--logo and iconic logo start  style="background:url(/Public/images/add.png)no-repeat center center;background-size: cover;width: 80px;height:80px;margin:25px auto 15px;"-->
        <div class="logo">
            <a href="/index.php/Admin/Index/index"><img src="<?php echo ($logo); ?>" alt=""></a>
            <div class="add_cont" >
                <div id="site_logo_div" >
                    <img src="<?php echo ($site_left_logo); ?>" >
                   
                </div>
<h6><?php echo ($gemmap_config['shop_info_store_title']); ?></h6>
            </div>
        </div>

        <div class="logo-icon text-center">
            <a href="/index.php/Admin/Index/index"><img src="<?php echo ($small_logo); ?>" alt=""></a>
            <div class="add_cont_s">
                <div id="site_logo_divs" >
                    <img src="<?php echo ($site_left_logo); ?>" style="width:40px;height:40px;background-size: cover;position: absolute;left:0;top:0;right:0;bottom:0;margin:auto;">
                </div>
            </div>
        </div>
        <!--logo and iconic logo end-->

        <div class="left-side-inner">
            <!--sidebar nav start-->
            <ul class="nav nav-pills nav-stacked custom-nav" id="menuRight"></ul>
            <!--sidebar nav end-->
        </div>
    </div>
    <!-- left side end-->
</section>

<!-- Placed js at the end of the document so the pages load faster -->
<script src="<?php echo (JS); ?>/jquery-1.10.2.min.js"></script>
<script src="<?php echo (JS); ?>/jquery-ui-1.9.2.custom.min.js"></script>
<script src="<?php echo (JS); ?>/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo (JS); ?>/bootstrap.min.js"></script>
<script src="<?php echo (JS); ?>/modernizr.min.js"></script>
<script src="<?php echo (JS); ?>/jquery.nicescroll.js"></script>

<!--easy pie chart-->
<script src="<?php echo (JS); ?>/easypiechart/jquery.easypiechart.js"></script>
<script src="<?php echo (JS); ?>/easypiechart/easypiechart-init.js"></script>

<!--Sparkline Chart-->
<script src="<?php echo (JS); ?>/sparkline/jquery.sparkline.js"></script>
<script src="<?php echo (JS); ?>/sparkline/sparkline-init.js"></script>

<!--icheck -->
<script src="<?php echo (JS); ?>/iCheck/jquery.icheck.js"></script>
<script src="<?php echo (JS); ?>/icheck-init.js"></script>

<!--Calendar-->
<script src="<?php echo (JS); ?>/calendar/clndr.js"></script>
<script src="<?php echo (JS); ?>/calendar/evnt.calendar.init.js"></script>
<script src="<?php echo (JS); ?>/calendar/moment-2.2.1.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.2/underscore-min.js"></script>

<!--common scripts for all pages-->
<script src="<?php echo (JS); ?>/scripts.js"></script>

<!--Dashboard Charts-->
<script src="/Public/js/jquery-ui.min.js" type="text/javascript"></script>
<script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/Public/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/Public/plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
<script src="/Public/dist/js/app.js" type="text/javascript"></script>
<script src="/Public/dist/js/demo.js" type="text/javascript"></script>

<script type="text/javascript">

    $(document).ready(function () {
        // $("#riframe").height($(window).height()-1);//浏览器当前窗口可视区域高度
        // $("#rightContent").height($(window).height()-1);
        // $('.main-sidebar').height($(window).height()-1);
        jQuery('.main-content').height($(window).height());
    });

    var tmpmenu = 1;
    function makecss(obj, mod_id) {
        $('#menu_' + tmpmenu).removeClass('active');
        $(obj).addClass('active');
        tmpmenu = mod_id;
    }

</script>
</body>
</html>

<!-- main content start-->
<div class="main-content" >

    <section class="content-wrapper " style="margin:0px;padding:0px;height:100%;">
        <iframe id='rightContent' name='rightContent' src="<?php echo U('Admin/Index/welcome');?>" width='100%' height='100%' frameborder="0" style="height:100%;background:#FFFFFF;"></iframe>
    </section>

</div>
<!-- main content end-->