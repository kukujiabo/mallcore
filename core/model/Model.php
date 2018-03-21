<?php
namespace Core\Model;

/**
 * model 基础类
 *
 * @author Meroc Chen <398515393@qq.com> 2017-10-11
 */
class Model {

  /**
   * model实例
   */
  protected static $_instance;

  /**
   * 表主键
   */
  protected $_primaryKey = 'id';

  /**
   * 表名
   */
  protected $_table;

  /**
   * 允许修改的字段名
   */
  protected $_editableFields = array();

  /**
   * 默认可读字段
   */
  protected $_readableFields = array();

  /**
   * 查询字段
   */
  protected $_queryFields = array();

  /**
   * 查询规则
   */
  protected $_queryOptionRule = array();

  /**
   * 更新规则
   */
  protected $_updateOptionRule = array();

  /**
   * 构造函数
   */
  public function __construct() {

    if (!isset($this->_table)) {

      $this->reflectTable();

    }

    if (empty($this->_editableFields)) {

      $this->getOperationFields();

    }

    if (empty($this->_readableFields)) {
    
      $this->_readableFields = $this->_editableFields;
    
    }

    if (empty($this->_queryFields)) {
    
      $this->_queryFields = $this->_editableFields;
    
    }

  }

  /**
   * 根据model类名映射表明，并获取orm实例
   */
  protected function reflectTable() {

    $self = get_called_class();

    $class = explode('\\', $self);

    $className = $class[count($class) - 1];

    $this->_table = $this->cc_format($className);
  
  }

  /**
   * 获取orm实例
   */
  public function orm() {

    $tableName = $this->_table;
  
    return \PhalApi\DI()->notorm->$tableName;

  }

  /**
   * 映射表字段
   */
  protected function getOperationFields() {
  
    $rows = $this->orm()->queryAll("sp_columns {$this->_table}", array());

    foreach($rows as $row) {

      array_push($this->_editableFields, $row['COLUMN_NAME']);

    }

    return array();

  }

  /**
   * 静态重载
   */
  public static function __callStatic($method, $arguments) {

    $self = get_called_class();

    if (!$self::$_instance || !($self::$_instance instanceof $self)) {
    
      $self::$_instance = new $self();
    
    }

    return call_user_func_array([$self::$_instance, $method], $arguments);

  }

  /**
   * 驼峰命名转下划线命名
   */
  private function cc_format($name) {
  
    $temp_array = array();

    for($i=0;$i<strlen($name);$i++){

      $ascii_code = ord($name[$i]);

      if($ascii_code >= 65 && $ascii_code <= 90){

        if($i == 0){

          $temp_array[] = chr($ascii_code + 32);

        }else{

          $temp_array[] = '_'.chr($ascii_code + 32);

        }

      }else{

        $temp_array[] = $name[$i];

      }

    }

    return implode('',$temp_array);

  }

}
