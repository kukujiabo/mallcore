<?php
namespace App\Service\Crm;

use App\Interfaces\Crm\IChannel;
use App\Service\BaseService;
use Core\Service\CurdSv;
use App\Service\Shop\ShopSv;
use App\Service\Crm\UserSv;
use App\Model\Channel; 
use App\Service\Wechat\WechatSv;

/**
 * 渠道服务
 *
 * @author Meroc Chen <398515393@qq.com> 2017-11-20
 */
class ChannelSv extends BaseService implements IChannel {

  use CurdSv;

  /**
   * 添加
   */
  public function addChannel($params) {

    if ($params['action_name'] == 'QR_SCENE') {

        $params['is_temporary'] = 1;

        if (!$params['expire_seconds']) {

            $params['expire_seconds'] = 30;

        }

    } elseif ($params['action_name'] == 'QR_STR_SCENE') {

        $params['is_temporary'] = 1;

        $params['scene_str'] = $params['scene_str'];

        if (!$params['expire_seconds']) {

            $params['expire_seconds'] = 30;

        }

    } elseif ($params['action_name'] == 'QR_LIMIT_SCENE') {

        $params['is_temporary'] = 2;

        unset($params['expire_seconds']);
        
    } elseif ($params['action_name'] == 'QR_LIMIT_STR_SCENE') {

        $params['is_temporary'] = 2;

        $params['scene_str'] = $params['scene_str'];

        unset($params['expire_seconds']);

    }

    $data = $params;

    unset($data['is_temporary']);

    unset($data['type']);

    unset($data['name']);

    $result_ticket = WechatSv::getTicket($data);

    $params = array_merge($params, json_decode($result_ticket, true));

    $origin_uri = \PhalApi\DI()->config->get('wechat.GET_QR_CODE');

    $params['qr_code'] = str_replace('{TICKET}', urlencode($params['ticket']), $origin_uri);

    $params['created_at'] = date("Y-m-d H:i:s");

    $id = self::add($params);

    return self::findOne($id);

  }

  /**
   * 编辑
   */
  public function edit($data) {

    $id = $data['id'];

    unset($data['id']);

    return self::update($id, $data);

  }

  /**
   * 根据场景值获取有效渠道
   *
   * @param string $sceneid
   *
   * @return array $channel
   */
  public function getActiveOneByScene($sceneId, $type  = 2) {
  
    $conditions = array(
    
      'status' => 1

    );

    $type == 1 ? $conditions['scene_id'] = $sceneId : $conditions['scene_str'] = $sceneId;

    $channel = self::findOne($conditions);

    if ($channel['is_temporary'] == 2) {
    
      return $channel;
    
    } else {
    
      if ((strtotime($channel['created_at']) + intval($channel['expire_seconds'])) > time()) {

        return $channel;
      
      }
    
    }

    return null;
  
  }

  /**
   * 返回渠道实体
   *
   * @param string $scene
   * @param int $type
   */
  public function getChannelEntity($channelId, $type = 2) {

    $channel = self::findOne($channelId);

    $entity = null; 

    switch($channel['type']) {
    
      case 1:

        $entity = ShopSv::findOne($channel['entity']);

        break;

      case 2:

        //todo 团队

        break;

      case 3:

        $entity = UserSv::findOne($channel['entity']);

        break;
    
    }
  
    return $entity;
  
  }

  /** 
   * 渠道业绩增1
   *
   * @param int $id
   */
  public function increaseNumber($id) {
  
    return self::update($id, array('number' => '+1'));
  
  }

}
