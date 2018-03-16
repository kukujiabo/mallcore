<?php
namespace App\Domain;

use App\Service\Message\SmsSv;

/**
 * 短信发送
 *
 */
class SmsDm {

  /**
   * 发送验证码
   */
  public function sendVerify($data) {
  
    return SmsSv::sendVerify($data['mobile']);
  
  }

  /**
   * 发送消费通知
   */
  public function sendConsumptionNotice($data) {
  
    return SmsSv::sendConsumptionNotice($data['mobile'], $data['content']);
  
  }

}
