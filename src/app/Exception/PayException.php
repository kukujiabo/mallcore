<?php
namespace App\Exception;


/**
 * 支付异常类
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class PayException extends LogException {

  public function __construct($msg, $code, $orderNo = null) {

    parent::__construct($msg, $code, 'pay', $orderNo);
  
  }

}
