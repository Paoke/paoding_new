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
	<link rel="stylesheet" type="text/css" href="/Template/5u/mobile/Static/css/layer.mobile.css"/>
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
			<div class="supply_head">
				<div class="weui-cell"style="padding: 0;padding-left: 15px;padding-top: 15px;">
	                <div class="weui-cell__bd">
	                    <p>需求描述</p>
	                </div>
	            </div>
			</div>
			<div class="weui-cells weui-cells_form" style="margin-top: 5px;">
	            <div class="weui-cell">
	                <div class="weui-cell__bd">
	                    <textarea class="weui-textarea supply_textarea" placeholder="简单描述您的需求，提交后1~3个工作日内将有专人与您联系！" rows="8" id="supply_need"></textarea>    
	                </div>
	            </div>
	        </div>
			<div class="weui-cells weui-cells_form">
	            <div class="weui-cell" style="padding: 10px;">
	                <div class="weui-cell__hd"><label class="weui-label">姓名</label></div>
	                <div class="weui-cell__bd">
	                    <input class="weui-input" type="text" placeholder="请输入您的姓名" id="supply_name">
	                </div>
	            </div>
	        </div>
				
			<div class="weui-cells_form" style="margin-top: 0px;background: #FFFFFF;color: #666666;">
	            <div class="weui-cell weui-cell_vcode">
	                <div class="weui-cell__hd">
	                    <label class="weui-label">手机号</label>
	                </div>
	                <div class="weui-cell__bd">
	                    <input class="weui-input" type="tel" placeholder="请输入手机号" id="supply_phone">
	                </div>
	                <div class="weui-cell__ft">
	                    <button class="weui-vcode-btn" id="supply_send" style="background: none;border:none;border-left: 1px solid #eee;color: #FF7800;" onclick="code('/<?php echo (API_PATH); ?>/Sms/sendMessage')">获取验证码</button>
	                </div>
	            </div>   
	        </div>
	        <div class="weui-cells weui-cells_form" style="margin-top: 0px;">
	            <div class="weui-cell" style="padding: 10px;">
	                <div class="weui-cell__hd"><label class="weui-label">验证码</label></div>
	                <div class="weui-cell__bd">
	                    <input class="weui-input" type="text" placeholder="请输入验证码" id="supply_yan" >
	                </div>
	            </div>
	        </div>
	        <div class="index_footK"></div>
	        <div class="supply_foot" id="supply_foot">
	        	<a href="javascript:;" class="weui-btn weui-btn_primary" style="background: #FF7800;" onclick="Contact('/<?php echo (API_PATH); ?>/Article/add_by_code')">提交</a>
	        </div>
			
			<div id="toast" style="opacity: 1; display:none">
		        <div class="weui-mask_transparent"></div>
		        <div class="weui-toast">
		            <i class="weui-icon-success-no-circle weui-icon_toast"></i>
		            <p class="weui-toast__content">提交成功</p>
		        </div>
		    </div>
		    <div id="toast2" style="opacity: 1; display:none">
		        <div class="weui-mask_transparent"></div>
		        <div class="weui-toast">
		            <i class="weui-icon-warn weui-icon_msg" style="font-size:80px; margin-top: 10px;"></i>
		            <p class="weui-toast__content" style="color: #f76260;">提交失败</p>
		        </div>
		    </div>
			<div id="loadingToast" style="display:none;">
		        <div class="weui-mask_transparent"></div>
		        <div class="weui-toast">
		            <i class="weui-loading weui-icon_toast"></i>
		            <p class="weui-toast__content">正在提交</p>
		        </div>
		    </div>
		</div>
		
		
	</body>
<script src="/Template/5u/mobile/Static/js/jquery-2.1.0.js" type="text/javascript" charset="utf-8"></script>
<script src="/Template/5u/mobile/Static/js/swiper.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/Template/5u/mobile/Static/js/index.js" type="text/javascript" charset="utf-8"></script>
<script src="/Template/5u/mobile/Static/js/layer.mobile.js"  type="text/javascript"></script>
<script type="text/javascript" src="/Public/home/js/jquery.md5.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="/Public/js/vue.js"></script>
<script>
	function code(url){
		var dom = $(".weui-vcode-btn");
		var mobile=$("#supply_phone").val();
		if(mobile.length!=11){
			layer.open({
				content: "请输入正确的手机格式"
				,skin: 'msg'
				,time: 2 //2秒后自动关闭
			});
		}

		$.ajax({
			url:url,
			type:"post",
			data:{"mobile":mobile},
			dataType:"json",
			success:function(res){
				if(res.result==1){
					time(dom);
					layer.open({
						content: "发送成功"
						,skin: 'msg'
						,time: 2 //2秒后自动关闭
					});
				}else if(res.result==0){
					layer.open({
						content: "发送失败"
						,skin: 'msg'
						,time: 2 //2秒后自动关闭
					});
				}
			}
		},'json');
	}


	function Contact(url){
		var content=$("#supply_need").val();
		var name=$("#supply_name").val();
		var mobile=$("#supply_phone").val();
		var code=$("#supply_yan").val();
		var category_id=1;
		if(content==''){
			layer.open({
				content: "请输入留言信息"
				,skin: 'msg'
				,time: 2 //2秒后自动关闭
			});
			return;
		}
		if(name==''){
			layer.open({
				content: "请输入姓名"
					,skin: 'msg'
					,time: 2 //2秒后自动关闭
			});
			return;
		}
		if(mobile.length!=11){
			layer.open({
				content: "请输入正确的手机格式"
				,skin: 'msg'
				,time: 2 //2秒后自动关闭
			});
			return;
		}
		var data={"jumpMessage":content,"jumpName":name,"jumpMobile":mobile,"code":code,"category_id":category_id};
		$.ajax({
			url:url,
			type:"post",
			data:data,
			dataType:"json",
			success:function(res){
				layer.open({
					content: res.msg,
					skin: 'msg',
					time: 1//1秒后自动关闭
				});
				if(res.result==1){
					setTimeout(
							function(){
								window.location.reload();
							},2000);

				}else if(res.result==0){
				}
			}
		},'json');
	}
</script>


</html>