<?php
namespace App\Exception;

/**
 * 用户异常类
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-11-30
 */
class UserException extends LogException {

  public function __construct($msg, $code, $orderNo = null) {

    parent::__construct($msg, $code, 'user', $orderNo);
  
  }

}
