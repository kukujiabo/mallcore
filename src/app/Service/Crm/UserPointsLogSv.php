<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use App\Interfaces\Crm\IUserPointsLog;
use App\Model\UserPointsLog;
use Core\Service\CurdSv;
use App\Service\Crm\UserSv;

/**
 * 用户消费积分日志类
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-09-18
 */
class UserPointsLogSv extends BaseService implements IUserPointsLog {

  use CurdSv;

  /**
   * 新增
   */
  public function addLog($data) {

    $data['created_time'] = date("Y-m-d H:i:s");

    try{

      return self::add($data);

    } catch (\Exception $e){

      throw new InternalServerErrorException('新增失败', 1);

    }
  
  }

  /**
   * 编辑
   */
  public function edit($data) {
    
    $where['id'] = $data['id'];

    unset($data['id']);

    return self::batchUpdate($where, $data);
  
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
   * 获取总数
   */
  public function getCount($condition) {

    return self::queryCount($condition);
  
  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {

    if ($condition['way'] == 1 && $condition['token']) {

      $info_user = UserSv::getUserByToken($condition['token']);

      $condition['uid'] = $info_user['uid'];

    }

    unset($condition['token']);

    unset($condition['way']);
    
    $list = UserPointsLog::queryList($condition, $condition['fields'], $condition['order'], 0, 1);

    return $list[0];

  }

}
