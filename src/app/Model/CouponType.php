<?php
namespace App\Model;

/**
 * [模型层] 优惠券种类
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-18
 *
 */
class CouponType extends BaseModel {

  protected $_primaryKey = 'coupon_type_id';

  protected $_queryOptionRule = array(
    'coupon_type_id' => 'in',
    'coupon_name' => 'like',
    'start_time' => 'range',
    'end_time' => 'range',
    'create_time' => 'range',
    'update_time' => 'range'
  );


}
