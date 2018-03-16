<?php
namespace App\Exception;

/**
 * 提领券异常类
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-11-30
 */
class CouponExchangeException extends LogException {

  public function __construct($msg, $code, $orderNo = null) {

    parent::__construct($msg, $code, 'couponExchange', $orderNo);
  
  }

}
