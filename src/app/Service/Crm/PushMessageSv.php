<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use App\Interfaces\Crm\IPushMessage;
use App\Model\PushMessage;
use Core\Service\CurdSv;
use App\Service\Crm\UserSv;

/**
 * 推送消息类
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-14
 */
class PushMessageSv extends BaseService implements IPushMessage {

  use CurdSv;

  /**
   * 添加
   */
  public function addPushMessage($data) {

    $data['created_at'] = date('Y-m-d H:i:s');

    try{

      return self::add($data);

    } catch (\Exception $e){

      throw new InternalServerErrorException('新增失败', 1);

    }

  }

  /**
   * 获取列表
   */
  public function getList($condition) {

    if ($condition['way'] == 1 && $condition['token']) {

      $info_user = UserSv::getUserByToken($condition['token']);

      $condition['uid'] = $info_user['uid'];

    }

    unset($condition['token']);

    unset($condition['way']);

    return self::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);

  }

  /**
   * 获取详情
   */
  public function getDetails($condition) {

    if ($condition['way'] == 1 && $condition['token']) {

      $info_user = UserSv::getUserByToken($condition['token']);

      $condition['uid'] = $info_user['uid'];

      unset($condition['token']);

    }

    unset($condition['way']);

    $info = self::queryList($condition, $condition['fields'], $condition['order'], 1, 1);

    return $info['list'];

  }

  /**
   * 获取总数
   */
  public function getCount($condition) {

    return self::queryCount($condition);

  }

  /**
   * 修改
   */
  public function edit($data) {

    if ($data['id']) {

      $condition['id'] = $data['id'];

      unset($data['id']);

    }

    return self::batchUpdate($condition, $data);

  }



}
