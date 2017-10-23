<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<title><?php echo ($seoTitle); ?></title>
	<meta name="keywords" content="<?php echo ($seoKeywords); ?>">
	<link rel="shortcut icon" href="/Template/5u/mobile/Static/img/favicon.ico">
	<meta name="description" content="<?php echo ($seoDescription); ?>">
	<link rel="stylesheet" type="text/css" href="/Template/5u/mobile/Static/css/weui.min.css"/>
	<link rel="stylesheet" type="text/css" href="/Template/5u/mobile/Static/css/font-awesome.min.css"/>
	<link rel="stylesheet" type="text/css" href="/Template/5u/mobile/Static/css/swiper.min.css"/>
	<link rel="stylesheet" type="text/css" href="/Template/5u/mobile/Static/css/index.css"/>
	<style>
		[v-cloak] {display: none !important;}
	</style>
	<script>
		//百度统计
		var _hmt = _hmt || [];
		(function() {
			var hm = document.createElement("script");
			hm.src = "https://hm.baidu.com/hm.js?f095b63fbc1984edb5ae1cef37dd08a6";
			var s = document.getElementsByTagName("script")[0];
			s.parentNode.insertBefore(hm, s);
		})();
		//清除信息
		<?php if(!empty($clearAll)): ?>if(localStorage.getItem("clearAll") && localStorage.getItem("clearAll") == <?php echo ($clearAll); ?>){
			localStorage.clear();
		}<?php endif; ?>
	</script>
</head>
<body>
<section id="template" v-cloak>
	<div class="web">
		<div class="detaile_head">
			<p class="detaile_head1">{{listData.cat_name}}</p>
			<p class="detaile_head2">成熟度：</p>
			<p class="detaile_head3">{{listData.csd}}</p>
			<p class="detaile_head4"><i class="fa fa-fire"></i>{{listData.clicks}}</p>
		</div>
		<div class="detaile_body">
			<div class="page__bd" >
				<h1 v-text="listData.title"></h1>
				<p v-html="listData.content"></p>
			</div>
		</div>
		<div class="detaile_body2">
			<div class="weui-cells">
				<div class="weui-cell">
					<div class="weui-cell__hd"><img src="/Template/5u/mobile/Static/img/detaile1.png"/></div>
					<div class="weui-cell__bd">
						<p style="padding-left: 15px;">技术成熟度：{{listData.csd}}</p>
					</div>
				</div>
				<div class="weui-cell">
					<div class="weui-cell__hd"><img src="/Template/5u/mobile/Static/img/detaile2.png"/></div>
					<div class="weui-cell__bd">
						<p style="padding-left: 15px;">合作形式：{{listData.hzxs}}</p>
					</div>
				</div>
				<div class="weui-cell">
					<div class="weui-cell__hd"><img src="/Template/5u/mobile/Static/img/detaile3.png"/></div>
					<div class="weui-cell__bd">
						<p style="padding-left: 15px;">合作价格：{{listData.hzjg}}</p>
					</div>
				</div>
				<div class="weui-cell">
					<div class="weui-cell__hd"><img src="/Template/5u/mobile/Static/img/detaile4.png"/></div>
					<div class="weui-cell__bd">
						<p style="padding-left: 15px;">交付形式：{{listData.jfxs}}</p>
					</div>
				</div>
				<div class="weui-cell">
					<div class="weui-cell__hd" ><img src="/Template/5u/mobile/Static/img/detaile5.png"/></div>
					<div class="weui-cell__bd">
						<p style="padding-left: 15px;" v-if="listData.status==1">专利：有</p>

						<p style="padding-left: 15px;" v-else>专利：无</p>

					</div>
				</div>
				<span style="display:none;" id="sid"><?php echo ($info["science_id"]); ?></span>
			</div>
		</div>
		<div class="detaile_footK"></div>
		<div class="detaile_foot">
			<span data-url="<?php echo U('index');?>" id="detaile_foot1"><img src="/Template/5u/mobile/Static/img/detaile_foot-back.png"/></span>
			<span id="detaile_foot2"><img src="/Template/5u/mobile/Static/img/detaile_foot-collection.png"/></span>
			<span id="detaile_foot3"><img src="/Template/5u/mobile/Static/img/detaile_foot-share.png"/></i></span>
			<div class="detaile_foot_bt">
				<a href="<?php echo U('Index/science_js');?>" class="weui-btn weui-btn_primary" style="background: #FF7800;">我需要此技术</a>
			</div>
		</div>
		<div class="detaile_share" id="detaile_share1">
			<img src="/Template/5u/mobile/Static/img/detaile_collection.png"/>
		</div>
		<div class="detaile_share" id="detaile_share2">
			<img src="/Template/5u/mobile/Static/img/detaile_share.png"/>
		</div>
	</div>
</section>
</body>

<script src="/Template/5u/mobile/Static/js/jquery-2.1.0.js" type="text/javascript" charset="utf-8"></script>
<script src="/Template/5u/mobile/Static/js/swiper.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/Template/5u/mobile/Static/js/index.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="/Public/home/js/jquery.md5.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="/Public/js/vue.js"></script>
<script>
	var vm = new Vue({
		el:'#template',
		data:{
			listData: '', //列表数据
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
					_this.listData = res.data;
				})
			},

			getConfigData:function () {
				var _this = this;
				var url = "/<?php echo (API_PATH); ?>/Setting/settingAbout/channel/<?php echo ($channel); ?>/type/2";
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

<script type="text/javascript">
	wx.config({
				appId: '<?php echo ($signPackage["appId"]); ?>',
				timestamp: <?php echo ($signPackage["timestamp"]); ?>,
			nonceStr: '<?php echo ($signPackage["nonceStr"]); ?>',
			signature: '<?php echo ($signPackage["signature"]); ?>',
			jsApiList: [
		'checkJsApi',
		'onMenuShareTimeline',
		'onMenuShareAppMessage',
		'onMenuShareQQ',
		'onMenuShareWeibo'
	]
	});
	wx.ready(function () {
		// 1 判断当前版本是否支持指定 JS 接口，支持批量判断
		wx.checkJsApi({
			jsApiList: [
				'getNetworkType',
				'previewImage',
				'onMenuShareTimeline',
				'onMenuShareAppMessage',
				'onMenuShareQQ',
				'onMenuShareWeibo'
			],
		});

		//分享给朋友
		wx.onMenuShareAppMessage({
			title: '<?php echo ($share["title"]); ?>', // 分享标题
			desc: '<?php echo ($share["desc"]); ?>', // 分享描述
			link: '<?php echo ($signPackage["url"]); ?>', // 分享链接
			imgUrl: "http://<?php echo ($area_name); echo ($share["img"]); ?>", // 分享图标
			success: function () {
				var sid = $('#sid').html();
				$.ajax({
					url:"<?php echo U('Science/shareAdd');?>",
					data:{science_id:sid},
					type:'post',
					dataType:'json',
					success:function(msg){
						errorReturn(msg);
						if(msg.code=='200'){
							return true;
						}
					}
				});
			}
		});

		//分享到朋友圈
		wx.onMenuShareTimeline({
			title: '<?php echo ($share["title"]); ?>', // 分享标题
			desc: '<?php echo ($share["desc"]); ?>', // 分享描述
			link: '<?php echo ($signPackage["url"]); ?>', // 分享链接
			imgUrl: "http://<?php echo ($area_name); echo ($share["img"]); ?>", // 分享图标
			success: function () {
				var sid = $('#sid').html();
				$.ajax({
					url:"<?php echo U('Science/shareAdd');?>",
					data:{science_id:sid},
					type:'post',
					dataType:'json',
					success:function(msg){
						errorReturn(msg);
						if(msg.code=='200'){
							return true;
						}
					}
				});
			}
		});

		//分享到QQ
		wx.onMenuShareQQ({
			title: '<?php echo ($share["title"]); ?>', // 分享标题
			desc: '<?php echo ($share["desc"]); ?>', // 分享描述
			link: '<?php echo ($signPackage["url"]); ?>', // 分享链接
			imgUrl: "http://<?php echo ($area_name); echo ($share["img"]); ?>", // 分享图标
			success: function () {
				var sid = $('#sid').html();
				$.ajax({
					url:"<?php echo U('Science/shareAdd');?>",
					data:{science_id:sid},
					type:'post',
					dataType:'json',
					success:function(msg){
						errorReturn(msg);
						if(msg.code=='200'){
							return true;
						}
					}
				});
			}
		});

		//分享到微博
		wx.onMenuShareWeibo({
			title: '<?php echo ($share["title"]); ?>', // 分享标题
			desc: '<?php echo ($share["desc"]); ?>', // 分享描述
			link: '<?php echo ($signPackage["url"]); ?>', // 分享链接
			imgUrl: "http://<?php echo ($area_name); echo ($share["img"]); ?>", // 分享图标
			success: function () {
				var sid = $('#sid').html();
				$.ajax({
					url:"<?php echo U('Science/shareAdd');?>",
					data:{science_id:sid},
					type:'post',
					dataType:'json',
					success:function(msg){
						errorReturn(msg);
						if(msg.code=='200'){
							return true;
						}
					}
				});
			}
		});

		//分享到QQ空间
		wx.onMenuShareQZone({
			title: '<?php echo ($share["title"]); ?>', // 分享标题
			desc: '<?php echo ($share["desc"]); ?>', // 分享描述
			link: '<?php echo ($signPackage["url"]); ?>', // 分享链接
			imgUrl: "http://<?php echo ($area_name); echo ($share["img"]); ?>", // 分享图标
			success: function () {
				var sid = $('#sid').html();
				$.ajax({
					url:"<?php echo U('Science/shareAdd');?>",
					data:{science_id:sid},
					type:'post',
					dataType:'json',
					success:function(msg){
						errorReturn(msg);
						if(msg.code=='200'){
							return true;
						}
					}
				});
			}
		});

	});
</script>
</html>