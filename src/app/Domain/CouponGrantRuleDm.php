<?php
namespace App\Domain;

use App\Service\Crm\CouponGrantRuleSv;

/**
 * 优惠券发放规则
 * 
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-18
 */
class CouponGrantRuleDm {

  /**
   * 新增
   */
  public function add($data) {

    $data['created_at'] = date("Y-m-d H:i:s");

    return CouponGrantRuleSv::add($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {
    
    $id = $data['id'];

    unset($data['id']);

    $data['updated_at'] = date("Y-m-d H:i:s");

    return CouponGrantRuleSv::update($id, $data);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return CouponGrantRuleSv::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);
  
  }

  /**
   * 获取数量
   */
  public function queryCount($condition) {
  
    return CouponGrantRuleSv::queryCount($condition);

  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {
    
    return CouponGrantRuleSv::findOne($condition['id']);

  }

  /**
   * 启用规则
   */
  public function enable($condition) {
  
    return CouponGrantRuleSv::enable($condition['id']);

  }

  /**
   * 禁用规则
   */
  public function disable($condition) {
  
    return CouponGrantRuleSv::disable($condition['id']);

  }

}
