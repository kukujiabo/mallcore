<?php
namespace App\Domain;

use App\Service\Crm\ManagerSv;

/**
 * 项目经理
 */
class ManagerDm {

  /**
   * 新增项目经理
   */
  public function addManager($data) {
  
    return ManagerSv::addManager($data); 
  
  }

  /**
   * 查询列表
   */
  public function getList($data) {

    $page = $data['page'];
    $pageSize = $data['page_size'];
    $order = $data['order'];

    unset($data['page']);
    unset($data['page_size']);
    unset($data['order']);
  
    return ManagerSv::getList($data, $order, $page, $pageSize);
  
  }

  /**
   * 查询所有条目
   */
  public function getAll($data) {
  
    return ManagerSv::all($data);
  
  }

}
