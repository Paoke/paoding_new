
$(function(){
	
	checkname=false;
	checkphone=false;
	checktask=false;
	
	//检查名字是否合法2-15位数字字母或汉字
	$('#nameEdit').on('blur',function(){
		if($(this).val().trim().match(/^[A-Za-z0-9\u4E00-\u9FFF]{2,15}$/g)){
			$('#nameDIV').attr('class','modal-input has-success has-feedback');
			$('#nameStatus').attr('class','glyphicon glyphicon-ok form-control-feedback');
			$('#nameStatus').css('display','inline');
			checkname=true;
		}else{
			$('#nameDIV').attr('class','modal-input has-error has-feedback');
			$('#nameStatus').attr('class','glyphicon glyphicon-remove form-control-feedback');
			$('#nameStatus').css('display','inline');
			checkname=false;
		}
	})	
	//电话输入框
	$('#phoneEdit').on('blur',function(){
		//console.log($(this).val().match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/g))
		if($(this).val().trim().match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[0-9]|18[0-9]|14[57])[0-9]{8}$/g) != null){
			$('#phoneDIV').attr('class','modal-input has-success has-feedback')
			$('#phoneStatus').attr('class','glyphicon glyphicon-ok form-control-feedback');
			$('#phoneStatus').css('display','inline');
			checkphone=true;
		}else{
			$('#phoneDIV').attr('class','modal-input has-error has-feedback');
			$('#phoneStatus').attr('class','glyphicon glyphicon-remove form-control-feedback');
			$('#phoneStatus').css('display','inline');
			checkphone=false;
		}
	})
	//需求输入框
	$('#taskEdit').on('blur',function(){
		if($(this).val().length>0&&$(this).val().length<=100){
			$('#taskDIV').attr('class','modal-input has-success has-feedback')
			$('#taskStatus').attr('class','glyphicon glyphicon-ok form-control-feedback');
			$('#taskStatus').css('display','inline');
			checktask=true;
		}else{
			$('#taskDIV').attr('class','modal-input has-error has-feedback');
			$('#taskStatus').attr('class','glyphicon glyphicon-remove form-control-feedback');
			$('#taskStatus').css('display','block');
			checktask=false;
		}
	})
	//提示字符数
	$('#taskEdit').on('keyup',function(){
		var num=100-$(this).val().length
		$('#tasktishi').css('display','block')
		$('#tasktishi').text('还可输入'+num+'字')
	})
	$("#btn").removeAttr("disabled");
	//提交按钮
	$('#btn').on('click',function(){
		$('#nameEdit').blur();//触发失去焦点事件
		$('#phoneEdit').blur();//触发失去焦点事件
		$('#taskEdit').blur();//触发失去焦点事件
		if(checkname&&checkphone&&checktask){
			$.ajax({
				type:'post',
				url:$('#Modal2').find('form').attr('action'),
				data:{
					'name':$('#nameEdit').val().trim(),
					'phone':$('#phoneEdit').val().trim(),
					'mess':$('#taskEdit').val().trim()
				},
				beforeSend:function(xhr){
					$("#btn").attr('disabled',"disabled");
				},
				success:function(result){
					 var arr=result.split(",");
					 	if(0==arr[1]){
					 		$('#nameEdit').val('');
							$('#phoneEdit').val('');
							$('#taskEdit').val('');
						window.location.reload();
					   }else{
						  // $("#btn").removeAttr("disabled");
					   }
					   
				},
				error:function(msg){
					console.log(msg)
				}
			})
		}
	})
	
		
})


/*公共函数*/
//trim	删除空格
String.prototype.trim=function(){
	return this.replace(/(^\s*)|(\s*$)/g,"");
}


//验证码倒计时
var wait=60;
function time(o) { 
	//console.log(wait)
	if (wait == 0) { 
		o.removeAttribute("disabled"); 
		o.value="重新发送"; 
		wait = 60; 
	} else { 
		o.setAttribute("disabled", true); 
		o.value="已发送(" + wait +"s"+ ")"; 
		wait--; 
		setTimeout(function() { 
			time(o) 
		}, 1000) 
	} 
}

//报错信息
function errorReturn(msg){
	var x = msg.code;
	switch(x){
		case 300:
			$('#tips').html('温馨提示：缺少值').attr('style','color:red');
			break;
		case 400:
			$('#tips').html('温馨提示：缺少参数').attr('style','color:red');
			break;
		case 401:
			$('#tips').html('温馨提示：手机格式错误').attr('style','color:red');
			break;
		case 402:
			$('#tips').html('温馨提示：验证码过期').attr('style','color:red');
			break;
		case 403:
			$('#tips').html('温馨提示：验证码错误').attr('style','color:red');
			break;
		case 404:
			$('#tips').html('温馨提示：此号码已被注册').attr('style','color:red');
			break;
		case 405:
			$('#tips').html('温馨提示：此号码未注册').attr('style','color:red');
			break;
		case 406:
			$('#tips').html('温馨提示：密码错误，请重试').attr('style','color:red');
			break;
		case 411:
			$('#tips').html('温馨提示：找不到该记录').attr('style','color:red');
			break;
		case 444:
			$('#tips').html('温馨提示：发生错误').attr('style','color:red');
			break;
	}
	if(x != 200){
		return false;
	}
}

//验证手机格式
function checkPhone2(i){
	if(i.val().trim().match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[0-9]|18[0-9]|14[0-9])[0-9]{8}$/g)!=null){
		return true
	}else{
		return false
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