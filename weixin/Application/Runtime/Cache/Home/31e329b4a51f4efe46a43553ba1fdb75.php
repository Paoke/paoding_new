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
				<div class="col-xs-12 col-sm-12  text-center margin-top-17">
					<img src="/weixin/Public/home/img/person.jpg"  alt="" class="head-portrait2 img-circle" />
				</div>
				<div class="col-xs-12 col-sm-12">
					<form action="<?php echo U('Member/binding_do');?>" method="post">
						<div class="form-group  box-input  width-272 box-center"><!--  height-74 -->
							<p id="p_username" class="height-25" style="visibility:hidden"><i class="glyphicon glyphicon-minus-sign font-sixteen red padding-10"></i><span class="tip">用户名为2~15位汉字</span></p>
							<input type="text" class="form-control  border-radius-top"   name="username" placeholder="用户名" required="required" min="3" max="20" value="<?php echo ($username); ?>">
							<input type="password" class="form-control border-radius-bottom"  style="margin-top:1px;" name="password" placeholder="密码" required="required" min="3" max="50">
							<p id="p_password" class="height-25" style="visibility:hidden"><i class="glyphicon glyphicon-minus-sign font-sixteen red padding-10"></i><span class="tip">请输入6位以上数字、字母、符号组合</span></p>
						</div>
						<div class="col-xs-12 col-sm-12  text-center">
							<button  type="button"  id="submit" class="btn btn-red white-link">绑定并登录</button>
						</div>
					</form>
				</div>
				<!-- margin-top-34 -->
			</div>
		</div>






    
	
<script>
var error = 0;
$('#submit').on('click',function(){
	
	$('#p_username').attr('style',"visibility:hidden").html('<i class="glyphicon glyphicon-minus-sign font-sixteen red padding-10"></i><span class="tip">用户名为2~15位汉字</span>');
	$('#p_password').attr('style',"visibility:hidden");
	var username = $("input[name='username']").val();
	var reg = /^[0-9a-zA-Z\u4e00-\u9fa5]{2,15}$/;
	var result = reg.exec(username);
	if(result == null){		
		$('#p_username').attr('style',"");	
		error = 0;
	}else{
		error = 1;
	}
	var password = $("input[name='password']").val();
	var reg1 = /^(?=.*[0-9a-zA-Z].*[0-9a-zA-Z]+).{6,16}$/;
	var result1 = reg1.exec(password);
	if(result1 == null){
		$('#p_password').attr('style',"");	
		error = 0;
	}else{
		error = 1;
	}
	if(error ==1){
		$.post("<?php echo U('Member/checkweixin');?>",{'username':username,'password':password},function(data){
			if(data.status ==0){
				$('#p_username').attr('style',"").html('<i class="glyphicon glyphicon-minus-sign font-sixteen red padding-10"></i><span class="tip">没有此用户</span>');
			}
			if(data.status==1){
				$('#p_password').attr('style',"").html('<i class="glyphicon glyphicon-minus-sign font-sixteen red padding-10"></i><span class="tip">密码输入有误</span>');
			}
			if(data.status==2){
				var url = "/weixin/index.php/Home/Member/binding_isSuccess/uid/"+data.uid+"/username/"+data.username+".html" ;
				window.location.href = url;
			}
		},'json');
	}
});
</script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/weixin/Public/home/js/bootstrap.min.js"></script>
	
  </body>
</html>