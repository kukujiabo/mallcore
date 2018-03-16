<?php
namespace App\Domain;

use App\Service\Crm\CouponGrantLogSv;

/**
 * 优惠券发放记录
 * 
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-18
 */
class CouponGrantLogDm {

  /**
   * 新增优惠券发放记录
   */
  public function add($data) {
    
    $data['created_at'] = date("Y-m-d H:i:s");

    return CouponGrantLogSv::add($data);
  
  }

  /**
   * 获取优惠券发放记录列表
   */
  public function queryList($condition) {

    return CouponGrantLogSv::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);
  
  }

  /**
   * 获取优惠券发放记录总数
   */
  public function queryCount($condition) {
  
    return CouponGrantLogSv::queryCount($condition);

  }

  /**
   * 发放日志联合信息
   */
  public function couponGrantUnionLog($params) {
  
    return CouponGrantLogSv::couponGrantUnionLog($params);
  
  }

}
