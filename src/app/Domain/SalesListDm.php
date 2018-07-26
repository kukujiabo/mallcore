<?php
namespace App\Domain;

use App\Service\Admin\SalesListSv;

class SalesListDm {

  public function getList($data) {
  
    return SalesListSv::getList($data); 
  
  }

}
