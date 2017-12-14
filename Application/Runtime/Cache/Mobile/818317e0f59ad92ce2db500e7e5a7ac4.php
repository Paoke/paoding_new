<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>意见反馈</title>
    <meta name="description" content="庖丁科技众包服务平台携手国内外先进技术科研院所、顶级技术专家，以实现科技成果市场化为核心，为企业提供快速精准的需求匹配服务，从而实现企业以及科技资源的有效对接，帮助企业实现产业技术升级，助力先进技术完成产业化发展。" />
    <meta name="keywords" content="庖丁众包、智能技术、机械制造、健康医疗、材料科学、能源环保、生产流程优化"/>
    <meta name='viewport' content='user-scalable=no,width=750'>
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/common_new.css">
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/my.css">
</head>
<body class="advice_body">
<p class="advice_p">您对庖丁众包平台的意见或建议(必填)</p>
<div class="advice_area">
    <textarea class="advice_text"  maxlength="200"></textarea>
    <p class="advice_numlim">
        <span class="advice_count">0 </span>
        | 200字
    </p>
</div>
<p class="advice_p">您的手机号</p>

<input class="advice_area2" type="text" placeholder="请输入您的手机号码">

<p class="advice_p">您的称呼(选填)</p>
<input class="advice_area2" type="text" placeholder="请输入您的贵姓">
<a href="my.html" class="register_btn" style="margin: 70px auto 100px;">发 送</a>

</body>
<script src='<?php echo (MOBILE); ?>/js/jquery-3.0.0.min.js'></script>
<script src='<?php echo (MOBILE); ?>/js/return.js'></script>
<script>
    var remainNum;
    $('.advice_text').keyup(function(){
        remainNum = $('textarea').val().length;
        $('.advice_count').html(remainNum);
        if($('textarea').val()!=""){
            $('.register_btn').css('background','#1a191e');
        }else{
            $('.register_btn').css('background','#ccc');
        }
    })

</script>
</html>