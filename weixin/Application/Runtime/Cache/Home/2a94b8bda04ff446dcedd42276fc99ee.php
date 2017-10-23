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
				<div class="col-xs-12 col-sm-12 height-141 text-center">
					<img src="/weixin/Public/home/img/logo.png" alt=""/>
				</div>
				<div class="col-xs-12 col-sm-12">
					<div class="width-230 bg-red box-center">
						<div  class="text-center width-230 table-ver">
							<a href="<?php echo U('Task/index');?>"><img  src="/weixin/Public/home/img/fast_commit.png" alt="" class="icon-35  margin-bottom-7 box-center"/></a>
							<a href="<?php echo U('Task/index');?>"  class="font-sixteen white-link display-block">快速提交</a>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 margin-top-19">
					<div class="width-230 bg-red box-center">
						<div  class="text-center width-230 table-ver">
							<a href="<?php echo U('User/index');?>"><img  src="/weixin/Public/home/img/center.png" alt="" class="icon-35  margin-bottom-7 box-center"/></a>
							<a href="<?php echo U('User/index');?>"  class="font-sixteen white-link display-block">个人中心</a>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 margin-top-19 ">
					<div class="width-230 bg-red box-center">
						<div  class="text-center width-230 table-ver">
							<a href="<?php echo U('Proman/index');?>"><img  src="/weixin/Public/home/img/team_products.png" alt="" class="icon-35  margin-bottom-7 box-center"/></a>
							<a href="<?php echo U('Proman/index');?>"  class="font-sixteen white-link display-block">产品经理</a>
						</div>
					</div>
				</div>
			</div>
		</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/weixin/Public/home/js/bootstrap.min.js"></script>
	
  </body>
</html>