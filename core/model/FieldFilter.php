<?php
namespace Core\Model;

/**
 * 字段过滤器
 *
 * @author Meroc Chen <398515393@qq.com> 2017-10-13
 */
trait FieldFilter {

  /**
   * 过滤新增对象字段
   *
   * @param array $data
   * @param array $fields
   *
   * @return array $result
   */
  protected function editableFieldFilter($data, $fields = array()) {
  
    if (empty($fields)) {
    
      $fields = $this->_editableFields;
    
    }

    $result = array();

    foreach($fields as $field) {
    
      if (isset($data[$field])) {
      
        $result[$field] = $data[$field];

      }
      
    }

    return $result;
  
  }

  protected function queryFieldFilter($data, $fields = array()) {

    if (empty($fields)) {
    
      $fields = $this->_queryFields;
    
    }

    $result = array();

    foreach($fields as $field) {

      if (isset($data[$field])) {
      
        $result[$field] = $data[$field]; 
      
      }
    
    }
  
    return $result;

  }

}
