<?php
namespace App\Domain;

use \App\Service\Market\AdverSv;

class AdverDm {

  public function save($data) {
  
    return AdverSv::save($data); 
  
  }

  public function getDetail($data) {
  
    return AdverSv::getDetail($data);
  
  }

}
