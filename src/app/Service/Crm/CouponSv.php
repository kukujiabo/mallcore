<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use App\Interfaces\Crm\ICoupon; 
use App\Model\Coupon;
use Core\Service\CurdSv;
use App\Model\CouponType;
use App\Exception\CouponException;
use App\Exception\UserException;
use App\Exception\ErrorCode;
use App\Service\Shop\ShopSv;
use App\Service\Crm\UserSv;
use App\Service\Crm\MemberSv;
use App\Service\Crm\MemberAccountSv;
use App\Service\Crm\CouponGrantLogSv;
use App\Service\Takeaway\CartTakeOutSv;
use App\Service\Commodity\GoodsSv;
use App\Service\Commodity\GoodsSkuSv;
use App\Service\Wechat\WechatTemplateMessageSv;

/**
 * 优惠券实例
 *
 * @author Meroc Chen <398515393@qq.com> 2017-10-11
 */
class CouponSv extends BaseService implements ICoupon {

  use CurdSv;

  /**
   * 1.使用优惠券，标记优惠券为已用，需要记录日志
   * 
   * @param string $code 优惠券编码
   * @param string $orderNo 优惠券使用订单号
   *
   * @return boolean true/false
   */
  public function setUsed($coupon, $orderNo, $phone = '', $channel = '') {

    $data['state'] = 2;

    $data['use_time'] = date('Y-m-d H:i:s');

    if ($orderNo) {

      $data['use_order_id'] = $orderNo;

    }

    $num = self::update(

      $coupon['coupon_id'], 

      $data

    );

    if ($num) {

      $user = $phone ? UserSv::findOne(array('user_tel' => $phone)) : null;

      if ($coupon['uid']) {

        $user['uid'] = $coupon['uid'];

      }

      $log = array(
      
        'uid' =>  $user ? $user['uid'] : 0,

        'coupon_id' => $coupon['coupon_id'],

        'money' => $coupon['money'],

        'percentage' => $coupon['percentage'],

        'channel' => $channel,

        'order_id' => $orderNo,

        'created_at' => date('Y-m-d H:i:s')
      
      );
    
      CouponUseLogSv::add($log);

      return true;
    
    } else {
    
      throw new CouponException(

        ErrorCode::CouponSv['COUPON_USE_FAILED_MSG'], 

        ErrorCode::CouponSv['COUPON_USE_FAILED_CODE'],

        $couponCode

      );
    
    }

  }

  /**
   * 获取全部可用的优惠券
   */
  public function getAvailableCoupon($data) {

    if ($data['type'] == 1) {

      $money = CartTakeOutSv::disposeGoods($data['cart_id']);

    } else {

      $goods_where['goods_id'] = $data['goods_id'];

      if ($data['sku_id']) {

        $goods_where['sku_id'] = $data['sku_id'];

        $info_goods = GoodsSkuSv::findOne($goods_where);

      } else {

        $info_goods = GoodsSv::findOne($goods_where);

      }

      $money = $info_goods['price'] * $data['num'];

    }

    $info_user = UserSv::getUserByToken($data['token']);

    $conditions['uid'] = $info_user['uid'];

    $conditions['state'] = 1;

    $conditions['online_type'] = '1,3';

    $list_copuon = self::all($conditions);

    $array = array();

    foreach ($list_copuon as $v) {

      try {

        self::isAvailable($v, $data['shop_id'], $money, 'online');

        array_push($array, $v);

      } catch (\Exception $e) {

      }

    }

    return $array;

  }

  /**
   * 2.判断优惠券是否可用（根据有效期，状态state，店铺id，商品id判断该优惠券是否可用）
   *
   * @param array $coupon 优惠券实例
   * @param int $shopId 商铺id
   * @param int $goodId 商品id
   * @param int $date 使用日期
   *
   * @return boolean true/false
   */
  public function isAvailable($coupon, $shopId, $money, $channel) {
  
    /**
     * (1)查询优惠券
     *
     * @desc 判断优惠券是否存在以及是否可用 
     */
    if (!$coupon || $coupon['state'] != 1) {
    
      throw new CouponException(

        ErrorCode::CouponSv['COUPON_INVALID_MSG'], 

        ErrorCode::CouponSv['COUPON_INVALID_CODE'],

        $coupon

      );
    
    }

    /**
     * (2)判断优惠券是否在有效期内
     */
    if (strtotime($coupon['start_time']) > time()) {
    
      throw new CouponException(

        ErrorCode::CouponSv['COUPON_NOT_START_MSG'], 

        ErrorCode::CouponSv['COUPON_NOT_START_CODE'],

        $coupon

      );
    
    } 

    if (!empty($coupon['end_time']) && strtotime($coupon['end_time']) < time()) {
    
      throw new CouponException(

        ErrorCode::CouponSv['COUPON_EXPIRED_MSG'], 

        ErrorCode::CouponSv['COUPON_EXPIRED_CODE'],

        $coupon

      );
    
    }

    /**
     * (3)查询门店
     *
     * @desc 判断是否全店通用，若不是，则判断所指定的门店是否可用
     */
    if (!$coupon['all_shops']) {

      $shop = null;
    
      switch ($channel) {
      
        case 'pos':

          $shop = ShopSv::findOne(array('pos_id' => $shopId));

          break;

        default:

          $shop = ShopSv::findOne($shopId);

          break;
      
      }

      $shops = explode(',', $coupon['shop_id']);

      if (!$shops || !in_array($shop['shop_id'], $shops)) {
      
        throw new CouponException(

          ErrorCode::CouponSv['COUPON_WRONG_STORE_MSG'], 

          ErrorCode::CouponSv['COUPON_WRONG_STORE_CODE'],

          $coupon

        );
      
      }
    
    }

    /**
     * (4)查询使用金额
     *
     * @desc 查看订单满额情况
     */
    if (floatval($coupon['at_least']) > 0) {
    
      if (floatval($money) < floatval($coupon['at_least'])) {
      
        throw new CouponException(

          ErrorCode::CouponSv['COUPON_MONEY_UNSATI_MSG'], 

          ErrorCode::CouponSv['COUPON_MONEY_UNSATI_CODE'],

          $code

        );
      
      }
    
    }

    return true;
  
  }

  /**
   * 3.核销优惠券（根据券号，门店id，金额，会员手机号）
   *
   * @param string $code
   * @param string $shopId
   * @param float money
   * @param string phone
   *
   * @return int 1
   */
  public function useCoupon($code, $shopId, $money, $orderNo, $phone = '', $channel = '') {

    $coupon = self::findOne(array('coupon_code' => $code));

    self::isAvailable($coupon, $shopId, $money, $channel);
    
    self::setUsed($coupon, $orderNo, $phone, $channel);

    return 1;
  
  }


  /**
   * 3.发放优惠券
   *
   * @param string $cid  优惠券类型id
   * @param string $uid  用户id
   *
   * @return boolean true/false
   */
  public function grant($cid, $uid) {
  
    /**
     * 首先判断该类型优惠券是否符合发放条件
     *
     * 1.当前是否标记有效
     * 2.当前是否在有效期内
     * 3.是否存在最大发放数量限制
     * 4.是否对个人存在发放数量限制
     */

    $couponType = CouponTypeSv::findActiveOne($cid);

    /**
     * 符合发放条件，将相关类型优惠券插入表中
     */

    $insertData = array(

      'coupon_type_id' => $cid,

      'uid' => $uid,

      'state' => 1,

      'fetch_time' => date('Y-m-d H:i:s'),

      'coupon_name' => $couponType['coupon_name'],

      'money' => $couponType['money'],

      'percentage' => $couponType['percentage'],

      'deduction_type' => $couponType['deduction_type'],

      'shop_id' => $couponType['shop_id'],

      'coupon_code' => $couponType['sequence'] . self::getRandCouponCode(),

      'online_type' => $couponType['online_type'],

      'ext_1' => $couponType['ext_1'],

      'ext_2' => $couponType['ext_2']

    );

    $insertData['qr_code'] = \App\qrCode($insertData['coupon_code'], true);

    try {

      $datetime = date('Y-m-d H:i:s');

      $register = array(
      
        'short_id' => 'OPENTM203067265',
      
        'uid' => $uid,
      
        'contents' => "first\$\$您获得一张优惠券||keyword1\$\${$insertData['coupon_name']}||keyword2\$\$1||keyword3\$\${$datetime}"
      
      );
      
      WechatTemplateMessageSv::generalMessage($register);

    } catch (\Exception $e) {

    
    }

    return self::add($insertData);
  
  }

  /**
   * pos查询会员可用优惠券
   *
   * @param array $data
   *
   * @return
   */
  public function posQueryAvailableCoupons($data) {

    $coupon = null;
  
    if ($data['phone']) {

      $coupons = self::getAvailableCouponByPhone($data['phone'], $data['shop_id'], $data['money'], 'pos');
    
    } elseif ($data['card_id']) {
    
      $coupons = self::getAvailableCouponByCardId($data['card_id'], $data['shop_id'], $data['money'], 'pos');
    
    }

    foreach($coupons as $key => $coupon) {
    
      $filter = array(

        'coupon_name' => $coupon['coupon_name'], //优惠券名称

        'coupon_code' => $coupon['coupon_code'], //优惠券编号

        'money' => $coupon['money'], //抵扣金额，当抵扣类型（deduction_type）为1时有效

        'state' => $coupon['state'], //优惠券状态：1.未使用，2.已使用，3.已过期

        'deduction_type' => $coupon['deduction_type'], //抵扣类型：1.抵扣，2.折扣

        'percentage' => $coupon['percentage'], //折扣，当抵扣类型（deduction_type）为2时有效

        'at_least' => $coupon['at_least'], //订单消费金额，满额可用

        'ext_1' => $coupon['ext_1'], //pos商品大类，用逗号分隔

        'ext_2' => $coupon['ext_2'], //pos商品单品条形码，用逗号分隔
      
      );

      $startDate = date('Y-m-d', strtotime($coupon['start_time']));

      $endDate = date('Y-m-d', strtotime($coupon['end_time']));

      $filter['datetime'] = $coupon['last_long'] ? '长期有效' : "{$startDate} ~ {$endDate}";
    
      $coupons[$key] = $filter;

    }

    return $coupons;
  
  }


  /**
   * 根据会员卡号获取用户可用优惠券
   *
   * @param string $cardId
   * @param string $shopId
   * @param float $money
   * @param string $channel
   *
   * @return 
   */
  public function getAvailableCouponByCardId($cardId, $shopId, $money, $channel) {
  
    $acct = MemberAccountSv::findOne(array('card_id' => $cardId));

    if (!$acct) {

      throw new UserException('未查找到用户！', 500291, $cardId);

    }

    return self::getAvailableCouponByUid($acct['uid'], $shopId, $money, $channel);
  
  }

  /**
   * 根据手机号获取用户可用优惠券
   *
   * @param string $phone
   * @param string $shopId
   * @param float $money
   * @param string $channel
   *
   * @return 
   */
  public function getAvailableCouponByPhone($phone, $shopId, $money, $channel) {
  
    $user = UserSv::findOne(array('user_tel' => $phone));

    if (!$user) {

      throw new UserException('未查找到用户！', 500291, $phone);

    }

    return self::getAvailableCouponByUid($user['uid'], $shopId, $money, $channel);
  
  }

  /**
   * 根据uid获取可用优惠券
   *
   * @param int $uid
   * @param string $shopId
   * @param float $money
   * @param string $channel
   *
   * @return 
   */
  public function getAvailableCouponByUid($uid, $shopId, $money, $channel) {
  
    $coupons = self::all(array('uid' => $uid, 'state' => 1));

    $acs = array();

    foreach($coupons as $coupon) {

      try {
    
        if (self::isAvailable($coupon, $shopId, $money, $channel)) {
        
          array_push($acs, $coupon);
        
        }

      } catch (CouponException $e) {
      
      
      }
    
    }

    return $acs;
  
  }

  /**
   * 批量添加优惠券（多种券，多用户）
   * 
   * @param array $couopnIds   优惠券id数组
   * @param array $memberIds   会员id数组
   *
   * @return 
   */
  public function batchGrant($couponIds, $memberIds, $sequence, $remark) {

    $newCoupons = array();
  
    foreach($couponIds as $couponId) {

      $cid = is_array($couponId) ? $couponId['key'] : $couponId;

      $num = is_array($couponId) ? intval($couponId['num']) : 0;

      $couponType = CouponTypeSv::findActiveOne($cid);

      $datetime = date('Y-m-d H:i:s');

      foreach($memberIds as $memberId) {
      
        $insertData = array(

          'coupon_type_id' => $cid,

          'uid' => $memberId,

          'state' => 1,

          'fetch_time' => $datetime,

          'coupon_name' => $couponType['coupon_name'],

          'money' => $couponType['money'],

          'percentage' => $couponType['percentage'],

          'deduction_type' => $couponType['deduction_type'],

          'all_shops' => $couponType['all_shops'],

          'at_least' => $couponType['at_least'],

          'online_type' => $couponType['online_type'],

          'ext_1' => $couponType['ext_1'],

          'ext_2' => $couponType['ext_2'],

        );


        /**
         * 设置使用门店
         */

        if ($couponType['all_shops']) {
        
          $insertData['shop_id'] = 0;
        
        } else {

          $insertData['shop_id'] = $couponType['shop_id'];
        
        }

        /**
         * 设置有效期类型
         */

        if ($couponType['term_type'] == 1) {
        
          $insertData['start_time'] = $couponType['start_time'];

          $insertData['end_time'] = $couponType['end_time'];
        
        } elseif ($couponType['term_type'] == 2) {

          if (!$couponType['last_long']) {
          
            $insertData['start_time'] = date('Y-m-d H:i:s');

            $insertData['end_time'] = date('Y-m-d H:i:s', (time() + (intval($couponType['valid_days']) * 3600 * 24)));

          } else {
          
            $insertData['last_long'] = $couponType['last_long'];
          
          }
        
        }

        for($i = 0; $i < $num; $i++) {

          $insertData['coupon_code'] = $couponType['sequence'] . self::getRandCouponCode();

          $insertData['qr_code'] = \App\qrCode($insertData['coupon_code'], true);

          array_push($newCoupons, $insertData);

          try {

            $register = array(
            
              'short_id' => 'OPENTM203067265',

              'uid' => $memberId,

              'contents' => "first\$\$您获得一张优惠券||keyword1\$\${$insertData['coupon_name']}||keyword2\$\$1||keyword3\$\${$datetime}"

            );

            WechatTemplateMessageSv::generalMessage($register);

          } catch (\Exception $e) {
          
          
          }

        }

      }
    
    }

    $number = self::batchAdd($newCoupons);

    /**
     * 添加发放优惠券日志
     */

    if ($number) {

      $logs = array();

      foreach($newCoupons as $newCoupon) {
      
        $log = array(
        
          'sequence' => $sequence,

          'remark' => $remark,

          'coupon_type_id' => $newCoupon['coupon_type_id'],

          'coupon_code' => $newCoupon['coupon_code'],

          'rule_id' => 0,

          'action' => 'admin',

          'uid' => $newCoupon['uid'],

          'created_at' => date('Y-m-d H:i:s')
        
        );

        array_push($logs, $log);

      }

      CouponGrantLogSv::batchAdd($logs);
    
      return $number;
    
    } else {
    
      return 0;
    
    }
  
  }

  /**
   * 后台批量添加优惠券
   *
   * @param array $params
   *
   * @return 
   */
  public function adminBatchAdd($params) {
  
    $coupons = json_decode($params['coupons'], true);

    $members = null;

    if ($params['member_name']) {

      if (strpos($params['member_name'], ' ')) {
      
        $memberName = implode(',', explode(' ', $params['member_name']));

      } else {
      
        $memberName = $params['member_name'];
      
      }

      $members = MemberSv::all(array('member_name' => $memberName));
    
    } elseif ($params['user_tel']) {

      if (strpos($params['user_tel'], ' ')) {
      
        $userTel = implode(',', explode(' ', $params['user_tel']));

      } else {
      
        $userTel = $params['user_tel'];
      
      }
    
      $members = UserSv::all(array('user_tel' => $userTel));
    
    } elseif ($params['card_id']) {
    
      if (strpos($params['card_id'], ' ')) {
      
        $cardId = implode(',', explode(' ', $params['card_id']));

      } else {
      
        $cardId = $params['card_id'];
      
      }

      $members = MemberAccountSv::all(array('card_id' => $cardId));
    
    }

    $mids = array();

    foreach($members as $member) {
    
      array_push($mids, $member['uid']);
    
    }

    return self::batchGrant($coupons, $mids, $params['sequence'], $params['remark']);

  }

  /**
   * 获取优惠券二维码
   */
  public function getCouponQrCode ($conditions) {

    $info_user = UserSv::getUserByToken($conditions['token']);

    $conditions['uid'] = $info_user['uid'];
    
    unset($conditions['token']);

    $info_conupon = self::findOne($conditions);

    if ($info_conupon['qr_code'] && file_exists(API_ROOT . '/static/' . $info_conupon['qr_code'])) {

      $qr_code = $info_conupon['qr_code'];

    } else {

      $qr_code = \App\qrCode($info_conupon['coupon_code']);

      if (!$qr_code) {

          throw new Exception(ErrorCode::System['QR_CODE_ERR_MSG'], ErrorCode::System['QR_CODE_ERR_CODE']);

      }

      self::update($info_conupon['coupon_id'], array('qr_code'=>$qr_code));

    }

    return array('qr_code' => $qr_code);

  }

  /**
   * 生成优惠群实例随机码
   */
  protected static function getRandCouponCode() {

    return \App\getRandomString(8) . rand(100, 999);
  
  }

  /**
   * 计算优惠价格
   * @param float $data['total'] 总价
   * @param int $data['coupon_id'] 优惠券id
   * @param int $data['info_coupon'] 优惠券详情
   * @return float money 优惠金额
   * @return int type 优惠类型 1 折扣，2 现金，3 包邮
   */
  public function calculate($data) {

    $info_coupon = $data['info_coupon'];

    if (!$info_coupon) {

      $info_coupon = self::findOne($data['coupon_id']);

    }

    if ($info_coupon['deduction_type'] == 1) {

      $money = round($info_coupon['percentage'] / 100 * $data['total'], 2);

    } else {

      $money = $info_coupon['money'];

    }

    $arr['money'] = $money;

    $arr['type'] = $info_coupon['deduction_type'];

    return $arr;

  }

}
