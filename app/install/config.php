<?php
return [
    //产品配置
    'product_name'   => 'FindData Robot Client', //产品名称
    'company_website_domain' => 'https://finddata.io', //官方网址
    'website_domain' => 'https://github.com/finddataio', //产品网址
    'company_name'   => 'FindData Lab', //公司名称
    'original_table_prefix'  => 'fdr_', //默认表前缀

    // 默认跳转页面对应的模板文件
    'dispatch_success_tmpl'  => APP_COMMON_PATH . 'tpl' . DS . 'dispatch_jump.tpl',
    'dispatch_error_tmpl'    => APP_COMMON_PATH . 'tpl' . DS . 'dispatch_jump.tpl',
];