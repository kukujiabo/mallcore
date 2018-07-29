<?php
namespace App\Api;

/**
 * 订单确认拍照接口
 *
 */
class OrderSignImage extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
    
      'create' => array(
      
        'order_id' => 'order_id|int|true||订单id',
        'driver_id' => 'driver_id|true|int||驾驶员id',
        'path' => 'path|string|true||图片路径'
      
      ),

      'getImageByOrderId' => array(
      
        'order_id' => 'order_id|int|true||订单id'
      
      )
    
    ));
  
  }

  /**
   * 上传照片
   * @desc 上传照片
   *
   * @return int id
   */
  public function create() {
  
    return $this->dm->create($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 根据订单id查询照片
   * @desc 根据订单id查询照片
   *
   * @return array list
   */
  public function getImageByOrderId() {
  
    return $this->dm->getImageByOrderId($this->retriveRuleParams(__FUNCTION__));
  
  }

}
