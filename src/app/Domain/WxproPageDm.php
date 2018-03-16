<?php
namespace App\Domain;

use App\Service\System\WxproPageConfigSv;
use App\Service\System\WxproPageSv;

/**
 * 获取crm微信小程序页面配置
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-07
 */
class WxproPageDm {

  /**
   * 获取crm页面配置
   *
   */
  public function getCrmPageConfigs($data) {
  
    return WxproPageConfigSv::getCrmPageConfigs($data);
  
  }

  /**
   * 获取crm小程序页面和页面配置
   */
  public function getCrmPageBoundConfigs($data) {
  
    return WxproPageSv::getCrmPageBoundConfigs($data);
  
  }

  /**
   * 获取小程序页面列表
   */
  public function getPageList($data) {
  
    return WxproPageSv::getPageList($data);
  
  }

  /**
   * 添加小程序页面
   */
  public function add($data) {
  
    return WxproPageSv::addPage($data);

  }

}
