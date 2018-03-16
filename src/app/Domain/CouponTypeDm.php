<?php
namespace App\Domain;

use App\Service\Crm\CouponTypeSv;

/**
 * 优惠券种类
 * 
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-18
 */
class CouponTypeDm {

  /**
   * 新增
   */
  public function add($data) {

    $data['create_time'] = date("Y-m-d H:i:s");

    return CouponTypeSv::add($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {

    $id = $data['coupon_type_id'];
    
    unset($data['coupon_type_id']);

    $data['update_time'] = date("Y-m-d H:i:s");
    
    if ($data['deleted_at'] == 1) {

      $data['deleted_at'] = time();

    }

    return CouponTypeSv::update($id, $data);
  
  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {

    return CouponTypeSv::findOne($condition['coupon_type_id']);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return CouponTypeSv::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);
  
  }

  /**
   * 获取数量
   */
  public function queryCount($condition) {
  
    return CouponTypeSv::queryCount($condition);

  }

  /**
   * 启用规则
   */
  public function enable($condition) {

    return CouponTypeSv::enable($condition['coupon_type_id']);

  }

  /**
   * 禁用规则
   */
  public function disable($condition) {
  
    return CouponTypeSv::disable($condition['coupon_type_id']);

  }

  /**
   * 创建优惠券类型
   */
  public function createCouponType($data) {
  
    return CouponTypeSv::createCouponType($data);
  
  }

}
