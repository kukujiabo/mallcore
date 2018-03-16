<?php
namespace App\Service\CouponExchange;

use App\Service\BaseService;
use App\Service\CouponExchange\OrderCouponExchangeAddressGoodsSv;
use App\Service\Commodity\GoodsSv;
use App\Interfaces\CouponExchange\IOrderCouponExchangeAddress;
use App\Model\OrderCouponExchangeAddress;
use Core\Service\CurdSv;
use App\Exception\OrderCouponExchangeAddressException;
use PhalApi\Exception;
use App\Exception\ErrorCode;

/**
 * 提领券订单地址接口
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-12-04
 */
class OrderCouponExchangeAddressSv extends BaseService implements IOrderCouponExchangeAddress {

  use CurdSv;

}
