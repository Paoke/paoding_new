<?php
return array(
    //'LOAD_EXT_CONFIG' => 'html',	// 加载其他自定义配置文件 html.php
    'URL_HTML_SUFFIX'   =>  '',
    'HTML_CACHE_ON'     =>   true, // 开启静态缓存
    'HTML_CACHE_TIME'   =>   60,   // 全局静态缓存有效期（秒）
    'HTML_FILE_SUFFIX'  =>   '.html', //设置静态缓存文件后缀
    //默认错误跳转对应的模板文件
    'TMPL_ACTION_ERROR' => 'Public:tpmsg',
    //默认成功跳转对应的模板文件
    'TMPL_ACTION_SUCCESS' => 'Public:tpmsg',
);
