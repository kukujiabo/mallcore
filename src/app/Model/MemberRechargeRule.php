<?php
namespace App\Model;

/**
 * [模型层] 用户充值规则配置
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-11-28
 *
 */
class MemberRechargeRule extends BaseModel {

  protected $_table = 'member_recharge_rules';

  protected $_queryOptionRule = array(
    'created_at' => 'range',
    'updated_at' => 'range',
    'start_date' => 'range',
    'end_date' => 'range',
    'member_level' => 'in'
  );


}
