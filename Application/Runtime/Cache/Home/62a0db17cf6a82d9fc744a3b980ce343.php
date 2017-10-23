<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>5U</title>
<meta name="keywords" content="京墨5U">
<meta name="description" content="京墨5U">
<link type="text/css" href="/Public/home/css/css.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="/Public/home/css/style.css" />
<script type="text/javascript" src="/Public/home/js/jquery.js"></script>
<style type="text/css">
html,body{overflow-x: hidden !important;}
</style>
<script type="text/javascript">
$(function(){
  systole();
});

function systole(){
  if(!$(".history").length){
    return;
  }
  var $warpEle = $(".history-date"),
    $targetA = $warpEle.find("h2 a,ul li dl dt a"),
    parentH,
    eleTop = [];
  
  parentH = $warpEle.parent().height();
  $warpEle.parent().css({"height":59});
  
  setTimeout(function(){
    
    $warpEle.find("ul").children(":not('h2:first')").each(function(idx){
      eleTop.push($(this).position().top);
      $(this).css({"margin-top":-eleTop[idx]}).children().hide();
    }).animate({"margin-top":0}, 1600).children().fadeIn();

    $warpEle.parent().animate({"height":parentH}, 2600);

    $warpEle.find("ul").children(":not('h2:first')").addClass("bounceInDown").css({"-webkit-animation-duration":"2s","-webkit-animation-delay":"0","-webkit-animation-timing-function":"ease","-webkit-animation-fill-mode":"both"}).end().children("h2").css({"position":"relative"});
    
  }, 600);

  $targetA.click(function(){
    $(this).parent().css({"position":"relative"});
    $(this).parent().siblings().slideToggle();
    $warpEle.parent().removeAttr("style");
    return false;
  });
};
</script>
</head>

<body>
<!-- nav -->
<div class="nav_content" style="top:0;">
    <div class="nav_box">
        <nav>
            <div class="logo">
                <a class="" href="/index.php/Home/Index/index"><i></i>京墨5U<span>创建应用 不在烦恼</span></a>
            </div>
            <ul>
                <li><a href="/index.php/Home/Index/index">首页</a></li>
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
<!-- nav_end -->

<section class="refer_banner">
    <div class="pic">
        <img src="/Public/home/images/bgczx.png" alt="" />
        <div class="t_txt">
            <h4>24小时</h4>
            <p>免费提供面对面咨询服务</p>
            <a class="alert_btn" href="javascript:;">我要咨询</a>
        </div>
    </div>

</section>

  <section style="background:#fff;padding-top:50px;padding-bottom:440px;">
  <div class="wrap" style="padding-left:50px;">
  <div class="hd"> 
        <strong>发展历程</strong> 
        <div class="bor-bton"></div> 
     </div> 
   <div class="history">
    <div class="history-date">
      <ul>
        <h2 class="first">
          <a href="#nogo">2016年</a><img src="/Public/home/images/img05.png"  />
        </h2>
        <li class="green">
          <h3>1.06<span>2016</span></h3>
          <dl>
            <dt><span>2016年1月13日，广州京墨医疗科技有限公司LOGO成功入驻创新谷LOGO墙</span></dt>
          </dl>
        </li>
        <li>
          <h3>1.15<span>2016</span></h3>
          <dl>
            <dt><span>公司旗下产品“糖问”与十七家医院签署合作协议 </span></dt>
          </dl>
        </li>
        <li>
          <h3>2.04<span>2016</span></h3>
          <dl>
            <dt><span>获得广东医谷和上医养生种子轮融资。</span></dt>
          </dl>
        </li>
        <li>
          <h3>6.25<span>2016</span></h3>
          <dl>
            <dt><span>参加第八届中国（深圳）生物与生命科技创新创业大赛预选赛 </span></dt>
          </dl>
        </li>
        <li>
          <h3>7.10<span>2016</span></h3>
          <dl>
            <dt><span>顺利进入第三届“创青春”广东青年创新创业大赛复赛</span></dt>
          </dl>
        </li>
      </ul>
    </div>
    
    <div class="history-date">
      <ul>
        <h2 class="date02"><a href="#nogo">2015年</a></h2>
        <li class="green">
          <h3>12.29<span>2015</span></h3>
          <dl>
            <dt><span>入驻国家级创业孵化中心——中大创新谷</span></dt>
          </dl>
        </li>
        <li>
          <h3>&nbsp;&nbsp;<span>&nbsp;&nbsp;</span></h3>
          <dl>
            <dt>&nbsp;&nbsp;<span>发展历史</span></dt>
          </dl>
        </li>
      </ul>
    </div>
  </div>
  </div>
  </section>

<footer>
    <div class="wrap_box">
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
</footer>


<section class="alert_box">
    <div class="black"></div>
    <div class="price-box" id="price-box_2">
        <div class="ant-spin">
            <p>联系人姓名</p>
            <input type="text" name="1" value=""placeholder="请输入5-16位英文或者数字" />
        </div>
        <div class="ant-spin">
            <p>联系人手机号</p>
            <input type="text" name="1" value=""placeholder="请输入5-16位英文或者数字" />
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


<!-- 滚动条JS就放此处 -->
<script type="text/javascript" src="/Public/home/js/jquery.nicescroll.js"></script>
<script type="text/javascript" src="/Public/home/js/nicescroll.js"></script>

</body>
</html>
<script type="text/javascript">
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