<?php
namespace App\Domain;

use App\Service\Crm\ConfigSv;

/**
 * 配置参数接口
 * 
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-11-27
 */
class ConfigDm {

  /**
   * 新增
   */
  public function add($data) {

    return ConfigSv::addConfig($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {

    return ConfigSv::edit($data);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return ConfigSv::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);
  
  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {

    return ConfigSv::findOne($condition);
  
  }

  /**
   * 获取总数
   */
  public function queryCount($condition) {
  
    return CouponSv::queryCount($condition);

  }

  /**
   * 根据key获取配置value
   */
  public function getConfigValueByKey($condition) {

    return ConfigSv::getConfigValueByKey($condition['key']);
  
  }

  /**
   * 根据模块获取配置项
   */
  public function getConfigByModule($condition) {

    return ConfigSv::getConfigByModule($condition['module']);
  
  }

}
