<?php

namespace App\Domain;

use App\Service\Commodity\GoodsAttributeValueSv;

/**
 * 商品规格值模版接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-12-27
 */
class GoodsAttributeValueDm {

  /**
   * 新增
   */
  public function add($data) {

    return GoodsAttributeValueSv::addGoodsAttributeValue($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {
    
    return GoodsAttributeValueSv::edit($data);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return GoodsAttributeValueSv::getList($condition);
  
  }

  /**
   * 获取所有值
   */
  public function getAll($condition) {

    return GoodsAttributeValueSv::all($condition, 'sort asc');
  
  }

  /**
   * 获取数量
   */
  public function queryCount($condition) {
  
    return GoodsAttributeValueSv::queryCount($condition);

  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {
    
    return GoodsAttributeValueSv::getDetail($condition);

  }

}
