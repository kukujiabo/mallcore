<?php
namespace App\Interfaces\Shop;

/**
 * 商铺订单关联操作接口
 *
 * @author Meroc Chen <398515393@qq.com> 2017-10-09
 */
class IShopOrder {

  /**
   * 新增店铺和订单的关联
   *
   * @param array $data
   *
   * @return string $id
   */
  public function add($data);

  /**
   * 查询列表
   *
   * @param array $condition
   * @param int $offset
   * @param int $limit
   *
   */
  public function queryList($condition, $offset = 0, $limit = 20);

}
