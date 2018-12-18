<?php 
namespace App\Service\Takeaway;

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
use App\Service\Commodity\GoodsCategorySv;
use App\Service\Crm\MemberAccountSv;
use App\Service\Crm\MemberAccountRecordSv;
use App\Service\Crm\CouponSv;
use App\Library\RedisClient;
use App\Service\Poss\PosSv;
use App\Service\Transport\TransSv;
use App\Service\Takeaway\OrderTakeOutDataSv;
use App\Service\Wechat\WechatTemplateMessageSv;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Library\Http;
use App\Model\OrderTakeoutUnion;

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

          $vs['buyer_message'] = $v['buyer_message']; // iconv('UTF-8', 'GBK', $v['buyer_message']);

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

      if ($info_order['order_status'] == 0) {

          throw new OrderTakeOutException(ErrorCode::OrderTakeOutSv['ORDER_CANCEL_ERR_MSG'], ErrorCode::OrderTakeOutSv['ORDER_CANCEL_ERR_CODE'], $data['order_sn']);
          
      }

      $order_data['order_status'] = 0;

      $table_order_log_data['created_at'] = $order_data['cancel_time'] = date("Y-m-d H:i:s");

      // 取消订单
      $info = self::batchUpdate($condition, $order_data);

      /**
       * 已审核订单同步u8
       */
      if ($info_order['audit']) {
      
        $userInfo = UserSv::findOne($info_order['buyer_id']);

        $member = MemberSv::findOne($info_order['buyer_id']);

        $manager = ManagerSv::findOne(array('phone' => $userInfo['user_tel']));

        $address = OrderTakeOutAddressSv::findOne(array('order_take_out_id' => $info_order['id']));

        $goods = OrderTakeOutGoodsSv::all(array('order_take_out_id' => $info_order['id']));

        $sn = trim($info_order['sn']);

        $cretcode = $sn . rand(100, 999) . rand(1, 9);

        $cretcode = substr($cretcode, 4, strlen($sn));

        $date = date('Y-m-d H:i:s');

        $signKey = "cretcode={$cretcode}ddate={$date}wechatphone={$userInfo['user_tel']}TunZhoush@$58h";

        $signSecret = md5($signKey);

        $newAsync = array(

          'sign'  => $signSecret,
          'userid' => $info_order['buyer_id'],
          'wechatcode' => $userInfo['wx_openid'],
          'wechatname' => $member['member_name'], // iconv("GBK//IGNORE", "UTF-8", $member['member_name']),
          'wechatphone' => $userInfo['user_tel'],
          'cretcode' => $cretcode,
          'csocode' => $sn,
          'ddate' => $date,
          'cdepcode' => $info_order['city_code'],
          'binvoice' => $info_order['invoice'],
          "cbuserid" => "",
          'cbuserphone' => "",
          'creceiver' => $address['consigner'], //  iconv("GBK//IGNORE", "UTF-8", $address['consigner']),
          'creceiveraddress' => $address['address'], // iconv("GBK//IGNORE", "UTF-8", $address['address']),
          'creceiverphone' => $address['mobile'],
          'cmemo' => $order['buyer_message'], // iconv("GBK//IGNORE", "UTF-8", $order['buyer_message']),
          'caccid' => $info_order['cas']
        
        );

        $newAsync['detail'] = array();

        foreach($goods as $good) {
        
          $orderGood = array(
          
            'autoid' => $good['id'],
            'iunsid' => $good['id'],
            'cinvcode' => $good['no_code'],
            'iquantity' => $good['num'],
            'iprice' => $good['price'],
            'imoney' => $good['goods_money']
          
          );

          array_push($newAsync['detail'], $orderGood);
        
        }

      
        $header = array( 'Content-Type:application/json;charset=utf-8' );
    
        $response = Http::httpPost("http://58.247.168.34:8008/api/u8/interface/create_salereturnvoucher", json_encode($newAsync), $header);

        $result = json_decode($response, true);

        if ($result['status'] == 0) {
        
          self::update($orders[$key]['id'], array('audit' => 0));
        
        }

        return $result;
        
      }

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

      /**
       * 下单时间筛选
       */

      if ($condition['start_time'] && $condition['end_time']) {
        
        $startTime = date('Y-m-d', $condition['start_time']);

        $endTime = date('Y-m-d', $condition['end_time'] + 86400);
      
        $condition['create_time'] = "eg|{$startTime};el|{$endTime}";
      
      } elseif ($condition['start_time']) {
      
        $startTime = date('Y-m-d', $condition['start_time']);

        $condition['create_time'] = "eg|{$startTime}";
      
      } elseif ($condition['end_time']) {
      
        $endTime = date('Y-m-d', $condition['end_time'] + 86400);

        $condition['create_time'] = "el|{$endTime}";
      
      }

      /**
       * 审核时间筛选
       */

      if ($condition['audit_start'] && $condition['audit_end']) {
        
        $startTime = date('Y-m-d', $condition['audit_start']);

        $endTime = date('Y-m-d', $condition['audit_end'] + 86400);
      
        $condition['audit_time'] = "eg|{$startTime};el|{$endTime}";
      
      } elseif ($condition['audit_start']) {
      
        $startTime = date('Y-m-d', $condition['audit_start']);

        $condition['audit_time'] = "eg|{$startTime}";
      
      } elseif ($condition['audit_end']) {
      
        $endTime = date('Y-m-d', $condition['audit_end'] + 86400);

        $condition['audit_time'] = "el|{$endTime}";
      
      }

      /**
       * 用户注册时间筛选
       */
      if ($condition['reg_start'] && $condition['reg_end']) {
        
        $startTime = date('Y-m-d', $condition['reg_start']);

        $endTime = date('Y-m-d', $condition['reg_end'] + 86400);
      
        $condition['reg_time'] = "eg|{$startTime};el|{$endTime}";
      
      } elseif ($condition['reg_start']) {
      
        $startTime = date('Y-m-d', $condition['reg_start']);

        $condition['reg_time'] = "eg|{$startTime}";
      
      } elseif ($condition['reg_end']) {
      
        $endTime = date('Y-m-d', $condition['reg_end'] + 86400);

        $condition['reg_time'] = "el|{$endTime}";
      
      }

      /**
       * 根据分类筛选，包括本分类和次级分类
       *
       */

      if ($condition['category_id']) {

        $category = GoodsCategorySv::findOne(array('category_id' => $condition['category_id']));

        $subCategories = GoodsCategorySv::all(array('pid' => $condition['category_id']));

        $ids = array();

        array_push($ids, $category['category_id']);

        foreach($subCategories as $subCategory) {
        
          array_push($ids, $subCategory['category_id']);
        
        }
  
        $goods = GoodsSv::all(array('category_id' => implode(',', $ids)));

        $gids = array();

        foreach($goods as $good) {
        
          array_push($gids, $good['goods_id']);
        
        }

        $orderGoods = OrderTakeOutGoodsSv::all(array('goods_id' => implode(',', $gids), 'created_at' => $condition['created_at']), NULL, 'order_take_out_id');

        $orderIds = array();

        foreach($orderGoods as $orderGood) {
        
          array_push($orderIds, $orderGood['order_take_out_id']);
        
        }

        $condition['id'] = implode(',', $orderIds);

        unset($condition['category_id']);

      }

      unset($condition['goods_status']);

      unset($condition['token']);

      unset($condition['excel']);

      unset($condition['way']);

      if ($excel) {

        if ($condition['recommend_phone']) {
        
          $or = "(user_tel = {$condition['recommend_phone']} OR recommend_phone = {$condition['recommend_phone']})";
        
        }

        unset($condition['recommend_phone']);

        $orders = OrderTakeoutUnionSv::all($condition, 'create_time desc', '*', $or);
      
        self::exportExcel($orders);
      
      } else {

        if ($condition['recommend_phone']) {
        
          $or = "(user_tel = {$condition['recommend_phone']} OR recommend_phone = {$condition['recommend_phone']})";
        
        }

        unset($condition['recommend_phone']);

        $info = OrderTakeoutUnionSv::queryList($condition, $condition['fields'], 'create_time desc', $condition['page'], $condition['page_size'], $or);

        foreach ($info['list'] as &$v) {

            //if ($goods_status == 1) {

            //    $where_order_address['order_take_out_id'] = $v['id'];

            //    // 获取订单商品
            //    $info_order_goods = OrderTakeOutGoodsSv::getList($where_order_address);

            //    $v['goods_list'] = $info_order_goods;

            //}

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

      $query = array();

      if ($data['way'] == 1 && $condition['token']) {

          $info_user = UserSv::getUserByToken($condition['token']);

          $query['buyer_id'] = $info_user['uid'];

      }

      if ($condition['order_id']) {

          $query['order_take_out_id'] = $condition['order_id'];

      }

      unset($condition['order_id']);

      unset($condition['token']);

      unset($condition['way']);

      $info_order = self::findOne($query['order_take_out_id']);

      if (!$info_order) {

          throw new Exception('参数错误，查不到用户订单数据', 6001);

      }

      //获取业务员
      if ($info_user['reference']) {
      
        $reference = UserSv::findOne($info_user['reference']);

        $info_order['recommend_phone'] = $reference['user_tel'];
      
      }

      $info_shop = ShopSv::findOne($info_order['shop_id']);

      $info_order['shop_name'] = $info_shop['shop_name'];
      
      $info_order['shop_logo'] = $info_shop['shop_logo'] ? $info_shop['shop_logo'] : $info_shop['shop_banner'];

      $where_order_goods['order_take_out_id'] = $where_order_address['order_id'] = $info_order['id'];

      // 获取订单地址
      $info_order_address = OrderTakeOutAddressSv::getDetail($where_order_address);

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

      unset($data['way']);

      unset($data['token']);

      $data['sn'] = self::getSn();

      $data['order_status'] = 1;

      $data['create_time'] = date('Y-m-d H:i:s');
      
      $data_goods['cart_id'] = $data['cart_id'];

      // 验证商品

      //CartTakeOutSv::verify($data['cart_id'], $data['buyer_id']);

      $data_address['address_id'] = $data['address_id'];

      // 验证地址

      // 计算订单商品总价
      $data['goods_money'] = CartTakeOutSv::disposeGoods($data['cart_id'], $cityCode, $memberLevel, $data['invoice']);

      if ($data['coupon_id']) {
      
        $coupon = CouponSv::findOne($data['coupon_id']);

        $data['coupon_money'] = $coupon['money'];

        CouponSv::update($data['coupon_id'], array('state' => 2));
      
      } else {

        $data['coupon_money'] = 0;

      }

      unset($data['address_id']);

      unset($data['cart_id']);

      $data_goods['uid'] = $data_address['uid'] = $data['buyer_id'];

      $data['shipping_money'] = 0;

      $data['order_money'] = $data['goods_money'] + $data['shipping_money'];

      if ($data['coupon_money'] > 0) {
      
        $data['order_money'] -= $data['coupon_money'];
      
      }

      $balance = 0;

      $data['provider_id'] = $providerId;

      $data['buyer_message'] = $data['buyer_message']; // iconv('UTF-8', 'GBK', $data['buyer_message']);

      if ($data['invoice'] == 1) {
      
        $data['cas'] = 802;
      
      } else {
      
        if ($data['provider_id'] > 0) {
        
          $data['cas'] = 802;
        
        } else {
        
          $data['cas'] = 801;
        
        }
      
      }

      // 添加订单
      $orderId = self::add($data);

      /**
       * 下单通知
       *
       */
      $msgData = array(
      
        'mobile' => $info_user['user_tel'],
      
        'short_id' => 'OPENTM410929003',

        'minipage' => '/pages/order/detail/detal',

        'object_key' => 'order_id',

        'object_id' => $orderId,

        'contents' => "first\$\$小骏马下单||keyword1\$\${$data['sn']}||keyword2\$\${$data['create_time']}||remark\$\${$data['remark']}"
      
      );

      try {

        WechatTemplateMessageSv::generalMessage($msgData);


      } catch (\Exception $e) {
      
      
      }

      $dataManas = DataManagerSv::all(array('city_code' => $cityCode));

      foreach($dataManas as $dataMana) {

        $infoData = array(
        
          'mobile' => $dataMana['mobile'],
        
          'short_id' => 'OPENTM410929003',

          'minipage' => '',

          'object_key' => 'order_id',

          'object_id' => $orderId,

          'contents' => "first\$\$小骏马下单||keyword1\$\${$data['sn']}||keyword2\$\${$data['create_time']}||remark\$\$用户手机号：{$info_user['user_tel']}"
        
        );

        try {

          WechatTemplateMessageSv::generalMessage($infoData);

        } catch (\Exception $e) {
        
        
        }

      }

      $data_goods['order_id'] = $data_address['order_id'] = $id = $orderId;

      // 添加订单地址
      $info_order_address = OrderTakeOutAddressSv::addOrderAddress($data_address);

      // 添加订单商品
      $info_order_goods = OrderTakeOutGoodsSv::addOrderGoodsAll($data_goods, $data['invoice']);

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
            'money' =>  $data['order_money'],
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'open_id' => $info_user['wx_openid'],
            'nonce_str' => md5($info_user['wx_openid'] . time()),
            'body' => "{$member['nick_name']} 下单支付 {$data['money']}"
        );

        //调用微信预支付
        $payInfo = PaySv::wechatPayAction($payment);

        $payInfo['sn'] = $data['sn'];

        $payInfo['price'] = $data['order_money'];

        $payInfo['id'] = $id;

        return $payInfo;

      } else {

        // 提交事务
        $info_return['id'] = $id;
        
        $info_return['sn'] = $data['sn'];

        $info_return['price'] = $data['order_money'];

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
          
          $info_goods['price'] = !empty($priceRule) ? ( $data['invoice'] ? $priceRule['tax_off_price'] : $priceRule['price'] ) : ( $data['invoice'] ? $info_sku_goods['tax_off_price'] : $info_sku_goods['price']);
          
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
      $data['goods_money'] = $data_goods['goods_money'] = $data['quantity'] *  ($data['invoice'] ? $info_goods['tax_off_price'] : $info_goods['price']);

      unset($data['address_id']);

      unset($data['quantity']);

      unset($data['sku_id']);

      $data_goods['uid'] = $data_address['uid'] = $data['buyer_id'];

      $data['shipping_money'] = 0;

      if ($data['coupon_id']) {
      
        $coupon = CouponSv::findOne($data['coupon_id']);

        $data['coupon_money'] = $coupon['money'];

        CouponSv::update($data['coupon_id'], array('state' => 2));
      
      } else {

        $data['coupon_money'] = 0;

      }

      $data['order_money'] = $data['goods_money'] + $data['shipping_money'];

      if ($data['coupon_money']) {
      
        $data['order_money'] -= $data['coupon_money'];
      
      }

      $balance = 0;

      $data['pay_money'] = $money - $data['user_money'] - $data['user_platform_money'] - $data['promotion_money'];

      $data['shop_id'] = 0;
      
      $data['shop_name'] = '';

      $data['address_id'] = 0;

      $data['provider_id'] = $providerId;

      $data['buyer_message'] = $data['buyer_message']; // iconv('UTF-8', 'GBK', $data['buyer_message']);

      if ($data['invoice'] == 1) {
      
        $data['cas'] = 802;
      
      } else {
      
        if ($data['provider_id'] > 0) {
        
          $data['cas'] = 802;
        
        } else {
        
          $data['cas'] = 801;
        
        }
      
      }

      $orderId = self::add($data);
      
      /**
       * 下单通知
       *
       */
      $msgData = array(
      
        'mobile' => $info_user['user_tel'],
      
        'short_id' => 'OPENTM410929003',

        'minipage' => '/pages/order/detail/detal',

        'object_key' => 'order_id',

        'object_id' => $orderId,

        'contents' => "first\$\$小骏马下单||keyword1\$\${$data['sn']}||keyword2\$\${$data['create_time']}||remark\$\${$data['remark']}"
      
      );

      $dataManas = DataManagerSv::all(array('city_code' => $cityCode));

      try {

        /**
         * 通知客户
         */
        WechatTemplateMessageSv::generalMessage($msgData);

        foreach($dataManas as $dataMana) {

          $infoData = array(
          
            'mobile' => $dataMana['mobile'],
          
            'short_id' => 'OPENTM410929003',

            'minipage' => '',

            'object_key' => 'order_id',

            'object_id' => $orderId,

            'contents' => "first\$\$小骏马下单||keyword1\$\${$data['sn']}||keyword2\$\${$data['create_time']}||remark\$\$用户手机号：{$info_user['user_tel']}"
          
          );

          WechatTemplateMessageSv::generalMessage($infoData);

        }

      } catch (\Exception $e) {
      
      
      }

      // 添加订单
      $data_goods['order_take_out_id'] = $data_address['order_id'] = $id = $orderId;

      // 添加订单地址
      $info_order_address = OrderTakeOutAddressSv::addOrderAddress($data_address);

      $data_goods['shop_id'] = $data['shop_id'];

      $data_goods['price'] = $data['invoice'] ? $info_goods['tax_off_price'] : $info_goods['price'];

      //$data_goods['id'] = rand(100000000, 999999999);

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
            'money' => $data['order_money'],
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'open_id' => $info_user['wx_openid'],
            'nonce_str' => md5($info_user['wx_openid'] . time()),
            'body' => "{$member['nick_name']} 下单支付 {$data['money']}"
        );

        //调用微信预支付
        $payInfo = PaySv::wechatPayAction($payment);

        $payInfo['sn'] = $data['sn'];
        $payInfo['price'] = $data['order_money'];
        $payInfo['id'] = $id;

        return $payInfo;
      
      } else {

        $info_return['id'] = $id;
        
        $info_return['sn'] = $data['sn'];

        $info_return['price'] = $data['order_money'];
      
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

      } elseif ($data['sn']) {
      
        $condition['sn'] = $data['sn'];
      
      } else {
      
        return 0;
      
      }

      if ($data['driver_name']) {
      
        $data['driver_name'] = $data['driver_name']; // iconv('UTF-8', 'GBK', $data['driver_name']);
      
      }

      unset($data['order_id']);
      unset($data['sn']);

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

      return trim($sn);

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

    $totalPrice = 0;

    /**
     * 检查商品
     */
    foreach($orderGoods as $orderGood) {

      $good = GoodsSv::findOne($orderGood['goods_id']);

      if ($orderGood['num'] < 0) {
      
        continue;
      
      }

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

        $sku['tax_off_price'] = $priceRule['tax_off_price'];
      
      }

      /**
       * 购物车商品
       */
      //$cartGood['cart_id'] = rand(100000000, 999999999);

      $cartGood['buyer_id'] = $uid;

      $cartGood['goods_id'] = $orderGood['goods_id'];

      $cartGood['sku_id'] = $orderGood['sku_id'];

      $cartGood['goods_name'] = $good['goods_name'];

      $cartGood['sku_name'] = $sku['sku_name'];

      $cartGood['price'] = $sku['price'];

      $cartGood['tax_off_price'] = $sku['tax_off_price'];

      $cartGood['num'] = $orderGood['num'];

      $cartGood['goods_picture'] = $orderGood['goods_picture'];

      array_push($newCartGoods, $cartGood);
    
    }

    CartTakeOutSv::batchRemove(array('buyer_id' => $uid));

    $i = 0;

    foreach($newCartGoods as $cgood) {
    
      $i++;

      CartTakeOutSv::add($cgood);
    
    }

    return $i;

  }

  /**
   * 导出excel
   * @desc 导出excel
   *
   */
  public function exportExcel($orders) {
  
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Type:application/vnd.ms-excel');

    header('Content-Disposition: attachment;filename="订单数据.xlsx"');
    header('Cache-Control: max-age=0');
      
    $spreadsheet = new Spreadsheet();

    $titles = array(
    
      '订单编号', 
      '帐套号', 
      '收货人', 
      '收货联系电话', 
      '收货地址', 
      '会员名称', 
      '业务员手机号', 
      '订单金额', 
      '订单状态', 
      '支付状态', 
      '出库单号', 
      '退货单号', 
      '商品编码', 
      '商品名称', 
      '二级分类', 
      '三级分类', 
      '商品数量', 
      '商品总价', 
      '审核时间', 
      '下单时间', 
      '支付时间', 
      '发货时间',
      '签收时间'
    
    );

    $sheet = $spreadsheet->getActiveSheet();

    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    foreach($titles as $key => $title) {

      $sheet->setCellValue("{$characters[$key]}1", $title);
    
    }

    $sheet->getColumnDimension('A')->setWidth(30);

    $statusInfo = array(
    
      '已取消',
      '待付款',
      '待发货',
      '待收货',
      '已完成'
    
    );

    $row = 2;

    foreach($orders as $order) {

      $orderGoods = VOrderTakeOutGoodsUnionInfoSv::all(array('order_take_out_id' => $order['id']));

      foreach($orderGoods as $index => $orderGood) {
        
        $column = 0;

        $valueOrder = array(
        
          'sn' => $order['sn'] . '  ',
          
          'cas' => $order['cas'],

          'consigner' => $order['consigner'], // iconv('GBK', 'UTF-8', $order['consigner']),

          'mobile' => $order['mobile'],

          'address' => $order['address'], // iconv('GBK', 'UTF-8', $order['address']),

          'member_name' => $order['member_name'], // iconv('GBK', 'UTF-8', $order['member_name']),

          'recommend_phone' => $order['recommend_phone'], 

          'price' => $order['order_money'],

          'order_status' => $statusInfo[$order['order_status']],

          'pay_status' => $order['pay_status'] ? '已支付' : '未支付',

          'export_code' => $order['export_code'],

          'return_code' => $orderGood['return_code'],

          'no_code' => $orderGood['no_code'],

          'sku_name' => $orderGood['sku_name'], // iconv('GBK', 'UTF-8', $orderGood['sku_name']),

          'senior_cateogory' => $orderGood['senior_category_name'], // iconv('GBK', 'UTF-8', $orderGood['senior_category_name']),

          'sub_category' => $orderGood['sub_category_name'], // iconv('GBK', 'UTF-8', $orderGood['sub_category_name']),

          'num' => $orderGood['num'],

          'goods_money' => $orderGood['goods_money'],

          'audit_time' => $order['audit_time'] ? explode(' ', $order['audit_time'])[0] : '',

          'create_time' => $order['create_time'] ? explode(' ', $order['create_time'])[0] : '',

          'pay_time' => $order['pay_time'] ? explode(' ', $order['pay_time'])[0] : '',

          'consign_time' => $order['consign_time'] ? explode(' ', $order['consign_time'])[0] : '',

          'sign_time' => $order['sign_time'] ? explode(' ', $order['sign_time'])[0] : ''

        );

        foreach($valueOrder as $value) {

          $cell = "{$characters[$column]}{$row}";

          $sheet->setCellValue($cell, $value);

          $column++;

        }

        $row++;

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

      $address = OrderTakeOutAddressSv::findOne(array('order_take_out_id' => $order['id']));

      $goods = OrderTakeOutGoodsSv::all(array('order_take_out_id' => $order['id']));

      $sn = trim($order['sn']);

      $signKey = "csocode={$sn}ddate={$order['create_time']}wechatphone={$userInfo['user_tel']}TunZhoush@$58h";

      $signSecret = md5($signKey);

      if ($userInfo['reference']) {
      
        $cbUser = UserSv::findOne($userInfo['reference']);
      
      }

      $newAsync = array(

        'sign'  => $signSecret,
        'userid' => $order['buyer_id'],
        'wechatcode' => $userInfo['wx_openid'],
        'wechatname' => $member['member_name'], // iconv("GBK//IGNORE", "UTF-8", $member['member_name']),
        'wechatphone' => $userInfo['user_tel'],
        'csocode' => $sn,
        'ddate' => $order['create_time'],
        'couponno' => $order['coupon_id'],
        'couponmoney' => $order['coupon_money'],
        'cdepcode' => $order['city_code'],
        'cpersoncode' => "",
        'binvoice' => $order['invoice'],
        "cbuserid" => $cbUser['uid'],
        'cbuserphone' => $cbUser['user_tel'],
        'creceiver' => $address['consigner'], // iconv("GBK//IGNORE", "UTF-8", $address['consigner']),
        'creceiveraddress' => $address['address'], // iconv("GBK//IGNORE", "UTF-8", $address['address']),
        'creceiverphone' => $address['mobile'],
        'cmemo' => $order['buyer_message'], // iconv("GBK//IGNORE", "UTF-8", $order['buyer_message']),
        'caccid' => $order['cas']
      
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

    $responses = array();

    foreach($asyncs as $key => $trans) {
    
      $header = array( 'Content-Type:application/json;charset=utf-8' );
    
      $response = Http::httpPost("http://58.247.168.34:8008/api/u8/interface/create_salevoucher", json_encode($trans), $header);

      $result = json_decode($response, true);

      if ($result['status'] == 0) {
      
        self::update($orders[$key]['id'], array('audit' => 1, 'audit_time' => date('Y-m-d H:i:s')));

        /**
         * 审核成功的订单，为用户添加积分
         *
         */
        MemberAccountSv::addAccountPoints($orders[$key]['buyer_id'], intval($orders[$key]['order_money']), 1, $orders[$key]['id'], '下单返积分');
      
      }
      
      array_push($responses, $response);
    
    }

    return $responses;

  }

  /**
   * 删除订单
   * @desc 删除订单
   *
   * @return int num
   */
  public function removeOrder($params) {
  
    $orderId = $params['order_id'];

    /**
     * 删除订单商品数据
     */
    OrderTakeOutGoodsSv::batchRemove(array( 'order_take_out_id' => $orderId ));

    /**
     * 删除订单地址数据
     */
    OrderTakeOutAddressSv::batchRemove(array('order_take_out_id' => $orderId));
  

    /**
     * 删除订单主数据
     */
    return self::remove($orderId);

  }

  /**
   * 查询业务员销售总额
   *
   * @return number price
   */
  public function getSalesAmount($condition) {

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

    unset($condition['goods_status']);

    unset($condition['token']);

    unset($condition['way']);

    /**
     * 用户下单时间筛选
     */
    if ($condition['start_time'] && $condition['end_time']) {
      
      $startTime = date('Y-m-d', $condition['start_time']);

      $endTime = date('Y-m-d', $condition['end_time'] + 86400);
    
      $condition['create_time'] = "eg|{$startTime};el|{$endTime}";
    
    } elseif ($condition['start_time']) {
    
      $startTime = date('Y-m-d', $condition['start_time']);

      $condition['create_time'] = "eg|{$startTime}";
    
    } elseif ($condition['end_time']) {
    
      $endTime = date('Y-m-d', $condition['end_time'] + 86400);

      $condition['create_time'] = "el|{$endTime}";
    
    }

    /**
     * 用户注册时间筛选
     */
    if ($condition['reg_start'] && $condition['reg_end']) {
      
      $startTime = date('Y-m-d', $condition['reg_start']);

      $endTime = date('Y-m-d', $condition['reg_end'] + 86400);
    
      $condition['reg_time'] = "eg|{$startTime};el|{$endTime}";
    
    } elseif ($condition['reg_start']) {
    
      $startTime = date('Y-m-d', $condition['reg_start']);

      $condition['reg_time'] = "eg|{$startTime}";
    
    } elseif ($condition['reg_end']) {
    
      $endTime = date('Y-m-d', $condition['reg_end'] + 86400);

      $condition['reg_time'] = "el|{$endTime}";
    
    }

    /**
     * 根据分类筛选，包括本分类和次级分类
     *
     */

    if ($condition['category_id']) {

      $category = GoodsCategorySv::findOne(array('category_id' => $condition['category_id']));

      $subCategories = GoodsCategorySv::all(array('pid' => $condition['category_id']));

      $ids = array();

      array_push($ids, $category['category_id']);

      foreach($subCategories as $subCategory) {
      
        array_push($ids, $subCategory['category_id']);
      
      }
  
      $goods = GoodsSv::all(array('category_id' => implode(',', $ids)));

      $gids = array();

      foreach($goods as $good) {
      
        array_push($gids, $good['goods_id']);
      
      }

      $orderGoods = OrderTakeOutGoodsSv::all(array('goods_id' => implode(',', $gids), 'created_at' => $condition['created_at']), NULL, 'order_take_out_id');

      $orderIds = array();

      foreach($orderGoods as $orderGood) {
      
        array_push($orderIds, $orderGood['order_take_out_id']);
      
      }

      $condition['id'] = implode(',', $orderIds);

      unset($condition['category_id']);

    }

    if ($condition['recommend_phone']) {
    
      $or = "(user_tel = {$condition['recommend_phone']} OR recommend_phone = {$condition['recommend_phone']})";
    
    }

    unset($condition['recommend_phone']);

    if ($or) {

      $orders = OrderTakeoutUnionSv::all($condition, NULL, '*', $or);

    } else {

      $orders = OrderTakeoutUnionSv::all($condition);

    }

    $totalPrice = 0;

    $orderIds = array();

    foreach($orders as $order) {
    
      if ($order['order_status'] > 1) {
      
    //    $totalPrice += $order['order_money'];
        //
        array_push($orderIds, $order['id']);
      
      }
    
    }

    $orderGoods = OrderTakeOutGoodsSv::all(array('order_take_out_id' => implode(',', $orderIds)));

    foreach($orderGoods as $orderGood) {
    
      $totalPrice += $orderGood['goods_money'];
    
    }

    return $totalPrice;
  
  }

  /**
   * 订单售后
   *
   * @param array data
   *
   */
  function orderAfterSale($data) {

    $sn = $data['sn'];
  
    $info_order = self::findOne(array('sn' => $sn));

    $goods = OrderTakeOutGoodsSv::all(array('sku_id' => $data['sku_id'], 'order_take_out_id' => $info_order['id']));

    $count = 0;

    foreach($goods as $good) {
    
      $count += $good['num'];
    
    }

    $num = $data['num'];

    if ($count >= $num) {

      $good = $goods[0];

      $userInfo = UserSv::findOne($info_order['buyer_id']);

      $member = MemberSv::findOne($info_order['buyer_id']);

      $manager = ManagerSv::findOne(array('phone' => $userInfo['user_tel']));

      $address = OrderTakeOutAddressSv::findOne(array('order_take_out_id' => $info_order['id']));

      $date = date('Y-m-d H:i:s');

      $cretcode = substr(trim($sn) . rand(1000, 9999), 4, strlen(trim($sn)));

      $signKey = "cretcode={$cretcode}ddate={$date}wechatphone={$userInfo['user_tel']}TunZhoush@$58h";

      $signSecret = md5($signKey);

      if ($userInfo['reference']) {
      
        $cbUser = UserSv::findOne($userInfo['reference']);
      
      }

      $newAsync = array(

        'sign'  => $signSecret,
        'userid' => $info_order['buyer_id'],
        'wechatcode' => $userInfo['wx_openid'],
        'wechatname' => $member['member_name'], // iconv("GBK//IGNORE", "UTF-8", $member['member_name']),
        'wechatphone' => $userInfo['user_tel'],
        'cretcode' => $cretcode,
        'csocode' => trim($sn),
        'ddate' => $date,
        'cdepcode' => $info_order['city_code'],
        'binvoice' => $info_order['invoice'],
        "cbuserid" => $cbUser['uid'] ? $cbUser['uid'] : "",
        'cbuserphone' => $cbUser['user_tel'] ? $cbUser['user_tel'] : "",
        'creceiver' => $address['consigner'], // iconv("GBK//IGNORE", "UTF-8", $address['consigner']),
        'creceiveraddress' => $address['address'], // iconv("GBK//IGNORE", "UTF-8", $address['address']),
        'creceiverphone' => $address['moabile'],
        'cmemo' => $order['buyer_message'], // iconv("GBK//IGNORE", "UTF-8", $order['buyer_message']),
        'caccid' => $info_order['cas']
      
      );

      $newAsync['detail'] = array();

      $orderGood = array(
      
        'autoid' => $good['id'],
        'iunsid' => $good['id'],
        'cinvcode' => $good['no_code'],
        'iquantity' => $num,
        'iprice' => abs($good['price']),
        'imoney' => $good['price'] * $num
      
      );

      array_push($newAsync['detail'], $orderGood);
      
      $header = array( 'Content-Type:application/json;charset=utf-8' );
      
      $response = Http::httpPost("http://58.247.168.34:8008/api/u8/interface/create_salereturnvoucher", json_encode($newAsync), $header);

      $result = json_decode($response, true);

      if ($result['status'] == 0) {
      
        self::update($orders[$key]['id'], array('audit' => 0));
      
      }
   
      return $result;
    
    } else {
    
      return array('status' => -1, 'msg' => '退货数量已达上限');
    
    }
  
  }

  public function getOrderNum($data) {
  
    $user = UserSv::getUserByToken($data['token']);

    $orders = self::all(array('buyer_id' => $user['uid'])); 

    $nopayNum = 0;

    $deliverNum = 0;

    $receiveNum = 0;
  
    foreach($orders as $order) {

      if ($order['order_status'] == 1) {
      
        $nopayNum++;
      
      }
    
      if ($order['order_status'] == 2) {
      
        $deliverNum++;
      
      }

      if ($order['order_status'] == 3) {
      
        $receiveNum++;
      
      }
    
    }

    return array( 'nopayNum' => $nopayNum, 'deliver_num' => $deliverNum, 'receive_num' => $receiveNum);
  
  }

  public function getTransFirstLocation($data) {
    
    return TransSv::queryList(array('order_id' => $data['order_id']), '*', 'id desc', 1, 1);
  
  }

  public function cancelReturnGoods($data) {
  
    return OrderTakeOutGoodsSv::remove($data['id']);
  
  }

}
