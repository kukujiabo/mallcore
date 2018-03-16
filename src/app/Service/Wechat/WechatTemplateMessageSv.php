<?php
namespace App\Service\Wechat;

use App\Service\BaseService;
use App\Service\Crm\UserSv;
use App\Service\Crm\MemberWechatSv;
use App\Service\Crm\MemberAccountSv;
use App\Exception\WechatException;
use App\Exception\WechatTemplateMessageException;
use App\Exception\ErrorCode;
use App\Service\System\ConfigSv;
use App\Interfaces\Wechat\IWechatTemplateMessage;
use App\Library\Http;
use App\Service\Message\MemberMessageSv;
use \Core\Service\CurdSv;

/**
 * 微信模版消息服务
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-13
 */
class WechatTemplateMessageSv extends BaseService implements IWechatTemplateMessage{

  use CurdSv;

  /**
   * 添加消息模版
   *
   * @param string $shortId
   * 
   * @return boolean true/false
   */
  public function addTemplate($data) {

    $shortId = $data['short_id'];

    $icon = $data['icon'];

    $number = self::queryCount();

    if ($number == 24) {
    
      throw new WechatException(

        ErrorCode::WechatTemplateMessageSv['WECHAT_TEMPLATE_MESSAGE_NUM_EXCEED_MSG'],

        ErrorCode::WechatTemplateMessageSv['WECHAT_TEMPLATE_MESSAGE_NUM_EXCEED_CODE']
      
      );
    
    }

    $templateId = self::getTemplateId($shortId);

    $template = self::findOne(array('template_id' => $templateId));

    self::update($template['id'], array('icon' => $icon));

    return $templateId;

  }

  /**
   * 公众号消息推送 
   *
   * @param array $data
   *
   * @return
   */
  public function generalMessage($data) {

    /**
     * 发送数据
     */
    $sendData = array();

    /**
     * s1.设置模版基本信息
     */

    $templateId = $data['template_id'] ? $data['template_id'] : self::getTemplateId($data['short_id']);

    $template = null;

    if ($templateId) {

      $sendData['template_id'] = $templateId;

      /**
       * 查询模版，拼装模版数据
       */
    
      $template = self::findOne(array('template_id' => $templateId));

      /**
       * 跳转网页URL
       */

      $template['url'] ? $sendData['url'] = $template['url'] : '';

      /**
       * 跳转小程序appid
       */

      if ($template['appid']) {

        $sendData['miniprogram'] = array(
        
          'appid' => $template['appid'],

          'pagepath' => $template['pagepath']
        
        );

        if ($data['object_id']) {

          if ($data['object_key']) {

            $sendData['miniprogram']['pagepath'] .= "?{$data['object_key']}={$data['object_id']}";

          } else {
          
            $sendData['miniprogram']['pagepath'] .= "?id={$data['object_id']}";
          
          }
        
        }
      
      }

      /**
       * 设置配色
       */

      $sendData['topcolor'] = $data['topcolor'];

    } else {
    
      /**
       * 查询模版失败，抛出异常
       */
      
      throw new WechatException(

        ErrorCode::WechatTemplateMessageSv['WECHAT_TEMPLATE_MESSAGE_ID_FAILED_MSG'],

        ErrorCode::WechatTemplateMessageSv['WECHAT_TEMPLATE_MESSAGE_ID_FAILED_CODE']
      
      );
    
    }

    /**
     * s2.组装发送报文
     */

    $valueDatas = array();

    $contents = explode('||', $data['contents']);

    $templateTitle = '';

    foreach($contents as $key => $content) {

      $kmv = explode('$$', $content);

      if (!$key) {

        /**
         * 记录消息标题
         */

        $templateTitle = $kmv[1];
      
      }

      $valueDatas[$kmv[0]]['value'] = $kmv[1];

      $valueDatas[$kmv[0]]['color'] = $kmv[2] ? $kmv[2] : '#666666';
    
    }

    $sendData['data'] = $valueDatas;

    /**
     * s3.设置会员信息
     */

    /**
     * 根据卡号或手机号查找用户
     */

    $condition = array();

    if ($data['card_id']) {

      $acct = MemberAccountSv::findOne(array('card_id' => $data['card_id'])); 

      $condition['uid'] = $acct['uid'];

    } elseif ($data['mobile']) {
    
      $condition['user_tel'] = $data['mobile'];
    
    } elseif ($data['uid']) {
    
      $condition['uid'] = $data['uid'];
    
    }

    $user = UserSv::findOne($condition);

    $wxinfo = MemberWechatSv::findOne(array('unionid'=>$user['wx_unionid']));

    if (!$user || !$user['wx_unionid'] || !$wxinfo || !$wxinfo['openid']) {

      /**
       * 用户未关注公众号，抛出查询不到用户异常，但是记录小程序消息记录值
       */

      MemberMessageSv::addTemplateMessage(
        
        $templateTitle, 
        
        $template['module'], 
        
        $user['uid'], 
        
        0, 
        
        $template['appid'], 
        
        $template['pagepath'], 
        
        $template['icon'], 
        
        $template['url'], 
        
        $data['object_id']
      
      );

      /**
       * 用户不合法，不可推送
       */
      throw new WechatException(
        
        ErrorCode::WechatSv['WECHAT_PUSH_USER_MISSED_MSG'], 
        
        ErrorCode::WechatSv['WECHAT_PUSH_USER_MISSED_CODE']
      
      ); 

    } else {

      $sendData['touser'] = $wxinfo['openid'];
    
    }

    /**
     * s4.记录推送消息
     */
    $message = array(
    
      'card_id' => $data['card_id'],

      'mobile' => $data['mobile'],

      'short_id' => $data['short_id'],

      'object_id' => $data['object_id'],

      'channel' => $data['channel'],

      'template_id' => $sendData['template_id'],

      'url' => $sendData['url'],

      'appid' => $template['appid'],

      'pagepath' => $template['pagepath'],

      'openid' => $sendData['touser'],

      'content' => $data['contents'],

      'created_at' => date('Y-m-d H:i:s'),

      'status' => 0
    
    );

    $msgid = WechatPushMessageSv::add($message);

    /**
     * s5.拼接请求地址
     */

    $access_token = WechatUtilsSv::getAccessToken('wps_access_token');

    $url = \PhalApi\DI()->config->get('wechat.WECHAT_PUSH');

    $url = str_replace('{ACCESS_TOKEN}', $access_token, $url);

    $json_template = json_encode($sendData);

    /**
     * s6.请求微信接口，推送消息
     */

    $dataRes = Http::httpPost($url, $json_template, '', '', '', 'form');

    $dataRes = json_decode($dataRes, true);

    $newMsg = array('errmsg' => $dataRes['errmsg'], 'msgid' => $msgid);

    /**
     * s7.处理推送返回
     */

    if ($dataRes['errcode'] == 0) {

      /**
       * 推送成功，将推送消息标记为成功，并且记录用户消息
       */

      $newMsg['status'] = 1;

      /**
       * 标记推送消息记录为发送成功！
       */

      WechatPushMessageSv::update($msgid, $newMsg);

      /**
       * 根据模版消息建立会员消息
       */

      MemberMessageSv::addTemplateMessage($templateTitle, $template['module'], $user['uid'], $msgid, $template['appid'], $template['pagepath'], $template['icon'], $template['url'], $data['object_id']);

      return true;

    } else {

      $newMsg['status'] = -1;

      WechatPushMessageSv::update($msgid, $newMsg);

      throw new WechatException(
        
        ErrorCode::WechatSv['WECHAT_DO_SEND_RETURN_MSG'], 
        
        ErrorCode::WechatSv['WECHAT_DO_SEND_RETURN_CODE'], 
        
        $dataRes
      
      );

    }

  }


  /**
   * 获取微信所有模版消息
   *
   * @return array $list
   */
  public function getAllTemplates() {

    $accessToken = WechatUtilsSv::getAccessToken();

    $apiUrl = \PhalApi\DI()->config->get('wechat.GET_PRIMARY_TEMPLATES');

    $url = str_replace('{ACCESS_TOKEN}', $accessToken, $apiUrl);

    $dataRes = Http::httpPost($url, array(), '', '', '', 'form');

    return json_decode($dataRes, true);

  }

  /**
   * 获取templateid
   */
  public function getTemplateId($shortId) {

    /**
     * 从数据库中查询是否已经获取对应的模版id
     */

    $template = self::findOne(array('short_id' => $shortId));

    if ($template && $template['template_id']) {

      /**
       * 返回数据库保存的模版id
       */

      return $template['template_id'];
    
    } else {

      /**
       * 通过微信接口查询模版id
       */
  
      $accessToken = WechatUtilsSv::getAccessToken();

      $apiUrl = \PhalApi\DI()->config->get('wechat.GET_TEMPLATE_ID');

      $url = str_replace('{ACCESS_TOKEN}', $accessToken, $apiUrl);

      $res = Http::httpPost($url, json_encode(array('template_id_short' => $shortId)), '', '', '', 'raw');

      $info = json_decode($res, true);

      if(!$info['errcode']) {

        /**
         * 查询成功，保存模版id，并返回
         */

        if ($template) {

          /**
           * 模版已存在，则更新模版数据
           */
        
          self::update($template['id'], array('template_id' => $info['template_id']));
        
        } else {

          /**
           * 模版不存在，根据消息模版id查询消息模版详细信息
           */

          $tempData = self::getTemplateInfo($info['template_id']);

          /**
           * 保存模版信息
           */
        
          $newTemplate = array(
          
            'short_id' => $shortId,

            'template_id' => $info['template_id'],

            'tmp_name' => $tempData['title'],

            'content' => $tempData['content'],

            'created_at' => date('Y-m-d H:i:s')
          
          );

          self::add($newTemplate);
        
        }
       
        return $info['template_id'];
      
      } else {

        /**
         * 查询失败返回false
         */
      
        return false;
      
      }

    }
  
  }

  /**
   * 根据模版id获取模版信息
   *
   * @param string $templateId
   *
   * @return array $info
   */
  public function getTemplateInfo($templateId) {
  
    $templates = self::getAllTemplates();

    foreach($templates['template_list'] as $template) {
    
      if ($template['template_id'] == $templateId) {
      
        return $template;
      
      }
    
    }
  
    return NULL;
  
  }

  /**
   * 获取已添加的公众号模版消息列表
   */
  public function getList() {
  
    return self::all();
  
  }

}
