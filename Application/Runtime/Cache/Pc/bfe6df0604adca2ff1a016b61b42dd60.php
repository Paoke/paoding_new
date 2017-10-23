<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="shortcut icon" href="/Template/5u/pc/Static/img/favicon.ico">
	<title>个人中心</title>
	<link rel="stylesheet" type="text/css" href="/Template/5u/pc/Static/css/swiper.min.css"/>
	<link rel="stylesheet" type="text/css" href="/Template/5u/pc/Static/css/index.css"/>
	<link rel="stylesheet" type="text/css" href="/Template/5u/pc/Static/font/iconfont.css"/>
	<style>
		.layui-layer-content{padding:30px 30px 30px 30px;}
		.size{font-size: 24px;}
		.ying{
			position: absolute;
			opacity: 0;
			left: 256px;
			top: 707px;
			height: 30px;
			width: 150px;
		}
		.File{
			position: absolute;
			opacity: 0;
			left: 376px;
			top: 779px;
			height: 30px;
			width: 150px;
		}
		.mation{
			position: absolute;
			opacity: 0;
			left: 396px;
			top: 858px;
			height: 30px;
			width: 150px;
		}
	</style>
	<style>
		.long{
			position: absolute;
			opacity: 0;
			left: 396px;
			top: 859px;
			height: 30px;
			width: 150px;
		}
		.data{
			position: absolute;
			opacity: 0;
			left: 395px;
			top: 780px;
			height: 30px;
			width: 150px;
		}
		.patents{
			position: absolute;
			opacity: 0;
			left: 396px;
			top: 859px;
			height: 30px;
			width: 150px;
		}
		.Technology{
			position: absolute;
			opacity: 0;
			left: 256px;
			top: 705px;
			height: 30px;
			width: 150px;
		}
		.uploadFile{
			position: absolute;
			opacity: 0;
			left: 256px;
			top: 626px;
			height: 30px;
			width: 150px;
		}
		.getFiles{
			position: absolute;
			opacity: 0;
			left: 376px;
			top: 701px;
			height: 30px;
			width: 150px;
		}
		.information{
			position: absolute;
			opacity: 0;
			left: 396px;
			top: 779px;
			height: 30px;
			width: 150px;
		}
		.Tech{
			position: absolute;
			opacity: 0;
			left: 256px;
			top: 627px;
			height: 30px;
			width: 150px
		}
		.datese{
			position: absolute;
			opacity: 0;
			left: 395px;
			top: 699px;
			height: 30px;
			width: 150px;
		}
		.pat{
			position: absolute;
			opacity: 0;
			left: 396px;
			top: 781px;
			height: 30px;
			width: 150px;
		}
		.patent{
			display: none;
		}
		.type{
			position: absolute;
			opacity: 0;
			left: 395px;
			top: 699px;
			height: 30px;
			width: 150px;
		}
		.pats{
			position: absolute;
			opacity: 0;
			left: 396px;
			top: 779px;
			height: 30px;
			width: 150px;
		}
		.tp{
			position: absolute;
			opacity: 0;
			left: 396px;
			top: 860px;
			height: 30px;
			width: 150px;
		}
		.disp{
			display: none;
		}
		.pts{
			position: absolute;
			opacity: 0;
			left: 396px;
			top: 780px;
			height: 30px;
			width: 150px;
		}
		.Tec{
			position: absolute;
			opacity: 0;
			left: 256px;
			top: 627px;
			height: 30px;
			width: 150px;
		}
		.too{
			position: absolute;
			opacity: 0;
			left: 395px;
			top: 858px;
			height: 30px;
			width: 150px;
		}
		.to2{
			position: absolute;
			opacity: 0;
			left: 395px;
			top: 779px;
			height: 30px;
			width: 150px;
		}
	</style>
</head>
<?php if(CONTROLLER_NAME == Activity): ?><body onresize="ButWidth()">
	<?php else: ?>
	<body><?php endif; ?>
<?php if(CONTROLLER_NAME == Index and ACTION_NAME == index): ?><header class="head2 outside">
		<?php else: ?>
		<header class="head outside"><?php endif; ?>
<div class="center">
	<a href="<?php echo U('Index/index');?>" class="head_logo"><img style="padding-top: 12px;" src="/Template/5u/pc/Static/img/logo.png"/></a>
	<nav class="navigation">
		<ul class="navigation-list ul-reset">
			<li class="navigation-item ib">
				<a href="/index.php/Pc/Index/index" class='navigation-link'>
					首页
				</a>
			</li>
			<li class="navigation-item ib">
				<a href="/index.php/Pc/Article/data_list/channel/js" class='navigation-link'>
					技术
				</a>
			</li>
			<li class="navigation-item ib">
				<a href="/index.php/Pc/Article/data_list/channel/hzjg" class='navigation-link'>
					合作机构
				</a>
			</li>
			<li class="navigation-item ib">
				<a href="/index.php/Pc/Article/data_list/channel/xq" class='navigation-link'>
					需求
				</a>
			</li>
			<li class="navigation-item ib">
				<a href="/index.php/Pc/Activity/data_list/channel/hd" class='navigation-link'>
					活动
				</a>
			</li>
			<li class="navigation-item ib">
				<a href="/index.php/Pc/Article/data_list/channel/zx" class='navigation-link'>
					资讯
				</a>
			</li>
		</ul>
	</nav>
	<ul class="head_nav_right">
		<li class="head_navLi head_searchLI">
			<form action="/index.php/Pc/Index/search">
				<div class="head_search">
					<input class="head_input" type="text" name="keyword" id="" value="" placeholder="请输入您要搜索的内容"/>
				</div>
				<input class="head_searchImg" type="submit" name="" id="" value="" />
				<i class="iconfont icon-iconfontsousuo1"></i>
			</form>
		</li>
		<li class="head_navLi">
			<a href="javascript:;" class="modal-wechat">关注公众号</a>
			<div id="wechatModal" class="wechat-modal hide">
				<img src="/Template/5u/pc/Static/img/wechatm.png"/>
			</div>
		</li>
		<li class="head_navLi head_user">
			<?php if(session('userArr') != null): ?><a style="height: 55px;line-height: 55px;" href="javascript:;"><img class="head_portrait" src="<?php echo session('headPic');?>"/></a>
				<ul class="head_userUl">
					<li class="head_userLi"><a href="/index.php/Pc/User/user_info">个人中心</a></li>
					<li class="head_userLi"><a  href="javascript:;" onclick="logout('/<?php echo (API_PATH); ?>/User/logout','/index.php/Pc/Index/index')">退出</a></li>
				</ul>
				<?php else: ?>
				<a class="head_login" href="javascript:;">登录</a><?php endif; ?>
		</li>
	</ul>
</div>
</header>
<section id="template">
	<div class="science_list outside">
		<div class="center user_center">
			<div class="user_widget">
				<div class="user_widget_header">
					个人中心
				</div>
				<div class="user_widget_body">
					<a href="/index.php/Pc/User/user_center" class='desc_list '>我提交的咨询</a>
					<a href="/index.php/Pc/User/user_authen" class='desc_list active'>认证</a>
					<a href="/index.php/Pc/User/user_info" class='desc_list '>基础资料</a>
					<a href="/index.php/Pc/User/user_security" class='desc_list '>账号安全</a>
					<a href="#" onclick="logout('/<?php echo (API_PATH); ?>/User/logout','/index.php/Pc/Index/index')" class="desc_list">退出</a>
				</div>
			</div>
			<div class="user_body">
				<div class="body_header">认证</div>
				<div class="body_content" >
					<form>
						<div class="user_desc" >
							<label>类别</label>
							<select class="small form-option" id="typecar"   name="" style="font-size: 14px;" onchange="ifcarId(this)">
								<option value="0"  >公司</option>
								<option value="1"  >个人</option>
							</select>
						</div>
						<div class="user_desc hide" id="companyNameId">
							<label >公司名</label>
							<input class="user_input" maxlength="20" id="company_name" v-model="userInfo.company_name"   type="text"/>
						</div>
						<div class="user_desc ">
							<label id="tyshxydm">统一社会信用代码</label>
							<input class="user_input" maxlength="20" id="company_code" v-model="userInfo.company_code"   type="text"/>
						</div>

						<div class="user_desc">
							<label>技术领域</label>
							<input class="user_input" maxlength="20" id="tech_field"  v-model="userInfo.tech_field"  type=" 0                                                                                                                                                                                                                                                    "/>
						</div>

						<div class="user_desc">
							<label>希望展示的内容</label>
							<textarea class="contact_need" id="desc"  v-model="userInfo.desc" cols=""></textarea>
						</div>

						<div class="user_desc" >
							<label>专利</label>
							<select class="small form-option zuanli" id="has_patent" onclick="tent()" name="" style="font-size: 14px;">
								<option value="0"  >无</option>
								<option value="1"  >有</option>
							</select>
						</div>
						<div class="user_desc">
							<label id="business">营业执照</label>
							<!--<img alt=""  width="200" height="200">-->
							<img alt="" v-bind:src="userInfo.company_pic" id="company_pic" width="200" height="200">
							<input class="upload_btn" type="button"  value="上传文件">
							<input id="upload" class="uploadFile" type="file" name="company_pic" onchange="readFile()"/>
						</div>
						<div class="user_desc">
							<label>技术资料</label>
							<!--<img alt="" v-bind:src="<?php echo session('head_pic');?>" id="avatarId">-->
							<input type="hidden" id="tech_file_base64" name="tech_file_base64" value="">
							<input class="user_input" maxlength="20" v-bind:src="userInfo.tech_file" name="tech_file"  id="tech_file" v-bind:value="userInfo.tech_file" readonly="readonly"  style="background:#e2e2e2"/>
							<input class="upload_btn" type="button" value="上传文件" >
							<input id="getFiles"   class="getFiles"  type="file" name="tech_file" onchange="handleFile(this)"/>
							<span>&nbsp;&nbsp;&nbsp;&nbsp;请上传zip压缩包</span>
						</div>
						<div class="user_desc tent">
							<label>专利资料</label>
							<!--<img alt="" v-bind:src="<?php echo session('head_pic');?>" id="avatarId">-->
							<!--<img alt="" v-bind:src="userInfo.head_pic" id="avatarId">-->
							<input type="hidden" id="patent_file_base64" name="patent_file_base64" value="">
							<input class="user_input" maxlength="20" v-bind:src="userInfo.patent_file" name="patent_file" id="patent_file" v-bind:value="userInfo.patent_file" readonly="readonly" style="background:#e2e2e2"/>
							<input class="upload_btn" type="button" value="上传文件" >
							<input id="information" class="information" type="file" name="patent_file" onchange="patentFile(this)" />
							<span>&nbsp;&nbsp;&nbsp;&nbsp;请上传zip压缩包</span>
						</div>
						<input type="button" class="sub_btn" value="保 存" onclick="save()" />
					</form>

				</div>
			</div>
		</div>
	</div>
	<footer class="foot outside">
		<div class="center">
			<ul class="footUl">
				<li class="footLi_left" style="padding-left: 10px;">
					<img src="/Template/5u/pc/Static/img/logo.png"/>
				</li>
				<li class="footLi_left">
					<p class="f1">联系电话</p>
					<p class="f2" v-text="configData.company_phone"></p>
				</li>
				<li class="footLi_left">
					<p class="f1">邮箱</p>
					<p class="f2" v-text="configData.company_smtp_user"></p>
				</li>
				<li class="footLi_left">
					<p class="f1">地址</p>
					<p class="f2" v-text="configData.company_address"></p>
				</li>
				<li class="footLi_right">
					<img src="/Template/5u/pc/Static/img/erweima2.jpg"/>
				</li>
			</ul>
		</div>
		<div class="center foot_icp">
			<span onclick="fuwxy()">服务协议</span>
			<span onclick="aboutUs()">关于我们</span>
			{{configData.company_store_name}}.ALL Rights Reaerved.<a href="http://www.miitbeian.gov.cn/">{{configData.company_record_no}}</a>
		</div>
	</footer>
</section>
<div class="cover outside"></div>
<div class="login_page">
	<div class="login-modal">
		<div class="login_leftPage login_entry" style="display: block;">
			<div class="login-head">
				登录
			</div>
			<div class="login-body">
				<input class="text-input" type="text" id="username" value="" placeholder="手机号码"/>
				<input type="password" id="password" value="" placeholder="密码"/>
				<a class="login_leftPageBut" id="login" onclick="login('/<?php echo (API_PATH); ?>/User/login')">登录</a>
				<span class="login_leftPageNone">没有账号?<a class="register" style="color: #ff6601;" href="javascript:;">立即注册</a></span>
				<a class="login_leftPageForgot forget" href="javascript:;">忘记密码</a>
				<div class="clear"></div>
			</div>
		</div>
		<div class="login_leftPage login_register">
			<div class="login-head">
				注册
			</div>
			<div class="login-body">
				<input type="text" id="mobile" value="" placeholder="手机号码"/>
				<input type="text" id="code" value="" placeholder="验证码" class="login_leftPageCode"/>
				<button class="login_leftPageGetcode" id="getphonecode" onclick="get_code('/<?php echo (API_PATH); ?>/Sms/sendMessage')">获取验证码</button>
				<input type="password" id="paswd" value="" placeholder="密码（不少于6位）"/>
				<a class="login_leftPageBut" id="register" onclick="register('/<?php echo (API_PATH); ?>/User/register')">注册</a>
				<a class="login_leftPageForgot entry" href="javascript:;">登录</a>
				<div class="clear"></div>
			</div>
		</div>
		<div class="login_leftPage login_forget">
			<div class="login-head">
				重设密码
			</div>
			<div class="login-body">
				<input type="text" id="mobnum" value="" placeholder="手机号码"/>
				<input type="text" id="mobyzm" value="" placeholder="验证码" class="login_leftPageCode"/>
				<button class="login_leftPageGetcode" id="getmobyzm" onclick="verification('/<?php echo (API_PATH); ?>/Sms/sendMessage')">获取验证码</button>
				<input type="password" id="newpwd" value="" placeholder="新密码（不少于6位）"/>
				<a class="login_leftPageBut" id="resetpwd" onclick="reset('/<?php echo (API_PATH); ?>/User/reset_by_code')">重设密码</a>
				<span class="login_leftPageNone"><a class="register2" style="color: #ff6601;" href="javascript:;">注册</a></span>
				<a class="login_leftPageForgot entry2" href="javascript:;">登录</a>
				<div class="clear"></div>
			</div>
		</div>
		<div class="login_right">
			<a class="login_close" href="javascript:;"><img class="login_closeImg" src="/Template/5u/pc/Static/img/login_close.jpg"/></a>
			<div class="clear"></div>
			<img class="login-wechat" alt="" src="/Template/5u/pc/Static/img/wechat11.png">
			<a class="login_rightTow" onclick="WeChatLogin()">
				微信登录
			</a>
		</div>
	</div>

	<div class="clear"></div>
</div>
<div class="contact">
	<a class="login_close" href="javascript:;"><img class="login_closeImg" src="/Template/5u/pc/Static/img/login_close.jpg"/></a>
	<div class="contact-head">
		联系我们
	</div>
	<div class="contact-body">
		<textarea class="contact_need" id="jumpMessage" rows="5" cols=""></textarea>
		<input type="text" value="" placeholder="姓名" id="jumpName" />
		<input type="text" value="" placeholder="手机号码" id="jumpMobile" />
		<input type="text" value="" placeholder="验证码" id="jumpCode" />
		<button class="login_leftPageGetcode" id="jumpGetCode">获取验证码</button>
		<a class="login_leftPageBut" id="jumpSubmit">提交</a>
		<span style="display:none;" id="fid"><?php echo ($fatherId); ?></span>
		<span style="display:none;" id="sid"><?php echo ($sonId); ?></span>
	</div>
</div>
<div id="tips" class="tips hide">
</html>

<script src="/Template/5u/pc/Static/js/jquery-2.1.0.js" type="text/javascript" charset="utf-8"></script>
<script src="/Template/5u/pc/Static/js/swiper.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/Template/5u/pc/Static/js/index.js" type="text/javascript" charset="utf-8"></script>
<script src="/Template/5u/pc/Static/js/jquery.md5.js" type="text/javascript"></script>
<script src="/Template/5u/pc/Static/js/common.js" type="text/javascript"></script>
<script src="/Template/5u/pc/Static/js/jquery.cookie.js" type="text/javascript" ></script>
</div>
<span style="display:none" id="jumpUrl">
			<?php if((CONTROLLER_NAME == Index) OR (CONTROLLER_NAME == Science)): echo U('Science/commit');?>
				<?php elseif(CONTROLLER_NAME == Task): ?>
				<?php echo U('Task/commit');?>
				<?php else: ?>
				<?php echo U('Dev/commit'); endif; ?>
		</span>
<script type='text/javascript'>
	(function(m, ei, q, i, a, j, s) {
		m[i] = m[i] || function() {
					(m[i].a = m[i].a || []).push(arguments)
				};
		j = ei.createElement(q),
				s = ei.getElementsByTagName(q)[0];
		j.async = true;
		j.charset = 'UTF-8';
		j.src = '//static.meiqia.com/dist/meiqia.js';
		s.parentNode.insertBefore(j, s);
	})(window, document, 'script', '_MEIQIA');
	_MEIQIA('entId', 10556);
</script>
</body>

<script src="/Public/js/vue.js"></script>
<script src="/Public/js/layer/layer-min.js"></script>
<script>
	function tent(){
		var patent = $("#has_patent").val();
		var options=$("#typecar option:selected");
		var type=options.text();
		if(type=="个人" && patent==1){
			$("#information").removeClass("too");
			$("#information").addClass("to2");
		}
		if(type=="公司" && patent==1){
			$("#information").removeClass("to2");
			$("#information").addClass("too");
		}
		if(patent==0){
			$(".user_desc.tent").addClass("patent");
		}else if(patent==1 && type=="公司"){
			$(".user_desc.tent").removeClass("patent");
			$("#information").removeClass("to2");
			$("#information").addClass("too");
		}else if(patent==1 && type=="个人"){
			$("#information").removeClass("too");
			$("#information").addClass("to2");
		}else if(patent==1) {
			$("#information").removeClass("to2");
			$("#information").addClass("too");
		}

	}

	function fuwxy(){
		var url = "/<?php echo (API_PATH); ?>/Paoding/getFwxy";
		$.get(url, function (res) {
			var  html='<div style="text-indent: 2em;"><p style="text-align: center;" class="size">服务协议</p>';
			html+="</br>";
			if(res.result ==1){}
			html+=res.data;

			layer.open({
				type: 1,
				area: ['820px', '540px'], //宽高
				shadeClose: true, //开启遮罩关闭
				content: html
			});
			var show=	$(".layui-layer-title").hide();
		})
	}
	function aboutUs(){
		var url = "/<?php echo (API_PATH); ?>/Paoding/getAboutUs";
		$.get(url, function (res) {
			var  html='<div style="text-indent: 2em;"><p style="text-align: center;" class="size">关于我们</p>';
			html+="</br>";
			if(res.result ==1){}
			html+=res.data;

			layer.open({
				type: 1,
				area: ['820px', '540px'], //宽高
				shadeClose: true, //开启遮罩关闭
				content: html
			});
			var show=	$(".layui-layer-title").hide();
		})
	}
	function Regis(){
		var url = "/<?php echo (API_PATH); ?>/Paoding/getZcxy";
		$.get(url, function (res) {
			var  html='<div style="text-indent: 2em;"><p style="text-align: center;" class="size">用户注册协议</p>';
			html+="</br>";
			if(res.result ==1){}
			html+=res.data;

			layer.open({
				type: 1,
				area: ['820px', '540px'], //宽高
				shadeClose: true, //开启遮罩关闭
				content: html
			});
			var show=	$(".layui-layer-title").hide();
		})
	}
	$(function () {
		/*setTimeout("getUser()",100);*/
		getUser();

	});
	function getUser() {
		var ifWeChatLogin = "<?php echo ($ifWeChatLogin); ?>";
		if(ifWeChatLogin == 1) {
			var url = "/<?php echo (API_PATH); ?>/User/WeChatLogin/code/<?php echo ($code); ?>";
			$.get(url, function (res) {
				window.location.href="/index.php/Pc/User/user_authen"
			})
		}
	}
	function  WeChatLogin() {
		var url = "/<?php echo (API_PATH); ?>/User/getAppIdData";
		$.get(url, function (res) {
			if(res.result == 1) {
				window.location.href="https://open.weixin.qq.com/connect/qrconnect?appid="+res.data['appid']+"&redirect_uri=http://"+res.data['area_name']+"//index.php/Pc/User/user_authen/ifWeChatLogin/1&response_type=code&scope=snsapi_login&state=2015#wechat_redirect";
			} else {
				layer.msg("系统繁忙请稍后再试！");
			}
		})

	}
	var ifcaror = true;
	function ifcarId(){
		//var typeid = $("#typecar").text();
		var options=$("#typecar option:selected");
		var typeid=options.text();
		if(typeid == "个人") {
			$("#tyshxydm").text("身份证号码");
			$("#companyNameId").addClass("hide");

			$("#upload").removeClass("Technology");
			$("#upload").addClass("uploadFile");

			$("#getFiles").removeClass("data");
			$("#getFiles").addClass("getFiles");

			$("#information").removeClass("too");
			$("#information").addClass("to2");
		} else {
			$("#tyshxydm").text("统一社会信用代码");
			$("#companyNameId").removeClass("hide");

			$("#upload").removeClass("uploadFile");
			$("#upload").addClass("ying");

			$("#getFiles").removeClass("getFiles");
			$("#getFiles").addClass("File");

			$("#information").removeClass("to2");
			$("#information").addClass("too");
		}
		if(typeid==1){
			$("#business").text("真实头像");
		}else if(typeid==0){
			$("#business").text("营业执照");
		}
		ifcaror = !ifcaror;
	}
	$(function(){
		var url = "/<?php echo (API_PATH); ?>/User/user_authen/action/detail/id/<?php echo ($userId); ?>";
		$.post(url,function(res){
			var data=res.data;
			var type=data.type;
			var has_patent=data.has_patent;
			if(has_patent==0){
				$("#upload").removeClass("Technology");
				$("#upload").addClass("Tec");
			}else {
				$("#upload").removeClass("Technology");
				$("#upload").addClass("Tec");
			}
			if(type=="个人"){
//				$("#information").removeClass("too");

				$("#getFiles").removeClass("data");
				$("#getFiles").addClass("type");
			}
			if(has_patent==1){
				$("#information").removeClass("patents");
				$("#information").addClass("pats");
			}
			if(type=="公司"){
				$("#information").removeClass("pats");
				$("#information").addClass("too");

				$("#upload").removeClass("Tec");
				$("#upload").addClass("Technology");
			}
		})
	})


	$(function(){
		var options=$("#typecar option:selected");
		var  typeid=options.val();
		if(typeid==1){
			$("#business").text("真实头像");

			$("#upload").removeClass("Technology");
			$("#upload").addClass("Tech");

			$("#getFiles").removeClass("data");
			$("#getFiles").addClass("datese");

			$("#information").removeClass("patents");
			$("#information").addClass("pat");
		}
		if(typeid==0) {

			$("#business").text("营业执照");

			$("#upload").removeClass("uploadFile");
			$("#upload").addClass("Technology")

			$("#getFiles").removeClass("getFiles");
			$("#getFiles").addClass("data");

			$("#information").removeClass("information")
			$("#information").addClass("patents");
		}

	});

	function save(){
		var url = "/<?php echo (API_PATH); ?>/User/user_authen/action/edit/id/<?php echo ($userId); ?>";
		var options=$("#typecar option:selected");
		var type=options.text();
		var company_code=$("#company_code").val();
		var company_name=$("#company_name").val();
		var tech_field=$("#tech_field").val();
		var desc=$("#desc").val();
		var patent=$("#has_patent option:selected");
		var has_patent=patent.val();
		var status=1;
		var data = {
			"type":type,
			"company_code":company_code,
			"company_name":company_name,
			"tech_field":tech_field,
			"desc":desc,
			"has_patent":has_patent,
			"status":status
		};
		$.post(url, data, function(ret){
			if(ret.result == 1){
				tip.setBody('保存成功');
				window.location.reload();
			}else{
				tip.setBody('保存失败');
				window.location.reload();
			}
		}, 'json');
	}
	$(function(){
		var url = "/<?php echo (API_PATH); ?>/User/user_authen/action/detail/id/<?php echo ($userId); ?>";
		$.post(url,function(res){
			var data=res.data;
			if(data.has_patent==0){
				$(".small.form-option.zuanli").empty();
				$(".user_desc.tent").addClass("patent");
				$("#has_patent").append('<option value="0"  >无</option>');
				$("#has_patent").append('<option value="1"  >有</option>');
			}
			if(data.has_patent==1){
				$(".small.form-option.zuanli").empty();
				$("#has_patent").append('<option value="1"  >有</option>');
				$("#has_patent").append('<option value="0"  >无</option>');
			}
		});

	})

</script>
<script>
	var vm = new Vue({
		el:'#template',
		data:{
			configData: '', //列表数据
			userInfo:''
		},
		mounted: function () {
			this.$nextTick(function () {
				this.getConfigData();
				this.getUserInfo();
			})
		},
		updated:function(){

		},
		filters: {
		},
		methods:{
			getConfigData:function () {
				var _this = this;
				var url = "/<?php echo (API_PATH); ?>/Setting/settingAbout";
				$.get(url, function (res) {
					_this.configData = res.data;
				})
			},
			getUserInfo:function(){
				var _this=this;
				var url = "/<?php echo (API_PATH); ?>/User/user_authen/action/detail/id/<?php echo ($userId); ?>";
				$.get(url,function(res){
					_this.userInfo = res.data;
					if(_this.userInfo.status==0){
						$(".body_header").text("认证【已认证】");
					}else if(_this.userInfo.status==1) {
						$(".body_header").text("认证【未认证】");
					}else {
						$(".body_header").text("认证【不通过】");
					}
					if(_this.userInfo.type == "公司") {
						$("#typecar").val(0);
						$("#tyshxydm").text("统一社会信用代码");
						$("#companyNameId").removeClass("hide");
					} else {
						$("#typecar").val(1);
						$("#tyshxydm").text("身份证号码");
						$("#companyNameId").addClass("hide");
					}
				})
			},
		}
	});
</script>
<!-- 上传图片开始 -->
<script>
	var aaa = document.getElementById("company_pic"); //获取显示图片的div元素
	var input = document.getElementById("upload"); //获取选择图片的input元素

	//这边是判断本浏览器是否支持这个API。
	if(typeof FileReader==='undefined'){
		console.log("抱歉，你的浏览器不支持 FileReader");
		input.setAttribute('disabled','disabled');
	}else{
		input.addEventListener('change',readFile,false); //如果支持就监听改变事件，一旦改变了就运行readFile函数。
	}


	function readFile(){
		var file = this.files[0]; //获取file对象
		//判断file的类型是不是图片类型。
		if(!/image\/\w+/.test(file.type)){
			alert("文件必须为图片！");
			return false;
		}

		var reader = new FileReader(); //声明一个FileReader实例
		reader.readAsDataURL(file); //调用readAsDataURL方法来读取选中的图像文件
		//最后在onload事件中，获取到成功读取的文件内容，并以插入一个img节点的方式显示选中的图片
		reader.onload = function(e){
			aaa.src=this.result;
			$.ajax({
				url:"/<?php echo (API_PATH); ?>/User/user_authen/action/update_head/id/<?php echo ($userId); ?>",
				data:{'head_pic':aaa.src},
				type:'post',
				dataType:'json',
				async:false,
				success:function(data){
					if(data != false){
						$('#company_pic').attr('v-bind:src',data);
						tip.setBody('已上传成功，请点击保存');
					}else{
						tip.setBody('发生错误');
						return false;
					}
				}
			});
		}
	}
</script>
<!-- 上传图片结束 -->
<!-- 技术资料上传开始 -->
<script>
	var file = document.getElementById("getFiles");
	var fileName = document.getElementById("tech_file");
	function handleFile(filename){
		var flag = false; //状态
		var arr = ["zip","rar"];
		//取出上传文件的扩展名
		var index = filename.lastIndexOf(".");
		var ext = filename.substr(index+1);

		//循环比较
		for(var i=0;i<arr.length;i++)
		{
			if(ext == arr[i])
			{
				flag = true; //一旦找到合适的，立即退出循环
				break;
			}
		}
		//条件判断
		if(!flag)
		{
			layer.msg('请上传zip文件，修改后重新上传文件即可');
			return;
		}

		var data={"tech_file":filename};
		$.ajax({
			url:"/<?php echo (API_PATH); ?>/User/user_authen/action/Upload_files/id/<?php echo ($userId); ?>",
			data:data,
			type:'post',
			dataType:'json',
			async:false,
			success:function(res){
				layer.load(1, {
					shade: [0.1,'#fff'],//0.1透明度的白色背景
					time: 2000
				});
				var data=res.data;
				if(data != false){
					tip.setBody('已上传成功，请点击保存');
					$('#tech_file').val(data.tech_file);
				}else{
					tip.setBody('发生错误');
					return false;
				}
			}

		});
	}
</script>
<!-- 技术资料上传结束 -->
<!-- 上传专利资料开始 -->
<script>
	var file = document.getElementById("patent_file");
	var fileName = document.getElementById("information");
	function patentFile(filename){
		var flag = false; //状态
		var arr = ["zip","rar"];
		//取出上传文件的扩展名
		var index = filename.lastIndexOf(".");
		var ext = filename.substr(index+1);
		//循环比较
		for(var i=0;i<arr.length;i++)
		{
			if(ext == arr[i])
			{
				flag = true; //一旦找到合适的，立即退出循环
				break;
			}
		}
		//条件判断
		if(!flag)
		{
			layer.msg('请上传zip文件，修改后重新上传文件即可');
			return;
		}
		var data={"patent_file":filename};

		$.ajax({
			url:"/<?php echo (API_PATH); ?>/User/user_authen/action/patent_files/id/<?php echo ($userId); ?>",
			data:data,
			type:'post',
			dataType:'json',
			async:false,
			success:function(res){
				var data=res.data;
				if(data != false){
					$("#patent_file").val(data.patent_file);
					tip.setBody('已上传成功，请点击保存');
				}else{
					tip.setBody('发生错误');
					return false;
				}
			}
		});
	}
</script>
<!-- 上传专利资料结束 -->

<script>
	var type;
	function patentFile(obj){
		layer.load(1, {
			shade: [0.1,'#fff'],//0.1透明度的白色背景
			time: 2000,
		});
		var fileName = $(obj).val();
		 type=fileName.substring(fileName.lastIndexOf('.')+1);
		if(type=="zip" || type=="rar"){

		}else {
			tip.setBody('请上传zip或zip压缩包');
			return false;
		}

		var reader = new FileReader();
		reader.readAsDataURL(obj.files[0]);
		reader.onload = function(e){
			dataFile(e.target.result);
		};
	}
	function  dataFile(base64File){
		var url = "/<?php echo (API_PATH); ?>/User/user_authen/action/patent_files/id/<?php echo ($userId); ?>";
		var zip=type;
		var data = {'file': base64File,"zip":zip};
		$.post(url, data, function(res){
			layer.closeAll();
			var data=res.data;
			if(data != false){
				layer.msg('已上传成功，请点击保存');
				$('#patent_file').val(data.patent_file);
			}else{
				tip.setBody('发生错误');
				return false;
			}
		});

	}

	function handleFile(obj){
		layer.load(1, {
			shade: [0.1,'#fff'],//0.1透明度的白色背景
			time: 2000,
		});
		var fileName = $(obj).val();
		 type=fileName.substring(fileName.lastIndexOf('.')+1);
		if(type=="zip" || type=="rar"){

		}else {
			tip.setBody('请上传rar或zip压缩包');
			return false;
		}


		var reader = new FileReader();
		reader.readAsDataURL(obj.files[0]);
		reader.onload = function(e){
			uploadFile(e.target.result);
		};
	}

	function uploadFile(base64File) {
		var url = "/<?php echo (API_PATH); ?>/User/user_authen/action/Upload_files/id/<?php echo ($userId); ?>";
		var zip = type;
		var data = {'file': base64File,"zip":zip};
		$.post(url, data, function(res){
			layer.closeAll();
			var data=res.data;
			if(data != false){
				layer.msg('已上传成功，请点击保存');
				$('#tech_file').val(data.tech_file);
			}else{
				tip.setBody('发生错误');
				return false;
			}
		});
	}


</script>