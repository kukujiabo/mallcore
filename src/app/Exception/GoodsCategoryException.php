<?php
namespace App\Exception;

/**
 * 商品分类异常
 *
 * @author Meroc Chen<398515393@qq.com> 2018-01-16
 */
class GoodsCategoryException extends LogException {

  public function __construct($msg, $code) {
  
    parent::__construct($msg, $code, 'goods_category', '');
  
  }

}
