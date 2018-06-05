<?php
namespace App\Domain;

use App\Service\Takeaway\OrderTakeOutReturnSv;

class OrderTakeOutReturnDm {

  public function createOrder($data) {
  
    return OrderTakeOutReturnSv::createOrder($data);
  
  }

}
