<?php
namespace App\Domain;

use App\Service\Crm\MobileVerifyCodeSv;

/**
 * 用户手机号验证
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-01
 */
class MobileVerifyCodeDm {

  /**
   * 验证手机验证码
   */
  public function checkCode($data) {
  
    return MobileVerifyCodeSv::checkVerifyCode($data['code'], $data['mobile']);
  
  }


}
