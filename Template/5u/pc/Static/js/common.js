<!-- 登陆开始 -->
function login(url){
	var username=$("#username").val();
	var password=$("#password").val();
//			var nameReg = /^((13[0-9]{1})|(14[0-9]{1})|(17[0]{1})|(15[0-3]{1})|(15[5-9]{1})|(18[0-9]{1}))+\d{8}$/;
	var pwdReg = /^(([a-z]+)|([0-9]+)|([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i;
	if (username == '' || username.length < 2 || username.length >16) {
		tip.setBody('请输入正确的登录名');
	} else
	if  (password == '' || password.length >15 || password.length <6 || !pwdReg.test(password)){
		tip.setBody('请输入正确的密码');
	}
	$.ajax({
		type:"post",
		url:url,
		data:{"username":username,"password":password},
		dataType:"json",
		success:function(res){
			tip.setBody(res.msg);
			if(res.result==1){
				location.reload(true);
			}
		}
	},'json');
}
<!-- 登陆结束 -->

<!-- 注销开始 -->
function logout(url,goto){
	$.post(url, function (res) {
		if(res.result==1){
			tip.setBody(res.msg);
		}
		if(goto==null){
			location.reload(true);
		}else{
			window.location.href=goto;
		}
	})
}
<!-- 注销结束 -->

<!-- 注册开始 -->
function register(url){
	var mobile=$("#mobile").val();
	var code=$("#code").val();
	var paswd=$("#paswd").val();
	if($("input[type='checkbox']").is(":checked")){
	}else {
		tip.setBody('请先选择同意注册条款');
		return false;
	}
	if(paswd.length>15 || paswd.length<6){
		tip.setBody('请输入正确的密码格式');
		return;
	}else if(code.length!=4){
		tip.setBody('请输入正确的验证码');
		return;
	}

	var data={"mobile":mobile,"code":code,"paswd":paswd};
	$.ajax({
		url:url,
		type:"post",
		data:data,
		dataType:"json",
		success:function(res){
			if(res.result==1){
				tip.setBody(res.msg);
				location.reload(true);
			}else if(res.result == 0){
				tip.setBody(res.msg);
			}else if(res.result == 2){
				tip.setBody(res.msg);
			}
		}
	},'json');
}


<!-- 注册结束 -->




<!-- 验证码开始 -->
function get_code(url){
	var dom = $(".login_leftPageGetcode");
	var mobile = $("#mobile").val();
	if(mobile == ''){
		tip.setBody('请输入手机号码');
		return false;
	}else if(mobile.length!=11){
		tip.setBody('请输入正确的手机格式');
		return;
	}
	var data={"mobile":mobile};
	$.ajax({
		url:url,
		type:'post',
		data:data,
		dataType:'json',
		success:function(msg){
			if(msg.result == 1){
				time(dom);
				tip.setBody(msg.msg);
			}else if(msg.result==0){
				tip.setBody(msg.msg);
			}
		}
	},'json');
}
var wait=60;
function time(o) {
	//console.log(o);
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

<!-- 验证码结束 -->


<!-- 重设密码开始 -->
function reset(url){
	var mobnum=$("#mobnum").val();
	var mobyzm=$("#mobyzm").val();
	var newpwd=$("#newpwd").val();
	if(newpwd.length>15 || newpwd.length<6){
		tip.setBody('请输入正确的密码格式');
		return;
	}else if(mobyzm.length!=4){
		tip.setBody('请输入正确的验证码');
		return;
	}
	var data={"mobnum":mobnum,"mobyzm":mobyzm,"newpwd":newpwd};
	$.ajax({
		url:url,
		type:"post",
		data:data,
		dataType:"json",
		success:function(res){
			tip.setBody(res.msg);
			if(res.result==1){
				location.reload(true);
			}
		}
	},'json');
}

function verification(url){
	//点击获取手机验证码
	var dom = $(".login_leftPageGetcode");
	var mobile = $("#mobnum").val();
	if (mobile == '') {
		tip.setBody('请输入手机号码');
		return false;
	}else if(mobile.length != 11){
		tip.setBody('请输入正确的手机格式');
		return;
	}
	var data={"mobile":mobile};
	$.ajax({
		url: url,
		type: 'post',
		data: data,
		dataType: 'json',
		success: function (msg) {
			if (msg.result == 1) {
				time(dom);
				tip.setBody(msg.msg);
			} else if (msg.result == 0) {
				tip.setBody(msg.msg);
			}
		}
	});
}
<!-- 重设密码结束 -->

