<?php

namespace App\Domain;

use App\Service\Shop\ShopSv;

/**
 * 店铺接口类
 * 
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-09
 */
class ShopDm {

  /**
   * 获取地图上两个坐标的直线距离
   */
  public function getDistance($data) {

    return ShopSv::getdistance($data['lng1'], $data['lat1'], $data['lng2'], $data['lat2']);
  
  }

  /**
   * 新增
   */
  public function add($data) {

    return ShopSv::addShop($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {

    return ShopSv::updateShop($data);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return ShopSv::getList($condition);
  
  }

  /**
   * 获取数量
   */
  public function queryCount($condition) {
  
    return ShopSv::queryCount($condition);

  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {
    
    return ShopSv::getDetail($condition);

  }

  /**
   * 启用规则
   */
  public function enable($condition) {
  
    return ShopSv::enable($condition);

  }

  /**
   * 禁用规则
   */
  public function disable($condition) {
  
    return ShopSv::disable($condition);

  }

}
