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
				<div class="col-xs-12 col-sm-12 text-center margin-top-17 gray">
					<p>用户名:<?php echo ($space["username"]); ?></p>
					<p>手机号码：<?php echo ($space["mobile"]); ?></p>
				</div>
				<div class="col-xs-12 col-sm-12 text-center margin-top-17">
					<div class=" box-center box-299 gray">
						<div class="box-128 margin-right-11 float-left">
							<div class="box-128 table-ver text-center">
								<a href="<?php echo U('User/unfished');?>"><img src="/weixin/Public/home/img/unfished.png" alt="" class="icon-602" /></a>
								<a href="<?php echo U('User/unfished');?>" class="gray-link display-block margin-top-24">未完成订单</a>
							</div>
						</div>
						<div class="box-160 float-left">
							<div class="box-160 table-ver text-center">
								<a href="<?php echo U('User/fished');?>"><img src="/weixin/Public/home/img/finshed_order.png" alt="" class="icon-40" /></a>
								<a href="<?php echo U('User/fished');?>" class="gray-link display-block margin-top-11">已完成订单</a>
							</div>
						</div>
						<div class="box-101 float-left margin-top-13">
							<div class="box-101 table-ver text-center">
								<a href="<?php echo U('User/editor');?>"><img src="/weixin/Public/home/img/editor.png" alt="" class="icon-40" /></a>
								<a href="<?php echo U('User/editor');?>" class="gray-link display-block margin-top-11">编辑个人资料</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12  text-center">
					<a href="<?php echo U('Index/index');?>" type="button" class="btn btn-return white-link text-center margin-top-24">返回</a>
				</div>
			</div>
		</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/weixin/Public/home/js/bootstrap.min.js"></script>
	
  </body>
</html>