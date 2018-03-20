<?php

namespace App\Domain;

use App\Service\Commodity\GoodsSv;

/**
 * 商品接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-20
 */
class GoodsDm {

  /**
   * 新增
   */
  public function add($data) {

    return GoodsSv::addGoods($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {
    
    return GoodsSv::updates($data);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return GoodsSv::getList($condition);
  
  }

  /**
   * 获取数量
   */
  public function queryCount($condition) {
  
    return GoodsSv::getCount($condition);

  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {
    
    return GoodsSv::getDetails($condition);

  }

  /**
   * 添加商品（包含SUK）
   */
  public function addSkuGoods($params) {
    
    return GoodsSv::addSkuGoods($params);

  }

  /**
   * 编辑商品（包含SUK）
   */
  public function editSkuGoods($params) {
    
    return GoodsSv::editSkuGoods($params);

  }

  /**
   * 获取全部
   */
  public function getAll($data) {

    return GoodsSv::all($data);
  
  }

  /**
   * 获取商品库存
   */
  public function getGoodsStock($data) {

    return GoodsSv::getGoodsStock($data);
  
  }

  public function getAllGoods() {
  
    return GoodsSv::all();
  
  }

}
