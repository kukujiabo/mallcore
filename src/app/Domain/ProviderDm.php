<?php
namespace App\Domain;

use App\Service\Admin\ProviderSv;

/**
 * 供应商
 *
 */
class ProviderDm {

  /**
   * 新增供应商
   */
  public function addProvider($data) {
  
    return ProviderSv::addProvider($data);
  
  }

  /**
   * 获取列表
   */
  public function getList($data) {
  
    return ProviderSv::getList($data); 
  
  }

  /**
   * 获取全部供应商
   */
  public function getAll() {
  
    return ProviderSv::all();
  
  }

}
