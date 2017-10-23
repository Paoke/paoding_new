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

				<form class="form-horizontal" action="<?php echo U('Task/fastTask_do');?>" method="post">
				<div class="col-xs-12 col-sm-12 margin-top-34">	
						<p id="yonghu" class="height-25" style="visibility:hidden"><i class="glyphicon glyphicon-minus-sign font-sixteen red padding-10"></i><span class="tip">用户名为2~15位字母数字及汉子</span></p>
						<div class="form-group border-bottom-none input-position">
						
							<label for="truename" class="lable-absolute">真实姓名</label>
							<input type="text" class="form-control border-bottom-none" placeholder="真实姓名" name="name" >
						</div>
						<div class="form-group input-position">
							<label for="truename" class="lable-absolute">手机号码</label>
							<input type="tel" class="form-control" placeholder="手机号码" name="phone">
						</div>
						<p id="shouji" class="height-25" style="visibility:hidden"><i class="glyphicon glyphicon-minus-sign font-sixteen red padding-10"></i><span class="tip">请输入11位手机号码</span></p>
						<div class="form-group margin-top-15">
							<div class="col-xs-6">
								<select class="form-control" name="city">									
									<option>广州</option>									
								</select>
							</div>
							<div class="col-xs-6">
								<select class="form-control" name="province">
									<option>越秀区</option>
									<option>海珠区</option>
									<option>白云区</option>
									<option>天河区</option>
									<option>黄埔区</option>
									<option>增城区</option>
									<option>从化区</option>
								</select>
							</div>
						</div>
						<div class="form-group">
						&nbsp;
						</div>
						<div class="form-group">							
							<textarea class="form-control" rows="3" placeholder="一句话描述" name="message"></textarea>
						</div>
						<p  id="zifu" class="height-25" style="visibility:hidden"><i class="glyphicon glyphicon-minus-sign font-sixteen red padding-10"></i><span class="tip">超过200个字符</span></p>
				</div>
				<div class="col-xs-12 col-sm-12 margin-top-41 text-center">
					<button type="submit" id="submit" class="btn btn-red white-link">提交</button>
				</div>
			</form>
			</div>
		</div>

<script>
var error = 0;
var jishu = 1;
$('#submit').on('click',function(){
	$('#yonghu').attr('style',"visibility:hidden");
	$('#shouji').attr('style',"visibility:hidden");
	$('#zifu').attr('style',"visibility:hidden");
	var name = $("input[name='name']").val();
	var reg = /^[\u4e00-\u9fa5]{2,15}$/;
	var result = reg.exec(name);
	if(result != null){	
		error=1;
	}else{
		$('#yonghu').attr('style',"");	
		error=0;
	}
	var phone = $("input[name='phone']").val();
	var reg1 = /^1[3|4|5|7|8][0-9]\d{8}$/;
	var result1 = reg1.exec(phone);	
	if(result1!= null){
		error=1;	
	}else{
		$('#shouji').attr('style',"");
		error=0;	
	}
	var message = $("textarea[name='message']").val();
	if(message != ""){
		var sss = getByteLen(message);	//计数
		if(sss > 200){
			$('#zifu').attr('style',"");
			jishu = 0;
		}else{
			jishu = 1;
		}
	}
	
	if(error== 0 || jishu== 0){
		return false;
	}
});
$("input[name='name']").on('focus',function(){
	$('#yonghu').attr('style',"visibility:hidden");
});
$("input[name='phone']").on('focus',function(){
	$('#shouji').attr('style',"visibility:hidden");
});
$("textarea[name='message']").on('focus',function(){
	$('#zifu').attr('style',"visibility:hidden");
});
//计算长度
	function getByteLen(val) {
		var len = 0;
		for (var i = 0; i < val.length; i++) {
			 var a = val.charAt(i);
			 if (a.match(/[^\x00-\xff]/ig) != null) 
			{
				len += 2;
			}
			else
			{
				len += 1;
			}
		}
		return len;
	}
</script>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/weixin/Public/home/js/bootstrap.min.js"></script>
	
  </body>
</html>