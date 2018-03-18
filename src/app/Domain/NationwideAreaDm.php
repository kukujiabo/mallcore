<?php

namespace App\Domain;

use App\Service\Crm\NationwideAreaSv;

/**
 * 全国地区接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-24
 */
class NationwideAreaDm {

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return NationwideAreaSv::queryList($condition);
  
  }

  /**
   * 获取地址
   */
  public function getAddress($condition) {

    return NationwideAreaSv::getAddress($condition);
  
  }

  /**
   * 获取所有行政区
   */
  public function cascadeList() {
  
    return NationwideAreaSv::cascadeList();
  
  }

  /**
   * 更新行政区信息
   */
  public function update($data) {

    $id = $data['id'];

    unset($data['id']);

    return NationwideAreaSv::update($id, $data);

  }

  public function queryCity($data) {
  
    return NationwideAreaSv::queryCity($data);
  
  }

}
