<?php
namespace App\Common; 

/**
 * 日志记录类 
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-13
 */
class Logs {

  /**
   * 错误日志
   *
   * @param string $class
   * @param string $content
   */
  public static function error($class, $content) {

    $date = date('Y-m-d');
  
    $path = $path ? $path : API_ROOT . "/logs/common/error.{$date}";

    $datetime = date('Y-m-d H:i:s');

    error_log("{$datetime} - {$class}: {$content}", 3, $path);
  
  }

  /**
   * 普通日志
   *
   * @param string $class
   * @param string $content
   */
  public static function record($class, $content) {

    $date = date('Y-m-d');
  
    $path = $path ? $path : API_ROOT . "/logs/common/record.{$date}";

    $datetime = date('Y-m-d H:i:s');

    error_log("{$datetime} - {$class}: {$content}", 3, $path);
  
  }

}
