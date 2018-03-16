<?php
namespace App\Library;

use Redis;

/**
 * 哈希 Redis 缓存
 */
class RedisClient {

  private static $redis;

  private function __construct() {
  
  }

  /**
   * 设置缓存内容
   * @param string $collection 集合名称
   * @param string $key        键值 
   * @param string $value      值
   */
  public static function set($collection, $key, $value) {

    $value = is_array($value) ? json_encode($value) : $value;

    $redis = self::getInstance();
  
    return $redis->hSet($collection, $key, $value);
  
  }

  /**
   * 获取值
   * @param string $collection
   * @param string $key
   */
  public static function get($collection, $key, $array = false) {

    $value = self::getInstance()->hGet($collection, $key);

    if (json_decode($value, $array)) {
    
      return json_decode($value, $array);
      
    } else {
    
      return $value;
    
    }

  }

  /**
   * 删除值
   * @param string $collection
   * @param string $key
   */
  public static function remove($collection, $key) {

    return self::getInstance()->hDel($collection, $key);
  
  }

  /**
   * 获取redis实例
   */
  public static function getInstance() {

    if(self::$redis) {

      return self::$redis;
    
    } else {
  
      $instance = new \Redis();

      $instance->connect(\PhalApi\DI()->config->get('redis.redis_host'), \PhalApi\DI()->config->get('redis.redis_port'));

      self::$redis = $instance;

      return self::$redis;

    }
  
  }

}
