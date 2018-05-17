<?php namespace App\Service\Takeaway;

use App\Service\BaseService;
use App\Interfaces\Takeaway\IOrderTakeOut;
use App\Model\OrderTakeOut;
use Core\Service\CurdSv;
use App\Service\Crm\UserSv;
use App\Service\Crm\MemberSv;
use App\Service\Crm\ManagerSv;
use App\Service\Admin\ProviderSv;
use App\Service\WorkSpace\WorkSpaceSv;
use App\Service\WorkSpace\ManagerWorkspaceSv;
use App\Service\Takeaway\OrderTakeOutGoodsSv;
use App\Service\Takeaway\OrderTakeOutAddressSv;
use App\Service\Takeaway\CartTakeOutSv;
use App\Service\Takeaway\OrderTakeOutLogSv;
use App\Service\Takeaway\OrderTakeOutGoodsDataSv;
use PhalApi\Exception;
use App\Service\Pay\PaySv;
use App\Exception\ErrorCode;
use App\Exception\OrderTakeOutException;
use App\Service\Shop\ShopSv;
use App\Service\Commodity\GoodsSkuSv;
use App\Service\Commodity\GoodsSv;
use App\Service\Commodity\GoodsPriceMapSv;
use App\Service\Crm\MemberAccountSv;
use App\Service\Crm\MemberAccountRecordSv;
use App\Service\Crm\CouponSv;
use App\Library\RedisClient;
use App\Service\Poss\PosSv;
use App\Service\Takeaway\OrderTakeOutDataSv;
use App\Service\Wechat\WechatTemplateMessageSv;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * 外卖订单
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-11
 */
class OrderTakeOutSv extends BaseService implements IOrderTakeOut {

  use CurdSv;

  /**
   * 外卖订单标记号
   */
  CONST ORDER_SIGN = '200'; 

  /**
   * 外卖订单标记号
   */
  CONST CHARGE_SIGN = 12; 

  /**
   * 外卖下单备注
   */
  CONST CHARGE_MARK = '外卖下单';

  /**
   * pos请求修改外卖订单状态
   */
  public function updateOrderTakeOut($data) {

      $condition['sn'] = $data['order_sn'];

      if ($data['status'] == 2) {

          // 线下接单
          $order_data['shipping_status'] = 0;

          $order_data['orders_time'] = date("Y-m-d H:i:s");

      } elseif ($data['status'] == 3) {

          // 线下配送
          $order_data['shipping_status'] = 2;

          $order_data['consign_time'] = date("Y-m-d H:i:s");

      } elseif ($data['status'] == 4) {

          // 线下签收
          $order_data['shipping_status'] = 3;

          $order_data['order_status'] = 3;

          $order_data['finish_time'] = date("Y-m-d H:i:s");

      } elseif ($data['status'] == 5) {

          // 线下取消
          $order_data['order_status'] = -1;

          $order_data['cancel_time'] = date("Y-m-d H:i:s");

      }

      if ($data['status'] > 1) {

          return self::batchUpdate($condition, $order_data);

      } else {

          return false;

      }

  }

  /**
   * pos获取外卖订单信息
   */
  public function getOrderTakeOut($data) {

      if ($data['status'] == 1) {

          $conditions['shipping_status'] = 1;

          $conditions['order_status'] = 2;

      } elseif ($data['status'] == 2) {

          $conditions['shipping_status'] = 0;

          $conditions['order_status'] = 2;

      } elseif ($data['status'] == 3) {

          $conditions['shipping_status'] = 2;

          $conditions['order_status'] = 2;

      } elseif ($data['status'] == 4) {

          $conditions['shipping_status'] = 3;

          $conditions['order_status'] = 3;

      }

      if ($data['order_sn'] == 1) {

          $conditions['sn'] = $data['order_sn'];

      }

      $order = 'pay_time asc';
      
      $list = OrderTakeOutDataSv::getList($conditions, $order);

      $list_array = array();

      foreach ($list as $v) {

          $vs = array();

          $vs['order_sn'] = $v['sn'];

          $vs['shipping_money'] = $v['shipping_money'];

          $vs['create_time'] = $v['create_time'];

          $vs['pay_time'] = $v['pay_time'];

          $vs['promotion_money'] = $v['coupon_money'];

          $vs['code_money'] = $v['user_money'];

          $vs['pos_id'] = $v['pos_id'];

          $vs['phone'] = $v['user_tel'];

          $vs['customary_number'] = $v['customary_number'] ? $v['customary_number'] : 0;

          $vs['money'] = $v['pay_money'];

          $vs['goods_money'] = $v['goods_money'];

          $vs['buyer_message'] = iconv('UTF-8', 'GBK', $v['buyer_message']);

          $vs['card_id'] = $v['card_id'];

          if ($v['shipping_status'] == 1 && $v['order_status'] == 2) {

              $vs['status'] = 1;

          } elseif ($v['shipping_status'] == 0 && $v['order_status'] == 2) {

              $vs['status'] = 2;

          } elseif ($v['shipping_status'] == 2 && $v['order_status'] == 2) {

              $vs['status'] = 3;

          } elseif ($v['shipping_status'] == 3 && $v['order_status'] == 3) {

              $vs['status'] = 4;

          }

          $vs['province_name'] = $v['province_name'];

          $vs['city_name'] = $v['city_name'];

          $vs['district_name'] = $v['district_name'];

          $vs['address'] = $v['address'];

          $vs['mobile'] = $v['mobile'];

          $vs['name'] = $v['consigner'];

          $vs['total_packet_fee_money'] = 0;

          $where['order_take_out_id'] = $v['id'];

          $list_goods = OrderTakeOutGoodsDataSv::all($where);

          $vs['goods'] = array();

          foreach ($list_goods as $vo) {

              $info_goods = array();

              $info_goods['goods_name'] = $vo['goods_name'];

              $info_goods['goods_no_code'] = $vo['goods_no_code'];

              $info_goods['stalls_no_code'] = $vo['stalls_no_code'];

              $info_goods['goods_category_name'] = $vo['category_name'];

              if ($vo['sku_name']) {

                  $info_goods['goods_name'] .= "（".$vo['sku_name']."）";

              }

              $info_goods['num'] = $vo['num'];

              $info_goods['price'] = $vo['price'];

              $info_goods['packet_fee_money'] = 0;

              $vs['goods'][] = $info_goods;

          }

          $list_array[] = $vs;

      }

      return $list_array;

  }

  /**
   * 取消外卖订单接口服务
   */
  public function cancelOrder($data) {

      $table_order_log_data['description'] = $data['comment'];

      $table_order_log_data['order_sn'] = $condition['sn'] = $data['order_sn'];

      $info_order = self::findOne($condition);

      if ($info_order['order_status'] == -1) {

          throw new OrderTakeOutException(ErrorCode::OrderTakeOutSv['ORDER_CANCEL_ERR_MSG'], ErrorCode::OrderTakeOutSv['ORDER_CANCEL_ERR_CODE'], $data['order_sn']);
          
      }

      $order_data['order_status'] = -1;

      $table_order_log_data['created_at'] = $order_data['cancel_time'] = date("Y-m-d H:i:s");

      // 取消订单
      $info = self::batchUpdate($condition, $order_data);

      // 添加外卖订单操作者记录
      OrderTakeOutLogSv::add($table_order_log_data);

      return $info;

  }

  /**
   * 外卖订单回调通知
   */
  public function orderTakeOutNotify($orderNo) {

      $where_order_take_out['sn'] = $orderNo;

      // 获取订单详情
      $info_order_take_out = self::findOne($where_order_take_out);



      if (!$info_order_take_out) { 

          //外卖订单不存在则抛出异常
          throw new PayException(
              ErrorCode::PaySv['NOTIFY_ORDER_NOT_FOUND_MSG'],
              ErrorCode::PaySv['NOTIFY_ORDER_NOT_FOUND_CODE'],
              $orderNo
          );

      } else if ($info_order_take_out['order_status'] == 2 && $info_order_take_out['pay_status'] == 2) {

          //外卖订单标记已完成则返回
          return;

      }

      $data_order_take_out['order_status'] = 2;

      $data_order_take_out['pay_status'] = 2;

      $data_order_take_out['pay_time'] = date("Y-m-d H:i:d");

      $info = self::batchUpdate($where_order_take_out, $data_order_take_out);

  }

  /**
   * 获取列表
   * @param $condition['goods_status'] 1-取订单商品 2-不取订单商品
   */
  public function getList($condition) {

      if ($condition['way'] == 1 && $condition['token']) {

          $info_user = UserSv::getUserByToken($condition['token']);

          $condition['buyer_id'] = $info_user['uid'];

      } elseif ($condition['way'] == 2 && $condition['token']) {
      
          $info_user = UserSv::getAdminToken($condition['token']);

          $provider = ProviderSv::findOne(array('account' => $info_user['user_name']));

          if ($provider) {

            $condition['provider_id'] = $provider['id'];

          }
      
      }

      $goods_status = $condition['goods_status'];

      $excel = $condition['excel'];

      unset($condition['goods_status']);

      unset($condition['token']);

      unset($condition['excel']);

      unset($condition['way']);

      if ($excel) {

        $orders = OrderTakeoutUnionSv::all($condition);
      
        self::exportExcel($orders);
      
      } else {

        $info = OrderTakeoutUnionSv::queryList($condition, $condition['fields'], 'create_time desc', $condition['page'], $condition['page_size']);

        foreach ($info['list'] as &$v) {

            $info_shop = ShopSv::findOne($v['shop_id']);

            $v['shop_name'] = $info_shop['shop_name'];

            $v['shop_logo'] = $info_shop['shop_logo'] ? $info_shop['shop_logo'] : $info_shop['shop_banner'];

            if ($goods_status == 1) {

                $where_order_address['order_take_out_id'] = $v['id'];

                // 获取订单商品
                $info_order_goods = OrderTakeOutGoodsSv::getList($where_order_address);

                $v['goods_list'] = $info_order_goods;

            }

            if ($v['workspace_id']) {
            
              $workspace = WorkSpaceSv::findOne(array('id' => $v['workspace_id']));

              $v['workspace_name'] = $workspace['name'];
            
            }

            if ($v['provider_id']) {

              $provider = ProviderSv::findOne(array('id' => $v['provider_id']));
            
              $v['provider_name'] = $provider['pname'];
            
            }

            $manager = ManagerSv::findOne(array('phone' => $v['user_tel']));

            if ($manager) {
            
              $v['manager_name'] = $manager['name'];
            
            }

        }

        return $info;

      }

  }

  /**
   * 查询订单列表
   */
  public function orderList($data) {
  
    $user = UserSv::getUserByToken($data['token']);
  
    $uid = $user['uid'];

    if (!$data['keyword']) {

      $condition = array(
      
        'buyer_id' => $uid,

        'order_status' => $data['order_status']
      
      );


      $orders = self::queryList($condition, '*', 'create_time desc', $data['page'], $data['page_size']);

      if(empty($orders['list'])) {
      
        return $orders;
      
      }

      foreach($orders['list'] as $key => $order) {
      
        $condition = array(
        
          'order_take_out_id' => $order['id']
        
        );

        $goods = OrderTakeOutGoodsSv::getList($condition);

        $orders['list'][$key]['order_goods'] = $goods;

        $address = OrderTakeOutAddressSv::findOne($condition);

        $orders['list'][$key]['order_address'] = $address;
      
      }

      return $orders;

    } else {

      $keyword = $data['keyword'];

      $page = $data['page'];

      $pageSize = $data['page_size'];

      $goodsNameCondition = array(
      
        'goods_name' => $keyword,

        'uid' => $uid
      
      );

      $skuNameCondition = array(
      
        'sku_name' => $keyword,

        'uid' => $uid
      
      );

      $og1 = OrderTakeOutGoodsSv::all($goodsNameCondition);

      $og2 = OrderTakeOutGoodsSv::all($skuNameCondition);

      $mobileCondition = array(
      
        'mobile' => $keyword,

        'uid' => $uid
      
      );

      $addressCondition = array(
      
        'address' => $keyword,

        'uid' => $uid
      
      );

      $consignerCondition = array(
      
        'consigner' => $keyword,

        'uid' => $uid

      );

      $oa1 = OrderTakeOutAddressSv::all($mobileCondition);

      $oa2 = OrderTakeOutAddressSv::all($addressCondition);

      $oa3 = OrderTakeOutAddressSv::all($consignerCondition);

      $orderIds = array();

      $tmpOrders = array_merge($og1, $og2, $oa1, $oa2, $oa3);

      foreach($tmpOrders as $order) {
      
        if (!in_array($order['order_take_out_id'], $orderIds)) {
        
          array_push($orderIds, $order['order_take_out_id']);
        
        }
      
      }

      $condition = array(
      
        'id' => implode(',', $orderIds)

      );

      if ($data['order_status']) {
      
        $condition['order_status'] = $data['order_status'];
      
      }

      $orders = self::queryList($condition, '*', 'create_time desc', $data['page'], $data['page_size']);

      if(empty($orders['list'])) {
      
        return $orders;
      
      }

      foreach($orders['list'] as $key => $order) {
      
        $condition = array(
        
          'order_take_out_id' => $order['id']
        
        );

        $goods = OrderTakeOutGoodsSv::getList($condition);

        $orders['list'][$key]['order_goods'] = $goods;

        $address = OrderTakeOutAddressSv::findOne($condition);

        $orders['list'][$key]['order_address'] = $address;
      
      }

      return $orders;

    }
  
  }

  /**
   * 获取数量
   */
  public function getCount($condition) {

      if ($condition['token']) {

          $info_user = UserSv::getUserByToken($condition['token']);

          $condition['uid'] = $info_user['uid'];

      }

      unset($condition['token']);

      return self::queryCount($condition);

  }

  /**
   * 获取详情
   */
  public function getDetails($condition) {

      if ($data['way'] == 1 && $condition['token']) {

          $info_user = UserSv::getUserByToken($condition['token']);

          $condition['buyer_id'] = $info_user['uid'];

      }

      if ($condition['order_id']) {

          $condition['id'] = $condition['order_id'];

      }

      unset($condition['order_id']);

      unset($condition['token']);

      unset($condition['way']);

      $info_order = self::findOne($condition);

      if (!$info_order) {

          throw new Exception('参数错误，查不到用户订单数据', 6001);

      }

      $info_shop = ShopSv::findOne($info_order['shop_id']);

      $info_order['shop_name'] = $info_shop['shop_name'];
      
      $info_order['shop_logo'] = $info_shop['shop_logo'] ? $info_shop['shop_logo'] : $info_shop['shop_banner'];

      $where_order_goods['order_take_out_id'] = $where_order_address['order_take_out_id'] = $info_order['id'];

      // 获取订单地址
      $info_order_address = OrderTakeOutAddressSv::getDetails($where_order_address);

      unset($info_order_address['id']);

      unset($info_order_address['order_take_out_id']);

      unset($info_order_address['uid']);

      $info_order = array_merge($info_order, $info_order_address);

      // 获取订单商品
      $info_order_goods = OrderTakeOutGoodsSv::getList($where_order_goods);

      $info_order['goods_list'] = $info_order_goods;

      return $info_order;

  }

  /**
   * 新增
   * @param int $data['way'] 途径 1-前台会员 2-后台管理员
   * @param string $data['token'] 用户令牌（way为1则必传）
   * @param int $data['buyer_id'] 用户id（way为2则必传）
   * @param int $data['shop_id'] 卖家店铺id
   * @param int $data['address_id'] 收货地址id
   */
  public function adds($data) {

      $payType = $data['payment_type'] = $data['pay_type'];

      unset($data['pay_type']);

      $providerId = 0;

      $module = RedisClient::get('system_config', 'account_is_poss') ? 1 : 2;

      if ($data['way'] == 1 && $data['token']) {

          $info_user = UserSv::getUserByToken($data['token']);

          $data['buyer_id'] = $info_user['uid'];

          $manager = ManagerSv::findOne(array('phone' => $info_user['user_tel']));

          if ($manager) {
          
            $providerId = $manager['pid'];
          
          }

      }

      $member = MemberSv::findOne(array('uid' => $info_user['uid']));

      $memberLevel = $member['member_level'];

      $cityCode = $data['city_code'];

      unset($data['city_code']);

      unset($data['way']);

      unset($data['token']);

      $data['sn'] = self::getSn();

      $data['order_status'] = 1;

      $data['create_time'] = date('Y-m-d H:i:s');
      
      $data_goods['cart_id'] = $data['cart_id'];

      // 验证商品

      CartTakeOutSv::verify($data['cart_id'], $data['buyer_id']);

      $data_address['address_id'] = $data['address_id'];

      // 验证地址

      // 计算订单商品总价
      $data['goods_money'] = CartTakeOutSv::disposeGoods($data['cart_id'], $cityCode, $memberLevel);

      $data['coupon_money'] = 0;

      unset($data['address_id']);

      unset($data['cart_id']);

      $data_goods['uid'] = $data_address['uid'] = $data['buyer_id'];

      $data['shipping_money'] = 0;

      $data['order_money'] = $data['goods_money'] + $data['shipping_money'];

      $money = $data['order_money'] - $data['coupon_money'] - $data['point_money'];

      $balance = 0;

      $data['id'] = rand(100000000, 999999999);

      $data['provider_id'] = $providerId;

      $data['buyer_message'] = iconv('UTF-8', 'GBK', $data['buyer_message']);

      // 添加订单
      self::add($data);

      $data_goods['order_id'] = $data_address['order_id'] = $id = $data['id'];

      // 添加订单地址
      $info_order_address = OrderTakeOutAddressSv::addOrderAddress($data_address);

      // 添加订单商品
      $info_order_goods = OrderTakeOutGoodsSv::addOrderGoodsAll($data_goods);

      $condition_cart['buyer_id'] = $data['buyer_id'];

      $condition_cart['cart_id'] = $data_goods['cart_id'];
      
      // 删除购物车商品
      $info_cart_goods = CartTakeOutSv::cartEmpty($condition_cart);

      if ($data['workspace_id']) {
      
        $wm = ManagerWorkspaceSv::findOne(array('mid' => $manager['id'], 'wid' => $data['workspace_id']));

        ManagerWorkspaceSv::update($wm['id'], array('rest_credit' => $wm['rest_credit'] - $data['goods_money']));
      
      }

      if ($payType == 1) {

        //构造预支付数据
        $payment = array(
            'pay_type' => 2, // 支付类型
            'out_trade_no' => $data['sn'],
            'money' => 0.01,// $data['goods_money'],
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'open_id' => $info_user['wx_openid'],
            'nonce_str' => md5($info_user['wx_openid'] . time()),
            'body' => "{$member['nick_name']} 下单支付 {$data['money']}"
        );

        //调用微信预支付
        $payInfo = PaySv::wechatPayAction($payment);

        $payInfo['sn'] = $data['sn'];
        $payInfo['price'] = $data['goods_money'];
        $payInfo['id'] = $id;

        return $payInfo;

      } else {

        // 提交事务
        $info_return['id'] = $id;
        
        $info_return['sn'] = $data['sn'];

        $info_return['price'] = $data['goods_money'];

        return $info_return;

      }

  }

  /**
   * 立即购买
   */
  public function purchase($data) {

      $payType = $data['pay_type'];

      unset($data['pay_type']);

      $data['payment_type'] = $payType;

      $providerId = 0;

      if ($data['way'] == 1 && $data['token']) {

          $info_user = UserSv::getUserByToken($data['token']);

          $data['buyer_id'] = $info_user['uid'];

          $manager = ManagerSv::findOne(array('phone' => $info_user['user_tel']));

          if ($manager) {
          
            $providerId = $manager['pid'];
          
          }

      }

      $member = MemberSv::findOne(array('uid' => $info_user['uid']));

      $memberLevel = $member['member_level'];

      $cityCode = $data['city_code'];

      unset($data['city_code']);

      unset($data['way']);

      unset($data['token']);

      $data['sn'] = self::getSn();

      $data['order_status'] = 1;

      $data['create_time'] = date('Y-m-d H:i:s');

      $data_address['address_id'] = $data['address_id'];

      $info_goods = GoodsSv::findOne($data['goods_id']);

      if ($data['sku_id']) {

          $data_goods['sku_id'] = $data['sku_id'];

          $info_sku_goods = GoodsSkuSv::findOne($data['sku_id']);

          $priceCondition = array(
          
            'city_code' => $cityCode,

            'user_level' => $memberLevel,

            'sku_id' => $info_sku_goods['sku_id']
          
          );

          $priceRule = GoodsPriceMapSv::findOne($priceCondition);

          $data_goods['sku_name'] = $info_sku_goods['sku_name'];

          $data_goods['no_code'] = $info_sku_goods['no_code'];
          
          $info_goods['price'] = !empty($priceRule) ? $priceRule['price'] : $info_sku_goods['price'];
          
          $info_goods['stock'] = $info_sku_goods['stock'];

          if ($info_sku_goods['picture']) {
          
              $info_goods['picture'] = $info_sku_goods['picture'];

          }

          if ($info_sku_goods['cost_price']) {
          
              $info_goods['cost_price'] = $info_sku_goods['cost_price'];

          }

      }

      if (!$info_goods['stock'] || $info_goods['stock'] <= 0) {

          throw new Exception("库存不足", 610111);

      }

      $data_goods['goods_name'] = $info_goods['goods_name'];

      $data_goods['goods_id'] = $data['goods_id'];

      $data_goods['num'] = $data['quantity'];

      $data_goods['goods_picture'] = $info_goods['picture'];

      $data_goods['cost_price'] = $info_goods['cost_price'];

      // 计算订单商品总价
      $data['goods_money'] = $data_goods['goods_money'] = $data['quantity'] * $info_goods['price'];

      unset($data['address_id']);

      unset($data['quantity']);

      unset($data['sku_id']);

      $data_goods['uid'] = $data_address['uid'] = $data['buyer_id'];

      $data['shipping_money'] = 0;

      $data['order_money'] = $data['goods_money'] + $data['shipping_money'];

      $money = $data['order_money'] - $data['point_money'] - $data['coupon_money'];

      $balance = 0;

      $data['pay_money'] = $money - $data['user_money'] - $data['user_platform_money'] - $data['promotion_money'];

      $data['id'] = time();

      $data['shop_id'] = 0;
      
      $data['shop_name'] = '';

      $data['address_id'] = 0;

      $data['provider_id'] = $providerId;

      $data['buyer_message'] = iconv('UTF-8', 'GBK', $data['buyer_message']);

      self::add($data);
      
      // 添加订单
      $data_goods['order_take_out_id'] = $data_address['order_id'] = $id = $data['id'];

      // 添加订单地址
      $info_order_address = OrderTakeOutAddressSv::addOrderAddress($data_address);

      $data_goods['shop_id'] = $data['shop_id'];

      $data_goods['price'] = $info_goods['price'];

      $data_goods['id'] = rand(100000000, 999999999);

      // 添加订单商品
      $info_order_goods = OrderTakeOutGoodsSv::addOrderGoods($data_goods);

      if ($data['workspace_id']) {
      
        $wm = ManagerWorkspaceSv::findOne(array('mid' => $manager['id'], 'wid' => $data['workspace_id']));

        ManagerWorkspaceSv::update($wm['id'], array('rest_credit' => $wm['rest_credit'] - $data['goods_money']));
      
      }

      if ($payType == 1) {
      
        //构造预支付数据
        $payment = array(
            'pay_type' => 2, // 支付类型
            'out_trade_no' => $data['sn'],
            'money' => 0.01,// $data['goods_money'],
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'open_id' => $info_user['wx_openid'],
            'nonce_str' => md5($info_user['wx_openid'] . time()),
            'body' => "{$member['nick_name']} 下单支付 {$data['money']}"
        );

        //调用微信预支付
        $payInfo = PaySv::wechatPayAction($payment);

        $payInfo['sn'] = $data['sn'];
        $payInfo['price'] = $data['goods_money'];
        $payInfo['id'] = $id;

        return $payInfo;
      
      } else {

        $info_return['id'] = $id;
        
        $info_return['sn'] = $data['sn'];

        $info_return['price'] = $data['goods_money'];
      
        return $info_return;
      
      }


  }

  /**
   * 外卖订单支付
   */
  public function payOrderTakeOut($data) {

      $info_user = UserSv::getUserByToken($data['token']);

      $where_order['sn'] = $data['sn'];

      $info_order = self::findOne($where_order);

      if (!$info_order) {

          // 订单不存在
          throw new Exception(ErrorCode::OrderTakeOutSv['ORDER_ERR_MSG'], ErrorCode::OrderTakeOutSv['ORDER_ERR_CODE']);

      } elseif ($info_order['order_status'] == 1 && $info_order['pay_status'] == 1 && $info_order['user_money'] > 0) {

          // 单一支付情况 使用余额支付
          return self::balancePay($info_order);

      } elseif ($info_order['order_status'] != 1 || $info_order['pay_status'] != 1) {

          // 已支付的订单
          throw new Exception(ErrorCode::OrderTakeOutSv['ORDER_PAY_STATUS_ERR_MSG'], ErrorCode::OrderTakeOutSv['ORDER_PAY_STATUS_ERR_CODE']);

      } elseif ($info_order['pay_money'] == 0 && $info_order['user_money'] == 0 ) {

          if ($info_order['order_status'] == 1 && $info_order['pay_status'] == 1) {

              $data_order['pay_status '] = $data_order['order_status'] = 2;

              $data_order['pay_time'] = data("Y-m-d H:i:s");

              $data_order['order_id'] = $info_order['id'];

              return self::updates($data_order);

          }

          // 需支付的金额为0
          throw new Exception(ErrorCode::OrderTakeOutSv['ORDER_PAY_MONEY_ERR_MSG'], ErrorCode::OrderTakeOutSv['ORDER_PAY_MONEY_ERR_CODE']);

      }

      //构造预支付数据
      $payment = array(
          'pay_type' => 2, // 支付类型
          'out_trade_no' => $data['sn'],
          'money' => $info_order['pay_money'],
          'ip_address' => $_SERVER['REMOTE_ADDR'],
          'open_id' => $info_user['wx_openid'],
          'nonce_str' => md5($info_user['wx_openid'] . time()),
          'device_info' =>  $data['device_info'], //由前台传入设备信息
          'body' => "{$member['nick_name']} 下单支付 {$data['money']}"
      );

      //调用微信预支付
      return PaySv::wechatPayAction($payment);

  }

  /**
   * 编辑
   */
  public function updates($data) {

      if ($data['order_id']) {

          $condition['id'] = $data['order_id'];

      }
      if ($data['driver_name']) {
      
        $data['driver_name'] = iconv('UTF-8', 'GBK', $data['driver_name']);
      
      }

      unset($data['order_id']);

      return self::batchUpdate($condition, $data);

  }

  /**
   * 获取订单编号
   */
  public function getSn() {

      $sn = OrderTakeOutSv::ORDER_SIGN.time();

      $sn .= \App\getRandomDigit(4);

      $where['sn'] = $sn;

      $info = OrderTakeOut::queryList($where, 'sn', '', 0, 1);

      if ($info) {

          $sn = self::getSn();

      }

      return $sn;

  }

  /**
   * 设置订单状态为已推送
   */
  public function setPushed($ids) {
  
    $condition = array(
    
      'order_id' => $ids
    
    );

    return self::batchUpdate($condition, array( 'is_pushed' => 1 ));
  
  }

  /**
   * 根据单号修改订单状态
   */
  public function updateOrderStatusByOrderNo($orderNo, $status) {
  
    $condition = array(
    
      'order_number' => $orderNo

    );

    $result = array();

    if ($status == 2) {
    
      $result['shipping_status'] = 0;

    } elseif ($status == 3) {
    
      $result['shipping_status'] = 2;
    
    } elseif ($status == 4) {
    
      $result['shipping_status'] = 3;
    
    }

    return self::batchUpdate($condition, $result);
  
  }

  /**
   * 订单余额支付
   * @desc 验证余额是否足够，判断线下扣款是否成功
   */
  public function balancePay ($info_order) {

      // 获取可用额度

      $res = null;

      $member_acc_where['uid'] = $info_order['buyer_id'];

      $res = MemberAccountSv::getPossDetail($member_acc_where);

      $balance = $res['balance'] ? $res['balance'] : 0;

      if ($info_order['user_money'] > $balance) {

          throw new OrderTakeOutException(ErrorCode::MemberAccountSv['MINU_ACCT_MONEY_LESS_MSG'], ErrorCode::MemberAccountSv['MINU_ACCT_MONEY_LESS_CODE']);

      }

      $record = array(
          'uid' => $info_order['buyer_id'],
          'account_type' => 2,
          'shop_id' => $info_order['shop_id'],
          'sign' => -1,
          'number' => $info_order['user_money'],
          'customary_number' => $balance,
          'from_type' => 1,
          'data_id' => $info_order['id'],
          'text' => '线上外卖下单使用会员卡余额支付',
          'create_time' => date('Y-m-d H:i:s')
      );

      // 减少余额记录操作
      MemberAccountRecordSv::add($record);

      $info_member_account = MemberAccountSv::findOne(array('uid'=>$info_order['buyer_id']));

      $data_balance['sCardID'] = $info_member_account['card_id'];

      $data_balance['iAddValue'] = -1 * $info_order['user_money'];

      $data_balance['iGiftValue'] = '0';

      $data_balance['sMemo'] = '外卖下单消费，单号：' . $info_order['sn'];

      // 通知pos使用余额
      $info_balance = PosSv::increaseBalance($data_balance);

      if ($info_balance['Status'] != 1) {

          throw new OrderTakeOutException(ErrorCode::OrderTakeOutSv['ORDER_USE_BALANCE_POS_ERR_MSG'], ErrorCode::OrderTakeOutSv['ORDER_USE_BALANCE_POS_ERR_CODE'], $id);
          
      }

      $data['pay_status'] = $data['order_status'] = 2;

      $data['pay_time'] = date("Y-m-d H:i:s");

      $data['order_id'] = $info_order['id'];

      self::updates($data);

      return true;

  }

  /**
   * 重新购买
   *
   */
  public function rebuyOrder($params) {
  
    $orderId = $params['order_id'];
  
    $user = UserSv::getUserByToken($params['token']);

    $cityCode = $params['city_code'];

    $uid = $user['uid'];

    $member = MemberSv::findOne(array('uid' => $uid));

    $order = self::findOne($orderId);
    
    $orderAddress = OrderTakeOutAddressSv::findOne(array('order_take_out_id' => $orderId));

    $orderGoods = OrderTakeOutGoodsSv::all(array('order_take_out_id' => $orderId));

    $newOrderGoods = array();

    /**
     * 购物车商品
     */
    $newCartGoods = array();

    $newOrderId = rand(100000000, 999999999);

    $totalPrice = 0;

    /**
     * 检查商品
     */
    foreach($orderGoods as $orderGood) {
    
      $good = GoodsSv::findOne($orderGood['goods_id']);

      if (empty($good) || !$good['state']) {
      
        return 0;
      
      }
    
      $sku = GoodsSkuSv::findOne($orderGood['sku_id']);

      if (empty($sku) || !$sku['active']) {
      
        return 0;
      
      }

      /**
       * 获取商品地域价格
       */
      $priceRule = GoodsPriceMapSv::findOne(array(
        
        'sku_id' => $sku['sku_id'], 
        
        'city_code' => $cityCode,
        
        'user_level' => $member['member_level'])

      );

      if (!empty($priceRule)) {
      
        $sku['price'] = $priceRule['price'];
      
      }

      /**
       * 购物车商品
       */
      $cartGood['cart_id'] = rand(100000000, 999999999);

      $cartGood['buyer_id'] = $uid;

      $cartGood['goods_id'] = $orderGood['goods_id'];

      $cartGood['sku_id'] = $orderGood['sku_id'];

      $cartGood['goods_name'] = $good['goods_name'];

      $cartGood['sku_name'] = $sku['sku_name'];

      $cartGood['price'] = $orderGood['price'];

      $cartGood['num'] = $orderGood['num'];

      $cartGood['goods_picture'] = $orderGood['goods_picture'];

      array_push($newCartGoods, $cartGood);
    
    }

    CartTakeOutSv::batchRemove(array('buyer_id' => $uid));

    return CartTakeOutSv::batchAdd($newCartGoods);

  }

  /**
   * 导出excel
   * @desc 导出excel
   *
   */
  public function exportExcel($orders) {
  
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Type:application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="01simple.xlsx"');
    header('Cache-Control: max-age=0');
      
    $spreadsheet = new Spreadsheet();

    $titles = array(
    
      '订单编号', '收货人', '收货联系电话', '会员名称', '订单金额', '订单状态', '下单时间' 
    
    );

    $sheet = $spreadsheet->getActiveSheet();

    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    foreach($titles as $key => $title) {

      $sheet->setCellValue("{$characters[$key]}1", $title);
    
    }

    $statusInfo = array(
    
      '-1' => '已取消',
      '1' => '待付款',
      '2' => '待发货',
      '3' => '待收货',
      '4' => '已完成'
    
    );

    foreach($orders as $index => $order) {

      $column = 0;

      $valueOrder = array(
      
        'sn' => $order['sn'],

        'consigner' => $order['consigner'],

        'mobile' => $order['mobile'],

        'member_name' => $order['member_name'],

        'price' => $order['goods_money'],

        'order_status' => iconv('UTF-8', 'GBK', $statusInfo[strval($order['order_status'])]),

        'create_time' => $order['create_time']
      
      );

      foreach($valueOrder as $value) {

	$row = $index + 2;

        $cell = "{$characters[$column]}{$row}";

        $sheet->setCellValue($cell, iconv('GBK', 'UTF-8', $value));

        $column++;

      }

    }

    $writer = new Xlsx($spreadsheet);

    $writer->save("php://output");

    exit(0);
  
  }

  /**
   * 审核订单，同步u8
   *
   *
   */
  public function audit($data) {
  
    $orders = self::all(array('sn' => $data['order_nos']));

    $cas = explode(',', $data['cas']);

    $asyncs = array();

    foreach($orders as $key => $order) {

      /**
       * 判断是否项目经理
       */

      $userInfo = UserSv::findOne($order['buyer_id']);

      $member = MemberSv::findOne($order['buyer_id']);

      $manager = ManagerSv::findOne(array('phone' => $userInfo['user_tel']));

      $address = OrderTakeOutAddressSv::findOne(array('order_takeout_id' => $order['id']));

      $goods = OrderTakeOutGoodsSv::all(array('order_take_out_id' => $order['id']));

      $signKey = "wechatcode={$userInfo['wx_openid']}wechatname={$member['member_name']}wechatphone={$userInfo['user_tel']}TunZhoush@$58h";

      $signSecret = md5($signKey);

      $newAsync = array(

        'sign'  => $signSecret,
        'userid' => $order['buyer_id'],
        'cmanager' => $manager ? $manager['name'] : $userInfo['user_name'],
        'wechatcode' => $userInfo['wx_openid'],
        'wechatname' => $member['member_name'],
        'wechatphone' => $userInfo['user_tel'],
        'csocode' => $order['sn'],
        'ddate' => $order['create_time'],
        'cdepcode' => 1,
        'cpersoncode' => 1,
        'creceiver' => $address['consigner'],
        'creceiveraddress' => $address['address'],
        'creceiverphone' => $address['mobile'],
        'cmemo' => $order['buyer_message'],
        'caccid' => $cas[$key]
      
      );

      $newAsync['detail'] = array();

      foreach($goods as $good) {
      
        $orderGood = array(
        
          'autoid' => $good['id'],
          'cinvcode' => $good['no_code'],
          'iquantity' => $good['num'],
          'iprice' => $good['price'],
          'imoney' => $good['goods_money']
        
        );

        array_push($newAsync['detail'], $orderGood);
      
      }

      array_push($asyncs, $newAsync);
    
    }

    return $asyncs;
  
  }

}
