<?php
namespace App\Api;

use PhalApi\Api;
use App\Domain\CouponGrantLogDm;

/**
 * 7.2 优惠券发放记录接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-10-18
 */
class CouponGrantLog extends BaseApi {

  /**
   * 优惠券发放记录接口参数规则
   */
  public function getRules() {

    return $this->rules(array(

      'add' => array(

        'coupon_id' => 'coupon_id|int|true||优惠券id',
      
        'uid' => 'uid|int|true||用户id|',

        'rule_id' => 'rule_id|int|false||优惠券发放规则',
        
        'operator_id' => 'operator_id|int|false||操作员id',

        'channel_type' => 'channel_type|int|false||渠道类型',

        'channel' => 'channel|int|false||渠道id',

        'action' => 'action|string|false||操作uri',

      ),

      //查询优惠券记录列表
      'queryList' => array(

        'coupon_id' => 'coupon_id|int|false||优惠券id',

        'operator_id' => 'operator_id|int|false||操作员id',
      
        'uid' => 'uid|int|false||用户id|',

        'channel_type' => 'channel_type|int|false||渠道类型',

        'channel' => 'channel|int|false||渠道id',

        'rule_id' => 'rule_id|int|false||优惠券发放规则',

        'action' => 'action|string|false||操作uri',

        'created_at' => 'created_at|string|false||创建时间',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|20|每页数据条数'

      ),

      'queryCount' => array(

        'coupon_id' => 'coupon_id|int|false||优惠券id',
        
        'operator_id' => 'operator_id|int|false||操作员id',
      
        'uid' => 'uid|int|false||用户id|',

        'channel_type' => 'channel_type|int|false||渠道类型',

        'channel' => 'channel|int|false||渠道id',

        'rule_id' => 'rule_id|int|false||优惠券发放规则',

        'action' => 'action|string|false||操作uri',

        'created_at' => 'created_at|string|false||创建时间',
      
      ),

      'couponGrantUnionLog' => array(

        'token' => 'token|string|true||用户令牌',
      
        'member_name' => 'member_name|string|false||会员名称',

        'mobile' => 'mobile|string|false||手机号',

        'sequence' => 'sequence|string|false||流水号',

        'coupon_code' => 'coupon_code|string|false||优惠券编号',

        'coupon_name' => 'coupon_name|string|false||优惠券名称',

        'rule_id' => 'rule_id|int|false||发放规则id',

        'start_time' => 'start_time|string|false||发放开始时间',

        'end_time' => 'end_time|string|false||发放结束时间',

        'page' => 'page|int|true|1|页码',

        'pageSize' => 'pageSize|int|true|20|每页条数'
      
      )
      
    ));

  }

  /**
   * 新增优惠券发放记录
   * @desc 在赠送用户优惠券的时候调用
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
   * 查询优惠券发放记录列表
   * @desc 获取优惠券发放记录
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
   * 查询优惠券发放记录数量
   * @desc 查询优惠券发放记录数量
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

  /**
   * 优惠券发放日志联合信息
   * @desc 优惠券发放日志联合信息
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function couponGrantUnionLog() {
  
    return $this->dm->couponGrantUnionLog($this->retriveRuleParams(__FUNCTION__));
  
  }

}
