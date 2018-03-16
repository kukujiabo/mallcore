<?php namespace App\Service\Takeaway;

use App\Service\BaseService;
use App\Model\OrderTakeOutLog;
use Core\Service\CurdSv;
use PhalApi\Exception;

/**
 * 外卖订单操作记录
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2018-01-15
 */
class OrderTakeOutLogSv extends BaseService {

    use CurdSv;

}
