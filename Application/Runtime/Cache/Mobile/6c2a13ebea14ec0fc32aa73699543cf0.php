<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en" ng-app="find">
<head>
    <meta charset="UTF-8">
    <title>我的</title>
    <meta name="description" content="庖丁科技众包服务平台携手国内外先进技术科研院所、顶级技术专家，以实现科技成果市场化为核心，为企业提供快速精准的需求匹配服务，从而实现企业以及科技资源的有效对接，帮助企业实现产业技术升级，助力先进技术完成产业化发展。" />
    <meta name="keywords" content="庖丁众包、智能技术、机械制造、健康医疗、材料科学、能源环保、生产流程优化"/>
    <meta name='viewport' content='user-scalable=no,width=750'>
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/common_new.css">
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/my.css">
</head>
<body ng-controller="findCtrl">
<div class="mask" style="display: none;"></div>
<div class="psw_reset" style="display: none;">
    <p>密码重置成功</p>
    <a href="">马上去登录...</a>
</div>

<form id="formID">
    <div class="regist_main" style="margin-top:120px">
        <div class="regist_input">
            <span class="regist_span">手机</span>
            <input type="text" placeholder="输入11位手机号" id="mobile" name="mobile">
            <input type='button' class="fr getIdentify" value='发送验证码'>
        </div>

        <div class="regist_input">
            <span class="regist_span">验证码</span>
            <input type="text" placeholder="输入您收到的验证码" name="code" id="code">
        </div>

        <div class="regist_input">
            <span class="regist_span">新密码</span>
            <input type="password" placeholder="新密码由6-20位字符组成，区分大小写" style="width:550px" id="password" name="password">
        </div>
        <p class="register_btn">重置密码</p>
    </div>
</form>


<div class="register_logo">
    <img src="<?php echo (MOBILE); ?>/images/zc-logo.png" alt="">
</div>
</body>
<script src='<?php echo (MOBILE); ?>/js/jquery-3.0.0.min.js'></script>
<script src='<?php echo (MOBILE); ?>/js/common.js'></script>
<script src='<?php echo (MOBILE); ?>/js/angular.min.js'></script>
<script src='<?php echo (MOBILE); ?>/js/return.js'></script>
<script>
    var countdown=60;  
    var mobile,code,password;
    var tip = {
        tip_ct:"",
    };
    var tips = {
        addtips:function(tip_ct){
            var tipNode = '<div class="tipCommon" style="display:block">'+tip_ct+'</div>';
            $('body').append(tipNode);
            setTimeout(function(){
                $(".tipCommon").remove();
            },1500)
        }
    }
    var app = angular.module('find', []);
    app.controller('findCtrl', function($scope,$http) {
      
        $(".getIdentify").on("click",function(){
            var regTel = /^[1][3,4,5,7,8][0-9]{9}$/;
            mobile = $('#mobile').val();
            if(!regTel.test(mobile)){
                tip_ct = "请输入正确的手机号码";
                tips.addtips(tip_ct);
                return false;
            }
            else{
                goTime();
                // 获取注册验证码
                $http({
                    method: 'POST',
                    url: '/api.php/Sms/sendMessage',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },    
                    transformRequest: function(obj) {    
                        var str = [];    
                        for (var p in obj) {    
                            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));    
                        }    
                        return str.join("&");    
                    } 
                }).then(function successCallback(response) {
                     console.log(response);
                    }, function errorCallback(response) {

                });

            }
        });

        // 忘记密码接口
        $(".register_btn").on("click",function(){
            var regPsw = /^.{6,}$/;
            password = $('#password').val();
            if(!regPsw.test(password)){
                    tip_ct = "密码不少于6位数";
                    tips.addtips(tip_ct);
                    return false;
            }
            else{
                var data = {};
                var t = $("#formID").serializeArray();
                $.each(t, function() {
                    data[this.name] = this.value;
                });               
                $http({
                    method: 'POST',
                    data:data,
                    url: '/api.php/User/reset_by_code',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },    
                    transformRequest: function(obj) {    
                        var str = [];    
                        for (var p in obj) {    
                            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));    
                        }    
                        return str.join("&");    
                    } 
                }).then(function successCallback(response) {
                     console.log(response);
                    }, function errorCallback(response) {

                });
            }

        })
    })

    function goTime() {
     var mobile=$('#mobile').val();
     if (countdown == 0) {           
         $('.getIdentify').attr("disabled",false);    

         $('.getIdentify').val("重新发送");          
         countdown = 60;   
     } else {            
         $('.getIdentify').attr("disabled",true); 
         $('.getIdentify').css('background','#fff');
         $('.getIdentify').val("重新发送(" + countdown + ")"); 
         countdown--;   
         setTimeout(function() {   
             goTime()   
         },1000);   
     }   
    }    
</script>
</html>