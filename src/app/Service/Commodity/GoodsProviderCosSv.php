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

    $skus = json_decode($data['skus'], true);

    foreach($skus as $sku) {
    
      $skuPrice = array(

        'sku_id' => $sku['sku_id'],
        'goods_id' => $data['goods_id'],
        'cost' => $sku['price'],
        'sku_name' => $sku['sku_name'],
        'goods_name' => $data['goods_name'],
        'provider_id' => $data['provider_id'],
        'sale_price' => $sku['price'],
        'created_at' => date('Y-m-d H:i:s')
        
      );

      array_push($datas, $skuPrice);
    
    }

    $goodPrice = array(
    
      'sku_id' => 0,
      'goods_id' => $data['goods_id'],
      'cost' => $data['cost'],
      'sku_name' => $data['goods_name'],
      'goods_name' => $data['goods_name'],
      'provider_id' => $data['provider_id'],
      'sale_price' => $data['price'],
      'created_at' => date('Y-m-d H:i:s')
    
    );

    $datas[] = $goodPrice;
  
    return self::batchAdd($datas);
  
  }

  /**
   * 商品列表
   *
   * @param array list
   *
   * @return array data
   */
  public function getList($params) {
  
    $query = array();

    $params['goods_name'] ? $query['goods_name'] = $params['goods_name'] : '';
    
    $params['sku_name'] ? $query['sku_name'] = $params['sku_name'] : '';

    $query['provider_id'] = $params['provider_id'];
  
    return self::queryList($query, '*', 'created_at desc', $params['page'], $params['page_size']);
  
  }

  /**
   * 获取供应商价格详情
   *
   * @param array data
   *
   * @return 
   */
  public function getDetail($data) {
  
    return self::findOne($data['id']); 
  
  }

  /**
   * 更新价格
   *
   * @param int 
   *
   * @return int num
   */
  public function updateCos($data) {
  
    $id = $data['id'];

    unset($data['id']);
  
    return self::update($id, $data);

  }

}
