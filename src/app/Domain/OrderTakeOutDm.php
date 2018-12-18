<?php
namespace App\Domain;

use App\Service\Takeaway\OrderTakeOutSv;

/**
 * 外卖订单
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-11
 */
class OrderTakeOutDm {

  /**
   * pos请求修改外卖订单状态
   */
  public function updateOrderTakeOut($data) {

    return OrderTakeOutSv::updateOrderTakeOut($data);
  
  }

  /**
   * pos获取外卖订单信息
   */
  public function getOrderTakeOut($data) {

    return OrderTakeOutSv::getOrderTakeOut($data);
  
  }

  /**
   * 取消订单接口服务
   */
  public function cancelOrder($data) {

    return OrderTakeOutSv::cancelOrder($data);
  
  }

  /**
   * 立即购买
   */
  public function purchase($data) {

    return OrderTakeOutSv::purchase($data);
  
  }

  /**
   * 新增
   */
  public function add($data) {

    return OrderTakeOutSv::adds($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {

    return OrderTakeOutSv::updates($data);
  
  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {

    return OrderTakeOutSv::getDetails($condition);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return OrderTakeOutSv::getList($condition);
  
  }

  /**
   * 获取数量
   */
  public function queryCount($condition) {
  
    return OrderTakeOutSv::getCount($condition);

  }

  /**
   * 订单支付
   */
  public function payOrderTakeOut($params) {
  
    return OrderTakeOutSv::payOrderTakeOut($params);

  }

  /**
   * 查询新的外卖订单
   */
  public function setPushed($params) {
  
    return OrderTakeOutSv::setPushed($params);
  
  }
    
  /**
   * 根据订单号修改订单状态
   */
  public function updateOrderStatusByOrderNo($params) {
  
    return OrderTakeOutSv::updateOrderStatusByOrderNo($params['order_sn'], $params['status']);
  
  }

  /**
   * 订单列表查询
   */
  public function orderList($params) {
  
    return OrderTakeOutSv::orderList($params);
  
  }

  /**
   * 重新下单
   */
  public function rebuyOrder($params) {
  
    return OrderTakeOutSv::rebuyOrder($params);
  
  }

  /**
   * 导出excel
   */
  public function exportExcel($params) {
  
    return OrderTakeOutSv::exportExcel($params);
  
  }

  /**
   * 审核订单，同步u8
   */
  public function audit($data) {
  
    return OrderTakeOutSv::audit($data);
  
  }

  /**
   * 删除订单
   */
  public function removeOrder($params) {
    
    return OrderTakeOutSv::removeOrder($params);
  
  }

  /**
   * 查询业务员销售总额
   */
  public function getSalesAmount($params) {
  
    return OrderTakeOutSv::getSalesAmount($params);
  
  }

  /**
   * 退货
   */
  public function orderAfterSale($data) {
  
    return OrderTakeOutSv::orderAfterSale($data); 
  
  }

  public function getOrderNum($data) {
  
    return OrderTakeOutSv::getOrderNum($data);
  
  }

  public function getTransFirstLocation($data) {
  
    return OrderTakeOutSv::getTransFirstLocation($data);
  
  }

  public function reAudit($data) {
  
    return OrderTakeOutSv::update($data['order_id'], array('audit' => 0));
  
  }

  public function cancelReturnGoods($data) {
  
    return OrderTakeOutSv::cancelReturnGoods($data);
  
  }

}
