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
	<body>
		<div class="web">
			<div class="weui-cells" style="margin-top: 0px;">
                <a class="weui-cell weui-cell_access" href="javascript:;">
                    <div class="weui-cell__hd" style="width:20%;text-align: center;"><img style="width: 40.5px;height: 58.5px;" src="/Template/5u/mobile/Static/img/dev/sever1.png" alt="" style="margin-right:5px;display:block"></div>
                    <div class="weui-media-box__bd" style="width: 100%;padding-left: 10px;">
                        <h4 class="weui-media-box__title" style="padding-bottom: 0px;">一站式设计开发服务</h4>
                        <p class="weui-media-box__desc">为您提供从设计到开发上线一站式服务。</p>
                    </div>
                </a>       
            </div>
            <div class="page grid js_show" style="background: #FFFFFF;margin-top: 10px;padding-bottom: 40px;border-bottom: 1px solid #d9d9d9;">
			    <div class="page__hd">
			        <h1 class="page__title service_dev_head">&nbsp;&nbsp;我们能为你做什么？</h1>
			        <p class="page__desc service_dev_head2">－微信－</p>
			    </div>
			    <div class="weui-grids">
			        <a href="javascript:;" class="weui-grid">
			            <div class="weui-grid__icon service_dev_img">
			                <img src="/Template/5u/mobile/Static/img/dev/service_dev1.png" alt="">
			            </div>
			            <p class="weui-grid__label">微网站</p>
			        </a>
			        <a href="javascript:;" class="weui-grid">
			            <div class="weui-grid__icon service_dev_img">
			                <img src="/Template/5u/mobile/Static/img/dev/service_dev2.png" alt="">
			            </div>
			            <p class="weui-grid__label">微商城</p>
			        </a>
			        <a href="javascript:;" class="weui-grid">
			            <div class="weui-grid__icon service_dev_img">
			                <img src="/Template/5u/mobile/Static/img/dev/service_dev3.png" alt="">
			            </div>
			            <p class="weui-grid__label">小程序</p>
			        </a>
			    </div>
			    <div class="page__hd">
			        <p class="page__desc service_dev_head2">－网站开发－</p>
			    </div>
			    <div class="weui-grids">
			        <a href="javascript:;" class="weui-grid">
			            <div class="weui-grid__icon service_dev_img">
			                <img src="/Template/5u/mobile/Static/img/dev/service_dev4.png" alt="">
			            </div>
			            <p class="weui-grid__label">官网建设</p>
			        </a>
			        <a href="javascript:;" class="weui-grid">
			            <div class="weui-grid__icon service_dev_img">
			                <img src="/Template/5u/mobile/Static/img/dev/service_dev5.png" alt="">
			            </div>
			            <p class="weui-grid__label">商城开发</p>
			        </a>
			        <a href="javascript:;" class="weui-grid">
			            <div class="weui-grid__icon service_dev_img">
			                <img src="/Template/5u/mobile/Static/img/dev/service_dev6.png" alt="">
			            </div>
			            <p class="weui-grid__label">系统定制</p>
			        </a>
			    </div>
			    <div class="page__hd">
			        <p class="page__desc service_dev_head2">－APP&H5－</p>
			    </div>
			    <div class="weui-grids">
			        <a href="javascript:;" class="weui-grid">
			            <div class="weui-grid__icon service_dev_img">
			                <img src="/Template/5u/mobile/Static/img/dev/service_dev7.png" alt="">
			            </div>
			            <p class="weui-grid__label">IOS开发</p>
			        </a>
			        <a href="javascript:;" class="weui-grid">
			            <div class="weui-grid__icon service_dev_img">
			                <img src="/Template/5u/mobile/Static/img/dev/service_dev8.png" alt="">
			            </div>
			            <p class="weui-grid__label">Android开发</p>
			        </a>
			        <a href="javascript:;" class="weui-grid">
			            <div class="weui-grid__icon service_dev_img">
			                <img src="/Template/5u/mobile/Static/img/dev/service_dev9.png" alt="">
			            </div>
			            <p class="weui-grid__label">H5页面开发</p>
			        </a>
			    </div>
			</div>
			<div class="page grid js_show" style="background: #FFFFFF;margin-top: 10px;padding-bottom: 30px;border-bottom: 1px solid #d9d9d9;">
			    <div class="page__hd">
			        <h1 class="page__title service_dev_head">我们的服务流程</h1>
			    </div>
			    <div class="weui-grids" style="padding-top: 25px;">
			    	<img style="width: 100%;" src="/Template/5u/mobile/Static/img/dev/service_dev10.jpg"/>
			    </div>
			    
			</div>
			<div class="index_footK"></div>
			<div class="service_foot">
				<div class="service_foot_left">
					<span id="service_foot1"><img style="width: 10px;height: 19px;padding-top: 5px;" src="/Template/5u/mobile/Static/img/dev/service_back.png"/></span>
					<span id="service_foot2"><img style="width: 23px;height: 20px;padding-top: 5px;" src="/Template/5u/mobile/Static/img/dev/service_share.png"/></span>
				</div>
				<a class="service_foot_bt" href="<?php echo U('User/dev_submit');?>">提交需求</a>
			</div>
			<div class="service_share">
				<img src="/Template/5u/mobile/Static/img/detaile_share.png"/>
			</div>
		</div>

	</body>
<script src="/Template/5u/mobile/Static/js/jquery-2.1.0.js" type="text/javascript" charset="utf-8"></script>
<script src="/Template/5u/mobile/Static/js/swiper.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/Template/5u/mobile/Static/js/index.js" type="text/javascript" charset="utf-8"></script>
<!--<script type="text/javascript" src="/Public/home/js/jquery.md5.js"></script>-->
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="/Public/js/vue.js"></script>
	<script type="text/javascript">
		
	</script>
</html>