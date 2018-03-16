<?php
namespace App\Exception;

/**
 * 微信小程序页面配置异常
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-08
 */
class WxproPageConfigException extends LogException {

  const MODULE = 'Wxpro_page_config';

  public function __construct($msg, $code, $id) {

    parent::__construct($msg, $code, MODULE, $id);
  
  }

}
