<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <link rel="shortcut icon" href="<?php echo ($gemmap_config['shop_info_title_logo']); ?>" type="image/png">
    <title><?php echo ($gemmap_config['shop_info_store_title']); ?></title>
    <meta name="keywords" content="<?php echo ($gemmap_config['shop_info_store_keyword']); ?>"/>
    <meta name="description" content="<?php echo ($gemmap_config['shop_info_store_desc']); ?>"/>

    <link href="<?php echo (CSS); ?>/style.css" rel="stylesheet">
    <link href="<?php echo (CSS); ?>/style-responsive.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<style type="text/css">
.state-overview .panel { padding: 10px; border-radius: 5px; }
.value{ font-weight: 500; }
.value p{ font-weight: 500; }
.symbol{ float: left; }
.panel { padding: 5px; border: 1px solid #e6e8eb; margin-top: -1px;margin-bottom:10px; }
.panel-heading { border-bottom: 1px solid #ddd; }
ul,li,ol{ list-style:none; padding:0; }
body { background: #f1f1f1; }
.mt{ margin-bottom:10px; }
.infoBox{ width: 500px; height: 480px; position: fixed; left: 0; bottom:0; top: 0; right: 0; background: #fff; margin: auto; z-index: 9999; display:none; }
.back_2{ position: fixed; left:0; top:0; right:0; bottom:0; margin:auto; background:#000; opacity:0.6; z-index: 99; display:none; }
.container{ width: 100%; height: 60px; overflow: hidden; background: #1ab394; }
.container .center a { display: block; width: 28px; background: #fff; height:28px; border-radius: 100%; }
.container .center a  img{ width: 100%; }
.container .center { right:15px; top: 12px; }
.pa { position: absolute; }
.container h1 { width: 70%; margin: 0 auto; font-weight: normal; font-size: 24px; text-align: center; height: 60px; line-height: 60px; overflow: hidden.; color: #fff; }
.secondInfo{ padding:20px; }
.secondInfo li{ margin-bottom:10px; width: 100%; height: 40px; }
.secondInfo p{ line-height: 30px; font-size: 20px; }
.bigTest{ color:red; }
.young{ width: 160px; height:160px; overflow: hidden; }
.young img{ width: 100%; }

.alert_box{ width: 100%; height: 100%; position: fixed; left:0; top:0; display:none; overflow:hidden; z-index: 99; }
.alert_box.on{ display:block; }
.black{ position: fixed; left:0; top:0; right:0; bottom:0; margin:auto; background:#000; opacity:0.6; z-index: 99; display:none; }
.price-box{ width: 500px; height:480px; position: absolute; left: 0; bottom:0; top:0; right:0; background: #fff; margin:auto; z-index: 9999; }
.state-overview .green,.state-overview .red,.state-overview .blue,.state-overview .yellow,.state-overview .purple { box-shadow:none; }
.toglel{width: 33%;float: right;}
.toglel button{width: 32%  !important;;}
.sylmbo{border: 1px solid #e7e7e7; padding:5px;margin-bottom:8px;}
.btn{padding:4px; }
.table > thead > tr > th{ vertical-align: bottom; border-bottom: 1px solid #ddd; padding: 10px; text-align:left; }
.alian{ width: 100%; float: left; }
.bllan{width: 30%;float: left; margin-right: 10px;}
</style>

<body class="sticky-header" id="html" style="margin-bottom:100px;">
    <!-- page heading end-->
    <div  width="100%" style="margin:10px;" class="panel">
        <header class="panel-heading">
            <div class="pull-left "> 应用概括</div>
            <div class="pull-right">
                <div class="formadd">
                    <a href="javascript:;" class="btn btn-default pull-right">整体趋势</a>
                </div>
            </div>
        </header>

        <div class="panel-body " style="margin:10px;">
            <div class="alian">
                <div class="row state-overview">
                    <div class="bllan">
                        <div class="panel purple">
                            <div class="symbol">
                                <i class="fa fa-vimeo-square fa-2x"></i>
                            </div>
                            <div class="state-value">
                                <div class="value"><?php echo ((isset($count["users"]) && ($count["users"] !== ""))?($count["users"]):0); ?></div>
                                <div class="title">总用户数</div>
                            </div>
                        </div>
                    </div>
                    <div class="bllan">
                        <div class="panel red">
                            <div class="symbol">
                                <i class="fa fa-male fa-2x"></i>
                            </div>
                            <div class="state-value">
                                <div class="value"><?php echo ((isset($count["month_users"]) && ($count["month_users"] !== ""))?($count["month_users"]):0); ?></div>
                                <div class="title">本月新增用户</div>
                            </div>
                        </div>
                    </div>
                    <div class="bllan">
                        <div class="panel blue">
                            <div class="symbol">
                              <i class="fa fa-female fa-2x"></i>
                            </div>
                            <div class="state-value">
                                <div class="value"><?php echo ((isset($count["today_users"]) && ($count["today_users"] !== ""))?($count["today_users"]):0); ?></div>
                                <div class="title">本日新增用户</div>
                            </div>
                        </div>
                    </div>
                    <div class="bllan">
                        <div class="panel green">
                            <div class="symbol">
                                <i class="fa fa-paste fa-2x"></i>
                            </div>
                            <div class="state-value">
                                <div class="value"><?php echo ((isset($count["year_login"]) && ($count["year_login"] !== ""))?($count["year_login"]):0); ?></div>
                                <div >本年访问量</div>
                            </div>
                        </div>
                    </div>
                    <div class="bllan">
                        <div class="panel yellow">
                            <div class="symbol">
                                <i class="fa fa-female fa-2x"></i>
                            </div>
                            <div class="state-value">
                                <div class="value"><?php echo ((isset($count["month_login"]) && ($count["month_login"] !== ""))?($count["month_login"]):0); ?></div>
                                <div class="title">本月访问量</div>
                            </div>
                        </div>
                    </div>
                    <div class="bllan">
                        <div class="panel blue">
                            <div class="symbol">
                                <i class="fa fa-paste fa-2x"></i>
                            </div>
                            <div class="state-value">
                                <div class="value"><?php echo ((isset($count["today_login"]) && ($count["today_login"] !== ""))?($count["today_login"]):0); ?></div>
                                <div >本日访问量</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--服务对接-->
            <div class="alian">
                <div class="row state-overview">
                    <div class="bllan">
                        <div class="panel purple">
                            <div class="symbol">
                                <i class="fa fa-vimeo-square fa-2x"></i>
                            </div>
                            <div class="state-value">
                                <div class="value"><?php echo ($Handle["wcl"]); ?></div>
                                <div class="title">服务对接-未处理</div>
                            </div>
                        </div>
                    </div>
                    <div class="bllan">
                        <div class="panel red">
                            <div class="symbol">
                                <i class="fa fa-male fa-2x"></i>
                            </div>
                            <div class="state-value">
                                <div class="value"><?php echo ($Handle["ycl"]); ?></div>
                                <div class="title">服务对接-已处理</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end -->
        </div>

            </div>

            <div class="toglel" style="display: none">
                <ul>
                    <li class="sylmbo">
                        <button class="btn  btn-info " type="button">Android版</button>
                        <button class="btn btn-default alert_btn" type="button">预览</button>
                        <button class="btn btn-default dropdown-toggle btn-de " type="button">打包</button>
                    </li>
                    <li class="sylmbo">
                        <button class="btn  btn-info " type="button">IOS版</button>
                        <button class="btn btn-default alert_btn " type="button">预览</button>
                        <button class="btn btn-default dropdown-toggle btn-de " type="button">打包</button>
                    </li>
                    <li class="sylmbo">
                        <button class="btn  btn-info " type="button">微信端</button>
                        <button class="btn btn-default alert_btn " type="button">预览</button>
                        <button class="btn  " type="button">绑定</button>
                    </li>
                </ul>
            </div>
        </div>

        <section  class="panel" style="display: none">
             <header class="panel-heading panel-body">
                <div class="pull-left "> 关键指标</div>
            </header>
            <table class="table">
                <thead>
                <tr>
                    <th>指标</th>
                    <th>启动次数</th>
                    <th>启动用户</th>
                    <th>新增用户</th>
                    <th>累积用户</th>
                    <th>活跃用户</th>
                    <th>平均使用时长</th>
                    <th>平均日使用时长</th>
                    <th>次日留存率</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>全部</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                </tr>
                <tr>
                    <td>Android端</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                </tr>
                <tr>
                    <td>IOS端</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                </tr>
                <tr>
                    <td>微信端</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                </tr>
                </tbody>
            </table>
        </section>

        <section  class="panel" style="display: none">
             <header class="panel-heading panel-body">
                <div class="pull-left "> 关键指标</div>
            </header>
            <table class="table">
                <thead>
                <tr>
                    <th>指标</th>
                    <th>启动次数</th>
                    <th>启动用户</th>
                    <th>新增用户</th>
                    <th>累积用户</th>
                    <th>活跃用户</th>
                    <th>平均使用时长</th>
                    <th>平均日使用时长</th>
                    <th>次日留存率</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>全部</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                </tr>
                <tr>
                    <td>Android端</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                </tr>
                <tr>
                    <td>IOS端</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                </tr>
                <tr>
                    <td>微信端</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                    <td>19000</td>
                </tr>
                </tbody>
            </table>
        </section>
           
        <section class="secondBanner" style="display: none">
            <div class="back_2"></div>
             <div class="infoBox">
                 <div class="container">
                     <div class="pa center"><a class="x" href="javascript:;"><img src="/Public/images/cancel.png" alt="" /></a> </div>
                     <h1>购买应用</h1>
                 </div>
                <div class="secondInfo">
                     <ul>
                         <li>
                            <span  class="col-md-3">站点名称:</span>www.dreammore.com
                         </li>
                         <li>
                             <span class="col-md-3">购买格式:</span>Android版打包费用
                         </li>
                         <li>
                             <span class="col-md-3">应付金额：</span>
                             <p class="bigTest">98元</p>
                         </li>
                         <li>
                             <span class="col-md-3">支付扫码：</span>
                            <div class="young">
                                <div><img src="/Public/home/images/qrcode.png"alt="" /></div>
                            </div>
                            <p>扫码支付完成 生产Android版应用</p>
                         </li>
                     </ul>
                </div>
             </div>
        </section>

        <section class="alert_box">
            <div class="black"></div>
            <div class="price-box" id="price-box_2">
                <div class="container">
                    <div class="pa center"><a class="x" href="javascript:;"><img src="/Public/images/cancel.png" alt="" /></a> </div>
                    <h1>购买应用</h1>
                </div>
                <div class="secondInfo">
                     <ul>
                         <li>
                             <span class="col-md-3">支付扫码：</span>
                            <div class="young">
                                <div><img src="/Public/home/images/qrcode.png"alt="" /></div>
                            </div>
                            <p>扫码支付完成 生产Android版应用</p>
                         </li>
                     </ul>
                </div>
             </div>
        </section> 

</div>
</body>
</html>

<!-- Placed js at the end of the document so the pages load faster -->
<script src="<?php echo (JS); ?>/jquery-1.10.2.min.js"></script>
<script src="<?php echo (JS); ?>/jquery-ui-1.9.2.custom.min.js"></script>
<script src="<?php echo (JS); ?>/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo (JS); ?>/bootstrap.min.js"></script>
<script src="<?php echo (JS); ?>/modernizr.min.js"></script>
<script src="<?php echo (JS); ?>/jquery.nicescroll.js"></script>
<script src="<?php echo (JS); ?>/scripts.js"></script>
<script type="text/javascript">

// 123
    $(function(){
        $('.btn-de').click(function(event){
            $('.infoBox').show();
            $('.back_2').show();
        });

        $('.x').click(function(event){
            $('.infoBox').hide();
            $('.back_2').hide();
        });
         $('.back_2').click(function(event){
            $('.infoBox').hide();
            $('.back_2').hide();
        });
    })

// 123
    $(function(){
        $('.alert_btn').click(function(event){
            $('.alert_box').show();
            $('.black').show();
        });

        $('.x').click(function(event){
            $('.alert_box').hide();
            $('.black').hide();
        });
         $('.black').click(function(event){
            $('.alert_box').hide();
            $('.black').hide();
        });
    })
    

</script>