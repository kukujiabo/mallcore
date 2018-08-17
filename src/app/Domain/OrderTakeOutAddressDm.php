<?php
namespace App\Domain;

use App\Service\Takeaway\OrderTakeOutAddressSv;

/**
 * 用户订单地址
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-11
 */
class OrderTakeOutAddressDm {

  /**
   * 新增
   */
  public function add($data) {

    return OrderTakeOutAddressSv::add($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {

    return OrderTakeOutAddressSv::update($data);
  
  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {

    return OrderTakeOutAddressSv::getDetail($condition);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return OrderTakeOutAddressSv::queryList($condition);
  
  }

  /**
   * 获取数量
   */
  public function queryCount($condition) {
  
    return OrderTakeOutAddressSv::queryCount($condition);

  }
    
}
