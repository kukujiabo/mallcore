<?php
namespace App\Domain;

use App\Service\WorkSpace\ManagerWorkspaceSv;

/**
 * 项目经理工地
 *
 */
class ManagerWorkspaceDm {

  public function addNew($data) {
  
    return ManagerWorkspaceSv::addNew($data);
  
  }

}
