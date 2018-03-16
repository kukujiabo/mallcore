<?php
namespace App\Service\Crm; 
use App\Interfaces\Crm\IMemberRechargeRule;
use App\Service\BaseService;
use App\Model\MemberRechargeRule;
use App\Service\Crm\MemberRechargeRuleUseCountSv;
use Core\Service\CurdSv;
use App\Service\Crm\UserSv;
use App\Service\Poss\PosSv;

/**
 * 用户充值规则配置服务
 *
 * @author Meroc Chen <398515393@qq.com> 2017-11-28
 */
class MemberRechargeRuleSv extends BaseService implements IMemberRechargeRule {

  use CurdSv;

  /**
   * 添加规则逻辑
   *
   * @param array $data
   *
   * @return 
   */
  public function addRule($params) {

    $data = self::getSaveData($params);
  
    return self::add($data);
  
  }

  /**
   * 修改用户充值规则
   *
   * @param array $data
   *
   * @return 
   */
  public function updateRule($params) {
  
    $id = $params['id'];
  
    $data = self::getSaveData($params);

    return self::update($id, $data);
  
  }

  /**
   * 拼接保存数据
   *
   * @param array $data
   *
   * @return 
   */
  protected static function getSaveData($params) {
  
    $data = array(
    
      'name' => $params['name'],

      'last_long' => $params['last_long'],
    
      'rule_type' => $params['rule_type'],

      'active' => $params['active'],

      'member_level' => $params['member_level'],

      'brief' => $params['brief'],

      'rule_type' => $params['rule_type'],

      'reward_type' => $params['reward_type'],

      'use_time' => $params['use_time'],

      'created_at' => date('Y-m-d H:i:s'),

      'priority' => $params['priority'],

      'special_type' => $params['special_type'],

    );

    /**
     * 判断是否长期有效
     */

    if (!$params['last_long']) {
    
      $data['start_date'] = strtotime($params['start_date']);

      $data['end_date'] = strtotime($params['end_date']);
    
    }

    /**
     * 判断规则金额类型
     */

    if ($params['rule_type'] == 1) {

      $data['money'] = $params['money'];

    } else {

      $data['min_money'] = $params['min_money'];

      $data['max_money'] = $params['max_money'];
    
    }

    /**
     * 判断奖励类型: 0.无奖励；1.固定奖励金；2.比例奖励
     */

    if ($params['reward_type'] == 1) {
    
      $data['reward_money'] = $params['reward_money'];
    
    } elseif ($params['reward_type'] == 2) {
    
      $data['reward_percentage'] = $param['reward_percentage'];
    
    }

    return $data;
  
  }

  /**
   * 根据用户TOKEN和金额筛选适合的充值规则
   *
   * @param string $token
   *
   * @return array $rules
   */
  public function getRuleByToken($token, $money) {
  
    $member = UserSv::getUserByToken($token);

    return self::getRuleByUid($member['uid'], $money);

  }

  /**
   * 根据用户ID和金额筛选适合的充值规则
   *
   * @param string $uid
   *
   * @return array $rules
   */
  public function getRuleByUid($uid, $money) {

    /**
     * 获取当前有效，并且该用户的等级可以参与的规则
     */
    $ct = time();

    $member = MemberSv::findOne(array('uid' => $uid));

    /**
     * 筛选条件
     * 1. 用户等级 包含用户当前等级和通用等级
     * 2. 是否有效
     * 3. 是否在有效期内
     */
    $options = array(
    
      'member_level' => "{$member['member_level']},0", 

      'active' => 1,
    
    );

    /**
     * start 首充规则判断，之后修改为可配置模式，现在暂时固定写法
     */

    $firstOptions = array(
    
      'uid' => $uid,

      'status' => 1,

      'special_type' => 1000000000,
    
    );

    $firstCnt = MemberRechargeSv::queryCount($firstOptions);

    if ($firstCnt > 0) {

      $options['special_type'] = 0;

    } else {

      $options['special_type'] = 1000000000;

      $user = UserSv::findOne($uid);

      /**
       * 查询pos是否有充值数据
       */
      $offLines = PosSv::getMemberBalanceHistory(
        
        array(
          
          'sMobile' => $user['user_tel'] 
        
        )
      
      );

      foreach($offLines as $offLine) {
      
        if ($offLine['DocType'] == '充值') {
        
          $options['special_type'] = 0;

          break;
        
        }
      
      }
    
    }

    /**
     * end 首充判断
     */

    $rules = self::all($options, 'display_order desc');

    $ruleIds = array();

    $ruleSorts = array();

    /**
     * 通过rule_id确认 用户是否使用该规则充值的次数, 并去除不在有效期内的条目
     */
    foreach($rules as $rule) {

      if (
        ($rule['end_date'] > 0 && ($rule['start_date'] > $ct || ($rule['end_date'] < $ct))) ||
        ($rule['start_date'] > 0 && ($rule['start_date']) > $ct)) {
      
        continue;
      
      }

      array_push($ruleIds, $rule['id']);
    
      $ruleSorts[$rule['id'] . ''] = $rule;

    }


    $ruleCnts = MemberRechargeRuleUseCountSv::all(array('uid' => $member['uid'], 'rule_code' => implode(',', $ruleIds)), 'num desc');

    /**
     * 比较次数，若超限则去除规则
     */
    foreach($ruleCnts as $ruleCnt) {

      $useTime = intval($ruleSorts[$ruleCnt['rule_code']]['use_time']);

      if ($useTime > 0 && $useTime <= intval($ruleCnt['num'])) {
      
        unset($ruleSorts[$ruleCnt['rule_code']]);
      
      }

    }

    /**
     * 根据优先级取最高的规则，一个或多个
     */
    $topRule = array();

    foreach($ruleSorts as $ruleSort) {

      if (!empty($topRule) && $ruleSort['priority'] < $topRule[0]['priority']) {
      
        break;
      
      }

      array_push($topRule, $ruleSort);
    
    }

    return $topRule;
    
  }

  /**
   * 启用规则
   */
  public function enable($id) {

    $data['active'] = 0;

    return self::update($id, $data);

  }

  /**
   * 禁用规则
   */
  public function disable($id) {

    $data['active'] = 1;
  
    return self::update($id, $data);

  }

  /**
   * 根据充值规则计算用户奖励金
   *
   * @param int $uid
   * @param float $money
   *
   * @return array $reward $ruleCode
   */
  public function calChargeMoneyByRule($uid, $money) {
  
    $rules = self::getRuleByUid($uid, $money);

    $money = floatVal($money);

    $reward = 0;

    $ruleCode = 0;

    /**
     * 计算充值奖励金额
     */
    if (!empty($rules)) {
      
      foreach ($rules as $rule) {

        if (
          ($rule['min_money'] <= $money && $money <= $rule['max_money']) ||
          ($rule['min_money'] <= $money && $rule['max_money'] == 0)
        ) {
        
          $reward = $rule['reward_type'] == 1 ? $rule['reward_money'] : $money * $rule['reward_percentage'];

          $ruleCode = $rule['id'];

          break;
        
        }
       
      }

    }

    return array('reward_money' => $reward, 'id' => $ruleCode);
  
  }

}
