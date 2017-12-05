<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en" ng-app="demand_list">
<head>
    <meta charset="UTF-8">
    <title>需求</title>
    <meta name="description" content="庖丁科技众包服务平台携手国内外先进技术科研院所、顶级技术专家，以实现科技成果市场化为核心，为企业提供快速精准的需求匹配服务，从而实现企业以及科技资源的有效对接，帮助企业实现产业技术升级，助力先进技术完成产业化发展。" />
    <meta name="keywords" content="庖丁众包、智能技术、机械制造、健康医疗、材料科学、能源环保、生产流程优化"/>
    <meta name='viewport' content='user-scalable=no,width=750'>
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/common_new.css">
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/demand.css">
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/swiper.css">
</head>
<body ng-cloak ng-controller="demandListCtrl">
<input type="hidden" value="1" id="page"/>
<input type="hidden" value="7"  id="page_total"/>
<div class="demand_nav">
    <ul>
        <div class="swiper-container" style="overflow:visible">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <li style="margin-left:0;text-align: center;">全部</li>
                    <div class="sildeBlock"></div>
                </div>
                <div class="swiper-slide" ng-repeat="list in lists">
                    <li>{{list.cat_name}}</li>                
                </div>
            </div>
        </div>
    </ul> 
</div>

<div class="search clear">
    <p class="search_p fl">您当前选择的业务范围</p>
    <select class="fl" name="" id="">
        <option value="全部">全部</option>
        <option value="科研类">科研类</option>
        <option value="应用类">应用类</option>
        <option value="专利类">专利类</option>
        <option value="服务类">服务类</option>
    </select>
    <div class="inputDiv fr">
        <img src="<?php echo (MOBILE); ?>/images/icon-search-default.png" alt="">
        技术搜索
    </div>
</div>

<!-- 搜索框 -->
<div class="searching" style="display:none;">
    <div class="input_search">
        <img src="<?php echo (MOBILE); ?>/images/icon-search-default.png" alt="">
        <input class="tech_search" type="text" placeholder="技术搜索">
        <p class="click_search fr">点击搜索</p>
    </div>
</div>

<div class="wrap">
    <div class="main" ng-repeat="detail in details">
        <div class="section">
            <p class="sec_title clear">
                <span class="callForBids fl">【{{detail.hzxs}}】</span>
                <span class="materials fl">{{detail.title}}</span>
            </p>
            <p class="sec_content">{{detail.desc}}</p>
            <div class="sec_data clear">
                <div class="sec_data_left fl">
                    <div>
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
                <img ng-show="detail.xpyf=='是'" class="fr" src="<?php echo (MOBILE); ?>/images/icon-research.png" alt="">
            </div>
            <a href="/index.php/Mobile/Demand/detail">
                <div class="viewDetails clear">
                    <img class="fr" src="<?php echo (MOBILE); ?>/images/icon-right.png" alt="">
                    <span class="viewDetails_span fr">查看详情</span>
                </div>
            </a>
        </div>
        <div class="index_div"></div>
    </div>
</div>

<p class="advert">
    庖丁众包·专业科技服务平台
</p>
<!-- 底部导航 -->
<div class="nav">
    <a class="nav_option" href="/index.php/Mobile/Index/index">
        <img src="<?php echo (MOBILE); ?>/images/icon-tabbar-technology-default.png" alt="">
        <p>技术</p>
    </a>
    <a class="nav_option" href="">
        <img src="<?php echo (MOBILE); ?>/images/icon-tabbar-demand-selected.png" alt="">
        <p style="color:#ff971d;">需求</p>
    </a>
    <a class="nav_option" href="/index.php/Mobile/Activity/activity">
        <img src="<?php echo (MOBILE); ?>/images/icon-tabbar-activity-default.png.png" alt="">
        <p>活动</p>
    </a>
    <a class="nav_option" href="/index.php/Mobile/User/user_center">
        <img src="<?php echo (MOBILE); ?>/images/icon-tabbar-my-default.png" alt="">
        <p >我的</p>
    </a>
</div>
</body>
<script src='<?php echo (MOBILE); ?>/js/angular.min.js'></script>
<script src='<?php echo (MOBILE); ?>/js/jquery-3.0.0.min.js'></script>
<script src='<?php echo (MOBILE); ?>/js/swiper.min.js'></script>
<script>
    //var page = "";
    //var page_total = "";
    var app = angular.module("demand_list",[]);
    var code = "";
    app.controller("demandListCtrl",function ($scope,$http){  
        // 1.20.需求类别栏目
        $http({
            method:'GET',
            url:'/api.php/ChannelIndex/index/action/dataList/channel/xq/type/2',          
        }).then(function successCallback(response) {                      
                $scope.lists = response.data.data;                  
            }, function errorCallback(response) {
            });

        // 1.21 需求详情列表
        var data = {"page":"1","page_num":"10","order_field":"create_time","order_by":"DESC","category_id":"0","get_page":"true"};
        $http({
            method:'POST',
            data:data,
            url:'/api.php/ChannelIndex/index/action/dataList/channel/xq/type/1',   
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },    
            transformRequest: function(obj) {    
                var str = [];    
                for (var p in obj) {    
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));    
                }    
                return str.join("&");    
            }       
        }).then(function successCallback(response) {  
                // page = response.data.data.page.page; 
                // page_total = response.data.data.page.page_total; 

                //$scope.page=response.data.data.page.page;

                $scope.details = response.data.data.info;                
            }, function errorCallback(response) {
            });
    });

    $(window).scroll(function () {
            if ($(document).scrollTop() > ($(document).height() - $(window).height()) / 1.5) {
                var page=$("#page").val();
                var page_total=$("#page_total").val();
                //console.log(page);
                // console.log(page_total);
                if(page < page_total) {
           
                    var nextPage = parseInt(page)+1;
                    //console.log(nextPage)
                    var data = {"page":nextPage,"page_num":"10","order_field":"create_time","order_by":"DESC","category_id":"0","get_page":"true"};
                    // $http({
                    //     method:'POST',
                    //     data:data,
                    //     url:'/api.php/ChannelIndex/index/action/dataList/channel/xq/type/1',   
                    //     headers: { 'Content-Type': 'application/x-www-form-urlencoded' },    
                    //     transformRequest: function(obj) {    
                    //         var str = [];    
                    //         for (var p in obj) {    
                    //             str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));    
                    //         }    
                    //         return str.join("&");    
                    //     }       
                    // }).then(function successCallback(response) {  
                    //         page = response.data.data.page.page;  
                    //         var info = response.data.data.info;
                    //         for(var i = 0;i<info.length;i++){
                    //             code = 
                    //              '<div class="main">'+
                    //                  '<div class="section">'+
                    //                  '<p class="sec_title clear">'+
                    //                         '<span class="callForBids fl">【'+info[i].hzxs+'】</span>'+
                    //                         '<span class="materials fl">'+info[i].title+'</span>'+
                    //                  '</p>'+
                    //                  '<p class="sec_content">'+info[i].desc+'</p>'+
                    //                  '<div class="sec_data clear">'+
                    //                         '<div class="sec_data_left fl">'+
                    //                            ' <div>'+
                    //                                 '<img src="<?php echo (MOBILE); ?>/images/icon-search-type.png" alt="">'+
                    //                                 '<span class="sec_data_span">'+info[i].cat_name+'</span>'+
                    //                                 '<img src="<?php echo (MOBILE); ?>/images/icon-search-time.png" alt="">'+
                    //                                 '<span class="sec_data_span">'+info[i].yfzq+'</span>'+
                    //                                 '<img src="<?php echo (MOBILE); ?>/images/icon-search-scan.png" alt="">'+
                    //                                 '<span class="sec_data_span">'+info[i].clicks+'</span>'+
                    //                             '</div>'+
                    //                             '<p class="sec_data_p">'+
                    //                                 '发布时间: <span class="sec_data_span">'+info[i].create_time+'</span>'+
                    //                                 '投入预算：<span>'+info[i].yfys+'</span>'+
                    //                             '</p>'+
                    //                        ' </div>'+
                    //                         '<img class="fr" src="<?php echo (MOBILE); ?>/images/icon-research.png" alt="">'+
                    //                    ' </div>'+
                    //                     '<a href="/index.php/Mobile/Demand/detail">'+
                    //                        ' <div class="viewDetails clear">'+
                    //                            ' <img class="fr" src="<?php echo (MOBILE); ?>/images/icon-right.png" alt="">'+
                    //                            ' <span class="viewDetails_span fr">查看详情</span>'+
                    //                         '</div>'+
                    //                     '</a>'+
                    //                 '</div>'+
                    //                 '<div class="index_div"></div>'+
                    //              '</div>';
                    //         }
                    //         $('.wrap').append(code);                        
                           
                                  
                    //     }, function errorCallback(response) {
                    //     });
                    $.post("/api.php/ChannelIndex/index/action/dataList/channel/xq/type/1",data,function(response){
                       $("#page").val(response['data']['page']['page'])
                       //page = response['data']['page']['page']; 
                       console.log(page); 
                       var info = response['data']['info'];
                       for(var i = 0;i<info.length;i++){
                           code = code+
                            '<div class="main">'+
                                '<div class="section">'+
                                '<p class="sec_title clear">'+
                                       '<span class="callForBids fl">【'+info[i].hzxs+'】</span>'+
                                       '<span class="materials fl">'+info[i].title+'</span>'+
                                '</p>'+
                                '<p class="sec_content">'+info[i].desc+'</p>'+
                                '<div class="sec_data clear">'+
                                       '<div class="sec_data_left fl">'+
                                          ' <div>'+
                                               '<img src="<?php echo (MOBILE); ?>/images/icon-search-type.png" alt="">'+
                                               '<span class="sec_data_span">'+info[i].cat_name+'</span>'+
                                               '<img src="<?php echo (MOBILE); ?>/images/icon-search-time.png" alt="">'+
                                               '<span class="sec_data_span">'+info[i].yfzq+'</span>'+
                                               '<img src="<?php echo (MOBILE); ?>/images/icon-search-scan.png" alt="">'+
                                               '<span class="sec_data_span">'+info[i].clicks+'</span>'+
                                           '</div>'+
                                           '<p class="sec_data_p">'+
                                               '发布时间: <span class="sec_data_span">'+info[i].create_time+'</span>'+
                                               '投入预算：<span>'+info[i].yfys+'</span>'+
                                           '</p>'+
                                      ' </div>'+
                                       '<img class="fr" src="<?php echo (MOBILE); ?>/images/icon-research.png" alt="">'+
                                  ' </div>'+
                                   '<a href="/index.php/Mobile/Demand/detail">'+
                                      ' <div class="viewDetails clear">'+
                                          ' <img class="fr" src="<?php echo (MOBILE); ?>/images/icon-right.png" alt="">'+
                                          ' <span class="viewDetails_span fr">查看详情</span>'+
                                       '</div>'+
                                   '</a>'+
                               '</div>'+
                               '<div class="index_div"></div>'+
                            '</div>';
                       }
                       $('.wrap').append(code);              
                    })
                }
              
            }
        });

    // 轮播
    var mySwiper = new Swiper(".swiper-container",{
        freeMode : true,
        slidesPerView : 5,
        observer:true,//修改swiper自己或子元素时，自动初始化swiper 
        observeParents:true//修改swiper的父元素时，自动初始化swiper 
    });

    $(".demand_nav").on("click",".swiper-slide li",function(){
        var index = $(this).parent(".swiper-slide").index();
        var tranLeft = index*150;      
        $(".sildeBlock").css("transform","translateX("+tranLeft+"px)");
    });

    $(".inputDiv").on("click",function(){
        $(".search").hide();
        $(".searching").show();
    });



</script>
</html>