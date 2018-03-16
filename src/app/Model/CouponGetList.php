<?php
namespace App\Model;

/**
 * [模型层] 优惠券获取列表
 *
 * @author Meroc Chen <398515393@qq.com> 2018-01-28
 */
class CouponGetList extends BaseModel {

  protected $_table = 'v_coupon_get_list';

  protected $_queryOptionRule = array(
  
    'member_name' => 'like',

    'coupon_name' => 'like'
  
  );

}
