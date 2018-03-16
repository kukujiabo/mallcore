<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\OrderTakeOutAddressDm;

/**
 * 6.3 外卖订单地址接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-11
 */
class OrderTakeOutAddress extends BaseApi {

  public function getRules() {

    return $this->rules(array(

      'add' => array(

        'shop_id' => 'shop_id|int|true||店铺ID，为0则表示所有门店',
      
        'operator_id' => 'operator_id|int|true||操作员id',

        'deduction_type' => 'deduction_type|int|false||抵扣类型：1 折扣，2 现金，3 包邮',
        
        'coupon_name' => 'coupon_name|string|true||优惠券类型名称',

        'money' => 'money|int|false||发放面额',

        'percentage' => 'percentage|float|false|0|折扣',

        'count' => 'count|int|false|0|发放数量，0为无限制',

        'max_fetch' => 'max_fetch|int|false|0|每人最大领取个数 0无限制',

        'at_least' => 'at_least|float|false|0|满多少元使用 0代表无限制',

        'need_user_level' => 'need_user_level|int|false|0|领取人会员等级',

        'range_type' => 'range_type|int|false|1|使用范围0部分产品使用 1全场产品使用',

        'start_time' => 'start_time|string|true||有效日期开始时间',

        'end_time' => 'end_time|string|true||有效日期结束时间',

        'need_bind' => 'need_bind|int|false|0|是否需要绑定用户',

        'status' => 'status|int|false|1|状态：1 可用，2 失效',

        'is_show' => 'is_show|int|false|0|是否允许首页显示:0 不显示，1 显示',

      ),

      'queryList' => array(

        'coupon_type_id' => 'coupon_type_id|int|false||优惠券类型Id',

        'shop_id' => 'shop_id|int|false||店铺ID，为0则表示所有门店',
      
        'operator_id' => 'operator_id|int|false||操作员id',

        'deduction_type' => 'deduction_type|int|false||抵扣类型：1 折扣，2 现金，3 包邮',
        
        'coupon_name' => 'coupon_name|string|false||优惠券类型名称',

        'money' => 'money|int|false||发放面额',

        'percentage' => 'percentage|float|false||折扣',

        'count' => 'count|int|false||发放数量，0为无限制',

        'max_fetch' => 'max_fetch|int|false||每人最大领取个数 0无限制',

        'at_least' => 'at_least|float|false||满多少元使用 0代表无限制',

        'need_user_level' => 'need_user_level|int|false||领取人会员等级',

        'range_type' => 'range_type|int|false||使用范围0部分产品使用 1全场产品使用',

        'start_time' => 'start_time|string|false||有效日期开始时间',

        'end_time' => 'end_time|string|false||有效日期结束时间',

        'need_bind' => 'need_bind|int|false||是否需要绑定用户',

        'status' => 'status|int|false||状态：1 可用，2 失效',

        'is_show' => 'is_show|int|false||是否允许首页显示:0 不显示，1 显示',

        'created_at' => 'created_at|string|false||创建时间',
        
        'update_time' => 'update_time|string|false||修改时间',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|20|每页数据条数'

      ),

      'queryCount' => array(

        'coupon_type_id' => 'coupon_type_id|int|false||优惠券类型Id',

        'shop_id' => 'shop_id|int|false||店铺ID，为0则表示所有门店',
      
        'operator_id' => 'operator_id|int|false||操作员id',

        'deduction_type' => 'deduction_type|int|false||抵扣类型：1 折扣，2 现金，3 包邮',
        
        'coupon_name' => 'coupon_name|string|false||优惠券类型名称',

        'money' => 'money|int|false||发放面额',

        'percentage' => 'percentage|float|false||折扣',

        'count' => 'count|int|false||发放数量，0为无限制',

        'max_fetch' => 'max_fetch|int|false||每人最大领取个数 0无限制',

        'at_least' => 'at_least|float|false||满多少元使用 0代表无限制',

        'need_user_level' => 'need_user_level|int|false||领取人会员等级',

        'range_type' => 'range_type|int|false||使用范围0部分产品使用 1全场产品使用',

        'start_time' => 'start_time|string|false||有效日期开始时间',

        'end_time' => 'end_time|string|false||有效日期结束时间',

        'need_bind' => 'need_bind|int|false||是否需要绑定用户',

        'status' => 'status|int|false||状态：1 可用，2 失效',

        'is_show' => 'is_show|int|false||是否允许首页显示:0 不显示，1 显示',

        'created_at' => 'created_at|string|false||创建时间',
        
        'update_time' => 'update_time|string|false||修改时间',
      
      ),

      'update' => array(

        'coupon_type_id' => 'coupon_type_id|int|true||优惠券类型Id',

        'shop_id' => 'shop_id|int|false||店铺ID，为0则表示所有门店',
      
        'operator_id' => 'operator_id|int|false||操作员id',

        'deduction_type' => 'deduction_type|int|false||抵扣类型：1 折扣，2 现金，3 包邮',
        
        'coupon_name' => 'coupon_name|string|false||优惠券类型名称',

        'money' => 'money|int|false||发放面额',

        'percentage' => 'percentage|float|false||折扣',

        'count' => 'count|int|false||发放数量，0为无限制',

        'max_fetch' => 'max_fetch|int|false||每人最大领取个数 0无限制',

        'at_least' => 'at_least|float|false||满多少元使用 0代表无限制',

        'need_user_level' => 'need_user_level|int|false||领取人会员等级',

        'range_type' => 'range_type|int|false||使用范围0部分产品使用 1全场产品使用',

        'start_time' => 'start_time|string|false||有效日期开始时间',

        'end_time' => 'end_time|string|false||有效日期结束时间',

        'need_bind' => 'need_bind|int|false||是否需要绑定用户',

        'status' => 'status|int|false||状态：1 可用，2 失效',

        'is_show' => 'is_show|int|false||是否允许首页显示:0 不显示，1 显示',
      
      ),
      
    ));

  }

  /**
   * 新增外卖订单地址
   * @desc 
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 类型Id
   * @return string msg 错误提示
   */
  public function add() {

    $params = $this->retriveRuleParams('add');

    $regulation = array(
      'shop_id' => 'required',
      'operator_id' => 'required',
      'coupon_name' => 'required',
      'start_time' => 'required',
      'end_time' => 'required',
    );

    \App\Verification($params, $regulation);

    return $this->dm->add($params);
  
  }

  /**
   * 修改外卖订单地址
   * @desc 修改外卖订单地址
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 修改条数
   * @return string msg 错误提示
   */
  public function update() {

    $params = $this->retriveRuleParams('update');

    $regulation = array(
      'coupon_type_id' => 'required',
    );

    \App\Verification($params, $regulation);

    return $this->dm->update($params);
  
  }

  /**
   * 查询外卖订单地址详情
   * @desc 查询外卖订单地址列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.coupon_type_id 优惠券类型Id
   * @return int data.shop_id 店铺ID，为0则表示所有门店
   * @return int data.operator_id 
   * @return int data.deduction_type 抵扣类型：1 折扣，2 现金，3 包邮
   * @return string data.coupon_name 优惠券名称
   * @return float data.money 发放面额（单位：元）
   * @return int data.percentage 折扣
   * @return int data.count 发放数量，0为无限制
   * @return int data.max_fetch 每人最大领取个数，0无限制
   * @return float data.at_least 满多少元使用，0代表无限制
   * @return int data.need_user_level 领取人会员等级
   * @return int data.range_type 使用范围0部分产品使用，1全场产品使用
   * @return string data.start_time 有效日期开始时间
   * @return string data.end_time 有效日期结束时间
   * @return int data.need_bind 是否需要绑定用户:0-否，1-是
   * @return int data.status 状态：1 可用，2 失效
   * @return string data.create_time 创建时间
   * @return string data.update_time 修改时间
   * @return int data.is_show 是否允许首页显示0不显示1显示
   * @return int data.deleted_at 删除时间戳
   * @return string msg 错误提示
   */
  public function getDetail() {

    $conditions = $this->retriveRuleParams('getDetail');

    $regulation = array(

      'coupon_type_id' => 'required',

    );

    \App\Verification($conditions, $regulation);

    return $this->dm->getDetail($conditions);

  }

  /**
   * 查询外卖订单地址列表
   * @desc 查询外卖订单地址列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.total 数据总条数
   * @return int data.page 当前页码
   * @return array data.list[] 外卖订单地址队列
   * @return int data.list[].coupon_type_id 优惠券类型Id
   * @return int data.list[].shop_id 店铺ID，为0则表示所有门店
   * @return int data.list[].operator_id 
   * @return int data.list[].deduction_type 抵扣类型：1 折扣，2 现金，3 包邮
   * @return string data.list[].coupon_name 优惠券名称
   * @return float data.list[].money 发放面额（单位：元）
   * @return int data.list[].percentage 折扣
   * @return int data.list[].count 发放数量，0为无限制
   * @return int data.list[].max_fetch 每人最大领取个数，0无限制
   * @return float data.list[].at_least 满多少元使用，0代表无限制
   * @return int data.list[].need_user_level 领取人会员等级
   * @return int data.list[].range_type 使用范围0部分产品使用，1全场产品使用
   * @return string data.list[].start_time 有效日期开始时间
   * @return string data.list[].end_time 有效日期结束时间
   * @return int data.list[].need_bind 是否需要绑定用户:0-否，1-是
   * @return int data.list[].status 状态：1 可用，2 失效
   * @return string data.list[].create_time 创建时间
   * @return string data.list[].update_time 修改时间
   * @return int data.list[].is_show 是否允许首页显示0不显示1显示
   * @return int data.list[].deleted_at 删除时间戳
   * @return string msg 错误提示
   */
  public function queryList() {

    $conditions = $this->retriveRuleParams('queryList');

    $regulation = array();

    \App\Verification($conditions, $regulation);

    return $this->dm->queryList($conditions);

  }

  /**
   * 查询外卖订单地址数量
   * @desc 查询外卖订单地址数量
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 条数
   * @return string msg 错误提示
   */
  public function queryCount() {

    $conditions = $this->retriveRuleParams('queryCount');
  
    $regulation = array();

    \App\Verification($conditions, $regulation);

    return $this->dm->queryCount($conditions);
  
  }

}
