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

    $condition = array(
    
      'goods_id' => $params['goods_id'],

      'city_code' => $params['city_code'],

      'user_level' => $params['user_level']
    
    );

    self::batchRemove($condition);

    foreach($skus as $sku) {
    
      $newPrice = array(
      
        'goods_id' => $params['goods_id'],

        'goods_name' => iconv("UTF-8", "GBK", $params['goods_name']),

        'user_level' => $params['user_level'],

        'city_code' => $params['city_code'],

        'sku_id' => $sku['sku_id'],

        'sku_name' => iconv("UTF-8", "GBK", $sku['sku_name']),

        'level_name' => iconv("UTF-8", "GBK", $params['level_name']),
      
        'city_name' => iconv("UTF-8", "GBK", $params['city_name']),

        'price' => floatval($sku['price']),

        'created_at' => date('Y-m-d H:i:s')

      );

      array_push($dataSet, $newPrice);
    
    }

    $good = array(
    
      'goods_id' => $params['goods_id'],

      'user_level' => $params['user_level'],

      'goods_name' => iconv("UTF-8", "GBK", $params['goods_name']),

      'city_code' => $params['city_code'],

      'sku_name' => '',

      'sku_id' => 0,

      'price' => $params['price'],

      'created_at' => date('Y-m-d H:i:s'),

      'level_name' => iconv("UTF-8", "GBK", $params['level_name']),
      
      'city_name' => iconv("UTF-8", "GBK", $params['city_name'])
    
    );

    $dataSet[] = $good;

    return self::batchAdd($dataSet);
  
  }

  public function getList($params) {

    $query = array();

    $params['goods_name'] ? $query['goods_name'] = $params['goods_name'] : '';
    
    $params['sku_name'] ? $query['sku_name'] = $params['sku_name'] : '';
  
    return self::queryList($query, '*', 'created_at desc', $params['page'], $params['page_size']);
  
  }


}
