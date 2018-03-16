<?php
namespace App\Domain;

use App\Service\Crm\ActivitySv;

/**
 * 活动接口
 */
class ActivityDm {

  /**
   * 添加活动
   */
  public function createActivity($params) {
  
    return ActivitySv::createActivity($params);
  
  }

  /**
   *
   */
  public function queryList($params) {
  
    return ActivitySv::getList($params);
  
  }

  public function testShareActivity($params) {
  
    return ActivitySv::shareActivity($params['share_code']);
  
  }

  /**
   * 启用活动
   */
  public function enable($data) {
  
    return ActivitySv::enable($data['id']);
  
  }

  /**
   * 停用活动
   */
  public function disable($data) {
  
    return ActivitySv::disable($data['id']);
  
  }

}
