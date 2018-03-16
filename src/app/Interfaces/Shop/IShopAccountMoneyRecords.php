<?php
namespace App\Interfaces\Shop;

/**
 * 店铺入账总额记录操作接口
 *
 * @author Meroc Chen <398515393@qq.com> 2017-10-11
 */
interface IShopAccountMoneyRecords {

  /**
   * 新增记录
   *
   * @param array $data
   *
   * @return string $id
   */
  public function add($data);

}
