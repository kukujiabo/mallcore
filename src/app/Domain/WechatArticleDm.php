<?php
namespace App\Domain;

use App\Service\Wechat\WechatArticleSv;

/**
 * 获取微信公众号素材
 * 
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-12-20
 */
class WechatArticleDm {

  /**
   * 获取微信公众号素材
   */
  public function getMaterial($data) {

    return WechatArticleSv::getMaterial($data);
  
  }

}
