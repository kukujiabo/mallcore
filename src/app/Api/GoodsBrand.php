<?php
namespace App\Api;

/**
 * 8.7 商品品牌接口
 *
 * @author: Meroc Chen <398515393@qq.com> 2018-02-26
 */
class GoodsBrand extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
    
      'addBrand' => array(

        'brand_avatar' => 'brand_avatar|string|true||品牌缩略图',
        'brand_code' => 'brand_code|string|true||品牌编码',
        'brand_name' => 'brand_name|string|true||品牌名称',
        'introduction' => 'introduction|string|false||品牌介绍',
        'brand_state' => 'brand_state|int|false|1|品牌状态'
      
      ),

      'updateBrand' => array(
      
        'id' => 'id|int|true||品牌id',
        'brand_avatar' => 'brand_avatar|string|true||品牌缩略图',
        'brand_name' => 'brand_name|string|false||品牌名称',
        'introduction' => 'introduction|string|false||品牌介绍',
        'index_show' => 'index_show|int|false||是否首页展示',
        'brand_state' => 'brand_state|int|false||品牌状态'
      
      ),

      'listQuery' => array(
      
        'brand_name' => 'brand_name|string|false||品牌名称',
        'brand_code' => 'brand_code|string|false||品牌编码',
        'index_show' => 'index_show|int|false||是否在首页展示',
        'brand_state' => 'brand_state|int|false||品牌状态',
        'all' => 'all|int|false|0|是否',
        'page' => 'page|int|false|1|页码',
        'page_size' => 'page_size|int|false|20|每页数据条数'
      
      ),

      'getDetail' => array(
      
        'id' => 'id|int|true||商品品牌id'
      
      ),

      'removeBrand' => array(
      
        'id' => 'id|int|true||品牌id'
      
      )
    
    ));
  
  }

  /**
   * 添加品牌
   * @desc 添加品牌
   *
   * @return int id
   */
  public function addBrand() {
  
    return $this->dm->addBrand($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 更新品牌
   * @desc 更新品牌
   *
   * @return int num
   */
  public function updateBrand() {
  
    return $this->dm->updateBrand($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 查询品牌列表数据
   * @desc  查询品牌列表数据
   *
   * @return array data
   */
  public function listQuery() {

    return $this->dm->listQuery($this->retriveRuleParams(__FUNCTION__));

  }

  /**
   * 删除品牌
   * @desc 删除品牌
   *
   * @return boolean true/false
   */
  public function removeBrand() {
  
    return $this->dm->removeBrand($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 品牌详情
   * @desc 品牌详情
   *
   * @return
   */
  public function getDetail() {
  
    return $this->dm->getDetail($this->retriveRuleParams(__FUNCTION__));
  
  }

}
