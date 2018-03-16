<?php
namespace App\Domain;

use App\Service\Takeaway\OrderTakeOutGoodsSv;

/**
 * 外卖订单商品
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-11
 */
class OrderTakeOutGoodsDm {

  /**
   * 新增
   */
  public function add($data) {

    return OrderTakeOutGoodsSv::addOrderGoods($data);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return OrderTakeOutGoodsSv::getList($condition);
  
  }

  /**
   * 获取数量
   */
  public function queryCount($condition) {
  
    return OrderTakeOutGoodsSv::queryCount($condition);

  }
    
}
