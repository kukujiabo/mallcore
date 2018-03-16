<?php
namespace App\Api;

/**
 * 25.2 微信小程序页面配置接口
 *
 * @author: Meroc Chen <398515393@qq.com> 2017-12-07
 */
class WxproPageConfig extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
    
      'updatePageConfigs' => array(
      
        'id' => 'id|int|true||配置项目id',

        'content' => 'content|string|false||修改值',

        'type' => 'type|int|true||值类型'
      
      ),
    
    ));
  
  }

  /**
   * 更新小程序页面配置信息 
   * @desc 更新小程序页面配置信息
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function updatePageConfigs() {

    $data = $this->retriveRuleParams('updatePageConfigs');
  
    return $this->dm->updatePageConfigs($data);
  
  }

}
