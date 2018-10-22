<?php
namespace App\Domain;

use App\Service\Crm\MerchantSv;

class MerchantDm {

  public function create($data) {
  
    return MerchantSv::create($data);
  
  }

  public function listQuery($data) {
  
    return MerchantSv::listQuery($data);
  
  }

}
