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


}
