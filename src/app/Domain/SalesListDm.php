<?php
namespace App\Domain;

class SalesListDm {

  public function getList($data) {
  
    return SalesListSv::getList($data); 
  
  }

}
