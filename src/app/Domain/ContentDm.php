<?php
namespace App\Domain;

use App\Service\Text\ContentSv;

/**
 * 文本服务
 */
class ContentDm {

  /**
   * 获取小程序页面配置文本
   */
  public function getMiniPageText($params) {
  
    return ContentSv::getMiniPageText($params);
  
  }

}
