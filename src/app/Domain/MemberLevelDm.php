<?php
namespace App\Domain;

use App\Service\Crm\MemberLevelSv;

class MemberLevelDm {

  /**
   * 新增会员等级
   */ 
  public function add($data) {
  
    return MemberLevelSv::addLevel($data);
  
  }

  /**
   * 查询单个信息
   */
  public function findOne($data) {
  
    return MemberLevelSv::findOne($data['level_id']);
  
  }

  /**
   * 更新等级信息
   */
  public function update($data) {
  
    $id = $data['level_id'];
  
    unset($data['id']);

    return MemberLevelSv::update($id, $data);
  
  }

  /**
   * 获取全部会员等级信息
   */
  public function getAll($condition, $order) {
  
    return MemberLevelSv::all($condition, $order);
  
  }

  /**
   * 删除会员等级
   */
  public function remove($data) {
  
    return MemberLevelSv::remove($data['level_id']);
  
  }

}
