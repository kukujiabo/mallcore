<?php
namespace App\Library;

/**
 * http 请求类
 * @author Meroc Chen 2017-09-05
 */
class Http {

  /** http get 方法
   * @param string $url
   * @param array $data
   * @param array $header
   * @param string $agent
   * @param integer $timeout
   */
  public static function httpGet($url, $data = '', $header = '', $agent = '', $timeout = 3000) {

    return self::httpRequest($url, $data, $header, 'get', $agent, $timeout); 

  }

  /**
   * http post 方法
   * @param string $url
   * @param array $data
   * @param array $header
   * @param string $agent
   * @param integer $timeout
   * @param string $type
   */
  public static function httpPost($url, $data, $header = '', $agent = '', $timeout = 3000, $type = 'raw') {

    return self::httpRequest($url, $data, $header, 'post', $agent, $timeout, $type); 

  }

  /**
   * 发送http请求
   * @param string $url
   * @param array $data
   * @param array $header
   * @param string $method
   * @param string $agent
   * @param integer $timeout
   * @param string $type
   */
  public static function httpRequest(
    $url, 
    $data, 
    $header = '', 
    $method = 'get', 
    $agent = '',
    $timeout = 3000,
    $type = 'form'
  ) {

    //初始化curl
    $curl=curl_init();

    //get请求拼接参数
    if ($method == 'get' && is_array($data) && count($data) > 0) {

      $rawStr = http_build_query($data);
      
      if(!strpos($url, '?')) {

        $url .= '?';
      
      }
      
      if (strpos($url, '?') == (strlen($url) -1)) {
      
        $url .= $rawStr;
      
      } else if (strpos($url, '&') == (strlen($url) - 1)) {
      
        $url .= $rawStr;
      
      } else {
      
        $url .= '&' . $rawStr;
      
      }

    }

    //设置药访问的地址
    curl_setopt($curl, CURLOPT_URL, $url);

    //设置请求头部
    if ($header) {
    
      curl_setopt($curl, CURLOPT_HTTPHEADER , $header);

    } else {

      curl_setopt($curl, CURLOPT_HEADER, false);
    
    }

    // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 

    // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); 

    // 模拟用户使用的浏览器
    if ($agent) {

      curl_setopt($curl, CURLOPT_USERAGENT, $aget); 

    }

    // Post提交的数据包
    if ($method == 'post') {

      //设置post请求
      curl_setopt($curl, CURLOPT_POST, true);

      if ($type == 'form') { 

        //提交表单

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); 

      } else {

        //提交元数据

        if (is_array($data)) {        

          curl_setopt($curl, CURLOPT_POSTFIELDS, self::_buildPost($data)); 
        
        } else {

          curl_setopt($curl, CURLOPT_POSTFIELDS, $data); 
        
        }
      
      }
      
    }

    // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout); 

    // 获取的信息以文件流的形式返回
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 

    // 执行操作
    list($result, $status) = array(curl_exec($curl), curl_getinfo($curl), curl_close($curl)); 

    return $result;

  }

  /**
   * 封装post提交数据
   *
   * @param mixed $data
   *
   * @return mixed $data
   */
  private static function _buildPost($data) {

    if (is_array($data)) {

      return http_build_query($data); 

    }

    return $data;

  }

}
