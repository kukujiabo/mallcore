<?php
namespace App\Exception;

/**
 * 会员异常类
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-11-30
 */
class MemberException extends LogException {

  public function __construct($msg, $code, $orderNo = null) {

    parent::__construct($msg, $code, 'member', $orderNo);
  
  }

}
