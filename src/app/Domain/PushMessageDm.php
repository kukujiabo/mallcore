<?php

namespace App\Domain;

use App\Service\Crm\PushMessageSv;

/**
 * 推送信息接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-11-14
 */
class PushMessageDm {

  /**
   * 新增
   */
  public function add($data) {

    return PushMessageSv::addPushMessage($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {
    
    return PushMessageSv::edit($data);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return PushMessageSv::getList($condition);
  
  }

  /**
   * 获取数量
   */
  public function queryCount($condition) {
  
    return PushMessageSv::getCount($condition);

  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {
    
    return PushMessageSv::getDetails($condition);

  }

}
