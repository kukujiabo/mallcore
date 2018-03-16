<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use App\Interfaces\Crm\IActivity;
use App\Service\Event\EventActionRelatSv;
use App\Service\Event\EventSv;
use App\Service\Event\ActionEventSv;
use Core\Service\CurdSv;

/**
 * 系统定义活动服务
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-22
 */
class ActivitySv extends BaseService implements IActivity {

  use CurdSv;

  /**
   * 创建活动
   *
   * @param array $params
   *
   * @return boolean true/false
   */
  public function createActivity($params) {
  
    /**
     * 1.先组合基本数据
     *
     * (1)活动名称
     * (2)活动编码
     * (3)活动优先级
     * (4)活动描述
     * (5)活动类型
     * (6)是否长期有效
     * (7)是否所有门店通用
     * (8)是否立即生效 (9)添加事件
     */

    $newAct = array(
    
      'activity_name' => $params['activity_name'],

      'activity_code' => $params['activity_code'],

      'priority' => $params['priority'],

      'description' => $params['description'],

      'type' => $params['type'],

      'last_long' => $params['last_long'],

      'all_shops' => $params['all_shops'],

      'active' => $params['active'],

      'created_at' => date('Y-m-d H:i:s'),

      'coupons' => $params['coupons'],

      'exchange' => $params['exchange'],

      'points' => $params['points'],

    );


    /**
     * 2.组合逻辑数据
     *
     * (1)有效时间
     * (2)可用门店
     */

    if (!$params['last_long']) {
    
      $newAct['start_date'] = $params['start_date'];

      $newAct['end_date'] = $params['end_date'];
    
    }

    if (!$params['all_shops']) {
    
      $newAct['activity_shops'] = $params['activity_shops'];
    
    }

    /**
     * 添加活动
     */

    $aid = self::add($newAct);


    if ($aid) { // 新增活动数据成功

      /**
       * 配置优惠券，提领券，积分
       */

      if ($params['coupons']) {
      
        self::dispatchCoupon($params['coupons'], $params['activity_code'], $params['activity_name'], $params['last_long'], $params['start_date'], $params['end_date']);
      
      }

      if ($params['exchange']) {
      
        self::dispatchExchange($params['exchange'],$params['activity_code'], $params['activity_name'], $params['last_long'], $params['start_date'], $params['end_date']);
      
      }

      if ($params['points']) {
      
        self::dispatchPoints($params['points'], $params['activity_code'], $params['activity_name'], $params['last_long'], $params['start_date'], $params['end_date']);
      
      }

      return $aid;

    } else { // 新增活动数据失败

      /**
       *  添加活动失败，抛出异常，记录想要添加的活动名称
       */

      throw new ActivityException(

        ErrorCode::ActivitySv['ACTIVITY_CREATE_FAILED_MSG'],

        ErrorCode::ActivitySv['ACTIVITY_CREATE_FAILED_CODE'],

        $params['activity_name'] 

      );
    
    }

  }

  /**
   * 配置活动优惠券
   *
   * @return 
   */
  protected static function dispatchCoupon($coupons, $actCode, $aname, $lastLong, $startDate = '', $endDate = '') {
  
    $module = 'coupon';

    $service = 'App\Service\Crm\CouponSv';
      
    self::dispatchReward($coupons, $module, $actCode, $aname, $service, $lastLong, $startDate, $endDate);
  
  }

  /**
   * 配置活动提领券
   *
   * @return
   */
  protected static function dispatchExchange($coupons, $actCode, $aname, $lastLong, $startData, $endDate) {
  
  
  }

  /**
   * 配置积分
   *
   * @return
   */
  protected static function dispatchPoints($points, $actCode, $aname, $lastLong, $startDate, $endDate) {
  
    $module = 'point';

    $service = 'App\Service\Crm\UserPointSv';
      
    self::dispatchReward($points, $module, $actCode, $aname, $service, $lastLong, $startDate, $endDate);
  
  }

  /**
   * 统一配置奖励
   *
   * @param string $rewards   奖项json字符串
   * @param string $module    奖项所属模块
   * @param string $aname     活动名称
   * @param string $service   对应服务接口
   * @param string $lastLong  活动持续时间
   * @param string $startDate 活动开始时间
   * @param string $endDate   活动结束时间
   *
   * @return null
   */
  protected static function dispatchReward($rewards, $module, $actCode, $aname, $service, $lastLong, $startDate='', $endDate='') {
  
    $rewards = json_decode($rewards, true);

    $events = array();

    $evActs = array();

    foreach($rewards as $reward) {

      $evtCode = EventSv::getCode($module);
    
      /**
       * 生成发放优惠券相关的事件
       */
      $newEvent = array(
      
        'event_name' => "活动派发-{$aname}",

        'event_code' => $evtCode,

        'service_name' => $service,

        'method_name' => 'grant',

        'module' => $module,

        'data' => $reward['key'],

        'remark' => $reward['label'],

        'last_long' => $lastLong,

        'created_at' => date('Y-m-d H:i:s'),

        'times' => $reward['grant_number'],

        'active' => 1
      
      );

      /**
       * 判断是否是长期有效事件
       */
      if (!$lastLong) {
      
        $newEvent['validate_start'] = $startDate;

        $newEvent['validate_end'] = $endDate;
      
      }

      array_push($events, $newEvent);

      /**
       * 添加事件关联用户动作
       */
      foreach($reward['grant_operation'] as $operation) {
      
        $evAct = array(

          'action_code' => $operation['key'],

          'event_code' => $evtCode,

          'activity_code' => $actCode,

          'module' => $module,

          'remark' => $aname,

          'active' => 1,

          'last_long' => $lastLong,

          'created_at' => date('Y-m-d H:i:s')

        );

        array_push($evActs, $evAct);
      
      }
      
    }

    /**
     * 批量添加事件
     */
    EventSv::batchAdd($events);

    /**
     * 批量添加动作事件关联
     */
    EventActionRelatSv::batchAdd($evActs);
  
  }

  /**
   * 获取活动列表
   *
   * @param array $params
   *
   * @return
   */
  public function getList($params) {

    $conditions = array();

    $params['activity_name'] ? $conditions['activity_name'] = $params['activity_name'] : '';

    $params['activity_code'] ? $conditions['activity_code'] = $params['activity_code'] : '';

    $params['activity_shops'] ? $conditions['activity_shops'] = $params['activity_shops'] : '';
  
    return self::queryList($conditions, '', '', $params['page'], $params['pageSize']);
  
  }

  /**
   * 分享活动
   *
   * @param string $shareCode
   *
   * @return
   */
  public function shareActivity($shareCode) {
  
    $actEvts = ActionEventSv::all(array('operation' => 'invite_friend', 'active' => 1));

    $shareRecord = ShareRecordSv::findOne(array('share_code' => $shareCode));

    $user = UserSv::findOne(array('hidden_identity' => $shareRecord['user_key']));

    foreach($actEvts as $event) {

      if (!$event['last_long']) {

        $vstart = strtotime($event['validate_start']);

        $vend = strtotime($event['validate_end']);

        $time = time();

        if ($vend < $time || $vstart > $time) {
        
          continue;
        
        }

      }

      try {

        $eventResult = call_user_func_array(

          array($event['event_service'], $event['event_method']), 

          array($event['data'], $user['uid'])

        );
    
        if($eventResult != false) {

          /**
           * 记录事件触发
           */
          $log = array(

            'uid' => $member->uid,

            'module' => $event['module'],
          
            'activity_code' => $event['act_code'],

            'action_code' => $event['action_code'],
            
            'event_code' => $event['event_code'],

            'object' => $event['data'],

            'created_at' => date('Y-m-d H:i:s')
          
          );

          ActivityMemberLogsSv::add($log);  
        
        }

      } catch (\Exception $e) {
      
      
      }
    
    }
    
  }

  /**
   * 启用活动
   *
   * @param int $id
   *
   * @return boolean true/false
   */
  public function enable($id) {

    $activity = self::findOne($id);
  
    if (!$activity) {
    
      return false;
    
    } else {

      self::update($id, array('active' => 0));

      EventActionRelatSv::batchUpdate(
        
        array('activity_code' => $activity['activity_code']), 
        
        array('active' => 0)
      
      );
      
      return true;
    
    }

  }

  /**
   * 停用活动
   *
   * @param int $id
   *
   * @return boolean true/false
   */
  public function disable($id) {
  
    $activity = self::findOne($id);
  
    if (!$activity) {
    
      return false;
    
    } else {

      self::update($id, array('active' => 1));

      EventActionRelatSv::batchUpdate(
        
        array('activity_code' => $activity['activity_code']), 
        
        array('active' => 1)
      
      );
      
      return true;
    
    }

  }

}
