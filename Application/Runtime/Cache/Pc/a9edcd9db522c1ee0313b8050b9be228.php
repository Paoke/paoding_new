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
				<a href="/index.php/Pc/User/user_center" class='desc_list active'>我提交的咨询</a>
				<a href="/index.php/Pc/User/user_authen" class='desc_list '>认证</a>
				<a href="/index.php/Pc/User/user_info" class='desc_list '>基础资料</a>
				<a href="/index.php/Pc/User/user_security" class='desc_list '>账号安全</a>
				<a href="#" onclick="logout('/<?php echo (API_PATH); ?>/User/logout','/index.php/Pc/Index/index')" class="desc_list">退出</a>
			</div>
		</div>
		<div class="user_body">
			<div class="body_header">我提交的咨询</div>
			<div class="body_content">
					<div class="content_list" v-for="con in Consu">
						<div class="list_title">

								<span class="reply commit_reply1" v-if="con.gfhf!='' && con.gfhf">已回复</span>

								<span class="reply commit_reply2" v-else>未回复</span>
							</if>
						</div>
						<div class="question" v-text="con.content"></div>
							<i class="line"></i>
							<div class="question">官方回复:{{con.gfhf}}</div>
					</div>
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
	$(function () {
		/*setTimeout("getUser()",100);*/
		getUser();

	});
	function getUser() {
		var ifWeChatLogin = "<?php echo ($ifWeChatLogin); ?>";
		if(ifWeChatLogin == 1) {
			var url = "/<?php echo (API_PATH); ?>/User/WeChatLogin/code/<?php echo ($code); ?>";
			$.get(url, function (res) {
				window.location.href="/index.php/Pc/User/user_center"
			})
		}
	}
	function  WeChatLogin() {
		var url = "/<?php echo (API_PATH); ?>/User/getAppIdData";
		$.get(url, function (res) {
			if(res.result == 1) {
				window.location.href="https://open.weixin.qq.com/connect/qrconnect?appid="+res.data['appid']+"&redirect_uri=http://"+res.data['area_name']+"//index.php/Pc/User/user_center/ifWeChatLogin/1&response_type=code&scope=snsapi_login&state=2015#wechat_redirect";
			} else {
				layer.msg("系统繁忙请稍后再试！");
			}
		})

	}



	var vm = new Vue({
		el:'#template',
		data:{
			configData: '', //列表数据
			Consu:'',
		},
		mounted: function () {
			this.$nextTick(function () {
				this.getConfigData();
				this.Consultation();
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
			Consultation:function(){
				var _this = this;
				var mobile="<?php echo ($mobile); ?>";
				var userId="<?php echo ($user_id); ?>";
				var data={
					"user_id":userId,
					"mobile":mobile
				};
				var url = "/<?php echo (API_PATH); ?>/Paoding/Consultation/id/<?php echo ($user_id); ?>";
				$.post(url,data,function(res){
//					alert(JSON.stringify(res));
					_this.Consu = res.data;
				})
			}
		}
	});
</script>
<!-- 修改手机号第一步开始（已绑定状态） -->
<script type="text/javascript">
	$(function(){
		$('#editMobNext').on('click',function(){
			var mobile = $('#oldMob').val();
			if(mobile != ''){
				var pwd = $('#oldMobPwd').val();
				if(pwd == ''){
					tip.setBody('请输入密码');
					return false;
				}
				var rand_string = 'abcdefghijklmnopqrstuvwxyz0123456789';
				var rand_num = '';
				var salt = '';
				for(var i=0;i<4;i++){
					rand_num = parseInt(Math.random()*35);
					salt += rand_string[rand_num];
				}
				$.ajax({
					url:"<?php echo U('User/getLoginSalt');?>",
					data:{'mobile':mobile},
					async: false,
					type:'post',
					dataType:'json',
					success:function(data){
						if(data != false){
							pwd_salt = pwd+data;
							md5_pwd = $.md5(pwd_salt);
							for(var i=0;i<10;i++){
								md5_pwd = $.md5(md5_pwd);
							}
							pwd_salt_new = pwd+salt;
							md5_pwd_new = $.md5(pwd_salt_new);
							for(var i=0;i<10;i++){
								md5_pwd_new = $.md5(md5_pwd_new);
							}
						}else{
							tip.setBody('您输入的用户不存在');
							return false;
						}
						$.ajax({
							url:"<?php echo U('User/login');?>",
							data:{
								'mobile':mobile,
								'salt':salt,
								'password_check':md5_pwd,
								'password':md5_pwd_new
							},
							type:'post',
							dataType:'json',
							async: false,
							success:function(msg){
								if(msg.code == '405'){
									tip.setBody('您输入的用户不存在');
								}else if(msg.code == '406'){
									tip.setBody('密码错误');
								}else if(msg.code == '200'){
									tip.setBody('验证通过');
									toNextPage();
								}
							}
						});
					}
				});
			}else{
				tip.setBody('发生错误');
			}
		});
	});

	function toNextPage(){
		$('.bd1').addClass('hide');
		$('.bd2').removeClass('hide');
	}
</script>
<!-- 修改手机号第一步结束（已绑定状态） -->

<!-- 修改手机号第二步开始（已绑定状态） -->
<script type="text/javascript">
	$(function(){
		//点击获取手机验证码
		$("#getNewMobCode").on("click",function(){
			var dom = $(this);
			var mobile = $("#newMob").val();
			if(mobile == ''){
				tip.setBody('请输入新的手机号码');
				return false;
			}
			$.ajax({
				url:"<?php echo U('User/getCode');?>",
				type:'POST',
				data:{'mobile': mobile},
				dataType:'json',
				success:function(msg){
					if(msg.code == 200){
						time(dom);
						tip.setBody('验证码已发送');
					}else if(msg.code == 401){
						tip.setBody('手机号格式不正确');
					}else{
						tip.setBody('发生错误');
					}
				}
			});
		});

		//点击确定
		$("#editMob").on("click",function(){
			var mobile = $("#newMob").val();
			if(mobile == ''){
				tip.setBody('请输入新的手机号码');
				return false;
			}
			var phoneCode = $('#newMobCode').val();
			if(phoneCode == ''){
				tip.setBody('请输入手机验证码');
				return false;
			}
			$.ajax({
				url:"<?php echo U('User/editMobile');?>",
				data:{'mobile':mobile,'phoneCode':phoneCode},
				type:'POST',
				dataType:'json',
				success:function(msg){
					switch(msg.code){
						case 200:
							tip.setBody('修改成功');
							window.location.reload();
							break;
						case 401:
							tip.setBody('手机格式不正确');
							break;
						case 402:
							tip.setBody('验证码过期');
							break;
						case 403:
							tip.setBody('验证码错误');
							break;
						case 404:
							tip.setBody('该号码已被绑定');
							break;
						case 407:
							tip.setBody('新号码不能与旧号码相同');
							break;
						case 444:
							tip.setBody('发生错误');
							break;
					}
				}
			});
		});
	});
</script>
<!-- 修改手机号第二步结束（已绑定状态） -->

<!-- 修改密码开始（已绑定手机状态） -->
<script type="text/javascript">
	$(function(){
		$('#editPwd').on('click',function(){
			var oldPwd = $('#oldPwd').val();
			if(oldPwd == ''){
				tip.setBody('请输入原密码');
				return false;
			}
			var newPwd = $('#newPwd').val();
			if(newPwd == ''){
				tip.setBody('请输入新密码');
				return false;
			}
			var rePwd = $('#rePwd').val();
			if(rePwd == ''){
				tip.setBody('请确认密码');
				return false;
			}
			if(newPwd != rePwd){
				tip.setBody('两次密码输入不一致');
				return false;
			}
			var rand_string = 'abcdefghijklmnopqrstuvwxyz0123456789';
			var rand_num = '';
			var salt = '';
			for(var i=0;i<4;i++){
				rand_num = parseInt(Math.random()*35);
				salt += rand_string[rand_num];
			}
			$.ajax({
				url:"<?php echo U('User/getResetSalt');?>",
				dataType:'json',
				success:function(salt){
					if(salt.length == 4){
						pwd_salt = oldPwd+salt;
						md5_pwd = $.md5(pwd_salt);
						for(var i=0;i<10;i++){
							md5_pwd = $.md5(md5_pwd);//旧密码的加密字符串
						}
						pwd_salt_new = newPwd+salt;
						md5_pwd_new = $.md5(pwd_salt_new);
						for(var i=0;i<10;i++){
							md5_pwd_new = $.md5(md5_pwd_new);//新密码的加密字符串
						}
						$.ajax({
							url:"<?php echo U('User/editPassword');?>",
							data:{
								'oldPass':md5_pwd,
								'newPass':md5_pwd_new,
								'salt':salt
							},
							type:'POST',
							dataType:'json',
							success:function(msg){
								if(msg.code == 200){
									tip.setBody('修改成功');
									window.location.reload();
								}else if(msg.code == 406){
									tip.setBody('原密码错误');
									return false;
								}else{
									tip.setBody('发生错误');
									return false;
								}
							}
						});
					}else{
						tip.setBody('发生错误');
						return false;
					}
				}
			});
		});
	});
</script>
<!-- 修改密码结束（已绑定手机状态） -->

<!-- 判断是否显示密码开始 -->
<script type="text/javascript">
	$(function(){
		$('#bindMob').blur(function(){
			var dom = $('#isshow');
			var mobile = $(this).val();
			if(mobile == ''){
				tip.setBody('请输入手机号码');
				return false;
			}
			$.ajax({
				url:"<?php echo U('User/checkMobile');?>",
				data:{'mobile':mobile},
				type:'POST',
				dataType:'json',
				success:function(status){
					switch(status){
						case 1://已存在此手机号（不显示密码框）
							dom.attr('style','display:none');
							dom.attr('check','1');
							break;
						case 2://不存在此手机号（显示密码框）
							dom.attr('style','display:block');
							dom.attr('check','2');
							break;
						default:
							tip.setBody('发生错误');
							break;
					}
				}
			});
		});
	});
</script>
<!-- 判断是否显示密码结束 -->

<!-- 绑定手机号开始（微信登录状态） -->
<script type="text/javascript">
	$(function(){
		//点击获取手机验证码
		$("#getBindCode").on("click",function(){
			var dom = $(this);
			var mobile = $("#bindMob").val();
			if(mobile == ''){
				tip.setBody('请输入手机号码');
				return false;
			}
			$.ajax({
				url:"<?php echo U('User/getCode');?>",
				type:'POST',
				data:{'mobile': mobile},
				dataType:'json',
				success:function(msg){
					if(msg.code == 200){
						time(dom);
						tip.setBody('验证码已发送');
					}else if(msg.code == 401){
						tip.setBody('手机号格式不正确');
					}else{
						tip.setBody('发生错误');
					}
				}
			});
		});

		//点击确定
		$('#sureBind').on('click',function(){
			var url = "<?php echo U('User/mob_bind');?>";
			var mobile = $("#bindMob").val();
			var phoneCode = $("#bindMobCode").val();
			var password = $('#bindPwd').val();
			var check = $('#isshow').attr('check');
			switch(check){
				case '1'://已存在此手机号（免输入密码）
					if(mobile=='' || phoneCode==''){
						tip.setBody('存在未填项');
						return false;
					}
					$.ajax({
						url:url,
						data:{
							'mobile':mobile,
							'phoneCode':phoneCode,
							'check':'1'
						},
						type:'post',
						dataType:'json',
						success:function(msg){
							switch(msg.code){
								case 200:
									tip.setBody('绑定成功');
									window.location.reload();
									break;
								case 401:
									tip.setBody('手机格式不正确');
									break;
								case 402:
									tip.setBody('验证码过期');
									break;
								case 403:
									tip.setBody('验证码错误');
									break;
								case 404:
									tip.setBody('此手机号已被绑定');
									break;
								case 444:
									tip.setBody('发生错误');
									break;
							}
						}
					});
					break;
				case '2'://不存在此手机号（需要设置密码）
					if(mobile=='' || phoneCode=='' || password==''){
						tip.setBody('存在未填项');
						return false;
					}
					var rand_string = 'abcdefghijklmnopqrstuvwxyz0123456789';
					var rand_num = '';
					var salt = '';
					for(var i=0;i<4;i++){
						rand_num = parseInt(Math.random()*35);
						salt += rand_string[rand_num];
					}
					pwd_salt_new = password+salt;
					md5_pwd_new = $.md5(pwd_salt_new);
					for(var i=0;i<10;i++){
						md5_pwd_new = $.md5(md5_pwd_new);
					}
					$.ajax({
						url:url,
						data:{
							'mobile':mobile,
							'phoneCode':phoneCode,
							'password':md5_pwd_new,
							'salt':salt,
							'check':'2'
						},
						type:'post',
						dataType:'json',
						success:function(msg){
							switch(msg.code){
								case 200:
									tip.setBody('绑定成功');
									window.location.reload();
									break;
								case 401:
									tip.setBody('手机格式不正确');
									break;
								case 402:
									tip.setBody('验证码过期');
									break;
								case 403:
									tip.setBody('验证码错误');
									break;
								case 404:
									tip.setBody('此手机号已被绑定');
									break;
								case 444:
									tip.setBody('发生错误');
									break;
							}
						}
					});
					break;
				default:
					tip.setBody('发生错误');
					break;
			}
		});
	});
</script>
<!-- 绑定手机号结束（微信登录状态） -->