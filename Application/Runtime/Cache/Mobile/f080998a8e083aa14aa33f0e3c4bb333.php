<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en" ng-app="userCenter">
<head>
    <meta charset="UTF-8">
    <title>我的</title>
    <meta name="description" content="庖丁科技众包服务平台携手国内外先进技术科研院所、顶级技术专家，以实现科技成果市场化为核心，为企业提供快速精准的需求匹配服务，从而实现企业以及科技资源的有效对接，帮助企业实现产业技术升级，助力先进技术完成产业化发展。" />
    <meta name="keywords" content="庖丁众包、智能技术、机械制造、健康医疗、材料科学、能源环保、生产流程优化"/>
    <meta name='viewport' content='user-scalable=no,width=750'>
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/common_new.css">
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/my.css">
</head>
<body ng-controller="myUserCen" style="padding-bottom:100px">

<input type="hidden" id="id" value="<?php echo session('userId');?>" />
<div class="my_header clear">
    <div class="my_head fl">
        <a href="/index.php/Mobile/User/change_head.html">
            <img src="{{ user.head_pic }}" alt="" >
        </a>
    </div>
    <div class="my_nameBox fl">
        <p class="my_name" ng-bind="user.nickname"></p>
        <a class="my_apply" ng-show="user.status=='1'">
            <div class="my_circle">
                <img src="<?php echo (MOBILE); ?>/images/icon-my-apply.png" alt="">
            </div>
            <span>已认证</span>
        </a>

        <a class="my_apply" ng-hide="user.status=='1'">
            <div class="my_circle">
                <img src="<?php echo (MOBILE); ?>/images/icon-my-apply.png" alt="">
            </div>
            <span>申请认证</span>
        </a>
    </div>
    <a href="/index.php/Mobile/User/user_info.html"><img class="my_header_jt" src="<?php echo (MOBILE); ?>/images/icon-right.png" alt=""></a>
</div>

<div class="my_project clear">
    <div class="clear fl my_project_left">
        <a href="" class="fl">
            <img src="<?php echo (MOBILE); ?>/images/icon-my-demand.png" alt="">
            <p>发布需求</p>
        </a>
        <a href="" class="fl">
            <img src="<?php echo (MOBILE); ?>/images/icon-my-technology.png" alt="">
            <p>发布技术</p>
        </a>
        <a href="" class="fl">
            <img src="<?php echo (MOBILE); ?>/images/icon-my-activity2.png" alt="">
            <p>我的活动</p>
        </a>
        <a href="" class="fl">
            <img src="<?php echo (MOBILE); ?>/images/icon-my-collect.png" alt="">
            <p>我的收藏</p>
        </a>
    </div>
    <a href="" class="fl a_project">
        <img src="<?php echo (MOBILE); ?>/images/icon-my-project.png" alt="">
        <p>对接项目</p>
    </a>
</div>

<a href="" class="my_hot_intro">热门推介位</a>

<a href="" class="my_secion clear">
    <span class="fl">认证中心</span>
    <img class="fr" src="<?php echo (MOBILE); ?>/images/icon-right2.png" alt="">
</a>
<a href="my-helpCenter.html" class="my_secion clear">
    <span class="fl">帮助中心</span>
    <img class="fr" src="<?php echo (MOBILE); ?>/images/icon-right2.png" alt="">
</a>
<a href="my-advice.html" class="my_secion clear">
    <span class="fl">意见反馈</span>
    <img class="fr" src="<?php echo (MOBILE); ?>/images/icon-right2.png" alt="">
</a>
<a href="my-set.html" class="my_secion clear">
    <span class="fl">设置</span>
    <img class="fr" src="<?php echo (MOBILE); ?>/images/icon-right2.png" alt="">
</a>

<div class="nav">
    <a class="nav_option" href="">
        <img src="<?php echo (MOBILE); ?>/images/icon-tabbar-technology-default.png" alt="">
        <p>技术</p>
    </a>
    <a class="nav_option" href="">
        <img src="<?php echo (MOBILE); ?>/images/icon-tabbar-demand-default.png" alt="">
        <p>需求</p>
    </a>
    <a class="nav_option" href="/index.php/Mobile/Activity/activity">
        <img src="<?php echo (MOBILE); ?>/images/icon-tabbar-activity-default.png.png" alt="">
        <p>活动</p>
    </a>
    <a class="nav_option" href="/index.php/Mobile/User/user_center">
        <img src="<?php echo (MOBILE); ?>/images/icon-tabbar-my-selected.png" alt="">
        <p style="color:#ff971d;">我的</p>
    </a>
</div>
</body>
<script src='<?php echo (MOBILE); ?>/js/jquery-3.0.0.min.js'></script>
<script src='<?php echo (MOBILE); ?>/js/angular.min.js'></script>
<script src='<?php echo (MOBILE); ?>/js/common.js'></script>
<script>
    var app = angular.module('userCenter', []);

    app.controller('myUserCen', function($scope,$http) {
        var id = $("#id").val();
        $http({
            method: 'GET',
            url: '/api.php/User/user_info/action/detail?id='+id,
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },    
            transformRequest: function(obj) {    
                var str = [];    
                for (var p in obj) {    
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));    
                }    
                return str.join("&");    
            } 
        }).then(function successCallback(response) {    
             $scope.user = response.data.data;
            }, function errorCallback(response) {

        });

    });
</script>
</html>