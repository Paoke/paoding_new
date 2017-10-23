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
					<a href="#" class="pull-right height-50"><img src="/weixin/Public/home/img/center.png" alt="" class="icon-25" /></a>
				</div>
				<div class="col-xs-12 col-sm-12 text-center">
					<span class="font-lg3 height-54">订单详情</span>
				</div>
				<div class="col-xs-12 col-sm-12 text-center">
					<div class="box-250 box-center gray">
						<div class="float-left width-140 text-left">
						<p><a href="/weixin/index.php/Home/User/order_detail/apply_id/<?php echo ($vo["apply_id"]); ?>">需求编号:<?php echo ($apply["apply_id"]); ?></a></p>
							<p>2015.09.22</p>
							<span style="white-space:break-word"><?php echo ($apply["message"]); ?></span>
						</div>
						<div class="pull-right">
							<a href="#"><img src="/weixin/Public/home/img/manager.jpg" alt="" class="head-portrait"/></a>
							<a href="#" class=" gray-link margin-top-11 display-block">产品经理</a>
						</div>
						<div class="clearfix"></div>
						<div class="a-group text-right">


							<?php switch($apply["status"]): case "0": ?><a href="/weixin/index.php/Home/Proman/evaluation/apply_id/<?php echo ($apply["apply_id"]); ?>" type="button" class="red-border red-link margin-right-15">预约经理</a><?php break;?>
								<?php case "1": ?><a href="http://www.paoding.cc/weixin/weixinpaytest/example/jsapi.php" type="button" class="red-border red-link margin-right-15">支付</a><?php break;?>
								<?php case "2": ?><a href="/weixin/index.php/Home/Proman/proman_pingjia/apply_id/<?php echo ($apply["apply_id"]); ?>" type="button" class="blue-border blue-link margin-right-15">评论</a><?php break;?>
								<?php case "3": ?>留言<?php break;?>
								<?php case "4": ?>完成<?php break;?>
								<?php case "5": ?><a href="#" type="button" class="yellow-border yellow-link">已完成</a><?php break;?>
								<?php default: ?>预约经理<?php endswitch;?>


							
							
						

							<!--
							预约经理  /weixin/index.php/Home/Proman/proman_pingjia/apply_id/<?php echo ($apply["apply_id"]); ?>

							支付

							评论

							留言






							查收-->
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12  text-center">
					<a href="<?php echo U('User/index');?>" type="button" class="btn btn-return white-link text-center margin-top-39">返回</a>
				</div>	
			</div>
		</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/weixin/Public/home/js/bootstrap.min.js"></script>
	
  </body>
</html>