<?php
namespace App\Service\CouponExchange;

use App\Service\BaseService;
use App\Service\CouponExchange\CouponExchangeGoodsSv;
use App\Service\Commodity\GoodsSv;
use App\Interfaces\CouponExchange\ICouponExchange;
use App\Model\CouponExchange;
use Core\Service\CurdSv;
use App\Exception\CouponExchangeException;
use PhalApi\Exception;
use App\Exception\ErrorCode;
use App\Service\CouponExchange\CouponVerificationLogSv;
use App\Service\Crm\UserSv;

/**
 * 提领券接口
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-21
 */
class CouponExchangeSv extends BaseService implements ICouponExchange {

  use CurdSv;

  public function grantCouponExchangeSv() {
  
  
  }

  /**
   * 新增
   */
  public function addCouponExchange($data) {

    $goods_id = $data['goods_id'];

    unset($data['goods_id']);

    $data['create_time'] = date("Y-m-d H:i:s");
    
    $img = \App\qrCode($data['heading_code']);

    if ($img) {

      $data['img'] = $img;

    }

    try{

      $id = self::add($data);

      $data_goods['goods_id'] = $goods_id;

      $data_goods['coupon_exchange_id'] = $id;

      $coupon_exchange_goods_id = CouponExchangeGoodsSv::add($data_goods);

      return $id;

    } catch (\Exception $e) {

      throw new InternalServerErrorException('新增失败', 1);

    }
  
  }

  /**
   * 编辑
   */
  public function edit($data) {
    
    $where['id'] = $data['id'];

    unset($data['id']);

    return self::batchUpdate($where, $data);
  
  }

  /**
   * 获取列表
   */
  public function getList($condition) {

    if ($condition['way'] == 1 && $condition['token']) {

      $info_user = UserSv::getUserByToken($condition['token']);

      $condition['owner_id'] = $info_user['uid'];

    }

    unset($condition['token']);

    unset($condition['way']);

    $info = self::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);

    foreach ($info['list'] as &$v) {

      $where['coupon_exchange_id'] = $v['id'];

      $goods = CouponExchangeGoodsSv::findOne($where);

      $goods_info = GoodsSv::findOne($goods['goods_id']);

      $v['goods_id'] = $goods_info['goods_id'];
      $v['price'] = $goods_info['price'];
      $v['picture'] = $goods_info['picture'];
      $v['goods_name'] = $goods_info['goods_name'];

    }
    unset($v);

    return $info;
  
  }

  /**
   * 获取总数
   */
  public function getCount($condition) {

    return self::queryCount($condition);
  
  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {

    if ($condition['way'] == 1 && $condition['token']) {

      $info_user = UserSv::getUserByToken($condition['token']);

      $condition['uid'] = $info_user['uid'];

    }

    unset($condition['token']);

    unset($condition['way']);
    
    $list = CouponExchange::queryList($condition, $condition['fields'], $condition['order'], 0, 1);

    return $list[0];

  }

  /**
   * 提领券兑换下单
   */
  public function conversion($condition) {

    $address_id = $condition['address_id'];

    $info_user = UserSv::getUserByToken($condition['token']);

    $condition['owner_id'] = $info_user['uid'];

    unset($condition['token']);

    unset($condition['address_id']);
    
    $info = self::cancelVerify($condition);

  }

  /**
   * 提领券核销验证
   * @param array $info 券信息
   */
  public function cancelVerify($condition) {

    $owner_id = $condition['owner_id'];

    unset($condition['owner_id']);
    
    // 获取券信息
    $info = self::getDetail($condition);

    if ($info) {

      $time = date("Y-m-d H:i:s");

      if ($info['status'] == 2) {

        throw new Exception(
          ErrorCode::CouponExchangeSv['COUPON_EXCHANGE_ACCT_PASS_USE_ERR_MSG'], 
          ErrorCode::CouponExchangeSv['COUPON_EXCHANGE_ACCT_PASS_USE_ERR_CODE']
          );

      } elseif ($info['status'] == 5) {

        throw new Exception(
          ErrorCode::CouponExchangeSv['COUPON_EXCHANGE_ACCT_PASS_ACTIVATE_ERR_MSG'], 
          ErrorCode::CouponExchangeSv['COUPON_EXCHANGE_ACCT_PASS_ACTIVATE_ERR_CODE']
          );

      } elseif ($info['status'] == 3) {

        throw new Exception(
          ErrorCode::CouponExchangeSv['COUPON_EXCHANGE_ACCT_PASS_STOP_ERR_MSG'], 
          ErrorCode::CouponExchangeSv['COUPON_EXCHANGE_ACCT_PASS_STOP_ERR_CODE']
          );

      } elseif ($info['status'] == 4 || (strtotime($info['end_time']) && $info['end_time'] < $time)) {

        throw new Exception(
          ErrorCode::CouponExchangeSv['COUPON_EXCHANGE_ACCT_PASS_END_TIME_ERR_MSG'], 
          ErrorCode::CouponExchangeSv['COUPON_EXCHANGE_ACCT_PASS_END_TIME_ERR_CODE']
          );

      } elseif (strtotime($info['start_time']) && $info['start_time'] > $time) {

        throw new Exception(
          ErrorCode::CouponExchangeSv['COUPON_EXCHANGE_ACCT_PASS_START_TIME_ERR_MSG'], 
          ErrorCode::CouponExchangeSv['COUPON_EXCHANGE_ACCT_PASS_START_TIME_ERR_CODE']
          );

      } elseif ($info['owner_id'] && $info['owner_id'] != $owner_id) {

        throw new Exception(
          ErrorCode::CouponExchangeSv['COUPON_EXCHANGE_ACCT_PASS_MEMBER_ERR_MSG'], 
          ErrorCode::CouponExchangeSv['COUPON_EXCHANGE_ACCT_PASS_MEMBER_ERR_CODE']
          );

      }

      return $info;

    } else {

      throw new Exception(
        ErrorCode::CouponExchangeSv['COUPON_EXCHANGE_ACCT_PASS_RETURN_MSG'], 
        ErrorCode::CouponExchangeSv['COUPON_EXCHANGE_ACCT_PASS_RETURN_CODE']
        );

    }

  }

  /**
   * 提领券核销
   */
  public function cancel($condition) {

    // 验证提领券
    $info_coupon = self::cancelVerify($condition);

    if ($condition['token']) {

      $info_user = UserSv::getUserByToken($condition['token']);

      $condition['uid'] = $info_user['uid'];

    }

    unset($condition['token']);

    $data_coupon_verification_log['coupon_exchange_id'] = $info_coupon['id'];

    // $data_coupon_verification_log['cancel_id'] = $condition['cancel_id'];

    // $data_coupon_verification_log['cancel_after_verification'] = $condition['cancel_after_verification'];

    $data_coupon_verification_log['uid'] = $condition['uid'];

    $data['cancel_time'] = $data_coupon_verification_log['created_at'] = date("Y-m-d H:i:s");

    // 提领券核销记录
    CouponVerificationLogSv::add($data_coupon_verification_log);

    $data['user_id'] = $condition['uid'];

    $data['status'] = 2;

    // 修改提领券状态
    $info = self::update($info_coupon['id'], $data);

    if (!$info) {

      throw new Exception(
        ErrorCode::CouponExchangeSv['COUPON_VERIFICATION_RETURN_MSG'], 
        ErrorCode::CouponExchangeSv['COUPON_VERIFICATION_RETURN_CODE']
        );
      
    }

    return array('status'=>true);

  }

}
