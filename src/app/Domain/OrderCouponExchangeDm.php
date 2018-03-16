<?php
namespace App\Domain;

use App\Service\CouponExchange\OrderCouponExchangeSv;

/**
 * 提领券订单
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-12-04
 */
class OrderCouponExchangeDm {

  /**
   * 新增
   */
  public function add($data) {

    return OrderCouponExchangeSv::addOrderCouponExchange($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {

    return OrderCouponExchangeSv::edit($data);
  
  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {
    
    return OrderCouponExchangeSv::getDetail($condition);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return OrderCouponExchangeSv::getList($condition);
  
  }

  /**
   * 获取数量
   */
  public function queryCount($condition) {
  
    return OrderCouponExchangeSv::queryCount($condition);

  }
    
}
