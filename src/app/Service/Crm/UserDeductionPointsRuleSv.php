<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use App\Interfaces\Crm\IUserDeductionPointsRule;
use App\Model\UserDeductionPointsRule;
use Core\Service\CurdSv;

/**
 * 用户消费积分规则配置类
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-09-18
 */
class UserDeductionPointsRuleSv extends BaseService implements IUserDeductionPointsRule {

  use CurdSv;

  /**
   * 1.启用规则
   * 
   * @param string $id
   *
   * @return boolean true/false
   */
  public function enable($id){
  }

  /**
   * 2.禁用规则
   *
   * @param string $id
   *
   * @return boolean true/false
   */
  public function disable($id){}

}
