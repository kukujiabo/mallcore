<?php
namespace App\Api;

/**
 * 22.2 微信菜单操作Api
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-17
 */
class WechatMenu extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
    
      'create' => array(
      
        'token' => 'token|string|true||用户令牌',

        'menus' => 'menus|string|true||菜单数组'
      
      ),

      'getMenu' => array(
      
      )
    
    ));
  
  }

  /**
   * 创建微信公众号菜单
   * @desc 创建微信公众号菜单
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function create() {
  
    $params = $this->retriveRuleParams(__FUNCTION__);

    return $this->dm->create($params);
  
  }

  /**
   * 拉去微信公众号菜单信息
   * @desc 拉去微信公众号菜单信息
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function getMenu() {

    return $this->dm->getMenu();
  
  }

}
