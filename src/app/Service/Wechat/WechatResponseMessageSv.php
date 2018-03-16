<?php
namespace App\Service\Wechat;

use App\Service\BaseService;
use Core\Service\CurdSv;
use App\Interfaces\Wechat\IWechatResponseMessage;

/**
 * 微信自定义消息回复
 *
 * @author Meroc Chen <398515393@qq.com> 2018-01-26
 */
class WechatResponseMessageSv extends BaseService implements IWechatResponseMessageSv {

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

        handleTextMessage($decodeXML);

        break;

      /**
       * 处理图像
       */

      case 'image':

        handleImageMessage($decodeXML);

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

}
