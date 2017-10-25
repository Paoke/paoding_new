<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>注册</title>
	<meta name="description" content="庖丁科技众包服务平台携手国内外先进技术科研院所、顶级技术专家，以实现科技成果市场化为核心，为企业提供快速精准的需求匹配服务，从而实现企业以及科技资源的有效对接，帮助企业实现产业技术升级，助力先进技术完成产业化发展。" />   
	<meta name="keywords" content="庖丁众包、智能技术、机械制造、健康医疗、材料科学、能源环保、生产流程优化"/>
	<meta name='viewport' content='user-scalable=no,width=750'>
	<link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/common_new.css">
	<link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/my.css">
</head>
<body>
	<div class="register_login">
		<a href="register.html" class="reg_login ">登录</a>
		<a href="login.html" class="reg_login reg_active">注册</a>
	</div>

	<div class="regist_main">
		<div class="regist_input">
			<span class="regist_span">手机</span>
			<input type="text" placeholder="输入11位手机号" maxlength="11">
			<input type='button' class="fr getIdentify" value='发送验证码'>
		</div>

		<div class="regist_input">
			<span class="regist_span">验证码</span>
			<input type="text" placeholder="输入您收到的验证码">
		</div>

		<div class="regist_input">
			<span class="regist_span">密码</span>
			<input type="password" placeholder="密码不少于6位数">
		</div>

		<div class="regist_input" style="margin-bottom:10px">
			<span class="regist_span">昵称</span>
			<input type="text" placeholder="不做无名之辈">
		</div>

		<div class="regist_tip clear">
			<div class="fl regist_tip_icon"></div>
			<span class="fl">无效的验证码，请重新输入</span>
		</div>

		<a href="" class="register_btn">注 册</a>

		<div class="regist_tip clear">
			<div class="fl regist_tip_icon2"></div>			
			<p class="fl"><span style="color:#ccc">我已阅读并同意</span><span>庖丁众包服务条款</span></p>
		</div>

		<div class="register_logo">
			<img src="<?php echo (MOBILE); ?>/images/zc-logo.png" alt="">
		</div>
	</div>


</body>
<script src='<?php echo (MOBILE); ?>/js/jquery-3.0.0.min.js'></script>
<script src='<?php echo (MOBILE); ?>/js/common.js'></script>
</html>