<?php
namespace App\Interfaces\Crm; 

use App\Interfaces\ICURD;

/**
 * 用户积分操作接口
 *
 * @author Meroc Chen <398515393@qq.com> 2017-09-18
 */
interface IUserPoint extends ICURD {

  /**
   * 1.使用用户积分
   * 
   * @param string $rule        积分使用规则
   * @param string $uid         用户id 
   * @param stromg $point       用户积分
   * @param string $channelType 渠道类型
   * @param string $channel     渠道id
   * @param string $action      请求操作
   * @param string $objectId    对象id（订单，小游戏）
   *
   * @return boolean true/false
   */
  public function usePoint($rule, $uid, $points, $channel, $channelId, $action, $objectId, $remarks);

}
