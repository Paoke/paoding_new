<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
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
<form action="<?php echo U('Member/binding_do');?>" method="post">
				<div class="col-xs-12 col-sm-12">
					
						<div class="form-group  box-input  width-272 box-center"><!--  height-74 -->
							<p class="display-hidden"><i class="glyphicon glyphicon-minus-sign font-sixteen red padding-10"></i><span class="tip">用户名为2~15位字母数字及汉子</span></p>
							<input type="text" class="form-control" name="username" placeholder="用户名" required="required" min="3" max="20" value="<?php echo ($username); ?>">
							<input type="password" class="form-control" name="password" placeholder="密码" required="required" min="3" max="50">
							<p class="display-hidden"><i class="glyphicon glyphicon-minus-sign font-sixteen red padding-10"></i><span class="tip">请输入6位数字、字母、符号组合</span></p>
						</div>
					
				</div>
				<div class="col-xs-12 col-sm-12  text-center"><!-- margin-top-34 -->
					<a href="#" type="button" class="btn btn-red white-link">绑定并登录</a>
				</div>
</form>
			</div>
		</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/weixin/Public/home/js/bootstrap.min.js"></script>
	
  </body>
</html>