<?php
namespace App\Api;

/**
 * 客户资料接口
 *
 */
class Merchant extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
    
      'create' => array(
      
        'mcode' => 'mcode|string|true||客户编码',
        'mname' => 'mname|string|true||客户名称',
        'phone' => 'phone|string|true||联系电话',
        'ext_1' => 'ext_1|string|true||联系人',
        'sales_id' => 'sales_id|int|true||销售id',
        'status' => 'status|int|true||状态',
        'brief' => 'brief|string|false||客户描述'
      
      ),

      'listQuery' => array(
      
        'mname' => 'mname|string|false||客户名称',
        'ext_1' => 'ext_1|string|false||联系人',
        'fields' => 'fields|string|false||字段',
        'order' => 'order|string|false||排序',
        'page' => 'page|int|false|1|页码',
        'page_size' => 'page_size|int|false|20|每页条数'
      
      )
    
    ));
  
  }

  /**
   * 新增客户资料
   * @desc 新增客户资料
   *
   * @return int id
   */
  public function create() {
  
    return $this->dm->create($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 查询资料列表 
   * @desc 查询资料列表 
   *
   * @return array data
   */
  public function listQuery() {
  
    return $this->dm->listQuery($this->retriveRuleParams(__FUNCTION__));
  
  }

}
