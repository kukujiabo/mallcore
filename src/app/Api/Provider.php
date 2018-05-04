<?php
namespace App\Api;

/**
 * 供应商接口
 *
 * @author Meroc Chen <398515393@qq.com> 2018-05-03
 */
class Provider extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
    
      'addProvider' => array(
      
        'pname' => 'pname|string|true||供应商名称',
        'address' => 'address|string|false||供应商地址',
        'contact' => 'contact|string|false||联系人姓名',
        'phone' => 'phone|string|false||联系人手机号',
        'province' => 'province|string|false||所属省份',
        'city' => 'city|string|false||所属城市',
        'introduction' => 'introduction|string|false||介绍',
        'thumbnail' => 'thumbnail|string|false||供应商图标',
        'status' => 'status|int|false|1|供应商状态',
        'account' => 'account|string|true||供应商账号',
        'password' => 'password|string|true||供应商密码'
      
      ),

      'getList' => array(
      
        'pname' => 'pname|string|false||供应商名称',
        'contact' => 'contact|string|false||供应商联系人',
        'phone' => 'phone|string|false||供应商手机号',
        'account' => 'account|string|false||供应商账号',
        'province' => 'province|string|false||供应商省份',
        'city' => 'city|string|false||供应商城市',
        'order' => 'order|string|false|created_at desc|排序',
        'page' => 'page|int|false|1|页码',
        'page_size' => 'page_size|int|false|20|每页条数'
      
      ),

      'getAll' => array(
      
      
      )
    
    ));
  
  }

  /**
   * 新增供应商
   * @desc 新增供应商
   *
   * @return int id
   */
  public function addProvider() {
  
    return $this->dm->addProvider($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 查询供应商列表
   * @desc 查询供应商列表
   *
   * @return array list
   */
  public function getList() {
  
    return $this->dm->getList($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 获取全部供应商
   * @desc 获取全部供应商
   *
   * @return 
   */
  public function getAll() {
  
    return $this->dm->getAll();  
  
  }

}
