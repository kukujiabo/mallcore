<?php
namespace App\Exception;

/**
 * Poss异常类
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-11-30
 */
class PossException extends LogException {

  public function __construct($msg, $code, $orderNo = null) {

    parent::__construct($msg, $code, 'poss', $orderNo);
  
  }

}
