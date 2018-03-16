<?php
namespace App\Service\Takeaway;

use App\Service\BaseService;
use App\Interfaces\Takeaway\IOrderTakeOutGoods;
use App\Model\OrderTakeOutGoods;
use Core\Service\CurdSv;
use App\Service\Commodity\GoodsSv;
use App\Service\Commodity\GoodsSkuSv;
use PhalApi\Exception;
use App\Service\Takeaway\CartTakeOutSv;

/**
 * 外卖订单商品
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-11
 */
class OrderTakeOutGoodsSv extends BaseService implements IOrderTakeOutGoods {

    use CurdSv;

    /**
     * 获取订单商品列表
     */
    public function getList($condition) {

        return self::all($condition, $condition['order']);

    }

    /**
     * 添加订单商品
     */
    public function addOrderGoods($data) {

      return self::add($data);

    }

    /**
     * 批量添加订单商品
     */
    public function addOrderGoodsAll($data) {

        $data_goods['uid'] = $data['uid'];

        $data_goods['order_take_out_id'] = $data['order_id'];

        $list_cart_goods = CartTakeOutSv::all(array('cart_id'=>$data['cart_id']));

        foreach ($list_cart_goods as $k => $v) {

            $data_goods['goods_id'] = $data_verify_goods['goods_id'] = $v['goods_id'];

            $data_goods['sku_id'] = $v['sku_id'];

            $data_goods['sku_name'] = $v['sku_name'];

            $data_verify_goods['quantity'] = $v['num'];

            if ($v['sku_id']) {

                $data_verify_goods['sku_id'] = $v['sku_id'];

                // 验证商品
                $info_goods = GoodsSkuSv::verifyGoods($data_verify_goods);

            } else {

                // 验证商品
                $info_goods = GoodsSv::verifyGoods($data_verify_goods);

            }

            $data_goods['goods_name'] = $v['goods_name'];

            $data_goods['price'] = $v['price'];

            $data_goods['cost_price'] = $info_goods['cost_price'];

            $data_goods['num'] = $v['num'];

            $data_goods['goods_money'] = $v['num'] * $v['price'];

            $data_goods['goods_picture'] = $v['goods_picture'];

            $data_goods['shop_id'] = $v['shop_id'];

            $data_goods_all[] = $data_goods;

        }

        return self::batchAdd($data_goods_all);

    }

}
