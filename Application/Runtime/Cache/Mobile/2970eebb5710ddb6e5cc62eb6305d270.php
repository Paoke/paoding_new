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
			<img style="width: 100%" src="/Template/5u/mobile/Static/img/dev/sever_banner.jpg"/>
            <div class="weui-cell" style="padding: 10px;">
                <div class="weui-cell__hd"><img src="/Template/5u/mobile/Static/img/dev/sever_dian.png" alt="" style="height:16px;margin-right:5px;display:block"></div>
                <div class="weui-cell__bd">
                    <p>服务内容</p>
                </div>
            </div>
            <div class="weui-panel">
	            <div class="weui-panel__bd">
	                <div class="weui-media-box weui-media-box_small-appmsg">
	                    <div class="weui-cells">
	                        <a class="weui-cell weui-cell_access" href="<?php echo U('User/service_dev');?>" style="padding: 30px 15px;border-top: 1px solid #eee;">
	                            <div class="weui-cell__hd" style="width: 30%;text-align: center;"><img style="width: 40.5px;height: 58.5px;" src="/Template/5u/mobile/Static/img/dev/sever1.png" alt="" style="margin-right:5px;display:block"></div>
	                            <div class="weui-media-box__bd" style="width: 100%;">
			                        <h4 class="weui-media-box__title" style="padding-bottom:5px;font-size: 16px;color: #333333;">一站式设计开发服务</h4>
			                        <p class="weui-media-box__desc">为您提供从设计到开发上线一站式服务。</p>
			                    </div>
	                            <span class="weui-cell__ft"></span>
	                        </a>
	                        <a class="weui-cell weui-cell_access" href="<?php echo U('User/service_ux');?>" style="padding: 30px 15px;border-top: 1px solid #eee;">
	                            <div class="weui-cell__hd" style="width: 30%;text-align: center;"><img style="width: 37.5px;height: 57.5px;" src="/Template/5u/mobile/Static/img/dev/sever2.png" alt="" style="margin-right:5px;display:block"></div>
	                            <div class="weui-media-box__bd" style="width: 100%;">
			                        <h4 class="weui-media-box__title" style="padding-bottom:5px;font-size: 16px;color: #333333;">产品原型设计服务</h4>
			                        <p class="weui-media-box__desc">提供单独的原型设计，用户体验设计服务。</p>
			                    </div>
	                            <span class="weui-cell__ft"></span>
	                        </a>
	                        <a class="weui-cell weui-cell_access" href="<?php echo U('User/service_ui');?>" style="padding: 30px 15px;border-top: 1px solid #eee;border-bottom: 1px solid #eee;">
	                            <div class="weui-cell__hd" style="width: 30%;text-align: center;"><img style="width: 54.5px;height: 42.5px;" src="/Template/5u/mobile/Static/img/dev/sever3.png" alt="" style="margin-right:5px;display:block"></div>
	                            <div class="weui-media-box__bd" style="width: 100%;">
			                        <h4 class="weui-media-box__title" style="padding-bottom:5px;font-size: 16px;color: #333333;">UI设计服务</h4>
			                        <p class="weui-media-box__desc">提供单独的网页等UI设计服务。</p>
			                    </div>
	                            <span class="weui-cell__ft"></span>
	                        </a>
	                    </div>
	                </div>
	            </div>
	        </div>
			<a href="<?php echo U('User/dev_submit');?>"><div class="index_send"><p>提交需求</p></div></a>
	        <div class="index_footK"></div>
	        <div class="index_footK"></div>
			<div class="index_foot">
				<div class="weui-tabbar">
	                <a href="<?php echo U('User/user_service');?>" class="weui-tabbar__item">
	                    <img src="/Template/5u/mobile/Static/img/dev/index_serve-active.png" alt="" class="weui-tabbar__icon">
	                    <p class="weui-tabbar__label">服务</p>
	                </a>
	                <a href="<?php echo U('User/cases');?>" class="weui-tabbar__item">
	                    <img src="/Template/5u/mobile/Static/img/dev/index_case.png" alt="" class="weui-tabbar__icon">
	                    <p class="weui-tabbar__label">案例</p>
	                </a>
	                <?php if($check == true): ?><a href="<?php echo U('User/personal');?>" class="weui-tabbar__item">
		                    <img style="width: 22px;" src="/Template/5u/mobile/Static/img/dev/index_my.png" alt="" class="weui-tabbar__icon">
		                    <p class="weui-tabbar__label">我的</p>
		                </a>
	                <?php else: ?>
	                	<a href="<?php echo U('User/about');?>" class="weui-tabbar__item">
		                    <img style="width: 22px;" src="/Template/5u/mobile/Static/img/dev/index_my.png" alt="" class="weui-tabbar__icon">
		                    <p class="weui-tabbar__label">关于</p>
		                </a><?php endif; ?>
	            </div>
			</div>
		</div>
	</body>
<script src="/Template/5u/mobile/Static/js/jquery-2.1.0.js" type="text/javascript" charset="utf-8"></script>
<script src="/Template/5u/mobile/Static/js/swiper.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/Template/5u/mobile/Static/js/index.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="/Public/home/js/jquery.md5.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="/Public/js/vue.js"></script>
</html>