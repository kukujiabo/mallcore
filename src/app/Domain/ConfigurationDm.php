<?php
namespace App\Domain;

use App\Service\System\ConfigSv;

/**
 * 系统配置
 */
class ConfigurationDm {

  /**
   * 保存公众号配置信息
   */
  public function saveWxPubSv($params) {

    return ConfigSv::saveWxPubSv($params);
    
  }

  /**
   * 获取公众号配置信息
   */
  public function getWxPubSv($params) {
  
    return ConfigSv::getWxPubSv($params);
  
  }


}
