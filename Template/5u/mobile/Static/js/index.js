$(function(){
	//点击切换
	var head = $(".swiper-slide");
	$(".swiper-slide").click(function(e){
//		e.preventDefault();
		$(this).addClass("index_head_active");
		$(this).siblings().removeClass("index_head_active");
		var id = $(this).attr("data-i");
		$("div[data-id="+id+"]").addClass("index_section_active");
		$("div[data-id="+id+"]").siblings().removeClass("index_section_active");
		location.replace($(this).attr("href"));	//为了替换当前链接，保证每次返回都是到专题列表
	})
	//锚点，返回还是当前导航标签
	var dian =  window.location.hash;
	for(i=0;i<head.length;i++){
		var mod = head.eq(i).attr("href");
		if(mod==dian){
			head.eq(i).click();
			break;
		}
	}
	//搜索
	$(".search").click(function(){
		$(".index_zhe").fadeIn(300);
		$(".index_search").css("transform","translateY(0)");
	})
	$("#searchCancel").click(function(){
		$(".index_zhe").fadeOut(300);
		$(".index_search").css("transform","translateY(-100%)");
	})
	$("#searchCancel2").click(function(){
		window.history.go(-1);
	})
	$(".index_zhe").click(function(){
		$(".index_zhe").fadeOut(300);
		$(".index_search").css("transform","translateY(-100%)");
	})
	//搜索输入内容清空
	$("#searchClear").click(function(){
		$("#searchInput").val("");
	})
	//选项
	$(".chevron-down").click(function(){
		$(".index_xuan").css("transform","translateY(0)");
	})
	$(".index_xuan_foot").click(function(){
		$(".index_xuan").css("transform","translateY(-100%)");
	})
	//内页分享收藏
	$("#detaile_foot1").click(function(){
		if(document.referrer === ''){
			location.href=$(this).attr("data-url")
		}else{
			window.history.back();
		}
		
	})
	$("#detaile_foot2").click(function(){
		$("#detaile_share1").fadeIn(500);
	})
	$("#detaile_share1").click(function(){
		$(this).fadeOut(500);
	})
	$("#detaile_foot3").click(function(){
		$("#detaile_share2").fadeIn(500);
	})
	$("#detaile_share2").click(function(){
		$(this).fadeOut(500);
	})

})
//头部实例化
function indexHead(dom, key){
	var head = dom;
	head.each(function(){
		var slideText = $(this).text();
		var slideX = slideText.length;
		var slideWidth = slideX * 19;
		$(this).width(slideWidth);
	})
	var swiper1 = new Swiper('.swiper-container', {
		slidesPerView : 'auto',
	});
	return swiper1;
}
//头部更新
function updateNav(dom, key){
	var dataStorageStr = localStorage.getItem(key);
	var dataStorage = JSON.parse(dataStorageStr);
	$(dom).each(function(){
		var id = $(this).attr("data-i");
		var val = dataStorage[id];
		$(this).text(val);
	})
}
//保存或取消分类信息
function changeDataStorage(dom, key){
	var dataStorageStr = localStorage.getItem(key);
	var dataStorage = JSON.parse(dataStorageStr);
	var xuan_val = $(dom).parent().parent().find("p").text();
	var xuan_id = $(dom).attr("id");
	if($(dom).is(":checked")){
		dataStorage[xuan_id] = xuan_val;
	}else{
		dataStorage[xuan_id] = "";
	}
	localStorage.setItem(key,JSON.stringify(dataStorage));
}
//根据本地缓存，判断是否给选项选中
function indexXuan(key){
	var dataStorageStr = localStorage.getItem(key);
	var dataStorage = JSON.parse(dataStorageStr);
	$(".index_xuan input").each(function(){
		var xuan_id = $(this).attr("id");
		var checked = dataStorage[xuan_id];
		if(checked==""){
			$(this).prop("checked",false);	
		}else{	
			$(this).prop("checked",true);
		}
	})
}
//第一次打开页面选项全部缓存
function LocationXuan(key){
	var dataStorage = {};
	$(".index_xuan input").each(function(){
		var xuan_val = $(this).parent().parent().find("p").text();
		var xuan_id = $(this).attr("id");
		dataStorage[xuan_id] = xuan_val;
	})
	dataStorageStr = JSON.stringify(dataStorage);
	localStorage.setItem(key,dataStorageStr);
	
}
//提交页绑定手机页输入框判断
var check = {
	"name" : "0",
	"phone" : "0",
	"yan" : "0",
	"need" : "0",
	"password" : "0",
	"email" : "0"
};
//姓名验证
$("#supply_name").blur(function(){
	var name = $(this).val();
	if(name.length==0){
		$(this).parent().parent().addClass("weui-cell_warn");
		check.name = 0;
	}else{
		$(this).parent().parent().removeClass("weui-cell_warn");
		check.name = 1;
	}
})
//手机号验证
$("#supply_phone").blur(function(){
	var phone = $(this).val();
	if(!(/^1(3|4|5|7|8)\d{9}$/.test(phone))){
		$(this).parent().parent().addClass("weui-cell_warn");
		check.phone = 0;
	}else{
		$(this).parent().parent().removeClass("weui-cell_warn");
		check.phone = 1;
	}
})
//验证码验证
$("#supply_yan").blur(function(){
	var yan = $(this).val();
	if(yan.length<4 || isNaN(yan)){
		$(this).parent().parent().addClass("weui-cell_warn");
		check.yan = 0;
	}else{
		$(this).parent().parent().removeClass("weui-cell_warn");
		check.yan = 1;
	}
})
//需求验证
$("#supply_need").blur(function(){
	var need = $(this).val();
	if(need.length==0){
		$(this).parent().parent().addClass("weui-cell_warn");
		check.need = 0;
	}else{
		$(this).parent().parent().removeClass("weui-cell_warn");
		check.need = 1;
	}
})
//密码验证
$("#supply_password").blur(function(){
	var password = $(this).val();
	if(password.length==0){
		$(this).parent().parent().addClass("weui-cell_warn");
		check.password = 0;
	}else{
		$(this).parent().parent().removeClass("weui-cell_warn");
		check.password = 1;
	}
})
//邮箱验证
$("#email").blur(function(){
	var email = $(this).val();
	if(email==""){
		check.email = 1;
	}else{
		if(!(/\w+[@]{1}\w+[.]\w+/.test(email))){
			$(this).parent().parent().addClass("weui-cell_warn");
			check.email = 0;
		}else{
			$(this).parent().parent().removeClass("weui-cell_warn");
			check.email = 1;
		}
	}
})
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

//报错信息
function errorReturn(msg){
	var x = msg.code;
	switch(x){
		case 300:
			$('#toast2').find("p").text('温馨提示：缺少值');
			break;
		case 400:
			$('#toast2').find("p").text('温馨提示：缺少参数');
			break;
		case 401:
			$('#toast2').find("p").text('温馨提示：手机格式错误');
			break;
		case 402:
			$('#toast2').find("p").text('温馨提示：验证码过期');
			break;
		case 403:
			$('#toast2').find("p").text('温馨提示：验证码错误');
			break;
		case 404:
			$('#toast2').find("p").text('温馨提示：此号码已被注册');
			break;
		case 405:
			$('#toast2').find("p").text('温馨提示：此号码未注册');
			break;
		case 406:
			$('#toast2').find("p").text('温馨提示：密码错误，请重试');
			break;
		case 411:
			$('#toast2').find("p").text('温馨提示：找不到该记录');
			break;
		case 444:
			$('#toast2').find("p").text('温馨提示：发生错误');
			break;
		case 500:
			$('#toast2').find("p").text('温馨提示：未登录！');
			break;
		case 600:
			$('#toast2').find("p").text('提交操作过于频繁！');
			break;	
	}
	if(x != 200){
		return false;
	}
}