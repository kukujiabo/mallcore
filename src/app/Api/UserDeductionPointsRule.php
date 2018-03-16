<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\UserDeductionPointsRuleDm;

/**
 * 2.3 用户消费积分规则接口
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-10-24
 */
class UserDeductionPointsRule extends BaseApi {

  /**
   * 接口参数规则
   */
  public function getRules() {

    return $this->rules(array(

      'add' => array(

        'name' => 'name|string|true||规则名称',

        'operator' => 'operator|int|true||创建人',

        'channel_type' => 'channel_type|int|true||使用渠道类型：0 全渠道，1 门店，2 线上消费',

        'channel' => 'channel|int|true||使用渠道id: 0 全部，门店id， 线上商城：9999',

        'action' => 'action|string|true||请求操作',

        'use_type' => 'use_type|int|true||使用类型：1 抵扣，2 兑换;',

        'deduction_type' => 'deduction_type|int|true||抵扣类型：1 按比例抵扣，2 固定抵扣',
      
        'limit' => 'limit|int|true||抵扣额度限制，当使用类型为1有效',

        'deduction_percent' => 'deduction_percent|int|true||抵扣比例，积分与人民币（单位：元）的抵扣比例，抵扣类型为1时有效',

        'fixed_amount' => 'fixed_amount|int|true||固定抵扣额度，当抵扣类型为2时有效',

        'exchange_percent' => 'exchange_percent|int|true||积分商品价格兑换的比例',

        'priority' => 'priority|int|true||优先级，数字越小，优先级越高，0为最高优先级',

        'status' => 'status|int|true||规则状态：1 有效，0 无效',

        'start_date' => 'start_date|int|true||有效期起始日, 0为一直有效',
        
        'expire_date' => 'expire_date|int|true||有效期截止日, 0为一直有效',

      ),

      'queryList' => array(

        'name' => 'name|string|false||规则名称',

        'operator' => 'operator|int|false||创建人',

        'channel_type' => 'channel_type|int|false||使用渠道类型：0 全渠道，1 门店，2 线上消费',

        'channel' => 'channel|int|false||使用渠道id: 0 全部，门店id， 线上商城：9999',

        'action' => 'action|string|false||请求操作',

        'use_type' => 'use_type|int|false||使用类型：1 抵扣，2 兑换;',

        'deduction_type' => 'deduction_type|int|false||抵扣类型：1 按比例抵扣，2 固定抵扣',
      
        'limit' => 'limit|int|false||抵扣额度限制，当使用类型为1有效',

        'deduction_percent' => 'deduction_percent|int|false||抵扣比例，积分与人民币（单位：元）的抵扣比例，抵扣类型为1时有效',

        'fixed_amount' => 'fixed_amount|int|false||固定抵扣额度，当抵扣类型为2时有效',

        'exchange_percent' => 'exchange_percent|int|false||积分商品价格兑换的比例',

        'priority' => 'priority|int|false||优先级，数字越小，优先级越高，0为最高优先级',

        'status' => 'status|int|false||规则状态：1 有效，0 无效',

        'start_date' => 'start_date|int|false||有效期起始日, 0为一直有效',
        
        'expire_date' => 'expire_date|int|false||有效期截止日, 0为一直有效',

        'created_at' => 'created_at|string|false||创建时间',

        'updated_at' => 'updated_at|string|false||更新时间',

        'deleted_at' => 'deleted_at|int|false||删除时间',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|20|每页数据条数'

      ),

      'update' => array(

        'id' => 'id|int|true||规则id',

        'name' => 'name|string|false||规则名称',

        'operator' => 'operator|int|false||创建人',

        'channel_type' => 'channel_type|int|false||使用渠道类型：0 全渠道，1 门店，2 线上消费',

        'channel' => 'channel|int|false||使用渠道id: 0 全部，门店id， 线上商城：9999',

        'action' => 'action|string|false||请求操作',

        'use_type' => 'use_type|int|false||使用类型：1 抵扣，2 兑换;',

        'deduction_type' => 'deduction_type|int|false||抵扣类型：1 按比例抵扣，2 固定抵扣',
      
        'limit' => 'limit|int|false||抵扣额度限制，当使用类型为1有效',

        'deduction_percent' => 'deduction_percent|int|false||抵扣比例，积分与人民币（单位：元）的抵扣比例，抵扣类型为1时有效',

        'fixed_amount' => 'fixed_amount|int|false||固定抵扣额度，当抵扣类型为2时有效',

        'exchange_percent' => 'exchange_percent|int|false||积分商品价格兑换的比例',

        'priority' => 'priority|int|false||优先级，数字越小，优先级越高，0为最高优先级',

        'status' => 'status|int|false||规则状态：1 有效，0 无效',

        'start_date' => 'start_date|int|false||有效期起始日, 0为一直有效',
        
        'expire_date' => 'expire_date|int|false||有效期截止日, 0为一直有效',

        'deleted_at' => 'deleted_at|int|false||删除时间 1-删除',
      
      ),

      'getDetail' => array(

        'id' => 'id|int|true||规则id',
      
      ),

      'enable' => array(

        'id' => 'id|int|true||规则id',
      
      ),

      'disable' => array(

        'id' => 'id|int|true||规则id',
      
      ),
      
    ));

  }

  /**
   * 新增用户消费积分规则
   * @desc 新增用户消费积分规则
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function add() {

    $regulation = array(
      'name' => 'required',
      'coupon_type_id' => 'required',
      'remarks' => 'required',
      'start_date' => 'required',
      'end_date' => 'required',
    );

    $params = $this->retriveRuleParams('add');

    \App\Verification($params, $regulation);

    return $this->dm->add($params);
  
  }

  /**
   * 修改用户消费积分规则
   * @desc 修改用户消费积分规则
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
   * 查询用户消费积分规则详情
   * @desc 查询用户消费积分规则详情
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
   * 用户消费积分规则启用
   * @desc 用户消费积分规则启用
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function enable() {

    $regulation = array(
      'id' => 'required',
    );

    $conditions = $this->retriveRuleParams('enable');

    \App\Verification($conditions, $regulation);

    return $this->dm->enable($conditions);
  
  }

  /**
   * 用户消费积分规则禁用
   * @desc 用户消费积分规则禁用
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function disable() {

    $regulation = array(
      'id' => 'required',
    );

    $conditions = $this->retriveRuleParams('disable');

    \App\Verification($conditions, $regulation);

    return $this->dm->disable($conditions);
  
  }

  /**
   * 查询用户消费积分规则列表
   * @desc 查询用户消费积分规则列表
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

}
