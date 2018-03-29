<?php
namespace App\Domain;

use App\Service\TmpDataSv;

class TmpDataDm {

  public function importBrand() {
  
    TmpDataSv::importBrand();
  
  }

  public function importGoods() {
  
    TmpDataSv::importGoods();
  
  }

}
