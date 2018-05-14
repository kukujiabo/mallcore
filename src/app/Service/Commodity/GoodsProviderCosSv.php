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

    $datas = array();

    $skus = json_decode($data['skus']);

    foreach($skus as $sku) {
    
      $skuPrice = array(

        'sku_id' => $sku['sku_id'],
        'goods_id' => $data['goods_id'],
        'cost' => $sku['price'],
        'sku_name' => $sku['sku_name'],
        'goods_name' => $sku['goods_name'],
        'created_at' => date('Y-m-d H:i:s'),
        'provider_id' => $data['provider_id']
        
      );

      array_push($datas, $skuPrice);
    
    }

    $goodPrice = array(
    
      'sku_id' => 0,
      'goods_id' => $data['goods_id'],
      'provider_id' => $data['provider_id'],
      'cost' => $data['cost'],
      'goods_name' => $data['goods_name'],
      'sku_name' => $data['sku_name'],
      'created_at' => date('Y-m-d H:i:s')
    
    );

    $datas[] = $goodPrice;
  
    return self::batchAdd($datas);
  
  }


}
