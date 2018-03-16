<?php
namespace App\Interfaces\Crm;

use App\Interfaces\ICURD;

/**
 *
 * 优惠券发放规则
 *
 * @author Meroc Chen <398515393@qq.com> 2017-09-19
 *
 */
interface ICouponGrantRule extends ICURD {

  /** 
   * 1.启用规则
   *
   * @param int $id 规则id
   *
   * @return boolean true/false
   */
  public function enable($id);

  /**
   * 2.禁用规则
   *
   * @param int $id 规则id
   *
   * @return boolean true/false
   */
  public function disable($id);

}
