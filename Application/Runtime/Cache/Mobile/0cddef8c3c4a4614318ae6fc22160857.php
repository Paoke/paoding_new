<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en"  ng-app="userAuthen">
<head>
    <meta charset="UTF-8">
    <title>申请认证</title>
    <meta name="description" content="庖丁科技众包服务平台携手国内外先进技术科研院所、顶级技术专家，以实现科技成果市场化为核心，为企业提供快速精准的需求匹配服务，从而实现企业以及科技资源的有效对接，帮助企业实现产业技术升级，助力先进技术完成产业化发展。" />
    <meta name="keywords" content="庖丁众包、智能技术、机械制造、健康医疗、材料科学、能源环保、生产流程优化"/>
    <meta name='viewport' content='user-scalable=no,width=750'>
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/common_new.css">
    <link rel="stylesheet" href="<?php echo (MOBILE); ?>/css/my.css">
</head>
<body ng-controller="myAuthen">
    <input type="hidden" id="id" value="<?php echo session('userId');?>" />
    <div class="mask" style="display:none;"></div>
    <div class="identify_tip">
        <p>认证信息提交成功</p>
        <a href="">两个工作日后通知认证结果</a>
    </div>
    <div class="apply_choose">
        <div class="apply_choice">
            <div class="apply_choosing apply_choice_company">公司</div>
            <div class="apply_choosing apply_choice_personal">个人</div>
        </div>
        <div class="apply_choice_cancle">取消</div>
    </div>
    <form class="" id="form-user-authen">
        <p class="apply_tit">申请认证</p>
        <p class="apply_tip">你当前未通过平台合格认证，请填写认证信息！</p>
        <div class="my_content">
            <a href="#">
                <div class="apply_content_box clear">
                    <span class='apply_word fl'>手机号</span>
                    <img  class='fr content_jt' src="<?php echo (MOBILE); ?>/images/icon-right2.png" alt="">
                    <input  ng-cloak class='apply_means fr' type="text" ng-value="user.mobile" readonly="readonly">
                </div>
            </a>

            <a href="/index.php/Mobile/User/idcard.html">
                <div class="apply_content_box chose clear">
                    <span class='apply_word fl'>身份证号</span>
                    <img  class='fr content_jt' src="<?php echo (MOBILE); ?>/images/icon-right2.png" alt="">
                    <input class='apply_means fr' type="text" name="idcard" readonly="readonly" ng-value="contents.idcard">
                </div>
            </a>

            <a href="/index.php/Mobile/User/email.html">
                <div class="apply_content_box clear">
                    <span class='apply_word fl'>电子邮箱</span>
                    <img  class='fr content_jt' src="<?php echo (MOBILE); ?>/images/icon-right2.png" alt="">
                    <input class='apply_means fr' type="text" name="email"  readonly="readonly" ng-value="contents.email" >
                </div>
            </a>

            <div id="choose_class" class="my_content">
                <div class="apply_content_box clear">
                    <span class='apply_word fl'>所属类别</span>
                    <img  class='fr content_jt' src="<?php echo (MOBILE); ?>/images/icon-right2.png" alt="">
                    <input id="chosed" class='apply_means fr' name="" type="text" value="必填" readonly="readonly">
                </div>
            </div>
            <input id="user_id" type="hidden" name="user_id" value="<?php echo session('userId');?>">
            <input id="company" type="hidden" name="company" ng-value="contents.company">
            <input id="job" type="hidden" id="job" ng-value="contents.job">
            <a href="/index.php/Mobile/User/gzly.html">
                <div class="apply_content_box clear">
                    <span class='apply_word fl'>关注领域</span>
                    <img  class='fr content_jt' src="<?php echo (MOBILE); ?>/images/icon-right2.png" alt="">
                    <input class='apply_means fr' type="text" name="gzly" readonly="readonly" ng-value="contents.gzly">
                </div>
            </a>

            <a href="/index.php/Mobile/User/yyhy.html">
                <div class="apply_content_box clear">
                    <span class='apply_word fl'>应用行业</span>
                    <img  class='fr content_jt' src="<?php echo (MOBILE); ?>/images/icon-right2.png" alt="">
                    <input class='apply_means fr' type="text" name="yyhy"  readonly="readonly" ng-value="contents.yyhy">
                </div>
            </a>
        <!-- </div> -->
        <a class="apply_form">提 交</a>
    </form>
</body>
<script src='<?php echo (MOBILE); ?>/js/jquery-3.0.0.min.js'></script>
<script src='<?php echo (MOBILE); ?>/js/return.js'></script>
<script src='<?php echo (MOBILE); ?>/js/angular.min.js'></script>
<script>
    var app = angular.module('userAuthen', []);

    app.controller('myAuthen', function($scope,$http) {
        $scope.contents = {
            idcard:'<?php echo ($arrData["idcard"]); ?>',
            email:'<?php echo ($arrData["email"]); ?>',
            company:'<?php echo ($arrData["company"]); ?>', 
            company:'<?php echo ($arrData["company"]); ?>', 
            job:'<?php echo ($arrData["job"]); ?>', 
            gzly:'<?php echo ($arrData["gzly"]); ?>', 
            yyhy:'<?php echo ($arrData["yyhy"]); ?>'
        };
        var id = $("#id").val();
        $http({
            method: 'GET',
            url: '/api.php/User/user_info/action/detail?id='+id,
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },    
            transformRequest: function(obj) {    
                var str = [];    
                for (var p in obj) {    
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));  
                }    
                return str.join("&");    
            } 
        }).then(function successCallback(response) {    
             $scope.user = response.data.data;
            }, function errorCallback(response) {
        });
    });

    $(document).ready(function(){
        if($('#company').val()!=''){
            $("#chosed").attr("value",'公司');
        }
    });    

    function close(eleStatus,transY){
        $('.apply_choose').css({'display':eleStatus});
        $('.mask').css({'display':eleStatus});
        var time = setTimeout(eleTransform, 10)
        function eleTransform(){
            $(".apply_choose").css('transform','translate3d(0,'+transY+',0)');
        };      
    };
    $('.mask').on("click",function(){
        close('none','0');
    });
    $(".apply_choice_cancle").on("click",function(){
        close('none','0');
    });

    $("#choose_class").on("click",function(){
        close('block','-320px');
    });

    $(".apply_choosing").on("click",function(){
        close('none','0');
        var _html = $(this).html();
        if(_html=='公司'){
            window.location.href='/index.php/Mobile/User/company.html';
        }
        $("#chosed").attr("value",_html);
        $('#company').val('');
        $('#job').val('');
    });
    // 提交后 identify_tip跟mask显示出现提示框
</script>
</html>