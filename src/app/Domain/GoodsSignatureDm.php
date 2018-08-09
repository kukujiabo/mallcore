<?php
namespace App\Domain;

use App\Service\Commodity\GoodsSignatureSv;

class GoodsSignatureDm {

  public function getAll() {
  
    return GoodsSignatureSv::getAll();
  
  }

}
