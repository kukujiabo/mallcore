<?php
namespace App\Exception;

/**
 * 优惠券异常
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-19
 */
class CouponException extends LogException {

  public function __construct($msg, $code, $couponCode = null) {

    parent::__construct($msg, $code, 'coupon', $couponCode);
  
  }

}
