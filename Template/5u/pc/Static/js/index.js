//提示弹出框
var Tips ={
		createNew:function(){
			var tips = {};
			tips.setBody = function(data){
				$('#tips').show();
				$('#tips').text(data);
				window.setTimeout(function (){
					$('#tips').hide();
				},2000);
			};
			return tips;
		}
};
var tip = Tips.createNew();
$(function(){
	//头部搜索框点击显示
	$(".icon-iconfontsousuo1").hover(function(){
		$(".head_search").fadeIn(300);
		$(this).css('color','#333');
	},function(){
		$(this).css('color','#fff');
	})
	$('.head_search').hover(function(){
		$(".icon-iconfontsousuo1").css('color','#333');
	},function(){
		$('.head2').find(".icon-iconfontsousuo1").css('color','#fff');
		$('.head').find(".icon-iconfontsousuo1").css('color','#333');
	})
	$(".icon-iconfontsousuo1").click(function(){
		$('.head_searchImg').click();
	})
	//搜索框消失
	$(".head_searchLI").mouseleave(function(){
		$(".head_search").fadeOut(300);
	})
	//partner鼠标悬浮
	$(".partnerLi").hover(function(){
		$(this).find(".partner_img").addClass("hide");
		$(this).find(".partner_imgActive").removeClass("hide");
	},function(){
		$(this).find(".partner_img").removeClass("hide");
		$(this).find(".partner_imgActive").addClass("hide");
	})
	$('.aphone').click(function(){
		$(".cover").fadeIn(300);
		$('.alter-phone').css({
			"top":"50%",
			"transform" :"translate(-50%,-50%)"
		})
	})
	$('.apassword').click(function(){
		$(".cover").fadeIn(300);
		$('.alter-password').css({
			"top":"50%",
			"transform" :"translate(-50%,-50%)"
		})
	})
	$('.bphone').click(function(){
		$(".cover").fadeIn(300);
		$('.band-phone').css({
			"top":"50%",
			"transform" :"translate(-50%,-50%)"
		})
	})
	//登录弹窗
	$(".head_login").click(function(){
		$(".cover").fadeIn(300);
		$(".login_page").css({
			"top":"50%",
			"transform" :"translate(-50%,-50%)"
		})
	})
	//登录弹窗消失
	$(".cover").click(function(){
		$(".login_page").css({
			"top":"0",
			"transform" :"translate(-50%,-100%)"
		})
		$(".contact").css({
			"top":"0",
			"transform" :"translate(-50%,-100%)"
		})
		$(".modal").css({
			"top":"0",
			"transform" :"translate(-50%,-100%)"
		})
		$(this).fadeOut(500);
	})
	//登录弹窗page切换
	$(".register").click(function(){
		$(".login_entry").css("display","none");
		$(".login_register").fadeIn(500);
	})
	$(".entry").click(function(){
		$(".login_register").css("display","none");
		$(".login_entry").fadeIn(500);
	})
	$(".forget").click(function(){
		$(".login_entry").css("display","none");
		$(".login_forget").fadeIn(500);
	})
	$(".entry2").click(function(){
		$(".login_forget").css("display","none");
		$(".login_entry").fadeIn(500);
	})
	$(".register2").click(function(){
		$(".login_forget").css("display","none");
		$(".login_register").fadeIn(500);
	})
	//关闭登陆弹窗
	$(".login_close").click(function(){
		$(".login_page").css({
			"top":"0",
			"transform" :"translate(-50%,-100%)"
		})
		$(".contact").css({
			"top":"0",
			"transform" :"translate(-50%,-100%)"
		})
		$(".modal").css({
			"top":"0",
			"transform" :"translate(-50%,-100%)"
		})
		$(".cover").fadeOut(500);
	})
	$(".login_closeImg").hover(function(){
		$(this).css("transform","rotate(180deg)");
	},function(){
		$(this).css("transform","rotate(0deg)");
	})
	//登陆头像
	$(".head_user").hover(function(){
		var height = $(".head_userLi").length*43
		$(".head_userUl").css("height",height+"px");
	},function(){
		$(".head_userUl").css("height","0");
	})
	//技术列表导航
	$(".science_tabLi_a").click(function(){
		$(this).addClass("science_tabLi_a_active");
		$(this).parent().siblings().find(".science_tabLi_a").removeClass("science_tabLi_a_active");
	})
	$(".science_new_tab").click(function(){
		$(this).addClass("science_new_tab_active");
		$(this).siblings().removeClass("science_new_tab_active");
	})
	//联系我们弹窗
	$(".science_head_but, .widget_sub,.banner-btn").click(function(){
		$(".cover").fadeIn(300);
		$(".contact").css({
			"top":"50%",
			"transform" :"translate(-50%,-50%)"
		})
	})
	//关注公众号弹框
	$('.modal-wechat').hover(function(){
		$('.wechat-modal').removeClass('hide');
	},function(){
		$('.wechat-modal').addClass('hide');
	})
	$('#wechatModal').hover(function(){
		$('.wechat-modal').removeClass('hide');
	},function(){
		$('.wechat-modal').addClass('hide');
	})
})

//提交输入框判断
var check = {
	"mobile" : "0",
	"password" : "0",
	"verify" : "0",
	"username" : "0",
	"message" : "0"
};
//头部鼠标悬浮后变色
/*$('.head2').hover(function(){
	$(this).css({'background':'#fafafa','position':'absolute','z-index':10})
	$(this).removeClass('head2');
},function(){
	$(this).addClass('head2');
	
})*/
/***************手机号验证开始***************/

// 登陆
$("#phone").blur(function(){
	var mobile = $(this).val();
	if(!(/^1(3|4|5|7|8)\d{9}$/.test(mobile))){
		tip.setBody('手机号格式不正确');
		check.mobile = 0;
	}else{
		check.mobile = 1;
	}
})
// 注册
$("#mobile").blur(function(){
	var mobile = $(this).val();
	if(!(/^1(3|4|5|7|8)\d{9}$/.test(mobile))){
		tip.setBody('手机号格式不正确');
		check.mobile = 0;
	}else{
		check.mobile = 1;
	}
})
// 重设密码
$("#mobnum").blur(function(){
	var mobile = $(this).val();
	if(!(/^1(3|4|5|7|8)\d{9}$/.test(mobile))){
		tip.setBody('手机号格式不正确');
		check.mobile = 0;
	}else{
		check.mobile = 1;
	}
})
// 弹层提交
$("#jumpMobile").blur(function(){
	var mobile = $(this).val();
	if(!(/^1(3|4|5|7|8)\d{9}$/.test(mobile))){
		tip.setBody('手机号格式不正确');
		check.mobile = 0;
	}else{
		check.mobile = 1;
	}
})

/***************手机号验证结束***************/

/****************密码验证开始****************/

// 登陆
$("#pwd").blur(function(){
	var password = $(this).val();
	if(password.length<6){
		tip.setBody('输入6位或以上的密码');
		check.password = 0;
	}else{
		check.password = 1;
	}
})
// 注册
$("#paswd").blur(function(){
	var password = $(this).val();
	if(password.length<6){
		tip.setBody('输入6位或以上的密码');
		check.password = 0;
	}else{
		check.password = 1;
	}
})
// 重设密码
$("#newpwd").blur(function(){
	var password = $(this).val();
	if(password.length<6){
		tip.setBody('输入6位或以上的密码');
		check.password = 0;
	}else{
		check.password = 1;
	}
})

/****************密码验证结束****************/

/***************验证码验证开始***************/

// 注册
$("#p_yzm").blur(function(){
	var verify = $(this).val();
	if(verify.length<4 || isNaN(verify)){
		tip.setBody('验证码不合法');
		check.verify = 0;
	}else{
		check.verify = 1;
	}
})
// 重设密码
$("#mobyzm").blur(function(){
	var verify = $(this).val();
	if(verify.length<4 || isNaN(verify)){
		tip.setBody('验证码不合法');
		check.verify = 0;
	}else{
		check.verify = 1;
	}
})
// 弹层提交
$("#jumpCode").blur(function(){
	var verify = $(this).val();
	if(verify.length<4 || isNaN(verify)){
		tip.setBody('验证码不合法');
		check.verify = 0;
	}else{
		check.verify = 1;
	}
})

/***************验证码验证结束***************/

/****************姓名验证开始****************/

// 弹层提交
$("#jumpName").blur(function(){
	var username = $(this).val();
	if(username.length==0){
		tip.setBody('请输入姓名');
		check.username = 0;
	}else{
		check.username = 1;
	}
})

/****************姓名验证结束****************/

/****************留言验证开始****************/

// 弹层提交
$("#jumpMessage").blur(function(){
	var message = $(this).val();
	if(message.length==0){
		tip.setBody('请输入您的留言信息');
		check.message = 0;
	}else{
		check.message = 1;
	}
})

/****************留言验证结束****************/

//验证码发送倒计时
var wait=60;
function time(o) { 
//	console.log(o);
	if (wait == 0) { 
		o.removeAttr("disabled"); 
		o.text("重新发送"); 
		wait = 2;
	} else { 
		o.attr("disabled", true); 
		o.text("已发送(" + wait +"s"+ ")"); 
		wait--; 
		setTimeout(function() { 
			time(o) 
		}, 1000) 
	} 
}