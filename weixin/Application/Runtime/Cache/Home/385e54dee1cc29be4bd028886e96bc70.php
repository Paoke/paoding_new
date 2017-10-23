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
				<div class="col-xs-12 col-sm-12 ">
					<div class="box-center box-content margin-top-36">
						广东庖丁技术开发股份有限公司成立于2014年8月，提供技术研发、技术服务、技术转让、技术咨询
							和技术劳务等专业服务，致力于打通技术与产业、学术、科研机构、政府、媒体之间的通路。目前，
							高校的研发方向与企业的需求往往存在着信息不对称的状况，基于这种现状，庖丁技术众包平台应运而生。
						
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 margin-top-13">
					<div class="checkbox text-center">
						<label>
						  <input type="checkbox" class="padding-right-7" checked> 我已阅读并同意以下协议
						</label>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 margin-top-13 text-center">
					<a href="/weixin/index.php/Home/Protocol/proman/apply_id/<?php echo ($apply_id); ?>" type="button" class="btn btn-blue  white-link text-center">产品经理服务协议</a>
				</div>
				<div class="col-xs-12 col-sm-12 margin-top-37 text-center">
					<a href="/weixin/index.php/Home/Proman/evaluationing/apply_id/<?php echo ($apply_id); ?>" id="Next"  type="button" class="btn btn-next white-link text-center">预约</a>
				</div>
			</div>
		</div>
	<script>

	$(":checkbox").on('change',function(){
		if($(this).prop('checked')==true){
			$('#Next').removeClass('disabled');
		}else{
			$('#Next').addClass('disabled');
		}
	});
	
</script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/weixin/Public/home/js/bootstrap.min.js"></script>
	
  </body>
</html>