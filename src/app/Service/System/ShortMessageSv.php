<?php
namespace App\Service\System;

use App\Service\BaseService;
use App\Interfaces\System\IShortMessage;
use App\Model\ShortMessage;
use App\Service\System\ConfigSv;
use Core\Service\CurdSv;
use PhalApi\Exception;

/**
 * 短信类
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-10
 */
class ShortMessageSv extends BaseService implements IShortMessage {

  use CurdSv;
  
  /**
   * 短信发送
   * @param int $data['type'] 类型 1-绑定手机 2-修改绑定手机 3-注册 4-修改密码 5-找回密码 6-短信验证登录
   * @param string $data['phone'] 手机号码
   * @return boolean 
   */
  public function send($data){

    $data['create_stamp'] = time();

    $data['created_at'] = date('Y-m-d H:i:s', $data['create_stamp']);

    $data['code'] = \App\getRandomDigit(6);

    // 调用发送短信



    try{

      self::add($data);

    } catch (\Exception $e){

      throw new Exception('新增失败', 5001);

    }

    return $data['code'];

  }

  /**
   * 短信验证
   * @param int $data['type'] 类型 1-绑定手机 2-修改绑定手机 3-注册 4-修改密码 5-找回密码 6-短信验证登录
   * @param string $data['phone'] 手机号码
   * @param string $data['code'] 短信验证码
   * @return boolean 
   */
  public function sendVerification($data){

    $data_short['status'] = 1;

    $data_short['type'] = $data['type'];

    $data_short['phone'] = $data['phone'];

    $list = ShortMessage::queryList($data_short, '*', 'create_stamp desc, id desc', '0', '1');

    $info = $list[0];

    // 短信有效时间（单位：秒）
    $code_valid_time = ConfigSv::getConfigValueByKey('code_valid_time');

    if (!$info || $data['code'] != $info['code'] || $info['create_stamp'] < (time() - $code_valid_time)) {

      throw new Exception('验证码错误', 5002);

    } else {

      $data_update['status'] = 2;

      self::update($info['id'], $data_update);

      return true;

    }

  }

}
