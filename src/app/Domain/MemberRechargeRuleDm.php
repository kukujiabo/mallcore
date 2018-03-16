<?php
namespace App\Domain;

use App\Service\Crm\MemberRechargeRuleSv;
use App\Service\Crm\MemberRechargeRuleUseCountSv;

/**
 * 用户充值规则
 * 
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-11-28
 */
class MemberRechargeRuleDm {

  /**
   * 新增
   */
  public function add($data) {

    return MemberRechargeRuleSv::addRule($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {

    return MemberRechargeRuleSv::updateRule($data);
  
  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {

    return MemberRechargeRuleSv::findOne($condition['id']);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return MemberRechargeRuleSv::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);
  
  }

  /**
   * 获取数量
   */
  public function queryCount($condition) {
  
    return MemberRechargeRuleSv::queryCount($condition);

  }

  /**
   * 启用规则
   */
  public function enable($condition) {

    return MemberRechargeRuleSv::enable($condition['id']);

  }

  /**
   * 禁用规则
   */
  public function disable($condition) {
  
    return MemberRechargeRuleSv::disable($condition['id']);

  }

  /**
   * 通过token获取用户充值规则
   */
  public function getRuleByToken($data) {
  
    return MemberRechargeRuleSv::getRuleByToken($data['token'], $data['money']);
  
  }

  /**
   * 获取用户使用
   */
  public function getRuleUseCount($data) {
  
    return MemberRechargeRuleUseCountSv::getRuleUseCount($data['token'], $data['ruleCodes']);
  
  }

  /**
   * 根据规则计算用户充值金额
   */
  public function calChargeMoneyByRule($data) {
  
    return MemberRechargeRuleSv::calChargeMoneyByRule($data['uid'], $data['money']);
  
  } 

}
