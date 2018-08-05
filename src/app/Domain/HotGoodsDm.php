<?php
namespace App\Domain;

use App\Service\Commodity\HotGoodsSv;

class HotGoodsDm {

  public function create($data) {
  
    return HotGoodsSv::create($data);
  
  }

  public function getList($data) {
  
    return HotGoodsSv::getList($data);
  
  }

  public function remove($data) {
  
    return HotGoodsSv::remove($data['id']);
  
  }

}
