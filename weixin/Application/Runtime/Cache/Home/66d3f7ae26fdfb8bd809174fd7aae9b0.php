<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>庖丁技术微信版</title>

    <!-- Bootstrap -->
    <link href="/weixin/Public/home/css/bootstrap.min.css" rel="stylesheet">
	<link href="/weixin/Public/home/css/style.css" rel="stylesheet">
	<script src="/weixin/Public/home/js/jquery-2.0.3.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 height-50 text-center bg-red">
					<img src="/weixin/Public/home/img/logo2.png" alt="" class="width-112"/>
					<a href="<?php echo U('Index/index');?>" class="pull-right height-50"><img src="/weixin/Public/home/img/center.png" alt="" class="icon-25" /></a>
				</div>
				<div class="col-xs-12 col-sm-12 text-center">
					<span class="height-66"><b>修改手机号码</b></span>
				</div>
<form class="box-center box-272" action="<?php echo U('User/modify_phone_do');?>" method="post">
				<div class="col-xs-12 col-sm-12">					
						<div class="form-group input-position border-bottom-none">
							<label class="lable-absolute2">原手机号码</label>
							<input type="text" class="form-control" value="<?php echo ($mobile); ?>" >
						</div>
						<div class="form-group input-position border-bottom-none">
							<label class="lable-absolute2">新手机号码</label>
							<input id="inputphone" type="text" class="form-control" name="newmobile" value="" >
						</div>
						<div class="form-group input-position">
							<label class="lable-absolute2">验证码</label>
							<input type="text" class="form-control" name="newcode" >							
							
						</div>
						<button id="phoneverify" onclick="sendMessage()" type="button" class="pull-right btn-red2 white-link" >获取验证码</button>	
						<p id="p_mobile" class="height-25" style="visibility:hidden"><i class="glyphicon glyphicon-minus-sign font-sixteen red padding-left-10"></i><span class="tip">请输入11位手机号码</span></p>
					
				</div>
				<div class="col-xs-12 col-sm-12 margin-top-30 text-center">
					<button id="submit" type="button" class="btn btn-red white-link" >提交</button>
					<!--<p class="margin-top-20 red">新手机绑定成功！</p>-->
					<p>&nbsp;</p>
					<a href="<?php echo U('User/index');?>" class="btn btn-red white-link" >返回</a>
				</div>
</form>
			</div>
		</div>
<script>
var pstatus = 0;
var error =0;
$('#inputphone').on('blur',function(){
	var mobile = $(this).val();
	var reg = /^1[3|4|5|7|8][0-9]\d{8}$/;
	var result = reg.exec(mobile);
	if(result == null){
		pstatus = 0;
	}else{
		pstatus = 1;
	}	
});
$('#inputphone').focus(function(){
	$('#p_mobile').attr('style',"visibility:hidden").html('<i class="glyphicon glyphicon-minus-sign font-sixteen red padding-left-10"></i><span class="tip">请输入11位手机号码</span>');
});
//短信验证倒计时
var InterValObj; //timer变量，控制时间
var count = 60; //间隔函数，1秒执行
var curCount;//当前剩余秒数
function sendMessage() {
	$('#inputphone').blur();
	var phone = $('#inputphone').val();
	$('#p_mobile').attr('style',"visibility:hidden").html('<i class="glyphicon glyphicon-minus-sign font-sixteen red padding-left-10"></i><span class="tip">请输入11位手机号码</span>');
	if(pstatus==0){
		$('#p_mobile').attr('style',"");	
		return false;
	}
	 curCount = count;　
	 $("#phoneverify").attr("disabled", "true").addClass('disabled');
	 $("#phoneverify").html("(" + curCount + ")秒后可重发");
	 InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器（可以使函数），1秒执行一次  
　　  //向后台发送处理数据
     $.ajax({
     　　type: "POST", //用POST方式传输
     　　//dataType: "json", //数据格式:JSON 
     　　url: "<?php echo U('User/sendsms');?>", //目标地址
    　　 data: {'phone':phone},
    　　 error: function (XMLHttpRequest, textStatus, errorThrown) {alert("发送失败")},
     　　success: function (msg){ 
			//alert('发送成功');		//成功返回
		}
     });
}
//timer处理函数
function SetRemainTime() {
		if (curCount == 0) {                
			window.clearInterval(InterValObj);//停止计时器
			$("#phoneverify").removeAttr("disabled");//启用按钮
			$("#phoneverify").html("重新发送验证码");
		}
		else {
			curCount--;
			$("#phoneverify").html("(" + curCount + ")秒后重新发送");
		}
}
$('#submit').on('click',function(){
	if(pstatus==0){
		$('#p_mobile').attr('style',"");	
		return false;
	}
	var mobile = $('#inputphone').val();
	var code = $("input[name='newcode']").val();
	$.post("<?php echo U('User/sendsmsverify');?>",{'code':code,'phone':mobile},function(data){
		if(data.status==0){
			$('#p_mobile').attr('style',"").html('<i class="glyphicon glyphicon-minus-sign font-sixteen red padding-left-10"></i><span class="tip">验证码错误</span>');
			error = 0 ;
		}else{
			error = 1;
		}
		if(error ==0){
			return false;
		}else{
			$.post("<?php echo U('User/modify_phone_do');?>",{'code':code,'newmobile':mobile},function(data){
				window.location.href = "<?php echo U('Index/index',array('cate_id' => 2));?>";
			},'json');		
		}
	},'json');
	return false;
});

</script>
		
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/weixin/Public/home/js/bootstrap.min.js"></script>
	
  </body>
</html>