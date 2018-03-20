<?php
namespace App\Domain;

use App\Service\Commodity\GoodsPriceMapSv;

/**
 * 商品价格体系
 */
class GoodsPriceMapDm {

  public function addRule($data) {
  
    return GoodsPriceMapSv::addRule($data);
  
  }

}
