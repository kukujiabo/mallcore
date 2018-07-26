<?php
namespace App\Domain;

use App\Service\Transport\TransSv;

class TransDm {

  public function pushLocation() {
  
    return TransSv::pushLocation();
  
  }

}
