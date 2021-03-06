<?php
namespace App\Domain;

use App\Service\Commodity\SmartTemplateSv;

class SmartTemplateDm {

  public function create($data) {
  
    return SmartTemplateSv::create($data);
  
  }

  public function getList($data) {
  
    return SmartTemplateSv::getList($data);
  
  }

  public function getDetail($data) {
  
    return SmartTemplateSv::getDetail($data); 
  
  }

  public function updateTemplate($data) {
  
    return SmartTemplateSv::updateTemplate($data);
  
  }

  public function getGoods($data) {
  
    return SmartTemplateSv::getGoods($data);
  
  }

}
