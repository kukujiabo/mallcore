<?php
namespace App\Service\CouponExchange;

use App\Service\BaseService;
use App\Interfaces\CouponExchange\ICouponExchangeGoods;
use App\Model\CouponExchangeGoods;
use Core\Service\CurdSv;

/**
 * 提领券商品接口
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-23
 */
class CouponExchangeGoodsSv extends BaseService implements ICouponExchangeGoods {

  use CurdSv;

}
