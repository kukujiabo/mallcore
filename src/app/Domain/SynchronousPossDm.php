<?php
namespace App\Domain;

use App\Service\Poss\SynchronousPossSv;

/**
 * 同步POSS数据
 * 
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-18
 */
class SynchronousPossDm {

  /**
   * 同步POSS商品
   */
  public function SynchronousGoods($data) {

    return SynchronousPossSv::SynchronousGoods($data);
  
  }

}
