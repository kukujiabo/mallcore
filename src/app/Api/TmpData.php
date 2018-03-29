<?php
namespace App\Api;

/**
 * 临时数据处理接口
 */
class TmpData extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
    
      'importBrand' => array(
      
      
      ),

      'importGoods' => array(
      
      
      )
    
    ));
  
  }

  /**
   * 导入品牌
   * @desc 导入品牌
   *
   */
  public function importBrand() {
  
    return $this->dm->importBrand();
  
  }

  public function importGoods() {
  
    return $this->dm->importGoods();
  
  }

}
