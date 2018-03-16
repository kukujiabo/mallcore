<?php
namespace App\Service\Takeaway;

use App\Service\BaseService;
use App\Model\OrderTakeOutGoodsData;
use Core\Service\CurdSv;
use PhalApi\Exception;

/**
 * 外卖订单商品视图类
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2018-01-19
 */
class OrderTakeOutGoodsDataSv extends BaseService {

    use CurdSv;

    public function all($data) {

        return OrderTakeOutGoodsData::all($data);

    }

}
