<?php

namespace App\Domain;

use App\Service\Crm\UserObtainPointsRuleSv;

/**
 * 用户获取积分规则接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-24
 */
class UserObtainPointsRuleDm {

  /**
   * 新增
   */
  public function add($data) {

    $data['created_at'] = date("Y-m-d H:i:s");

    return UserObtainPointsRuleSv::add($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {
    
    $id = $data['id'];

    unset($data['id']);

    $data['updated_at'] = date("Y-m-d H:i:s");
    
    if ($data['deleted_at'] == 1) {

      $data['deleted_at'] = time();

    }

    return UserObtainPointsRuleSv::update($id, $data);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return UserObtainPointsRuleSv::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);
  
  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {
    
    return UserObtainPointsRuleSv::findOne($condition['id']);

  }

  /**
   * 启用规则
   */
  public function enable($condition) {
    
    $data['updated_at'] = date("Y-m-d H:i:s");

    $data['status'] = 1;
  
    return UserObtainPointsRuleSv::update($condition['id'], $data);

  }

  /**
   * 禁用规则
   */
  public function disable($condition) {
    
    $data['updated_at'] = date("Y-m-d H:i:s");

    $data['status'] = 0;

    return UserObtainPointsRuleSv::update($condition['id'], $data);

  }

}
