<?php
namespace App\Model;

/**
 * [模型层] 手机验证码
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-20
 */
class MobileVerifyCode extends BaseModel {

  /**
   * 根据code和手机号获取最后发送的条目
   *
   * @param string $code
   * @param string $mobile
   *
   * @return array $code
   */
  protected function getLastItemByCodeMobile($code, $mobile) {

    $condition = array('code' => $code, 'mobile' => $mobile, 'status' => 0);
  
    $code = self::queryList($condition, '*', 'id desc', 0, 1);

    return $code[0];
  
  }

  /**
   * 根据手机号获取最后发送的条目
   *
   * @param string $mobile
   *
   * @return array $code
   */
  protected function findLastByMobile($mobile) {
  
    $condition = array('mobile' => $mobile);

    $code = self::queryList($condition, '*', 'id desc', 0, 1);

    return $code[0];
  
  }

  /**
   * 设置验证码为已使用
   *
   * @param int $id
   *
   * @return boolean true/false
   */
  protected function setUsed($id) {
  
    return self::update($id, array('status' => 1));
  
  }

}
