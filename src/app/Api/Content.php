<?php
namespace App\Api;

/**
 * 28.1 文本服务接口
 *
 * @author Meroc Chen <398515393@qq.com> 2018-01-07
 */
class Content extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
    
      'getMiniPageText' => array(
      
        'page_code'  => 'page_code|string|true||小程序页面编码',

        'attr_code'  => 'attr_code|string|true||属性页面编码',
      
      )
    
    ));
  
  }

  /**
   * 获取小程序页面配置文本接口
   * @desc 获取小程序页面配置文本接口
   *
   * @return text
   */
  public function getMiniPageText() {
  
    return $this->dm->getMiniPageText($this->retriveRuleParams(__FUNCTION__));
  
  }


}
