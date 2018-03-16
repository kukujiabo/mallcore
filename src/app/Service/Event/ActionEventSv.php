<?php
namespace App\Service\Event;

use App\Service\BaseService;
use App\Interfaces\Event\IActionEvent;
use Core\Service\CurdSv;

/**
 * 操作事件服务
 *
 * @author Meroc Chen <398515393@qq.com> 2017-11-21
 */
class ActionEventSv extends BaseService implements IActionEvent {

  use CurdSv;

}
