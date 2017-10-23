<?php
return array(
    'VIEW_PATH'       =>'./Template/default/pc/', // 改变某个模块的模板文件目录
    'DEFAULT_THEME'    =>'MedicineAlliance', // 模板名称
    'TMPL_PARSE_STRING'  =>array(
        '__STATIC__'     => '/Template/default/pc/MedicineAlliance/Static', // 增加新的image  css js  访问路径  后面给 php 改了
    ),
);
?>