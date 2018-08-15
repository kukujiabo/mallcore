<?php
namespace App\Domain;

use App\Service\Crm\NewBounSv;

class NewBounDm {

  public function create($data) {
  
    return NewBounSv::create($data);
  
  }

  public function getAll($data) {
  
    return NewBounSv::getAll($data); 
  
  }

}
