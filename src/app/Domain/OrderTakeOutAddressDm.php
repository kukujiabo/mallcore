<?php
namespace App\Domain;

use App\Service\Takeaway\OrderAddressSv;

/**
 * 用户订单地址
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-11
 */
class OrderTakeOutAddress {

  /**
   * 新增
   */
  public function add($data) {

    return OrderAddressSv::add($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {

    return OrderAddressSv::update($data);
  
  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {

    return OrderAddressSv::getDetail($condition);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return OrderAddressSv::queryList($condition);
  
  }

  /**
   * 获取数量
   */
  public function queryCount($condition) {
  
    return OrderAddressSv::queryCount($condition);

  }
    
}
