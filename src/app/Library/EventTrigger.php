<?php
namespace App\Library;

use App\Service\Event\ActionEventSv;
use App\Common\Logs;
use App\Library\RedisClient;
use App\Service\Crm\ActivityMemberLogsSv;

/**
 * 事件处理器
 *
 * @author Meroc Chen <398515393@qq.com> 2017-11-21
 */
class EventTrigger {

  protected $action;

  protected $token;

  public function __construct($action, $token) {
  
    $this->action = $action;

    $this->token = $token;

  }

  /**
   * 处理事件
   */
  public function run() {

    $member = RedisClient::get('member_info', $this->token);

    $condition = array(
    
      'operation' => $this->action,

      'active' => 1,
    
    );

    $events = ActionEventSv::all($condition);

    $funcs = array();

    foreach($events as $event) {

      if (!$event['last_long']) {

        $vstart = strtotime($event['validate_start']);

        $vend = strtotime($event['validate_end']);

        $time = time();

        if ($vend < $time || $vstart > $time) {
        
          continue;
        
        }

      }

      try {

        /**
         * 先判断事件触发次数
         */
        $times = $event['times'];

        if ($times > 0) {

          $countOptions = array(
          
            'activity_code' => $event['act_code'],

            'action_code' => $event['action_code'],
            
            'event_code' => $event['event_code'],

            'object' => $event['data']
          
          );

          $takeCount = ActivityMemberLogsSv::queryCount($countOptions);

          if ($takeCount >= $times) {
          
            continue;
          
          }

        }

        $eventResult = call_user_func_array(

          array($event['event_service'], $event['event_method']), 

          array($event['data'], $member->uid)

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
        
        } else {
        
        
        }

      } catch (\Exception $e) {
      
        Logs::error(__CLASS__, $e->getMessage());

      }
    
    }

  }

}
