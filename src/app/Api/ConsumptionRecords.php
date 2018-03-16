<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\ConsumptionRecordsDm;
use PhalApi\Exception;

/**
 * 3.3 用户消费记录接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-20
 */
class ConsumptionRecords extends BaseApi {

  public function getRules() {

    return $this->rules(array(

      'add' => array(

        'uid' => 'uid|int|true||用户id',
      
        'sn' => 'sn|string|true||流水号',
        
        'seq' => 'seq|string|true||消费相关单号',

        'phone' => 'phone|string|true||用户手机号',

        'module' => 'module|int|true||模块',

        'title' => 'title|int|true||标题',

        'money' => 'money|float|true||消费金额',

        'remark' => 'remark|string|true||备注',

        'status' => 'status|int|true||记录状态',

      ),

      'queryPossList' => array(

        'token' => 'token|string|true||用户令牌',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|20|每页数据条数'

      ),

      'queryList' => array(

        'way' => 'way|int|true|1|类型 1-前台会员 2-后台管理员',

        'token' => 'token|string|false||用户令牌',

        'id' => 'id|string|false||表序号',

        'uid' => 'uid|string|false||用户id',
      
        'sn' => 'sn|string|false||流水号',
        
        'seq' => 'seq|string|false||消费相关单号',

        'phone' => 'phone|string|false||用户手机号',

        'module' => 'module|string|false||模块',

        'title' => 'title|string|false||标题',

        'money' => 'money|string|false||消费金额',

        'remark' => 'remark|string|false||备注',

        'status' => 'status|string|false||记录状态',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|20|每页数据条数'

      ),

      'getDetail' => array(

        'way' => 'way|int|true|1|类型 1-前台会员 2-后台管理员',
        
        'token' => 'token|string|false||用户令牌',

        'id' => 'id|string|false||表序号',

        'uid' => 'uid|string|false||用户id',
      
        'sn' => 'sn|string|false||流水号',
        
        'seq' => 'seq|string|false||消费相关单号',

        'phone' => 'phone|string|false||用户手机号',

        'module' => 'module|string|false||模块',

        'title' => 'title|string|false||标题',

        'money' => 'money|string|false||消费金额',

        'remark' => 'remark|string|false||备注',

        'status' => 'status|string|false||记录状态',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',

      ),

      'getPossDetail' => array(
        
        'token' => 'token|string|true||用户令牌',

        'id' => 'id|string|true||表序号',

      ),

      'queryCount' => array(

        'id' => 'id|string|false||表序号',

        'uid' => 'uid|string|false||用户id',
      
        'sn' => 'sn|string|false||流水号',
        
        'seq' => 'seq|string|false||消费相关单号',

        'phone' => 'phone|string|false||用户手机号',

        'module' => 'module|string|false||模块',

        'title' => 'title|string|false||标题',

        'money' => 'money|string|false||消费金额',

        'remark' => 'remark|string|false||备注',

        'status' => 'status|string|false||记录状态',
      
      ),

      'update' => array(

        'id' => 'id|string|true||表序号',

        'uid' => 'uid|string|false||用户id',
      
        'sn' => 'sn|string|false||流水号',
        
        'seq' => 'seq|string|false||消费相关单号',

        'phone' => 'phone|string|false||用户手机号',

        'module' => 'module|string|false||模块',

        'title' => 'title|string|false||标题',

        'money' => 'money|string|false||消费金额',

        'remark' => 'remark|string|false||备注',

        'status' => 'status|string|false||记录状态',
      
      ),
      
    ));

  }

  /**
   * 新增用户消费记录
   * @desc 在用户使用优惠券的时候调用
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 类型Id
   * @return string msg 错误提示
   */
  public function add() {

    $params = $this->retriveRuleParams('add');

    $regulation = array(
      
      'uid' => 'required',
      
      'sn' => 'required',
      
      'seq' => 'required',
      
      'phone' => 'required|phone',
      
      'module' => 'required',
      
      'title' => 'required',
      
      'money' => 'required',
      
      'remark' => 'required',
      
      'status' => 'required',

    );

    \App\Verification($params, $regulation);

    return $this->dm->add($params);
  
  }

  /**
   * 修改用户消费记录
   * @desc 修改用户消费记录
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 修改条数
   * @return string msg 错误提示
   */
  public function update() {

    $params = $this->retriveRuleParams('update');

    $regulation = array(

      'id' => 'required',
      
      'phone' => 'phone',

    );

    \App\Verification($params, $regulation);

    return $this->dm->update($params);
  
  }

  /**
   * 查询Poss用户消费记录详情
   * @desc 查询Poss用户消费记录列表（所有的金额单位都为：元）
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.id 表序号
   * @return string data.seq 消费相关单号
   * @return string data.title 标题
   * @return float data.money 消费金额（单位：元）
   * @return string data.created_at 创建时间
   * @return array data.goods[] 商品队列
   * @return int data.goods[].goods_name 商品名称
   * @return int data.goods[].num 商品数量
   * @return int data.goods[].price 单价
   * @return int data.goods[].goods_money 小计
   * @return int data.pay[] 支付方式队列
   * @return int data.pay[].pay_mode 支付方式
   * @return int data.pay[].price 支付金额
   * @return string msg 错误提示
   */
  public function getPossDetail() {

    $conditions = $this->retriveRuleParams('getPossDetail');

    $regulation = array(

      'token' => 'required',
      
      'id' => 'required',

    );

    \App\Verification($conditions, $regulation);

    return $this->dm->getPossDetail($conditions);

  }

  /**
   * 查询用户消费记录详情
   * @desc 查询用户消费记录列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.id 表序号
   * @return int data.uid 用户id
   * @return string data.sn 流水号
   * @return string data.seq 消费相关单号
   * @return string data.phone 用户手机号
   * @return string data.module 模块
   * @return string data.title 标题
   * @return float data.money 消费金额（单位：元）
   * @return string data.remark 备注
   * @return int data.status 记录状态
   * @return string data.created_at 创建时间
   * @return string msg 错误提示
   */
  public function getDetail() {

    $conditions = $this->retriveRuleParams('getDetail');

    $regulation = array(

      'way' => 'required',
      
      'phone' => 'phone',

    );

    \App\Verification($conditions, $regulation);

    return $this->dm->getDetail($conditions);

  }

  /**
   * 查询Poss用户消费记录列表
   * @desc 查询Poss用户消费记录列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.total 数据总条数
   * @return int data.page 当前页码
   * @return array data.list[] 用户消费记录队列
   * @return int data.list[].id 表序号
   * @return string data.list[].seq 消费相关单号
   * @return string data.list[].title 标题
   * @return float data.list[].money 消费金额（单位：元）
   * @return string data.list[].created_at 创建时间
   * @return string msg 错误提示
   */
  public function queryPossList() {

    $conditions = $this->retriveRuleParams('queryPossList');

    $regulation = array(

      'token' => 'required',
      
      'page' => 'required',
      
      'page_size' => 'required',

    );

    \App\Verification($conditions, $regulation);

    return $this->dm->queryPossList($conditions);

  }

  /**
   * 查询用户消费记录列表
   * @desc 查询用户消费记录列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.total 数据总条数
   * @return int data.page 当前页码
   * @return array data.list[] 用户消费记录队列
   * @return int data.list[].id 表序号
   * @return int data.list[].uid 用户id
   * @return string data.list[].sn 流水号
   * @return string data.list[].seq 消费相关单号
   * @return string data.list[].phone 用户手机号
   * @return string data.list[].module 模块
   * @return string data.list[].title 标题
   * @return float data.list[].money 消费金额（单位：元）
   * @return string data.list[].remark 备注
   * @return int data.list[].status 记录状态
   * @return string data.list[].created_at 创建时间
   * @return string msg 错误提示
   */
  public function queryList() {

    $conditions = $this->retriveRuleParams('queryList');

    $regulation = array(

      'way' => 'required',
      
      'phone' => 'phone',

    );

    \App\Verification($conditions, $regulation);

    return $this->dm->queryList($conditions);

  }

  /**
   * 查询用户消费记录数量
   * @desc 查询用户消费记录数量
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 条数
   * @return string msg 错误提示
   */
  public function queryCount() {

    $conditions = $this->retriveRuleParams('queryCount');
  
    $regulation = array(
      
      'phone' => 'phone',

    );

    \App\Verification($conditions, $regulation);

    return $this->dm->queryCount($conditions);
  
  }

}
