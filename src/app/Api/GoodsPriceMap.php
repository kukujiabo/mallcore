<?php
namespace App\Api;

/**
 * 价格体系接口
 *
 * @author Meroc Chen <398515393@qq.com> 
 */
class GoodsPriceMap extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
    
      'addRule' => array(
      
        'goods_id'  => 'goods_id|int|true||商品id',

        'goods_name' => 'goods_name|string|true||商品名称',

        'user_level'  => 'user_level|int|true||用户等级',

        'level_name'  => 'level_name|string|true||等级名称',

        'city_code'  => 'city_code|int|true||城市编码',

        'city_name' => 'city_name|string|true||城市名称',

        'price' => 'price|float|true||价格',

        'tax_off_price' => 'tax_off_price|float|false||含税价格',

        'skus' => 'skus|string|true||sku'
      
      ),

      'getList' => array(
      
        'goods_name' => 'goods_name|string|false||商品名称',

        'goods_id' => 'goods_id|int|false||商品id',

        'sku_name' => 'sku_name|string|false||sku名称',

        'city_code' => 'city_code|string|false||城市代码',

        'page' => 'page|int|false|1|页码',

        'page_size' => 'page_size|int|false|20|每页条数'
      
      ),

      'edit' => array(
      
        'id' => 'id|int|true||价格id',

        'price' => 'price|float|false||价格',

        'tax_off_price' => 'tax_off_price|float|false||含税价格'
      
      ),

      'batchEdit' => array(
      
        'data' => 'data|string|true||批量编辑数据'
      
      ),

      'remove' => array(
      
        'id' => 'id|int|true||删除价格'
      
      ),

      'exportExcel' => array(
      
        'city_code' => 'city_code|string|true||城市编码',

        'goods_id' => 'goods_id|string|true||商品编码',
      
      ),

      'importData' => array(

        'city_code' => 'city_code|string|true||城市编码',

        'file_path' => 'file_path|string|true||文件路径',

        'orig_name' => 'orig_name|string|true||文件原始名称'

      ),

      'syncSkuPriceByGoodsId' => array(
      
        'goods_id' => 'goods_id|int|true||商品id'
      
      )
    
    ));
  
  }

  /**
   * 添加规则
   * @desc 添加规则
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 参数集
   * @return array data.Status 1:操作成功;-1:操作出错
   * @return array data.Description 错误信息
   * @return string msg 错误提示
   */
  public function addRule() {
  
    return $this->dm->addRule($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 获取列表
   * @desc 获取列表
   *
   * @return int
   */
  public function getList() {
  
    return $this->dm->getList($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 编辑价格接口
   * @desc 编辑价格接口
   *
   * @return int num
   */
  public function edit() {
  
    return $this->dm->edit($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 批量编辑接口
   * @desc 批量编辑接口
   *
   * @return int num
   */
  public function batchEdit() {
  
    return $this->dm->batchEdit($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 删除价格接口
   * @desc 删除价格接口
   *
   * @return int num
   */
  public function remove() {
  
    return $this->dm->remove($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 导出excel
   * @desc 导出excel
   *
   * @return 
   */
  public function exportExcel() {
  
    return $this->dm->exportExcel($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 导入数据
   * @desc 导入数据
   *
   * @return 
   */
  public function importData() {

    return $this->dm->importData($this->retriveRuleParams(__FUNCTION__));

  }

  /**
   * 同步SKU区域价格数据
   * @desc 同步SKU区域价格数据
   *
   * @return
   */
  public function syncSkuPriceByGoodsId() {

    return $this->dm->syncSkuPriceByGoodsId($this->retriveRuleParams(__FUNCTION__));
  
  }

}
