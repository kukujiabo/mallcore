<?php
namespace App\Domain;

use App\Service\Crm\MemberCardSv;

/**
 * 会员卡
 */
class MemberCardDm {

  /**
   * 查询会员卡列表
   */
  public function getList($data) {
  
    return MemberCardSv::getList($data);
  
  }

  /**
   * 查询总数
   */
  public function getCount($data) {
  
    return MemberCardSv::queryCount($data);
  
  }

  /**
   * 添加
   */
  public function add($data) {
  
    return MemberCardSv::addMemberCard($data);
  
  }

  /**
   * 修改
   */
  public function update($data) {
  
    return MemberCardSv::edit($data);
  
  }

  /**
   * 查询详情
   */
  public function getDetail($data) {
  
    return MemberCardSv::findOne($data);
  
  }

}
