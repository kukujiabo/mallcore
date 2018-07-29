<?php
namespace App\Domain;

use App\Service\Transport\DriverSv;

class DriverDm {

  public function create($data) {
  
    return DriverSv::create($data);
  
  }

  public function getList($data) {
  
    return DriverSv::getList($data);
  
  }

  public function login($data) {
  
    return DriverSv::login($data);
  
  }

  public function getOrderList($data) {
  
    return DriverSv::getOrderList($data); 
  
  }

  public function confirmTrans($data) {
  
    return DriverSv::confirmTrans($data); 
  
  }

  public function finishTrans($data) {
  
    return DriverSv::finishTrans($data);
  
  }

}
