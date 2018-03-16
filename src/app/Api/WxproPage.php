<?php
namespace App\Api;

/** 
 * 25.1 微信小程序页面配置接口
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-07
 */
class WxproPage extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
    
      'getCrmPageConfigs' => array(
      
        'page_code' => 'page_code|string|false||页面编码'
      
      ),
    
      'getCrmPageBoundConfigs' => array(
      
        'page_code' => 'page_code|string|false||页面编码'
      
      ),

      'getPageList' => array(
      
        'token' => 'token|string|true||用户令牌',

        'mini_code' => 'mini_code|string|false||小程序编码',

        'page_name' => 'page_name|string|false||页面名称'

      ),

      'add' => array(
      
        'token' => 'token|string|true||用户令牌',

        'mini_code' => 'mini_code|string|true||小程序编码',

        'page_name' => 'page_name|string|true||页面名称',

        'page_code' => 'page_code|string|true||页面编码',

        'page_url' => 'page_url|string|true||页面路径',

        'module' => 'module|string|true||页面模块',

        'active' => 'active|int|true||有效状态'
      
      )

    ));
  
  }

  /**
   * 获取crm小程序页面配置
   * @desc 获取crm小程序页面配置
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function getCrmPageConfigs() {

    $data = $this->retriveRuleParams('getCrmPageConfigs');
  
    return $this->dm->getCrmPageConfigs($data);
  
  }

  /**
   * 获取crm小程序页面和页面配置
   * @desc 获取crm小程序页面和页面配置
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function getCrmPageBoundConfigs() {

    $data = $this->retriveRuleParams('getCrmPageBoundConfigs');
  
    return $this->dm->getCrmPageBoundConfigs($data);
  
  }

  /**
   * 获取页面列表
   * @desc 获取页面列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function getPageList() {
  
    return $this->dm->getPageList($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 添加小程序页面
   * @desc 添加小程序页面
   *
   * @return int ret 操作状态：200表示成功
   * @return int num 添加条数，通常为1
   * @return string msg 错误提示
   */
  public function add() {
  
    return $this->dm->add($this->retriveRuleParams(__FUNCTION__));
  
  }

}

