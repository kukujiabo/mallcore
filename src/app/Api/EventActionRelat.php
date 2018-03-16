<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\EventActionRelatDm;

/**
 * 10.2 事件操作关联接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-10-20
 */
class EventActionRelat extends BaseApi {

  /**
   * 接口参数规则
   */
  public function getRules() {

    return $this->rules(array(

      'add' => array(

        'event_id' => 'event_id|int|true||事件id',

        'action_id' => 'action_id|int|true||操作id',

        'module' => 'module|string|true||模块',

        'remark' => 'remark|string|false||备注',

        'active' => 'active|int|true||是否启用',

        'operator_id' => 'operator_id|int|true||操作员id',

      ),

      'queryList' => array(

        'event_id' => 'event_id|int|false||事件id',

        'action_id' => 'action_id|int|false||操作id',

        'module' => 'module|string|false||模块',

        'remark' => 'remark|string|false||备注',

        'active' => 'active|int|false||是否启用',
        
        'operator_id' => 'operator_id|int|false||操作员id',

        'created_at' => 'created_at|string|false||创建时间',

        'updated_at' => 'updated_at|string|false||更新时间',

        'deleted_at' => 'deleted_at|int|false||删除时间',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|20|每页数据条数'

      ),

      'queryCount' => array(

        'event_id' => 'event_id|int|false||事件id',

        'action_id' => 'action_id|int|false||操作id',

        'module' => 'module|string|false||模块',

        'remark' => 'remark|string|false||备注',

        'active' => 'active|int|false||是否启用',
        
        'operator_id' => 'operator_id|int|false||操作员id',

        'created_at' => 'created_at|string|false||创建时间',

        'updated_at' => 'updated_at|string|false||更新时间',

        'deleted_at' => 'deleted_at|int|false||删除时间',
      
      ),

      'update' => array(

        'id' => 'id|int|true||表序号',

        'event_id' => 'event_id|int|false||事件id',

        'action_id' => 'action_id|int|false||操作id',

        'module' => 'module|string|false||模块',

        'remark' => 'remark|string|false||备注',

        'active' => 'active|int|false||是否启用',
        
        'operator_id' => 'operator_id|int|false||操作员id',

        'created_at' => 'created_at|string|false||创建时间',

        'updated_at' => 'updated_at|string|false||更新时间',

        'deleted_at' => 'deleted_at|int|false||删除时间 1-删除',
      
      ),

      'getDetail' => array(

        'id' => 'id|int|true||表序号',
      
      ),
      
    ));

  }

  /**
   * 新增事件操作关联
   * @desc 新增事件操作关联
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function add() {

    $regulation = array(
      'event_id' => 'required',
      'action_id' => 'required',
      'module' => 'required',
      'active' => 'required',
      'operator_id' => 'required',
    );

    $params = $this->retriveRuleParams('add');

    \App\Verification($params, $regulation);

    return $this->dm->add($params);
  
  }

  /**
   * 修改事件操作关联
   * @desc 修改事件操作关联
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function update() {

    $regulation = array(
      'id' => 'required',
    );

    $params = $this->retriveRuleParams('update');

    \App\Verification($params, $regulation);

    return $this->dm->update($params);
  
  }

  /**
   * 查询事件操作关联详情
   * @desc 查询事件操作关联详情
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function getDetail() {

    $regulation = array(
      'id' => 'required',
    );

    $conditions = $this->retriveRuleParams('getDetail');

    \App\Verification($conditions, $regulation);

    return $this->dm->getDetail($conditions);
  
  }

  /**
   * 查询事件操作关联列表
   * @desc 查询事件操作关联列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function queryList() {

    $conditions = $this->retriveRuleParams('queryList');

    $regulation = array();

    \App\Verification($conditions, $regulation);

    return $this->dm->queryList($conditions);

  }

  /**
   * 查询事件操作关联数量
   * @desc 查询事件操作关联数量
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function queryCount() {

    $conditions = $this->retriveRuleParams('queryCount');
  
    $regulation = array();

    \App\Verification($conditions, $regulation);

    return $this->dm->queryCount($conditions);
  
  }

}
