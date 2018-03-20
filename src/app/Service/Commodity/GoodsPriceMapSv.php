<?php
namespace App\Service\Commodity;

use App\Service\BaseService;
use Core\Service\CurdSv;

/**
 * 价格体系服务
 * @desc 价格体系服务
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class GoodsPriceMapSv extends BaseService {

  use CurdSv;

  /**
   * 添加体系规则
   *
   */
  public function addRule($params) {
  
    $params['created_at'] = date('Y-m-d H:i:s');

    $skus = json_decode($params['skus'], true);

    $dataSet = array();

    foreach($skus as $sku) {
    
      $newPrice = array(
      
        'goods_id' => $params['goods_id'],

        'user_level' => $params['user_level'],

        'city_code' => $params['city_code'],

        'sku_id' => $sku['sku_id'],

        'price' => $sku['price'],

        'created_at' => date('Y-m-d H:i:s')
      
      );

      array_push($dataSet, $newPrice);
    
    }

    $good = array(
    
      'goods_id' => $params['goods_id'],

      'user_level' => $params['user_level'],

      'city_code' => $params['city_code'],

      'sku_id' => 0,

      'price' => $params['price'],

      'created_at' => date('Y-m-d H:i:s')
    
    );

    $dataSet[] = $good;

    return self::batchAdd($dataSet);
  
  }


}
