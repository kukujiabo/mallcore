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

}