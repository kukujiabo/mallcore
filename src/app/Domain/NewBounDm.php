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

  public function removeBoun($data) {
  
    return NewBounSv::removeBoun($data);
  
  }

  public function grantNew($data) {
  
    return NewBounSv::grantNew($data);
  
  }

  public function checkFetched($data) {
  
    return NewBounSv::checkFetched($data);
  
  }

}
