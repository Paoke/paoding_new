
$(function(){
	
	checkname=false;
	checkphone=false;
	checktask=false;
	
	//检查名字是否合法2-15位数字字母或汉字
	$('#nameEdit').on('blur',function(){
		if($(this).val().trim().match(/^[A-Za-z0-9\u4E00-\u9FFF]{2,15}$/g)){
			$('#nameDIV').attr('class','modal-input has-success has-feedback');
			$('#nameStatus').attr('class','glyphicon glyphicon-ok form-control-feedback');
			$('#nameStatus').css('display','inline');
			checkname=true;
		}else{
			$('#nameDIV').attr('class','modal-input has-error has-feedback');
			$('#nameStatus').attr('class','glyphicon glyphicon-remove form-control-feedback');
			$('#nameStatus').css('display','inline');
			checkname=false;
		}
	})	
	//电话输入框
	$('#phoneEdit').on('blur',function(){
		//console.log($(this).val().match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/g))
		if($(this).val().trim().match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[0-9]|18[0-9]|14[0-9])[0-9]{8}$/g)){
			$('#phoneDIV').attr('class','modal-input has-success has-feedback')
			$('#phoneStatus').attr('class','glyphicon glyphicon-ok form-control-feedback');
			$('#phoneStatus').css('display','inline');
			checkphone=true;
		}else{
			$('#phoneDIV').attr('class','modal-input has-error has-feedback');
			$('#phoneStatus').attr('class','glyphicon glyphicon-remove form-control-feedback');
			$('#phoneStatus').css('display','inline');
			checkphone=false;
		}
	})
	//需求输入框
	$('#taskEdit').on('blur',function(){
		if($(this).val().length>0&&$(this).val().length<=100){
			$('#taskDIV').attr('class','modal-input has-success has-feedback')
			$('#taskStatus').attr('class','glyphicon glyphicon-ok form-control-feedback');
			$('#taskStatus').css('display','inline');
			checktask=true;
		}else{
			$('#taskDIV').attr('class','modal-input has-error has-feedback');
			$('#taskStatus').attr('class','glyphicon glyphicon-remove form-control-feedback');
			$('#taskStatus').css('display','block');
			checktask=false;
		}
	})

///////需求表单ajax异步提交

		$(".btn-needs").on("click",function(){
			var flag=$(this).attr("flag");
			$(".btn-modal").attr("flag",flag);	
			$(".btn-modal").removeAttr("disabled");	
		});
		$(".btn-modal").on("click",function(){
			var flag=$(this).attr("flag");
			var name=$("#nameEdit").val().trim();
			var phone=$("#phoneEdit").val().trim();
			var message=$("#taskEdit").val().trim();
			var url=$("#url").attr("action");
			$('#nameEdit').blur();
			$('#phoneEdit').blur();
			$('#taskEdit').blur();
			if(checkname&&checkphone&&checktask){
			$.ajax({
				url:url,
				type:"post",
				data:{
					"flag":flag,
					"username":name,
					"mobile":phone,
					"message":message,
				},
				dataType:"json",
				beforeSend:function(xhr){
					$(".btn-modal").attr("disabled","disabled")
				},
				success:function(msg){
					console.log(msg);
					if(msg==0){
						window.location.reload();
					}else{
						$(".btn-modal").removeAttr("disabled");	
					}

					
				},
			});
			}
		});


	//提示字符数
	$('#taskEdit').on('keyup',function(){
		var num=100-$(this).val().length
		$('#tasktishi').css('display','block')
		$('#tasktishi').text('还可输入'+num+'字')
	})
	
	
	// 头部用户已登录下拉
	$('#top-center').mouseover(function(){
		$(this).css({height:'180px','transition':'all 0.5s ease'});
	})
	$('#top-center').mouseout(function(){
		$(this).css('height','80px');
	})
	
	
	$('input,textarea').focus(function(){
		$(this).attr('placeholder','');
		$(this).parent('div').removeClass('has-error');
	})
	
	
	
	
})


//验证码倒计时
	var wait=60;
	function time(o) { 
		//console.log(wait)
		if (wait == 0) { 
			o.removeAttribute("disabled"); 
			o.value="重新发送"; 
			wait = 60; 
		} else { 
			o.setAttribute("disabled", true); 
			o.value="已发送(" + wait +"s"+ ")"; 
			wait--; 
			setTimeout(function() { 
				time(o) 
			}, 1000) 
		} 
	}

	//验证手机格式
	function checkPhone2(i){
		if(i.val().trim().match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[0-9]|18[0-9]|14[0-9])[0-9]{8}$/g)!=null){
			return true
		}else{
			return false
		}
	}

	//验证密码个数
	function checkPwd(i){
		if(i.val().trim().match(/^[0-9|a-z|A-Z]{6,20}$/g)!=null){
			return true
		}else{
			return false
		}
	}
	
	//验证重复密码
	function checkRpwd(i,k){
		if(i.val().trim()==k.trim()){
			return true
		}else{
			return false
		}
	}
	
/*公共函数*/
//trim	删除空格
String.prototype.trim=function(){
	return this.replace(/(^\s*)|(\s*$)/g,"");
}



