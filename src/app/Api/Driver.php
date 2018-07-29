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
      
      ),

      'getOrderList' => array(
      
        'driver_phone' => 'driver_phone|string|true||驾驶员电话',
        'trans' => 'trans|int|0||运输状态',
        'page' => 'page|int|false|1|页码',
        'page_size' => 'page_size|int|false|8|每页条数'
      
      ),

      'confirmTrans' => array(
      
        'driver_phone' => 'driver_phone|string|true||驾驶员手机号',
        'id' => 'id|int|true||订单id'
      
      ),

      'finishTrans' => array(
      
        'driver_phone' => 'driver_phone|string|true||驾驶员手机号',
        'id' => 'id|int|true||订单id'
      
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
   * 驾驶员登录
   * @desc 驾驶员登录
   *
   * @return array
   */
  public function login() {
  
    return $this->dm->login($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 查询送货订单
   * @desc 查询送货订单
   *
   * @return array list
   */
  public function getOrderList() {
  
    return $this->dm->getOrderList($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 确认开始配送
   * @desc 确认开始配送
   *
   * @return 
   */
  public function confirmTrans() {
  
    return $this->dm->confirmTrans($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 确认配送完成
   * @desc 确认配送完成
   *
   * @return 
   */
  public function finishTrans() {
  
    return $this->dm->finishTrans($this->retriveRuleParams(__FUNCTION__)); 
  
  }

}
