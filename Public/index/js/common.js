// 美洽
(function(m, ei, q, i, a, j, s) {
    m[i] = m[i] || function() {
                (m[i].a = m[i].a || []).push(arguments)
            };
    j = ei.createElement(q),
            s = ei.getElementsByTagName(q)[0];
    j.async = true;
    j.charset = 'UTF-8';
    j.src = '//static.meiqia.com/dist/meiqia.js';
    s.parentNode.insertBefore(j, s);
})(window, document, 'script', '_MEIQIA');
_MEIQIA('entId', 10556);
_MEIQIA('withoutBtn');
_MEIQIA('init');
// 导航栏高亮
var urlStr = location.href;
// console.log(urlStr);
var reg = /([_][^/]+)$/;
$(".navigation-list a").each(function () {
    // 截取"-"之前的字段
    var index=$(this).attr('href').lastIndexOf("\/");
    var thisUrl = $(this).attr('href') .substring(index + 1, $(this).attr('href') .length).replace(reg, "");
    thisUrl = thisUrl.substring(0,1).toUpperCase()+thisUrl.substring(1);
    if ((urlStr + '/').indexOf(thisUrl) > -1 && thisUrl != '') {
        $(this).addClass('selected-link');
    } else {
        $(this).removeClass('selected-link');
    }
});

// 百度统计
var _hmt = _hmt || [];
(function() {
    var hm = document.createElement("script");
    hm.src = "https://hm.baidu.com/hm.js?f095b63fbc1984edb5ae1cef37dd08a6";
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(hm, s);
})();

//验证码发送倒计时
var wait=60;
function time(o) { 
//	console.log(o);
	if (wait == 0) { 
		o.removeAttr("disabled"); 
		o.val("重新发送"); 
		wait = 60;
	} else { 
		o.attr("disabled", true); 
		o.val("已发送(" + wait +"s"+ ")"); 
		wait--; 
		setTimeout(function() { 
			time(o) 
		}, 1000) 
	} 
};

// 取hash
function GetQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)","i");
    var r = window.location.search.substr(1).match(reg);
    if (r!=null) return unescape(r[2]); return null;
};

// 公共提示框
var tip = {
    tip_ct:"",
    tip_url:""
};
var tips = {
    addtips:function(tip_ct,tip_url){         
        var tipNode = '<div class="tipCommon" style="display:block">'+tip_ct+'</div>';
        $('body').append(tipNode);
        setTimeout(function(){
            $(".tipCommon").remove();
            if(tip_url){
                window.location.href = tip_url;
            };
        },1500);
        return false;
    }
};

// 导航下拉
$("#user_dropdown").on("mouseenter",function() {
   $(".nav_user").show();
});
$("#user_dropdown").on("mouseleave",function() {
   $(".nav_user").hide();
});

// 右侧导航
$("#show_phone").on("mouseenter",function() {
   $(".Bar_phone").show();
});
$("#show_phone").on("mouseleave",function() {
   $(".Bar_phone").hide();
});

// 底部导航
// $("#foot_phone").on("mouseenter",function() {
//    $(".Bar_phone2").show();
// });
// $("#foot_phone").on("mouseleave",function() {
//    $(".Bar_phone2").hide();
// });
$(".Login_close").on("click",function(){
  $(".mask").hide();
  $(".login_boxs").hide();
});



// 回到顶部
$("#go_top").on("click",function(){
     $('body,html').animate({scrollTop: 0},400);
});

// 意见反馈
var sgt = '<div class="suggestion" >'+
          '<div class="sug_tip">'+
          '<p>请填写反馈意见</p>'+
          '<p class="close">X</p>'+
          '</div>'+
          '<textarea class="tex" placeholder="问题描述大于10字或小于200字"></textarea>'+
          '<div>'+
          '<input class="sug_inp" type="text" placeholder="姓名" >'+
          '<input class="sug_inp" type="text" placeholder="手机号">'+
          '<input class="sug_in3" type="text" placeholder="验证码">'+
          '<input class="sug_inp3" type="button" value="获取验证码" >'+
          '</div>'+
          '<input class="sug_apply" type="button" value="提 交">'+
          '</div>';

$("#suggest").on("click",function(){
    $("body").append(sgt);
});
$("body").on("click",".close",function(){
    $(".suggestion").remove();
});
$("body").on("click",".sug_inp3",function(){
    time($('.sug_inp3'));
});

// 微信分享
  window._bd_share_config = {
    "common" : {
     "bdSnsKey" : {},
     "bdText" : "",
     "bdMini" : "2",
     "bdUrl" : window.location.href,
     "bdMiniList" : false,
     "bdPic" : "",
     "bdStyle" : "0", 
    },
    "share" : { "bdSize" : "32"}
  };
  with (document)
    0[(getElementsByTagName('head')[0] || body)
      .appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='
      + ~(-new Date() / 36e5)];

//退出登录
$("#logout").on("click",function() {
    $.ajax({
        url: '/api.php/User/logout',
        type: 'GET',
    });   
    window.location.href="/index.php/index/index/index.html";
});




