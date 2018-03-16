<?php
namespace App\Service\CouponExchange;

use App\Service\BaseService;
use App\Service\CouponExchange\OrderCouponExchangeGoodsGoodsSv;
use App\Service\Commodity\GoodsSv;
use App\Interfaces\CouponExchange\IOrderCouponExchangeGoods;
use App\Model\OrderCouponExchangeGoods;
use Core\Service\CurdSv;
use App\Exception\OrderCouponExchangeGoodsException;
use PhalApi\Exception;
use App\Exception\ErrorCode;

/**
 * 提领券订单商品接口
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-12-04
 */
class OrderCouponExchangeGoodsSv extends BaseService implements IOrderCouponExchangeGoods {

  use CurdSv;

}
