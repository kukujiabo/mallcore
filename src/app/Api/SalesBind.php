<?php
namespace App\Api;

/**
 * 绑定销售员接口
 *
 */
class SalesBind extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
    
      'addBindings' => array(
      
        'account' => 'account|string|true||账号',
      
        'mobiles' => 'mobiles|string|true||手机号'
      
      ),

      'unbind' => array(
      
        'account' => 'account|string|true||账号',
      
        'sales_phone' => 'sales_phone|string|true||手机号'
      
      )
    
    ));
  
  }

  public function addBindings() {
  
    return $this->dm->addBindings($this->retriveRuleParams(__FUNCTION__)); 
  
  }

  public function unbind() {
  
    return $this->dm->unbind($this->retriveRuleParams(__FUNCTION__));
  
  }

}
