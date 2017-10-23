<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>5U</title>
<meta name="keywords" content="京墨5U">
<meta name="description" content="京墨5U">
<link type="text/css" href="/Public/home/css/css.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="/Public/home/css/style.css" />
<link rel="stylesheet" href="/Public/home/css/jquery.fullPage.css">
<script type="text/javascript" src="/Public/home/js/jquery.js"></script>
<script src="/Public/home/js/jquery.fullPage.min.js"></script>
<script src="/Public/home/js/jquery.SuperSlide.js"></script>
<script>
    $(function(){
        $('#dowebok').fullpage({
            anchors: ['page1', 'page2', 'page3', 'page4','page5','page6','page7','page8','page9'],
            menu: '#menu',
            /*'navigation': true,
             'navigationPosition': 'right',*/
            //小点导航颜色
            afterLoad: function(anchorLink, index){
                if(index == 1){
                    $("#fp-nav li a span").css("background","#B0B0B0");
                    $("#fp-nav li a").removeClass("active")
                    $("#fp-nav li:eq(0) a").addClass("active");
                    $("#fp-nav li a.active span").css("background","#7BF1FE");
                    $(".nav_content").removeClass('show');
                }
                if(index == 2){
                    $("#fp-nav li a span").css("background","#B0B0B0");
                    $("#fp-nav li a").removeClass("active")
                    $("#fp-nav li:eq(1) a").addClass("active");
                    $("#fp-nav li a.active span").css("background","#E82B2B");
                    $(".nav_content").addClass('show');
                }
                if(index == 3){
                    $("#fp-nav li a span").css("background","#B0B0B0");
                    $("#fp-nav li a").removeClass("active")
                    $("#fp-nav li:eq(2) a").addClass("active");
                    $("#fp-nav li a.active span").css("background","#ED6E47");
                    $(".nav_content").addClass('show');
                }
                if(index == 4){
                    $("#fp-nav li a span").css("background","#B0B0B0");
                    $("#fp-nav li a").removeClass("active")
                    $("#fp-nav li:eq(3) a").addClass("active");
                    $("#fp-nav li a.active span").css("background","#019CE3");
                    $(".nav_content").addClass('show');
                }
                if(index == 5){
                    $("#fp-nav li a span").css("background","#B0B0B0");
                    $("#fp-nav li a").removeClass("active")
                    $("#fp-nav li:eq(4) a").addClass("active");
                    $("#fp-nav li a.active span").css("background","#089C4A");
                    $(".nav_content").addClass('show');
                }
                if(index == 6){
                    $("#fp-nav li a span").css("background","#B0B0B0");
                    $("#fp-nav li a").removeClass("active")
                    $("#fp-nav li:eq(5) a").addClass("active");
                    $("#fp-nav li a.active span").css("background","#E2BB0A");
                    $(".nav_content").addClass('show');
                }
                if(index == 7){
                    $("#fp-nav li a span").css("background","#B0B0B0");
                    $("#fp-nav li a").removeClass("active")
                    $("#fp-nav li:eq(6) a").addClass("active");
                    $("#fp-nav li a.active span").css("background","#641F89");
                    $(".nav_content").addClass('show');
                }
                if(index == 8){
                    $("#fp-nav li a span").css("background","#B0B0B0");
                    $("#fp-nav li a").removeClass("active")
                    $("#fp-nav li:eq(7) a").addClass("active");
                    $("#fp-nav li a.active span").css("background","#E52424");
                    $(".nav_content").addClass('show');
                }
                if(index == 9){
                    $("#fp-nav li a span").css("background","#B0B0B0");
                    $("#fp-nav li a").removeClass("active")
                    $("#fp-nav li:eq(8) a").addClass("active");
                    $("#fp-nav li a.active span").css("background","#E82B2B");
                    $(".nav_content").addClass('show');
                }

            }

        });
    });
</script>

</head>

<body>
<!-- nav -->
<div class="nav_content">
    <div class="nav_box">
        <nav>
            <div class="logo">
                <a class="" href="/index.php/Home/Index/index"><i></i>京墨5U<span>创建应用 不在烦恼</span></a>
            </div>
            <ul>
                <li class="active"><a href="/index.php/Home/Index/index">首页</a></li>
                <li><a href="javascript:;">产品</a></li>
                <li><a href="/index.php/Home/Trial/trialshow">试用</a></li>
                <li><a href="/index.php/Home/Consulting/consultingshow">咨询</a></li>
                <li><a href="/index.php/Home/Case/caseshow">案例</a></li>
                <li><a href="/index.php/Home/Help/helpshow">帮助</a></li>
            </ul>
            <div class="login">
                <a href="/index.php/Home/Index/login">登录</a>
                <a href="/index.php/Home/Index/register">注册</a>
            </div>
        </nav>
    </div>
</div>

<div id="dowebok">
    <!-- 1 -->
    <div class="section page_1">
        <section class="headerbg">
            <div class="logo_bg"><div class="logo_sh"></div></div>
            <div class="head_txt"></div>
            <div class="input_box">
                <input type="text" placeholder="请输入您的手机号"/>
                <a href="javascript:;">开始试用</a>
            </div>
            <div class="headText">
                <div class="hdtx3"><a href="#page2"></a></div>
            </div>
        </section>
    </div>

    <!-- 2 -->
    <div class="section page_2">
        <div class="content_box">
            <section class="banner_box">
                <div class="index_focus">
                    <a href="javascript:;" class="index_focus_pre" title="上一张">上一张</a>
                    <a href="javascript:;" class="index_focus_next" title="下一张">下一张</a>
                    <div class="bd">
                        <ul>
                            <li>
                                <a href="javascript:;" class="pic">
                                    <img class="pic" src="/Public/home/images/banner1.jpg" alt="">
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" class="pic">
                                    <img class="pic" src="/Public/home/images/banner2.jpg" alt="">
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" class="pic">
                                    <img class="pic" src="/Public/home/images/banner1.jpg" alt="">
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="slide_nav">
                        <a href="javascript:;"></a>
                        <a href="javascript:;"></a>
                        <a href="javascript:;"></a>
                    </div>
                </div>
                <script type="text/javascript">
                    $(document).ready(function(){

                        $(".index_focus").hover(function(){
                            $(this).find(".index_focus_pre,.index_focus_next").stop(true, true).fadeTo("show", 1)
                        },function(){
                            $(this).find(".index_focus_pre,.index_focus_next").fadeOut()
                        });

                        $(".index_focus").slide({
                            titCell: ".slide_nav a ",
                            mainCell: ".bd ul",
                            delayTime: 500,
                            interTime: 3500,
                            prevCell:".index_focus_pre",
                            nextCell:".index_focus_next",
                            effect: "fold",
                            autoPlay: true,
                            trigger: "click",
                        });

                    });
                </script>
            </section>
            <div class="bottom_news">
                <div>
                    <a href="javascript:;">[2016-11-30] 京墨5U正式上线</a>
                </div>
                <div>
                    <a href="javascript:;">[2016-11-30] 京墨5U正式上线</a>
                </div>
                <div>
                    <a href="javascript:;">[2016-11-30] 京墨5U正式上线</a>
                </div>
                <a href="/index.php/Home/Index/grow" class="more">更多></a>
            </div>
        </div>

        <a href="#page1" class="backTop"><img src="/Public/home/images/backtop1.png" width="42" height="42" /></a>
    </div>

    <!-- 3 -->
    <div class="section page_3">
        <section class="alway">
            <div class="warp_box">
                <h2>京墨5U,24小时让想法成为应用</h2>
                <div class="left"><div></div></div>
                <div class="right">
                    <ul>
                        <li>
                            <i></i>
                            <h3>上线时间无忧</h3>
                        </li>
                        <li>
                            <i></i>
                            <h3>开发成本无忧</h3>
                        </li>
                        <li>
                            <i></i>
                            <h3>产品体验无忧</h3>
                        </li>
                        <li>
                            <i></i>
                            <h3>运营维护无忧</h3>
                        </li>
                        <li>
                            <i></i>
                            <h3>技术指导无忧</h3>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <a href="#page1" class="backTop"><img src="/Public/home/images/backtop2.png" width="42" height="42" /></a>
    </div>

    <!-- 4 -->
    <div class="section page_4">
        <section class="alway">
            <div class="wrap_box">
                <ul>
                    <li>
                        <div class="icon_bg"></div>
                        <p>可自定义配置的模块</p>
                    </li>
                    <li>
                        <div class="icon_bg"></div>
                        <p>独立的后台管理</p>
                    </li>
                    <li>
                        <div class="icon_bg"></div>
                        <p>绑定独立的公司域名</p>
                    </li>
                    <li>
                        <div class="icon_bg"></div>
                        <p>海量的应用模板</p>
                    </li>
                    <li>
                        <div class="icon_bg"></div>
                        <p>零成本的试用体验</p>
                    </li>
                    <li>
                        <div class="icon_bg"></div>
                        <p>随心随地贴心的指导</p>
                    </li>
                </ul>
            </div>
        </section>
        <a href="#page1" class="backTop"><img src="/Public/home/images/backtop3.png" width="42" height="42" /></a>
    </div>

    <!-- 5 -->
    <div class="section page_5">
        <section class="alway">
            <div class="warp_box">
                <div class="left"><div></div></div>
                <div class="right">
                    <div><span>免费</span>面对面<p>技术咨询</p><a class="anima alert_btn" href="javascript:;">马上咨询</a></div>
                </div>
            </div>
        </section>
        <a href="#page1" class="backTop"><img src="/Public/home/images/backtop4.png" width="42" height="42" /></a>
    </div>

    <!-- 6 -->
    <div class="section page_6">
        <section class="alway">
            <div class="wrap_box">
                <div class="top">
                    <ul id="content_txt">
                        <li class="active">
                            <div class="cont_box">
                                <p>很好 很不错now1</p>
                            </div>
                            <div class="user">
                                <i><img src="/Public/home/images/user_pic1.png"/></i>
                                <h5>途盾 - 乐总</h5>
                            </div>
                        </li>
                        <li>
                            <div class="cont_box">
                                <p>很好 很不错now2</p>
                            </div>
                            <div class="user">
                                <i><img src="/Public/home/images/user_pic2.png"/></i>
                                <h5>鑫康服务 - 莫总</h5>
                            </div>
                        </li>
                        <li>
                            <div class="cont_box">
                                <p>很好 很不错now3</p>
                            </div>
                            <div class="user">
                                <i><img src="/Public/home/images/user_pic3.png"/></i>
                                <h5>广东医谷 - 谢总</h5>
                            </div>
                        </li>
                        <li>
                            <div class="cont_box">
                                <p> 很好 很不错now4</p>
                            </div>
                            <div class="user">
                                <i><img src="/Public/home/images/user_pic4.png"/></i>
                                <h5>中大创投 - 舒董</h5>
                            </div>
                        </li>
                        <li>
                            <div class="cont_box">
                                <p>很好 很不错now5</p>
                            </div>
                            <div class="user">
                                <i><img src="/Public/home/images/user_pic5.png"/></i>
                                <h5>中大创新谷 - 郑总</h5>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="bottom">
                    <div class="slideTxtBox2">
                        <div class="bd">
                            <div id="leftMarquee" class="infoList">
                                <div class="bdr">
                                    <ul>
                                        <li class="hceg li1"><img src="/Public/home/images/logo_1.png"/> </li>
                                        <li class="hceg li2"><img src="/Public/home/images/logo_2.png"/> </li>
                                        <li class="hceg li3"><img src="/Public/home/images/logo_3.png"/> </li>
                                        <li class="hceg li4"><img src="/Public/home/images/logo_4.png"/> </li>
                                        <li class="hceg li5"><img src="/Public/home/images/logo_5.png"/> </li>
                                    </ul>
                                </div>
                                <script type="text/javascript">
                                $("#leftMarquee").slide({mainCell:".bdr ul",effect:"leftMarquee",vis:5,interTime:40,autoPlay:true});</script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <a href="#page1" class="backTop"><img src="/Public/home/images/backtop5.png" width="42" height="42" /></a>
    </div>

    <!-- 7 -->
    <div class="section page_7">
        <section class="alway">
            <div class="wrap_box">
                <h2>立即试用 为创业加速</h2>
                <a href="javascript:;" class="speed alert_btn">马上体验</a>
                <div class="content_box">
                    <ul>
                        <li class="li_left">
                            <h4>联系我们</h4>
                            <ol>
                                <li>合作咨询：13760845833</li>
                                <li>代理加盟：13760845833</li>
                                <li>商邮箱务：lyp@gemmap.cn</li>
                                <li>联系地址：海珠区滨江东路550号中大创新谷</li>
                            </ol>
                        </li>
                        <li class="li_center">
                            <h4>关注我们</h4>
                            <div class="code">
                                <div class="fl"><img src="/Public/home/images/qrcode.png"alt="" /></div>
                                <div class="fr"><img src="/Public/home/images/qrcode_tw.png"alt="" /></div>
                            </div>
                        </li>
                        <li class="li_right">
                            <h4>更多</h4>
                            <ol>
                                <li><a href="javascript:;">产品</a></li>
                                <li><a href="/index.php/Home/Trial/trialshow">试用</a></li>
                                <li><a href="/index.php/Home/Consulting/consultingshow">咨询</a></li>
                                <li><a href="/index.php/Home/Case/caseshow">案例</a></li>
                                <li><a href="/index.php/Home/Help/helpshow">帮助</a></li>
                            </ol>
                        </li>
                    </ul>
                    <div class="end">广州京墨科技有限公司@2016丨苏icp备13020699号-7</div>
                </div>
            </div>
        </section>
        <a href="#page1" class="backTop"><img src="/Public/home/images/backtop6.png" width="42" height="42" /></a>
    </div>


</div>

<!-- 侧边小按钮 -->
<div id="fp-nav" style="color: rgb(0, 0, 0); margin-top: -83.5px;" class="right">
    <ul>
        <li>
            <a href="#page1" class="active"><span></span></a>
        </li>
        <li>
            <a href="#page2"><span></span></a>
        </li>
        <li>
            <a href="#page3"><span></span></a>
        </li>
        <li>
            <a href="#page4"><span></span></a>
        </li>
        <li>
            <a href="#page5"><span></span></a>
        </li>
        <li>
            <a href="#page6"><span></span></a>
        </li>
        <li>
            <a href="#page7"><span></span></a>
        </li>
    </ul>
</div>


<section class="alert_box">
    <div class="black"></div>
    <div class="price-box" id="price-box_2">
        <div class="ant-spin">
            <p>联系人姓名</p>
            <input type="text" name="1" value=""placeholder="请输入5-16位英文或者数字" />
        </div>
        <div class="ant-spin">
            <p>联系人手机号</p>
            <input id="phone_num" type="text" name="1" value=""placeholder="请输入5-16位英文或者数字" />
        </div>
        <div class="ant-spin">
            <p>对标系统</p>
            <input type="text" name="1" value=""placeholder="请输入5-16位英文或者数字" />
        </div>
        <div class="ant-row">
            <p>费用预算</p>
                <select name="" id="" class="option">
                <option value="10万内">10万内</option>
                <option value="15万内">15万内</option>
                <option value="25万内">25万内</option>
                <option value="50万内">50万内</option>
                <option value="50万内以上">50万内以上</option>
            </select>
        </div>
        <span>我们的攻城狮将在3个工作日内联系您，请保持电话畅通，谢谢</span>
        <button>提交需求</button>
    </div>
</section>

</body>
</html>

<script type="text/javascript">
   $(function(){
    $('.input_box a').click(function(event) {
        var input_val = $('.input_box input').val()
        if (input_val == "") {alert("请输入您的手机号")} else{
            $('#phone_num').val(input_val);
            $('.alert_box').addClass('on');
            $('.black').show();
        };
    });
   }) 


    $(function(){
        $('.li1').mouseenter(function(event) {
            $(this).addClass('current').siblings('li').removeClass('current')
           $('#content_txt li').removeClass('active')
            $('#content_txt li:eq(0)').addClass('active')
        });
        $('.li2').mouseenter(function(event) {
            $(this).addClass('current').siblings('li').removeClass('current')
            $('#content_txt li').removeClass('active')
            $('#content_txt li:eq(1)').addClass('active')
        });
         $('.li3').mouseenter(function(event) {
            $(this).addClass('current').siblings('li').removeClass('current')
            $('#content_txt li').removeClass('active')
            $('#content_txt li:eq(2)').addClass('active')
        });
          $('.li4').mouseenter(function(event) {
            $(this).addClass('current').siblings('li').removeClass('current')
            $('#content_txt li').removeClass('active')
            $('#content_txt li:eq(3)').addClass('active')
        });
           $('.li5').mouseenter(function(event) {
            $(this).addClass('current').siblings('li').removeClass('current')
            $('#content_txt li').removeClass('active')
            $('#content_txt li:eq(4)').addClass('active')
        });

    })

    // ---
     $(function(){
        $('.alert_btn').click(function(event) {
            $('.alert_box').addClass('on')
            $('.black').show()
            $('body').css('height','100%')
            $('body').css('overflow','hidden')
        });
        $('.black').click(function(event) {
            $('.alert_box').removeClass('on')
            $(this).hide()
            $('body').css('height','auto')
            $('body').css('overflow','auto')
        });
    })
</script>