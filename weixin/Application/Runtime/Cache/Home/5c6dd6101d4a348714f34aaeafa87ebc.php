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
				<div class="col-xs-12 col-sm-12 margin-top-30 text-center">
					<h4>预约产品经理</h4>
				</div>
				<div class="col-xs-12 col-sm-12 margin-top-48">
					<form action="<?php echo U('Proman/evaluationing_do');?>" method="post">
					<div class="form-group">
						<label for="exampleInputEmail1">访谈方式:</label>
							<select class="form-control" name="proman_fangshi">
									<option>面谈</option>
									<option>电话</option>									
								</select>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">访谈时间:</label>
						<input type="date" class="form-control" name="proman_time" required>
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">联系电话:</label>
						<input type="text" class="form-control" name="proman_phone">
						<p id="p_mobile" class="height-25" style="visibility:hidden"><i class="glyphicon glyphicon-minus-sign font-sixteen red padding-left-10"></i><span class="tip">请输入真实有效的联系方式</span></p>
					</div>
					<input type="hidden" class="form-control" name="apply_id" value="<?php echo ($apply_id); ?>">
					<div class="form-group text-center">
						<button type="submit" class="btn btn-red white-link">提交</button>
					</div>
					</form>
			</div>
		</div>
<script>
var error = 0;
$('#submit').on('click',function(){
	$('#p_mobile').attr('style',"visibility:hidden");
	var mobile = $("input[name='proman_phone']").val();
	var rega = /^1[3|4|5|7|8][0-9]\d{8}$/;
	var regb = /^(0[0-9]{2,3}\-)?([2-9][0-9]{6,7})+(\-[0-9]{1,4})?$/;
	if(rega.exec(mobile)!= null){
		error = 1;
	}else if(regb.exec(mobile)!= null){
		error = 1;
	}else{
		error = 0;
	}
	if(error == 0){
		$('#p_mobile').attr('style',"");	
		return false;	
	}
});
$("input[name='proman_phone']").focus(function(){
	$('#p_mobile').attr('style',"visibility:hidden");
});
</script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/weixin/Public/home/js/bootstrap.min.js"></script>
	
  </body>
</html>