<?php

namespace App\Domain;

use App\Service\Crm\UserPointSv;

/**
 * 积分接口类
 * 
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-09-25
 */
class UserPointDm {

  /**
   * 新增
   */
  public function add($data) {

    return UserPointSv::addPoint($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {

    return UserPointSv::edit($data);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return UserPointSv::getList($condition);
  
  }

  /**
   * 获取总数
   */
  public function queryCount($condition) {
    
    return UserPointSv::getCount($condition);

  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {
    
    return UserPointSv::getDetail($condition);

  }

  /**
   * 发放积分
   */
  public function grant($data) {
  
    return UserPointSv::grant($data['rid'], $data['uid']);
  
  }

}
