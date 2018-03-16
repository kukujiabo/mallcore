<?php
namespace App\Service\Message;

use App\Library\Sms;
use App\Service\System\ConfigSv;
use App\Service\BaseService;
use App\Service\Crm\MobileVerifyCodeSv;

/**
 * 短信服务
 *
 * @author Meroc Chen <398515393@qq.com 2017-12-01
 */
class SmsSv extends BaseService {

  /**
   * 发送验证短信
   *
   * @param string $mobile
   *
   * @return array $msg
   */
  public function sendVerify($mobile) {

    $code = MobileVerifyCodeSv::createCode($mobile); 

    $tpCode = ConfigSv::getConfigValueByKey('submail_tmp_code_verify');

    return Sms::sendSms($mobile, $tpCode, array('code' => $code));
  
  }

  /**
   * 发送消费通知短信
   *
   * @param string $mobiel
   * @param string $content
   *
   * @return array $msg
   */
  public function sendConsumptionNotice($mobile, $content) {

    $tpCode = ConfigSv::getConfigValueByKey('submail_tmp_code_consumption');

    return Sms::sendSms($mobile, $tpCode, array('money' => $content));
  
  }

}
