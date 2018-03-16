<?php
namespace App\Model;

/**
 * [模型层] 优惠券使用日志
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-18
 *
 */
class CouponUseLog extends BaseModel {

  protected $_queryOptionRule = array(
    'created_at' => 'range',
  );

}
