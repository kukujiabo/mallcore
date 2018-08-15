<?php
namespace App\Api;

/**
 * 新用户礼包接口
 * @desc 新用户礼包接口
 *
 */
class NewBoun extends BaseApi {

  public function getRules() {
   
    return $this->rules(array(
    
      'create' => array(
      
        'coupons' => 'coupons|string|true||优惠券信息'
      
      ),

      'getAll' => array(
      
      
      )
    
    )); 
  
  }

  /**
   * 新增礼包优惠券
   * @desc 新增礼包优惠券
   *
   * @return int num
   */
  public function create() {
  
    return $this->dm->create($this->retriveRuleParams(__FUNCTION__)); 
  
  }

  /**
   * 查询全部礼包优惠券
   * @desc 查询全部礼包优惠券
   *
   * @return array data
   */
  public function getAll() {
  
    return $this->dm->getAll($this->retriveRuleParams(__FUNCTION__));
  
  }

}
