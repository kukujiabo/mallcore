<?php
namespace App\Domain;

use App\Service\Crm\ChannelSv;

/**
 * 渠道服务接口
 * 
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-12-12
 */
class ChannelDm {

  /**
   * 新增
   */
  public function add($data) {

    return ChannelSv::addChannel($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {

    return ChannelSv::edit($data);
  
  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {

    return ChannelSv::findOne($condition['id']);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return ChannelSv::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);
  
  }

  /**
   * 获取数量
   */
  public function queryCount($condition) {
  
    return ChannelSv::queryCount($condition);

  }

  /**
   * 根据场景id获取一个渠道
   */
  public function getActiveOneByScene($data) {
  
    return ChannelSv::getActiveOneByScene($data['scene_id'], $data['type']);
  
  }

}
