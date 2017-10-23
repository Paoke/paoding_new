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
				<div class="col-xs-12 col-sm-12 margin-top-33">
					<p class="text-center font-lg2"><b>产品经理</b></p>
				</div>


<?php if(is_array($proman)): $i = 0; $__LIST__ = $proman;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="col-xs-12 col-sm-12 margin-top-32">

					
					<div class="box-content2 box-center">

						<div class="float-left text-center">
							<a href="/weixin/index.php/Home/Proman/proman/id/<?php echo ($vo["id"]); ?>"><img src="/weixin/Public/home/img/person.jpg"  alt="" class="icon-head" /></a>
							<p><?php echo ($vo["truename"]); ?></p>
						</div>
						<!--<p class="info">任务编号:  <?php echo ($apply["apply_id"]); ?></p>
						<p class="info">任务时间:  <?php echo (date("20y-m-d",$apply["reg_time"])); ?></p>-->
						<p class="info">产品经理工号:  <?php echo ($vo["id"]); ?></p>
						<p class="info2"><?php echo ($vo["info"]); ?></p>

					</div>
					

				</div><?php endforeach; endif; else: echo "" ;endif; ?>
	
<div class="col-xs-12 col-sm-12 margin-top-57 text-center">
					<a href="<?php echo U('Index/index');?>" type="button" class="btn btn-blue  white-link text-center">返回</a>
				</div>
				

			</div>
		</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/weixin/Public/home/js/bootstrap.min.js"></script>
	
  </body>
</html>