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
			<?php if($science != null): ?><div class="weui-panel weui-panel_access" style="background: #f3f4f8;margin-top: 0px;" data-page="1">
					<?php if(is_array($science)): $i = 0; $__LIST__ = $science;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="weui-panel__hd user_head"><?php echo ($v["science_name"]); ?></div>
						<div class="weui-panel__bd">
			                <a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg" style="padding-bottom: 0px;">
			                    <div class="weui-media-box__hd user_img">
			                        <img class="weui-media-box__thumb" src="<?php echo session('head_url');?>" alt="">
			                    </div>
			                    <div class="weui-media-box__bd">
			                    	<ul class="weui-media-box__info">
				                        <li class="weui-media-box__info__meta" style="color: #999999;"><?php echo ($v["create_time"]); ?></li>
				                        <?php if($v['reply'] != null): ?><li class="weui-media-box__info__meta" style="float: right;color: #009944;font-size: 12px;">已沟通</li>
				                        <?php else: ?>
				                        <li class="weui-media-box__info__meta" style="float: right;color: #FF7800;font-size: 12px;">待沟通</li><?php endif; ?>
				                    </ul>
			                        <p class="weui-media-box__desc" style="padding-top: 5px;padding-bottom: 20px;color: #666;-webkit-line-clamp:100"><?php echo ($v["message"]); ?></p>
			                    </div>
			                </a>
			            </div>
			            <div class="weui-panel__bd">
			                <div class="weui-media-box weui-media-box_text" style="padding-top: 0px;padding-left: 85px;">
			                	<?php if($v['reply'] != null): ?><h4 class="weui-media-box__title" style="font-size: 13px;color: #222;">沟通回复：</h4>
			                    <p class="weui-media-box__desc" style="background: #f3f4f8;padding: 10px;color: #222;-webkit-line-clamp:100"><?php echo ($v["reply"]); ?></p><?php endif; ?>
			                </div>
			            </div><?php endforeach; endif; else: echo "" ;endif; ?>
		        </div>
				<div class="weui-panel" style="margin-top: 0px;">
		          	<div class="weui-panel__ft index_body_foot1">
		                <div class="weui-cell weui-cell_access weui-cell_link" style="padding: 10px;">
		                    <div class="weui-cell__bd" style="text-align: center;">查看更多</div>
		                </div>    
		            </div>
		            <div class="page__bd index_body_foot2" style="display: none;">
				        <div class="weui-loadmore">
				            <i class="weui-loading"></i>
				            <span class="weui-loadmore__tips">正在加载</span>
				        </div>
				    </div>
				    <div class="page__bd index_body_foot3" style="display: none;">
				        <div class="weui-loadmore weui-loadmore_line">
				            <span class="weui-loadmore__tips">暂无数据</span>
				        </div>
				    </div>
		        </div>
	        <?php else: ?>
				<div class="uesr_null">
					<div class="uesr_nulli"><img src="/Template/5u/mobile/Static/img/user_null.png"/></div>
					<div class="uesr_null1">您暂未提交任何需求</div>
					<div class="uesr_null2"><a style="color:blue;text-decoration:none;" href="/index.php/Mobile/Article/data_list/channel/xq">返回需求列表</a></div>
				</div><?php endif; ?>
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
			var pageNum = $(dom).siblings(".weui-panel_access").attr("data-page");
			$.ajax({
				url:"<?php echo U('User/user_sciences');?>",
				data:{page:pageNum++},
				type:'post',
				dataType:'json',
				success:function(science){
					if(science == ''){
						$(_s).siblings(".index_body_foot2").css("display","none");
						$(_s).siblings(".index_body_foot3").css("display","block");
					}else{
						addHtml(science,dom,_s);
					}
				}
			});
			
			$(dom).siblings(".weui-panel_access").attr("data-page",pageNum);
		}
		
		function addHtml(datas,dom,_s){
			var result="";
			for(i=0;i<datas.length;i++){
				var data = datas[i];
				var reply = '';
				var rmsg = '';
				if(data.reply){
					reply = '<li class="weui-media-box__info__meta" style="float: right;color: #009944;font-size: 12px;">已沟通</li>';
					rmsg = '<h4 class="weui-media-box__title" style="font-size: 13px;color: #222;">沟通回复：</h4><p class="weui-media-box__desc" style="background: #f3f4f8;padding: 10px;color: #222;-webkit-line-clamp:100">'+data.reply+'</p>';
				}else{
					reply = '<li class="weui-media-box__info__meta" style="float: right;color: #FF7800;font-size: 12px;">待沟通</li>';
				}
				result += 	'<div class="weui-panel__hd user_head">'+data.science_name+'</div>'+
							'<div class="weui-panel__bd">'+
				                '<a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg" style="padding-bottom: 0px;">'+
				                    '<div class="weui-media-box__hd user_img">'+
				                        '<img class="weui-media-box__thumb" src="<?php echo session("head_url");?>" alt="">'+
				                    '</div>'+
				                    '<div class="weui-media-box__bd">'+
				                    	'<ul class="weui-media-box__info">'+
					                        '<li class="weui-media-box__info__meta" style="color: #999999;">'+data.create_time+'</li>'+reply+   
					                    '</ul>'+
				                        '<p class="weui-media-box__desc" style="padding-top: 5px;padding-bottom: 20px;color: #666;-webkit-line-clamp:100">'+data.message+'</p>'+
				                    '</div>'+
				                '</a>'+
				            '</div>'+
				            '<div class="weui-panel__bd">'+
				                '<div class="weui-media-box weui-media-box_text" style="padding-top: 0px;padding-left: 85px;">'+rmsg+
				                '</div>'+
				            '</div>'	
			}
	        $(dom).siblings(".weui-panel_access").append(result);
	        $(_s).siblings(".index_body_foot2").css("display","none");
			$(_s).css("display","block");
		}
		
		$(".index_body_foot1").click(function(){
			var _s = this;
			var dom = $(this).parents();
			$(this).css("display","none");
			$(this).siblings(".index_body_foot2").css("display","block");
			pullUpAction(dom,_s);
		})
	</script>
</html>