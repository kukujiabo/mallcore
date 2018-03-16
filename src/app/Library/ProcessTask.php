<?php
namespace App\Library;

/**
 * 请求进程服务
 */
class ProcessTask {

  /**
   * 请求开启进程
   * @param array $data
   * @param string $uri
   * @param string $host
   * @param string $port
   */
  public static function startTask($data = [], $uri = "", $host = "",, $port = "") {

    $host = $host ? $host : \PhalApi\DI()->config->get('process.host');

    $port = $port ? $port : \PhalApi\DI()->config->get('process.port');

    $url = $host . '/' . $uri;

    try {

      $response = Http::get($url, $data);

      if ($response != 'received') {
      
        error_log('request_task_no_response', 3, \PhalApi\DI()->config->get('process.error_log_file'));
      
      }

    } catch (\Exception $e) {
    
        error_log($e->getMessage(), 3, \PhalApi\DI()->config->get('process.error_log_file'));
    
    }
  
  }

}
