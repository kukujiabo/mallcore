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

  public function getList($data) {
  
    return ManagerWorkspaceSv::getList($data);
  
  }

  public function getDetail($data) {
  
    return ManagerWorkspaceSv::getDetail($data);
  
  }

}
