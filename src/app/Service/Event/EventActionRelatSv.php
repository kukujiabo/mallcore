<?php

namespace App\Service\Event;

use App\Service\BaseService;
use App\Interfaces\Event\IEventActionRelat;
use App\Model\EventActionRelat;
use Core\Service\CurdSv;

/**
 * 事件操作关联接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-20
 */
class EventActionRelatSv extends BaseService implements IEventActionRelat {

    use CurdSv;

}
