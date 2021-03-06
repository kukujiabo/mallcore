<?php
namespace App\Api;

/**
 * 数据员接口
 * @desc 数据员接口
 */
class DataManager extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
    
      'create' => array(
      
        'name' => 'name|string|true||名称',
        'mobile' => 'mobile|string|true||手机号',
        'city_code' => 'city_code|string|true||名称'
      
      ),

      'getList' => array(
      
        'name' => 'name|string|false||名称',
        'mobile' => 'mobile|string|false||手机号',
        'city_code' => 'city_code|string|false||名称',
        'page' => 'page|int|false|1|页码',
        'page_size' => 'page_size|int|false|1|每页条数',
      
      ),

      'removeManager' => array(
      
        'id' => 'id|int|true||数据员id'
      
      )
    
    ));
  
  }

  /**
   * 新增数据员
   * @desc 新增数据员
   *
   * @return int id
   */
  public function create() {
  
    return $this->dm->create($this->retriveRuleParams(__FUNCTION__));  
  
  }

  /** 
   * 查询数据员列表
   * @desc 查询数据员列表
   *
   * @return array list
   */
  public function getList() {
  
    return $this->dm->getList($this->retriveRuleParams(__FUNCTION__)); 
  
  }

  /**
   * 删除数据员
   * @desc 删除数据员
   *
   * @return int num
   */
  public function removeManager() {
  
    return $this->dm->removeManager($this->retriveRuleParams(__FUNCTION__)); 
  
  }

}
