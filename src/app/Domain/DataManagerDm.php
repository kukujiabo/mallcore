<?php
namespace App\Domain;

use App\Service\Takeaway\DataManagerSv;

class DataManagerDm {

  public function create($data) {
  
    return DataManagerSv::create($data);
  
  }

  public function getList($data) {
  
    return DataManagerSv::getList($data);
  
  }

}
