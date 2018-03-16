<?php
namespace App\Interfaces\System;

/**
 * 读取配置
 */
interface IConfig {

  /**
   * 1.根据模块获取配置项
   * @param string $module
   */
  public function getConfigByModule($module);

  /**
   * 2.根据key获取配置value
   * @param string $key
   */
  public function getConfigValueByKey($key);

}
