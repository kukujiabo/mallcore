<?php
namespace App\Interfaces\TableOrder;

/**
 * 点餐订单接口
 *
 * @author Meroc Chen <398515393@qq.com> 2017-10-09
 */
interface IOrder {

  /**
   * 1.新增订单
   *
   * @param mixed $data
   *
   * @return int $id
   */
  public function add($data);

  /**
   * 2.申请取消订单
   *
   * @param string $orderId
   *
   * @return boolean true/false
   */
  public function applyCancel($orderId);

  /**
   * 3.商户确认接单
   *
   * @param string $orderId
   *
   * @return boolean true/false
   */
  public function confirmOrder($orderId);

  /**
   * 4.完成订单
   *
   * @param string $orderId
   *
   * @return boolean true/false
   */
  public function completeOrder($orderId);

  /**
   * 5.商户拒绝订单
   *
   * @param string $orderId
   *
   * @return boolean true/false
   */
  public function rejectOrder($orderId);

  /**
   * 6.推送订单到pos系统
   *
   * @param string $orderId
   *
   * @return boolean true/false
   */
  public function pushOrderToPos($orderId);


}
