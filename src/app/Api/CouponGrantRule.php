<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\CouponGrantRuleDm;

/**
 * 7.3 优惠券发放规则接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-10-18
 */
class CouponGrantRule extends BaseApi {

  /**
   * 接口参数规则
   */
  public function getRules() {

    return $this->rules(array(

      'add' => array(

        'name' => 'name|string|true||规则名称',

        'operator_id' => 'operator_id|int|false||操作员id',

        'action_id' => 'action_id|int|false||用户操作id',

        'channel_type' => 'channel_type|int|false||渠道类型',

        'channel' => 'channel|int|false||渠道id',
      
        'coupon_type_id' => 'coupon_type_id|int|true||优惠券种类id',

        'grant_total_num' => 'grant_total_num|int|false|0|发放总量，为0时不限制',

        'grant_individual_num' => 'grant_individual_num|int|false|0|个人领取数量，为0不限制',

        'remarks' => 'remarks|string|true||备注',

        'start_date' => 'start_date|int|true|0|开始时间，为0立即开始',

        'end_date' => 'end_date|int|true|0|结束时间，为0长期有效',
        
        'status' => 'status|int|true||规则状态：1 有效，0 无效',

      ),

      'queryList' => array(

        'name' => 'name|string|false||规则名称',

        'operator_id' => 'operator_id|int|false||操作员id',

        'action_id' => 'action_id|int|false||用户操作id',

        'channel_type' => 'channel_type|int|false||渠道类型',

        'channel' => 'channel|int|false||渠道id',
      
        'coupon_type_id' => 'coupon_type_id|int|false||优惠券种类id',

        'grant_total_num' => 'grant_total_num|int|false||发放总量，为0时不限制',

        'grant_individual_num' => 'grant_individual_num|int|false||个人领取数量，为0不限制',

        'start_date' => 'start_date|int|false||开始时间，为0立即开始',

        'end_date' => 'end_date|int|false||结束时间，为0长期有效',
        
        'status' => 'status|int|false||规则状态：1 有效，0 无效',

        'created_at' => 'created_at|string|false||创建时间',

        'updated_at' => 'updated_at|string|false||更新时间',

        'deleted_at' => 'deleted_at|int|false||删除时间',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|20|每页数据条数'

      ),

      'queryCount' => array(

        'name' => 'name|string|false||规则名称',

        'operator_id' => 'operator_id|int|false||操作员id',

        'action_id' => 'action_id|int|false||用户操作id',

        'channel_type' => 'channel_type|int|false||渠道类型',

        'channel' => 'channel|int|false||渠道id',
      
        'coupon_type_id' => 'coupon_type_id|int|false||优惠券种类id',

        'grant_total_num' => 'grant_total_num|int|false||发放总量，为0时不限制',

        'grant_individual_num' => 'grant_individual_num|int|false||个人领取数量，为0不限制',

        'start_date' => 'start_date|int|false||开始时间，为0立即开始',

        'end_date' => 'end_date|int|false||结束时间，为0长期有效',
        
        'status' => 'status|int|false||规则状态：1 有效，0 无效',

        'created_at' => 'created_at|string|false||创建时间',

        'updated_at' => 'updated_at|string|false||更新时间',

        'deleted_at' => 'deleted_at|int|false||删除时间',
      
      ),

      'update' => array(

        'id' => 'id|int|true||规则id',

        'name' => 'name|string|false||规则名称',

        'operator_id' => 'operator_id|int|false||操作员id',

        'action_id' => 'action_id|int|false||用户操作id',

        'channel_type' => 'channel_type|int|false||渠道类型',

        'channel' => 'channel|int|false||渠道id',
      
        'coupon_type_id' => 'coupon_type_id|int|false||优惠券种类id',

        'grant_total_num' => 'grant_total_num|int|false||发放总量，为0时不限制',

        'grant_individual_num' => 'grant_individual_num|int|false||个人领取数量，为0不限制',

        'start_date' => 'start_date|int|false||开始时间，为0立即开始',

        'end_date' => 'end_date|int|false||结束时间，为0长期有效',
        
        'status' => 'status|int|false||规则状态：1 有效，0 无效',

        'deleted_at' => 'deleted_at|int|false||删除时间',
      
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
   * 新增优惠券发放规则
   * @desc 新增优惠券发放规则
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function add() {

    $params = $this->retriveRuleParams('add');

    $regulation = array(
      'name' => 'required',
      'coupon_type_id' => 'required',
      'remarks' => 'required',
      'start_date' => 'required',
      'end_date' => 'required',
    );

    \App\Verification($params, $regulation);

    return $this->dm->add($params);
  
  }

  /**
   * 修改优惠券发放规则
   * @desc 修改优惠券发放规则
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function update() {

    $params = $this->retriveRuleParams('update');

    $regulation = array(
      'id' => 'required',
    );

    \App\Verification($params, $regulation);

    return $this->dm->update($params);
  
  }

  /**
   * 查询优惠券发放规则详情
   * @desc 查询优惠券发放规则详情
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function getDetail() {

    $conditions = $this->retriveRuleParams('getDetail');

    $regulation = array(
      'id' => 'required',
    );

    \App\Verification($conditions, $regulation);

    return $this->dm->getDetail($conditions);
  
  }

  /**
   * 优惠券发放规则启用
   * @desc 优惠券发放规则启用
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function enable() {

    $conditions = $this->retriveRuleParams('enable');

    $regulation = array(
      'id' => 'required',
    );

    \App\Verification($conditions, $regulation);

    return $this->dm->enable($conditions);
  
  }

  /**
   * 优惠券发放规则禁用
   * @desc 优惠券发放规则禁用
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function disable() {

    $conditions = $this->retriveRuleParams('disable');

    $regulation = array(
      'id' => 'required',
    );

    \App\Verification($conditions, $regulation);

    return $this->dm->disable($conditions);
  
  }

  /**
   * 查询优惠券发放规则列表
   * @desc 查询优惠券发放规则列表
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
   * 查询优惠券发放规则数量
   * @desc 查询优惠券发放规则数量
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
