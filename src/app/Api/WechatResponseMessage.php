<?php
namespace App\Api;

/**
 * 微信回复消息
 *
 */
class WechatResponseMessage extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
    
      'editResponseMessage' => array(
      
        'token' => 'token|string|true||用户令牌',
      
        'text' => 'text|string|true||回复内容'
      
      ),

      'getFocusResponse' => array(
      
        'token' => 'token|string|true||用户令牌'
      
      )
    
    ));
  
  }

  /**
   * 编辑微信自动回复消息
   * @desc 编辑微信自动回复消息
   *
   * @return
   */
  public function editResponseMessage() {
  
    return $this->dm->editResponseMessage($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 查询关注回复内容
   * @desc 查询关注回复内容
   *
   * @return
   */
  public function getFocusResponse() {
  
    return $this->dm->getFocusResponse($this->retriveRuleParams(__FUNCTION__)); 
  
  }

}
