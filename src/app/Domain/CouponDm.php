<?php
namespace App\Domain;

use App\Service\Crm\CouponSv;
use App\Service\Crm\UserSv;

/**
 *
 * @author Meroc Chen <398515393@qq.com> 2017-10-12
 */
class CouponDm {

  /**
   * 新增优惠券
   */
  public function add($data) {

    return CouponSv::create($data);
  
  }

  public function queryList($condition) {

    if ($condition['way'] == 1 && $condition['token']) {

      $info_user = UserSv::getUserByToken($condition['token']);

      $condition['uid'] = $info_user['uid'];

    }

    unset($condition['way']);
    
    unset($condition['token']);

    return CouponSv::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);
  
  }

  public function queryCount($condition) {

    if ($condition['way'] == 1 && $condition['token']) {

      $info_user = UserSv::getUserByToken($condition['token']);

      $condition['uid'] = $info_user['uid'];

    }

    unset($condition['way']);
    
    unset($condition['token']);
  
    return CouponSv::queryCount($condition);

  }

  /**
   * pos核销优惠券
   */
  public function posUseCoupon($data) {
  
    return CouponSv::useCoupon(
      $data['code'], 
      $data['shopId'], 
      $data['money'], 
      $data['orderNo'],
      $data['phone'], 
      'pos'
    );
  
  }

  /**
   * 后台管理员批量添加为用户添加优惠券
   */
  public function adminBatchAdd($params) {
  
    return CouponSv::adminBatchAdd($params);
  
  }

  /**
   * 获取优惠券二维码
   */
  public function getCouponQrCode($conditions) {
  
    return CouponSv::getCouponQrCode($conditions);
  
  }

  /**
   * 获取可用优惠券
   */
  public function getAvailableCoupon($data) {
  
    return CouponSv::getAvailableCoupon($data);
  
  }

  /**
   * pos查询可用优惠券
   */
  public function posQueryAvailableCoupons($data) {
  
    return CouponSv::posQueryAvailableCoupons($data);
  
  }

}
