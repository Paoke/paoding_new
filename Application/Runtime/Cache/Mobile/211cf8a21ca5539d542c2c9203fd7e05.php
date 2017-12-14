<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en" ng-app="publishTec">
<head>
    <meta charset="UTF-8">
    <title>发布需求</title>
    <meta name="description" content="庖丁科技众包服务平台携手国内外先进技术科研院所、顶级技术专家，以实现科技成果市场化为核心，为企业提供快速精准的需求匹配服务，从而实现企业以及科技资源的有效对接，帮助企业实现产业技术升级，助力先进技术完成产业化发展。" />
    <meta name="keywords" content="庖丁众包、智能技术、机械制造、健康医疗、材料科学、能源环保、生产流程优化"/>
    <meta name='viewport' content='user-scalable=no,width=750'>
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/common_new.css">
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/index-publish-common.css">
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/index.css">
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/swiper.css">
</head>
<body ng-controller="ctrlTec">
<input type="hidden" id="user_id" name="user_id" value="<?php echo ($user_id); ?>">
<div class="demand_div clear">
    <span class="demand_name fl">需求名称</span>
    <input class="demand_input fr" type="text" placeholder="请输入技术需求的名称" id="title">
</div>
<div class="demand_div clear" style="border:none;">
    <span class="demand_name fl">需求说明</span>
    <img class='fr demand_div_jt' src="<?php echo (MOBILE); ?>/images/icon-index-issue-down.png" alt="">
</div>
<div class="advice_area">
    <textarea class="advice_text" ng-model="text" ng-change="tolCount();" maxlength="200" placeholder="请输入目前主要的技术问题、需求场景、指标指数等" id="content"></textarea >
    <p class="advice_numlim">
        <span class="advice_count" ng-bind="count">0</span>
        | 200字
    </p>
</div>
<div class="demand_area">
    <p style="margin-left:30px;">需求领域</p>
    <div class="areas_main clear">
        <li class="areas_default">电子信息</li>
        <li class="areas_default">先进制造</li>
        <li class="areas_default">新材料</li>
        <li class="areas_default">新能源与节能</li>
        <li class="areas_default">环境保护</li>
        <li class="areas_default">健康医疗</li>
        <li class="areas_default">智能技术</li>
    </div>
</div>
<div class="demand_div clear" style="border-top:1px solid #ccc;">
    <span class="demand_name fl">投入预算</span>
    <div class="fr demand_name">
        <label><input name="price" class="inp_radio" type="radio" value="面议" />面议</label>
        <label><input name="price" class="inp_radio" type="radio" value="公开" />公开</label>

    </div>
</div>
<div class="demand_div clear"  id="choose_btn">
    <span class="demand_name fl">期限要求</span>
    <img class='fr demand_div_jt' src="<?php echo (MOBILE); ?>/images/icon-index-issue-right.png" alt="">
    <span class="demand_name fr" id="choose_html">请选择</span>
</div>
<div class="index_div"></div>

<div class="demand_div clear">
    <span class="demand_name fl">企业名称</span>
    <!-- <img class='fl point_icon' src="<?php echo (MOBILE); ?>/images/icon-index-issue-remind.png" alt=""> -->
    <input class="demand_input fr" type="text" placeholder="请输入企业名称" id="company">
</div>
<div class="demand_div clear">
    <span class="demand_name fl">主营业务</span>
    <!-- <img class='fl point_icon' src="<?php echo (MOBILE); ?>/images/icon-index-issue-remind.png" alt=""> -->
    <input class="demand_input fr" type="text" placeholder="请输入主营业务" >
</div>
<div class="demand_div clear">
    <span class="demand_name fl">联系人</span>
    <input class="demand_input fr" type="text" placeholder="请输入联系人名字" id="people" >
</div>
<div class="demand_div clear">
    <span class="demand_name fl">联系号码</span>
    <input class="demand_input fr" type="number" placeholder="请输入联系手机号码" id="phone" oninput="if(this.value>11){this.value = this.value.substr(0,11)};">
</div>
<a  class="register_btn" style="margin-top:60px" onclick="getMsg();">确认发布</a>

<!-- 选择上拉框 -->
<div class="mask" style="display:none"></div>
<div class="issue-tip">
    <!-- <img src="issue-close" alt=""> -->
    <!-- <img class="issue-done" src="images/index-issue-done.png" alt=""> -->
</div>
<div class="slide-wrap">
    <div class="choose-time clear">
        <p class="fl cancle">取消</p>
        <p class="fl choose-p2">选择时间</p>
        <p class="fr complete">完成</p>
    </div>
    <div class="slide-line"></div>
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">1个月</div>
            <div class="swiper-slide">2个月</div>
            <div class="swiper-slide">3个月</div>
            <div class="swiper-slide">4个月</div>
            <div class="swiper-slide">5个月</div>
            <div class="swiper-slide">6个月</div>
            <div class="swiper-slide">7个月</div>
            <div class="swiper-slide">8个月</div>
            <div class="swiper-slide">9个月</div>
            <div class="swiper-slide">10个月</div>
            <div class="swiper-slide">11个月</div>
            <div class="swiper-slide">12个月</div>
        </div>
    </div>
</div>

</body>
<script src='<?php echo (MOBILE); ?>/js/jquery-3.0.0.min.js'></script>
<script src="<?php echo (MOBILE); ?>/js/swiper.min.js"></script>
<script src="<?php echo (MOBILE); ?>/js/angular.min.js"></script>
<script src="<?php echo (MOBILE); ?>/js/index-publishTec.js"></script>
<script src='<?php echo (MOBILE); ?>/js/return.js'></script>
<script>
    function getMsg() {
        // 获取技术领域选中状态
        var li = $(".areas_main li");
        var lingyu_html;
        for(var i = 0;i < li.length ; i++){
            if( li.eq(i).hasClass('areas_selected') ){               
                 lingyu_html = li.eq(i).html();
            }
        };
        // 获取需提交的值
        var user_id = $("#user_id").val(),
            title = $("#title").val(),
            content = $("#content").val(),
            lingyu = lingyu_html,
            csd = $("input[name='price']:checked").val(),
            yfzq = $("#choose_html").html(),
            gsm = $("#company").val(),
            lxrxm = $("#people").val(),
            dhhm = $("#phone").val();

        var data = {
            user_id : user_id,
            title : title,
            content : content,
            jsly : lingyu,
            yfys : csd,
            yfzq : yfzq,
            gsm : gsm,
            lxrxm : lxrxm,
            dhhm:dhhm
        };
         //异步提交表单数据
         $.ajax({
             type: "post",
             url: '/index.php/Mobile/Article/add?channel=xq&type=1&iscopy=0',
             data: data,
             dataType: 'json',
             success: function (res) {
                 console.log(res);
             }
         })
    }


    var mySwiper = new Swiper('.swiper-container', {    
        initialSlide :1,     //初始化位置
        direction : 'vertical',
        slidesPerView : 3,//每组三个
        centeredSlides : true,//设定为true时，活动块会居中，而不是默认状态下的居左。
        slidesPerView : 'auto',
        // loopedSlides :8,
    });

    // 期限要求 
    $("#choose_html").on("click",function(){
        showUpBox('.slide-wrap');
    });

    $(".complete").on("click",function(){
        clickComplete(mySwiper,$(".swiper-slide"));
        closeUpBox('.slide-wrap');
        $("#choose_html").html(chooseHtml);
    });

    $('.mask').on("click",function(){
        closeUpBox('.slide-wrap');

    });

    var app = angular.module("publishTec",[]);
    app.controller("ctrlTec",function ($scope){
        $scope.status = "";
    　　$scope.count = 0;
    　　$scope.tolCount = function () {
    　　　　$scope.count =$scope.text.length;
    　　};    
    });






</script>
</html>