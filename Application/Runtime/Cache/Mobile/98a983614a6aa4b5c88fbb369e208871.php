<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>主题论坛</title>
    <meta name="description" content="庖丁科技众包服务平台携手国内外先进技术科研院所、顶级技术专家，以实现科技成果市场化为核心，为企业提供快速精准的需求匹配服务，从而实现企业以及科技资源的有效对接，帮助企业实现产业技术升级，助力先进技术完成产业化发展。" />
    <meta name="keywords" content="庖丁众包、智能技术、机械制造、健康医疗、材料科学、能源环保、生产流程优化"/>
    <meta name='viewport' content='user-scalable=no,width=750'>
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/common_new.css">
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/activity.css">
</head>
<body>
<div class="theme_banner">
    <img class="theme_img" src="<?php echo (MOBILE); ?>/images/theme-banner.jpg" alt="">
</div>
<!-- tab切换 -->
<div class="clear theme_title">
    <div class="theme_tab fl theme_active" style="margin-right:142px;">
        <img src="<?php echo (MOBILE); ?>/images/theme-icon.jpg" alt="">
        <span>论坛简介</span>
    </div>
    <div class="theme_tab fl">
        <img src="<?php echo (MOBILE); ?>/images/theme-icon.jpg" alt="">
        <span>受邀嘉宾</span>
    </div>
</div>

<!-- tab切换主体 -->
<!-- 论坛简介 -->
<div class="theme_tab_content" style="display:block;">
    <div class="theme_main">
        <div class="clear">
            <div class="fl lump"></div>
            <span class="fl theme_tit">主题论坛</span>
        </div>
        <p class="theme_ct">论坛根生中国、立足亚洲、辐射世界，是为亚洲各国之间、亚洲各国与世界其它地区之间经济交流与商务交流合作的高端平台；是亚洲各国政、商、学、研、资等各界精英指点财富江山、激荡财智思想的饕餮盛宴，是以亚洲各国高层政要、地方首脑、驻华使节、企业领袖、专家学者、社会名流等为主体的高端国际组织。</p>
    </div>
    <div class="index_div"></div>

    <div class="theme_main">
        <div class="clear">
            <div class="fl lump"></div>
            <span class="fl theme_tit">举办活动</span>
        </div>
        <div class="activity_lately_section clear">
            <div class="activity_section_left fl">
                <img src="<?php echo (MOBILE); ?>/images/activity-bottom-banner-1.jpg" alt="">
            </div>
            <div class="activity_section_right fr">
                <p class="activity_right_tit">广东省家具行业推行绿色清洁生产与挥发性有机污染物</p>
                <p class="activity_right_p">
                    <span class="activity_right_span">广州 天河区</span>
                    <span>09/16</span>
                </p>
                <p class="activity_right_p">
                    浏览<span class="activity_right_span"> 2068</span>
                    收藏<span> 1258</span>
                </p>
            </div>
        </div>

        <div class="activity_lately_section clear">
            <div class="activity_section_left fl">
                <img src="<?php echo (MOBILE); ?>/images/activity-bottom-banner-1.jpg" alt="">
            </div>
            <div class="activity_section_right fr">
                <p class="activity_right_tit">广东省家具行业推行绿色清洁生产与挥发性有机污染物</p>
                <p class="activity_right_p">
                    <span class="activity_right_span">广州 天河区</span>
                    <span>09/16</span>
                </p>
                <p class="activity_right_p">
                    浏览<span class="activity_right_span"> 2068</span>
                    收藏<span> 1258</span>
                </p>
            </div>
        </div>

        <div class="activity_lately_section clear">
            <div class="activity_section_left fl">
                <img src="<?php echo (MOBILE); ?>/images/activity-bottom-banner-1.jpg" alt="">
            </div>
            <div class="activity_section_right fr">
                <p class="activity_right_tit">广东省家具行业推行绿色清洁生产与挥发性有机污染物</p>
                <p class="activity_right_p">
                    <span class="activity_right_span">广州 天河区</span>
                    <span>09/16</span>
                </p>
                <p class="activity_right_p">
                    浏览<span class="activity_right_span"> 2068</span>
                    收藏<span> 1258</span>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- 受邀嘉宾 -->
<div class="theme_tab_content">
    <div class="theme_guest clear">
        <div class="theme_head fl">
            <img src="<?php echo (MOBILE); ?>/images/activity-guest.jpg" alt="">
        </div>
        <div class="guset_introduce fl">
            <p class="guest_name">张全琪</p>
            <p class="guest_university">中山大学卡内基梅隆大学</p>
            <p class="guest_position">国际联合研究会(JRI)副研究员</p>
        </div>
    </div>

    <div class="theme_guest clear">
        <div class="theme_head fl">
            <img src="<?php echo (MOBILE); ?>/images/activity-guest.jpg" alt="">
        </div>
        <div class="guset_introduce fl">
            <p class="guest_name">张全琪</p>
            <p class="guest_university">中山大学卡内基梅隆大学</p>
            <p class="guest_position">国际联合研究会(JRI)副研究员</p>
        </div>
    </div>
</div>

</body>
<script src='<?php echo (MOBILE); ?>/js/jquery-3.0.0.min.js'></script>
<script src='<?php echo (MOBILE); ?>/js/return.js'></script>
<script>
    // tab切换
    $(".theme_tab").on("click",function(){
        var index = $(this).index();
        $(this).addClass('theme_active').siblings('.theme_active').removeClass('theme_active');
        $(".theme_tab_content").eq(index).show().siblings('.theme_tab_content').hide();
    })

    // 导航栏
    // 需修改的元素：dv、 body的padding-top值，赋为dv的高度
    $(function () {
        var ie6 = /msie 6/i.test(navigator.userAgent),
            dv = $('.theme_title'), //活动元素
            st;
        dv.attr('otop', dv.offset().top); //存储原来的距离顶部的距离
        $(window).scroll(function () {
            st = Math.max(document.body.scrollTop || document.documentElement.scrollTop);
            if (st >= parseInt(dv.attr('otop'))) {
                if (ie6) {
                    //IE6不支持fixed属性，所以只能靠设置position为absolute和top实现此效果
                    dv.css({ position: 'absolute', top: st });
                }
                else if(dv.css('position') != 'fixed'){
                    dv.css({ 'position': 'fixed', 'top': 0,'left':'50%','margin-left':'-375px'});
                    $('body').css('padding-top','81px');
                }
            } else if (dv.css('position') != 'relative'){
                dv.css({ 'position': 'relative' });
                $('body').css('padding-top','');
            }
        });
    });

</script>
</html>