<?php
namespace App\Service\Wechat;

use App\Service\BaseService;
use Core\Service\CurdSv;
use App\Interfaces\Wechat\IWechatPushMessage;

/**
 * 微信推送消息服务
 *
 * @author Meroc Chen <398515393@qq.com> 2018-01-08
 */
class WechatPushMessageSv extends BaseService implements IWechatPushMessage {

  use CurdSv;

}
