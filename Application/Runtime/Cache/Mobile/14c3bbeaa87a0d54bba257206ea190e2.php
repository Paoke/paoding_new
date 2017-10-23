<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<title><?php echo ($seoTitle); ?></title>
	<link rel="shortcut icon" href="/Template/5u/mobile/Static/img/favicon.ico">
	<meta name="keywords" content="<?php echo ($seoKeywords); ?>">
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
	<body>
		<div class="web">
			<!--<div class="serve_head">
				<img src="/Template/5u/mobile/Static/img/serve_logo.png"/>
			</div>-->
			<a href="/index.php/Mobile/Article/data_list/channel/js">
			<div class="weui-cells" style="padding: 10px 0;">
	            <div class="weui-cell" style="padding-bottom: 15px;">
	                <div class="weui-cell__hd" style="position: relative;margin-right: 10px;">
	                    <img src="/Template/5u/mobile/Static/img/serve_logo1.png" style="width: 40px;display: block">
	                </div>
	                <div class="weui-cell__bd">
	                    <p style="color: #333333;">庖丁技术</p>
	                    <p style="font-size: 13px;color: #888888;">技术与产业供需对接平台</p>
	                </div>
	            </div>
	            <div class="weui-media-box weui-media-box_text">
                    <p class="weui-media-box__desc" style="-webkit-line-clamp:100">庖丁技术致力于打破科研机构与企业之间信息不对称，推送高校研究所技术成果市场化，面向市场需求，把创新技术与企业需求相对接，推动技术升级。</p>
                </div>
	        </div>
	        </a>
	        <a href="<?php echo U('User/user_service');?>">
			<div class="weui-cells" style="padding: 10px 0;">
	            <div class="weui-cell" style="padding-bottom: 15px;">
	                <div class="weui-cell__hd" style="position: relative;margin-right: 10px;">
	                    <img src="/Template/5u/mobile/Static/img/serve_logo2.png" style="width: 34px;display: block">
	                </div>
	                <div class="weui-cell__bd">
	                    <p style="color: #333333;">庖丁开发</p>
	                    <p style="font-size: 13px;color: #888888;">专注于互联网项目设计开发</p>
	                </div>
	            </div>
	            <div class="weui-media-box weui-media-box_text">
                    <p class="weui-media-box__desc" style="-webkit-line-clamp:100">专注于互联网项目，为客户提供需求梳理、解决方案、产品原型、UI设计、软件开发等服务</p>
                </div>
	        </div>
			</a>
			<?php if($check != true): ?><div class="index_footK"></div>
				<div class="index_foot">
					<div class="weui-tabbar">
		                <a href="<?php echo U('Topic/index');?>" class="weui-tabbar__item">
		                    <img src="/Template/5u/mobile/Static/img/index_jishu.png" alt="" class="weui-tabbar__icon">
		                    <p class="weui-tabbar__label">技术</p>
		                </a>
		                <a href="<?php echo U('Task/index');?>" class="weui-tabbar__item">
		                    <img src="/Template/5u/mobile/Static/img/index_need.png" alt="" class="weui-tabbar__icon">
		                    <p class="weui-tabbar__label">需求</p>
		                </a>
		                <?php if($check == true): ?><a href="<?php echo U('User/personal');?>" class="weui-tabbar__item">
			                    <img src="/Template/5u/mobile/Static/img/index_my-active.png" alt="" class="weui-tabbar__icon">
			                    <p class="weui-tabbar__label">我的</p>
			                </a>
		                <?php else: ?>
		                	<a href="<?php echo U('User/service');?>" class="weui-tabbar__item">
			                    <img src="/Template/5u/mobile/Static/img/index_my-active.png" alt="" class="weui-tabbar__icon">
			                    <p class="weui-tabbar__label">关于</p>
			                </a><?php endif; ?>
		            </div>
				</div><?php endif; ?>
		</div>	
	</body>
<script src="/Template/5u/mobile/Static/js/jquery-2.1.0.js" type="text/javascript" charset="utf-8"></script>
<script src="/Template/5u/mobile/Static/js/swiper.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/Template/5u/mobile/Static/js/index.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="/Public/home/js/jquery.md5.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="/Public/js/vue.js"></script>
</html>