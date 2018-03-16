<?php
namespace Core\Service;

trait CurdSv {

  /**
   * 1.新增对象
   *
   * @param array $data
   *
   * @return string $id
   */
  public function add($data) {

    $className = get_class();

    $modelName = explode('\\', substr($className, 0, strlen($className) - 2));

    $model = "App\\Model\\{$modelName[count($modelName) - 1]}";

    return $model::add($data);
  
  }

  /**
   * 2.批量新增对象
   *
   * @param array $dataSet
   *
   * @return string $id
   */
  public function batchAdd($dataSet) {
  
    $className = get_class();

    $modelName = explode('\\', substr($className, 0, strlen($className) - 2));

    $model = "App\\Model\\{$modelName[count($modelName) - 1]}";

    return $model::batchAdd($dataSet);
    
  }

  /**
   * 3.删除对象
   *
   * @param string $id
   *
   * @return boolean ture/false
   */
  public function remove($id, $soft = true) {
  
    $className = get_class();

    $modelName = explode('\\', substr($className, 0, strlen($className) - 2));

    $model = "App\\Model\\{$modelName[count($modelName) - 1]}";

    return $model::remove($id, $soft);
  
  }

  /**
   * 4.更新对象
   *
   * @param string $id
   * @param array $data
   *
   * @return boolean true/false
   */
  public function update($id, $data) {
  
    $className = get_class();

    $modelName = explode('\\', substr($className, 0, strlen($className) - 2));

    $model = "App\\Model\\{$modelName[count($modelName) - 1]}";

    return $model::update($id, $data);
  
  }

  /**
   * 5.批量更新对象
   *
   * @param array $condition
   * @param array $data
   *
   * @return int num
   */
  public function batchUpdate($condition, $data) {
  
    $className = get_class();

    $modelName = explode('\\', substr($className, 0, strlen($className) - 2));

    $model = "App\\Model\\{$modelName[count($modelName) - 1]}";

    return $model::batchUpdate($condition, $data);
  
  }

  /**
   * 6.查询列表
   *
   * @param array $condition
   * @param string $fields
   * @param string $order
   * @param int $offset
   * @param int $limit
   *
   * @return array $list
   */
  public function queryList($condition, $fields, $order, $page, $pageSize) { 
    
    $className = get_class();

    $modelName = explode('\\', substr($className, 0, strlen($className) - 2));

    $model = "App\\Model\\{$modelName[count($modelName) - 1]}";

    $totalCount = $model::number($condition);

    $queryResult = '';

    $queryPage = 1;

    if ($totalCount > 0) {

      $querySize = (INT)($pageSize < 1 ? 20 : ( $pageSize > $totalCount ? $totalCount : $pageSize));

      $pageNum = ceil($totalCount/$querySize);

      $queryPage = (INT)($page > $pageNum ? $pageNum : ($page < 1 ? 1 : $page));

      $offset = ($queryPage - 1) * (INT)$querySize;

      $queryResult = $model::queryList($condition, $fields, $order, $offset, $querySize);

    }

    $response = array(
      
      'list' => $queryResult,

      'total' => $totalCount,

      'page' => $queryPage
    
    );
  
    return $response;
  
  }

  /**
   * 7.根据primary key或unique key查询一条记录
   *
   * @param string/array $id
   *
   * @return mixed object
   */
  public function findOne($id) {
  
    $className = get_class();

    $modelName = explode('\\', substr($className, 0, strlen($className) - 2));

    $model = "App\\Model\\{$modelName[count($modelName) - 1]}";
  
    return $model::findOne($id);
  
  }

  /**
   * 8.根据条件查询数量
   *
   * @param array $condition
   *
   * @return int num
   */
  public function queryCount($condition) {
  
    $className = get_class();

    $modelName = explode('\\', substr($className, 0, strlen($className) - 2));

    $model = "App\\Model\\{$modelName[count($modelName) - 1]}";

    return $model::number($condition);
  
  }

  /**
   * 9.批量删除对象
   *
   * @param array $condition
   *
   * @return boolean ture/false
   */
  public function batchRemove($condition, $soft = true) {
  
    $className = get_class();

    $modelName = explode('\\', substr($className, 0, strlen($className) - 2));

    $model = "App\\Model\\{$modelName[count($modelName) - 1]}";

    return $model::batchRemove($condition, $soft);
  
  }

  /**
   * 10.返回所有符合条件的数据
   *
   * @param array $condition
   *
   * @return array $data
   */
  public function all($condition, $order = '') {

    $className = get_class();
  
    $modelName = explode('\\', substr($className, 0, strlen($className) - 2));

    $model = "App\\Model\\{$modelName[count($modelName) - 1]}";

    return $model::all($condition, $order);

  }

  /**
   * 11.批量删除接口
   *
   * @param array $condition
   *
   * @return int $num
   */
  /*
  public function batchRemove($condition) {
  
    $className = get_class();
  
    $modelName = explode('\\', substr($className, 0, strlen($className) - 2));

    $model = "App\\Model\\{$modelName[count($modelName) - 1]}";

    return $model::batchRemove($condition, false);
  
  }
   */

}
