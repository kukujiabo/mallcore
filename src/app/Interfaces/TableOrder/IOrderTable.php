<?php
namespace App\Interfaces\TableOrder;

/**
 * 餐桌管理接口
 *
 * @author Meroc Chen <398515393@qq.com> 2017-10-01
 */
interface IOrderTable {

  /**
   * 新增餐桌
   *
   * @param array $data
   *
   * @return int $id
   */
  public function add($data);

  /**
   * 修改餐桌信息
   *
   * @param int $id
   * @param array $data
   *
   * @return boolean true/false
   */
  public function update($id, $data);

  /**
   * 移除餐桌
   *
   * @param int $id
   *
   * @return boolean true/false
   */
  public function remove($id);

  /**
   * 查询餐桌列表
   *
   * @param array $condition
   * @param int $offset
   * @param int $limit
   *
   * @return array $list
   */
  public function queryList($condition, $offset = 0, $limit = 20);


}
