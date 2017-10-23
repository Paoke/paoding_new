<?php if (!defined('THINK_PATH')) exit();?><meta name="format-detection" content="telephone=no" />
<!DOCTYPE html>
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
	<body>
		<div class="web" id="template">
			<div class="weui-cells weui-cells_form">
				<div class="weui-cell" style="padding: 10px;">
	                <div class="weui-cell__hd"><label class="weui-label">账号</label></div>
	                <div class="weui-cell__bd">
	                    <input class="weui-input" type="text" readonly="true" v-bind:value="userInfo.user_name">
	                </div>
	            </div>
	            <div class="weui-cell"style="padding: 10px;">
	                <div class="weui-cell__hd"><label class="weui-label" >手机号</label></div>
	                <div class="weui-cell__bd">
						<div v-if="userInfo.mobile==''">
							<a href="<?php echo U('User/connect');?>" style="color:#5786e6">绑定手机</a>
	                  </div>
						<div v-else>
							<input class="weui-input" type="text" readonly="true" v-bind:value="userInfo.mobile">
						</div>

	                </div>
	            </div>
	        </div>
	        <div class="weui-cells weui-cells_form">
				<div class="weui-cell" style="padding: 10px;">
	                <div class="weui-cell__hd"><label class="weui-label">昵称</label></div>
	                <div class="weui-cell__bd">
	                		<input class="weui-input" type="text" id="nickname"  v-bind:value="userInfo.nickname"  placeholder="未填写">
	                </div>
	            </div>
	            <div class="weui-cell" style="padding: 10px;">
	                <div class="weui-cell__hd"><label class="weui-label">公司</label></div>
	                <div class="weui-cell__bd">
							<input class="weui-input" type="text" id="company"  v-bind:value="userInfo.company" placeholder="未填写"/>
	                </div>
	            </div>
	            <div class="weui-cell" style="padding: 10px;">
	                <div class="weui-cell__hd"><label class="weui-label">邮箱</label></div>
	                <div class="weui-cell__bd">
	                		<input class="weui-input" type="text" id="email"  v-bind:value="userInfo.email" placeholder="未填写" />
	                </div>
	            </div>
	        </div>
	        
	        <div class="supply_foot" >
	        	<a style="background: #FF7800;" id="next_foot" class="weui-btn weui-btn_primary">完成</a>
	        </div>
	        <div id="toast" class="toast" style="opacity: 1; display:none">
		        <div class="weui-mask_transparent"></div>
		        <div class="weui-toast">
		            <i class="weui-icon-success-no-circle weui-icon_toast"></i>
		            <p class="weui-toast__content">已完成</p>
		        </div>
		    </div>
			<div id="loadingToast" class="loadingToast" style="display:none;">
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
<script type="text/javascript" src="/Template/5u/mobile/Static/js/jquery.md5.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="/Public/js/vue.js"></script>
	<script type="text/javascript">
		$(function(){
			$('#next_foot').click(function(){
				var url = "/<?php echo (API_PATH); ?>/User/user_info/action/edit";
				var user_id = "<?php echo ($user_id); ?>";
				var nickname = $("#nickname").val();
				var email = $("#email").val();
				var company = $("#company").val();
				var data={
					"user_id":user_id,
					"nickname":nickname,
					"email":email,
					"company":company
				};
				$.post(url,data,function(res){
						if(res.result==1){
							$("#loadingToast").css("display","none");
							$("#toast").css("display","block");
							window.history.go(-1);
						}else {
							layer.msg("网络繁忙！");
						}
				})
			})
		});





//		$(function(){
//			$('#next_foot').click(function(){
//				var id ="<?php echo ($user_id); ?>";
//				$("#email").blur();
//				if(check.email==1){
//					$("#loadingToast").css("display","block");
//					var email = $('#email').val();
//					var username = $('#username').val();
//					var company = $('#company').val();
//					$.ajax({
//						url:"/<?php echo (API_PATH); ?>/User/user_info/action/edit",
//						data:{
//							'id':id,
//							'email':email,
//							'username':username,
//							'company':company
//						},
//						type:'post',
//						dataType:'json',
//						success:function(msg){
//							errorReturn(msg);
//							if(msg.code == 200){
//								$("#loadingToast").css("display","none");
//								$("#toast").css("display","block");
//								setTimeout(function(){
//									$("#toast").css("display","none");
//									// window.location.href = "<?php echo U('User/personal');?>";
//									window.history.go(-1);
//								},500)
//							}
//						}
//					});
//				}
//			});
//		})

		var vm = new Vue({
			el:'#template',
			data:{
				configData: '', //列表数据
				userInfo:''
			},
			mounted: function () {
				this.$nextTick(function () {
					this.getUserInfo();
				})
			},
			updated:function(){
			},
			filters: {
			},
			methods:{
				getUserInfo:function(){
					var _this=this;
					var url = "/<?php echo (API_PATH); ?>/User/user_info/action/detail/id/<?php echo ($user_id); ?>";
					$.get(url,function(res){
						_this.userInfo = res.data;
					})
				}
			}
		});
	</script>
</html>