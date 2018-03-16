<?php
namespace App\Service\Crm;

use Core\Service\CurdSv;
use App\Service\BaseService;
use App\Service\Crm\UserSv;

/**
 * 用户充值规则使用记数服务【视图操作，只可查询】
 *
 * @author Meroc Chen <398515393@qq.com> 2017-11-28
 */
class MemberRechargeRuleUseCountSv extends BaseService {

  use CurdSv;

  /**
   * 获取用户使用充值规则次数统计
   *
   * @param string $token
   * @param string $ruleCodes
   *
   * @return array $data
   */
  public function getRuleUseCount($token, $ruleCodes) {

    $member = UserSv::getUserByToken($token);

    $query = array(
    
      'uid' => $member['uid'],

      'rule_code' => $ruleCodes
    
    );
  
    return self::all($query, 'num desc');

  }

}
