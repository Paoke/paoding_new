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
				<div class="col-xs-12 height-156 text-center">
					<img src="/weixin/Public/home/img/logo.png" alt=""/>
				</div>
				<div class="col-xs-12">
					<div class="width-185 bg-red box-center text-center">
						<a href="<?php echo U('Member/binding');?>" class="font-sixteen white-link">绑定已有账号</a>
					</div>
				</div>
				<div class="col-xs-12 margin-top-27">
					<div class="width-185 bg-red box-center text-center">
						<a href="<?php echo U('Member/register');?>" class="font-sixteen white-link">注册新账号</a>
					</div>
				</div>
			</div>
		</div>
    
	<!--<div class="container">
		<div class="row">	
			<div class="col-md-3 col-xs-4"></div>
			<div class="col-md-6 col-xs-4"><a href="#"  class="thumbnail"><img src="<?php echo ($User_weixin["headimgurl"]); ?>" alt="微信公众号授权登陆"></a></div>
			<div class="col-md-3 col-xs-4"></div>
			<div class="col-md-12 col-xs-12 text-center"><?php echo ($User_weixin["nickname"]); ?></div>

			<div class="col-md-12 col-xs-12">
				<a class="btn btn-default btn-block" href="<?php echo U('Member/register');?>" role="button">我没有账号，现在去注册</a>
				<a class="btn btn-default btn-block" href="<?php echo U('Member/binding');?>" role="button">我已有账号，现在区绑定</a>
			</div>
		</div>
		
		
	</div>-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>