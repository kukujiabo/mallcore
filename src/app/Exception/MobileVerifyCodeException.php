<?php
namespace App\Exception;

/**
 * 验证码异常类
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-01
 */
class MobileVerifyCodeException extends LogException {

  public function __construct($msg, $code) {

    parent::__construct($msg, $code, 'mobile_verify_code', '');
  
  }

}
