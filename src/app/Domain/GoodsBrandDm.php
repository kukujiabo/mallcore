<?php
namespace App\Domain;

use App\Service\Commodity\GoodsBrandSv;

/**
 * 商品品牌处理域
 *
 * @author Meroc Chen <398515393@qq.com> 2018-02-26
 */
class GoodsBrandDm {

  /**
   * 添加品牌
   *
   * @param array data
   *
   * @return int id
   */
  public function addBrand($data) {
  
    return GoodsBrandSv::addBrand($data);
  
  }

  /**
   * 更新商品品牌
   *
   * @param int id
   * @param array data
   *
   * @return int num
   */
  public function updateBrand($params) {

    $id = $params['id'];
  
    unset($params['id']);

    return GoodsBrandSv::updateBrand($id, $params);
  
  }

  /**
   * 查询品牌列表
   *
   * @param array param
   *
   * @return array list
   */
  public function listQuery($params) {

     return GoodsBrandSv::listQuery($params['brand_name'], $params['brand_code'], $params['brand_state'], $params['index_show'], $params['all'], $params['page'], $params['page_size']);

  }

  /**
   * 删除品牌
   *
   * @param array param
   *
   * @return int id
   */
  public function removeBrand($params) {
  
    return GoodsBrandSv::removeBrand($params['id']);
  
  }

  /**
   * 获取商品品牌详情
   *
   * @param array 
   *
   * @return array info
   */
  public function getDetail($params) {

    return GoodsBrandSv::findOne($params['id']);
  
  }

}
