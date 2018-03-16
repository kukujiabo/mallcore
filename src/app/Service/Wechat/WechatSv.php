<?php
namespace App\Service\Wechat; 

use App\Common\Logs;
use App\Service\BaseService;
use App\Service\Crm\UserSv;
use App\Service\System\ConfigSv;
use App\Service\Wechat\WechatSceneSv;
use App\Library\Http;
use App\Library\RedisClient;
use App\Library\WXBizMsgCrypt;

/**
 *
 * 微信接口类
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-12-01
 *
 */
class WechatSv extends BaseService {

  /**
   * 微信公众号推送信息
   *
   * @param array $params 请求参数
   *
   * @return 
   */
  public function wechatMessagePush($params) {
    
    /**
     * 1.先记录请求所有内容
     */
    $express = json_encode($params);

    $encrypt = file_get_contents("php://input");

    $rawQueryContent = "express:{$express}|encrypt:{$encrypt}";

    $tid = WechatUtilsSv::addThirdPartyLog($rawQueryContent);

    /**
     * 2.判断请求是否包含签名
     */
    if ($params['signature']) {

      $token = ConfigSv::getConfigValueByKey('wps_developing_token');

      /**
       * 3.验证签名
       */
      if (WechatUtilsSv::checkSignature($params['signature'], $params['timestamp'], $params['nonce'], $token)) {

        self::handleMessage($token, $params, $encrypt);

        /**
         * 在绑定服务器时返回 echo 字段，其他时候返回空字符串
         */

        if (empty($params['echostr'])) {
         
          echo '';
           
        } else {
         
          echo $params['echostr'];

        }

        exit;

      } else {

        echo false;

        exit;

      }

    }

  }

  /**
   * 获取ticket
   */
  public function getTicket ($data) {

      if ($data['scene_id']) {

          $scene['scene_id'] = (int)$data['scene_id'];

          unset($data['scene_id']);

      }

      if ($data['scene_str']) {

          $scene['scene_str'] = $data['scene_str'];

          unset($data['scene_str']);

      }

      $data['action_info']['scene'] = $scene;

      $access_token = WechatUtilsSv::getAccessToken();

      $origin_uri = \PhalApi\DI()->config->get('wechat.GET_TICKET');

      $origin_uri = str_replace('{TOKENPOST}', $access_token, $origin_uri);

      return Http::httpPost($origin_uri, json_encode($data), '', '', '', 'form');

  }

  /**
   * 微信推送消息处理
   *
   * @author Meroc Chen <398515393@qq.com> 2017-12-13
   *
   * @param array $params
   * @param string $encrypt
   *
   * @return
   */
  public static function handleMessage($token, $params, $encrypt = '') {

    if ($params['openid']) {

      /**
       * 微信消息包含用户信息
       *
       * 1. 解密
       * 2. 处理事件和场景
       */

      $decryptMsg = '';  //解密后的明文

      if ($params['encrypt_type'] == 'aes' && strlen($encrypt)) {

        /**
         * 解密
         */

        $appid = ConfigSv::getConfigValueByKey('wps_appid');

        $EncodingAESKey = ConfigSv::getConfigValueByKey('wps_encodingaeskey');

        $pc = new WXBizMsgCrypt($token, $EncodingAESKey, $appid);

        $res = $pc->decryptMsg($params['msg_signature'], $params['timestamp'], $params['nonce'], $encrypt, $decryptMsg);

        if ($res != 0) {

          /**
           * 解密失败，记入错误日志中，不能抛出异常
           */
          Logs::error(__CLASS__, "decode: {$encrypt} failed! ");
        
          return;
        
        }

      }

      /**
       * 解密成功处理
       */

      $decodeXML = (array)simplexml_load_string($decryptMsg, 'SimpleXMLElement', LIBXML_NOCDATA);

    
      if ($decodeXML['MsgType'] == 'event' && $decodeXML['Event']) {

        /**
         * 根据事件和场景处理本次请求
         */
        WechatSceneSv::handleScene($params['openid'], $decodeXML['EventKey'], $decodeXML['Event']);

      } elseif (in_array($decodeXML, WechatResponseMessageSv::MSGTYPES)) {
      
        /**
         * 处理推送消息
         */
        WechatResponseMessageSv::handlePushMessage($decodeXML);
      
      }

    } else {

      /**
       * 事件不包含用户信息
       */
    
    }

  }

}

