<?php
namespace App\Domain;

use App\Service\Crm\MemberSignSv;

/**
 * 会员签到
 * 
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-11-15
 */
class MemberSignDm {

  /**
   * 新增
   */
  public function add($data) {

    return MemberSignSv::addMemberSign($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {
    
    return MemberSignSv::edit($data);
  
  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {

    return MemberSignSv::getDetail($condition);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return MemberSignSv::getList($condition);
  
  }

  /**
   * 获取数量
   */
  public function queryCount($condition) {
  
    return MemberSignSv::getCount($condition);

  }

  /**
   * 获取签名奖励
   */
  public function getSignRewards($data) {
  
    return MemberSignSv::getSignRewards($data['token']);
  
  }

}
