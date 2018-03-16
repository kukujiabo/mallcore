<?php
namespace App\Api;

/**
 * 22.4 微信模版消息接口服务
 *
 * @author: Meroc Chen <398515393@qq.com> 2018-01-04
 */
class Wechat extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
      
      'wechatMessagePush' => array(

        'signature' => 'signature|string|false||微信加密签名',

        'timestamp' => 'timestamp|string|false||时间戳',

        'nonce' => 'nonce|string|false||随机数',

        'echostr' => 'echostr|string|false||随机字符串',

        'openid' => 'openid|string|false||openid',

        'encrypt_type' => 'encrypt_type|string|false||加密类型',

        'msg_signature' => 'msg_signature|string|false||签名参数',
                                                                 
       ),
    
    ));
  
  }

  /**
   * 微信公众号URL验证
   * @desc 微信公众号URL验证
   *
   * @return int ret 操作状态：200表示成功
   * @return boolean data 
   * @return string msg 错误提示
   */
  public function wechatMessagePush() {

    $params = $this->retriveRuleParams('wechatMessagePush');

    return $this->dm->wechatMessagePush($params);

  }


}
