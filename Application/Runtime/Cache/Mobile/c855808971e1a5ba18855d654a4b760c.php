<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en" ng-app="detail_tec">
<head>
    <meta charset="UTF-8">
    <title>技术项目</title>
    <meta name="description" content="庖丁科技众包服务平台携手国内外先进技术科研院所、顶级技术专家，以实现科技成果市场化为核心，为企业提供快速精准的需求匹配服务，从而实现企业以及科技资源的有效对接，帮助企业实现产业技术升级，助力先进技术完成产业化发展。" />
    <meta name="keywords" content="庖丁众包、智能技术、机械制造、健康医疗、材料科学、能源环保、生产流程优化"/>
    <meta name='viewport' content='user-scalable=no,width=750'>
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/common_new.css">
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/index.css">
</head>
<body ng-controller="detail_tecCtrl">
<div class="mask" style="display:none"></div>

<div class="banner">
    <img ng-cloak ng-src="{{lists.lbxt}}" alt="">
</div>

<div class="share clear">
    <div class="share_left fl">
        <p class="title" ng-cloak>{{lists.title}}</p>
        <p class="tip">
            发布于 <span ng-cloak>{{lists.create_time}}</span>
            浏览  <span ng-cloak>{{lists.clicks}}</span>
        </p>
    </div>
    <div class="fr">
        <img src="<?php echo (MOBILE); ?>/images/icon-index-techdetail-share.jpg" alt="">
        <p class="tip">分享</p>
    </div>
</div>

<div class="index_project_data clear">
    <div class="data_section fl first_data">
        <p class="sec_num">合作形式</p>
        <p class="sec_status" ng-cloak>{{lists.hzxs}}</p>
        <p class="sec_line"></p>
    </div>
    <div class="data_section fl">
        <p class="sec_num">交付形式</p>
        <p class="sec_status" ng-cloak>{{lists.jfxs}}</p>
        <p class="sec_line"></p>
    </div>
    <div class="data_section fl">
        <p class="sec_num">合作价格</p>
        <p class="sec_status" ng-cloak>{{lists.hzjg}}</p>
    </div>
</div>
<div class="index_div"></div>

<div class="intro">
    <div class="intro_section clear">
        <p class="intro_left fl">技术领域</p>
        <p class="intro_right fr" ng-cloak>{{lists.lingyu}}</p>
    </div>

    <div class="intro_section clear">
        <p class="intro_left fl">成熟度</p>
        <p class="intro_right fr" ng-cloak>{{lists.csd}}</p>
    </div>

    <div class="intro_section clear">
        <p class="intro_left fl">应用行业</p>
        <p class="intro_right fr" ng-cloak>{{lists.yyxy}}</p>
    </div>

    <div class="intro_section clear">
        <p class="intro_left fl">专利证书</p>
        <p class="intro_right fr" ng-cloak>{{lists.zlzs}}</p>
    </div>

    <div class="intro_section clear">
        <p class="intro_left fl">联系方式</p>
        <p class="intro_right fr" id="getContackWay" style="color:#ff971d">获取联系方式</p>
    </div>

    <div class="getTelphone" style="display:none">
        <div class="intro_section clear">
            <p class="intro_left fl">联系人</p>
            <p class="intro_right fr" ng-cloak>{{lists.lxrxm}}</p>
        </div>

        <div class="intro_section clear">
            <p class="intro_left fl">手机号</p>
            <p class="intro_right fr" ng-cloak>{{lists.dhhm}}</p>
        </div>

        <div class="intro_section clear">
            <p class="intro_left fl">邮箱号</p>
            <p class="intro_right fr" ng-cloak>{{lists.dzyx}}</p>
        </div>
    </div>
</div>
<div class="index_div"></div>

<div class="tec_tab">
    <a href="#tip1" class="active"><p class="tab_p">技术讲述</p></a>
    <a href="#tip2"><p class="tab_p">技术优势</p></a>
    <a href="#tip3"><p class="tab_p">效果指标</p></a>
    <a href="#tip4"><p class="tab_p">应用案例</p></a>
    <div class="slideBlock"></div>
</div>

<a name="tip1">
    <div class="tec_main">
        <div class="tec_tit">技术详述</div>
        <div class="tec_content" ng-bind-html="lists.content|trustHtml"></div>
    </div>
</a>

<a name="tip2">
    <div class="tec_main">
        <div class="tec_tit">技术优势</div>
        <div class="tec_content" ng-bind-html="lists.jsys|trustHtml"></div>
    </div>
</a>

<a name="tip3">
    <div class="tec_main">
        <div class="tec_tit">效果指标</div>
        <div class="tec_content" ng-bind-html="lists.xgzb|trustHtml"></div>
    </div>
</a>

<a name="tip4">
    <div class="tec_main">
        <div class="tec_tit">应用案例</div>
        <div class="tec_content" ng-bind-html="lists.yyal|trustHtml"></div>
    </div>
</a>

<p class="advert">
    庖丁众包·专业科技服务平台
</p>

<div class="sec_return">
    <a onclick="goBack();">
        <img class="return_icon" src="<?php echo (MOBILE); ?>/images/icon-common-return.png" alt="">
    </a>
    <p class="collect" id="collect">收藏</p>
    <p class="collect" id="cancle" style="display:none;background:#ccc;">取消收藏</p>
</div>
</body>
<script src='<?php echo (MOBILE); ?>/js/jquery-3.0.0.min.js'></script>
<script src='<?php echo (MOBILE); ?>/js/angular.min.js'></script>
<script>

    var referrer = document.referrer;
    function GetQueryString(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)","i");
        var r = window.location.search.substr(1).match(reg);
        if (r!=null) return unescape(r[2]); return null;
    };     

    var data_id = GetQueryString('data_id');  
   
    var app = angular.module('detail_tec',[]);
    app.filter("trustHtml",function ($sce){
        return function(val) {
            return $sce.trustAsHtml(val);
        }
    })
    app.controller("detail_tecCtrl",function ($scope,$http){
        $http({
            method:'GET',
            params: {data_id:data_id},
            url:'/api.php/ChannelIndex/index/action/dataDetail/channel/js/type/1'
        }).then(function successCallback(response) {                    
                $scope.lists = response.data.data;                        
            }, function errorCallback(response) {
                console.log(response);
            });

        // 收藏
        $("#collect").on("click",function(){
            $http({
                method:'GET',                
                url:'/index.php/Mobile/Article/like?channel=js&id='+data_id+'&action=1'
            }).then(function successCallback(response) {                
                    $("#collect").hide();
                    $("#cancle").show();                     
                }, function errorCallback(response) {                   
                });
        });
        // 取消收藏
        $("#cancle").on("click",function(){
            $http({
                method:'GET',                
                url:'/index.php/Mobile/Article/like?channel=js&id='+data_id+'&action=0'
            }).then(function successCallback(response) {                   
                    $("#collect").show();
                    $("#cancle").hide();
                }, function errorCallback(response) {                   
                });
        });

    });   

  
     $(".tec_tab a").on("click",function(){
         var index = $(this).index();
         var tranX = index*188;
         $(".slideBlock").css("transform","translateX("+tranX+"px)");
         $(this).addClass('active').siblings().removeClass('active');
     });

     $("#getContackWay").on("click",function(){
         $(".getTelphone").show();
         $(this).parent().hide();
     });

     // 导航栏
     // 需修改的元素：dv、 body的padding-top值，赋为dv的高度
     $(function () {
         var ie6 = /msie 6/i.test(navigator.userAgent),
             dv = $('.tec_tab'), //活动元素
             st;
         dv.attr('otop', dv.offset().top); //存储原来的距离顶部的距离
         $(window).scroll(function () {
             // 监听滚动  nav字体颜色   四个锚点分别监听位置判断
             // console.log($(".tec_tit").offset().top - document.body.scrollTop);
             st = Math.max(document.body.scrollTop || document.documentElement.scrollTop);
             if (st >= parseInt(dv.attr('otop'))) {
                 if (ie6) {
                     //IE6不支持fixed属性，所以只能靠设置position为absolute和top实现此效果
                     dv.css({ position: 'absolute', top: st });
                 }
                 else if(dv.css('position') != 'fixed'){
                     dv.css({ 'position': 'fixed', 'top': 0,'left':'50%','margin-left':'-375px'});
                     $('body').css('padding-top','90px');
                 }
             } else if (dv.css('position') != 'relative'){
                 dv.css({ 'position': 'relative' });
                 $('body').css('padding-top','');
             }
         });
     });

    function goBack(){
        window.location.href=referrer;
    }



</script>
</html>