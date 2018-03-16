<?php
namespace App\Model;

/**
 * [模型层] 优惠券发放记录
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-18
 *
 */
class CouponGrantLog extends BaseModel {

  protected $_queryOptionRule = array(
    'created_at' => 'range',
  );

}
