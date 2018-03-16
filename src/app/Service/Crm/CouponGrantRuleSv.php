<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use App\Interfaces\Crm\ICouponGrantRule;
use App\Model\CouponGrantRule;
use Core\Service\CurdSv;

/**
 *
 * 优惠券发放规则
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-18
 *
 */
class CouponGrantRuleSv extends BaseService implements ICouponGrantRule {

  use CurdSv;

  /** 
   * 1.启用规则
   *
   * @param int $id 规则id
   *
   * @return boolean true/false
   */
  public function enable($id) {
    
    $data['status'] = 1;

    $data['updated_at'] = date("Y-m-d H:i:s");

    return CouponGrantRule::update($id, $data);
  }

  /**
   * 2.禁用规则
   *
   * @param int $id 规则id
   *
   * @return boolean true/false
   */
  public function disable($id) {

    $data['status'] = 0;

    $data['updated_at'] = date("Y-m-d H:i:s");

    return CouponGrantRule::update($id, $data);
  }

  /**
   * 3.获取符合条件的优惠券发放规则
   *
   * @param int $level
   * @param array $ins
   *
   * @return array $rules
   */
  public function getMatchedCouponRule($level, $ins = array()) {

    $ids = implode(',', $ins);
  
    $couponTypes = CouponTypeSv::all(array('coupon_type_id' => $ids));

    $rules = array();

    foreach($couponTypes as $couponType) {

      $rule = array(
    
        'name' => $couponType['coupon_name']
    
      );

      array_push($rules, $rule);

    }

    return $rules;
  
  }

}
