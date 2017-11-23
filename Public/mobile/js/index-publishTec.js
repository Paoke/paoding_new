// 监听输入框
$('.advice_text').keyup(function(){	
	if( $(this).val().length>0 ){
		$(this).css("border-color","#1e1e1e");
	}else{
		$(this).css("border-color","#ccc");
	}
});

// 需求领域
$(".areas_default").on("click",function(){
	if($(this).hasClass('areas_default')){
		$(this).addClass('areas_selected').removeClass('areas_default');
	}
	else{
		$(this).addClass('areas_default').removeClass('areas_selected');
	}
});

// 上拉框选择
// var inputNum;
var mouthHtml;
var mySwiper = new Swiper('.swiper-container', {	
	initialSlide :1,	 //初始化位置
	direction : 'vertical',
	slidesPerView : 3,//每组三个
	centeredSlides : true,//设定为true时，活动块会居中，而不是默认状态下的居左。
	slidesPerView : 'auto',
	// loopedSlides :8,
});

$("#choose_btn").on("click",function(){
	showUpBox('.slide-wrap');
});

$('.mask').on("click",function(){
	closeUpBox('.slide-wrap');
});

$(".cancle").on("click",function(){
	closeUpBox('.slide-wrap');
});

$(".complete").on("click",function(){
	clickComplete();
	closeUpBox('.slide-wrap');
	$("#choose_html").html(mouthHtml);
})

// 关闭上拉框
function closeUpBox(ele){
	$(ele).hide();
	$('.mask').hide();
	$(ele).css('transform','translate3d(0,0,0)');
}
// 显示上拉框
function showUpBox(ele){
	$(ele).show();
	$('.mask').show();
	$(ele).css('transform','translate3d(0,-320px,0)');
}
// 点击完成
function clickComplete(){
	var mouthIndex = mySwiper.activeIndex;		
	mouthHtml = $(".swiper-slide").eq(mouthIndex).html();
}


