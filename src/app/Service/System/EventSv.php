<?php 

namespace App\Service\System;

use App\Service\BaseService;
use App\Interfaces\System\IEvent;
use App\Model\Event;
use Core\Service\CurdSv;

/**
 * 系统定义事件接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-20
 */
class EventSv extends BaseService implements IEvent {

    use CurdSv;

}
