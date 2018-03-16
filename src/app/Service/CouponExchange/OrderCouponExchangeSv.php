<?php
namespace App\Service\CouponExchange;

use App\Service\BaseService;
use App\Service\Commodity\GoodsSv;
use App\Interfaces\CouponExchange\IOrderCouponExchange;
use App\Model\OrderCouponExchange;
use Core\Service\CurdSv;
use App\Exception\OrderCouponExchangeException;
use PhalApi\Exception;
use App\Exception\ErrorCode;
use App\Service\Crm\UserSv;
use App\Service\CouponExchange\CouponExchangeSv;
use App\Service\CouponExchange\CouponExchangeGoodsSv;
use App\Service\CouponExchange\OrderCouponExchangeGoodsSv;
use App\Service\CouponExchange\OrderCouponExchangeAddressSv;
use App\Service\Crm\MemberExpressAddressSv;

/**
 * 提领券订单接口
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-12-04
 */
class OrderCouponExchangeSv extends BaseService implements IOrderCouponExchange {

  use CurdSv;

  // 添加提领券订单
  public function addOrderCouponExchange ($data) {

    $address_id = $data['address_id'];

    // 获取用户信息
    $info_user = UserSv::getUserByToken($data['token']);

    $data['owner_id'] = $info_user['uid'];

    unset($data['token']);

    unset($data['address_id']);
    
    // 验证提领券
    $info_coupon_exchange = CouponExchangeSv::cancelVerify($data);

    $info_address = MemberExpressAddressSv::getAddressDetails(array('address_id'=>$address_id, 'uid'=>$info_user['uid']));

    // 验证收货地址
    if (!$info_address) {

      throw new Exception("找不到收货地址", 1);
      
    }

    $where_coupon_exchange_goods['coupon_exchange_id'] = $info_coupon_exchange['id'];

    // 获取提领券兑换的商品
    $info_coupon_exchange_goods = CouponExchangeGoodsSv::findOne($where_coupon_exchange_goods);

    if (!$info_coupon_exchange_goods) {

      throw new Exception("未找到提领券商品", 1);
      
    }

    $where_goods['goods_id'] = $info_coupon_exchange_goods['goods_id'];

    // 获取商品信息
    $info_goods = GoodsSv::findOne($where_goods);

    if (!$info_goods) {

      throw new Exception("未找到提领券商品信息", 1);
      
    }

    $data_order_coupon_exchange['buyer_message'] = $data['buyer_message'];

    $data_order_coupon_exchange['buyer_id'] = $info_user['uid'];

    $data_order_coupon_exchange['user_name'] = $info_user['nick_name'];

    $data_order_coupon_exchange['sn'] = self::createOrderNo();

    $data_order_coupon_exchange['create_time'] = date("Y-m-d H:i:s");

    $data_order_coupon_exchange['goods_money'] = $info_goods['price'];

    $data_order_coupon_exchange['coupon_exchange_id'] = $info_coupon_exchange['id'];

    $data_order_coupon_exchange['coupon_exchange_money'] = $info_goods['price'];

    $data_order_coupon_exchange['shipping_money'] = 0;

    $data_order_coupon_exchange['order_money'] = $data_order_coupon_exchange['goods_money'] + $data_order_coupon_exchange['shipping_money'];

    $data_order_coupon_exchange['pay_money'] = $data_order_coupon_exchange['order_money'] - $data_order_coupon_exchange['coupon_exchange_money'];

    // 添加提领券订单
    $order_coupon_exchange_id = self::add($data_order_coupon_exchange);

    if (!$order_coupon_exchange_id) {

      throw new Exception("下单失败", 1);
      
    }

    $data_coupon_exchange['id'] = $info_coupon_exchange['id'];

    $data_coupon_exchange['status'] = 2;

    $data_coupon_exchange['cancel_time'] = $data_coupon_exchange['modified_time'] = date("Y-m-d H:i:s");

    $info_coupon_exchange = CouponExchangeSv::edit($data_coupon_exchange);

    if (!$info_coupon_exchange) {

      throw new Exception("提领券状态修改失败！", 1);
      
    }

    $data_order_coupon_exchange_goods['order_coupon_exchange_id'] = $order_coupon_exchange_id;
    
    $data_order_coupon_exchange_goods['uid'] = $info_user['uid'];
    
    $data_order_coupon_exchange_goods['goods_id'] = $info_goods['goods_id'];
    
    $data_order_coupon_exchange_goods['goods_name'] = $info_goods['goods_name'];
    
    $data_order_coupon_exchange_goods['price'] = $info_goods['price'];

    $data_order_coupon_exchange_goods['cost_price'] = $info_goods['cost_price'];

    $data_order_coupon_exchange_goods['num'] = 1;

    $data_order_coupon_exchange_goods['goods_money'] = $data_order_coupon_exchange_goods['num'] * $info_goods['price'];

    $data_order_coupon_exchange_goods['goods_picture'] = $info_goods['picture'];

    // 添加提领券订单商品
    $order_coupon_exchange_goods_id = OrderCouponExchangeGoodsSv::add($data_order_coupon_exchange_goods);

    if (!$order_coupon_exchange_goods_id) {

      throw new Exception("订单商品写入失败", 1);
      
    }

    unset($info_address['id']);

    $data_order_coupon_exchange_address['order_coupon_exchange_id'] = $order_coupon_exchange_id;

    $data_order_coupon_exchange_address['address_id'] = $address_id;

    $data_order_coupon_exchange_address = array_merge($data_order_coupon_exchange_address, $info_address);

    // 添加提领券订单地址
    $order_coupon_exchange_address_id = OrderCouponExchangeAddressSv::add($data_order_coupon_exchange_address);

    if (!$order_coupon_exchange_address_id) {

      throw new Exception("订单地址写入失败", 1);
      
    }

    return $order_coupon_exchange_id;

  }

  /**
   * 获取订单号
   */
  public function createOrderNo() {

    $timestamp = time() . '';

    $seq = substr($timestamp, 7, 9) . substr($timestamp, 3, 4) . substr($timestamp, 0, 3);
  
    return 600 . $seq . \App\getRandomDigit(4);
  
  }

  /**
   * 获取列表
   * @param $condition['goods_status'] 1-取订单商品 2-不取订单商品
   */
  public function getList($condition) {

    if ($condition['way'] == 1 && $condition['token']) {

      $info_user = UserSv::getUserByToken($condition['token']);

      $condition['buyer_id'] = $info_user['uid'];

    }

    $goods_status = $condition['goods_status'];

    unset($condition['goods_status']);

    unset($condition['token']);

    unset($condition['way']);

    $info = self::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);

    if ($goods_status == 1) {

      foreach ($info['list'] as &$v) {

        $where_order_address['order_coupon_exchange_id'] = $v['id'];

        // 获取订单商品
        $info_order_goods = OrderCouponExchangeGoodsSv::queryList($where_order_address);

        $v['goods_list'] = $info_order_goods['list'];

      }

      unset($v);

    }

    return $info;

  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {

    if ($condition['token']) {

      $info_user = UserSv::getUserByToken($condition['token']);

      $condition['buyer_id'] = $info_user['uid'];

    }

    unset($condition['token']);

    unset($condition['order_id']);

    unset($condition['way']);

    $info_order = self::findOne($condition);

    if (!$info_order) {

      throw new Exception('参数错误，查不到用户订单数据', 6001);

    }

    $where_order_goods['order_coupon_exchange_id'] = $where_order_address['order_coupon_exchange_id'] = $info_order['id'];

    // 获取订单地址
    $info_order_address = OrderCouponExchangeAddressSv::findOne($where_order_address);

    if (!$info_order_address) {

      throw new Exception('找不到订单地址', 6001);

    }

    unset($info_order_address['id']);

    unset($info_order_address['order_coupon_exchange_id']);

    unset($info_order_address['uid']);

    $info_order = array_merge($info_order, $info_order_address);

    // 获取订单商品
    $info_order_goods = OrderCouponExchangeGoodsSv::queryList($where_order_goods);

    if (!$info_order_goods) {

      throw new Exception('找不到订单商品', 6001);

    }

    $info_order['goods_list'] = $info_order_goods['list'];

    return $info_order;

  }

  /**
   * 编辑
   */
  public function edit($data) {

    if ($data['id']) {

      $condition['id'] = $data['id'];

    }

    unset($data['id']);

    return self::batchUpdate($condition, $data);

  }

}
