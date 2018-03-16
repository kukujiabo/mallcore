<?php
namespace App\Exception;

/**
 * 微信异常类
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-12-01
 */
class WechatException extends LogException {

  public function __construct($msg, $code, $relat = null) {

    parent::__construct($msg, $code, 'wechat', $relat);
  
  }

}
