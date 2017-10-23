<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="#" type="image/png">

    <title><?php echo ($gemmap_config['shop_info_store_title']); ?></title>
    <meta name="keywords" content="<?php echo ($gemmap_config['shop_info_store_keyword']); ?>"/>
    <meta name="description" content="<?php echo ($gemmap_config['shop_info_store_desc']); ?>"/>

    <link href="<?php echo (CSS); ?>/style.css" rel="stylesheet">
    <link href="<?php echo (CSS); ?>/style-responsive.css" rel="stylesheet">
    <script src="/Public/js/common.js" type="text/javascript"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<style type="text/css">
    body {
        background: #f1f1f1;
    }

    .form-horizontal.adminex-form .form-group {
        border-bottom: 1px solid #eff2f7;
        padding-bottom: 15px;
        margin-bottom: 15px;
    }

    .button-next, .finish {
        float: right;
    }

    .fr {
        float: right;
    }

    .radio input[type=radio], .radio-inline input[type=radio], .checkbox input[type=checkbox], .checkbox-inline input[type=checkbox] {
        float: none;
        margin-left: 10px;
    }

    .panel-body {
        padding: 15px;
        border: 1px solid #e6e8eb;
        margin-top: -1px;
    }

    .nav-button span {
        display: inline-block;
    }

    #home .nav-button span {
        width: 12em;
    }

    #about .nav-button span {
        width: 8em;
    }

    #profile .nav-button span {
        width: 11em;
    }

    #Shopping .nav-button span {
        width: 11em;
    }

    #Mail .nav-button span {
        width: 11em;
    }

    #Watermark .nav-button span {
        width: 10em;
    }

    #Distribution .nav-button span {
        width: 9em;
    }

    .radio {
        display: inline-block;
        padding-left: 0px;
    }

    /*-LTJ-**********************/
    .form-input {
        width: 400px;
        display: inline-block;
    }

    .form-option {
        width: 400px;
        height: 34px;
    }

    .panel {
        border: 1px solid #ddd;
    }


    .control-label  input{    width: 20px;
        height: 20px;
        background-color: #ffffff;
        border: solid 1px #dddddd;
        -webkit-border-radius:50%;
        border-radius: 50%;
        font-size: 16px;
        margin: 0;
        padding: 0;
        position: relative;
        display: inline-block;
        vertical-align: top;
        cursor: default;
        -webkit-appearance: none;
        -webkit-user-select: none;
        user-select: none;
        -webkit-transition: background-color ease 0.1s;
        transition: background-color ease 0.1s;
    }
    .control-label  input:hover{cursor:pointer;}
    .control-label  input:focus { outline: none !important; }
    .control-label  input:checked{    background-color: #03a9f4;
        border: solid 1px #03a9f4;
        text-align: center;
        background-clip: padding-box;
        border:none;
    }
    .control-label  input:checked:before{    content: '';
        width: 10px;
        height: 6px;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-left: -5px;
        margin-top: -5px;
        background: transparent;
        border: 1px solid #ffffff;
        border-top: none;
        border-right: none;
        z-index: 2;
        -webkit-border-radius: 0;
        border-radius: 0;
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg);}

    .control-label  input:checked:after{    content: '';
        width: 10px;
        height: 6px;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-left: -5px;
        margin-top: -5px;
        background: transparent;
        border: 1px solid #ffffff;
        border-top: none;
        border-right: none;
        z-index: 2;
        -webkit-border-radius: 0;
        border-radius: 0;
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg);}

    /***********************/

</style>

<body class="sticky-header">

<section>
    <div class="main-content" width="100%" style="margin:0px;">
        <!--body wrapper start-->
        <div class="wrapper">
            <div class="row">
                <div class="col-md-12">
                    <section class="panel">
                        <div class="panel-heading">
                            网站设置
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" id="postbutton" class="btn btn-default "
                                            onclick="ajax_submit_form('form_id')"><i class="fa fa-save"></i>保存
                                    </button>
                                </div>
                            </div>
                        </div>
                      
                        <header class=" panel-body">
                            <ul class="nav nav-tabs" id="tab_ul">
                                <li class="active" data-id="aboutform">
                                    <a href="/type/home#home" data-toggle="tab" ><font color="black">网站设置</font></a>
                                </li>
                                <li class="" data-id="sms_form">
                                    <a href="/type/profile#profile" data-toggle="tab"><font color="black">短信设置</font></a>
                                </li>
                                <li class="" data-id="email_form">
                                    <a href="/type/Mail#Mail" data-toggle="tab"><font color="black">邮件设置</font></a>
                                </li>
                                <!--<li class="">-->
                                    <!--<a href="/type/Shopping#Shopping" data-toggle="tab"><font color="black">商城设置</font></a>-->
                                <!--</li>-->
                            </ul>
                        </header>
                        <div class="">
                            <div class="tab-content">
                                <div class="tab-pane active" id="home">
                                    <form method="post" id="aboutform" class="postform" action="/index.php/Admin/System/setting/action/edit">


                                        <div class="panel-body">
                                            <div class="nav-button ">
                                                <span style="width: 8em;" class="pull-left">公司名称：</span><input type="text" datatype="*"
                                                                                                               nullmsg="公司名称不得为空！"
                                                                                                               class="form-control form-input"
                                                                                                               name="store_name"
                                                                                                               value="<?php echo ($vo['store_name']); ?>"/>
                                            </div>
                                        </div>

                                        <div class="panel-body">
                                            <div class="nav-button ">
                                                <span style="width: 8em;" class="pull-left">公司地址：</span><input type="text" name="address"
                                                                                                               class="form-control form-input"
                                                                                                               style="display: inline-block;"
                                                                                                               value="<?php echo ($vo['address']); ?>"/>
                                            </div>
                                        </div>

                                        <div class="panel-body">
                                            <div class="nav-button ">
                                                <span style="width: 8em;" class="pull-left">网站标题：</span><input type="text" datatype="*"
                                                                                                               nullmsg="网站标题不得为空！"
                                                                                                               class="form-control form-input"
                                                                                                               style="display: inline-block;"
                                                                                                               name="store_title"
                                                                                                               value="<?php echo ($vo['store_title']); ?>"/>
                                            </div>
                                        </div>

                                        <div class="panel-body">
                                            <div class="nav-button ">
                                                <span style="width: 8em;" class="pull-left">网站备案号：</span><input type="text"
                                                                                                               class="form-control form-input"
                                                                                                               style="display: inline-block;"
                                                                                                               name="record_no"
                                                                                                               value="<?php echo ($vo['record_no']); ?>"/>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="nav-button ">
                                                <span style="width: 8em;" class="pull-left">网站描述：</span><input type="text"
                                                                                                               class="form-control form-input"
                                                                                                               style="display: inline-block;"
                                                                                                               name="store_desc"
                                                                                                               value="<?php echo ($vo['store_desc']); ?>"/>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="nav-button ">
                                                <span style="width: 8em;" class="pull-left">网站地址：</span><input type="text"
                                                                                                               class="form-control form-input"
                                                                                                               style="display: inline-block;"
                                                                                                               name="site_url"
                                                                                                               value="<?php echo ($vo['site_url']); ?>"/>
                                                &nbsp &nbsp 需加前缀http://
                                            </div>
                                        </div>

                                        <div class="panel-body">
                                            <div class="nav-button ">
                                                <span style="width: 8em;" class="pull-left">联系人：</span><input type="text" class="form-control form-input"
                                                                                                              ignore="ignore"
                                                                                                              datatype="/^[\u4E00-\u9FA5A-Za-z0-9]+$/"
                                                                                                              style="display: inline-block;"
                                                                                                              name="contact"
                                                                                                              value="<?php echo ($vo['contact']); ?>"/>
                                            </div>
                                        </div>

                                        <div class="panel-body">
                                            <div class="nav-button ">
                                                <span style="width: 8em;" class="pull-left">联系电话：</span><input
                                                    onkeyup='this.value=this.value.replace("/(13\d|14[57]|15[^4,\D]|17[678]|18\d)\d{8}|170[059]\d{7}/","")'  type="text"
                                                    ignore="ignore"
                                                    datatype="/(13\d|14[57]|15[^4,\D]|17[678]|18\d)\d{8}|170[059]\d{7}/"
                                                    class="form-control form-input"
                                                    name="phone" value="<?php echo ($vo['phone']); ?>"/>
                                            </div>
                                        </div>

                                        <div class="panel-body">
                                            <div class="nav-button ">
                                                <span style=" width: 8em;display:inline-block">登录企业图标：</span>
                                                <input type="text" class="form-control form-input" name="login_leftlogo"
                                                       readonly="readonly"
                                                       id="login_leftlogo" value="<?php echo ($vo['login_leftlogo']); ?>"/>

                                                <input class="btn btn-info" type="button" value="上传图片"
                                                       onclick="GetUploadify(1,'login_leftlogo','img','');"/>
                                                &nbsp;&nbsp;
                                                <button class="btn btn-default " type="button"
                                                        onclick="preview('login_leftlogo')"><i class="fa fa-search"></i>
                                                </button>
                                                &nbsp;&nbsp;<span>图片大小：1024*223</span>
                                            </div>
                                            <!--</div>-->
                                        </div>

                                        <div class="panel-body">
                                            <div class="nav-button ">
                                                <span style=" width: 8em;">后台企业图标(大)：</span>
                                                <input type="text" class="form-control form-input" name="store_logo"
                                                       readonly="readonly"
                                                       id="store_logo" value="<?php echo ($vo['store_logo']); ?>"/>
                                                <input class="btn btn-info" type="button" value="上传图片"
                                                       onclick="GetUploadify(1,'store_logo','img','');"/>
                                                &nbsp;&nbsp;
                                                <button class="btn btn-default " type="button"
                                                        onclick="preview('store_logo')"><i class="fa fa-search"></i>
                                                </button>
                                                &nbsp;&nbsp;<span>图片大小：144*40</span>
                                            </div>
                                        </div>

                                        <div class="panel-body">
                                            <span style=" width: 8em;display:inline-block">后台企业图标(小)：</span>
                                            <input type="text" class=" form-control form-input" name="store_small_logo"
                                                   readonly="readonly"
                                                   id="store_small_logo" value="<?php echo ($vo['store_small_logo']); ?>"
                                            />

                                            <input class="btn btn-info" type="button" value="上传图片"
                                                   onclick="GetUploadify(1,'store_small_logo','img','');"/>
                                            &nbsp;&nbsp;
                                            <button class="btn btn-default " type="button"
                                                    onclick="preview('store_small_logo')"><i class="fa fa-search"></i>
                                            </button>
                                            &nbsp;&nbsp;<span>图片大小：40*40</span>
                                            <!--</div>-->
                                        </div>
                                        <div class="panel-body">
                                            <!--<div class="form-group">-->
                                            <span style=" width: 8em;display:inline-block">后台应用图标：</span>
                                            <input type="text" class=" form-control form-input" name="site_left_logo"
                                                   readonly="readonly"
                                                   id="site_left_logo" value="<?php echo ($vo['site_left_logo']); ?>"
                                            />

                                            <input class="btn btn-info" type="button" value="上传图片"
                                                   onclick="GetUploadify(1,'site_left_logo','img','');"/>
                                            &nbsp;&nbsp;
                                            <button class="btn btn-default " type="button"
                                                    onclick="preview('site_left_logo')"><i class="fa fa-search"></i>
                                            </button>
                                            &nbsp;&nbsp;<span>图片大小：1024*1024</span>
                                            <!--</div>-->
                                        </div>
                                        <div class="panel-body">
                                            <!--<div class="form-group">-->
                                            <span style=" width: 8em;display:inline-block">浏览器图标：</span>
                                            <input type="text" class=" form-control form-input" name="title_logo"
                                                   readonly="readonly"
                                                   id="title_logo" value="<?php echo ($vo['title_logo']); ?>"
                                            />

                                            <input class="btn btn-info" type="button" value="上传图片"
                                                   onclick="GetUploadify(1,'title_logo','img','');"/>
                                            &nbsp;&nbsp;
                                            <button class="btn btn-default " type="button"
                                                    onclick="preview('title_logo')"><i class="fa fa-search"></i>
                                            </button>
                                            &nbsp;&nbsp;<span>ico后缀图片，必须大于10K</span>
                                            <!--</div>-->
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="profile">
                                    <form method="post" id="sms_form" action="/index.php/Admin/System/setting/action/edit">
                                        <div class="panel-body">
                                            <div class="nav-button ">
                                                <span style="width: 8em;">注册启用短信：</span>
                                                <div class="radio">
                                                    <label class="control-label">
                                                        <input type="radio" name="regis_sms_enable"
                                                               id="regis_sms_enable" value="0">
                                                        否
                                                    </label>
                                                    <label class="control-label" >
                                                        <input type="radio" name="regis_sms_enable"
                                                               id="regis_sms_enable" value="1">
                                                        是
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="nav-button ">
                                                <span style="width: 8em;">阿里大鱼[appkey]：</span><input type="text" name="sms_appkey"
                                                                                 class="form-control form-input"
                                                                                 style="display: inline-block;"
                                                                                 value="<?php echo ($vo["sms_appkey"]); ?>"/>
                                            </div>
                                        </div>

                                        <div class="panel-body">
                                            <div class="nav-button ">
                                                <span style="width: 8em;">阿里大鱼[secretKey]：</span><input type="text" name="sms_secretKey"
                                                                                    class="form-control form-input"
                                                                                    style="display: inline-block;"
                                                                                    value="<?php echo ($vo["sms_secretKey"]); ?>"/>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="nav-button ">
                                                <span style="width: 8em;">阿里大鱼[sign]：</span><input type="text" name="sms_sign"
                                                                               class="form-control form-input"
                                                                               style="display: inline-block;"
                                                                               value="<?php echo ($vo["sms_sign"]); ?>"/>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="nav-button ">
                                                <span style="width: 8em;">产品名：</span><input type="text" name="sms_product"
                                                                                        class="form-control form-input"
                                                                                        style="display: inline-block;"
                                                                                        value="<?php echo ($vo["sms_product"]); ?>"/>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="nav-button ">
                                                <span style="width: 8em;">短信模板名：</span><input type="text" name="sms_templateCode"
                                                                                              class="form-control form-input"
                                                                                              style="display: inline-block;"
                                                                                              value="<?php echo ($vo["sms_templateCode"]); ?>"/>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="Shopping">
                                    <form method="post"  action="/index.php/Admin/System/setting/action/edit">
                                        <div class="panel-body">
                                            <div class="nav-button ">
                                                <span style="width: 8em;">默认库存：</span>
                                                <input type="number" onkeyup='this.value=this.value.replace(/\D/gi,"")'
                                                       min=0 name="default_storage" class="form-control form-input"
                                                       style="display: inline-block;" value="<?php echo ($vo['default_storage']); ?>"/>&nbsp;&nbsp;&nbsp;&nbsp;
                                            </div>
                                        </div>

                                        <div class="panel-body">
                                            <div class="nav-button ">
                                                <span style="width: 8em;">库存预警数：</span>
                                                <input type="number"
                                                       onkeyup='this.value=this.value.replace(/\D/gi,"")'
                                                       min=0 name="warning_storage"
                                                       value="<?php echo ($vo['warning_storage']); ?>" class="form-control form-input"
                                                       style="display: inline-block;"/>&nbsp;&nbsp;&nbsp;&nbsp;当商品数量少于X件时，会在系统后台首页
                                                &lt;库存预警&gt;显示
                                            </div>
                                        </div>

                                        <div class="panel-body">
                                            <div class="nav-button ">
                                                <span style="width: 8em;">发票税率 (%)：</span>
                                                <input type="number" onkeyup='this.value=this.value.replace(/\D/gi,"")'
                                                       min=0 max=100 name="tax" placeholder="1-100"
                                                       value="<?php echo ($vo['tax']); ?>" class="form-control form-input"/>&nbsp;&nbsp;&nbsp;&nbsp;当买家需要发票的时候就要增加
                                                &lt;商品金额&gt;*
                                                &lt;税率&gt;的费用
                                            </div>
                                        </div>

                                        <div class="panel-body">
                                            <div class="nav-button ">
                                                <span style="width: 8em;">包邮费用设置：</span>
                                                <input type="number" onkeyup='this.value=this.value.replace(/\D/gi,"")'
                                                       class="form-control form-input"
                                                       min=0 name="freight_free" value="<?php echo ($vo['freight_free']); ?>">&nbsp;&nbsp;&nbsp;&nbsp;0表示不免运费
                                            </div>
                                        </div>

                                        <div class="panel-body">
                                            <div class="nav-button ">
                                                <span style="width: 8em;">会员赠送积分：</span>
                                                <input type="number" onkeyup='this.value=this.value.replace(/\D/gi,"")'
                                                       min=0 name="reg_integral" class="form-control form-input"
                                                       value="<?php echo ($vo['reg_integral']); ?>"/>&nbsp;&nbsp;&nbsp;&nbsp;
                                            </div>
                                        </div>

                                        <div class="panel-body">
                                            <div class="nav-button ">
                                                <span style="width: 8em;">积分换算比例：</span>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="point_rate" id="point_rate1" value="1"
                                                               checked>
                                                        1元=1积分
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="point_rate" id="point_rate10"
                                                               value="10">
                                                        1元=10积分
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="point_rate" id="point_rate100"
                                                               value="100">
                                                        1元=100积分
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel-body">
                                            <div class="nav-button ">
                                                <span style=" width: 8em;">自动收货设置：</span>
                                                <select name="auto_confirm_date" class="form-option" id="auto_confirm_date">
                                                    <option value="1">1天</option>
                                                    <option value="2">2天</option>
                                                    <option value="3">3天</option>
                                                    <option value="4">4天</option>
                                                    <option value="5">5天</option>
                                                    <option value="6">6天</option>
                                                    <option value="7">7天</option>
                                                    <option value="8">8天</option>
                                                    <option value="9">9天</option>
                                                    <option value="10">10天</option>
                                                    <option value="11">11天</option>
                                                    <option value="12">12天</option>
                                                    <option value="13">13天</option>
                                                    <option value="14">14天</option>
                                                    <option value="15">15天</option>
                                                    <option value="16">16天</option>
                                                    <option value="17">17天</option>
                                                    <option value="18">18天</option>
                                                    <option value="19">19天</option>
                                                    <option value="20">20天</option>
                                                    <option value="21">21天</option>
                                                    <option value="22">22天</option>
                                                    <option value="23">23天</option>
                                                    <option value="24">24天</option>
                                                    <option value="25">25天</option>
                                                    <option value="26">26天</option>
                                                    <option value="27">27天</option>
                                                    <option value="28">28天</option>
                                                    <option value="29">29天</option>
                                                    <option value="30">30天</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="Mail">
                                    <form method="post" id="email_form" action="/index.php/Admin/System/setting/action/edit">
                                        <div class="panel-body">
                                            <div class="nav-button ">
                                                <span  style="width: 8em;">发送服务器：</span><input type="text" class="form-control form-input"
                                                                                      name="smtp_server"
                                                                                      value="<?php echo ($vo["smtp_server"]); ?>"/>&nbsp;&nbsp;&nbsp;&nbsp;发送邮箱的SMTP地址。如:
                                                smtp.gmail.com或smtp.qq.com
                                            </div>
                                        </div>

                                        <div class="panel-body">
                                            <div class="nav-button "><span style="width: 8em;">发送服务器端口:</span><input type="number"
                                                                                                   class="form-control form-input"
                                                                                                   onkeyup='this.value=this.value.replace(/\D/gi,"")'
                                                                                                   name="smtp_port"
                                                                                                   value="<?php echo ($vo["smtp_port"]); ?>"/>&nbsp;&nbsp;&nbsp;&nbsp;默认为25
                                            </div>
                                        </div>

                                        <div class="panel-body">
                                            <div class="nav-button ">
                                                <span style="width: 8em;">邮箱账号：</span><input type="email" name="smtp_user"
                                                                                   class="form-control form-input"
                                                                                   value="<?php echo ($vo["smtp_user"]); ?>"/>
                                            </div>
                                        </div>

                                        <div class="panel-body">
                                            <div class="nav-button ">
                                                <span style="width: 8em;">邮箱密码：</span><input type="text" name="smtp_pwd"
                                                                                   class="form-control form-input"
                                                                                   value="<?php echo ($vo["smtp_pwd"]); ?>"/>
                                            </div>
                                        </div>

                                       
                                    </form>
                                </div>

                            </div>

                        </div>


                    </section>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- main content end-->
<script type="text/javascript" src="<?php echo (JS); ?>/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo (JS); ?>/Validform_v5.3.2_min.js"></script>
<script type="text/javascript">
    $('.postform').Validform({
        tiptype: 3
    });
</script>
<!-- Placed js at the end of the document so the pages load faster -->
<script src="<?php echo (JS); ?>/jquery-ui-1.9.2.custom.min.js"></script>
<script src="<?php echo (JS); ?>/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo (JS); ?>/bootstrap.min.js"></script>
<script src="<?php echo (JS); ?>/modernizr.min.js"></script>
<script src="<?php echo (JS); ?>/jquery.nicescroll.js"></script>
<script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
<!--common scripts for all pages-->
<script src="<?php echo (JS); ?>/scripts.js"></script>
<script>
    function ajax_submit_form() {

        var form_id = $("#tab_ul").find('.active').attr('data-id');


        var action  =  "/index.php/Admin/System/setting/action/edit";

        //异步提交表单数据
        $.ajax({
            type: "post",
            url: action,
            data: $('#' + form_id).serialize(),
            dataType: 'json',
            success: function (res) {
                if (res.result == 1) {
                    layer.msg(res.msg);

                }
                if (res.result == 0) {
                    layer.msg(res.msg);
                }
            }
        })
    }






    function preview(id) {
        var src = "";
        if ($('#' + id).val()) {
            src = $('#' + id).val();
        } else {
            src = $('#' + id).attr("src");
        }
        var content;
        if (src == "") {
            content = '没有图片可供预览';
            layer.msg(content);
        }
        else {
            content = "<img width='300' height='300' src='" + src + "'>";
            layer.open({
                type: 1,
                title: false,
                closeBtn: false,
                area: ['300px', '300px'],
                skin: 'layui-layer-nobg', //没有背景色
                shadeClose: true,
                content: content
            });
        }
    }    $(document).ready(function () {
        //选中附件大小
        $("#file_size").val('<?php echo ($vo['
        file_size
        ']); ?>'
        )
        ;
        //选中附件大小
        $("#pattern").val('<?php echo ($vo['
        pattern
        ']); ?>'
        )
        ;
        //选中是否开启APP测试
        $("input[name='app_test']").eq(<?php echo ($vo['app_test']); ?>).attr("checked", 'checked');
        //选中是否注册启用短信：
        $("input[name='regis_sms_enable']").eq(<?php echo ($vo['regis_sms_enable']); ?>).attr("checked", 'checked');
        //选中是否注册启用短信：
        $("#sms_time_out").val('<?php echo ($vo['
        sms_time_out
        ']); ?>'
        )
        ;
        //选中积分换算比例
        $("#point_rate<?php echo ($vo['point_rate']); ?>").attr("checked", 'checked');
        //选中发货后多少天自动收货
        $("#auto_confirm_date").val('<?php echo ($vo['
        auto_confirm_date
        ']); ?>'
        )
        ;
        //选中积分换算比例
        $("#condition<?php echo ($vo['condition']); ?>").attr("checked", 'checked');
        //选中积分换算比例
        $("#is_mark<?php echo ($vo['is_mark']); ?>").attr("checked", 'checked');
        //选中积分换算比例
        $("#mark_type<?php echo ($vo['mark_type']); ?>").attr("checked", 'checked');
        //选中积分换算比例
        $("#sel<?php echo ($vo['sel']); ?>").attr("checked", 'checked');
        //分销开关
        $("input[name='switch']").eq(<?php echo ($vo['switch']); ?>).attr("checked", 'checked');
        //意见反馈审核开关
        $("input[name='meb_feedback']").eq(<?php echo ($vo['meb_feedback']); ?>).attr("checked", 'checked');
        //商品评价审核开关
        $("input[name='meb_comment']").eq(<?php echo ($vo['meb_comment']); ?>).attr("checked", 'checked');
        //预约评价审核开关
        $("input[name='meb_book']").eq(<?php echo ($vo['meb_book']); ?>).attr("checked", 'checked');
        //报名评价审核开关
        $("input[name='meb_sign']").eq(<?php echo ($vo['meb_sign']); ?>).attr("checked", 'checked');
        //商品咨询审核开关
        $("input[name='meb_consult']").eq(<?php echo ($vo['meb_consult']); ?>).attr("checked", 'checked');
        //文章评论审核开关
        $("input[name='meb_article']").eq(<?php echo ($vo['meb_article']); ?>).attr("checked", 'checked');
        //启用微信二维码扫描登录
        $("input[name='wx_scanning']").eq(<?php echo ($vo['wx_scanning']); ?>).attr("checked", 'checked');
        //3次登录失败后启用验证码
        $("input[name='login_code']").eq(<?php echo ($vo['login_code']); ?>).attr("checked", 'checked');
        //微信自动注册
        $("input[name='wx_auto_register']").eq(<?php echo ($vo['wx_auto_register']); ?>).attr("checked", 'checked');
        //活动评论审核开关
        $("input[name='switch_activity_comment']").eq(<?php echo ($vo['switch_activity_comment']); ?>).attr("checked", 'checked');
        //活动服务评论审核开关
        $("input[name='switch_activity_service_comment']").eq(<?php echo ($vo['switch_activity_service_comment']); ?>).attr("checked", 'checked');
    });
    function adsubmit(str) {
        if ($('input[name=tax]').val() > 100 || $('input[name=tax]').val() < 0) {
            layer.msg('请填写正确税率', {icon: 2, time: 2000});   //alert('少年，用户名不能为空！');
            return false;
        }
        $('#' + str).submit();
    }
</script>
</body>
</html>