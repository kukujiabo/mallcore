<?php

namespace App\Domain;

use App\Service\Crm\UserPointsLogSv;

/**
 * 用户获取积分规则接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-24
 */
class UserPointsLogDm {

  /**
   * 新增
   */
  public function add($data) {

    return UserPointsLogSv::addLog($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {

    return UserPointsLogSv::edit($data);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return UserPointsLogSv::getList($condition);
  
  }

  /**
   * 获取总数
   */
  public function queryCount($condition) {

    return UserPointsLogSv::getCount($condition);
  
  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {
    
    return UserPointsLogSv::getDetail($condition);

  }

}
