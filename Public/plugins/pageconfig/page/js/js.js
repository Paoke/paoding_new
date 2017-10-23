
// 首页
  $(function(){
    $('.index_1 nav').on('click','li',function(ev){
      $('.index_1 nav li').removeClass('cur');
      $(this).addClass('cur');
      // $().removeClass();
      // $().eq($(this).index()).addClass();
    });
 });
// 分类
$(function(){

  $('.index_2 .sort').on('click','li',function(ev){
          $('.index_2 .sort li').removeClass('current');
          $(this).addClass('current');
          $('.index_2 .right_sort ul').removeClass('tab_show');
          $('.index_2 .right_sort ul').eq($(this).index()).addClass('tab_show');
    });
});

// 购物车
$(function(){
    $('.index_3 li i').click(function(event) {
        $(this).parent().parent().find('i').toggleClass('cur');
        if ($(this).hasClass('cur')) {$(this).parent().parent().find('.bot').css('display','block')}else{$(this).parent().parent().find('.bot').css('display','none')};
    });

});
// all
$(function(){
    $('.index_3 .all').click(function(event) {
        $(this).toggleClass('cur')
        if ($('.index_3 .all').hasClass('cur')) {$('.index_3 li i').addClass('cur')}else{$('.index_3 li i').removeClass('cur')};
        if ($('.index_3 li i').hasClass('cur')) {$('.index_3 .bot').css('display','block')}else{$('.index_3 .bot').css('display','none')};
    });

});


// footer
$(function(){
    $('footer').on('click','a',function(ev){
        $('footer a').removeClass('current');
        $(this).addClass('current');
        $('body .wrap').removeClass('tab_show');
        $('body .wrap').eq($(this).index()).addClass('tab_show');
        if ($('.index_2').hasClass('tab_show')) {$('body').css('background','#fff')} else{$('body').css('background','#efeff4')};
    });
});