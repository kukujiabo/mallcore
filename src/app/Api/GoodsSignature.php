<?php
namespace App\Api;

/**
 * 商品标签接口
 *
 */
class GoodsSignature extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
    
      'getAll' => array()
    
    ));
  
  }

  /**
   * 获取全部标签
   * @desc 获取全部标签
   *
   * @return array list
   */
  public function getAll() {
  
    return $this->dm->getAll();
  
  }

}
