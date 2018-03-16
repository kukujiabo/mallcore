<?php
namespace App\Interfaces\Crm;

use App\Interfaces\ICURD;

/**
 * 用户获取积分规则接口
 *
 * @author Meroc Chen <398515393@qq.com> 2017-09-18
 */
interface IUserObtainPointsRule extends ICURD {

  /**
   * 1.启用规则
   *
   * @param int $id
   *
   * @return boolean true/false
   */
  public function enable($id);

  /**
   * 2.禁用规则
   *
   * @param int $id
   *
   * @return boolean true/false
   */
  public function disable($id);

}
