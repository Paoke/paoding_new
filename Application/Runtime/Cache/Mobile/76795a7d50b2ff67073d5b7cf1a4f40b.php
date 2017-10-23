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
<section id="template">
	<body>
		<div class="web">
			<li v-for="zt in ztData">
			<a class="tList_body" @click="getZtDetail(zt.id)">
				<div class="tList_body2">
				<img style="width: 100%;" v-bind:src="zt.cover_url"/>
	        	<div class="section">
	        		<p class="section4" v-text="zt.title"></p>
	        		<p class="section5"></p>
	        	</div>
	        	</div>
			</a>
			</li>
		</div>
	</body>
</section>
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
			ztData:'',
			bool : 'true',
		},
		mounted: function () {
			this.$nextTick(function () {
				this.getZt();
			})
		},
		updated:function(){
		},
		filters: {
		},
		methods:{
			getZt:function(){
				var _this=this;
				var url="/<?php echo (API_PATH); ?>/ChannelIndex/index/action/dataList/channel/ztgl/type/1";
				$.get(url,function(res){
					_this.ztData = res.data;
				});
			},
			getZtDetail:function (id) {
				window.location.href="/index.php/Mobile/Article/tlist/channel/tlist/type/1/data_id/"+id;
			},

		}
	});
</script>



	<script type="text/javascript">
		$(".tList_body").eq(0).css("padding-top","10px");
	</script>
</html>