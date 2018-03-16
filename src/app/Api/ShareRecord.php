<?php
namespace App\Api;

use App\Api\BaseApi;

/**
 * 19.1 分享记录
 *
 * @author Meroc Chen <398515393@qq.com> 2017-11-20
 */
class ShareRecord extends BaseApi {

  /**
   * 配置路由规则
   */
  public function getRules() {
  
    return $this->rules(array(
    
      'add' => array(
      
        'shareTicket' => 'shareTicket|String|false||微信shareTicket',

        'sessionKey' => 'sessionKey|String|false||微信sessionKey',

        'encodeData' => 'encodeData|String|false||微信分享加密信息',

        'iv' => 'iv|String|false||解密秘钥',

        'module' => 'module|String|false||分享类型',

        'remark' => 'remark|String|false||分享备注',

        'token' => 'token|String|true||用户token',

        'share_code' => 'share_code|string|true||分享码（唯一）',
      
      )
    
    ));
  }

  /**
   * 新增分享记录
   * @desc 新增分享记录接口
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 参数集
   * @return array data.Status 1:操作成功;-1:操作出错
   * @return array data.Description 错误信息
   * @return string msg 错误提示
   */
  public function add() {

    $regulation = array(

      'token' => 'required',

      'share_code' => 'required',

    );
  
    $params = $this->retriveRuleParams('add');

    \App\Verification($params, $regulation);

    return $this->dm->add($params);
  
  }


}
