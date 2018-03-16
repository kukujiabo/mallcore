<?php
namespace App\Service\Wechat;

use App\Library\Http;
use App\Library\RedisClient;
use App\Service\System\ConfigSv;
use App\Service\BaseService;
use App\Service\ThirdPartyApi\Notify\ThirdPartyMessageLogSv;

/**
 * 微信相关常用操作服务
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class WechatUtilsSv extends BaseService {

    /**
     * 定义微信token类型
     */

    CONST ConfigMap = array(

      /**
       * 公众号token相关配置
       */
    
      'wps_access_token' => array(
      
        'appid' => 'wps_appid', 
        
        'appsecret' => 'wps_appsecret',

        'openid_url' => 'wechat.USER_ACCESS_TOKEN'
      
      ),

      /**
       * 小程序token相关配置
       */

      'mini_access_token' => array(
      
        'appid' => 'mini_appid', 
        
        'appsecret' => 'mini_appsecret',

        'openid_url' => 'wechat.GET_MIN_OPENID'
      
      )
    
    );

    /**
     * 获取微信 access_token
     *  
     * @param string $type wps_access_token-公众号 access_token_mini_apps-小程序
     * @param string $app_id 默认公众号appid
     * @param string $app_secret 默认公众号secret
     *
     * @return string access_token
     */
    public function getAccessToken ($type = 'wps_access_token', $appid = '', $appsecret = '') {

      $wxToken = RedisClient::get('wechat', $type, true);

      //access_token_result
      /**
       * 判断 access_token 是否过期
       */

      if (!$wxToken || empty($wxToken[$type]['access_token']) || $wxToken[$type]['expires_at'] <= time()) {

        /**
         * 缓存token无效，重新获取
         */

        $url = \PhalApi\DI()->config->get('wechat.GET_ACCESS_TOKEN');

        /**
         * 根据需要的 access_token 类型加载配置
         */

        $config = WechatUtilsSv::ConfigMap[$type];

        $appid = $appid ? $appid : ConfigSv::getConfigValueByKey($config['appid']);

        $appsecret = $appsecret ? $appsecret : ConfigSv::getConfigValueByKey($config['appsecret']);

        $url = str_replace(array('{APPID}', '{APPSECRET}'), array($appid, $appsecret), $url);

        $result = json_decode(Http::httpGet($url), true);

        /**
         * 判断是否获取成功
         */

        if ($result['errcode']) {
        
          return NULL;
        
        } else {
        
          $result['expires_at'] = time() + $result['expires_in'];

          RedisClient::set('wechat', $type, $result);

          return $result['access_token'];
        
        }

      } else {

        /**
         * 缓存token有效直接返回
         */

        return $wxToken['access_token'];

      }

    }

    /**
     * 获取微信小程序openId
     *
     * @param string $code
     *
     * @return
     */
    public function getMiniOpenId($code, $appid = '', $appsecret = '') {

      return self::getOpenId($code, 'mini_access_token'); 
    
    }

    /**
     * 获取微信公众号openId
     *
     * @param string $code
     *
     * @return
     */
    public function getPubsOpenId($code, $appid = '', $appsecret = '') {

      return self::getOpenId($code, 'wps_access_token'); 
    
    }

    /**
     * 根据code获取用户openid
     *
     * @param string $code 
     * @param string $type
     *
     * @return array $result
     */
    public function getOpenId($code, $type) {

      /**
       * 读取相关配置
       */

      $appid = ConfigSv::getConfigValueByKey(WechatUtilsSv::ConfigMap[$type]['appid']);

      $appsecret = ConfigSv::getConfigValueByKey(WechatUtilsSv::ConfigMap[$type]['appsecret']);

      $urlTemp = \PhalApi\DI()->config->get(WechatUtilsSv::ConfigMap[$type]['openid_url']);

      /**
       * 请求openId
       */

      $url = str_replace(array('{APPID}', '{APPSECRET}', '{CODE}'), array($appid, $appsecret, $code), $urlTemp);

      $result =  Http::httpGet($url);

      return json_decode($result, true);
    
    }


    /**
     * 获取关注用户的信息
     * @param string $openid 微信用户openid
     * @return array 微信用户信息
     */
    public function getUnionid ($openid, $access_token) {

        $url = \PhalApi\DI()->config->get('wechat.GET_SUBSCRIBE');

        $url = str_replace('{ACCESS_TOKEN}', $access_token, $url);

        $url = str_replace('{OPENID}', $openid, $url);

        $url = str_replace('{zh_CN}', 'zh_CN', $url);

        $result = Http::httpGet($url);

        return json_decode($result, true);

    }

    /**
     * 记录第三方日志
     *
     * @param string $content 日志主要内容
     * @param string $remark  日志备注
     * @param string $action  日志操作类型
     * @param string $status  日志状态
     *
     * @return 
     */
    public function addThirdPartyLog($content, $remark = 'raw', $action = '', $status = 0) {
    
      $insertData = array(
          'module' => 'wechat',
          'action' => $action,
          'content' => $content,
          'remark' => $remark,
          'status' => $status,
          'created_at' => date('Y-m-d H:i:s'),
          'err_msg' => '',
      );

      return ThirdPartyMessageLogSv::add($insertData);
    
    }

    /**
     * 修改第三方日志
     *
     * @param int $id 日志id
     * @param array $data 修改数据集
     *
     * @return int num 修改影响条数
     */
    public function updateThirdPartyLog($id, $data) {
    
      $updateData = array();

      if ($data['action']) {

        $updateData['action'] = $data['action'];
      
      }
      if ($data['remark']) {
      
        $updateData['remark'] = $data['remark'];
      
      }
      if (isset($data['status'])) {
      
        $updateData['status'] = $data['status'];
      
      }
      if ($data['err_msg']) {
      
        $updateData['err_msg'] = $data['err_msg'];

      }
    
      if (empty($updateData)) {

        return 0;
      
      }

      return ThirdPartyMessageLogSv::update($id, $updateData);
    
    }

    /**
     * 生成签名
     *
     * @param string $timestamp 时间戳
     * @param string $nonce 随机数
     * @param string $token 令牌
     *
     * @return string $signature 签名
     */
    public function createSignature($timestamp, $nonce, $token) {
    
      $sigArr = array($timestamp, $nonce, $token);

      sort($sigArr, SORT_STRING);

      return sha1(implode($sigArr));

    }

    /**
     * 检验签名
     *
     * @param string $signature 需要验证的签名
     * @param string $timestamp 时间戳
     * @param string $nonce 随机数
     * @param string $token 令牌
     *
     * @return boolean true/false
     */
    public function checkSignature($signature, $timestamp, $nonce, $token) {
    
      return $signature == self::createSignature($timestamp, $nonce, $token);
    
    }

}
