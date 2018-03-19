<?php
namespace App\Domain;

use App\Service\Takeaway\CartTakeOutSv;

/**
 * 外卖购物车
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-15
 */
class CartTakeOutDm {

  /**
   * 新增
   */
  public function add($data) {

    return CartTakeOutSv::addCart($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {

    return CartTakeOutSv::updates($data);
  
  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {

    return CartTakeOutSv::getDetail($condition);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return CartTakeOutSv::getList($condition);
  
  }

  /**
   * 获取数量
   */
  public function queryCount($condition) {
  
    return CartTakeOutSv::getCount($condition);

  }

  /**
   * 清空
   */
  public function cartEmpty($condition) {
  
    return CartTakeOutSv::cartEmpty($condition);

  }

  /**
   * 删除商品
   */
  public function remove($condition) {
  
    $id = $condition['cart_id'];

    return CartTakeOutSv::remove($id);
  
  }
    
}
