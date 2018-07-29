<?php
namespace App\Api;

/**
 * 驾驶员接口
 *
 */
class Driver extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
    
      'create' => array(
      
        'account' => 'account|string|true||账号（手机号）',
        'password' => 'password|string|true||密码',
        'name' => 'name|string|true||真实姓名',
        'city_code' => 'city_code|string|true||所属城市',
        'remark' => 'remark|string|false||备注'
      
      ),

      'getList' => array(

        'account' => 'account|string|false||账号',
        'name' => 'name|string|false||姓名',
        'city_code' => 'city_code|string|true||所属城市',
        'page' => 'page|int|false||页码',
        'page_size' => 'page_size|int|false|20|每页条数'
      
      ),

      'login' => array(
      
        'account' => 'account|string|true||账号',
        'password' => 'password|string|true||密码'
      
      )
    
    ));
  
  }

  /**
   * 新增驾驶员
   * @desc 新增驾驶员
   *
   * @return int 
   */
  public function create() {
  
    return $this->dm->create($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 获取驾驶员列表
   * @desc 获取驾驶员列表
   *
   * @return int
   */
  public function getList() {
  
    return $this->dm->getList($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   *
   *
   */
  public function login() {
  
    return $this->dm->login($this->retriveRuleParams(__FUNCTION__));
  
  }

}
