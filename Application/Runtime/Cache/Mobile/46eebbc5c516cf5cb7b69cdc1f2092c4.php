<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>个人信息</title>
    <meta name="description" content="庖丁科技众包服务平台携手国内外先进技术科研院所、顶级技术专家，以实现科技成果市场化为核心，为企业提供快速精准的需求匹配服务，从而实现企业以及科技资源的有效对接，帮助企业实现产业技术升级，助力先进技术完成产业化发展。" />
    <meta name="keywords" content="庖丁众包、智能技术、机械制造、健康医疗、材料科学、能源环保、生产流程优化"/>
    <meta name='viewport' content='user-scalable=no,width=750'>
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/common_new.css">
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/my.css">
</head>
<body>
<p class="apply_tit">已绑定手机号</p>
<p class="apply_tip"></p>
<div class="apply_already clear">
    <div class="phone_icon fl">
        <img src="<?php echo (MOBILE); ?>/images/icon-binding.png" alt="">
    </div>
    <div class="already_num fl">
        <p class="already_tip">你当前已绑定手机号</p>
        <p class="already_number"><?php echo ($_SESSION['userArr']['mobile']); ?></p>
    </div>
</div>
<a href="/index.php/Mobile/User/change_binding.html" class="apply_form">修改绑定</a>
<p class="apply_change_tip">为确保账户安全，换绑前需验证当前手机号</p>
</body>
<script src='<?php echo (MOBILE); ?>/js/jquery-3.0.0.min.js'></script>
<script src='<?php echo (MOBILE); ?>/js/return.js'></script>
<script>
    function (str) {

    }
</script>
</html>