<?php
namespace App\Interfaces\TableOrder;

/**
 * 餐桌使用记录管理表
 *
 * @author Meroc Chen <398515393@qq.com> 2017-10-01
 */
interface IOrderTableLog {

  /**
   * 新增使用记录
   *
   * @param array $data
   *
   * @return int $id
   */
  public function add($data);


}
