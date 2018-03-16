<?php
namespace App\Exception;

/**
 * 外卖订单异常
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2018-01-15
 */
class OrderTakeOutException extends LogException {

  public function __construct($msg, $code, $couponCode = null) {

    parent::__construct($msg, $code, 'order_take_out', $couponCode);
  
  }

}
