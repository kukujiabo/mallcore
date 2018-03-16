<?php

namespace App\Domain;

use App\Service\System\ModuleSv;

/**
 * 系统模块接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-20
 */
class ModuleDm {

  /**
   * 新增
   */
  public function add($data) {

    $data['create_time'] = date("Y-m-d H:i:s");

    return ModuleSv::add($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {
    
    $id = $data['module_id'];

    unset($data['module_id']);

    $data['modify_time'] = date("Y-m-d H:i:s");
    
    if ($data['deleted_at'] == 1) {

      $data['deleted_at'] = time();

    }

    return ModuleSv::update($id, $data);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return ModuleSv::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);
  
  }

  /**
   * 获取数量
   */
  public function queryCount($condition) {
  
    return ModuleSv::queryCount($condition);

  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {
    
    return ModuleSv::findOne($condition['module_id']);

  }

  /**
   * 获取模块详情
   */
  public function crmModList($data) {
  
    return ModuleSv::crmModList($data);
  
  }
  
}
