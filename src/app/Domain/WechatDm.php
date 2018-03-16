<?php
namespace App\Domain;

use App\Service\Wechat\WechatSv;

/**
 * 微信类
 * 
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-12-01
 */
class WechatDm {

  /**
   * 公众号消费推送
   */
  public function consumeSend($params) {
  
    return WechatSv::consumeSend($params);

  }

  /**
   * 微信公众号URL验证
   */
  public function wechatMessagePush($params) {
  
    return WechatSv::wechatMessagePush($params);

  }

}
