<?php
namespace App\Service\Commodity;

use App\Service\BaseService;
use Core\Service\CurdSv;

/**
 * 商品供应商进价
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class GoodsProviderCosSv extends BaseService {

  use CurdSv;

  /**
   * 新增供应商商品进价
   *
   * @param array data
   *
   * @return int id
   */
  public function addGoodsCos($data) {
  
    $price = array(
    
      'sku_id' => $data['sku_id'],
      'goods_id' => $data['goods_id'],
      'provider_id' => $data['provider_id'],
      'cost' => $data['cost'],
      'goods_name' => $data['goods_name'],
      'sku_name' => $data['sku_name'],
      'created_at' => date('Y-m-d H:i:s')
    
    );
  
    return self::add($price);
  
  }


}
