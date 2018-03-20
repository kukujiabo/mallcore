<?php
namespace App\Service\Commodity;

use App\Service\BaseService;
use App\Interfaces\Commodity\IGoodsSku;
use App\Model\GoodsSku;
use Core\Service\CurdSv;
use PhalApi\Exception;

/**
 * sku商品
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-12-27
 */
class GoodsSkuSv extends BaseService implements IGoodsSku {

    use CurdSv;

    public function getAll($condition) {
    
      $skus = self::all($condition);

      foreach($skus as $key => $sku) {
      
        $priceRule = GoodsPriceMapSv::findOne(array(
        
          'sku_id' => $sku['sku_id'],

          'city_code' => $condition['city_code'],

          'user_level' => $condition['user_level']
        
        ));

        if ($priceRule) {
        
          $skus[$key]['price'] = $priceRule['price'];
        
        }
      
      }

      return $skus;

    
    
    }

    /**
     * 获取列表
     */
    public function getList($condition) {

      $skus = self::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);

      foreach($skus['list'] as $key => $sku) {
      
        $priceRule = GoodsPriceMapSv::findOne(array(
        
          'sku_id' => $sku['sku_id'],

          'city_code' => $condition['city_code'],

          'user_level' => $condition['user_level']
        
        ));

        if ($priceRule) {
        
          $skus['list'][$key]['price'] = $priceRule['price'];
        
        }
      
      }

      return $skus;

    }

    /**
     * 获取详情
     */
    public function getDetail($condition) {

      $sku = self::findOne($condition);

      $priceRule = GoodsPriceMapSv::findOne(array(
      
        'sku_id' => $sku['sku_id'],

        'city_code' => $condition['city_code'],

        'user_level' => $condition['user_level']
      
      ));

      if ($priceRule) {
      
        $sku['price'] = $priceRule['price'];
      
      }

      return $sku;

    }

    /**
     * 新增
     */
    public function addGoodsSku($data) {

        $data['create_date'] = date("Y-m-d H:i:s");

        self::add($data);

        return $data['sku_id'];

    }

    /**
     * 编辑
     */
    public function edit($data) {

        $condition['sku_id'] = $data['sku_id'];

        unset($data['sku_id']);

        return self::batchUpdate($condition, $data);

    }

    /**
     * 验证
     */
    public function verifyGoods($data) {

        $condition['sku_id'] = $data['sku_id'];

        $condition['goods_id'] = $data['goods_id'];

        $info_sku = self::findOne($condition);

        if (!$info_sku) {

            throw new Exception('sku_id 错误，查不到sku商品数据', 850501);
            
        }

        if ($info_sku['active'] == 2) {

            throw new Exception('sku商品'. $info_sku['sku_name'] .'已下架', 850502);

        }

        if ($data['quantity'] > $info_sku['stock']) {

            throw new Exception('sku商品' . $info_sku['sku_name'] . '库存不足', 850503);

        }

        return $info_sku;

    }

}
