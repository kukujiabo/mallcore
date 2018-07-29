<?php
namespace App\Domain;

use App\Service\Transport\OrderSignImageSv;

class OrderSignImageDm {

  public function create($data) {
  
    return OrderSignImageSv::create($data);
  
  }

  public function getAllByOrderId($data) {
  
    return OrderSignImageSv::getAllByOrderId($data);
  
  }

}
