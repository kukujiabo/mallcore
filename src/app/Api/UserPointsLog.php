<?php
namespace App\Api;

use PhalApi\Api;
use App\Domain\UserPointsLogDm;

/**
 * 2.6 用户消费积分记录接口
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-09-25
 */

class UserPointsLog extends BaseApi {

  /**
   * 接口参数规则
   */
  public function getRules() {

    return $this->rules(array(

      'add' => array(

        'uid' => 'uid|int|true||所属用户id',

        'serial' => 'serial|string|false||流水号',

        'rule_name' => 'rule_name|string|false||规则名称',

        'channel' => 'channel|int|false||渠道id',

        'channel_type' => 'channel_type|int|false||渠道类型：1 线下门店，2 线上商城',

        'action' => 'action|string|false||请求操作',

        'object_id' => 'object_id|string|false||关联对象id',

        'points_amount' => 'points_amount|int|true||积分使用总额',

        'ins_ids' => 'ins_ids|int|false||积分实例id',

        'use_type' => 'use_type|int|true||记录类型：1 消费，2 失效，3 获得',

        'remarks' => 'remarks|string|false||备注',

      ),

      'queryList' => array(

        'way' => 'way|int|true|1|类型 1-前台用户 2-后台管理员',

        'token' => 'token|string|false||用户令牌',

        'id' => 'id|int|false||表序号',

        'uid' => 'uid|int|false||所属用户id',

        'serial' => 'serial|string|false||流水号',

        'rule_name' => 'rule_name|string|false||规则名称',

        'channel' => 'channel|int|false||渠道id',

        'channel_type' => 'channel_type|int|false||渠道类型：1 线下门店，2 线上商城',

        'action' => 'action|string|false||请求操作',

        'object_id' => 'object_id|string|false||关联对象id',

        'points_amount' => 'points_amount|int|false||积分使用总额',

        'ins_ids' => 'ins_ids|int|false||积分实例id',

        'use_type' => 'use_type|int|false||记录类型：1 消费，2 失效，3 获得',

        'remarks' => 'remarks|string|false||备注',

        'created_at' => 'created_at|string|false||创建时间',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|20|每页数据条数'

      ),

      'queryCount' => array(

        'id' => 'id|int|false||表序号',

        'uid' => 'uid|int|false||所属用户id',

        'serial' => 'serial|string|false||流水号',

        'rule_name' => 'rule_name|string|false||规则名称',

        'channel' => 'channel|int|false||渠道id',

        'channel_type' => 'channel_type|int|false||渠道类型：1 线下门店，2 线上商城',

        'action' => 'action|string|false||请求操作',

        'object_id' => 'object_id|string|false||关联对象id',

        'points_amount' => 'points_amount|int|false||积分使用总额',

        'ins_ids' => 'ins_ids|int|false||积分实例id',

        'use_type' => 'use_type|int|false||记录类型：1 消费，2 失效，3 获得',

        'remarks' => 'remarks|string|false||备注',

        'created_at' => 'created_at|string|false||创建时间',

      ),

      'update' => array(

        'id' => 'id|int|true||记录id',

        'uid' => 'uid|int|false||所属用户id',

        'serial' => 'serial|string|false||流水号',

        'rule_name' => 'rule_name|string|false||规则名称',

        'channel' => 'channel|int|false||渠道id',

        'channel_type' => 'channel_type|int|false||渠道类型：1 线下门店，2 线上商城',

        'action' => 'action|string|false||请求操作',

        'object_id' => 'object_id|string|false||关联对象id',

        'points_amount' => 'points_amount|int|false||积分使用总额',

        'ins_ids' => 'ins_ids|int|false||积分实例id',

        'use_type' => 'use_type|int|false||记录类型：1 消费，2 失效，3 获得',

        'remarks' => 'remarks|string|false||备注',

        'created_at' => 'created_at|string|false||创建时间',
      
      ),

      'getDetail' => array(

        'way' => 'way|int|true|1|类型 1-前台用户 2-后台管理员',

        'token' => 'token|string|false||用户令牌',

        'id' => 'id|int|false||表序号',

        'uid' => 'uid|int|false||所属用户id',

        'serial' => 'serial|string|false||流水号',

        'rule_name' => 'rule_name|string|false||规则名称',

        'channel' => 'channel|int|false||渠道id',

        'channel_type' => 'channel_type|int|false||渠道类型：1 线下门店，2 线上商城',

        'action' => 'action|string|false||请求操作',

        'object_id' => 'object_id|string|false||关联对象id',

        'points_amount' => 'points_amount|int|false||积分使用总额',

        'ins_ids' => 'ins_ids|int|false||积分实例id',

        'use_type' => 'use_type|int|false||记录类型：1 消费，2 失效，3 获得',

        'remarks' => 'remarks|string|false||备注',

        'created_at' => 'created_at|string|false||创建时间',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',
      
      ),
      
    ));

  }

  /**
   * 新增消费积分记录
   * @desc 新增用户消费积分记录
   *
   * @return int ret 操作状态：200表示成功
   * @return int data 表序号
   * @return string msg 错误提示
   */
  public function add() {

    $regulation = array(
      'uid' => 'required',
      'points_amount' => 'required',
      'use_type' => 'required',
    );

    $params = $this->retriveRuleParams('add');

    \App\Verification($params, $regulation);

    return $this->dm->add($params);
  
  }

  /**
   * 修改消费积分记录
   * @desc 修改用户消费积分记录
   *
   * @return int ret 操作状态：200表示成功
   * @return int data 修改条数
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
   * 查询消费积分记录详情
   * @desc 查询用户消费积分记录详情
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.id 记录id
   * @return int data.uid 用户id
   * @return string data.serial 流水号
   * @return string data.rule_name 规则名称
   * @return int data.channel 渠道id
   * @return int data.channel_type 渠道类型：1 线下门店，2 线上商城
   * @return string data.action 请求操作
   * @return int data.object_id 对应订单id
   * @return int data.points_amount 积分使用总额
   * @return int data.ins_ids 积分实例id
   * @return string data.remarks 备注
   * @return int data.use_type 记录类型：1 消费，2 失效，3 获得
   * @return string data.created_time 创建时间
   * @return string msg 错误提示
   */
  public function getDetail() {

    $regulation = array(
      'way' => 'required',
    );

    $conditions = $this->retriveRuleParams('getDetail');

    \App\Verification($conditions, $regulation);

    if ($params['way'] == 1 && !$params['token']) {

      throw new Exception('token 必传');
        
    }

    return $this->dm->getDetail($conditions);
  
  }

  /**
   * 查询消费积分记录列表
   * @desc 查询用户消费积分记录列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.total 数据总条数
   * @return int data.page 当前页码
   * @return array data.list[] 数据队列
   * @return int data.list[].id 记录id
   * @return int data.list[].uid 用户id
   * @return string data.list[].serial 流水号
   * @return string data.list[].rule_name 规则名称
   * @return int data.list[].channel 渠道id
   * @return int data.list[].channel_type 渠道类型：1 线下门店，2 线上商城
   * @return string data.list[].action 请求操作
   * @return int data.list[].object_id 对应订单id
   * @return int data.list[].points_amount 积分使用总额
   * @return int data.list[].ins_ids 积分实例id
   * @return string data.list[].remarks 备注
   * @return int data.list[].use_type 记录类型：1 消费，2 失效，3 获得
   * @return string data.list[].created_time 创建时间
   * @return string msg 错误提示
   */
  public function queryList() {

    $conditions = $this->retriveRuleParams('queryList');

    $regulation = array(
      'way' => 'required',
    );

    \App\Verification($conditions, $regulation);
    
    if ($params['way'] == 1 && !$params['token']) {

      throw new Exception('token 必传');
        
    }

    return $this->dm->queryList($conditions);

  }

  /**
   * 查询消费积分记录总数
   * @desc 查询消费积分记录总数
   *
   * @return int ret 操作状态：200表示成功
   * @return int data 数据条数
   * @return string msg 错误提示
   */
  public function queryCount() {

    $conditions = $this->retriveRuleParams('queryCount');

    $regulation = array(
      'way' => 'required',
    );

    \App\Verification($conditions, $regulation);

    return $this->dm->queryCount($conditions);

  }

}
