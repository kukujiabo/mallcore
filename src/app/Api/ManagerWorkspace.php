<?php
namespace App\Api;

/**
 * 项目经理关联工地接口
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class ManagerWorkspace extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
    
      'addNew' => array(
      
        'mid' => 'mid|int|true||项目经理id',
        'wid' => 'wid|int|true||工地id',
        'status' => 'status|int|true||状态',
        'min_credit' => 'min_credit|float|true||最大额度',
        'max_credit' => 'max_credit|float|true||最小额度'
      
      ) 
    
    ));
  
  }

  /**
   * 新增关联
   * @desc 新增关联
   *
   * @return int id
   */
  public function addNew() {
  
    return $this->dm->addNew($this->retriveRuleParams(__FUNCTION__));
  
  }


}
