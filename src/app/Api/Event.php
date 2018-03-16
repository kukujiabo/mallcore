<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\EventDm;

/**
 * 10.1 系统定义事件接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-10-20
 */
class Event extends BaseApi {

  /**
   * 接口参数规则
   */
  public function getRules() {

    return $this->rules(array(

      'add' => array(

        'event_code' => 'event_code|string|true||事件编码',

        'event_name' => 'event_name|string|true||事件名称', 

        'service_name' => 'service_name|string|true||请求路径',

        'method_name' => 'method_name|string|true||方法名称',

        'data' => 'data|string|true||数据',

        'module' => 'module|string|true||所属模块',

        'remark' => 'remark|string|false||备注',

        'operator_id' => 'operator_id|int|false||操作员id',

        'validate_start' => 'validate_start|string|true||有效开始时间，0为无限制',

        'validate_end' => 'validate_end|string|true||有效结束时间，0为无限制',

      ),

      'queryList' => array(

        'event_code' => 'event_code|string|false||事件编码',

        'event_name' => 'event_name|string|false||事件名称',

        'route' => 'route|string|false||请求路径',

        'module' => 'module|string|false||所属模块',

        'remark' => 'remark|string|false||备注',

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

        'event_code' => 'event_code|string|false||事件编码',

        'event_name' => 'event_name|string|false||事件名称',

        'route' => 'route|string|false||请求路径',

        'module' => 'module|string|false||所属模块',

        'remark' => 'remark|string|false||备注',

        'operator_id' => 'operator_id|int|false||操作员id',

        'created_at' => 'created_at|string|false||创建时间',

        'updated_at' => 'updated_at|string|false||更新时间',

        'deleted_at' => 'deleted_at|int|false||删除时间',
      
      ),

      'update' => array(

        'id' => 'id|int|true||表序号',

        'event_code' => 'event_code|string|false||事件编码',

        'event_name' => 'event_name|string|false||事件名称',

        'route' => 'route|string|false||请求路径',

        'module' => 'module|string|false||所属模块',

        'remark' => 'remark|string|false||备注',

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
   * 新增系统定义事件
   * @desc 新增系统定义事件
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function add() {

    $regulation = array(
      'event_code' => 'required',
      'event_name' => 'required',
      'method_name' => 'required',
      'event_name' => 'required',
      'data' => 'required',
      'module' => 'required',
      'validate_start' => 'required',
      'validate_end' => 'required',
    );

    $params = $this->retriveRuleParams('add');

    \App\Verification($params, $regulation);

    return $this->dm->add($params);
  
  }

  /**
   * 修改系统定义事件
   * @desc 修改系统定义事件
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
   * 查询系统定义事件详情
   * @desc 查询系统定义事件详情
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
   * 查询系统定义事件列表
   * @desc 查询系统定义事件列表
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
   * 查询系统定义事件数量
   * @desc 查询系统定义事件数量
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
