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

        'sku_id'  => 'sku_id|int|true||skuId',

        'user_level'  => 'user_level|int|true||用户等级',

        'price'  => 'price|float|true||价格',

        'city_code'  => 'city_code|int|true||城市编码',

        'priority'  => 'priority|int|true||优先级',

      
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
