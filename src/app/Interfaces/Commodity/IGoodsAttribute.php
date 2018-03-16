<?php
namespace App\Interfaces\Commodity;

use App\Interfaces\ICURD;

/**
 * 商品属性管理接口
 *
 * @author Meroc Chen <398515393@qq.com> 2017-09-30
 */
interface IGoodsAttribute extends ICURD {

  /**
   * 检验属性唯一编码是否存在
   *
   * @return boolean true/false
   */
  public function existAttrUniKey($key);

  /**
   * 生成属性唯一编码
   *
   * @return string $key
   */
  public function createAttrUniKey();

}
