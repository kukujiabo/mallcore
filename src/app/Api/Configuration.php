<?php
namespace App\Api;

/**
 * 11.7 系统配置接口
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class Configuration extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
    
      'saveWxPubSv' => array(

        'token' => 'token|string|true||用户令牌',
      
        'wps_appid' => 'wps_appid|string|true||公众号appid',

        'wps_appsecret' => 'wps_appsecret|string|true||公众号appsecret',

        'wps_developing_token' => 'wps_developing_token|string|true||开发者自定义token',

        'wps_encodingaeskey' => 'wps_encodingaeskey|string|true||开发者加密密钥',
      
      ),

      'getWxPubSv' => array(
      
        'token' => 'token|string|true||用户令牌',

        'sub_module' => 'sub_module|string|true||配置所属子模块',
      
      )
    
    ));
  
  }

  /**
   * 保存微信公众号配置
   * @desc 保存微信公众号配置
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function saveWxPubSv() {
  
    $params = $this->retriveRuleParams(__FUNCTION__);

    return $this->dm->saveWxPubSv($params);
  
  }

  /**
   * 获取公众号配置
   * @desc 获取公众号配置
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function getWxPubSv() {
  
    $params = $this->retriveRuleParams(__FUNCTION__);

    return $this->dm->getWxPubSv($params);
  
  }


}
