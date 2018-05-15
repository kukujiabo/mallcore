<?php
namespace App\Domain;

use App\Service\WorkSpace\WorkSpaceSv;
use App\Service\Crm\UserSv;
use App\Service\Crm\ManagerSv;

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

  /**
   * 获取列表
   *
   */
  public function getListByToken($data) {
  
    $user = getUserByToken($data['token']);

    $manager = ManagerSv::findOne(array('user_tel' => $user['user_tel']));

    $condition = array(
    
      'pid' => $manager['pid'],

      'page' => $data['page'],

      'page_size' => $data['page_size']
    
    );

    return $this->getList($condition);
  
  }

}
