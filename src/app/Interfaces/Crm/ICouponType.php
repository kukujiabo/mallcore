<?php
namespace App\Interfaces\Crm;

use App\Interfaces\ICURD;

/**
 *
 * 优惠券种类接口
 *
 * @author Meroc Chen <398515393@qq.com> 2017-09-18
 *
 */
interface ICouponType extends ICURD {

  /**
   * 1.禁用优惠券
   *
   * @param int $id
   *
   * @return boolean true/false
   */
  public function disable($id);

  /**
   * 2.启用优惠券
   *
   * @param int $id
   *
   * @return boolean true/false
   */
  public function enable($id);

}
