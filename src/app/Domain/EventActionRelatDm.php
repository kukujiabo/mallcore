<?php

namespace App\Domain;

use App\Service\System\EventActionRelatSv;

/**
 * 事件操作关联接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-20
 */
class EventActionRelatDm {

  /**
   * 新增
   */
  public function add($data) {

    $data['created_at'] = date("Y-m-d H:i:s");

    return EventActionRelatSv::add($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {
    
    $id = $data['id'];

    unset($data['id']);

    $data['updated_at'] = date("Y-m-d H:i:s");
    
    if ($data['deleted_at'] == 1) {

      $data['deleted_at'] = time();

    }

    return EventActionRelatSv::update($id, $data);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return EventActionRelatSv::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);
  
  }

  /**
   * 获取数量
   */
  public function queryCount($condition) {
  
    return EventActionRelatSv::queryCount($condition);

  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {
    
    return EventActionRelatSv::findOne($condition['id']);

  }

}
