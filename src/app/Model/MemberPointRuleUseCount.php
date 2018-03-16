<?php
namespace App\Model;

/**
 * [模型层] 用户积分规则使用计数
 *
 * @author Meroc Chen <398515393@qq.com> 2017-11-30
 */
class MemberPointRuleUserCount extends BaseModel {

  protected $_table = 'v_member_rule_use_count';

  protected $_queryOptionRule = array(
  
    'rule_id' => 'in'
  
  );


}
