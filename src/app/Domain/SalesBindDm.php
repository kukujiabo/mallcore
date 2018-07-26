<?php
namespace App\Domain;

use App\Service\Admin\SalesBindSv;

class SalesBindDm {

  public function addBindings($data) {
  
    return SalesBindSv::addBindings($data); 
  
  }

  public function unbind($data) {
  
    return SalesBindSv::unbind($data);
  
  }

}
