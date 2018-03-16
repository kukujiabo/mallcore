<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use App\Interfaces\Crm\IUserObtainPointsRule; use App\Model\UserObtainPointsRule;
use Core\Service\CurdSv;
use App\Exception\ErrorCode;

/**
 * 用户获取积分规则接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-09-18
 */
class UserObtainPointsRuleSv extends BaseService implements IUserObtainPointsRule {

  use CurdSv;

  /**
   * 1.删除记录（软删除）
   *
   * @param int $id
   *
   * @return boolean true/false
   */
  public function remove($id){}

  /**
   * 2.启用规则
   *
   * @param int $id
   *
   * @return boolean true/false
   */
  public function enable($id){
  
  }

  /**
   * 3.禁用规则
   *
   * @param int $id
   *
   * @return boolean true/false
   */
  public function disable($id) {
  
  }

  /**
   * 4.根据id获取有效规则
   *
   * @param int $id
   *
   * @return mixed $data
   */
  public function findActiveOne($id) {
  
    $time = date('Y-m-d H:i:s');

    $data = self::findOne($id);

    if (!$data) {

      throw new \Exception(ErrorCode::UserObtainPointsRuleSv['FAO_NOT_FOUND_MSG'], ErrorCode::UserObtainPointsRuleSv['FAO_NOT_FOUND_CODE']);

    } else if (intval($data['status']) == 0) {
    
      throw new \Exception(ErrorCode::UserObtainPointsRuleSv['FAO_INVALID_MSG'], ErrorCode::UserObtainPointsRuleSv['FAO_INVALID_CODE']);
    
    }

    return $data;
  
  }

  /**
   * 5.根据用户id，用户等级获取匹配的积分规则
   *
   * @param int $uid    用户id
   * @param int $level  用户等级
   *
   * @return 
   */
  public function getMatchedPointRule($level, $ins = array()) {

    $condition = array(

      'user_level' => "{$level},0",

      'status' => 1

    );

    if (!empty($ins)) {
    
      $condition['id'] = implode(',', $ins);
    
    }

    $rules = self::all($condition, 'priority desc, created_at');

    $currentTime = time();

    $keyRules = array(); 

    /**
     * 不在有效期内的规则去除
     */
    foreach($rules as $rule) {

      if (
        intval($rule['start_date'])  > $currentTime || 
        (intval($rule['expire_date']) < $currentTime && intval($rule['expire_date']) > 0)
      ) {

        continue;
      
      }

      array_push($keyRules, $rule);
    
    }

    return $keyRules;
  
  }

}
