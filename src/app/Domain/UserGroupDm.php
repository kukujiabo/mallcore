<?php

namespace App\Domain;

use App\Service\Admin\UserGroupSv;

/**
 * 系统用户组操作接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-25
 */
class UserGroupDm {

  /**
   * 新增
   */
  public function add($data) {

    $data['create_time'] = date("Y-m-d H:i:s");

    return UserGroupSv::add($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {
    
    $id = $data['group_id'];

    unset($data['group_id']);

    $data['modify_time'] = date("Y-m-d H:i:s");
    
    if ($data['deleted_at'] == 1) {

      $data['deleted_at'] = time();

    }
    
    return UserGroupSv::update($id, $data);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return UserGroupSv::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);
  
  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {
    
    return UserGroupSv::findOne($condition['group_id']);

  }

}
