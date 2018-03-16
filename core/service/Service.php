<?php
namespace Core\Service;

class Service {

  protected static $_instance;

  public function __construct() {

  
  }

  /**
   * 重载静态方法
   *
   * @param string $method    被调用的函数名
   * @param array $arguments  被调用函数所需参数
   *
   */
  public static function __callStatic($method, $arguments) {

    $self = get_called_class();

    if (!$self::$_instance) {
    
      $self::$_instance = new $self();
    
    }

    try {

      return call_user_func_array([$self::$_instance, $method], $arguments);

    } catch(\Exception $e) {
    
      die('调用非法函数！');
    
    }
  
  }

}
