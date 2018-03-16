<?php

namespace App\Domain;

use App\Service\Commodity\GoodsCategorySv;

/**
 * 商品分类接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-11-15
 */
class GoodsCategoryDm {

  /**
   * 获取全部
   */
  public function getAll($data) {

    return GoodsCategorySv::all($data);
  
  }

  /**
   * 新增
   */
  public function add($data) {

    return GoodsCategorySv::addGoodsCategory($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {
    
    return GoodsCategorySv::updates($data);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    $is_subclass = $condition['is_subclass'];

    unset($condition['is_subclass']);

    $info = GoodsCategorySv::getList($condition);

    if ($is_subclass == 1) {

      $info['list'] = GoodsCategorySv::getSubclassList($info['list']);

    }

    return $info;
  
  }

  /**
   * 获取数量
   */
  public function queryCount($condition) {
  
    return GoodsCategorySv::getCount($condition);

  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {
    
    return GoodsCategorySv::getDetails($condition);

  }

  /**
   * 删除商品分类
   */
  public function remove($condition) {
  
    return GoodsCategorySv::removeCategory($condition);
  
  }

}
