<?php
namespace App\Service\Crm;

use Core\Service\CurdSv;
use App\Service\BaseService;
use App\Model\MobileVerifyCode;
use App\Exception\ErrorCode;
use App\Exception\MobileVerifyCodeException;

/**
 * 验证码管理服务 
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-01
 */
class MobileVerifyCodeSv extends BaseService {

  /**
   * 生成验证码
   *
   * @param string $mobile
   *
   * @return array $data
   */
  public function createCode($mobile) {
  
    $code = rand(100000, 999999);

    $last = MobileVerifyCode::findLastByMobile($mobile);

    $duration = time() - $last['send_at'];

    if ($last && $duration < 60) {
    
      /**
       * 验证短信发送间隔不超过60秒则抛出异常
       */
      throw new MobileVerifyCodeException($duration, ErrorCode::MobileVerifyCodeSv['VERIFY_CODE_DURATION_CODE']);
    
    }
  
    $data = array(
      'code' => $code,
      'mobile' => $mobile,
      'created_at' => date('Y-m-d H:i:s'),
      'send_at' => time(),
      'expire_at' => time() + 300,
      'status' => 0
    );

    MobileVerifyCode::add($data);

    return $code;

  }

  /**
   * 检查验证码
   *
   * @param string $code
   * @param string $mobile
   *
   * @return boolean true/false
   */
  public function checkVerifyCode($code, $mobile) {
  
    $verifyCode = MobileVerifyCode::getLastItemByCodeMobile($code, $mobile);

    if (!$verifyCode || $verifyCode['expire_at'] < time() || $verifyCode['status'] == 1) {

      throw new MobileVerifyCodeException(ErrorCode::MobileVerifyCodeSv['CODE_EXPIRE_MSG'], ErrorCode::MobileVerifyCodeSv['CODE_EXPIRE_CODE']);
    
    }

    return MobileVerifyCode::setUsed($verifyCode['id']);
  
  }


}
