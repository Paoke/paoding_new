<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>申请认证</title>
    <meta name="description" content="庖丁科技众包服务平台携手国内外先进技术科研院所、顶级技术专家，以实现科技成果市场化为核心，为企业提供快速精准的需求匹配服务，从而实现企业以及科技资源的有效对接，帮助企业实现产业技术升级，助力先进技术完成产业化发展。" />
    <meta name="keywords" content="庖丁众包、智能技术、机械制造、健康医疗、材料科学、能源环保、生产流程优化"/>
    <meta name='viewport' content='user-scalable=no,width=750'>
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/common_new.css">
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/my.css">
</head>
<body>
<form action="" method="get">
    <div class="tech_tit_box clear">
        <div class="tech_icon fl"></div>
        <p class="tech_tit fl">智能技术</p>
    </div>

    <div class="tech_checkbox">
        <div class="tech_main">
            <div class="tech_circle"></div>
            <label><input type="checkbox" name="way" value="智能家电">智能家电</label>
        </div>
        <div class="tech_main">
            <div class="tech_circle"></div>
            <label><input type="checkbox" name="way" value="智能家居">智能家居</label>
        </div>
        <div class="tech_main">
            <div class="tech_circle"></div>
            <label><input type="checkbox" name="way" value="智能机器">智能机器</label>
        </div>
        <div class="tech_main">
            <div class="tech_circle"></div>
            <label><input type="checkbox" name="way" value="智能手表">智能手表</label>
        </div>
    </div>

    <div class="tech_tit_box clear">
        <div class="tech_icon fl"></div>
        <p class="tech_tit fl">创新技术</p>
    </div>

    <div class="tech_checkbox">
        <div class="tech_main">
            <div class="tech_circle"></div>
            <label><input type="checkbox" name="way" value="创新家电">创新家电</label>
        </div>
        <div class="tech_main">
            <div class="tech_circle"></div>
            <label><input type="checkbox" name="way" value="创新家居">创新家居</label>
        </div>
        <div class="tech_main">
            <div class="tech_circle"></div>
            <label><input type="checkbox" name="way" value="创新机器">创新机器</label>
        </div>
        <div class="tech_main">
            <div class="tech_circle"></div>
            <label><input type="checkbox" name="way" value="创新行业">创新行业</label>
        </div>
    </div>
</form>
<div class="sec_return">
    <a onclick="javascript:history.go(-1);">
        <img class="return_icon" src="/Public/Mobile/images/icon-common-return.png" alt="">
    </a>
    <a class="change_name_savs"><div class="app_btn">确定</div></a>
</div>

</body>
<script src='<?php echo (MOBILE); ?>/js/jquery-3.0.0.min.js'></script>
<script>
    // 表单优化，默认input设置透明，以选中状态作为判断条件
    $("label").on("change",function(){
        if($(this).find("input").is(':checked')){
            $(this).parent('.tech_main').find(".tech_circle").addClass('circle_active');
            return false;
        }
        else{
            $(this).parent('.tech_main').find(".tech_circle").removeClass('circle_active');
            return false;
        }

    })
    $(".change_name_savs").on('click',function () {
        var yyhy=null;
        $(".circle_active").each(function () {
            if(yyhy==null){
                yyhy=$(this).next().children().val();
            }else{
                yyhy=yyhy+'、'+$(this).next().children().val();
            }
        });
        window.location.href='/index.php/Mobile/User/user_authen.html?yyhy='+yyhy;

    })
</script>
</html>