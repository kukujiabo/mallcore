<?php
/**
 * 统一初始化
 */

// 定义项目路径
defined('API_ROOT') || define('API_ROOT', dirname(__FILE__) . '/..');
// 引入composer
require_once API_ROOT . '/vendor/autoload.php';

// 时区设置
date_default_timezone_set('Asia/Shanghai');

// 引入DI服务
include API_ROOT . '/config/di.php';

//允许跨域请求
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-Token");

//socket不超时
//ini_set('default_socket_timeout', -1);

// 调试模式
if (\PhalApi\DI()->debug) {
    // 启动追踪器
    \PhalApi\DI()->tracer->mark();

    error_reporting(E_ALL);
    ini_set('display_errors', 'On'); 
}

\PhalApi\DI()->filter = "\\App\\Common\\AuthFilter";

// 翻译语言包设定
\PhalApi\SL('zh_cn');
