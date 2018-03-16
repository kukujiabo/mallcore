<?php
namespace App\Domain;

use App\Service\CouponExchange\CouponExchangeSv;

/**
 * 提领券接口
 * 
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-21
 */
class CouponExchangeDm {

  /**
   * 新增
   */
  public function add($data) {

    return CouponExchangeSv::addCouponExchange($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {

    return CouponExchangeSv::edit($data);
  
  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {

    return CouponExchangeSv::getDetail($condition);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return CouponExchangeSv::getList($condition);
  
  }

  /**
   * 获取数量
   */
  public function queryCount($condition) {
  
    return CouponExchangeSv::getCount($condition);

  }

  /**
   * 提领券兑换下单
   */
  public function conversion($condition) {
  
    return CouponExchangeSv::conversion($condition);

  }

  /**
   * 提领券核销验证
   */
  public function cancelVerify($condition) {
  
    return CouponExchangeSv::cancelVerify($condition);

  }

  /**
   * 提领券核销
   */
  public function cancel($condition) {
  
    return CouponExchangeSv::cancel($condition);

  }

}
