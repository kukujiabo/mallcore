<?php
namespace App\Api;

/**
 * 爆款商品接口
 *
 */
class HotGoods extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
    
      'create' => array(
      
        'city_code' => 'city_code|int|true||城市代码',

        'goods_id' => 'goods_id|int|true||商品id'
      
      ),

      'getList' => array(
      
        'city_code' => 'city_code|int|true||城市代码',
        'page' => 'page|int|true||页码',
        'page_size' => 'page_size|int|true||每页条数'
      
      ),

      'remove' => array(
      
        'id' => 'id|int|true||删除'
      
      )
    
    ));
  
  }

  /**
   * 新增爆款商品
   * @desc 新增爆款商品
   *
   * @return int id
   */
  public function create() {
  
    return $this->dm->create($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 爆款商品列表
   * @desc 爆款商品列表
   *
   * @return array list
   */
  public function getList() {
  
    return $this->dm->getList($this->retriveRuleParams(__FUNCTION__)); 
  
  }

  /**
   * 删除爆款商品
   * @desc 删除爆款商品
   *
   * @return int num
   */
  public function remove() {
  
    return $this->dm->remove($this->retriveRuleParams(__FUNCTION__)); 
  
  }

}
