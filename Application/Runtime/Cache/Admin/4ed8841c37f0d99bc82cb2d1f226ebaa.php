<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title><?php echo ($gemmap_config['shop_info_store_title']); ?></title>
    <meta name="keywords" content="<?php echo ($gemmap_config['shop_info_store_keyword']); ?>"/>
    <meta name="description" content="<?php echo ($gemmap_config['shop_info_store_desc']); ?>"/>
    <link rel="stylesheet" href="<?php echo (CSS); ?>/base.css"/>
</head>
<style type="text/css">
    html, body {
        height: 100%;
    }

    body {
        background: url(<?php echo (IMG); ?>/login-bg.jpg) no-repeat;
        background-size: cover;
        height: 100%;
        position: relative;
    }

    .container {
        background: #fff;
        width: 350px;
        height: 100px;
        position: absolute;
        top: 20%;
        left: 35%;
        bottom: 0;
        right: 0;
        padding: 10px 10px;
        border-radius: 10px;
    }

    .container h1 {
        color: #50aa8e;
        text-align: center;
        line-height: 20px;
        font-weight: 700;
        font-size: 20px;
    }

    .container ul {
        text-align: center;
        margin-top: 15px;
        line-height: 10px;
    }

    .container li {
        margin-top: 15px;
    }

    .footer {
        margin-top: 25px;
        text-align: center;
    }

    .footer a {
        color: #124ec1;
    }

    p {
        text-align: center;
    }
</style>
<body>

<div class="wrapper">
    <?php if(isset($message)) {?>
    <!--处理成功-->
    <div class="container">
        <h1><?php echo($message); ?></h1>
        <ul>
            <a id="href" href="<?php echo($jumpUrl); ?>"></a>
            <li><img src="/Public/images/jiazai.gif" height="30" width="30" alt=""/></li>
            <li>
                等待时间： <b id="wait"><?php echo($waitSecond); ?></b>
            </li>
        </ul>
        <!--<div class="footer">-->
            <!--<p>&copy; 2016-2017 <a href="http://www.gemmap.cn" target="_blank">www.gemmap.cn</a></p>-->
            <!--<p>5u应用配置平台</p>-->
            <!--<p>广州京墨医疗科技有限公司</p>-->
        <!--</div>-->
    </div>
    <?php }else{?>
    <!--处理失败-->
    <div class="container">
        <h1> <?php echo($error); ?></h1>
        <ul>
            <a id="href" href="<?php echo($jumpUrl); ?>"></a>
            <li><img src="/Public/images/jiazai.gif" height="30" width="30" alt=""/></li>
            <li>
                等待时间： <b id="wait"><?php echo($waitSecond); ?></b>
            </li>
        </ul>
        <!--<div class="footer">-->
            <!--<p>&copy; 2016-2017 <a href="http://www.gemmap.cn" target="_blank">www.gemmap.cn</a></p>-->
            <!--<p>5u应用配置平台</p>-->
            <!--<p>广州京墨医疗科技有限公司</p>-->
        <!--</div>-->
    </div>
    <?php }?>


</div><!-- /.login-box -->

<script type="text/javascript">

    (function () {
        var wait = document.getElementById('wait'), href = document.getElementById('href').href;
        var interval = setInterval(function () {
            var time = --wait.innerHTML;
            if (time <= 0) {
                location.href = href;
                clearInterval(interval);
            }
            ;
        }, 1000);
    })();

</script>
</body>
</html>