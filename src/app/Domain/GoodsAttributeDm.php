<?php

namespace App\Domain;

use App\Service\Commodity\GoodsAttributeSv;

/**
 * 商品属性接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-12-27
 */
class GoodsAttributeDm {

  /**
   * 新增
   */
  public function add($data) {

    return GoodsAttributeSv::addGoodsAttribute($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {
    
    return GoodsAttributeSv::edit($data);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return GoodsAttributeSv::getList($condition);
  
  }

  /**
   * 获取所有值
   */
  public function getAll($condition) {

    return GoodsAttributeSv::all($condition);
  
  }

  /**
   * 获取数量
   */
  public function queryCount($condition) {
  
    return GoodsAttributeSv::queryCount($condition);

  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {
    
    return GoodsAttributeSv::getDetail($condition);

  }

}
