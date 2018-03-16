<?php

namespace App\Domain;

use App\Service\Admin\UserAdminSv;
use App\Service\Crm\UserSv;

/**
 * 后台管理员操作接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-25
 */
class UserAdminDm {

  /**
   * 登录
   */
  public function login($data) {

    return UserAdminSv::login($data);
  
  }

  /**
   * 新增
   */
  public function add($data) {

    $data['created_at'] = date("Y-m-d H:i:s");

    return UserAdminSv::add($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {
    
    $id = $data['uid'];

    unset($data['uid']);

    $data['updated_at'] = date("Y-m-d H:i:s");
    
    if ($data['deleted_at'] == 1) {

      $data['deleted_at'] = time();

    }
    
    return UserAdminSv::update($id, $data);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return UserAdminSv::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);
  
  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {
    
    return UserAdminSv::findOne($condition['uid']);

  }

  /**
   * 获取管理员缓存信息
   */
  public function getAdmin($condition) {
    
    return UserSv::getAdminToken($condition['token']);

  }

}
