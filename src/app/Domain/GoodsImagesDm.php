<?php

namespace App\Domain;

use App\Service\Commodity\GoodsImagesSv;

/**
 * 商品属性接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-12-27
 */
class GoodsImagesDm {

  /**
   * 获取全部
   */
  public function getAll($data) {

    return GoodsImagesSv::all($data, 'sort asc');
  
  }

}
