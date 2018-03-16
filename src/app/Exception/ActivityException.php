<?php
namespace App\Exception;

/**
 * 活动异常
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-24
 */
class ActivityException extends LogException {

  public function __construct($msg, $code, $aname) {
  
    parent::__construct($msg, $code, 'activity', $aname);
  
  }

}
