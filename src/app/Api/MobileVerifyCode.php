<?php
namespace App\Api;

/**
 * 24.1 手机验证码接口
 *
 * @author: Meroc Chen <398515393@qq.com> 2017-12-01
 */
class MobileVerifyCode extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
    
      'checkCode' => array(
      
        'code' => 'code|string|true||验证码',

        'mobile' => 'mobile|string|true||手机号'
      
      )
    
    ));
  
  }

  /**
   * 检查验证码
   *
   */
  public function checkCode() {
  
    $data = $this->retriveRuleParams('checkCode');

    return $this->dm->checkCode($data);
  
  }


}
