<?php
namespace App\Model;

/**
 * 商品价格体系模型
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class GoodsPriceMap extends BaseModel {

  protected $_queryOptionRule = array(

    'goods_name' => 'like',

    'sku_name' => 'like',

  );

}
