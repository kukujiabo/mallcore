<?php
namespace App\Exception;

/**
 * 访问权限异常
 *
 * @author Meroc Chen<398515393@qq.com> 2017-12-02
 */
class AuthException extends LogException {

  public function __construct($msg, $code) {
  
    parent::__construct($msg, $code, 'auth', '');
  
  }

}
