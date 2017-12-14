<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en"  ng-app="userInfo">
<head>
    <meta charset="UTF-8">
    <title>个人信息</title>
    <meta name="description" content="庖丁科技众包服务平台携手国内外先进技术科研院所、顶级技术专家，以实现科技成果市场化为核心，为企业提供快速精准的需求匹配服务，从而实现企业以及科技资源的有效对接，帮助企业实现产业技术升级，助力先进技术完成产业化发展。" />
    <meta name="keywords" content="庖丁众包、智能技术、机械制造、健康医疗、材料科学、能源环保、生产流程优化"/>
    <meta name='viewport' content='user-scalable=no,width=750'>
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/common_new.css">
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/my.css">
</head>
<body ng-controller="myInfo">
    <input type="hidden" id="id" value="<?php echo ($user_id); ?>" />
    <p class="ifm_tit">个人信息</p>
    <div class="ifm_head_wrap">
        <div class="ifm_head">
            <img class="ifm_deafault" src="{{ user.head_pic }}" alt="">
            <img class="ifm_camera" src="<?php echo (MOBILE); ?>/images/icon-camera.png" alt="">
        </div>
    </div>

    <a href="/index.php/Mobile/User/user_authen.html"  ng-hide="user.status=='1'">
        <div class="apply_content_box chose clear">
            <span class='apply_word fl'>申请认证</span>
            <img  class='fr content_jt' src="<?php echo (MOBILE); ?>/images/icon-right2.png" alt="">

        </div>
    </a>
    <a href="/index.php/Mobile/User/change_nickname.html">
        <div class="apply_content_box chose clear">
            <span  class='apply_word fl'>昵称</span>
            <img  class='fr content_jt' src="<?php echo (MOBILE); ?>/images/icon-right2.png" alt="">
            <input style="color:#666;" class='apply_means fr' type="text" ng-value="user.nickname">
        </div>
    </a>
    <a href="#">
        <div class="apply_content_box chose clear">
            <span class='apply_word fl'>手机</span>
            <img  class='fr content_jt' src="<?php echo (MOBILE); ?>/images/icon-right2.png" alt="">
            <input style="color:#666;" class='apply_means fr' type="text" ng-value="user.mobile">
        </div>
    </a>
</body>
<script src='<?php echo (MOBILE); ?>/js/jquery-3.0.0.min.js'></script>
<script src='<?php echo (MOBILE); ?>/js/angular.min.js'></script>
<script src='<?php echo (MOBILE); ?>/js/common.js'></script>
<script src='<?php echo (MOBILE); ?>/js/return.js'></script>
<script>
    var app = angular.module('userInfo', []);

    app.controller('myInfo', function($scope,$http) {
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