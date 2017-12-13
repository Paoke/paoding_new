<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en" ng-app="login">
<head>
    <meta charset="UTF-8">
    <title>登录</title>
    <meta name="description" content="庖丁科技众包服务平台携手国内外先进技术科研院所、顶级技术专家，以实现科技成果市场化为核心，为企业提供快速精准的需求匹配服务，从而实现企业以及科技资源的有效对接，帮助企业实现产业技术升级，助力先进技术完成产业化发展。" />
    <meta name="keywords" content="庖丁众包、智能技术、机械制造、健康医疗、材料科学、能源环保、生产流程优化"/>
    <meta name='viewport' content='user-scalable=no,width=750'>
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/common_new.css">
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/my.css">
</head>
<body  ng-controller="myLogin">
    <div class="register_login">
        <a href="/index.php/Mobile/Login/login.html" class="reg_login reg_active">登录</a>
        <a href="/index.php/Mobile/Register/register.html" class="reg_login ">注册</a>
    </div>
    <form id="formID">
        <div class="regist_main">
            <div class="regist_input">
                <span class="regist_span">手机</span>
                <input type="text" placeholder="输入11位手机号" maxlength="11" name="mobile">
            </div>

            <div class="regist_input">
                <span class="regist_span">密码</span>
                <input type="password" placeholder="密码不少于6位数" name="password">
                <a href="/index.php/Mobile/login/find.html" class="fr">忘记密码</a>
            </div>
            <a class="register_btn">登 录</a>
        </div>

        <div class="register_logo">
            <img src="<?php echo (MOBILE); ?>/images/zc-logo.png" alt="">
        </div>
    </form>

</body>
<script src='<?php echo (MOBILE); ?>/js/jquery-3.0.0.min.js'></script>
<script src='<?php echo (MOBILE); ?>/js/angular.min.js'></script>
<script src='<?php echo (MOBILE); ?>/js/common.js'></script>
<script>
    var app = angular.module('login', []);
    app.controller('myLogin', function($scope,$http) {
        $(".register_btn").on("click",function(){
           var data = {};
           var t = $('#formID').serializeArray();
           $.each(t, function () {
               data[this.name] = this.value;
           });
           
        $http({
            method: 'POST',
            data:data,
            url: '/api.php/User/login',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },    
            transformRequest: function(obj) {    
                var str = [];    
                for (var p in obj) {    
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));    
                }    
                return str.join("&");    
            } 
        }).then(function successCallback(response) {
            // 登陆成功跳转到my.html
            if(response.data.result==1){
                alert("登录成功");
                window.location.href="/index.php/Mobile/User/user_center.html";
            }else{
                alert("登录失败");
            } 
            }, function errorCallback(response) {

        });
    });
    })  
</script>
</html>