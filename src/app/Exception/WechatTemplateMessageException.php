<?php
namespace App\Exception;

/**
 * 微信推送消息异常
 *
 * @author Meroc Chen <398515393@qq.com> 2018-01-17
 */
class WechatTemplateMessageException extends LogException {

  public function __construct($msg, $code, $aname) {
  
    parent::__construct($msg, $code, 'wechat_template_message', $aname);
  
  }

}
