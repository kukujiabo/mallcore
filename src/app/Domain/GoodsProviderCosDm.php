<?php
namespace App\Domain;

use App\Service\Commodity\GoodsProviderCosSv;

class GoodsProviderCosDm {

  /**
   * 添加价格
   */
  public function addGoodsCos($data) {
  
    return GoodsProviderCosSv::addGoodsCos($data);
  
  }

}
