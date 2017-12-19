<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en" ng-app="activity">
<head>
    <meta charset="UTF-8">
    <title>活动</title>
    <meta name="description" content="庖丁科技众包服务平台携手国内外先进技术科研院所、顶级技术专家，以实现科技成果市场化为核心，为企业提供快速精准的需求匹配服务，从而实现企业以及科技资源的有效对接，帮助企业实现产业技术升级，助力先进技术完成产业化发展。" />
    <meta name="keywords" content="庖丁众包、智能技术、机械制造、健康医疗、材料科学、能源环保、生产流程优化"/>
    <meta name='viewport' content='user-scalable=no,width=750'>
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/common_new.css">
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/activity.css">
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/swiper.css">
</head>
<body ng-controller="actCtrl">
<div class="activity_banner">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <a href="#">
                    <img src="<?php echo (MOBILE); ?>/images/hd-lunbo1.png" alt="">
                </a>
            </div>
            <div class="swiper-slide">
                <a href="#">
                    <img src="<?php echo (MOBILE); ?>/images/hd-lunbo2.png" alt="">
                </a>
            </div>
            <div class="swiper-slide">
                <a href="#">
                    <img src="<?php echo (MOBILE); ?>/images/hd-lunbo3.png" alt="">
                </a>
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>
    <!-- 导航 -->
<div class="activity_nav clear">
    <a href="/index.php/Mobile/Activity/share.html?tag_id={{options[2].id}}">
        <li class="activity_nav_part fl" style="margin-left:90px;">
            <div class="activity_nav_part_icon" style="background: url(<?php echo (MOBILE); ?>/images/icon-activity-salon.png) center 0 no-repeat;"></div>
            <p class="activity_nav_part_theme" ng-cloak>{{options[2].tag_name}}</p>
        </li>
    </a>
    <a href="/index.php/Mobile/Activity/theme.html?tag_id={{options[1].id}}">
        <li class="activity_nav_part fl">
            <div class="activity_nav_part_icon" style="background: url(<?php echo (MOBILE); ?>/images/icon-activity-fortum.png) center 0 no-repeat;"></div>
            <p class="activity_nav_part_theme" ng-cloak>{{options[1].tag_name}}</p>
        </li>
    </a>
    <a href="/index.php/Mobile/Activity/abutment.html?tag_id={{options[0].id}}">
        <li class="activity_nav_part fl">
            <div class="activity_nav_part_icon" style="background: url(<?php echo (MOBILE); ?>/images/icon-activity-joint.png) center 0 no-repeat;"></div>
            <p class="activity_nav_part_theme" ng-cloak>{{options[0].tag_name}}</p>
        </li>
    </a>
</div>
<div class="activity_grey"></div>

<!-- 最近举办 -->
<div class="activity_lately">
    <div class="activity_lately_tit clear" ng-show="lists[0].have=='1'">
        <div class="activity_tit_icon fl" style="background: url(<?php echo (MOBILE); ?>/images/icon-activity-previous.png);"></div>
        <span class="activity_lately_span fl">最近举办</span>
    </div>

    <div ng-repeat="list in lists" ng-hide="list.status=='0'">
        <a href="/index.php/Mobile/Activity/detail" >
            <div class="activity_main">
                <img class="activity_main_img" ng-src="{{list.cover_url}}" alt="">
                <div class="activity_main_time clear">
                    <p class="fl">{{list.plan_end_time}}</p>
                    <p class="fr">了解详情<img src="<?php echo (MOBILE); ?>/images/icon-right.png" alt=""></p>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="activity_grey"></div>

<!-- 往期活动 -->
<div class="activity_lately">
    <div class="activity_lately_tit clear"  ng-show="lists[0].have!='1'">
        <div class="activity_tit_icon fl"  style="background: url(<?php echo (MOBILE); ?>/images/icon-activity-previous.png) center 0 no-repeat;"></div>
        <span class="activity_lately_span fl">往期活动</span>
    </div>

    <div ng-repeat="list in lists" ng-hide="list.status=='1'">
        <div class="activity_lately_section clear">
            <div class="activity_section_left fl">
                <img class="activity_logo" ng-src="{{list.sponsor_logo_url}}" alt="">
            </div>
            <div class="activity_section_right fr">
                <p class="activity_right_tit">{{list.title}}</p>
                <p class="activity_right_p">
                    <span class="activity_right_span">{{list.diqu}}</span>
                    <span>{{list.formal_start_time}}</span>
                </p>
                <p  class="activity_right_p">
                    浏览<span class="activity_right_span"> {{list.clicks}}</span>
                    收藏<span> {{list.shoucang}}</span>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="nav">
    <a class="nav_option" href="/index.php/Mobile/Index/index">
        <img src="<?php echo (MOBILE); ?>/images/icon-tabbar-technology-default.png" alt="">
        <p>技术</p>
    </a>
    <a class="nav_option" href="/index.php/Mobile/Demand/demand_list">
        <img src="<?php echo (MOBILE); ?>/images/icon-tabbar-demand-default.png" alt="">
        <p>需求</p>
    </a>
    <a class="nav_option" href="/index.php/Mobile/Activity/activity">
        <img src="<?php echo (MOBILE); ?>/images/icon-tabbar-activity-selected.png" alt="">
        <p style="color:#ff971d;">活动</p>
    </a>
    <a class="nav_option" href="/index.php/Mobile/User/user_center">
        <img src="<?php echo (MOBILE); ?>/images/icon-tabbar-my-default.png" alt="">
        <p>我的</p>
    </a>
</div>
</body>
<script src='<?php echo (MOBILE); ?>/js/jquery-3.0.0.min.js'></script>
<script src="<?php echo (MOBILE); ?>/js/angular.min.js"></script>
<script src='<?php echo (MOBILE); ?>/js/swiper.min.js'></script>
<script>
    // 轮播
    var mySwiper = new Swiper('.swiper-container', {
        pagination : '.swiper-pagination',
        paginationClickable :true,
        loop:true,
        // autoplay: 3000
    });
    var data={
        page:1,
        page_num: 4,            
        order_field:"create_time",
        category_id:0,
        tag_id:0,
        order_by:"DESC"
    }

    var app = angular.module("activity",[]);
    app.controller("actCtrl",function ($scope,$http){
        //  获取活动标签接口
        $http({
            method:'GET',
            url:'/api.php/ChannelIndex/index/action/dataList/channel/hd/type/4'
        }).then(function successCallback(response){
            $scope.options = response.data.data;
            // console.log( $scope.options[1].tag_name);
        },function errorCallback(){

        });

        //  获取活动列表接口
        $http({
            method: 'POST',
            data: data,
            url: '/api.php/ChannelIndex/index/action/dataList/channel/hd/type/1',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            transformRequest: function (obj) {
                var str = [];
                for (var p in obj) {
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                }
                return str.join("&");
            }
        }).then(function successCallback(response){
            var data=response.data.data;
            for (var i = 0; i < data.length; i++) {
                if(Date.parse(new Date())>(new Date(data[i].formal_end_time)).getTime()){
                    data[i]['status']="0";//已经举办过了
                }else{
                    data[i]['status']="1";//未举办
                    data[0]['have']="1";
                }
                
            };
            $scope.lists = data;
            // console.log( $scope.lists);
        },function errorCallback(){

        })
    });
</script>
</html>