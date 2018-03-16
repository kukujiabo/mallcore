<?php
namespace App\Model;

/**
 * [模型层] 用户充值规则使用计数
 *
 * @author Meroc Chen <398515393@qq.com> 2017-11-28
 *
 */
class MemberRechargeRuleUseCount extends BaseModel {

  protected $_table = 'v_member_recharge_rule_use_count';

  protected $_queryOptionRule = array(
    'uid' => 'in',
    'rule_code' => 'in' 
  );

}
