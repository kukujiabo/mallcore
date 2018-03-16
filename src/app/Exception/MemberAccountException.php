<?php
namespace App\Exception;

/**
 * 会员帐户异常类
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-01
 */
class MemberAccountException extends LogException {

  public function __construct($msg, $code, $event) {
  
    return parent::__construct($msg, $code, 'member_account', $event);
  
  }


}
