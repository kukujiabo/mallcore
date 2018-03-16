<?php
namespace App\Interfaces;

/**
 * 服务增删改查基础接口
 *
 * @author Meroc Chen <398515393@qq.com> 2017-10-18
 */
interface ICURD {

  /**
   * 1.新增对象
   *
   * @param array $data
   *
   * @return string $id
   */
  public function add($data);

  /**
   * 2.批量新增对象
   *
   * @param array $dataSet
   *
   * @return string $id
   */
  public function batchAdd($dataSet);

  /**
   * 3.删除对象
   *
   * @param string $id
   *
   * @return boolean ture/false
   */
  public function remove($id);

  /**
   * 4.更新对象
   *
   * @param string $id
   * @param array $data
   *
   * @return boolean true/false
   */
  public function update($id, $data);

  /**
   * 5.批量更新对象
   *
   * @param array $condition
   * @param array $data
   *
   * @return int num
   */
  public function batchUpdate($condition, $data);

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
  public function queryList($condition, $fields, $order, $offset, $limit);

  /**
   * 7.根据primary key或unique key查询一条记录
   *
   * @param string/array $id
   *
   * @return mixed object
   */
  public function findOne($id);

  /**
   * 8.根据条件查询数量
   *
   * @param array $condition
   *
   * @return int num
   */
  public function queryCount($condition);

}
