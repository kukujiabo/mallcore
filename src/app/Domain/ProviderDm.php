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

  /**
   * 获取装修公司详情
   */
  public function getDetail($params) {
  
    return ProviderSv::getDetail($params);
  
  }

  public function edit($params) {
  
    return ProviderSv::edit($params);
  
  }

}
