<?php
namespace App\Model;

/**
 * [模型层] 优惠券发放规则
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-18
 *
 */
class CouponGrantRule extends BaseModel {

  protected $_queryOptionRule = array(
    'grant_total_num' => 'range',
    'grant_individual_num' => 'range',
    'start_date' => 'range',
    'end_date' => 'range',
    'created_at' => 'range',
    'updated_at' => 'range',
    'deleted_at' => 'range',
  );

}
