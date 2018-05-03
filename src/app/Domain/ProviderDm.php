<?php
namespace App\Domain;

use App\Service\Admin\ProviderSv;

class ProviderDm {

  /**
   * 新增供应商
   */
  public function addProvider($data) {
  
    return ProviderSv::addProvider($data);
  
  }

}
