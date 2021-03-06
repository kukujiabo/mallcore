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
  
    $user = UserSv::getUserByToken($data['token']);

    $manager = ManagerSv::findOne(array('phone' => $user['user_tel']));

    if (!$manager) {
    
      return null;
    
    }

    $condition = array(
    
      'mid' => $manager['id']
    
    );

    return WorkSpaceSv::getAllByMid($condition);
  
  }

  /**
   * 设置施工阶段
   *
   */
  public function setTiming($data) {
  
    return WorkSpaceSv::setTiming($data);
  
  }

}
