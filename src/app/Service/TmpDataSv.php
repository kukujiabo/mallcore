<?php
namespace App\Service;

use Core\Service\CurdSv;
use App\Service\Commodity\GoodsBrandSv; use App\Service\Commodity\GoodsSv;
use App\Service\Commodity\GoodsSkuSv;
use App\Service\Commodity\GoodsAttributeSv;
use App\Service\Commodity\GoodsAttributeValueSv;
use App\Service\Takeaway\OrderTakeOutSv;

/**
 * 临时数据处理
 *
 *
 */
class TmpDataSv extends BaseService {

  use CurdSv;

  public function importBrand() {
  
    $goods = self::all([]);

    $brands = array();
  
    foreach($goods as $good) {

      if ($good['prop'] && !in_array($good['prop'], $brands)) {
    
        array_push($brands, $good['prop']);

      }
    
    }

    $newBrands = array();

    foreach($brands as $brand) {

      //$encodeBrand = iconv('GBK', 'UTF-8', $brand);

      $newBrand = array(

        'brand_name'  => $brand,

        'brand_code' => rand(10000000, 99999999),

        'brand_state' => 1,

        'created_at' => date('Y-m-d H:i:s'),

        'index_show' => 0
      
      );

      GoodsBrandSv::add($newBrand);
    
    }

  }

  public function importGoods() {
  
    $goods = self::all([]);

    $groupGoods = array();

    foreach($goods as $good) {
    
      if (!is_array($groupGoods[$good['name']])) {
      
        $groupGoods[$good['name']] = array();
      
      }

      array_push($groupGoods[$good['name']], $good);
    
    }

    foreach($groupGoods as $specGoods) {

      $goodOne = $specGoods[0];

      /**
       * 添加商品主数据
       */
      $brand = GoodsBrandSv::findOne(array('brand_name' => $goodOne['prop']));

      $newGood = array(

        'goods_id' => rand(100000000, 999999999),

        'goods_number' => rand(100000000, 999999999),
      
        'goods_name' => $goodOne['name'],

        'brand_id' => $brand['id'],

        'shop_id' => 0,

        'price' => $goodOne['price'],

        'state' => 1,

        'stock' => 99999,

        'is_sku' => 1,

        'index_show' => 0,

        'create_time' => date('Y-m-d H:i:s')
      
      );

      $gid = $newGood['goods_id'];

      GoodsSv::add($newGood);

      /**
       * 添加商品属性数据
       */
      $spec = array(

        'attr_id' => rand(100000000, 999999999),
      
        'goods_id' => $gid,

        'shop_id' => 0,

        'attr_value_id' => 0,

        'attr_value' => '选择规格',

        'active' => 1,

        'sort' => $key,
      
        'create_time' => date('Y-m-d H:i:s')

      );
      
      GoodsAttributeSv::add($spec);

      $specValues = array();

      $skus = array();

      foreach($specGoods as $key => $good) {
      
        $specValue = array(
        
          'attr_value_id' => rand(100000000, 999999999),

          'attr_id' => $spec['attr_id'],

          'attr_value' => $good['stand'],

          'is_visible' => $good['is_visible'],
          
          'active' => 1,

          'sort' => $key + 1,

          'create_time' => date('Y-m-d H:i:s'),

          'goods_id' => $gid
        
        );

        array_push($specValues, $specValue);

        $attrValueItemFormat = array(
        
          'attr_id' => $spec['attr_id'],

          'attr_val' => $specValue['attr_value_id'],

          'attrKey' => '选择规格',

          'attrValue' => $specValue['attr_value']
        
        );


        $sku = array(
        
          'sku_id' => rand(100000000, 999999999),

          'goods_id' => $gid,

          'sku_name' => $good['name'] . ' ' . $good['stand'],

          'price' => $good['price'],

          'attr_value_items_format' => json_encode(array($attrValueItemFormat)),

          'no_code' => $good['seq'],

          'stock' => 99999,

          'active' => 1,

          'create_date' => date('Y-m-d H:i:s')
        
        );

        array_push($skus, $sku);
      
        GoodsAttributeValueSv::add($specValue);

        GoodsSkuSv::add($sku);

      }

      /**
       * 添加商品属性值数据
       */

      /**
       * 添加商品sku数据
       */
    
    }
  
  }

  public function updateOrderAuditTime() {
  
    $tmpData = self::all(array());

    $i = 0;

    foreach($tmpData as $data) {
    
      $order = OrderTakeOutSv::findOne(array('sn' => $data['seq']));
    
      $result =  OrderTakeOutSv::update($order['id'], array('audit_time' => '2018-07-09'));

      $i += $result;
    
    }
  
    return $i; 
  
  }

}
