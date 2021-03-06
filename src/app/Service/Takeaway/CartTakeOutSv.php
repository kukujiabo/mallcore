<?php
namespace App\Service\Takeaway;

use App\Service\BaseService;
use App\Interfaces\Takeaway\ICartTakeOut;
use App\Model\CartTakeOut;
use Core\Service\CurdSv;
use App\Service\Crm\UserSv;
use App\Service\Commodity\GoodsSv;
use App\Service\Commodity\GoodsSkuSv;
use App\Service\Shop\ShopSv;
use App\Service\Commodity\GoodsPriceMapSv;
use App\Service\Crm\MemberSv;
use PhalApi\Exception;

/**
 * 外卖购物车
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-15
 */
class CartTakeOutSv extends BaseService implements ICartTakeOut {

    use CurdSv;

    /**
     * 清空
     */
    public function cartEmpty($condition) {

        if ($condition['way'] == 1 && $condition['token']) {

            $info_user = UserSv::getUserByToken($condition['token']);

            $condition['buyer_id'] = $info_user['uid'];

        }

        unset($condition['token']);

        unset($condition['way']);

        $data['num'] = 0;

        return self::batchRemove($condition, $data);

    }

    /**
     * 获取详情
     */
    public function getDetail($condition) {

        if ($condition['way'] == 1 && $condition['token']) {

            $info_user = UserSv::getUserByToken($condition['token']);

            $condition['buyer_id'] = $info_user['uid'];

            unset($condition['token']);

        }

        unset($condition['way']);

        $list = CartTakeOut::queryList($condition, $condition['fields'], $condition['order'], 0, 1);

        return $list[0];

    }

    /**
     * 获取列表
     */
    public function getList($condition) {

        if ($condition['way'] == 1 && $condition['token']) {

            $info_user = UserSv::getUserByToken($condition['token']);

            $condition['buyer_id'] = $info_user['uid'];

            unset($condition['token']);

        }

        unset($condition['way']);

        $datas = self::all($condition, $condition['order']);

        //foreach($datas as $key => $data) {
        //
        //  $sku = GoodsSkuSv::findOne($data['sku_id']);

        //  $datas[$key]['price'] = $sku['price'];

        //  $datas[$key]['tax_off_price'] = $sku['tax_off_price'];
        //
        //}

        return $datas;

    }

    /**
     * 获取数量
     */
    public function getCount($condition) {

        if ($condition['way'] == 1 && $condition['token']) {

            $info_user = UserSv::getUserByToken($condition['token']);

            $condition['buyer_id'] = $info_user['uid'];

            unset($condition['token']);

        }

        $carts = self::all($condition);

        $count = 0;

        foreach($carts as $cart) {
        
          $count += $cart['num'];
        
        }

        return $count;

    }

    /**
     * 新增
     */
    public function addCart($data) {

      if ($data['way'] == 1 && $data['token']) {

          $info_user = UserSv::getUserByToken($data['token']);

          $data['buyer_id'] = $info_user['uid'];

          unset($data['token']);

      }

      $cityCode = $data['city_code'];

      unset($data['city_code']);

      unset($data['way']);

      $where_cart['goods_id'] = $where_goods['goods_id'] = $data['goods_id'];

      $where_goods['quantity'] = $data['num'];

      $info_goods = GoodsSv::verifyGoods($where_goods);

      $where_cart['buyer_id'] = $data['buyer_id'];

      $member = MemberSv::findOne(array('uid' => $data['buyer_id']));

      if ($data['sku_id']) {

          $where_cart['sku_id'] = $data['sku_id'];

          $info_sku_goods = GoodsSkuSv::findOne($data['sku_id']);

          $data['sku_name'] = $info_sku_goods['sku_name'];

          $info_goods['stock'] = $info_sku_goods['stock'];

          $priceRule = GoodsPriceMapSv::findOne(array(
          
            'city_code' => $cityCode,

            'sku_id' => $data['sku_id'],

            'user_level' => $member['member_level']
          
          ));

          $info_goods['price'] = $priceRule ? $priceRule['price'] : $info_sku_goods['price'];

          $info_goods['tax_off_price'] = $priceRule ? $priceRule['tax_off_price'] : $info_sku_goods['tax_off_price'];

          if ($info_sku_goods['picture']) {

              $info_goods['picture'] = $info_sku_goods['picture'];
              
          }

      }

      $info_cart = self::getDetail($where_cart);

      $data['goods_name'] = $info_goods['goods_name'];
      
      $data['price'] = $info_goods['price'];

      $data['tax_off_price'] = $info_goods['tax_off_price'];

      $data['goods_picture'] = $info_goods['thumbnail'];

      if ($info_cart) {

          $data['num'] += $info_cart['num'];

          GoodsSv::compare($data['num'], $info_goods['stock']);

          $data['cart_id'] = $info_cart['cart_id'];

          // 修改
          $info = self::updates($data);

      } else {

          if (!isset($data['shop_id'])) {
              
              $data['shop_id'] = $info_goods['shop_id'];
              
          }

          if (!isset($data['shop_name'])) {

              $where_shop['shop_id'] = $info_goods['shop_id'];

              $info_shop = ShopSv::getDetail($where_shop);
              
              $data['shop_name'] = $info_shop['shop_name'];

          }

          //$data['cart_id'] = rand(100000000, 999999999);

          return self::add($data);

      }

    }

    /**
     * 编辑
     */
    public function updates($data) {

        if ($data['way'] == 1 && $data['token']) {

            $info_user = UserSv::getUserByToken($data['token']);

            $condition['buyer_id'] = $info_user['uid'];

            unset($data['token']);

        }

        unset($data['way']);

        $where_cart['cart_id'] = $condition['cart_id'] = $data['cart_id'];

        unset($data['cart_id']);

        $info_cart = self::getDetail($where_cart);

        $where_goods['goods_id'] = $info_cart['goods_id'];

        $where_goods['quantity'] = $data['num'];

        $info_goods = GoodsSv::verifyGoods($where_goods);

        if (!isset($data['num']) && $data['totalizer_num']) {

            $data['num'] = '+' . $data['totalizer_num'];

            $num = $info_cart['num'] + $data['num'];

            unset($data['totalizer_num']);

        } else {

            $num = $data['num'];

        }

        GoodsSv::compare($num, $info_goods['stock']);
        
        return self::batchUpdate($condition, $data);

    }

    /**
     * 计算购物车商品总价
     * @param string $cart_id 购物车商品id（英文逗号隔开）
     * @return float $total_prices 订单商品总价
     */
    public function disposeGoods($cart_id, $cityCode = null, $memberLevel = null, $invoice = 0) {

        $cart_id_array = explode(',', $cart_id);

        $list_cart_goods = self::all(array('cart_id'=>$cart_id, 'num'=>'g|0'));

        if (count($cart_id_array) != count($list_cart_goods)) {

            throw new Exception('cart_id 错误，查不到购物车商品数据', 9001);

        }

        $total_prices = 0;

        foreach($list_cart_goods as $v) {

          $priceCondition = array(
          
            'user_level' => $memberLevel,

            'city_code' => $cityCode,

            'sku_id' => $v['sku_id']
          
          );

          $priceRule = GoodsPriceMapSv::findOne($priceCondition);

          if ($priceRule) {

            $total_prices += ($invoice ? $priceRule['tax_off_price'] : $priceRule['price']) * $v['num'];

          } else {
          
            $total_prices += ($invoice ? $v['tax_off_price'] : $v['price']) * $v['num'];
          
          }

        }

        return $total_prices;

    }

    /**
     * 验证购物车商品
     * @param string $cart_id 购物车商品id（英文逗号隔开）
     * @return int $buyer_id 买家id
     */
    public function verify($cart_id, $buyer_id) {

        $cart_id_array = explode(',', $cart_id);

        $list_cart_goods = self::all(array('cart_id'=>$cart_id, 'buyer_id'=>$buyer_id, 'num'=>'g|0'));

        if (count($cart_id_array) != count($list_cart_goods)) {

            throw new Exception('cart_id 错误，查不到购物车商品数据', 9001);

        }

        foreach($list_cart_goods as $v) {

            $where_goods = array();

            $where_goods['goods_id'] = $v['goods_id'];

            $info_goods = GoodsSv::findOne($where_goods);

            if ($v['sku_id']) {

                $where_goods['sku_id'] = $v['sku_id'];

                $info_sku_goods = GoodsSkuSv::findOne($where_goods);

                if ($info_sku_goods['active'] == 2) {

                    throw new Exception('商品'.$info_goods['goods_name'].'（'.$info_sku_goods['sku_name'].'）已下架', 9003);

                }

                $info_goods['stock'] = $info_sku_goods['stock'];

            }

            if ($info_goods['state'] == 0) {

                throw new Exception('商品'.$info_goods['goods_name'].'已下架', 9005);

            }

            if ($v['num'] > $info_goods['stock']) {

                throw new Exception("商品库存不足", 9004);
                
            }

        }

        return $total_prices;

    }

    /**
     * 删除购物车选中商品
     * @desc  删除购物车选中商品
     *
     * @return
     */
    public function removeSelectedGoods($params) {
    
      $ids['cart_id'] = $params['cart_id'];

      return self::batchRemove($ids);
    
    }

}
