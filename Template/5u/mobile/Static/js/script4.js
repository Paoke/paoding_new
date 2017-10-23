$(function(){
	//实例化头部左右滑动菜单
	$(".swiper-slide").each(function(){
		var slideText = $(this).text();
		var slideX = slideText.length;
		var slideWidth = slideX * 36;
		$(this).width(slideWidth);
	})
	var swiper = new Swiper('.swiper-container', {
	    	slidesPerView : 'auto',
	  	});
	//形式调动位置
//	var sectionB3 = $(".index_sectionB3");
//	for(i=0;i<sectionB3.length;i++){
//		var sectionB3X = sectionB3.eq(i).text().length;
//		$(".index_sectionB2").eq(i).css("right",sectionB3X*23+130+"px")
//	}
	//点击搜索按钮
	$(".search").click(function(){
		$(".index_zhe").fadeIn(500);
		$(".index_search").css("transform","translateY(0)");
	})
	//点击分类选择下拉框
	$(".chevron-down").click(function(){
		$(".index_head").css("transform","translateY(-100%)");
		$(".index_xuanxiang").css("transform","translateY(0)");
	})
	$(".index_keep").click(function(){
		$(".index_head").css("transform","translateY(0)");
		$(".index_xuanxiang").css("transform","translateY(-100%)");
	})
	//遮罩层
	$(".index_zhe").click(function(){
		$(this).fadeOut(500);
		$(".index_search").css("transform","translateY(-100%)");
	})
	//搜索、取消按钮
	$("#search_cancel").click(function(){
		$(".index_zhe").fadeOut(500);
		$(".index_search").css("transform","translateY(-100%)");
	})
	//收藏
	$("#detaile_foot2").click(function(){
		$("#detaile_collection").fadeIn(500);
	})
	$("#detaile_collection").click(function(){
		$(this).fadeOut(500);
	})
	
	//分享
	$("#detaile_foot3").click(function(){
		$("#detaile_share").fadeIn(500);
	})
	$("#detaile_share").click(function(){
		$(this).fadeOut(500);
	})
	//头部分类点击切换效果
	$(".swiper-slide").on("click",function(){
		$(this).addClass("index_head_active");
		$(this).siblings().removeClass("index_head_active");
		var id = $(this).attr("data-href");
		$("#"+id).addClass("index_boy_active");
		$("#"+id).siblings().removeClass("index_boy_active");
		var dom = $("#"+id);
		loaded(dom);
	})
	//技术、需求列表页 循环实例化iscroll
	/*$(".swiper-slide").each(function(){
		var id = $(this).attr("data-href");
		var dom = $("#"+id);
		loaded(dom);
	})*/	
	/*var index_bodyB = $(".index_boy");
	for(i=0;i<index_bodyB.length;i++){
		$(".swiper-slide").eq(i).click(function(){
			
			index = $(this).index();
			$(this).addClass("index_head_active");
			$(this).siblings().removeClass("index_head_active");
			index_bodyB.eq(index).addClass("index_boy_active");
			index_bodyB.eq(index).siblings().removeClass("index_boy_active");
			loaded();
		})
	}*/
	detaile_head1L = $(".detaile_head1").width()+55;
	detaile_head2L = detaile_head1L+$(".detaile_head2").width();
	$(".detaile_head2").css("left",detaile_head1L+"px");
	$(".detaile_head3").css("left",detaile_head2L+"px");
	//绑定手机号不可点击
	
})

var myScroll,
	pullDownEl, 
	pullDownOffset,
	pullUpEl, 
	pullUpOffset,
	loadingEnd = true,	//加载完毕
	loadingEndBefore = true, //加载完毕之前
	generatedCount = 0;
function loaded(dom) {
	loadingEnd = true;
	loadingEndBefore = true;
	var id = $(dom).attr("id");
	pullDownEl = dom.find('.pullDown');
	pullDownOffset = pullDownEl.offsetHeight;
	pullUpEl = dom.find('.pullUp');	
	pullUpOffset = 30;
	myScroll = new iScroll(id, {
		preventDefault: false,
		scrollbars: true,
		mouseWheel: true,
		interactiveScrollbars: true,
		shrinkScrollbars: 'scale',
		fadeScrollbars: true,
		momentum: true,
		useTransition: true,
		topOffset: pullDownOffset,
		onRefresh: function () {
			if (pullDownEl.hasClass('loading')) {
				pullDownEl.className = '';
				pullDownEl.find('.pullDownLabel').text('Pull down to refresh...');}
			if (pullUpEl.hasClass('loading')) {
				pullUpEl.className = '';
				pullUpEl.find('.pullUpLabel').text('Pull up to load more...');
			}
			
			pullUpEl.css("display","none");
			document.getElementById("show").innerHTML="onRefresh: up["+pullUpEl.className+"],down["+pullDownEl.className+"],Y["+this.y+"],maxScrollY["+this.maxScrollY+"],minScrollY["+this.minScrollY+"],scrollerH["+this.scrollerH+"],wrapperH["+this.wrapperH+"]";
		},
		onScrollMove: function () {
			document.getElementById("show").innerHTML="onScrollMove: up["+pullUpEl.className+"],down["+pullDownEl.className+"],Y["+this.y+"],maxScrollY["+this.maxScrollY+"],minScrollY["+this.minScrollY+"],scrollerH["+this.scrollerH+"],wrapperH["+this.wrapperH+"]";
			if ( this.scrollerH < this.wrapperH && this.y < (this.minScrollY-pullUpOffset) || this.scrollerH > this.wrapperH && this.y < (this.maxScrollY - pullUpOffset) ) {
				pullUpEl.css("display","");
				pullUpEl.attr("class","flip");
				pullUpEl.find('.pullUpLabel').text('向上拉加载...');
			} 
			 if (this.scrollerH < this.wrapperH && this.y > (this.minScrollY-pullUpOffset) && pullUpEl.hasClass('flip') || this.scrollerH > this.wrapperH && this.y > (this.maxScrollY - pullUpOffset) && pullUpEl.hasClass('flip')) {
				pullUpEl.css("display","none");
				pullUpEl.attr("class","");
				pullUpEl.find('.pullUpLabel').text('Pull up to load more...');
			}
		},
		onScrollEnd: function () {
			document.getElementById("show").innerHTML="onScrollEnd: up["+pullUpEl.className+"],down["+pullDownEl.className+"],Y["+this.y+"],maxScrollY["+this.maxScrollY+"],minScrollY["+this.minScrollY+"],scrollerH["+this.scrollerH+"],wrapperH["+this.wrapperH+"]";
			 if (pullUpEl.hasClass('flip')) {
				pullUpEl.attr("class","loading");
				pullUpEl.find('.pullUpLabel').text('加载中...');
				if(!loadingEnd){	//如果已经加载完了
					loading_end(dom);
					return false;
				}
				if(loadingEndBefore)	//如果上一页已经加载完了
					pullUpAction(dom);	// Execute custom function (ajax call?)
			}
		}
		
	});
}
function loading_end(dom){
	dom.find('.pullUpLabel').text('数据加载完毕');
}

var supply_name = $("#supply_name");
var supply_phone = $("#supply_phone");
var supply_need = $("#supply_need");
var supply_yanzheng = $("#supply_yanzheng");
var checkName = false;
var checkPhone = false;
var checkNeed = false;
var checkYanzheng = false;


supply_name.blur(function(){
	var _s = this;
	var val = $(this).val();
	if(val.length==0){
    	$(this).css("border","3px solid #ff0000");
    	setTimeout(function(){
    		$(_s).css("border","1px solid #ff0000");
    	},500)
    	checkName = false;
	}else{
		$(_s).css("border","1px solid #cccccc");
		checkName = true;
	}
})
supply_need.blur(function(){
	var _s = this;
	var val = $(this).val();
	if(val.length==0){
    	$(this).css("border","3px solid #ff0000");
    	setTimeout(function(){
    		$(_s).css("border","1px solid #ff0000");
    	},500)
    	checkNeed = false;
	}else{
		$(_s).css("border","1px solid #cccccc");
		checkNeed = true;
	}
})
supply_yanzheng.blur(function(){
	var _s = this;
	var val = $(this).val();
	if(val.length==0){
    	$(this).css("border","3px solid #ff0000");
    	setTimeout(function(){
    		$(_s).css("border","1px solid #ff0000");
    	},500)
    	checkYanzheng = false;
	}else{
		$(_s).css("border","1px solid #cccccc");
		checkYanzheng = true;
	}
})
supply_phone.blur(function(){
	var _s = this;
	var phone = $(this).val();
	if(!(/^1(3|4|5|7|8)\d{9}$/.test(phone))){
    	$(this).css("border","3px solid #ff0000");
    	setTimeout(function(){
    		$(_s).css("border","1px solid #ff0000");
    	},500)
    	checkPhone = false;
	}else{
		$(_s).css("border","1px solid #cccccc");
		checkPhone = true;
	}
})

function check(){
	supply_name.blur();
	supply_need.blur();
	supply_phone.blur();
	supply_yanzheng.blur();	
}
var wait=60;
function time(o) { 
//	console.log(o);
	if (wait == 0) { 
		o.removeAttr("disabled"); 
		o.text("重新发送"); 
		wait = 60; 
	} else { 
		o.attr("disabled", true); 
		o.text("已发送(" + wait +"s"+ ")"); 
		wait--; 
		setTimeout(function() { 
			time(o) 
		}, 1000) 
	} 
}

//报错信息
function errorReturn(msg){
	if(msg.code == 300){
		$('#tips').html('温馨提示：缺少值').attr('style','color:red');
	}
	if(msg.code == 400){
		$('#tips').html('温馨提示：缺少参数').attr('style','color:red');
	}
	if(msg.code == 401){
		$('#tips').html('温馨提示：手机格式错误').attr('style','color:red');
		$('#phone').parent('div').addClass('has-error');
	}
	if(msg.code == 402){
		$('#tips').html('温馨提示：验证码过期').attr('style','color:red');
		$('#p_yzm').parent('div').addClass('has-error');
	}
	if(msg.code == 403){
		$('#tips').html('温馨提示：验证码错误').attr('style','color:red');
		$('#p_yzm').parent('div').addClass('has-error');
	}
	if(msg.code == 404){
		$('#tips').html('温馨提示：此号码已被注册').attr('style','color:red');
		$('#phone').parent('div').addClass('has-error');
	}
	if(msg.code == 405){
		$('#tips').html('温馨提示：此号码未注册').attr('style','color:red');
		$('#phone').parent('div').addClass('has-error');
	}
	if(msg.code == 406){
		$('#tips').html('温馨提示：密码错误，请重试').attr('style','color:red');
		$('#pwd').parent('div').addClass('has-error');
	}
	if(msg.code == 411){
		$('#tips').html('温馨提示：找不到该记录').attr('style','color:red');
	}
	if(msg.code == 444){
		$('#tips').html('温馨提示：发生错误').attr('style','color:red');
	}
	if(msg.code != 200){
		return false;
	}
}
/**添加数据
$.session.set('key', 'value')

删除数据
$.session.remove('key');

获取数据
$.session.get('key');

清除数据
$.session.clear();
**/
(function($){

$.session = {

    _id: null,

    _cookieCache: undefined,

    _init: function()
    {
        if (!window.name) {
            window.name = Math.random();
        }
        this._id = window.name;
        this._initCache();

        // See if we've changed protcols

        var matches = (new RegExp(this._generatePrefix() + "=([^;]+);")).exec(document.cookie);
        if (matches && document.location.protocol !== matches[1]) {
           this._clearSession();
           for (var key in this._cookieCache) {
               try {
               window.sessionStorage.setItem(key, this._cookieCache[key]);
               } catch (e) {};
           }
        }

        document.cookie = this._generatePrefix() + "=" + document.location.protocol + ';path=/;expires=' + (new Date((new Date).getTime() + 120000)).toUTCString();

    },

    _generatePrefix: function()
    {
        return '__session:' + this._id + ':';
    },

    _initCache: function()
    {
        var cookies = document.cookie.split(';');
        this._cookieCache = {};
        for (var i in cookies) {
            var kv = cookies[i].split('=');
            if ((new RegExp(this._generatePrefix() + '.+')).test(kv[0]) && kv[1]) {
                this._cookieCache[kv[0].split(':', 3)[2]] = kv[1];
            }
        }
    },

    _setFallback: function(key, value, onceOnly)
    {
        var cookie = this._generatePrefix() + key + "=" + value + "; path=/";
        if (onceOnly) {
            cookie += "; expires=" + (new Date(Date.now() + 120000)).toUTCString();
        }
        document.cookie = cookie;
        this._cookieCache[key] = value;
        return this;
    },

    _getFallback: function(key)
    {
        if (!this._cookieCache) {
            this._initCache();
        }
        return this._cookieCache[key];
    },

    _clearFallback: function()
    {
        for (var i in this._cookieCache) {
            document.cookie = this._generatePrefix() + i + '=; path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        }
        this._cookieCache = {};
    },

    _deleteFallback: function(key)
    {
        document.cookie = this._generatePrefix() + key + '=; path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        delete this._cookieCache[key];
    },

    get: function(key)
    {
        return window.sessionStorage.getItem(key) || this._getFallback(key);
    },

    set: function(key, value, onceOnly)
    {
        try {
            window.sessionStorage.setItem(key, value);
        } catch (e) {}
        this._setFallback(key, value, onceOnly || false);
        return this;
    },
    
    'delete': function(key){
        return this.remove(key);
    },

    remove: function(key)
    {
        try {
        window.sessionStorage.removeItem(key);
        } catch (e) {};
        this._deleteFallback(key);
        return this;
    },

    _clearSession: function()
    {
      try {
            window.sessionStorage.clear();
        } catch (e) {
            for (var i in window.sessionStorage) {
                window.sessionStorage.removeItem(i);
            }
        }
    },

    clear: function()
    {
        this._clearSession();
        this._clearFallback();
        return this;
    }

};

$.session._init();

})(jQuery);
