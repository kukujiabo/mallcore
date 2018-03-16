<?php
namespace App\Model;

class CouponGrantLogUnion extends BaseModel {

  protected $_queryOptionRule = array(

    'created_at' => 'range',

    'member_name' => 'like',

    'coupon_code' => 'like',

    'coupon_name' => 'like',

    'sequence' => 'sequence'

  );

  protected $_table = 'v_coupon_grant_union_info';

}
