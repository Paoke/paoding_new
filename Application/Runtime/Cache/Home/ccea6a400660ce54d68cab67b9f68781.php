<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>5U</title>
<meta name="keywords" content="京墨5U">
<meta name="description" content="京墨5U">
<link type="text/css" href="/Public/home/css/css.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="/Public/home/css/style.css" />
<script type="text/javascript" src="/Public/home/js/jquery.js"></script>
<script type="text/javascript" src="/Public/home/js/register.js"></script>

<style type="text/css">
a{text-decoration:none; color:#969696; font-family: '',Microsoft YaHei,Tahoma,Arial,sans-serif;}
a:hover{color:#fff; text-decoration:none;}
input{ outline: none; border:none; }
.container{padding-top: 120px;;}
.register{ width: 400px; margin: 0 auto; padding-top:40px; position: relative; }
/*包裹表单项和对应的提示信息的容器的样式设置*/
.register-box{ width:100%; height: 52px; padding-bottom: 30px; }
/*表单项样式设置*/
.register-box .box{ width:100%; height:100%; line-height: 52px; padding-left: 10px; border: 1px solid #ccc; position: relative; font-size: 14px;}
.register-box .box.error{ border:1px solid red; }
.register-box .box input{ width:200px; font-size:16px; padding-left: 20px; }
/*验证通过*/
.register-box .box.right i{ width:20px; height: 20px; background: url(/Public/home/images/right.png) no-repeat center center; position: absolute; top:50%; margin-top: -10px; right: 10px; }
/*提示信息样式设置*/
.register-box .tip { width:100%; line-height: 30px; font-size: 12px; }
.register-box .tip i{ width: 20px; height: 20px; display: inline-block; vertical-align: middle; }
.register-box .tip span{ color: #CCCCCC; }
/*提示信息隐藏样式*/
.register-box .tip.hide{ display: none; }
/*提示信息默认样式*/
.register-box .tip.default i { background: url(/Public/home/images/default.png) no-repeat center center; }
.register-box .tip.default span{ color: #ccc; }
/*提示信息错误样式*/
.register-box .tip.error i { background: url(/Public/home/images/error.png) no-repeat center center; }
.register-box .tip.error span{ color: red; }
/*提示信息密码弱*/
.register-box .tip.ruo i { background: url(/Public/home/images/ruo.png) no-repeat center center; }
/*提示信息密码中*/
.register-box .tip.zhong i { background: url(/Public/home/images/zhong.png) no-repeat center center; }
/*提示信息密码中*/
.register-box .tip.qiang i { background: url(/Public/home/images/qiang.png) no-repeat center center; }
/*京东用户注册协议*/
.register-box.xieyi{ width:100%; height: 20px; padding-bottom: 30px; /*  background-color: #ccc; */}
.register-box.xieyi .box{ line-height: normal; padding: 0; border: none; }
.register-box.xieyi .box.error{ line-height: normal; padding: 0; border: 1px solid red; }
.register-box.xieyi .box input{ width: auto; }

.container h4{font-size: 20px;font-weight: 100;color:#333;text-align: center;padding:25px 0 15px;}
.container .input_box{padding:25px;box-sizing: border-box;margin:auto;margin-top:20px;}
.input_box:nth-of-type(1){background:url(/Public/home/images/id.png)no-repeat 17px center;background-size: 26px;}
.input_box:nth-of-type(2){background:url(/Public/home/images/pr.png)no-repeat 17px center;background-size: 26px;}
.login_btn{width: 350px;line-height:47px;text-align: center;font-size: 18px;background:#21a2dd;color:#f0f0f0;margin:auto;display:block; margin-top:15px;}
.login_btn:hover{ background-color: #0c83fa;color:#fff;}
.btom{overflow: hidden;width:350px;margin:auto;padding-top: 15px;}
.btom a:nth-of-type(1){float: left;font-size: 14px;color:#21a2dd;}
.btom a:nth-of-type(2){float: right;font-size: 14px;color:#21a2dd;}
.btom a:hover{color:#0c83fa;}


.infoBox{ width: 600px; height: 160px; position: fixed; left: 0; bottom:0; top: 0; right: 0; background: #fff; margin: auto; z-index: 9999; display:none;}
.back_2{position: fixed;left:0;top:0;right:0;bottom:0;margin:auto;background:#000;opacity:0.6;z-index: 99;display:none;}
.box-shadow{ width: 100%; height: 30px; overflow: hidden; background:#e7e7e7; text-align: center; font-size:16px; line-height: 30px; }
.infoBox input{width: 80%; margin: 20px 0 0 20px; float: left; height: 30px; display: block;  border-radius: 5px; border: 1px solid #e7e7e7; padding-left:5px; }
.btn{display: block;width: 70px;height: 35px; position: absolute; bottom:0; top: 50px; right: 8px; background: #238efa; text-align: center;border-radius: 5px; color:#fff; line-height: 30px; font-size: 16px;}
</style>
</head>

<body>
<!-- nav -->
<div class="nav_content" style="top:0;">
    <div class="nav_box">
        <nav>
            <div class="logo">
                <a class="" href="/index.php/Home/Index/index"><i></i>京墨5U<span>创建应用 不在烦恼</span></a>
            </div>
            <ul>
                <li><a href="/index.php/Home/Index/index">首页</a></li>
                <li><a href="javascript:;">产品</a></li>
                <li><a href="/index.php/Home/Trial/trialshow">试用</a></li>
                <li><a href="/index.php/Home/Consulting/consultingshow">咨询</a></li>
                <li><a href="/index.php/Home/Case/caseshow">案例</a></li>
                <li><a href="/index.php/Home/Help/helpshow">帮助</a></li>
            </ul>
            <div class="login">
                <a href="/index.php/Home/Index/login">登录</a>
                <a href="/index.php/Home/Index/register">注册</a>
            </div>
        </nav>
    </div>
</div>
<!-- nav_end -->

  <div class="container">
        <h4>京墨5U登陆</h4>
        <!--京东注册模块-->
        <div class="register">
            <!--用户名-->
            <div class="register-box">
                <!--表单项-->
                <div class="box default ">
                    <label for="userName" class="input_box"></label>
                    <input type="text" id="userName" placeholder="登录账号" />
                    <i></i>
                </div>
                <!--提示信息-->
                <div class="tip">
                    <i></i>
                    <span></span>
                </div>
            </div>
            <!--设置密码-->
            <div class="register-box">
                <!--表单项-->
                <div class="box default">
                    <label for="pwd"  class="input_box"></label>
                    <input type="password" id="pwd" placeholder="密码" />
                    <i></i>
                </div>
                <!--提示信息-->
                <div class="tip">
                    <i></i>
                    <span></span>
                </div>
            </div>
            <!--设置密码-->
        </div>
    </div>
    <a class="login_btn" href="javascript::">登陆</a>
    <div class="btom">
        <a href="javascript:;" class="btn-de">忘记密码</a>
        <a href="/index.php/Home/Index/register">注册</a>
    </div>

    <section class="secondBanner">
        <div class="back_2"></div>
        <div class="infoBox">
            <div class="box-shadow">请输入邮箱地址</div>
             <input type="text" id="userName" placeholder="列如：http//:569842612@qqOutlook.com" />
             <a href="javascript:;" class="btn">确定</a>
         </div>
    </section>


<!-- 滚动条JS就放此处 -->
<script type="text/javascript" src="/Public/home/js/jquery.nicescroll.js"></script>
<script type="text/javascript" src="/Public/home/js/nicescroll.js"></script>

</body>
</html>
<script type="text/javascript">
 jQuery.noConflict(); //将变量$的控制权让渡给prototype.js
(function($){ //定义匿名函数并设置形参为$

$(function(){ //匿名函数内部的$均为jQuery
    var validCode=true;
$(".code").click(function(){ //继续使用 $ 方法
    var time=60;
        var code=$(this);
        if (validCode) {
            validCode=false;
            code.addClass("code1");
        var t=setInterval(function () {
            time--;
            code.html(time+"秒");
            if (time==0) {
                clearInterval(t);
            code.html("重新获取");
                validCode=true;
            code.removeClass("code1");
            }
        },1000)
        }
    });
});

// ------
  $(function(){
        $('.btn-de').click(function(event){
            $('.infoBox').show();
            $('.back_2').show();
        });

        $('.btn').click(function(event){
            $('.infoBox').hide();
            $('back_2').hide();
        });
         $('.btn').click(function(event){
            $('.infoBox').hide();
            $('.back_2').hide();
        });
    })


})(jQuery); //执行匿名函数且传递实参jQuery



</script>