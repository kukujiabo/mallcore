<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\MemberAccountDm;

/**
 * 3.1 会员账户接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-07
 */
class MemberAccount extends BaseApi {

  public function getRules() {

    return $this->rules(array(

      'add' => array(

        'uid' => 'uid|int|true||会员uid',

        'shop_id' => 'shop_id|int|false||店铺ID，为0则表示所有门店',
      
        'point' => 'point|int|false|0|会员积分',

        'balance' => 'balance|float|false|0.00|余额',
        
        'coin' => 'coin|string|false|0|购物币',

        'member_cunsum' => 'member_cunsum|float|false|0.00|会员消费',

        'member_sum_point' => 'member_sum_point|int|false|0|会员累计积分',

      ),

      'queryList' => array(

        'id' => 'id|string|false||表序号',

        'uid' => 'uid|string|false||会员uid',

        'shop_id' => 'shop_id|string|false||店铺ID，为0则表示所有门店',
      
        'point' => 'point|string|false||会员积分',

        'balance' => 'balance|string|false||余额',
        
        'coin' => 'coin|string|false||购物币',

        'member_cunsum' => 'member_cunsum|string|false||会员消费',

        'member_sum_point' => 'member_sum_point|string|false||会员累计积分',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|20|每页数据条数'

      ),

      'queryCount' => array(

        'id' => 'id|string|false||表序号',

        'uid' => 'uid|string|false||会员uid',

        'shop_id' => 'shop_id|string|false||店铺ID，为0则表示所有门店',
      
        'point' => 'point|string|false||会员积分',

        'balance' => 'balance|string|false||余额',
        
        'coin' => 'coin|string|false||购物币',

        'member_cunsum' => 'member_cunsum|string|false||会员消费',

        'member_sum_point' => 'member_sum_point|string|false||会员累计积分',
      
      ),

      'update' => array(

        'id' => 'id|string|false||表序号',

        'uid' => 'uid|string|false||会员uid',

        'shop_id' => 'shop_id|string|false||店铺ID，为0则表示所有门店',
      
        'point' => 'point|string|false||会员积分',

        'balance' => 'balance|string|false||余额',
        
        'coin' => 'coin|string|false||购物币',

        'member_cunsum' => 'member_cunsum|string|false||会员消费',

        'member_sum_point' => 'member_sum_point|string|false||会员累计积分',
      
      ),

      'getPossDetail' => array(

        'token' => 'token|string|true||用户令牌',
      
      ),

      'getDetail' => array(

        'way' => 'way|string|true|1|途径 1-前台会员 2-后台管理员',

        'token' => 'token|string|false||用户令牌（way为1则必传）',

        'id' => 'id|string|false||表序号',

        'uid' => 'uid|string|false||会员uid',

        'shop_id' => 'shop_id|string|false||店铺ID，为0则表示所有门店',
      
        'point' => 'point|string|false||会员积分',

        'balance' => 'balance|string|false||余额',
        
        'coin' => 'coin|string|false||购物币',

        'member_cunsum' => 'member_cunsum|string|false||会员消费',

        'member_sum_point' => 'member_sum_point|string|false||会员累计积分',
      
      ),

      'addMoney' => array(
      
        'uid' => 'uid|string|true||用户id',

        'money' => 'money|float|true||添加金额'
      
      ),

      'offlineUseMoney' => array(
      
        'mobile' => 'mobile|string|true||用户手机号',

        'money' => 'money|float|true||金额',

        'orderId' => 'orderId|string|true||订单号',

        'remark' => 'remark|string|false||备注'
      
      ),

      'offlineChargeMoney' => array(
      
        'mobile' => 'mobile|string|true||会员手机号',

        'money' => 'money|float|true||充值金额',

        'remark' => 'remark|string|false||备注'
      
      ),

      'posUpdateMemberCardId' => array(
      
        'mobile' => 'mobile|string|true||会员手机号',

        'card_id' => 'card_id|string|true||会员新卡号'
      
      ),
      
    ));

  }

  /**
   * pos修改卡号同步线上
   * @desc pos修改卡号同步线上
   *
   * @return int ret 操作状态：200表示成功
   * @return int data 修改条数
   * @return string msg 错误提示
   */
  public function posUpdateMemberCardId() {

    $params = $this->retriveRuleParams('posUpdateMemberCardId');

    $regulation = array(

      'mobile' => 'required|phone',

      'card_id' => 'required',

    );

    \App\Verification($params, $regulation);

    return $this->dm->posUpdateMemberCardId($params);
  
  }

  /**
   * 新增会员账户
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
    );

    \App\Verification($params, $regulation);

    return $this->dm->add($params);
  
  }

  /**
   * 修改会员账户
   * @desc 修改会员账户
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 修改条数
   * @return string msg 错误提示
   */
  public function update() {

    $params = $this->retriveRuleParams('update');

    $regulation = array(
    );

    \App\Verification($params, $regulation);

    return $this->dm->update($params);
  
  }

  /**
   * 查询Poss会员账户详情
   * @desc 查询Poss会员账户详情
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.id 表序号
   * @return int data.uid 会员uid
   * @return int data.shop_id 店铺ID
   * @return int data.point 会员积分 
   * @return float data.balance 余额（单位：元）
   * @return int data.coin 购物币
   * @return float data.member_cunsum 会员消费（单位：元）
   * @return int data.member_sum_point 会员累计积分
   * @return string data.card_id 会员卡号
   * @return string data.card_id_qr_code 二维码图片路径
   * @return string data.bar_code 条形码二维码图片路径
   * @return string msg 错误提示
   */
  public function getPossDetail() {

    $conditions = $this->retriveRuleParams('getPossDetail');

    $regulation = array(

      'token' => 'required',
      
    );

    \App\Verification($conditions, $regulation);

    return $this->dm->getPossDetail($conditions);

  }

  /**
   * 查询会员账户详情
   * @desc 查询会员账户详情
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.id 表序号
   * @return int data.uid 会员uid
   * @return int data.shop_id 店铺ID
   * @return int data.point 会员积分 
   * @return float data.balance 余额（单位：元）
   * @return int data.coin 购物币
   * @return float data.member_cunsum 会员消费（单位：元）
   * @return int data.member_sum_point 会员累计积分
   * @return string data.card_id 会员卡号
   * @return string data.card_id_qr_code 二维码图片路径
   * @return string data.bar_code 条形码二维码图片路径
   * @return string msg 错误提示
   */
  public function getDetail() {

    $conditions = $this->retriveRuleParams('getDetail');

    $regulation = array(

      'way' => 'required',
      
    );

    \App\Verification($conditions, $regulation);

    return $this->dm->getDetail($conditions);

  }

  /**
   * 查询会员账户列表
   * @desc 查询会员账户列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.total 数据总条数
   * @return int data.page 当前页码
   * @return array data.list[] 数据队列
   * @return int data.list[].id 表序号
   * @return int data.list[].uid 会员uid
   * @return int data.list[].shop_id 店铺ID
   * @return int data.list[].point 会员积分 
   * @return float data.list[].balance 余额（单位：元）
   * @return int data.list[].coin 购物币
   * @return float data.list[].member_cunsum 会员消费（单位：元）
   * @return int data.list[].member_sum_point 会员累计积分
   * @return string data.list[].card_id 会员卡号
   * @return string data.list[].card_id_qr_code 二维码图片路径
   * @return string data.list[].bar_code 条形码二维码图片路径
   * @return string msg 错误提示
   */
  public function queryList() {

    $conditions = $this->retriveRuleParams('queryList');

    $regulation = array();

    \App\Verification($conditions, $regulation);

    return $this->dm->queryList($conditions);

  }

  /**
   * 查询会员账户数量
   * @desc 查询会员账户数量
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

  /**
   * 添加会员帐户余额
   * @desc 添加会员帐户余额
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 条数
   * @return string msg 错误提示
   */
  public function addMoney() {

    $data = $this->retriveRuleParams('addMoney');
  
    return $this->dm->addMoney($data);
  
  }

  /**
   * 线下消费使用余额
   * @desc 线下消费使用帐户余额
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 条数
   * @return string msg 错误提示
   */
  public function offlineUseMoney() {
  
    $data = $this->retriveRuleParams('offlineUseMoney');

    return $this->dm->offlineUseMoney($data);
  
  }

  /**
   * 线下充值
   * @desc 线下充值接口
   */
  public function offlineChargeMoney() {
  
    $data = $this->retriveRuleParams('offlineChargeMoney');

    return $this->dm->offlineChargeMoney($data);
  
  }

}
