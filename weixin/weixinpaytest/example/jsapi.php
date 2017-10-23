<?php 

ini_set('date.timezone','Asia/Shanghai');

//error_reporting(E_ERROR);

session_start(); 

 $apply =$_SESSION["apply_id"];

 $name = $_SESSION['weixin_name'];

 $phone =$_SESSION['weixin_phone'];

 $message =$_SESSION['weixin_message'];

 $fangshi = $_SESSION['weixin_proman_fangshi'];

 $time = $_SESSION['weixin_proman_time'];

require_once "../lib/WxPay.Api.php";

require_once "WxPay.JsApiPay.php";

require_once 'log.php';



//初始化日志

$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');

$log = Log::Init($logHandler, 15);



//打印输出数组信息

function printf_info($data)

{

    foreach($data as $key=>$value){

        echo "<font color='#00ff55;'>$key</font> : $value <br/>";

    }

}



//①、获取用户openid

$tools = new JsApiPay();

$openId = $tools->GetOpenid();



//②、统一下单

$input = new WxPayUnifiedOrder();

$input->SetBody("庖丁技术服务费");

$input->SetAttach("test");

$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));

$input->SetTotal_fee("1");

$input->SetTime_start(date("YmdHis"));

$input->SetTime_expire(date("YmdHis", time() + 600));

$input->SetGoods_tag("test");

$input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");

$input->SetTrade_type("JSAPI");

$input->SetOpenid($openId);

$order = WxPayApi::unifiedOrder($input);

//echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';

//printf_info($order);

$jsApiParameters = $tools->GetJsApiParameters($order);



//获取共享收货地址js函数参数

$editAddress = $tools->GetEditAddressParameters();



//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php

/**

 * 注意：

 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功

 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，

 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）

 */



?>



<html>

<head>

    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>

    <meta name="viewport" content="width=device-width, initial-scale=1"/> 

    <title>微信支付样例-支付</title>

    <script type="text/javascript">

	//调用微信JS api 支付

	function jsApiCall()

	{

		WeixinJSBridge.invoke(

			'getBrandWCPayRequest',

			<?php echo $jsApiParameters; ?>,

			function(res){

				WeixinJSBridge.log(res.err_msg);

				alert(res.err_code+res.err_desc+res.err_msg);

				 if(res.err_msg == "get_brand_wcpay_request:ok"){

                   //alert(res.err_code+res.err_desc+res.err_msg);

                       window.location.href="http://www.paoding.cc/weixin/index.php/Home/WeixinPay/WeixinPay";

                   }else{

                       //返回跳转到订单详情页面

                       alert(支付失败);

                       window.location.href="http://www.paoding.cc/weixin/index.php/Home/Proman/order.html";

                         

                   }

			}

		);

	}



	function callpay()

	{

		if (typeof WeixinJSBridge == "undefined"){

		    if( document.addEventListener ){

		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);

		    }else if (document.attachEvent){

		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 

		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);

		    }

		}else{

		    jsApiCall();

		}

	}

	</script>

	<script type="text/javascript">

	//获取共享地址

	function editAddress()

	{

		WeixinJSBridge.invoke(

			'editAddress',

			<?php echo $editAddress; ?>,

			function(res){

				var value1 = res.proviceFirstStageName;

				var value2 = res.addressCitySecondStageName;

				var value3 = res.addressCountiesThirdStageName;

				var value4 = res.addressDetailInfo;

				var tel = res.telNumber;

				

				alert(value1 + value2 + value3 + value4 + ":" + tel);

			}

		);

	}

	

	window.onload = function(){

		if (typeof WeixinJSBridge == "undefined"){

		    if( document.addEventListener ){

		        document.addEventListener('WeixinJSBridgeReady', editAddress, false);

		    }else if (document.attachEvent){

		        document.attachEvent('WeixinJSBridgeReady', editAddress); 

		        document.attachEvent('onWeixinJSBridgeReady', editAddress);

		    }

		}else{

			editAddress();

		}

	};

	</script>

	<style>

		body {

			background: #e9e9e9;

			font-family: "微软雅黑","Microsoft YaHei";

			margin: 0px auto;

		}

		.container,col-xs-12,col-sm-12 {

			width: 100%;

		}

		.bg-red {

			background: #ee545f;

		}

		.height-50 {

			height: 50px;

			line-height: 50px;

		}

		.text-left {

			text-align: left;

		}

		.text-center {

			text-align: center;

		}

		.text-right {

			text-align: right;

		}

		.pull-right {

			float: right;

		}

		.width-112 {

			width: 112px;

			height: 25px;

		}

		.margin-top-48 {

			margin-top: 48px;

		}

		.margin-top-30 {

			margin-top: 30px;

		}

		.col-xs-5 {

		  width: 41.66666667%;

		  float: left;

		}

		.col-xs-7 {

		  width: 58.33333333%;

		  float: left;

		}

	</style>

	

</head>

<body>



		<div class="container">

			<div class="row">

				<div class="col-xs-12 col-sm-12 height-50 text-center bg-red">

					<img src="http://www.paoding.cc/weixin/Public/home/img/logo2.png" alt="" class="width-112"/>

					<a href="http://www.paoding.cc/weixin" class="pull-right height-50"><img src="http://www.paoding.cc/weixin/Public/home/img/center.png" alt="" class="icon-25" /></a>

				</div>

				<div class="col-xs-12 col-sm-12 margin-top-48 text-center">

					<h4>预约产品经理订单</h4>

				</div>

			</div>





			<div class="row margin-top-30">

					<div class="col-xs-5 col-sm-5 text-right">

						<p>您的姓名:</p>

						<p>您的手机:</p>

						<p>访谈方式:</p>

						<p>访谈时间:</p>

						<p>您的需求:</p>

						<p>支付金额:</p>

					</div>

					<div class="col-xs-7 col-sm-7 text-left">

						<p class="text-center"><?php echo $name; ?></p>

						<p class="text-center"><?php echo $phone; ?></p>

						<p class="text-center"><?php echo $fangshi; ?></p>

						<p class="text-center"><?php echo $time; ?></p>

						<p class="text-center"><?php echo $message; ?></p>

						<p class="text-center"> 500元</p>

						

					</div>



					

<!--

				<div class="col-xs-12 col-sm-12  margin-top-30 text-center">					

						<a href="http://www.paoding.cc/weixin/weixinpaytest/example/jsapi.php?name={$apply.name}&phone={$apply.phone}" class="btn btn-red white-link">现在去付款</a>

						

				</div>-->

				<div align="center">

					<button style="width:210px; height:50px;margin-top:20px; border-radius: 15px;background-color:#ee545f; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >立即支付</button>

			</div>

					

		</div>

	</div>











	<!--<div align="center">

		<h3>庖丁技术产品经理服务费订单<?php echo $apply; ?> </h3>

	</div>s

    <br/>

	<div align="center">

	<font color="#9ACD32"><b><span style="color:#f00;font-size:50px">500元</span></b></font><br/><br/>

	<font color="#9ACD32"><b><span style="color:#f00;font-size:50px"><?php echo $name; ?> </span></b></font><br/><br/>

	<font color="#9ACD32"><b><span style="color:#f00;font-size:50px"><?php echo $phone; ?> </span></b></font><br/><br/>

	<font color="#9ACD32"><b><span style="color:#f00;font-size:50px"><?php echo $fangshi; ?> </span></b></font><br/><br/>

	<font color="#9ACD32"><b><span style="color:#f00;font-size:50px"><?php echo $time; ?> </span></b></font><br/><br/>

	</div>

	<div align="center">

		<button id="zf" style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >立即支付</button>

	</div>-->

</body>

</html>