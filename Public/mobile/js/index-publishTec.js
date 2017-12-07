// 监听输入框
$('.advice_text').keyup(function(){
    if( $(this).val().length>0 ){
        $(this).css("border-color","#1e1e1e");
    }else{
        $(this).css("border-color","#ccc");
    }
});

// 需求领域  单选
$(".areas_default").on("click",function(){
    $(this).addClass('areas_selected').removeClass('areas_default').siblings().addClass('areas_default').removeClass('areas_selected');
});

// 上拉框选择
var chooseHtml;
var mySwiper = new Swiper('#swiper-container1', {
    initialSlide :1,	 //初始化位置
    direction : 'vertical',
    slidesPerView : 3,//每组三个
    centeredSlides : true,//设定为true时，活动块会居中，而不是默认状态下的居左。
    slidesPerView : 'auto',
    // loopedSlides :8,
});
var mySwiper2 = new Swiper('#swiper-container-tec', {
    initialSlide :1,
    direction : 'vertical',
    slidesPerView : 3,
    centeredSlides : true,
    slidesPerView : 'auto',
});

// 合作方式选择
$("#choose_coopType").on("click",function(){
    showUpBox('#slide-wrap1');
});

// 技术成熟度选择
$("#choose_tec").on("click",function(){
    showUpBox('#slide-wrap2');
});

// 技术成熟度完成点击
$("#complete_tec").on("click",function(){
    clickComplete(mySwiper2,$("#swiper-container-tec .swiper-slide"));
    closeUpBox('#slide-wrap2');
    $("#choose_tecHtml").html(chooseHtml);
});

// 合作方式完成点击
$("#complete_coopType").on("click",function(){
    clickComplete(mySwiper,$("#swiper-container1 .swiper-slide"));
    closeUpBox('#slide-wrap1');
    $("#choose_coopHtml").html(chooseHtml);
});

$('.mask').on("click",function(){
    closeUpBox('#slide-wrap1,#slide-wrap2');
});

$(".cancle").on("click",function(){
    closeUpBox('#slide-wrap1,#slide-wrap2');
});


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
function clickComplete(mySwiperIndex,eleSwiper){
    var mouthIndex = mySwiperIndex.activeIndex;
    chooseHtml = eleSwiper.eq(mouthIndex).html();
}


