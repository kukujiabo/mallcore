<?php
namespace Core\Model;

/**
 * model 层基础CURD
 *
 * @author Meroc Chen <398515393@qq.com> 2017-10-11
 */
trait CURD {

  /**
   * 新增
   *
   * @param array $data 
   *
   * @return string $id
   */
  protected function add(Array $data) {

    $object = $this->editableFieldFilter($data);

    foreach($object as $key => $value) {
    
      $codeValue = iconv('UTF-8', 'GBK', $value);

      $object[$key] = $codeValue ? $codeValue : $value;
    
    }

    $this->orm()->insert($object);

    return $this->orm()->insert_id();

  }

  /**
   * 批量新增
   *
   * @param array $dataSet
   *
   * @return int num
   */
  protected function batchAdd(Array $dataSet) {

    $objectSet = array();
  
    foreach($dataSet as $data) {
    
      $object = $this->editableFieldFilter($data);

      foreach($object as $key => $value) {
      
        $codeValue = iconv('UTF-8', 'GBK', $value);

        $object[$key] = $codeValue ? $codeValue : $value;
      
      }

      array_push($objectSet, $object);
    
    }

    return $this->orm()->insert_multi($objectSet);
  
  }

  /**
   * 更新
   *
   * @param Mixed $id
   * @param array $data;
   *
   * @return int num
   */
  protected function update($id, Array $data) {

    $orm = $this->orm();

    $data = UpdateBuilder::buildUpdate($this->editableFieldFilter($data), $this->_updateOptionRule);

    $where = QueryBuilder::makeQuery(array( $this->_primaryKey => $id ), $this->_queryOptionRule);

    return $orm->where($where)->update($data);

  }

  /**
   * 批量更新
   *
   * @param array $condition 查询条件
   * @param array $data      修改数据
   *
   * @return int num         影响条数
   */
  protected function batchUpdate($condition, $data) {

    $orm = $this->orm();

    $data = UpdateBuilder::buildUpdate($this->editableFieldFilter($data), $this->_updateOptionRule);

    $where = QueryBuilder::makeQuery($condition, $this->_queryOptionRule);
  
    return $orm->where($where)->update($data);
  
  }


  /**
   * 根据条件查询表数据
   *
   * @param array $condition
   * @param string $fields
   * @param string $order
   * @param int $offset
   * @param int $limit
   *
   * @return array $list
   */
  protected function queryList($condition, $fields = " * ", $order = NULL, $offset = 0, $limit = 20) {

    $operation = $this->_queryOptionRule;

    $orm = $this->orm();

    $orm->select($fields);

    if (empty($order)) {
    
      $order = "{$this->_primaryKey} desc";
    
    }

    $orm->order($order);

    $orm->limit($limit, $offset);

    $condition= $this->queryFieldFilter($condition);

    $where = QueryBuilder::makeQuery($condition, $this->_queryOptionRule);

    return $orm->where($where)->fetchRows();

  }

  /**
   * 根据条件查询数据条数
   *
   * @param array $condition
   *
   * @return int $num
   */
  protected function number($condition) {
  
    $operation = $this->_queryOptionRule;

    $orm = $this->orm();

    $condition= $this->queryFieldFilter($condition);

    $where = QueryBuilder::makeQuery($condition, $this->_queryOptionRule);

    return $orm->where($where)->count();
  
  }

  /**
   * 根据id或unique值查找一个对象
   *
   * @param array/string $id
   *
   * @return mixed object
   */
  protected function findOne($id) {

    $orm = $this->orm();

    if (is_array($id)) {

      $condition= $this->queryFieldFilter($id);

      return $orm->where($condition)->fetchOne();

    } else {

      return $orm->where($this->_primaryKey, $id)->fetchOne();

    }
  
  }

  /**
   * 删除
   *
   * @param string $id
   * @param boolean $soft
   *
   * @return boolean true/false
   */
  protected function remove($id, $soft = true) {

    return $this->orm()->where($this->_primaryKey, $id)->delete();
  
  }

  /**
   * 批量删除
   *
   * @param array $condition
   * @param boolean $soft
   *
   * @return boolean true/false
   */
  protected function batchRemove($condition, $soft = true) {

    $where = QueryBuilder::makeQuery($condition, $this->_queryOptionRule);

    return $this->orm()->where($where)->delete();
  
  }

  /**
   * 查找所有满足条件的数据
   *
   * @param array $condition
   *
   * @return array $data
   */
  protected function all($condition, $order = NULL, $fields = '*') {
  
    $operation = $this->_queryOptionRule;

    $orm = $this->orm();

    $orm->select($fields);

    if ($order) {

      $orm->order($order);
    
    }

    $condition= $this->queryFieldFilter($condition);

    $where = QueryBuilder::makeQuery($condition, $this->_queryOptionRule);

    return $orm->where($where)->fetchRows();

  }

}
