<?php
namespace App\Domain;

use App\Service\System\WxproPageConfigSv;

/**
 * 微信小程序页面配置
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-07
 */
class WxproPageConfigDm {

  /**
   * 读取页面配置
   */
  public function getCrmPageConfigs($data) {
  
    return WxproPageConfigSv::getCrmPageConfigs($data);
  
  }

  /**
   * 更新页面配置
   */
  public function updatePageConfigs($data) {
  
    return WxproPageConfigSv::updatePageConfigs($data);
  
  }

}
