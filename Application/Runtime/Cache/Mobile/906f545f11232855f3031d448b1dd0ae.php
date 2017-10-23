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
			<div class="index_body" data-page="1" style="padding-top: 10px;">
				<?php if(is_array($case)): $i = 0; $__LIST__ = $case;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="weui-panel_access">
			            <div class="weui-panel__bd">
			                <a href="javascript:;" class="weui-media-box_appmsg index_section">
			                <!-- <a href="<?php echo U('Dev/case_info',array('case_id'=>$v['case_id']));?>" class="weui-media-box_appmsg index_section"> -->
			                    <img src="<?php echo ($v["case_img"]); ?>"/>
			                </a>
			            </div>
			        </div><?php endforeach; endif; else: echo "" ;endif; ?>
		    </div>
	        <div class="weui-panel__bd">
		        <div class="weui-panel__ft index_body_foot1">
	                <div class="weui-cell weui-cell_access weui-cell_link" style="padding: 10px;background: #FFFFFF;">
	                    <div class="weui-cell__bd" style="display: block;text-align: center;">查看更多</div>
	                </div>    
	            </div>
	            <div class="page__bd index_body_foot2" style="display: none;background: #FFFFFF;">
			        <div class="weui-loadmore" style="width: 100%; margin: 0px;padding: 15px 0px;">
			            <i class="weui-loading"></i>
			            <span class="weui-loadmore__tips">正在加载</span>
			        </div>
			    </div>
			    <div class="page__bd index_body_foot3" style="display:none;background: #FFFFFF;"">
			        <div class="weui-loadmore weui-loadmore_line" style="border: none; margin: 0px auto;">
			            <span class="weui-loadmore__tips" style="top: 0;padding: 10px;">————暂无数据————</span>
			        </div>
			    </div>
		    </div>
	        <div class="index_footK"></div>
			<div class="index_foot">
				<div class="weui-tabbar">
	                <a href="<?php echo U('User/user_service');?>" class="weui-tabbar__item">
	                    <img src="/Template/5u/mobile/Static/img/dev/index_serve.png" alt="" class="weui-tabbar__icon">
	                    <p class="weui-tabbar__label">服务</p>
	                </a>
	                <a href="<?php echo U('User/cases');?>" class="weui-tabbar__item">
	                    <img src="/Template/5u/mobile/Static/img/dev/index_case-active.png" alt="" class="weui-tabbar__icon">
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
	<script type="text/javascript">
		function pullUpAction (dom,_s) {
			pageNum = $(dom).attr("data-page");
//			var sciencetype = $(dom).attr('type');
			$.ajax({
				url:"<?php echo U('Dev/cases');?>",
				data:{page:pageNum++},
				type:'post',
				dataType:'json',
				success:function(science){
					if(science == ''){
						$(".index_body_foot2").css("display","none");
						$(".index_body_foot3").css("display","block");
					}else{
						addHtml(science,dom,_s);
					}
				}
			});
			
			$(dom).attr("data-page",pageNum);
		}
		function addHtml(datas,dom,_s){
			var result="";
			for(i=0;i<datas.length;i++){
				var data = datas[i];
				result += '<div class="weui-panel weui-panel_access">'+
		            '<div class="weui-panel__bd">'+
		                '<a href="<?php echo U('Dev/case_info','','');?>/case_id/'+data.case_id+'" class="weui-media-box_appmsg index_section">'+
		                    '<img src="'+data.case_img+'"/>'+
		               '</a></div></div>';
			}
			$(dom).append(result);
			$(".index_body_foot2").css("display","none");
			$(_s).css("display","block");
		}
		
		$(".index_body_foot1").click(function(){
			var _s = this;
			var dom = $(".index_body");
			$(this).css("display","none");
			$(".index_body_foot2").css("display","block");
			pullUpAction(dom,_s);	
		})
	</script>
</html>