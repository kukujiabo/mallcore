<?php

namespace App\Domain;

use App\Service\Commodity\GoodsSkuSv;

/**
 * sku商品接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-12-27
 */
class GoodsSkuDm {

  /**
   * 新增
   */
  public function add($data) {

    return GoodsSkuSv::addGoodsSku($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {
    
    return GoodsSkuSv::edit($data);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return GoodsSkuSv::getList($condition);
  
  }

  /**
   * 获取所有值
   */
  public function getAll($condition) {

    return GoodsSkuSv::getAll($condition);
  
  }

  /**
   * 获取数量
   */
  public function queryCount($condition) {
  
    return GoodsSkuSv::queryCount($condition);

  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {
    
    return GoodsSkuSv::getDetail($condition);

  }

}
