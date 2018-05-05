<?php
namespace App\Domain;

use App\Service\WorkSpace\WorkSpaceSv;

/**
 * 工地资料
 */
class WorkSpaceDm {

  public function addWorkSpace($data) {
  
    return WorkSpaceSv::addWorkSpace($data);
  
  }

  public function getList($data) {

    $order = $data['order'];
    $page = $data['page'];
    $pageSize = $data['page_size'];

    unset($data['order']);
    unset($data['page']);
    unset($data['page_size']);
  
    return WorkSpaceSv::getList($data, $order, $page, $pageSize);
  
  }

}
