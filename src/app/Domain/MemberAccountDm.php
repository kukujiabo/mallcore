<?php
namespace App\Domain;

use App\Service\Crm\MemberAccountSv;

/**
 * 会员账户
 * 
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-11-07
 */
class MemberAccountDm {

  /**
   * pos修改卡号同步线上
   */
  public function posUpdateMemberCardId($params) {

    return MemberAccountSv::posUpdateMemberCardId($params);
  
  }

  /**
   * 新增
   */
  public function add($data) {

    return MemberAccountSv::add($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {
    
    return MemberAccountSv::updates($data);
  
  }

  /**
   * 获取Poss会员详情
   */
  public function getPossDetail($condition) {
      
    return MemberAccountSv::getPossDetail($condition);
  
  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {

    return MemberAccountSv::getDetails($condition);
  
  }



  /**
   * 获取列表
   */
  public function queryList($condition) {

    return MemberAccountSv::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);
  
  }

  /**
   * 获取数量
   */
  public function queryCount($condition) {
  
    return MemberAccountSv::queryCount($condition);

  }

  /**
   * 启用规则
   */
  public function enable($condition) {

    return MemberAccountSv::enable($condition['coupon_type_id']);

  }

  /**
   * 禁用规则
   */
  public function disable($condition) {
  
    return MemberAccountSv::disable($condition['coupon_type_id']);

  }


  public function addMoney($data) {

    return MemberAccountSv::addMoney($data['uid'], $data['money']);
  
  }

  /**
   * 线下使用余额消费同步会员余额
   */
  public function offlineUseMoney($data) {
  
    return MemberAccountSv::offlineUseAccountMoney($data['mobile'], $data['money'], $data['orderId'], $data['remark']);
  
  }

  /**
   * 线下充值
   */
  public function offlineChargeMoney($data) {
  
    return MemberAccountSv::offlineChargeMoney($data['mobile'], $data['money'], $data['remark']);
  
  }

}
