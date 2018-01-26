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
