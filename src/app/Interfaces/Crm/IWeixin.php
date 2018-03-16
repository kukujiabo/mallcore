<?php
namespace App\Interfaces\Crm;

interface IWeixin {

  /**
   * 获取access_token.
   */
  public function getAccessToken($appid, $appSecret, $client_credential = 'access_token');

  /**
   * 获取微信用户信息
   */
  public function getWxUserInfo($accessToken, $openid, $lang = 'zh_CN');

  /**
   * 获取微信关注用户列表
   */
  public function getWxUserList($accessToken, $nextOpenId);

  public function getUserAccessToken($code);

  public function getUserInfoCodeUri($url);
  
}
