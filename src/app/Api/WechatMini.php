<?php
namespace App\Api;

/**
 * 25.3 微信小程序配置
 *
 * @author: Meroc Chen <398515393@qq.com> 2017-12-28
 */
class WechatMini extends BaseApi {

  public function getRules() {

    return $this->rules(array(
    
      'add' => array(

        'token' => 'token|string|true||用户令牌',
      
        'mini_name' => 'mini_name|string|true||小程序名称',

        'mini_code' => 'mini_code|string|true||小程序编码',

        'mini_appid' => 'mini_appid|string|true||小程序appid',

        'mini_secret' => 'mini_secret|string|true||小程序密钥',

        'icon' => 'icon|string|true||小程序图标',

        'remark' => 'remark|string|false||小程序说明'
      
      ),

      'queryList' => array(
      
        'token' => 'token|string|true||用户令牌',

        'mini_name' => 'mini_name|string|false||小程序名称',

        'mini_code' => 'mini_code|string|false||小程序编码',

        'mini_appid' => 'mini_appid|string|false||小程序appid',

        'page' => 'page|int|true|1|页码',

        'pageSize' => 'pageSize|int|true|30|每页条数'
      
      ),

    ));
  
  }

  /**
   * 添加小程序
   * @desc 添加小程序
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function add() {
  
    return $this->dm->add($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 查询小程序列表
   * @desc 查询小程序列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function queryList() {
  
    return $this->dm->queryList($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 更新小程序配置
   * @desc 更新小程序配置
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function update() {
  
    return $this->dm->update($this->retriveRuleParams(__FUNCTION__));
  
  }

}
