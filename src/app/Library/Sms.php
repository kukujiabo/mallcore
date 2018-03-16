<?php
namespace App\Library;

use App\Service\System\ConfigSv;

/**
 * 短信管理类
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class Sms {

  public function sendSms($mobile, $tpCode, $vars) {
  
    $message_configs = array(

      'appid' => ConfigSv::getConfigValueByKey('submail_sms_appid'),

      'appkey' => ConfigSv::getConfigValueByKey('submail_sms_appkey'),

      'sign_type' => 'normal'

    );

    $submail = new \MESSAGEXsend($message_configs);

    $submail->setTo($mobile);

    $submail->SetProject($tpCode);

    foreach($vars as $key => $var) {

      $submail->AddVar($key, $var); 
    
    }

    $xsend = $submail->xsend();

    return $xsend;
  
  }

}
