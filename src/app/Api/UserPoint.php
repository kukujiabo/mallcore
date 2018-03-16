<?php
namespace App\Api;

use PhalApi\Api;
use App\Domain\UserPointDm;
use PhalApi\Exception;

/**
 * 2.5 积分接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-09-25
 */

class UserPoint extends BaseApi {

  /**
   * 接口参数规则
   */
  public function getRules() {

    return $this->rules(array(

      'add' => array(

        'uid' => 'uid|int|true||所属用户id',

        'full_points' => 'full_points|int|true||积分总额',

        'rest_points' => 'rest_points|int|true||积分剩余额度',

        'rule_name' => 'rule_name|string|true||规则名称',

        'object_id' => 'object_id|string|true||关联对象id',

        'channel' => 'channel|int|true||渠道id',

        'channel_type' => 'channel_type|int|true||渠道类型：1 线下门店，2 线上商城',

        'status' => 'status|int|true||积分记录有效性：1 有效，0 失效',

        'start_date' => 'start_date|int|true||有效期起始日（时间戳）, 0为一直有效',
        
        'expire_date' => 'expire_date|int|true||有效期截止日（时间戳）, 0为一直有效',

        'remarks' => 'remarks|string|false||备注',

      ),

      'queryList' => array(

        'way' => 'way|int|true|1|途径 1-前台会员 2-后台管理员',

        'token' => 'token|string|false||用户令牌（way为1则必传）',

        'id' => 'id|string|false||积分记录id',

        'uid' => 'uid|string|false||用户表序号',

        'full_points' => 'full_points|string|false||积分总额',

        'rest_points' => 'rest_points|string|false||积分剩余额度',

        'rule_name' => 'rule_name|string|false||规则名称',

        'object_id' => 'object_id|string|false||关联对象id',

        'channel' => 'channel|string|false||渠道id',

        'channel_type' => 'channel_type|string|false||渠道类型：1 线下门店，2 线上商城',

        'status' => 'status|string|false||积分记录有效性：1 有效，0 失效',

        'start_date' => 'start_date|string|false||有效期起始日（时间戳）, 0为一直有效',
        
        'expire_date' => 'expire_date|string|false||有效期截止日（时间戳）, 0为一直有效',
        
        'remarks' => 'remarks|string|false||备注',

        'created_at' => 'created_at|string|false||创建时间',

        'updated_at' => 'updated_at|string|false||更新时间',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|20|每页数据条数'

      ),

      'queryCount' => array(

        'way' => 'way|int|true|1|途径 1-前台会员 2-后台管理员',

        'token' => 'token|string|false||用户令牌（way为1则必传）',

        'id' => 'id|string|false||积分记录id',

        'uid' => 'uid|string|false||用户表序号',

        'full_points' => 'full_points|string|false||积分总额',

        'rest_points' => 'rest_points|string|false||积分剩余额度',

        'rule_name' => 'rule_name|string|false||规则名称',

        'object_id' => 'object_id|string|false||关联对象id',

        'channel' => 'channel|string|false||渠道id',

        'channel_type' => 'channel_type|string|false||渠道类型：1 线下门店，2 线上商城',

        'status' => 'status|string|false||积分记录有效性：1 有效，0 失效',

        'start_date' => 'start_date|string|false||有效期起始日（时间戳）, 0为一直有效',
        
        'expire_date' => 'expire_date|string|false||有效期截止日（时间戳）, 0为一直有效',
        
        'remarks' => 'remarks|string|false||备注',

        'created_at' => 'created_at|string|false||创建时间',

        'updated_at' => 'updated_at|string|false||更新时间',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|20|每页数据条数'

      ),

      'update' => array(

        'id' => 'id|string|true||积分记录id',

        'uid' => 'uid|string|false||用户表序号',

        'full_points' => 'full_points|string|false||积分总额',

        'rest_points' => 'rest_points|string|false||积分剩余额度',

        'rule_name' => 'rule_name|string|false||规则名称',

        'object_id' => 'object_id|string|false||关联对象id',

        'channel' => 'channel|string|false||渠道id',

        'channel_type' => 'channel_type|string|false||渠道类型：1 线下门店，2 线上商城',

        'status' => 'status|string|false||积分记录有效性：1 有效，0 失效',

        'start_date' => 'start_date|string|false||有效期起始日（时间戳）, 0为一直有效',
        
        'expire_date' => 'expire_date|string|false||有效期截止日（时间戳）, 0为一直有效',
        
        'remarks' => 'remarks|string|false||备注',
      
      ),

      'getDetail' => array(

        'way' => 'way|int|true|1|途径 1-前台会员 2-后台管理员',

        'token' => 'token|string|false||用户令牌（way为1则必传）',

        'id' => 'id|string|false||积分记录id',

        'uid' => 'uid|string|false||用户表序号',

        'full_points' => 'full_points|string|false||积分总额',

        'rest_points' => 'rest_points|string|false||积分剩余额度',

        'rule_name' => 'rule_name|string|false||规则名称',

        'object_id' => 'object_id|string|false||关联对象id',

        'channel' => 'channel|string|false||渠道id',

        'channel_type' => 'channel_type|string|false||渠道类型：1 线下门店，2 线上商城',

        'status' => 'status|string|false||积分记录有效性：1 有效，0 失效',

        'start_date' => 'start_date|string|false||有效期起始日（时间戳）, 0为一直有效',
        
        'expire_date' => 'expire_date|string|false||有效期截止日（时间戳）, 0为一直有效',
        
        'remarks' => 'remarks|string|false||备注',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',
      
      ),

      'grant' => array(

        'token' => 'token|string|true||用户令牌',
      
        'rid' => 'rid|int|true||规则id',
      
        'uid' => 'uid|int|true||会员uid'
      
      )
      
    ));

  }

  /**
   * 新增积分记录
   * @desc 新增用户积分记录
   *
   * @return int ret 操作状态：200表示成功
   * @return int data 表序号
   * @return string msg 错误提示
   */
  public function add() {

    $regulation = array(
      'uid' => 'required',
      'full_points' => 'required',
      'rest_points' => 'required',
      'rule_name' => 'required',
      'object_id' => 'required',
      'channel' => 'required',
      'channel_type' => 'required',
      'status' => 'required',
      'start_date' => 'required',
      'expire_date' => 'required',
    );

    $params = $this->retriveRuleParams('add');

    \App\Verification($params, $regulation);

    return $this->dm->add($params);
  
  }

  /**
   * 修改积分记录
   * @desc 修改用户积分记录
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
   * 查询积分记录详情
   * @desc 查询用户积分记录详情
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.id 表序号
   * @return int data.uid 所属用户id
   * @return int data.full_points 积分总额
   * @return int data.rest_points 积分剩余额度
   * @return string data.rule_name 规则名称
   * @return string data.object_id 关联对象id
   * @return int data.channel 渠道id
   * @return int data.channel_type 渠道类型：1 线下门店，2 线上商城
   * @return int data.status 积分实例有效性：1 有效，0 失效
   * @return int data.start_date 有效起始日期（时间戳）, 0为立即可用
   * @return int data.expire_date 有效截止日期（时间戳）, 0位长期有效
   * @return string data.remarks 备注
   * @return string data.updated_at 更新时间
   * @return string data.created_at 创建时间
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
   * 查询积分记录列表
   * @desc 查询用户积分记录列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.total 数据总条数
   * @return int data.page 当前页码
   * @return int data.list[] 数据队列
   * @return int data.list[].id 表序号
   * @return int data.list[].uid 所属用户id
   * @return int data.list[].full_points 积分总额
   * @return int data.list[].rest_points 积分剩余额度
   * @return string data.list[].rule_name 规则名称
   * @return string data.list[].object_id 关联对象id
   * @return int data.list[].channel 渠道id
   * @return int data.list[].channel_type 渠道类型：1 线下门店，2 线上商城
   * @return int data.list[].status 积分实例有效性：1 有效，0 失效
   * @return int data.list[].start_date 有效起始日期（时间戳）, 0为立即可用
   * @return int data.list[].expire_date 有效截止日期（时间戳）, 0位长期有效
   * @return string data.list[].remarks 备注
   * @return string data.list[].updated_at 更新时间
   * @return string data.list[].created_at 创建时间
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
   * 查询积分记录总数
   * @desc 查询用户积分记录总数
   *
   * @return int ret 操作状态：200表示成功
   * @return int data 记录总数
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

  /**
   * 发放积分
   * @desc 发放积分
   *
   * @return int ret 操作状态：200表示成功
   * @return int data 记录总数
   * @return string msg 错误提示
   */
  public function grant() {

    return $this->dm->grant($this->retriveRuleParams(__FUNCTION__));
  
  }

}
