<?php
namespace App\Model;

/**
 * [模型层] 优惠券
 *
 * @author:  Meroc Chen <398515393@qq.com> 2017-10-11
 */
class Coupon extends BaseModel {

  protected $_primaryKey = 'coupon_id';

  protected $_queryOptionRule = array(

    'start_time' => 'range',

    'end_time' => 'range',

    'online_type' => 'in'

  );

}
