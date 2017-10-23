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
					<span class="height-66"><b>修改密码</b></span>
				</div>
<form class="box-center box-272"action="<?php echo U('User/modify_password_do');?>" method="post">
				<div class="col-xs-12 col-sm-12">
					
						<div class="form-group input-position border-bottom-none">
							<label class="lable-absolute2">当前密码</label>
							<input type="password" class="form-control" id="password" value = "">
						</div>
						<div class="form-group input-position border-bottom-none">
							<label class="lable-absolute2">新密码</label>
							<input type="password" class="form-control" id="newpassword" placeholder="" required="required">
						</div>
						<div class="form-group input-position">
							<label class="lable-absolute2">确认密码</label>
							<input type="password" class="form-control" id="repassword" placeholder="" required="required">
						</div>
						<p id="p_password" class="height-25 padding-left-10" style="visibility:hidden"><i class="glyphicon glyphicon-minus-sign font-sixteen red "></i><span class="tip">请输入6位以上数字、字母、符号组合的新密码</span></p>
				</div>
				<p id="tishi" style="color:red;display:none" class="text-center">密码修改成功！</p>
				<div class="col-xs-12 col-sm-12 margin-top-30 text-center">
					<button id ="submit" type="button" class="btn btn-red white-link" >提交</button>
					<!--<p class="margin-top-20 red">新手机绑定成功！</p>-->
					<p>&nbsp;</p>
					<a href="<?php echo U('User/editor');?>" class="btn btn-red white-link" >返回</a>
				</div>
</form>
			</div>
		</div>
<script>
var error = 0;		//总错误
var old = 0;		//旧密码
var neww = 0;      //新密码
$('#submit').on('click',function(){
	var password = $('#password').val();
	if(password == ""){
		$('#p_password').attr('style',"").html('<i class="glyphicon glyphicon-minus-sign font-sixteen red"></i><span class="tip">请输入当前密码</span>');	
		error = 0;
		old = 0;
	}else{
		error = 1;
		old = 1;
	}
	var newpassword = $('#newpassword').val();
	var reg1 = /^(?=.*[0-9a-zA-Z].*[0-9a-zA-Z]+).{6,16}$/;
	var result1 = reg1.exec(newpassword);
	if(result1 == null){
		if(old == 1){
			$('#p_password').attr('style',"").html('<i class="glyphicon glyphicon-minus-sign font-sixteen red "></i><span class="tip">请输入6位以上数字、字母、符号组合的新密码</span>');
		}
		error= 0;
		neww = 0;
	}else{
		error = 1;
		neww = 1;
	}
	if(neww == 1){
	
		var repassword = $("#repassword").val();
		if(repassword != newpassword){
			if(neww == 1){
				$('#p_password').attr('style',"").html('<i class="glyphicon glyphicon-minus-sign font-sixteen red"></i><span class="tip">密码不一致</span>');	
			}
			error = 0;
		}else{
			error = 1;
		}
	}
	if(error == 1){
		$.post("<?php echo U('User/yanzheng');?>",{'password':password,'newpassword':newpassword,'repassword':repassword},function(data){
			if(data.status == 0){
				$('#p_password').attr('style',"").html('<i class="glyphicon glyphicon-minus-sign font-sixteen red"></i><span class="tip">当前密码错误</span>');
				error = 0;
			}else if(data.status ==1){
				$('#p_password').attr('style',"").html('<i class="glyphicon glyphicon-minus-sign font-sixteen red"></i><span class="tip">密码不一致</span>');
				error =0;
			}else {
				error = 1;
			}
			if(error ==0){
				return false;
			}else{
				$("#tishi").fadeIn("slow");	//显示P的内容
			setTimeout(function(){    //设置指定时间后的动作
				  $("#tishi").fadeOut("slow");    //隐藏
				  window.location.href = "<?php echo U('User/editor');?>";
			},2000);
				
			}
		},'json');
	}
	
});
$('#password').focus(function(){
	$('#p_password').attr('style',"visibility:hidden").html('<i class="glyphicon glyphicon-minus-sign font-sixteen red"></i><span class="tip">请输入当前密码</span>');
});
$('#newpassword').focus(function(){
	$('#p_password').attr('style',"visibility:hidden").html('<i class="glyphicon glyphicon-minus-sign font-sixteen red"></i><span class="tip">请输入当前密码</span>');
});
$('#repassword').focus(function(){
	$('#p_password').attr('style',"visibility:hidden").html('<i class="glyphicon glyphicon-minus-sign font-sixteen red"></i><span class="tip">请输入当前密码</span>');
});
</script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/weixin/Public/home/js/bootstrap.min.js"></script>
	
  </body>
</html>