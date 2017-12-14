<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="shortcut icon" href="/Template/5u/pc/Static/img/favicon.ico">
	<title>技术</title>
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
				<a href="/index.php/Pc/Index/index" class='navigation-link '>
					首页
				</a>
			</li>
			<li class="navigation-item ib">
				<a href="/index.php/Pc/Article/data_list/channel/js" class='navigation-link selected-link'>
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
				<a href="/index.php/Pc/Activity/data_list/channel/hd" class='navigation-link '>
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
	<div class="science_list outside">
		<div class="center">
			<div class="blog_box">
				<a href="/index.php/Pc/Article/data_list/channel/js">技术列表 > </a>
				<span>技术详情</span>
			</div>
			<div class="blog">
				<div class="blog_title">
					{{listData.title}}
				</div>
				<div class="blog_desc">
					<span>发布于{{listData.create_time}}</span>
					<span>阅读量{{listData.clicks}}</span>
				</div>
				<div class="blog_content" v-html="listData.content">
				</div>
				
			</div>
			<div class="blog_widget">
				<div class="widget_head">概要信息</div>

				<div class="widget_body">
					<div>技术领域：{{listData.cat_name}}</div>
					<div>成熟度：{{listData.csd}}</div>
					<div>合作形式：{{listData.hzxs}}</div>
					<div>合作价格：{{listData.hzjg}}</div>
					<div>交付形式：{{listData.jfxs}}</div>
					<div>专利：{{listData.zhuanli}}</div>
					<div v-if="WhetherContact">
						<div>公司名：{{listData.gsm}}</div>
						<div>联系人姓名：{{listData.lxrxm}}</div>
						<div>手机号码：{{listData.dhhm}}</div>
						<div>电子邮箱：{{listData.dzyx}}</div>
					</div>
					<div  v-if="contactButton">
						<button class="widget_sub2"  @click="getContact()">获取联系方式</button>
					</div>
				</div>
				<div class="widget_footer">
					<p>需要了解此技术或更多需求，请联系我们</p>
					<button class="widget_sub">联系客服</button>
				</div>

			</div>
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
		<button class="login_leftPageGetcode" id="jumpGetCode" onclick="code('/<?php echo (API_PATH); ?>/Sms/sendMessage')">获取验证码</button>
		<a class="login_leftPageBut" id="jumpSubmit" onclick="Contact('/<?php echo (API_PATH); ?>/Article/add_by_code')">提交</a>
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
				window.location.href="/index.php/Pc/Article/detail/channel/<?php echo ($channel); ?>/type/1/data_id/<?php echo ($data_id); ?>"
			})
		}
	}
	function  WeChatLogin() {
		var url = "/<?php echo (API_PATH); ?>/User/getAppIdData";
		$.get(url, function (res) {
			if(res.result == 1) {
				window.location.href="https://open.weixin.qq.com/connect/qrconnect?appid="+res.data['appid']+"&redirect_uri=http://"+res.data['area_name']+"//index.php/Pc/Article/detail/channel/<?php echo ($channel); ?>/type/1/data_id/<?php echo ($data_id); ?>/ifWeChatLogin/1&response_type=code&scope=snsapi_login&state=2015#wechat_redirect";
			} else {
				layer.msg("系统繁忙请稍后再试！");
			}
		})

	}
	function code(url){
		var dom = $(".login_leftPageGetcode");
		var mobile=$("#jumpMobile").val();
		if(mobile.length!=11){
			tip.setBody("请输入正确的手机格式");
			return;
		}

		$.ajax({
			url:url,
			type:"post",
			data:{"mobile":mobile},
			dataType:"json",
			success:function(res){
				if(res.result==1){
					time(dom);
					tip.setBody(res.msg);
				}else if(res.result==0){
					tip.setBody(res.msg);
				}
			}
		},'json');
	}
	function Contact(url){
		var content=$("#jumpMessage").val();
		var name=$("#jumpName").val();
		var mobile=$("#jumpMobile").val();
		var code=$("#jumpCode").val();
		var category_id=1;
		if(content==''){
			tip.setBody("请输入留言信息");
			return;
		}
		if(name==''){
			tip.setBody("请输入姓名");
			return;
		}
		if(mobile==''){
			tip.setBody("请输入手机号码");
			return;
		}
		var data={"jumpMessage":content,"jumpName":name,"jumpMobile":mobile,"code":code,"category_id":category_id};
		$.ajax({
			url:url,
			type:"post",
			data:data,
			dataType:"json",
			success:function(res){
				if(res.result==0){
					tip.setBody(res.msg);
				}else if(res.result==1){
					tip.setBody(res.msg);
					window.location.reload();
				}
			}
		},'json');
	}
</script>
<script>
	var vm = new Vue({
		el:'#template',
		data:{
			listData: '', //列表数据
			categoryData:'',
			configData:'',
			page :  '0',
			bool : 'true',
			WhetherContact : false, // 是否获取联系方式
			contactButton : true  //获取联系方式是否隐藏

		},
		mounted: function () {
			this.$nextTick(function () {
				this.getData();
				this.getConfigData();
				this.getCategory();
				this.getListData();
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
				$.get(url, function (res) {
					//alert(JSON.stringify(res));
					_this.listData = res.data;
				})
			},

			getCategory:function(){
				var _this = this;
				var url = "/<?php echo (API_PATH); ?>/ChannelIndex/index/action/dataList/channel/<?php echo ($channel); ?>/type/2";
				$.get(url, function (res) {
//					alert(JSON.stringify(res));
					_this.categoryData = res.data;
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

			getContact:function () {
				var userId = "<?php echo session('userId');?>";
				var userName = "<?php echo session('userName');?>";
				if (userId) {
					if(userName) {
						var url = "/<?php echo (API_PATH); ?>/Article/getContactData/channel/<?php echo ($channel); ?>/type/1/data_id/<?php echo ($data_id); ?>/user_id/"+userId;
						$.get(url, function (res) {
							_this.configData = res.data;
						})
						this.WhetherContact = true;
						this.contactButton = false;
					} else {
						layer.msg("请先到个人中心绑定手机号码！");
					}

				} else {
					layer.msg("请先登录！");
				}


			},
		}
	});
</script>