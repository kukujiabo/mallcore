<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\PushMessageDm;

/**
 * 2.7 推送消息接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-14
 */
class PushMessage extends BaseApi {

  /**
   * 接口参数规则
   */
  public function getRules() {

    return $this->rules(array(

      'add' => array(

        'uid' => 'uid|int|true||用户id',

        'content' => 'content|string|true||消息内容',

        'type' => 'type|int|true|1|渠道类型 1-通知 2-订单 3-余额 4-积分 5-优惠券',

        'price' => 'price|float|false||消费额度',

        'shop_id' => 'shop_id|int|false||店铺id',
        
        'shop_name' => 'shop_name|string|false||店铺名称',
        
        'order_sn' => 'order_sn|string|false||单号',

        'channel' => 'channel|int|false||渠道id',

        'remarks' => 'remarks|string|false||备注',

      ),

      'queryList' => array(
        
        'way'  => array('name' => 'way', 'type' => 'int', 'require' => true, 'default' => '1', 'desc' => '途径 1-前台会员 2-后台管理员'),

        'token'  => array('name' => 'token', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '用户令牌（way为1则必传）'),

        'id' => 'id|int|false||表序号',

        'uid' => 'uid|int|false||用户id',

        'shop_id' => 'shop_id|int|false||店铺id',

        'content' => 'content|string|false||消息内容',

        'type' => 'type|int|false||渠道类型 1-通知 2-订单 3-余额 4-积分 5-优惠券',

        'channel' => 'channel|int|false||渠道id',

        'remarks' => 'remarks|string|false||备注',

        'created_at' => 'created_at|string|false||创建时间',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|20|每页数据条数'

      ),

      'queryCount' => array(

        'id' => 'id|int|false||表序号',

        'uid' => 'uid|int|false||用户id',

        'shop_id' => 'shop_id|int|false||店铺id',

        'content' => 'content|string|false||消息内容',

        'type' => 'type|int|false||渠道类型 1-通知 2-订单 3-余额 4-积分 5-优惠券',
        
        'created_at' => 'created_at|string|false||创建时间',

        'channel' => 'channel|int|false||渠道id',

        'remarks' => 'remarks|string|false||备注',
      
      ),

      'update' => array(

        'id' => 'id|int|true||表序号',

        'uid' => 'uid|int|false||用户id',

        'shop_id' => 'shop_id|int|false||店铺id',

        'content' => 'content|string|false||消息内容',

        'type' => 'type|int|false||渠道类型 1-通知 2-订单 3-余额 4-积分 5-优惠券',

        'channel' => 'channel|int|false||渠道id',

        'remarks' => 'remarks|string|false||备注',
      
      ),

      'getDetail' => array(

        'way'  => array('name' => 'way', 'type' => 'int', 'require' => true, 'default' => '1', 'desc' => '途径 1-前台会员 2-后台管理员'),

        'token'  => array('name' => 'token', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '用户令牌（way为1则必传）'),

        'id' => 'id|int|false||表序号',

        'uid' => 'uid|int|false||用户id',

        'shop_id' => 'shop_id|int|false||店铺id',

        'content' => 'content|string|false||消息内容',

        'type' => 'type|int|false||渠道类型 1-通知 2-订单 3-余额 4-积分 5-优惠券',

        'created_at' => 'created_at|string|false||创建时间',

        'channel' => 'channel|int|false||渠道id',

        'remarks' => 'remarks|string|false||备注',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',
      
      ),
      
    ));

  }

  /**
   * 新增推送消息
   * @desc 新增推送消息
   *
   * @return int ret 操作状态：200表示成功
   * @return int data 返回id
   * @return string msg 错误提示
   */
  public function add() {

    $regulation = array(
      'uid' => 'required',
      'content' => 'required',
      'type' => 'required',
    );

    $params = $this->retriveRuleParams('add');

    \App\Verification($params, $regulation);

    return $this->dm->add($params);
  
  }

  /**
   * 修改推送消息
   * @desc 修改推送消息
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
   * 查询推送消息详情
   * @desc 查询推送消息详情
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.id 表序号
   * @return int data.uid 用户id
   * @return int data.shop_id 店铺id
   * @return int data.shop_name 店铺名称
   * @return int data.type 渠道类型 1-通知 2-订单 3-余额 4-积分 5-优惠券
   * @return string data.content 消息内容
   * @return string data.order_sn 单号
   * @return string data.pay_mode 支付方式
   * @return string data.price 消费额度（单位：元）
   * @return string data.created_at 创建时间
   * @return int data.channel 渠道id
   * @return string data.remarks 备注
   * @return string msg 错误提示
   */
  public function getDetail() {

    $regulation = array(
      'way' => 'required',
    );

    $conditions = $this->retriveRuleParams('getDetail');

    \App\Verification($conditions, $regulation);

    return $this->dm->getDetail($conditions);
  
  }

  /**
   * 查询推送消息列表
   * @desc 查询推送消息列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return array data.total 数据总条数
   * @return array data.page 当前页码
   * @return array data.list[] 结果参数集
   * @return int data.list[].id 表序号
   * @return int data.list[].uid 用户id
   * @return int data.list[].shop_id 店铺id
   * @return int data.list[].shop_name 店铺名称
   * @return int data.list[].type 类型 1-通知 2-订单 3-余额 4-积分 5-优惠券
   * @return string data.list[].content 消息内容
   * @return string data.list[].order_sn 单号
   * @return string data.list[].pay_mode 支付方式
   * @return string data.list[].price 消费额度（单位：元）
   * @return string data.list[].created_at 创建时间
   * @return int data.list[].channel 渠道id
   * @return string data.list[].remarks 备注
   * @return string msg 错误提示
   */
  public function queryList() {

    $conditions = $this->retriveRuleParams('queryList');

    $regulation = array(
      'way' => 'required',
    );

    \App\Verification($conditions, $regulation);

    return $this->dm->queryList($conditions);

  }

  /**
   * 查询推送消息数量
   * @desc 查询推送消息数量
   *
   * @return int ret 操作状态：200表示成功
   * @return int data 数据条数
   * @return string msg 错误提示
   */
  public function queryCount() {

    $conditions = $this->retriveRuleParams('queryCount');
  
    $regulation = array();

    \App\Verification($conditions, $regulation);

    return $this->dm->queryCount($conditions);
  
  }

}
