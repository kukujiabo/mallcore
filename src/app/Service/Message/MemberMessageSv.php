<?php
namespace App\Service\Message;

use Core\Service\CurdSv;
use App\Service\BaseService;
use App\Service\Crm\UserSv;
use App\Interfaces\Message\IMemberMessage;


/**
 * 会员消息服务
 *
 * @author Meroc Chen <398515393@qq.com> 2018-01-08
 */
class MemberMessageSv extends BaseService implements IMemberMessage {

  use CurdSv;

  /**
   * 根据模版消息设置会员消息
   *
   * @param string $title     消息标题
   * @param string $module    消息所属模块
   * @param string $uid       用户id
   * @param string $msgId     推送消息id 
   * @param string $appid     小程序appid
   * @param string $pagepath  页面路径
   * @param string $icon      图标
   * @param string $url       网页跳转地址
   */
  public function addTemplateMessage($title, $module, $uid, $msgId, $appid, $pagepath, $icon, $url, $objectId) {

    $newMsg = array(
    
      'title' => $title,

      'module' => $module,

      'uid' => $uid,

      'msgid' => $msgId,

      'appid' => $appId,

      'pagepath' => $pagepath,

      'url' => $url,

      'icon' => $icon,

      'object_id' => $objectId,

      'created_at' => date('Y-m-d H:i:s')
    
    );
  
    return self::add($newMsg);
  
  }

  /**
   * 获取列表
   */
  public function getLists($condition) {
    
    if ($condition['way'] == 1 && $condition['token']) {

      $user_info = UserSv::getUserByToken($condition['token']);

      $condition['uid'] = $user_info['uid'];

    }

    unset($condition['way']);

    unset($condition['token']);
    
    return self::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);

  }


}
