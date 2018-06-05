<?php
namespace App\Api;

/**
 * 退单接口
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class OrderTakeOutReturn extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
    
      'createOrder' => array(
      
        'sn' => 'sn|string|true||订单编号',
        'user_id' => 'user_id|int|true||用户id',
        'member_name' => 'member_name|string|true||用户名称',
        'phone' => 'phone|string|true||手机号',
        'goods' => 'goods|string|true||退货商品数据'
      
      )
    
    )); 
  
  }


  /**
   * 新建订单
   * @desc 新建订单
   *
   * @return
   */
  public function createOrder() {
  
    return $this->dm->createOrder($this->retriveRuleParams(__FUNCTION__)); 
  
  }

}
