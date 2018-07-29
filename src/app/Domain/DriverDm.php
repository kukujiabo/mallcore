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

}
