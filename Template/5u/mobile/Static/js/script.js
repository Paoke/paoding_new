
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
		if($(this).val().trim().match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/g)){
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
	//提示字符数
	$('#taskEdit').on('keyup',function(){
		var num=100-$(this).val().length
		$('#tasktishi').css('display','block')
		$('#tasktishi').text('还可输入'+num+'字')
	})
	$("#btn").removeAttr("disabled");
	//提交按钮
	$('#btn').on('click',function(){
		$('#nameEdit').blur();//触发失去焦点事件
		$('#phoneEdit').blur();//触发失去焦点事件
		$('#taskEdit').blur();//触发失去焦点事件
		if(checkname&&checkphone&&checktask){
			$.ajax({
				type:'post',
				url:$('#Modal2').find('form').attr('action'),
				data:{
					'username':$('#nameEdit').val().trim(),
					'mobile':$('#phoneEdit').val().trim(),
					'mess':$('#taskEdit').val().trim()
				},
				beforeSend:function(xhr){
					$("#btn").attr('disabled',"disabled");
				},
				success:function(result){
					 var arr=result.split(",");
					 	if(0==arr[1]){
					 		$('#nameEdit').val('');
							$('#phoneEdit').val('');
							$('#taskEdit').val('');
						window.location.reload();
					   }else{
						  // $("#btn").removeAttr("disabled");
					   }
					   
				},
				error:function(msg){
					console.log(msg)
				}
			})
		}
	})
	
		
})





/*公共函数*/
//trim	删除空格
String.prototype.trim=function(){
	return this.replace(/(^\s*)|(\s*$)/g,"");
}

