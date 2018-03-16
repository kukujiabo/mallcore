<?php
namespace App\Exception;

/**
 * 活动异常
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-27
 */
class EventException extends LogException {

  public function __construct($msg, $code, $event) {
  
    parent::__construct($msg, $code, 'event', $event);
  
  }

}
