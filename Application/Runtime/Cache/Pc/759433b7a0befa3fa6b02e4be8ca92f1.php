<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="shortcut icon" href="/Template/5u/pc/Static/img/favicon.ico">
	<title>活动</title>
	<link rel="stylesheet" type="text/css" href="/Template/5u/pc/Static/css/swiper.min.css"/>
	<link rel="stylesheet" type="text/css" href="/Template/5u/pc/Static/css/index.css"/>
	<link rel="stylesheet" type="text/css" href="/Template/5u/pc/Static/font/iconfont.css"/>
	<style>
		.layui-layer-content{padding:30px 30px 30px 30px;}
		.size{font-size: 24px;}
	</style>
</head>
<?php if(CONTROLLER_NAME == Activity): ?><body onresize="">
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
				<a href="/index.php/Pc/Index/index" class='navigation-link '>
					首页
				</a>
			</li>
			<li class="navigation-item ib">
				<a href="/index.php/Pc/Article/data_list/channel/js" class='navigation-link '>
					技术
				</a>
			</li>
			<li class="navigation-item ib">
				<a href="/index.php/Pc/Article/data_list/channel/hzjg" class='navigation-link'>
					合作机构
				</a>
			</li>
			<li class="navigation-item ib">
				<a href="/index.php/Pc/Article/data_list/channel/xq" class='navigation-link '>
					需求
				</a>
			</li>
			<li class="navigation-item ib">
				<a href="/index.php/Pc/Activity/data_list/channel/hd" class='navigation-link selected-link'>
					活动
				</a>
			</li>
			<li class="navigation-item ib">
				<a href="/index.php/Pc/Article/data_list/channel/zx" class='navigation-link '>
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
					<li class="head_userLi"><a  href="javascript:;" onclick="logout('/<?php echo (API_PATH); ?>/User/logout')">退出</a></li>
				</ul>
				<?php else: ?>
				<a class="head_login" href="javascript:;">登录</a><?php endif; ?>
		</li>
	</ul>
</div>
</header>
<section id="template">
	<div class="act_info_head outside">
		<div class="center act_info_top">
			<template v-if="listData.signup_flag==0">
			<p class="act_info_top_tab tab_reday">报<br />名<br />中</p>
			</template>
			<template v-if="listData.signup_flag==1">
			<p class="act_info_top_tab tab_ing">进<br />行<br />中</p>
			</template>
			<template v-if="listData.signup_flag==2">
			<p class="act_info_top_tab tab_end">已<br />结<br />束</p>
			</template>
			<img class="act_info_topImg" v-bind:src="listData.cover_url"/>
			<h3 class="act_info_topTitle" v-text="listData.title"></h3>
			<p class="act_info_topList">
				<img src="/Template/5u/pc/Static/img/act_infolist1.png"/>{{listData.formal_start_time}}-{{listData.formal_end_time}}
			</p>
			<p class="act_info_topList">
				<img src="/Template/5u/pc/Static/img/act_infolist2.png"/>{{listData.address}}
			</p>
			<p class="act_info_topList">
				<img src="/Template/5u/pc/Static/img/act_infolist3.png"/>限额{{listData.renshu}}人
			</p>
			<p class="act_info_topList act_info_topList_bottom">
				<img src="/Template/5u/pc/Static/img/act_infolist4.png"/>{{listData.cost}}
			</p>

			<div class="act_info_topBut"  @click="showForm()" id="topBut" onclick="topBut()">点击参与</div>

		</div>
	</div>

	<div class="act_info_body outside">
		<div class="center act_info_article">
			<h2 class="act_info_article_title">活动详情</h2>
			<p class="act_info_article_titleUnder"></p>
			<div class="act_info_article_content" v-html="listData.content"></div>
		</div>
	</div>
<footer class="foot outside" >
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
		<div class="loginLeftPage login_register">
			<div class="login-head">
				注册
			</div>
			<div class="login-body">
				<input class="loginLeftPage_input" type="text" id="mobile" value="" placeholder="手机号码"/>
				<input class="loginLeftPage_input login_leftPageCode"  type="text" id="code" value="" placeholder="验证码" />
				<button class=" login_leftPageGetcode"   id="getphonecode" onclick="get_code('/<?php echo (API_PATH); ?>/Sms/sendMessage')">获取验证码</button>
				<input  class="loginLeftPage_input" type="password" id="paswd" value="" placeholder="密码（不少于6位）"/>
				<div  style="font-size: 12px;color: #999999;">
					<input style="width: 20px;"  type="checkbox" value="1" checked="checked" />我已阅读并同意 <span class="Regis" onclick="Regis()" style="color: #ff6601;">《用户注册协议》</span>
				</div>

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
		个人信息
	</div>
	<div class="contact-body">
		<input type="text" value="" placeholder="姓名" id="FullName" />
		<input type="text" value="" placeholder="手机号码" id="FullMobile" maxlength="11"/>
		<a class="login_leftPageBut" id="jumpSubmit">提交</a>
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
</script>
<script>

	function  topBut(){
		var id="<?php echo ($userId); ?>";
			if(!id){
				tip.setBody("请先登录");
				$(".cover").fadeIn(300);
				$(".login_page").css({
					"top":"50%",
					"transform" :"translate(-50%,-50%)"
				})
			}else {
				$(".cover").fadeIn(300);
				$(".contact").css({
					"top":"50%",
					"transform" :"translate(-50%,-50%)"
				})
			}
	}
	$("#jumpSubmit").on("click",function (){

		var name=$("#FullName").val();
		var mobile=$("#FullMobile").val();

		if(name=="" || mobile ==""){
			tip.setBody("请输入个人信息");
			return;
		}
		if(mobile.length!=11){
			tip.setBody("请输入正确的手机号码");
			return;
		}

		var userId="<?php echo ($userId); ?>";
		var activity_id="<?php echo ($data_id); ?>";
		var data={
			"name":name,
			"mobile":mobile,
			"activity_id":activity_id,
			"status":1
		};
		var url = "/<?php echo (API_PATH); ?>/ActivityOrder/order/action/applycommon/channel/<?php echo ($channel); ?>/type/3/id/<?php echo ($data_id); ?>";
		$.post(url, data, function (res) {

			if (res.result == 1) {
				tip.setBody("报名成功");
				$(".act_info_topBut").css('color', '#666');
				$(".act_info_topBut").text("已报名");
				$(".act_info_topBut ").css('background', '#ddd');
				$("#topBut").unbind();
				vm.order_status = 1;

				location.reload(true);
			}else{
				tip.setBody(res.msg);
			}
		})
	});


</script>
<script>
	<?php if(session('userArr') != null): ?>var isLogin=true;
			<?php else: ?>
	var isLogin=false;<?php endif; ?>
	$(function () {
		/*setTimeout("getUser()",100);*/
		getUser();

	});
	function getUser() {
		var ifWeChatLogin = "<?php echo ($ifWeChatLogin); ?>";
		if(ifWeChatLogin == 1) {
			var url = "/<?php echo (API_PATH); ?>/User/WeChatLogin/code/<?php echo ($code); ?>";
			$.get(url, function (res) {
				window.location.href="/index.php/Pc/Activity/detail/channel/<?php echo ($channel); ?>/type/1/data_id/<?php echo ($data_id); ?>"
			})
		}
	}
	function  WeChatLogin() {
		var url = "/<?php echo (API_PATH); ?>/User/getAppIdData";
		$.get(url, function (res) {
			if(res.result == 1) {
				window.location.href="https://open.weixin.qq.com/connect/qrconnect?appid="+res.data['appid']+"&redirect_uri=http://"+res.data['area_name']+"//index.php/Pc/Activity/detail/channel/<?php echo ($channel); ?>/type/1/data_id/<?php echo ($data_id); ?>/ifWeChatLogin/1&response_type=code&scope=snsapi_login&state=2015#wechat_redirect";
			} else {
				layer.msg("系统繁忙请稍后再试！");
			}
		})

	}

	var vm = new Vue({
		el:'#template',
		data:{
			listData: '', //列表数据
			configData:'',
			page :  '0',
			bool : 'true'
		},
		mounted: function () {
			this.$nextTick(function () {
				this.getData();
				this.getConfigData();
			})
		},
		updated:function(){
		},
		filters: {
		},
		methods:{
			getData:function () {
				var _this = this;
				var url = "/<?php echo (API_PATH); ?>/ChannelIndex/index/action/dataDetail/channel/<?php echo ($channel); ?>/type/1/data_id/<?php echo ($data_id); ?>";
				var data = {
					'order_status': true,
					'is_collect': true,
					'clicks': true
				};
				$.post(url,data, function (res) {
					_this.listData = res.data;

					if(_this.listData.user_id==''){
						$("#topBut").attr("disabled", true);
					}

					if(_this.listData.order_status != null){
						_this.order_status = _this.listData.order_status;
					}
					if (_this.order_status == 1) {
						$(".act_info_topBut").css('color', '#666');
						$(".act_info_topBut").text("已报名");
						$(".act_info_topBut").attr('disabled',true);
						$(".act_info_topBut").css('background', '#ddd');
						$(".act_info_topBut").unbind();
					} else if (_this.order_status == 0) {
						$(".act_info_topBut").text("点击参与");
					}
				})
			},
			getConfigData:function () {
				var _this = this;
				var url = "/<?php echo (API_PATH); ?>/Setting/settingAbout/channel/<?php echo ($channel); ?>/type/1";
				$.get(url, function (res) {
					_this.configData = res.data;
				})
			},
			showDetail:function (url) {
				window.location.href=url;
			},
//			showForm:function(){
//				if(!isLogin){
//					tip.setBody("请先登录");
//					return;
//				}else{
//					if(_this.order_status!=1){
//						topBut();
//					}
//				}
//			}
		}
	});
</script>