<?php
namespace App\Api;

/**
 * 运输相关接口
 *
 * @author Meroc Chen
 */
class Trans extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
    
      'pushLocation' => array(
      
      )
    
    ));
  
  }

  /**
   * 推送坐标接口
   * @desc 推送坐标接口
   *
   * @return
   */
  public function pushLocation() {
  
    return $this->dm->pushLocation();
  
  }

}
