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
				<div class="col-xs-12 col-sm-12 margin-top-19">
					<div class="box-info box-center">
						<div class="float-left text-center">
							<img src="/weixin/Public/home/img/person.jpg" alt="" class="icon-head3" />
							<p><?php echo ($proman["truename"]); ?></p>
						</div>
						<div class="float-left">
							<p class="padding-top-15">工号: <?php echo ($proman["id"]); ?></p>
							<p class="padding-top-10">资历: <?php echo ($proman["info"]); ?></p>
						</div>
						<div class="clearfix"></div>
						<p class="margin-top-30 padding-left-12">历史评价</p>
<?php if(is_array($pingjia)): $i = 0; $__LIST__ = $pingjia;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="border margin-top-15 margin-left-12 margin-right-12">
							<span class="conetent">日期</span><?php echo (date("y年m月d日",$vo["reg_time"])); ?><span class="pull-right padding-right-11 line-height-30">
								<?php if(($vo["proman_pingjia"]) == "1"): ?>满意<?php else: ?>不满意<?php endif; ?>
							</span>
						</div><?php endforeach; endif; else: echo "" ;endif; ?>
						<!--<div class="border margin-top-15 margin-left-12 margin-right-12">
							<span class="conetent">日期</span>2015.09.21<span class="pull-right padding-right-11 line-height-30">满意</span>
						</div>
						<div class="border margin-top-15 margin-left-12 margin-right-12">
							<span class="conetent">日期</span>2015.09.21<span class="pull-right padding-right-11 line-height-30">满意</span>
						</div>-->
					</div>
				</div>
				
				<div class="col-xs-12 col-sm-12  text-center">
					<a href="#" type="button" class="btn btn-return white-link text-center margin-top-28">返回</a>
				</div>
			</div>
		</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/weixin/Public/home/js/bootstrap.min.js"></script>
	
  </body>
</html>