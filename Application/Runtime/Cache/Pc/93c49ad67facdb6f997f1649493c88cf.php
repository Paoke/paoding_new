<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="shortcut icon" href="/Template/5u/pc/Static/img/favicon.ico">
	<title>首页</title>
	<link rel="stylesheet" type="text/css" href="/Template/5u/pc/Static/css/swiper.min.css"/>
	<link rel="stylesheet" type="text/css" href="/Template/5u/pc/Static/css/index.css"/>
	<link rel="stylesheet" type="text/css" href="/Template/5u/pc/Static/font/iconfont.css"/>
	<link rel="stylesheet" type="text/css" href="/Template/5u/pc/Static/css/style.css"/>
	<style>
		.layui-layer-content{padding:30px 30px 30px 30px;}
		.size{font-size: 24px;}
		[v-cloak] {display: none !important;}
	</style>

	<script src="/Template/5u/pc/Static/js/jquery-2.1.0.js" type="text/javascript" charset="utf-8"></script>
	<script src="/Template/5u/pc/Static/js/swiper.min.js" type="text/javascript" charset="utf-8"></script>
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
				<a href="/index.php/Pc/Index/index" class='navigation-link selected-link'>
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
					<li class="head_userLi"><a  href="javascript:;" onclick="logout('/<?php echo (API_PATH); ?>/User/logout')">退出</a></li>
				</ul>
			<?php else: ?>
				<a class="head_login" href="javascript:;">登录</a><?php endif; ?>
		</li>
	</ul>
</div>
</header>
<section id="ContentData" v-cloak>
	<!-- 轮播图开始 -->
	<section class="banner">
		<div class="swiper-container indexBanner">
			<div class="swiper-wrapper">
				<?php if(is_array($list)): foreach($list as $key=>$vo): ?><div class="swiper-slide">
					<a class="bannerBox" href="javascript:;">
						<img src="<?php echo ($vo["ad_code"]); ?>" alt="" style="width: 100%;height: 100%;"/>
					</a>
				</div><?php endforeach; endif; ?>
			</div>
			<div class="swiper-pagination"></div>
		</div>
	</section>
	<script type="text/javascript">
		$(function () {
			var swiper = new Swiper('.indexBanner', {
				loop: true,
				pagination: '.swiper-pagination',
				paginationClickable: true,
				autoplay: 2500
			});
		})
	</script>
	<!-- 轮播图end -->
		<div class="achievement outside">
			<div class="center">
				<ul class="achievementUl">
					<li class="achievementLi">
						<h3>{{jsCount}}</h3>
						<p>科技成果发布</p>
					</li>
					<li class="achievementLi">
						<h3>{{xqCount}}</h3>
						<p>市场需求发布</p>
					</li>
					<li class="achievementLi">
						<h3>{{fwdjCount}}</h3>
						<p>次服务对接</p>
					</li>
				</ul>
				<div class="clear"></div>
			</div>
		</div>
	<div class="achievement outside" style="height:600px;padding-top: 20px" >
		<div class="center">
			<h2 style="color: #333333;font-weight: 400;padding-bottom: 20px;text-align: center;">技术</h2>
			<ul class="science_listUl">
				<li class="science_listLi" v-for="list in jsList">
					<a  @click="showJsDetail(list.id)">
						<img class="science_listLi_img" v-bind:src="list.cover_url" />
						<h3 class="science_listLi_title" v-text="list.title"></h3>
						<p class="science_listLi_tab" v-text="list.create_time"></p>
					</a>
				</li>
			</ul>
		</div>
	</div>

	<div class="achievement outside" style="height:600px;padding-top: 20px" >
		<div class="center">
			<h2 style="color: #333333;font-weight: 400;padding-bottom: 20px;text-align: center;">需求</h2>
			<ul class="science_listUl">
				<li class="science_listLi" v-for="list in xqList">
					<a  @click="showXqDetail(list.id)">
						<img class="science_listLi_img" v-bind:src="list.cover_url" />
						<h3 class="science_listLi_title" v-text="list.title"></h3>
						<p class="science_listLi_tab" v-text="list.create_time"></p>
					</a>
				</li>
			</ul>
		</div>
	</div>

	<div class="achievement outside" style="height:320px;padding-top: 20px" >
		<div class="center">
			<h2 style="color: #333333;font-weight: 400;padding-bottom: 20px;text-align: center;">活动</h2>
			<ul class="science_listUl">
				<li class="science_listLi" v-for="list in hdList">
					<a  @click="showHdDetail(list.id)">
						<img class="science_listLi_img" v-bind:src="list.cover_url" />
						<h3 class="science_listLi_title" v-text="list.title"></h3>
						<p class="science_listLi_tab" v-text="list.desc"></p>
					</a>
				</li>
			</ul>
		</div>
	</div>

	<div class="achievement outside" style="height:320px;padding-top: 20px" >
		<div class="center">
			<h2 style="color: #333333;font-weight: 400;padding-bottom: 20px;text-align: center;">合作机构</h2>
			<ul class="science_listUl">
				<li class="science_listLi" v-for="list in hzjgList">
					<a  @click="showHzjgDetail(list.id)">
						<img class="science_listLi_img" v-bind:src="list.cover_url" />
						<h3 class="science_listLi_title" v-text="list.title"></h3>
						<p class="science_listLi_tab" v-text="list.desc"></p>
					</a>
				</li>
			</ul>
		</div>
	</div>

	<div class="achievement outside" style="height:320px;padding-top: 20px" >
		<div class="center">
			<h2 style="color: #333333;font-weight: 400;padding-bottom: 20px;text-align: center;">资讯</h2>
			<ul class="science_listUl">
				<li class="science_listLi" v-for="list in zxList">
					<a  @click="showZxDetail(list.link)">
						<img class="science_listLi_img" v-bind:src="list.cover_url" />
						<h3 class="science_listLi_title" v-text="list.title"></h3>
						<p class="science_listLi_tab" v-text="list.create_time"></p>
					</a>
				</li>
			</ul>
		</div>
	</div>
		<!--<div class="section outside">-->
			<!--<div class="center section_center">-->
				<!--<div class="section_leftImg">-->
					<!--<img src="/Template/5u/pc/Static/img/section1.jpg"/>-->
				<!--</div>-->
				<!--<h2 class="section_rightTitle">技术方案库</h2>-->
				<!--<p class="section_rightContent">海量领先技术任您选择，寻找和合适技术方案，合作转化实现价值。</p>-->
<!--&lt;!&ndash; 				<p class="section_rightContent2">如果您拥有创新技术，希望扩大应用场景，对接市场需求，立即联系我们吧。</p>-->
 <!--&ndash;&gt;				<a class="section_rightButton" href="/index.php/Pc/Article/data_list/channel/js">前往查看</a>-->
				<!--<div class="clear"></div>-->
			<!--</div>-->
		<!--</div>-->
		<!--<div class="section outside">-->
			<!--<div class="center section_center">-->
				<!--<div class="section_rightImg">-->
					<!--<img src="/Template/5u/pc/Static/img/section2.jpg"/>-->
				<!--</div>-->
				<!--<h2 class="section_rightTitle">市场需求中心</h2>-->
				<!--<p class="section_rightContent">为创新技术扩大应用场景，寻找合适的对接市场需求。</p>-->
<!--&lt;!&ndash; 				<p class="section_rightContent2">如果您拥有创新技术，希望扩大应用场景，对接市场需求，请发布</p>-->
 <!--&ndash;&gt;				<a class="section_rightButton" href="/index.php/Pc/Article/data_list/channel/xq">前往查看</a>-->
				<!--<div class="clear"></div>-->
			<!--</div>-->
		<!--</div>-->
		<!--<div class="section outside">-->
			<!--<div class="center section_center">-->
				<!--<div class="section_leftImg">-->
					<!--<img src="/Template/5u/pc/Static/img/section3.jpg"/>-->
				<!--</div>-->
				<!--<h2 class="section_rightTitle">最新活动</h2>-->
				<!--<p class="section_rightContent">庖丁技术直通车等科技对接活动，参与启动供需转化“直通车”。</p>-->
<!--&lt;!&ndash; 				<p class="section_rightContent2">如果您拥有创新技术，希望扩大应用场景，对接市场需求，请发布</p>-->
 <!--&ndash;&gt;				<a class="section_rightButton" href="/index.php/Pc/Activity/data_list/channel/hd">前往查看</a>-->
				<!--<div class="clear"></div>-->
			<!--</div>-->
		<!--</div>-->
		<!--<div class="section outside">-->
			<!--<div class="center section_center" style="border-bottom: none;">-->
				<!--<div class="section_rightImg">-->
					<!--<img src="/Template/5u/pc/Static/img/section4.jpg"/>-->
				<!--</div>-->
				<!--<h2 class="section_rightTitle">最新资讯</h2>-->
				<!--<p class="section_rightContent">掌握最新的行业技术动态，奇妙创意和新酷产品尽在于此。</p>-->
<!--&lt;!&ndash; 				<p class="section_rightContent2">如果您拥有创新技术，希望扩大应用场景，对接市场需求，请发布</p>-->
 <!--&ndash;&gt;				<a class="section_rightButton" href="/index.php/Pc/Article/data_list/channel/zx">前往查看</a>-->
				<!--<div class="clear"></div>-->
			<!--</div>-->
		<!--</div>-->
		<div class="partner outside">
			<div class="center section_center">
				<h2 class="partner_title">合作伙伴</h2>
				<span class="partner_underline"></span>
				<ul class="partnerUl">
					<li class="partnerLi">
						<img src="/Template/5u/pc/Static/img/partner1Active.png" class="partner_imgActive hide"/>
						<img src="/Template/5u/pc/Static/img/partner1.png" class="partner_img"/>
					</li>
					<li class="partnerLi">
						<img src="/Template/5u/pc/Static/img/partner2Active.png" class="partner_imgActive hide"/>
						<img src="/Template/5u/pc/Static/img/partner2.png" class="partner_img"/>
					</li>
					<li class="partnerLi">
						<img src="/Template/5u/pc/Static/img/partner3Active.png" class="partner_imgActive hide"/>
						<img src="/Template/5u/pc/Static/img/partner3.png" class="partner_img"/>
					</li>
					<li class="partnerLi">
						<img src="/Template/5u/pc/Static/img/partner4Active.png" class="partner_imgActive hide"/>
						<img src="/Template/5u/pc/Static/img/partner4.png" class="partner_img"/>
					</li>
					<li class="partnerLi">
						<img src="/Template/5u/pc/Static/img/partner5Active.png" class="partner_imgActive hide"/>
						<img src="/Template/5u/pc/Static/img/partner5.png" class="partner_img"/>
					</li>
				</ul>
				<div class="clear"></div>
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

<!--<script type="text/javascript" src="/Template/5u/pc/Static/js/jquery-1.7.1.min.js"></script>-->
<!--<script type="text/javascript" src="/Template/5u/pc/Static/js/jquery.event.drag-1.5.min.js"></script>-->
<!--<script type="text/javascript" src="/Template/5u/pc/Static/js/jquery.touchSlider.js"></script>-->

<script src="/Template/5u/pc/Static/js/index.js" type="text/javascript" charset="utf-8"></script>
<script src="/Template/5u/pc/Static/js/jquery.md5.js" type="text/javascript"></script>
<script src="/Template/5u/pc/Static/js/common.js" type="text/javascript"></script>
<script src="/Public/js/vue.js"></script>
<script src="/Public/js/layer/layer-min.js"></script>

<script type="text/javascript">
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

	$(document).ready(function(){
		getUser();
		$(".main_visual").hover(function(){
			$("#btn_prev,#btn_next").fadeIn()
		},function(){
			$("#btn_prev,#btn_next").fadeOut()
		});

		$dragBln = false;

		$(".main_image").touchSlider({
			flexible : true,
			speed : 200,
			btn_prev : $("#btn_prev"),
			btn_next : $("#btn_next"),
			paging : $(".flicking_con a"),
			counter : function (e){
				$(".flicking_con a").removeClass("on").eq(e.current-1).addClass("on");
			}
		});

		$(".main_image").bind("mousedown", function() {
			$dragBln = false;
		});

		$(".main_image").bind("dragstart", function() {
			$dragBln = true;
		});

		$(".main_image a").click(function(){
			if($dragBln) {
				return false;
			}
		});

		timer = setInterval(function(){
			$("#btn_next").click();
		}, 5000);

		$(".main_visual").hover(function(){
			clearInterval(timer);
		},function(){
			timer = setInterval(function(){
				$("#btn_next").click();
			},5000);
		});

		$(".main_image").bind("touchstart",function(){
			clearInterval(timer);
		}).bind("touchend", function(){
			timer = setInterval(function(){
				$("#btn_next").click();
			}, 5000);
		});

	});

	function getUser() {
		var ifWeChatLogin = "<?php echo ($ifWeChatLogin); ?>";
		if(ifWeChatLogin == 1) {
			var url = "/<?php echo (API_PATH); ?>/User/WeChatLogin/code/<?php echo ($code); ?>";
			$.get(url, function (res) {
				window.location.href="/index.php/Pc/Index/index"
			})
		}
	}
	function  WeChatLogin() {
		var url = "/<?php echo (API_PATH); ?>/User/getAppIdData";
		$.get(url, function (res) {
			if(res.result == 1) {
				window.location.href="https://open.weixin.qq.com/connect/qrconnect?appid="+res.data['appid']+"&redirect_uri=http://"+res.data['area_name']+"//index.php/Pc/Index/index/ifWeChatLogin/1&response_type=code&scope=snsapi_login&state=2015#wechat_redirect";
			} else {
				layer.msg("系统繁忙请稍后再试！");
			}
		})

	}
</script>
<script>
	var vm2 = new Vue({
		el:'#ContentData',
		data:{
			jsList:'',
			xqList:'',
			hdList:'',
			hzjgList:'',
			zxList:'',
			jsCount:0,
			xqCount:0,
			configData:'',
			fwdjCount:0
		},
		mounted: function () {
			this.$nextTick(function () {
				this.getJsList();
				this.getXqList();
				this.getHdList();
				this.getZxList();
				this.getHzjgList();
				this.getJsCount();
				this.getXqCount();
				this.getFwdjCount();
				this.getConfigData();
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
			getJsList:function(){
				var url = "/<?php echo (API_PATH); ?>/ChannelIndex/index/action/dataList/channel/js/type/1";
				var _this = this;
				var data={
					"get_page": true,
					"page": 1,
					"page_num":10,
					"order_field":"create_time",
					"order_by":"DESC",
				};
				$.post(url, data,function (res) {
					_this.jsList = res.data.info;
				})
			},
			getXqList:function(){
				var url = "/<?php echo (API_PATH); ?>/ChannelIndex/index/action/dataList/channel/xq/type/1";
				var _this = this;
				var data={
					"get_page": true,
					"page": 1,
					"page_num":10,
					"order_field":"create_time",
					"order_by":"DESC",
				};
				$.post(url, data,function (res) {
					_this.xqList = res.data.info;
				})
			},
			getHzjgList:function(){
				var url = "/<?php echo (API_PATH); ?>/ChannelIndex/index/action/dataList/channel/hzjg/type/1";
				var _this = this;
				var data={
					"get_page": true,
					"page": 1,
					"page_num":5,
					"data_by": "is_red desc,create_time desc"
					//"order_field":"create_time",
					//"order_by":"DESC",
				};
				$.post(url, data,function (res) {
					_this.hzjgList = res.data.info;
				})
			},
			getHdList:function(){
				var url = "/<?php echo (API_PATH); ?>/ChannelIndex/index/action/dataList/channel/hd/type/1";
				var _this = this;
				var data={
					"get_page": true,
					"page": 1,
					"page_num":5,
					"order_field":"create_time",
					"order_by":"DESC",
				};
				$.post(url, data,function (res) {
					_this.hdList = res.data.info;
				})
			},
			getZxList:function(){
				var url = "/<?php echo (API_PATH); ?>/ChannelIndex/index/action/dataList/channel/zx/type/1";
				var _this = this;
				var data={
					"get_page": true,
					"page": 1,
					"page_num":5,
					"order_field":"create_time",
					"order_by":"DESC",
				};
				$.post(url, data,function (res) {
					_this.zxList = res.data.info;
				})
			},
			getJsCount:function () {
				var _this = this;
				var url = "/<?php echo (API_PATH); ?>/ChannelIndex/index/action/count/channel/js/type/1";
				$.get(url, function (res) {
					_this.jsCount = res.data;
				})
			},
			getXqCount:function () {
				var _this = this;
				var url = "/<?php echo (API_PATH); ?>/ChannelIndex/index/action/count/channel/xq/type/1";
				$.get(url, function (res) {
					_this.xqCount = res.data;
				})
			},
			getFwdjCount:function () {
				var _this = this;
				var url = "/<?php echo (API_PATH); ?>/ChannelIndex/index/action/count/channel/fwdj/type/1";
				$.get(url, function (res) {
					_this.fwdjCount = res.data;
				})
			},
			showJsDetail:function (id) {
				window.location.href="/index.php/Pc/Article/detail/channel/js/type/1/data_id/"+id;
			},
			showXqDetail:function (id) {
				window.location.href="/index.php/Pc/Article/detail/channel/xq/type/1/data_id/"+id;
			},
			showZxDetail:function (url) {
				window.location.href=url;
			},
			showHzjgDetail:function (id) {
				window.location.href="/index.php/Pc/Article/detail/channel/hzjg/type/1/data_id/"+id;
			},
			showHdDetail:function (id) {
				window.location.href="/index.php/Pc/Activity/detail/channel/hd/type/1/data_id/"+id;
			}
		}
	});
</script>