<?php
namespace App\Domain;

use App\Service\Wechat\WechatSv;
use App\Service\Wechat\WechatUtilsSv;
use App\Service\Crm\UserSv;

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

  public function getMiniTempCode($params) {

    $user = UserSv::getUserByToken($params['token']);

    if ($user['qr_code']) {
    
      return $user['qr_code'];
    
    }

    $accessToken = WechatUtilsSv::getAccessToken('mini_access_token');
    
    $data = WechatUtilsSv::getMiniTempCode($accessToken, $user['uid'], 'pages/mall/mall');

    if ($data) {

      $updateData = array();
    
      $updateData['qr_code'] = $data;

      $updateData['token'] = $params['token'];

      $updateData['way'] = 1;

      UserSv::updates($updateData);

      return $data;
    
    } else {
    
      return 0;
    
    }

  }

}
