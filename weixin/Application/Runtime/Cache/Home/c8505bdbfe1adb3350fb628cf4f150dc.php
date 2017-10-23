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
				
				<div class="col-xs-12 col-sm-12 padding-0">
					<div class="height-39 white-bg box-center">
						<ul class="nav nav-tabs tabs-list">
							<li><a href="<?php echo U('User/unfished');?>" >未完成订单</a></li>
							<li class="active"><a href="<?php echo U('User/fished');?>" >已完成订单</a></li>
							<li><a href="<?php echo U('User/editor');?>" >编辑个人资料</a></li>
						</ul>
					</div>

						<?php if(is_array($fished)): $i = 0; $__LIST__ = $fished;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="col-xs-12 col-sm-12 margin-top-20">
								<div class="box-289 box-center gray">
									<div class="float-left ">
									<p><a href="/weixin/index.php/Home/User/order_detail/apply_id/<?php echo ($vo["apply_id"]); ?>">需求编号:<?php echo ($vo["apply_id"]); ?></a></p>
										<p>2015.09.22</p>
										<span style="white-space:break-word"><?php echo ($vo["message"]); ?></span>
									</div>
									<div class="pull-right">
										<a href="#"><img src="/weixin/Public/home/img/manager.jpg" alt="" class="head-portrait"/></a>
										<a href="#" class=" gray-link margin-top-11 display-block">产品经理</a>
									</div>
								</div>
							</div><?php endforeach; endif; else: echo "" ;endif; ?>
					</div>
						
						<!--
							<div class="col-xs-12 col-sm-12 margin-top-20">
								<div class="box-289 box-center gray">
									<div class="float-left">
										<p>2015.09.22</p>
										<span style="white-space:break-word">一句话描述</span>
									</div>
									<div class="pull-right">
										<a href="#"><img src="/weixin/Public/home/img/manager.jpg" alt="" class="head-portrait"/></a>
										<a href="#" class=" gray-link margin-top-11 display-block">产品经理</a>
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 margin-top-20">
								<div class="box-289 box-center gray">
									<div class="float-left">
										<p>2015.09.22</p>
										<span style="white-space:break-word">一句话描述</span>
									</div>
									<div class="pull-right">
										<a href="#"><img src="/weixin/Public/home/img/manager.jpg" alt="" class="head-portrait"/></a>
										<a href="#" class=" gray-link margin-top-11 display-block">产品经理</a>
									</div>
								</div>
							</div>
						
						
					-->
				
				
				<div class="col-xs-12 col-sm-12  text-center">
								<a href="<?php echo U('User/index');?>" type="button" class="btn btn-return white-link text-center margin-top-42 margin-bottom-30">返回</a>
				</div>	
			</div>
		</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/weixin/Public/home/js/bootstrap.min.js"></script>
	
  </body>
</html>