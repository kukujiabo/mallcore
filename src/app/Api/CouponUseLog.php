<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\CouponUseLogDm;

/**
 * 7.5 优惠券使用日志接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-10-18
 */
class CouponUseLog extends BaseApi {

  /**
   * 接口参数规则
   */
  public function getRules() {

    return $this->rules(array(

      'add' => array(

        'coupon_id' => 'coupon_id|int|true||优惠券id',
      
        'uid' => 'uid|int|true||用户id',

        'money' => 'money|float|false||优惠券面额',
        
        'percentage' => 'percentage|float|false||优惠券折扣',

        'channel_type' => 'channel_type|int|false||渠道类型',

        'channel' => 'channel|int|false||渠道id',

        'order_id' => 'order_id|int|false||订单id',

      ),

      'queryList' => array(

        'coupon_id' => 'coupon_id|int|false||优惠券id',
      
        'uid' => 'uid|int|false||用户id|',

        'money' => 'money|float|false||优惠券面额',
        
        'percentage' => 'percentage|float|false||优惠券折扣',

        'channel_type' => 'channel_type|int|false||渠道类型',

        'channel' => 'channel|int|false||渠道id',

        'order_id' => 'order_id|int|false||订单id',

        'created_at' => 'created_at|string|false||创建时间',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|20|每页数据条数'

      ),

      'queryCount' => array(

        'coupon_id' => 'coupon_id|int|false||优惠券id',
      
        'uid' => 'uid|int|false||用户id|',

        'money' => 'money|float|false||优惠券面额',
        
        'percentage' => 'percentage|float|false||优惠券折扣',

        'channel_type' => 'channel_type|int|false||渠道类型',

        'channel' => 'channel|int|false||渠道id',

        'order_id' => 'order_id|int|false||订单id',

        'created_at' => 'created_at|string|false||创建时间',
      
      )
      
    ));

  }

  /**
   * 新增优惠券使用日志
   * @desc 在用户使用优惠券的时候调用
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function add() {

    $regulation = array(
      'coupon_id' => 'required',
      'uid' => 'required',
    );

    $params = $this->retriveRuleParams('add');

    \App\Verification($params, $regulation);

    return $this->dm->add($params);
  
  }

  /**
   * 查询优惠券使用日志列表
   * @desc 查询优惠券使用日志列表
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
   * 查询优惠券使用日志数量
   * @desc 查询优惠券使用日志数量
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
