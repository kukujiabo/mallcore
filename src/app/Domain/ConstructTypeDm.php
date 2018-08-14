<?php
namespace App\Domain;

use App\Service\Commodity\ConstructTypeSv;

class ConstructTypeDm {

  public function create($data) {
  
    return ConstructTypeSv::create($data);
  
  }

  public function getAll($data) {
  
    return ConstructTypeSv::getAll($data);
  
  }

  public function getDetail($data) {
  
    return ConstructTypeSv::getDetail($data);
  
  }

  public function updateConstruct($data) {
  
    return ConstructTypeSv::updateConstruct($data);
  
  }

  public function removeConstruct($data) {
  
    return ConstructTypeSv::removeConstruct($data); 
  
  }

}

