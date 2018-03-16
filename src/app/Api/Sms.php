<?php
namespace App\Api;

/**
 * 23.1 发送系统定义的短信
 *
 * @author: Meroc Chen <398515393@qq.com> 2017-12-01
 */
class Sms extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
      
      '*' => array(

        'mobile' => 'mobile|string|true||用户手机号',

        'content' => 'content|string|false||短信内容'
      
      ),
    
      'sendVerify' => array(


      ),

      'sendConsumptionNotice' => array(
      
      
      )
    
    ));
  
  }

  /**
   * 发送验证短信
   * @desc 发送验证短信接口
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function sendVerify() {

    $data = $this->retriveRuleParams('sendVerify');
  
    return $this->dm->sendVerify($data);
  
  }

  /**
   * 发送消费通知短信
   * @desc 发送消费通知短信接口
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function sendConsumptionNotice() {
  
    $data = $this->retriveRuleParams('sendConsumptionNotice');
  
    return $this->dm->sendConsumptionNotice($data);

  }

}
