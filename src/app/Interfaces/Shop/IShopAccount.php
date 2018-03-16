<?php
namespace App\Interfaces\Shop;

/**
 * 店铺账户接口
 *
 * @author Meroc Chen <398515393@qq.com> 2017-10-09
 */
interface IShopAccount {

  /**
   * 新增账户
   *
   * @param array $data
   *
   * @return string $id
   */
  public function add($data);

  /**
   * 更新账户信息
   *
   * @param string $id
   * @param array $data
   *
   * @return boolean true/false
   */
  public function update($id, $data);

}
