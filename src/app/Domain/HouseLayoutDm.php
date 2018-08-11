<?php
namespace App\Domain;

use App\Service\Commodity\HouseLayoutSv;

class HouseLayoutDm {

  public function create($data) {
  
    return HouseLayoutSv::create($data);
  
  }

  public function getAll($data) {
  
    return HouseLayoutSv::getAll($data);
  
  }

  public function getDetail($data) {
  
    return HouseLayoutSv::getDetail($data);
  
  }

}
