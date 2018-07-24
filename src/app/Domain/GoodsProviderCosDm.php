<?php
namespace App\Domain;

use App\Service\Commodity\GoodsProviderCosSv;

class GoodsProviderCosDm {

  /**
   * 添加进价
   */
  public function addGoodsCos($data) {
  
    return GoodsProviderCosSv::addGoodsCos($data);
  
  }

  /**
   * 获取进价列表
   */
  public function getList($data) {
  
    return GoodsProviderCosSv::getList($data);
  
  }

  /**
   * 获取价格详情
   */
  public function getDetail($data) {
  
    return GoodsProviderCosSv::getDetail($data);
  
  }

  /**
   * 修改价格
   */
  public function updateCos($data) {
  
    return GoodsProviderCosSv::updateCos($data);
  
  }

  /**
   * 导入价格
   */
  public function importData($data) {

    return GoodsProviderCosSv::importData($data);

  }

}
