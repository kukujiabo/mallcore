<?php 
namespace App\Api;

/**
 * 20.1 用户充值接口
 * 
 * @author: Meroc Chen <398515393@qq.com> 2017-11-27
 */
class MemberRecharge extends BaseApi {

  /**
   * 配置接口参数规则
   */
  public function getRules() {

    return $this->rules(array(

      'miniRecharge' => array(

        'token' => 'token|string|true||用户token',

        'money' => 'money|float|true||充值金额',
      
        'device_info' => 'device_info|string|false||设备信息',

        'rule_id' => 'rule_id|int|false|0|规则id'
      
      )

    ));

  }

  /**
   * 小程序用户充值接口
   * @desc 小程序用户充值接口
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return array data.timeStamp 当前的时间戳
   * @return array data.nonceStr 随机字符串，长度为32个字符以下
   * @return array data.package 统一下单接口返回的prepay_id参数值，提交格式如：prepay_id=*
   * @return array data.signType 签名算法，暂支持 MD5
   * @return array data.paySign 签名
   * @return string msg 错误提示
   */
  public function miniRecharge() {

    $data = $this->retriveRuleParams('miniRecharge');

    $regulation = array();

    \App\Verification($data, $regulation);

    /**
     * 配置支付类型为小程序支付
     */
    $data['pay_type'] = 2;
  
    return $this->dm->miniRecharge($data);
  
  }

}
