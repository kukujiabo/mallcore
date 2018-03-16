<?php

namespace App\Domain;

use App\Service\Admin\UserJurisdictionSv;

/**
 * 用户权限操作接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-25
 */
class UserJurisdictionDm {

  /**
   * 新增
   */
  public function add($data) {

    $data['created_at'] = date("Y-m-d H:i:s");

    return UserJurisdictionSv::add($data);
  
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
    
    return UserJurisdictionSv::update($id, $data);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return UserJurisdictionSv::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);
  
  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {
    
    return UserJurisdictionSv::findOne($condition['id']);

  }

}
