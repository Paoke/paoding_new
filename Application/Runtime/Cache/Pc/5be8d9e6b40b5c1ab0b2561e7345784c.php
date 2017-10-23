<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="shortcut icon" href="/Template/5u/pc/Static/img/favicon.ico">
	<title>合作机构</title>
	<link rel="stylesheet" type="text/css" href="/Template/5u/pc/Static/css/swiper.min.css"/>
	<link rel="stylesheet" type="text/css" href="/Template/5u/pc/Static/css/index.css"/>
	<link rel="stylesheet" type="text/css" href="/Template/5u/pc/Static/font/iconfont.css"/>
	<style>
		.science_contentUl{display:none;}
		.science_contentUl.active{display: block;}
		.science_contentLi_contenBut{margin:0;}
	</style>
	<style>
		.layui-layer-content{padding:30px 30px 30px 30px;}
		.size{font-size: 24px;}
	</style>
	<style>
		body{
			font-family:"Segoe UI";
		}
		li{
			list-style:none;
		}
		a{
			text-decoration:none;
		}
		.pagination {
			position: relative;

		}
		.pagination li{
			display: inline-block;
			margin:0 5px;
		}
		.pagination li a{
			padding:.5rem 1rem;
			display:inline-block;
			border:1px solid #ddd;
			background:#fff;

			color:#0E90D2;
		}
		.pagination li a:hover{
			background:#eee;
		}
		.pagination li.active a{
			background:#0E90D2;
			color:#fff;
		}
		/*.activity_listpage{*/
			/*display: inline-block;*/
			/*font-size: 14px;*/
			/*color: #fff;*/
			/*padding: 10px 15px;*/
			/*border: 1px solid #eee;*/
			/*border-radius: 5px;*/
			/*background: #ff6d00;*/
			/*margin: 0 2px;*/
		/*}*/
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
				<a href="/index.php/Pc/Article/data_list/channel/js" class='navigation-link '>
					技术
				</a>
			</li>
			<li class="navigation-item ib">
				<a href="/index.php/Pc/Article/data_list/channel/hzjg" class='navigation-link selected-link'>
					合作机构
				</a>
			</li>
			<li class="navigation-item ib">
				<a href="/index.php/Pc/Article/data_list/channel/xq" class='navigation-link '>
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
<section id="template">
	<div class="science_list outside" >
		<div class="center">
			<div class="article_tab">
				<ul class="science_tabUl" style="width: 100%;">
					<li class="science_tabLi">
						<a id="yuansuo" class='science_tabLi_a science_tabLi_a_active'  href="/index.php/Pc/Article/data_list/channel/hzjg">院所/协会</a>
					</li>

					<li class="science_tabLi">
						<a id="hezuo" class='science_tabLi_a' href="/index.php/Pc/Article/data_list/channel/hzqy"  onclick="empty()">合作企业</a>
					</li>
				</ul>
			</div>
			<div class="science_list outside" >
				<div class="center">
					<div class="cook">
						<ul class="science_listUl active">
							<li class="science_listLi" v-for="minute in minuteData"  @click="getDataByCategory(minute.id)">
								<a @clicks="getDataByCategory(minute.id)">
									<img class="science_listLi_img" v-bind:src="minute.cat_img" style="width: 220px;height: 200px;"/>
									<h3 class="science_listLi_title" v-text="minute.cat_name"></h3>
								</a>
							</li>
						</ul>
					</div>
					<div class="clear"></div>

					<ul class="science_contentUl active">
						<li class="science_contentLi" v-for="group in groupData"  @click="getDetail(list.id)">
							<img class="company_contentLi_img" v-bind:src="group.cover_url" />
							<a  @click="getJtgsDetail(group.id)">
								<h2 class="science_contentLi_title" v-text="group.title"></h2>
							</a>
							<p class="science_contentLi_conten" >
								{{group.desc}}
							</p>
							<a class="science_contentLi_contenBut"  @click="getJtgsDetail(group.id)">查看全文></a>
						</li>
					</ul>

					<!--<ul class="science_contentUl">-->
						<!--<li class="science_contentLi" v-for="list in listData"  @click="getDetail(list.id)">-->
							<!--<img class="science_contentLi_img" v-bind:src="list.cover_url" />-->
							<!--<a  @click="getDetail(list.id)">-->
								<!--<h2 class="science_contentLi_title" v-text="list.title"></h2>-->
							<!--</a>-->
							<!--<p class="science_contentLi_conten" >-->
								<!--{{list.desc}}-->
							<!--</p>-->
							<!--<a class="science_contentLi_contenBut"  @click="getDetail(list.id)">查看全文></a>-->
						<!--</li>-->
					<!--</ul>-->
				</div>
				<div class="activity_listpage">
					<div>
						<a class="first" @click="go_page(1)" v-if="show_first">1...</a>
						<a class="prev" @click="go_page(page-1)" v-if="show_prex">&lt;&lt;</a>
						<a v-for="index in pages"  @click="go_page(index)" v-bind:class="{current: index==page}">{{index}}</a>
						<a class="next" @click="go_page(page+1)" v-if="show_next">&gt;&gt;</a>
						<a class="end" @click="go_page(page_total)" v-if="show_end">{{page_total}}</a>
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
				window.location.href="/index.php/Pc/Article/data_list/channel/hzjg"
			})
		}
	}
	function  WeChatLogin() {
		var url = "/<?php echo (API_PATH); ?>/User/getAppIdData";
		$.get(url, function (res) {
			if(res.result == 1) {
				window.location.href="https://open.weixin.qq.com/connect/qrconnect?appid="+res.data['appid']+"&redirect_uri=http://"+res.data['area_name']+"//index.php/Pc/Article/data_list/channel/hzjg/ifWeChatLogin/1&response_type=code&scope=snsapi_login&state=2015#wechat_redirect";
			} else {
				layer.msg("系统繁忙请稍后再试！");
			}
		})

	}

	function empty(){
		$(".cook").hide();
		$(".activity_listpage").hide();
		$('.science_contentUl:eq(0)').removeClass('active').siblings('.science_contentUl').addClass('active');
	}
</script>
<script>
	var vm = new Vue({
		el:'#template',
		data:{
			listData: '', //列表数据
			groupData:'',
			minuteData:'',
			categoryData:'',
			configData: '',
			page : 1,
			page_total:0,
			show_first:false,
			show_end:false,
			show_prex:false,
			show_next:false,
			show_item:5,
			bool : 'true',
			category_id: 0
		},
		computed:{
			pages:function(){
				var pag = [];
				if( this.page < this.show_item ){
					//如果当前的激活的项 小于要显示的条数
					//总页数和要显示的条数那个大就显示多少条
					var i = Math.min(this.show_item,this.page_total);
					while(i){
						pag.unshift(i--);
					}
				}else{ //当前页数大于显示页数了
					var middle = this.page - Math.floor(this.show_item / 2 ),//从哪里开始
							i = this.show_item;
					if( middle >  (this.page_total - this.show_item)  ){
						middle = (this.page_total - this.show_item) + 1
					}
					while(i--){
						pag.push( middle++ );
					}
				}
				return pag
			}
		},
		mounted: function () {
			this.$nextTick(function () {
				this.getData();
				this.getCategoryData();
				this.getGroupData();
				this.getGroupDetail();
				this.getConfigData();

				var ifHzqy = "<?php echo ($if_hzqy); ?>";
				var _this = this;
				if(ifHzqy == 1) {
					_this.getDataByCategory();
					_this.if_heqy();
				}
			})
		},
		updated:function(){

		},
		filters: {
		},
		methods:{
			getData:function () {
				var _this = this;
				var url = "/<?php echo (API_PATH); ?>/ChannelIndex/index/action/dataList/channel/<?php echo ($channel); ?>/type/1";
				var data={
					"order_field":"create_time",
					"order_by":"DESC",
				};
				$.post(url,data, function (res) {
					_this.listData = res.data;
				})
			},
			getGroupData:function () {
				vm.page = 1;
				vm.page_total = 0;
				//this.search(0);
			},
			getGroupDetail:function () {
				var _this = this;
				var url = "/<?php echo (API_PATH); ?>/ChannelIndex/index/action/dataList/channel/jtgs/type/2";
				$.get(url, function (res) {
					_this.minuteData = res.data;
					_this.getDataByCategory(_this.minuteData[0].id);
				})
			},
			getCategoryData:function () {
				var _this = this;
				var url = "/<?php echo (API_PATH); ?>/ChannelIndex/index/action/dataList/channel/<?php echo ($channel); ?>/type/2";
				$.get(url, function (res) {
					_this.categoryData = res.data;
				})
			},
			getEnterprise:function(){
				var _this=this;
				var url="/<?php echo (API_PATH); ?>/ChannelIndex/index/action/dataList/channel/qy/type/1";
				$.get(url,function(res){
					alert(JSON.stringify(res));
					_this.listData = res.data;
				})
			},

			getDataByCategory:function(category_id){
				vm.page = 1;
				vm.page_total = 0;
				this.search(category_id);
			},
			getConfigData:function () {
				var _this = this;
				var url = "/<?php echo (API_PATH); ?>/Setting/settingAbout";
				$.get(url, function (res) {
					_this.configData = res.data;
				})
			},
			showDetail:function (url) {
				window.location.href=url;
			},
			getDetail:function (id) {
				window.location.href="/index.php/Pc/Article/detail/channel/<?php echo ($channel); ?>/type/1/data_id/"+id;
			},
			getJtgsDetail:function (id) {
				window.location.href="/index.php/Pc/Article/detail/channel/jtgs/type/1/data_id/"+id;
			},
			search:function(category_id){
				var url = "/<?php echo (API_PATH); ?>/ChannelIndex/index/action/dataList/channel/jtgs/type/1";
				if(category_id > 0){
					vm.category_id = category_id;
					url += "/category_id/"+category_id;
				}
				var _this = this;
				var data={
					"get_page": true,
					"page": vm.page,
					"page_num":10,
					"order_field":"create_time",
					"order_by":"DESC",
				};
				$.post(url, data,function (res) {
					_this.groupData = res.data.info;
					var page = res.data.page;
					vm.page = parseInt(page.page);
					vm.page_total = parseInt(page.page_total);
					vm.show_first = (vm.page-1 > 1);
					vm.show_prex = (vm.page-1 > 0);
					vm.show_next = (vm.page_total-vm.page > 0);
					vm.show_end = (vm.page_total-vm.page > 1);
				})
			},
			go_page: function(page){
				if(page == vm.page){
					return;
				}
				vm.page = parseInt(page);
				this.search(vm.category_id);
				window.scrollTo(0,document.body.scrollHeight);
				window.scrollTo(0,0);
			},
			if_heqy: function(){
				$("#yuansuo").removeClass('science_tabLi_a_active');
				$("#hezuo").addClass('science_tabLi_a_active');
				$(".cook").hide();
				$(".activity_listpage").hide();
				$('.science_contentUl:eq(0)').removeClass('active').siblings('.science_contentUl').addClass('active');
			}
		}

	});


</script>