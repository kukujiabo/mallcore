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

        'city_code'  => 'city_code|int|true||城市编码',

        'price' => 'price|float|true||价格',

        'skus' => 'skus|string|true||sku'
      
      ),

      'updateRule' => array(
      
      
      ),

      'getRules' => array(
      
      
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


}
