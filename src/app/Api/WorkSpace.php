<?php
namespace App\Api;

/**
 * 工地接口
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class WorkSpace extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
    
      'addWorkSpace' => array(
      
        'pid' => 'pid|int|true||所属供应商',
        'name' => 'name|string|true||工地名称',
        'address' => 'address|string|false||工地地址',
        'province' => 'province|string|false||所在省份',
        'city' => 'city|int|false||所在城市',
        'contact' => 'contact|string|false||联系人',
        'phone' => 'phone|string|false||手机号'
      
      ),

      'getList' => array(
      
        'pid' => 'pid|int|false||供应商id',
        'name' => 'name|string|false||工地名称',
        'province' => 'province|string|false||省份id',
        'city' => 'city|string|false||城市id',
        'order' => 'order|string|false||排序',
        'page' => 'page|int|false||页码',
        'page_size' => 'page_size|int|false||每页条数'
      
      ),

      'getListByToken' => array(
        'token' => 'token|string|true||令牌',
        'page' => 'page|int|false|1|页码',
        'page_size' => 'page_size|int|false|20|每页条数'
      )
    
    ));
  
  }

  /**
   * 新增工地档案接口
   * @desc 新增工地档案接口
   *
   * @return int id
   */
  public function addWorkSpace() {
  
    return $this->dm->addWorkSpace($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 查询工地列表
   * @desc 查询工地列表
   *
   * @return array list
   */
  public function getList() {
  
    return $this->dm->getList($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 根据token获取工地列表
   * @desc 根据token获取工地列表
   *
   * @return array list
   */
  public function getListByToken() {
  
    return $this->dm->getListByToken($this->retriveRuleParams(__FUNCTION__));
  
  }

}
