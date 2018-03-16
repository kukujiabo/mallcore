<?php namespace App\Service\Takeaway;

use App\Service\BaseService;
use App\Model\OrderTakeOutData;
use Core\Service\CurdSv;
use PhalApi\Exception;
use App\Exception\ErrorCode;

/**
 * pos获取外卖订单视图
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2018-01-22
 */
class OrderTakeOutDataSv extends BaseService {

    use CurdSv;

    public function getList($condiitons, $order){

        return OrderTakeOutData::all($condiitons, $order);

    }

}
