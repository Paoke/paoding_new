<?php
		return array(
			'VIEW_PATH'       =>'./Template/default/mobile/', // 改变某个模块的模板文件目录
			'DEFAULT_THEME'    =>'company3', // 模板名称
		//	'TMPL_DETECT_THEME' => true, // 自动侦测模板主题
		//	'THEME_LIST' => 'new,company3', // 支持的模板主题项
			'TMPL_PARSE_STRING'  =>array(
		//                '__PUBLIC__' => '/Common', // 更改默认的/Public 替换规则
					'__STATIC__'     => '/Template/default/mobile/company3/Static', // 增加新的image  css js  访问路径  后面给 php 改了
			   ),
			   //'DATA_CACHE_TIME'=>60, // 查询缓存时间
			);
		?>