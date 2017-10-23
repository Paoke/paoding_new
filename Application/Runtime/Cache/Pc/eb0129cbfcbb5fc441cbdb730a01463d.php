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
					<a href="/index.php/Pc/User/user_center"  class='desc_list'>我提交的咨询</a>
					<a href="/index.php/Pc/User/user_authen" class='desc_list'>认证</a>
					<a href="/index.php/Pc/User/user_info" class='desc_list'>基础资料</a>
					<a href="/index.php/Pc/User/user_security"  class='desc_list active'>账号安全</a>
					<a href="#" onclick="logout('/<?php echo (API_PATH); ?>/User/logout','/index.php/Pc/Index/index')"  class='desc_list'>退出</a>
				</div>
			</div>
			<div class="user_body">
				<div class="body_header">账户安全</div>
				<div class="body_content">
				<!-- 手机号 -->
					<div class="content_list security_desc" v-if="userInfo.mobile!=''">
						<span class="status"><i class="circle-right"></i>已绑定</span>
						<span class="desc1">{{userInfo.mobile}}</span>
						<span class="desc2">手机号码可用于登录</span>
						<a class="btn aphone" type="button" >修改手机号</a>
					</div>
					<div class="content_list security_desc" v-else>
						<span class="status"><i class="circle"></i>未绑定</span>
						<span class="desc1">设置手机号码</span>
						<span class="desc2">手机号码可用于登录</span>
						<a class="btn bphone" type="button" >绑定</a>
					</div>
				<!-- 手机号 -->
				<!-- 密码 -->
					<div class="content_list security_desc" v-if="userInfo.mobile!=''">
						<span class="status"><i class="circle-right"></i>已设置</span>
						<span class="desc1">修改密码</span>
						<span class="desc2">为确保账户安全，请定期修改密码</span>
						<a class="btn apassword" type="button" >修改密码  </a>
					</div>

				<!-- 密码 -->
				<!-- 微信 -->
					<div class="content_list security_desc" v-if="userInfo.openid!=''">
						<span class="status"><i class="circle-right"></i>已设置</span>
						<span class="desc1">微信第三方登录</span>
						<span class="desc2">绑定微信后可以使用微信扫码登录</span>
						<?php if((cookie('opid') != null) AND (session('mobile') == null)): ?><a class="btn" type="button" style="color:grey">解绑</a>
						<?php else: ?>
							<a class="btn" type="button" href="#" onclick="WeChatUnBind()" style="color:black">解绑</a><?php endif; ?>
					</div>

					<div class="content_list security_desc" v-else>
						<span class="status"><i class="circle"></i>未设置</span>
						<span class="desc1">微信第三方登录</span>
						<span class="desc2">绑定微信后可以使用微信扫码登录</span>
						<a class="btn" type="button" onclick="WeChatBind()">
							绑定
						</a>
					</div>

				<!-- 微信 -->
				</div>
			</div>
		</div>
	</div>
	<!-- 修改手机号 -->
	<div class="modal alter-phone">
		<a class="login_close" href="javascript:;">
			<img class="" src="/Template/5u/pc/Static/img/login_close.jpg" style="transform: rotate(0deg);">
		</a>
		<div class="modal-hd">
			修改绑定手机
		</div>
		<div class="modal-bd bd1 hide">
			<!--<input class="text-input" type="text" v-model="userInfo.user_name" disabled="true" id="oldMob" />
			<input class="text-input" type="password" placeholder="密码" id="oldMobPwd" />
			<button type="button" class="btn" id="editMobNext" onclick="NextStep('/<?php echo (API_PATH); ?>/User/login')">下一步</button>-->
			<input class="text-input" type="text" v-model="userInfo.mobile" disabled="true" id="oldMob" />
			<!--<input class="text-input" type="text" placeholder="手机号码" id="newMob1" />-->
			<button type="button" class="phone-code" id="getNewMobCode1" onclick="GetLatest('/<?php echo (API_PATH); ?>/Sms/sendMessage')">获取短信验证码</button>
			<input class="text-input" type="text" placeholder="验证码" id="oldMobCode" />
			<button type="button" class="btn" id="editMob1" onclick="Determine('/<?php echo (API_PATH); ?>/User/Modify',1)">下一步</button>
		</div>
		<div class="modal-bd bd2 hide">
			<input class="text-input" type="text" placeholder="新手机号码" id="newMob" />
			<button type="button" class="phone-code" id="getNewMobCode" onclick="GetLatest('/<?php echo (API_PATH); ?>/Sms/sendMessage')">获取短信验证码</button>
			<input class="text-input" type="text" placeholder="验证码" id="newMobCode" />
			<button type="button" class="btn" id="editMob" onclick="Determine('/<?php echo (API_PATH); ?>/User/Modify',2)">确定</button>
		</div>
		<div class="modal-bd bd3 hide">
			<input class="text-input" type="text" placeholder="手机号码" id="bindMob3" />
			<button type="button" class="phone-code" id="getBindCode3" onclick="GetLatest('/<?php echo (API_PATH); ?>/Sms/sendMessage')">获取短信验证码</button>
			<input class="text-input" type="text" placeholder="验证码" id="bindMobCode3" />
			<input class="text-input" type="text" placeholder="设置密码" id="bindPwd3" />
			<!--<span style="display:none" id="isshow3" check='1'><input class="text-input" type="password" placeholder="密码" id="bindPwd3" /></span>-->
			<button type="button" class="btn" id="sureBind3" onclick="Determine('/<?php echo (API_PATH); ?>/User/Modify',3)">确定</button>
		</div>
		<div class="modal-ft"></div>
	</div>
	<!-- 修改手机号 -->
	<!-- 修改密码 -->
	<div class="modal alter-password">
		<a class="login_close" href="javascript:;">
			<img class="" src="/Template/5u/pc/Static/img/login_close.jpg" style="transform: rotate(0deg);">
		</a>
		<div class="modal-hd">
			修改密码
		</div>
		<div class="modal-bd">
			<input class="text-input" type="text" placeholder="原密码" id="oldPwd" />
			<input class="text-input" type="password" placeholder="新密码" id="newPwds" />
			<input class="text-input" type="password" placeholder="确认密码" id="rePwd" />
			<button type="button" class="btn" id="editPwd" onclick="Confirm()">确认修改</button>
		</div>
		
		<div class="modal-ft"></div>
	</div>
	<!-- 修改密码 -->
	<!-- 绑定手机号 -->
	<div class="modal band-phone">
		<a class="login_close" href="javascript:;">
			<img class="" src="/Template/5u/pc/Static/img/login_close.jpg" style="transform: rotate(0deg);">
		</a>
		<div class="modal-hd">
			绑定手机
		</div>
		<div class="modal-bd">
			<input class="text-input" type="text" placeholder="手机号码2" id="bindMob" />
			<button type="button" class="phone-code" id="getBindCode" onclick="Obtain('/<?php echo (API_PATH); ?>/Sms/sendMessage')">获取短信验证码</button>
			<input class="text-input" type="text" placeholder="验证码" id="bindMobCode" />
			<span style="display:none" id="isshow" check='1'><input class="text-input" type="password" placeholder="密码" id="bindPwd" /></span>
			<button type="button" class="btn" id="sureBind" onclick="binbang('/<?php echo (API_PATH); ?>/User/binding')">确定</button>
		</div>
		<div class="modal-ft"></div>
	</div>
	<!-- 绑定手机号 -->
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
				<input type="text" id="p_yzm" value="" placeholder="验证码" class="login_leftPageCode"/>
				<button class="login_leftPageGetcode" id="getphonecode">获取验证码</button>
				<input type="password" id="paswd" value="" placeholder="密码（不少于6位）"/>
				<a class="login_leftPageBut" id="register">注册</a>
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
				<button class="login_leftPageGetcode" id="getmobyzm">获取验证码</button>
				<input type="password" id="newpwd" value="" placeholder="新密码（不少于6位）"/>
				<a class="login_leftPageBut" id="resetpwd">重设密码</a>
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
</html>

<script src="/Template/5u/pc/Static/js/jquery-2.1.0.js" type="text/javascript" charset="utf-8"></script>
<script src="/Template/5u/pc/Static/js/swiper.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/Template/5u/pc/Static/js/index.js" type="text/javascript" charset="utf-8"></script>
<script src="/Template/5u/pc/Static/js/jquery.md5.js" type="text/javascript"></script>
<script src="/Template/5u/pc/Static/js/common.js" type="text/javascript"></script>
<script src="/Public/js/vue.js"></script>
<script src="/Public/js/layer/layer-min.js"></script>
<script>
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
	var ifWeChatBind = 0;
	$(function () {
		/*setTimeout("getUser()",100);*/
		getUser();

	});
	function getUser() {
		var ifWeChatLogin = "<?php echo ($ifWeChatLogin); ?>";

		ifWeChatBind = "<?php echo ($ifWeChatBind); ?>";


		//微信登录
		if(ifWeChatLogin == 1) {
			var url = "/<?php echo (API_PATH); ?>/User/WeChatLogin/code/<?php echo ($code); ?>";
			$.get(url, function (res) {
				window.location.href="/index.php/Pc/User/user_security"
			})
		}
		//微信绑定
		if(ifWeChatBind == 1) {
				var url = "/<?php echo (API_PATH); ?>/User/WeChatBind/code/<?php echo ($code); ?>";
				$.get(url, function (res) {
					vmvue.getUserInfo();
				})
			}
	}

	function  WeChatLogin() {
		var url = "/<?php echo (API_PATH); ?>/User/getAppIdData";
		$.get(url, function (res) {
			if(res.result == 1) {
				window.location.href="https://open.weixin.qq.com/connect/qrconnect?appid="+res.data['appid']+"&redirect_uri=http://"+res.data['area_name']+"//index.php/Pc/User/user_security/ifWeChatLogin/1&response_type=code&scope=snsapi_login&state=2015#wechat_redirect";
			} else {
				layer.msg("系统繁忙请稍后再试！");
			}
		})

	}
    //绑定微信
	function  WeChatBind() {
		var url = "/<?php echo (API_PATH); ?>/User/getAppIdData";
		$.get(url, function (res) {
			if(res.result == 1) {
				window.location.href="https://open.weixin.qq.com/connect/qrconnect?appid="+res.data['appid']+"&redirect_uri=http://"+res.data['area_name']+"//index.php/Pc/User/user_security/ifWeChatBind/1&response_type=code&scope=snsapi_login&state=2015#wechat_redirect";
			} else {
				layer.msg("系统繁忙请稍后再试！");
			}
		})

	}

	function myrefresh()
	{
		window.location.reload();
	}

	//解绑微信
	function  WeChatUnBind() {
		var yesOrNo = confirm('确定解绑吗？');
		if(yesOrNo){
			var url = "/<?php echo (API_PATH); ?>/User/WeChatUnBind";
			$.get(url, function (res) {
				layer.msg(res.msg);
				setTimeout('myrefresh()',1000);

			})
		}

	}


	//修改绑定手机 点击确定按钮
	function Determine(url,type){
		var bindMobile =$("#bindMob3").val();
		var bindCode=$("#bindMobCode3").val();
		var password = $("#bindPwd3").val();
		var oldMoblie = $("#oldMob").val();
		var mobile=$("#newMob").val();
		var code=$("#newMobCode").val();
		var oldCode=$("#oldMobCode").val();
		var user_id="<?php echo ($userId); ?>";
		if(type ==1) {
			if(oldCode.length!=4){
				tip.setBody('请输入正确的验证码');
				return;
			}
			var data={"bindMob":mobile,"oldMobile":oldMoblie,"bindMobCode":code,"oldMobCode":oldCode,"userId":user_id};
		}
		else if(type==2) {
			if(mobile.length!=11){
				tip.setBody('请输入正确的手机格式');
				return;
			}else  if(code.length!=4){
				tip.setBody('请输入正确的验证码');

				return;
			}
			var data={"bindMob":mobile,"oldMobile":oldMoblie,"bindMobCode":code,"oldMobCode":oldCode,"userId":user_id};
		}
		else if(type==3) {
			if(bindMobile.length!=11){
				tip.setBody('请输入正确的手机格式');
				return;
			}else  if(bindCode.length!=4){
				tip.setBody('请输入正确的验证码');
				return;
			} else if(password=='') {
				tip.setBody('请输入密码');
				return;
			}
			var data={"bindMob":bindMobile,"bindMobCode":bindCode,"paswd":password,"userId":user_id};
		}

		$.ajax({
			url:url,
			type:"post",
			data:data,
			dataType:"json",
			success:function(res){
				if(res.result==1){
					tip.setBody(res.msg);
					toNextPage();
					if(type ==3){
						setTimeout('toIndex()',1000);
					}
				}else if(res.result==0){
					tip.setBody(res.msg);
				}
			}
		},'json');
	}
	function toIndex() {
		window.location.href="/index.php/Pc/Index/index";
	}
	//修改绑定手机 获取验证码
	function GetLatest(url){
		//点击获取手机验证码
		var dom = $(".phone-code");
		var bindMobile = $("#bindMob3").val();
		var oldMobile = $("#oldMob").val();
		var mobile = $("#newMob").val();
		if(bindMobile) {
			var data={"mobile":bindMobile};
		}
		else if(oldMobile) {
			var data={"mobile":oldMobile};
		} else {
			if (mobile == '') {
				tip.setBody('请输入手机号码');
				return false;
			}else if(mobile.length != 11){
				tip.setBody('请输入正确的手机格式');
				return;
			}
			var data={"mobile":mobile};
		}


		$.ajax({
			url: url,
			type: 'post',
			data: data,
			dataType: 'json',
			success: function (msg) {
				if (msg.result == 1) {
					time(dom);
					tip.setBody(msg.msg);
				} else if (msg.result == 0) {
					tip.setBody(msg.msg);
				}
			}
		});
	}
	//下一步
	function NextStep(url){
		var username=$("#oldMob").val();
		var password=$("#oldMobPwd").val();
		var pwdReg = /^(([a-z]+)|([0-9]+)|([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i;
		 if  (password == '' || password.length >15 || password.length <6 || !pwdReg.test(password)){
			tip.setBody('请输入正确的密码');
		}
		$.ajax({
			type:"post",
			url:url,
			data:{"username":username,"password":password},
			dataType:"json",
			success:function(res){
				if(res.result==1){
					tip.setBody("验证通过");
					toNextPage();
				}
			}
		},'json');
	}
	//下一步 更改绑定
	function toNextPage(){
		$('.bd1').addClass('hide');
		$('.bd3').removeClass('hide');

	}
	//修改密码 确认按钮
	function Confirm(){
		var url = "/<?php echo (API_PATH); ?>/User/user_info/action/update_pw/id/<?php echo ($userId); ?>";
		var old=$("#oldPwd").val();
		var repass=$("#newPwds").val();
		var re_new=$("#rePwd").val();
		var data={
			"old":old,
			"new":repass,
			"re_new":re_new
		};

		$.post(url,data, function(ret){
			alert(JSON.stringify(ret));
			if(ret.result == 1){
				tip.setBody(ret.msg);
			}else{
				tip.setBody(ret.msg);
			}
		}, 'json');
	}
	//绑定手机 确定按钮
	function  binbang(url){
		var mobile=$("#bindMob").val();
		var code=$("#bindMobCode").val();
		var user_id="<?php echo ($userId); ?>";
		if(mobile.length!=11){
			tip.setBody('请输入正确的手机格式');
			return;
		}else if(code.length!=4){
			tip.setBody('请输入正确的验证码');
			return;
		}
		var data={"bindMob":mobile,"bindMobCode":code,"userId":user_id};
		$.ajax({
			url:url,
			type:"post",
			data:data,
			dataType:"json",
			success:function(res){
				if(res.result==1){
					tip.setBody(res.msg);
				}else if(res.result==0){
					tip.setBody(res.msg);
				}
			}
		},'json');
	}
	//绑定手机 获取验证码
	function Obtain(url){
		//点击获取手机验证码
		var dom = $(".phone-code");
		var mobile = $("#bindMob").val();
		if (mobile == '') {
			tip.setBody('请输入手机号码');
			return false;
		}else if(mobile.length != 11){
			tip.setBody('请输入正确的手机格式');
			return;
		}
		var data={"mobile":mobile};
		$.ajax({
			url: url,
			type: 'post',
			data: data,
			dataType: 'json',
			success: function (msg) {
				if (msg.result == 1) {
					time(dom);
					tip.setBody(msg.msg);
				} else if (msg.result == 0) {
					tip.setBody(msg.msg);
				}
			}
		});
	}

	var vmvue = new Vue({
		el:'#template',
		data:{
			configData: '', //列表数据
			userInfo:'',
		},
		mounted: function () {
			this.$nextTick(function () {
				var _this = this;
				this.getConfigData();
				this.getUserInfo();

				/*	setTimeout(function(){
				 _this.ifBind();
				 }, 100);*/
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
				var url = "/<?php echo (API_PATH); ?>/User/user_info/action/detail/id/<?php echo ($userId); ?>";
				$.get(url,function(res){
					_this.userInfo = res.data;
					/*console("shju",);*/
					//如何是微信登录的用户绑定手机需要绑定密码
					if(_this.userInfo.openid && res.data['password'] ==0) {
						$('.bd1').addClass('hide');
						$('.bd2').addClass('hide');
						$('.bd3').removeClass('hide');
					} else {
						//如果是账号密码登录的用户不用设置密码
						if(_this.userInfo.mobile){
							$('.bd1').removeClass('hide');
							$('.bd2').addClass('hide');
							$('.bd3').addClass('hide');
						}else {
							$('.bd1').addClass('hide');
							$('.bd2').removeClass('hide');
							$('.bd3').addClass('hide');
						}
					}

				})
			},
		}
	});
</script>