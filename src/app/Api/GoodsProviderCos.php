<?php
namespace App\Api;

/**
 * 供应商商品进价接口
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class GoodsProviderCos extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
    
      'addGoodsCos' => array(
      
        'goods_id' => 'goods_id|int|true||商品id',
        'provider_id' => 'provider_id|int|true||供应商id',
        'cost' => 'cost|float|true||商品进价',
        'goods_name' => 'goods_name|string|true||商品名称',
        'skus' => 'skus|string|true||商品规格'
      
      ),

      'getList' => array(
      
        'goods_name' => 'goods_name|string|false||商品名称',
        'sku_name' => 'sku_name|string|false||商品规格名称',
        'provider_id' => 'provider_id|int|false||供应商id',
        'page' => 'page|int|false|1||页码',
        'page_size' => 'page_size|int|false|2||每页条数',
      
      )
    
    ));
  
  }

  /**
   * 新增供应商进价
   * @desc 新增供应商进价
   *
   * @return int id
   */
  public function addGoodsCos() {
  
    return $this->dm->addGoodsCos($this->retriveRuleParams(__FUNCTION__)); 
  
  }

  /**
   * 获取进价列表
   * @desc 获取进价列表
   *
   * @return array list
   */
  public function getList() {
  
    return $this->dm->getList($this->retriveRuleParams(__FUNCTION__));
  
  }


}
