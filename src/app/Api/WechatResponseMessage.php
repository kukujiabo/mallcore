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
      
      ),

      'addKeywordResponse' => array(
      
        'token' => 'token|string|true||用户令牌',

        'kname' => 'kname|string|true||key',

        'keyword' => 'keyword|string|true||关键字',

        'ext_1' => 'ext_1|string|true||回复内容'
      
      ),

      'getKeywordList' => array(
      
        'token' => 'token|string|true||用户令牌',
      
      ),

      'deleteKeyword' => array(
      
        'token' => 'token|string|true||用户令牌',
        'id' => 'id|int|true||删除关键字',
      
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

  /**
   * 新增关键字回复
   * @desc 新增关键字回复
   *
   * @return
   */
  public function addKeywordResponse() {
  
    return $this->dm->addKeywordResponse($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 查询关键字列表
   * @desc 查询关键字列表
   *
   * @return array list
   */
  public function getKeywordList() {
  
    return $this->dm->getKeywordList($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 删除关键字
   * @desc 删除关键字
   *
   * @return int id
   */
  public function deleteKeyword() {
  
    return $this->dm->deleteKeyword($this->retriveRuleParams(__FUNCTION__));
  
  }

}
