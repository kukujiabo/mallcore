<?php
namespace App\Domain;

use App\Service\Crm\CouponUseLogSv;

/**
 * 优惠券使用日志
 * 
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-18
 */
class CouponUseLogDm {

  /**
   * 新增
   */
  public function add($data) {
    
    $data['created_at'] = date("Y-m-d H:i:s");

    return CouponUseLogSv::add($data);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return CouponUseLogSv::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);
  
  }

  /**
   * 获取数量
   */
  public function queryCount($condition) {
    
    return CouponUseLogSv::queryCount($condition);

  }

}
