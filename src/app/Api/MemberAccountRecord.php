<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\MemberAccountRecordDm;
use PhalApi\Exception;

/**
 * 3.2 会员账户记录接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-07
 */
class MemberAccountRecord extends BaseApi {

  public function getRules() {

    return $this->rules(array(

      'add' => array(

        'uid' => 'uid|string|true||用户ID',

        'account_type' => 'account_type|string|true||账户类型1.积分2.余额3.购物币',
        
        'sign' => 'sign|string|true||正负号',

        'number' => 'number|float|true||数量（额度，单位：元）',

        'from_type' => 'from_type|string|true||产生方式1.商城订单2.订单退还3.兑换4.充值5.签到6.分享7.注册8.提现9提现退还',

        'type_name' => 'type_name|string|false||类型名称',
      
        'shop_id' => 'shop_id|int|false||店铺ID',
      
        'shop_name' => 'shop_name|string|false||店铺名称',

        'data_id' => 'data_id|string|false||相关表的数据ID',

        'text' => 'text|string|false||数据相关内容描述文本',

      ),

      'queryList' => array(

        'way' => 'way|string|true|1|途径 1-前台会员 2-后台管理员',

        'token' => 'token|string|false||用户令牌（way为1则必传）',

        'uid' => 'uid|string|false||用户ID',

        'id' => 'id|string|false||流水账表序号',
      
        'shop_id' => 'shop_id|string|false||店铺ID',

        'account_type' => 'account_type|string|false||账户类型1.积分2.余额3.购物币',
        
        'sign' => 'sign|string|false||正负号',

        'number' => 'number|float|false||数量（额度，单位：元）',

        'from_type' => 'from_type|string|false||产生方式1.商城订单2.订单退还3.兑换4.充值5.签到6.分享7.注册8.提现9提现退还',

        'data_id' => 'data_id|string|false||相关表的数据ID',

        'text' => 'text|string|false||数据相关内容描述文本',

        'create_time' => 'create_time|string|false||创建时间',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',

        'page' => 'page|string|true|1|页码',

        'page_size' => 'page_size|string|true|20|每页数据条数'

      ),

      'queryPossList' => array(

        'token' => 'token|string|true||用户令牌',

        'account_type' => 'account_type|int|true||1-积分 2-余额',

        'page' => 'page|string|true|1|页码',

        'page_size' => 'page_size|string|true|20|每页数据条数'

      ),

      'queryCount' => array(

        'id' => 'id|string|false||流水账表序号',

        'uid' => 'uid|string|false||用户ID',
      
        'shop_id' => 'shop_id|string|false||店铺ID',

        'account_type' => 'account_type|string|false||账户类型1.积分2.余额3.购物币',
        
        'sign' => 'sign|string|false||正负号',

        'number' => 'number|float|false||数量（额度，单位：元）',

        'from_type' => 'from_type|string|false||产生方式1.商城订单2.订单退还3.兑换4.充值5.签到6.分享7.注册8.提现9提现退还',

        'data_id' => 'data_id|string|false||相关表的数据ID',

        'text' => 'text|string|false||数据相关内容描述文本',

        'create_time' => 'create_time|string|false||创建时间',
      
      ),

      'update' => array(

        'id' => 'id|string|true||流水账表序号',

        'uid' => 'uid|string|false||用户ID',
      
        'shop_id' => 'shop_id|string|false||店铺ID',

        'account_type' => 'account_type|string|false||账户类型1.积分2.余额3.购物币',
        
        'sign' => 'sign|string|false||正负号',

        'number' => 'number|float|false||数量（额度，单位：元）',

        'from_type' => 'from_type|string|false||产生方式1.商城订单2.订单退还3.兑换4.充值5.签到6.分享7.注册8.提现9提现退还',

        'data_id' => 'data_id|string|false||相关表的数据ID',

        'text' => 'text|string|false||数据相关内容描述文本',
      
      ),

      'getDetail' => array(

        'way' => 'way|string|true|1|途径 1-前台会员 2-后台管理员',

        'token' => 'token|string|false||用户令牌（way为1则必传）',

        'uid' => 'uid|string|false||用户ID',

        'id' => 'id|string|false||流水账表序号',
      
        'shop_id' => 'shop_id|string|false||店铺ID',

        'account_type' => 'account_type|string|false||账户类型1.积分2.余额3.购物币',
        
        'sign' => 'sign|string|false||正负号',

        'number' => 'number|float|false||数量（额度，单位：元）',

        'from_type' => 'from_type|string|false||产生方式1.商城订单2.订单退还3.兑换4.充值5.签到6.分享7.注册8.提现9提现退还',

        'data_id' => 'data_id|string|false||相关表的数据ID',

        'text' => 'text|string|false||数据相关内容描述文本',

        'create_time' => 'create_time|string|false||创建时间',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',
      
      ),
      
    ));

  }

  /**
   * 新增会员账户记录
   * @desc 在用户使用优惠券的时候调用
   *
   * @return int ret 操作状态：200表示成功
   * @return int data 表序号
   * @return string msg 错误提示
   */
  public function add() {

    $params = $this->retriveRuleParams('add');

    $regulation = array(
      'uid' => 'required',
      'account_type' => 'required',
      'sign' => 'required',
      'number' => 'required',
      'from_type' => 'required',
    );

    \App\Verification($params, $regulation);

    return $this->dm->add($params);
  
  }

  /**
   * 修改会员账户记录
   * @desc 修改会员账户记录
   *
   * @return int ret 操作状态：200表示成功
   * @return int data 修改条数
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
   * 查询会员账户记录详情
   * @desc 查询会员账户记录列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.id 表序号
   * @return int data.shop_id 店铺ID
   * @return string data.shop_name 店铺名称
   * @return int data.uid 用户ID 
   * @return int data.account_type 账户类型1.积分2.余额3.购物币
   * @return string data.sign 正负号
   * @return float data.number 数量（额度，单位：元）
   * @return int data.from_type 产生方式1.商城订单2.订单退还3.兑换4.充值5.签到6.分享7.注册8.提现9提现退还
   * @return string data.type_name 类型名称
   * @return int data.data_id 相关表的数据ID
   * @return string data.text 数据相关内容描述文本
   * @return string data.create_time 创建时间
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
   * 查询会员账户记录列表
   * @desc 查询会员账户记录列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.total 数据总条数
   * @return int data.page 当前页码
   * @return array data.list[] 数据队列
   * @return int data.list[].id 表序号
   * @return int data.list[].shop_id 店铺ID
   * @return string data.list[].shop_name 店铺名称
   * @return int data.list[].uid 用户ID 
   * @return int data.list[].account_type 账户类型1.积分2.余额3.购物币
   * @return string data.list[].sign 正负号
   * @return float data.list[].number 数量（额度，单位：元）
   * @return int data.list[].from_type 产生方式1.商城订单2.订单退还3.兑换4.充值5.签到6.分享7.注册8.提现9提现退还
   * @return string data.list[].type_name 类型名称
   * @return int data.list[].data_id 相关表的数据ID
   * @return string data.list[].text 数据相关内容描述文本
   * @return string data.list[].create_time 创建时间
   * @return string msg 错误提示
   */
  public function queryList() {

    $conditions = $this->retriveRuleParams('queryList');

    $regulation = array(

      'way' => 'required',

      'page' => 'required',

      'page_size' => 'required',

    );

    \App\Verification($conditions, $regulation);

    return $this->dm->queryList($conditions);

  }

  /**
   * 查询poss会员账户记录列表
   * @desc 查询poss会员账户记录列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.total 数据总条数
   * @return int data.page 当前页码
   * @return array data.list[] 数据队列
   * @return int data.list[].id 表序号
   * @return string data.list[].shop_name 店铺名称
   * @return string data.list[].sign 正负号
   * @return float data.list[].number 数量（额度，单位：元）
   * @return string data.list[].type_name 类型名称
   * @return int data.list[].data_id 相关表的数据ID
   * @return string data.list[].text 数据相关内容描述文本
   * @return string data.list[].create_time 创建时间
   * @return string msg 错误提示
   */
  public function queryPossList() {

    $conditions = $this->retriveRuleParams('queryPossList');

    $regulation = array(

      'token' => 'required',
      
      'account_type' => 'required',

      'page' => 'required',

      'page_size' => 'required',

    );

    \App\Verification($conditions, $regulation);

    return $this->dm->queryPossList($conditions);

  }

  /**
   * 查询会员账户记录数量
   * @desc 查询会员账户记录数量
   *
   * @return int ret 操作状态：200表示成功
   * @return int data 条数
   * @return string msg 错误提示
   */
  public function queryCount() {

    $conditions = $this->retriveRuleParams('queryCount');
  
    $regulation = array(

    );

    \App\Verification($conditions, $regulation);

    return $this->dm->queryCount($conditions);
  
  }

}
