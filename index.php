<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// 定义应用目录
//header("Content-type: text/html; charset=utf-8");
if (version_compare(PHP_VERSION, '5.5', '<')) {
    die('PHP version is too low, at least need PHP 5.5, please upgrade PHP version!');
}

// 定义应用目录
define('APP_PATH', __DIR__ . '/app/');

// 定义应用目录
define('APP_COMMON_PATH', APP_PATH . 'common/');

// 定义应用目录
define('PUBLIC_PATH', '/public');

//上传文件目录
define('UPLOAD_PATH', __DIR__.'/public/uploads');

// 加载框架引导文件
require __DIR__ . '/thinkphp/start.php';

