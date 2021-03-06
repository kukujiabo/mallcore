<?php
namespace App\Service\Wechat;

use App\Service\BaseService;
use Core\Service\CurdSv;
use App\Interfaces\Wechat\IWechatResponseMessage;
use App\Service\System\ConfigSv;

/**
 * 微信自定义消息回复
 *
 * @author Meroc Chen <398515393@qq.com> 2018-01-26
 */
class WechatResponseMessageSv extends BaseService {

  use CurdSv;

  CONST MSGTYPES = array( 'text', 'image' );

  /**
   * 处理微信推送消息
   *
   * @param array $decodeXML
   *
   * @return
   */
  public function handlePushMessage($decodeXML) {

    /**
     * 记录推送消息
     */

    self::addResponseMessage($decodeXML);

    /**
     * 分别处理不同的推送消息
     */

    $msgType = $decodeXML['MsgType'];
  
    switch($msgType) {

      /**
       * 处理文本消息
       */
    
      case 'text':

        self::handleTextMessage($decodeXML);

        break;

      /**
       * 处理图像
       */

      case 'image':

        self::handleImageMessage($decodeXML);

        break;
    
    }   
  
  }

  /**
   * 处理微信文本消息
   *
   * @param array $decodeXML
   *
   * @return
   */
  public function handleTextMessage($decodeXML) {
  
    $content = $decodeXML['Content'];

    $reply = ConfigSv::findOne(array('sub_module' => 'wechat_public_service_keyword', 'val' => $content));

    if ($reply) {

      $content = $reply['ext_1']; // iconv('GBK', 'UTF-8', $reply['ext_1']);
     
      echo "<xml><ToUserName><![CDATA[{$decodeXML['FromUserName']}]]></ToUserName><FromUserName><![CDATA[gh_cbcd762da8e4]]></FromUserName><CreateTime>{$nowTime}</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[{$content}]]></Content></xml>";

      exit;

    } else {

      $reply = ConfigSv::findOne(array('k_name' => 'default_response'));

      $content = $reply['val']; // iconv('GBK', 'UTF-8', $reply['val']);
    
      echo "<xml><ToUserName><![CDATA[{$decodeXML['FromUserName']}]]></ToUserName><FromUserName><![CDATA[gh_cbcd762da8e4]]></FromUserName><CreateTime>{$nowTime}</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[{$content}]]></Content></xml>";

      exit;
    
    }
  
  }

  /**
   * 处理微信图片消息
   *
   * @param array $decodeXML
   *
   * @return
   */
  public function handleImageMessage($decodeXML) {
  
  
  
  }

  /**
   * 添加推送消息
   */
  public function addResponseMessage($data, $received = 1) {

    $newMsg = array(
    
      'from_user' => $data['FromUserName'],

      'to_user' => $data['ToUserName'],

      'msg_type' => $data['MsgType'],

      'msg_id' => $data['MsgId'],

      'is_received' => $received,

      'create_time' => $data['CreateTime'],

      'created_at' => date('Y-m-d H:i:s')
    
    );

    if ($data['MsgType'] == 'text') {
    
      $newMsg['msg_content'] = $data['Content'];
    
    } elseif ($data['MsgType'] == 'image') {

      $newMsg['msg_content'] = $data['PicUrl'];

      $newMsg['media_id'] = $data['MediaId'];
    
    }

    return self::add($newMsg);
  
  }

  public function editDefaultMessage($data) {
  
    return ConfigSv::saveByKname(array( 'default_response' => $data['text'] ));
  
  }

  public function getDefaultMessage($data) {
  
    return ConfigSv::getConfigValueByKey('default_response');
  
  }

  public function editResponseMessage($data) {
  
    return ConfigSv::saveByKname(array('subscribe_response'=>$data['text']));   
  }

  public function getFocusResponse($data) {
  
    return ConfigSv::getConfigValueByKey('subscribe_response'); 
  
  }

  public function addKeywordResponse($data) {

    $newConfig = array(
    
      'module' => 'WX',
      'sub_module' => 'wechat_public_service_keyword',
      'k_name' => $data['kname'],
      'val' => $data['keyword'],
      'ext_1' => $data['ext_1'],
    
    );
  
    return ConfigSv::add($newConfig);
  
  }

  public function getKeywordList($data) {
  
    return ConfigSv::all(array( 'sub_module' => 'wechat_public_service_keyword' ));
  
  }

  public function deleteKeyword($data) {
  
    return ConfigSv::remove($data['id']);
  
  }

}
