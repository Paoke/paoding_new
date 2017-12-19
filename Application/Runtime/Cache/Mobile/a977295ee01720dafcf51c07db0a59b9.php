<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en" ng-app="detail">
<head>
    <meta charset="UTF-8">
    <title>需求详情</title>
    <meta name="description" content="庖丁科技众包服务平台携手国内外先进技术科研院所、顶级技术专家，以实现科技成果市场化为核心，为企业提供快速精准的需求匹配服务，从而实现企业以及科技资源的有效对接，帮助企业实现产业技术升级，助力先进技术完成产业化发展。" />
    <meta name="keywords" content="庖丁众包、智能技术、机械制造、健康医疗、材料科学、能源环保、生产流程优化"/>
    <meta name='viewport' content='user-scalable=no,width=750'>
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/common_new.css">
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/demand.css">
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/my.css">
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/swiper.css">
</head>
<body ng-controller="detailCtrl">
<div class="main">
    <div class="section">
        <p class="sec_title clear">
            <span class="callForBids fl">【{{detail.hzxs}}】</span>
            <span class="materials fl">{{detail.title}}</span>
        </p>

        <div class="sec_data clear">
            <div class="sec_data_left fl">
                <div>
                    <p class="sec_data_num">需求编号:{{detail.id}}</p>
                    <img src="<?php echo (MOBILE); ?>/images/icon-search-type.png" alt="">
                    <span class="sec_data_span">{{detail.cat_name}}</span>
                    <img src="<?php echo (MOBILE); ?>/images/icon-search-time.png" alt="">
                    <span class="sec_data_span">{{detail.yfzq}}</span>
                    <img src="<?php echo (MOBILE); ?>/images/icon-search-scan.png" alt="">
                    <span class="sec_data_span">{{detail.clicks}}</span>
                </div>
                <p class="sec_data_p">
                    发布时间: <span class="sec_data_span">{{detail.create_time}}</span>
                    投入预算：<span>{{detail.yfys}}</span>
                </p>
            </div>
            <img class="fr" src="<?php echo (MOBILE); ?>/images/icon-research.png" alt="">
        </div>
    </div>
    <div class="index_div"></div>
</div>

<div class="apply_content_box chose clear">
    <span class='apply_word fl'>合作方式</span>
    <input class='apply_means fr' type="text" ng-value="{{detail.hzfs}}" readonly="readonly">
</div>

<!-- 获取联系方式 -->
<p class="getConWay">获取联系方式</p>
<!-- 未认证时 getTelphoto 不可见 -->
<div class="getTelphoto" style="display:none">
    <div class="apply_content_box chose clear">
        <span class='apply_word fl'>联系人</span>
        <input class='apply_means fr' type="text" ng-value="{{detail.lxrxm}}" readonly="readonly">
    </div>
    <div class="apply_content_box chose clear">
        <span class='apply_word fl'>手机号</span>
        <input class='apply_means fr' type="text" ng-value="{{detail.dhhm}}" readonly="readonly">
    </div>
    <div class="apply_content_box chose clear">
        <span class='apply_word fl'>邮箱</span>
        <input class='apply_means fr' type="text" ng-value="
        {{detail.dzyx}}" readonly="readonly">
    </div>
    <div class="apply_content_box chose clear">
        <span class='apply_word fl'>企业名称</span>
        <input class='apply_means fr' type="text" ng-value="
       {{detail.gsm}}" readonly="readonly">
    </div>
</div>
<div class="index_div"></div>

<div class="demand_main">
    <div class="demand_main_tit clear">
        <div class="black_block fl"></div>
        需求讲述
    </div>
    <p ng-bind-html="detail.content|trustHtml"></p>
</div>
<p class="advert">
    庖丁众包·专业科技服务平台
</p>
<div class="sec_return">
    <a onclick="javascript:history.go(-1);">
        <img class="return_icon" src="<?php echo (MOBILE); ?>/images/icon-common-return.png" alt="">
    </a>
    <p class="collect">收藏</p>
</div>
</body>
<script src='<?php echo (MOBILE); ?>/js/jquery-3.0.0.min.js'></script>
<script src='<?php echo (MOBILE); ?>/js/angular.min.js'></script>
<script>
    $(".getConWay").on("click",function(){
        $(this).hide();
        $(".getTelphoto").show();
    })

    function GetQueryString(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)","i");
        var r = window.location.search.substr(1).match(reg);
        if (r!=null) return unescape(r[2]); return null;
    };
    var data_id = GetQueryString("data_id");

    var app = angular.module("detail",[]);
    app.filter('trustHtml',function ($sce){
        return function(val) {
            return $sce.trustAsHtml(val);
        }
    });
    app.controller("detailCtrl",function ($scope,$http){
        $http({
            method:'GET',
            params:{data_id:data_id},  
            // 1.25.获取需求详情接口
            url:'/api.php/ChannelIndex/index/action/dataDetail/channel/xq/type/1',
        }).then(function successCallback(response){       
          $scope.detail = response.data.data;
          console.log($scope.detail.lxrxm);
        },function errorCallback(){          
        });
    });


</script>
</html>