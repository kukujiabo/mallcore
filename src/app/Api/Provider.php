<?php
namespace App\Api;

/**
 * 装修公司接口
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
        'ptype' => 'ptype|int|false|1|公司类型',
        'password' => 'password|string|true||供应商密码'
      
      ),

      'getDetail' => array(
      
        'id' => 'id|int|true||装修公司id'
      
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

      'edit' => array(
      
        'id' => 'id|int|true||装修公司id',
        'pname' => 'pname|string|false||装修公司名称',
        'contact' => 'contact|string|false||装修公司联系人',
        'phone' => 'phone|string|false||装修公司手机号',
        'account' => 'account|string|false||装修公司账号',
        'address' => 'address|string|false||装修公司地址',
        'province' => 'province|string|false||装修公司省份',
        'city' => 'city|string|false||装修公司城市',
        'introduction' => 'introduction|string|false||装修公司简介',
        'thumbnail' => 'thumbnail|string|false||装修公司图标',
        'password' => 'password|string|false||装修公司密码',
        'status' => 'status|int|false||装修公司状态',
        'ptype' => 'ptype|int|false||公司类型'
      
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

  /**
   * 查询详情
   * @desc 查询详情
   *
   * @return
   */
  public function getDetail() {
  
    return $this->dm->getDetail($this->retriveRuleParams(__FUNCTION__)); 
  
  }

  /**
   * 编辑装修公司
   * @desc 编辑装修公司
   *
   * @return 
   */
  public function edit() {
  
    return $this->dm->edit($this->retriveRuleParams(__FUNCTION__));
  
  }

}
