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
      
      
      ),

      'removeBoun' => array(
      
        'id' => 'id|int|true||优惠券id'
      
      ),

      'grantNew' => array(
      
        'token' => 'token|string|true||用户令牌',

        'sequence' => 'sequence|string|true||序列'
      
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

  /**
   * 删除新手礼包优惠券
   * @desc 删除新手礼包优惠券
   *
   * @return int id
   */
  public function removeBoun() {
  
    return $this->dm->removeBoun($this->retriveRuleParams(__FUNCTION__)); 
  
  }

  /**
   * 发放新人礼包
   * @desc 发放新人礼包
   *
   * @return int num
   */
  public function grantNew() {
  
    return $this->dm->grantNew($this->retriveRuleParams(__FUNCTION__)); 
  
  }

}
