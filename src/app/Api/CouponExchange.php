<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\CouponExchangeDm;
use PhalApi\Exception;

/**
 * 17.1 提领券接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-21
 */
class CouponExchange extends BaseApi {

  public function getRules() {

    return $this->rules(array(

      'add' => array(

        'serial_number' => 'serial_number|string|true||序列号',

        'heading_code' => 'heading_code|string|true||识别码',

        'coupons_code' => 'coupons_code|string|true||提领码',
      
        'goods_id' => 'goods_id|int|true||商品id',
      
        'type' => 'type|int|true|1|种类 1-提领券 2-电子券',
        
        'status' => 'status|int|true||状态 1-已激活 2-已注销 3-已停用 4-已过期 5-未激活',

        'start_time' => 'start_time|string|false||有效期开始时间，不传为无限制',

        'end_time' => 'end_time|string|false||过期时间，不传为无限制',

        'owner_id' => 'owner_id|int|false||当前拥有者',

        'member_id' => 'member_id|int|false||购买者',

        'user_id' => 'user_id|int|false||管理员id',

        'cancel_id' => 'cancel_id|int|false||核销码id',

        'cancel_after_verification' => 'cancel_after_verification|string|false||核销码',

        'cancel_time' => 'cancel_time|string|false||核销时间',

        'order_id' => 'order_id|int|false||兑换商品的订单id',

        'electronic_order_id' => 'electronic_order_id|int|false||购买电子券时的订单id',

        'on_line' => 'on_line|int|false|1|线上 1-支持 2-不支持',

        'offline' => 'offline|int|false|1|线下 1-支持 2-不支持',

        'is_postage' => 'is_postage|int|false|1|是否包邮 1-否 2-是',

        'is_voucher' => 'is_voucher|int|false|1|代金券 1-否 2-是',

        'img' => 'img|string|false||电子券二维码图片路径',

        'comment' => 'comment|string|false||备注',

      ),

      'queryList' => array(

        'way' => 'way|int|true|1|途径 1-前台（会员） 2-后台（管理员）',

        'token' => 'token|string|false||用户令牌',

        'id' => 'id|string|false||表序号',

        'serial_number' => 'serial_number|string|false||序列号',

        'heading_code' => 'heading_code|string|false||识别码',

        'coupons_code' => 'coupons_code|string|false||提领码',
      
        'type' => 'type|int|false|1|种类 1-提领券 2-电子券',
        
        'status' => 'status|int|false||状态 1-已激活 2-已注销 3-已停用 4-已过期 5-未激活',

        'start_time' => 'start_time|string|false||有效期开始时间，不传为无限制',

        'end_time' => 'end_time|string|false||过期时间，不传为无限制',

        'owner_id' => 'owner_id|int|false||当前拥有者',

        'member_id' => 'member_id|int|false||购买者',

        'user_id' => 'user_id|int|false||管理员id',

        'cancel_id' => 'cancel_id|int|false||核销码id',

        'cancel_after_verification' => 'cancel_after_verification|string|false||核销码',

        'cancel_time' => 'cancel_time|string|false||核销时间',

        'order_id' => 'order_id|int|false||兑换商品的订单id',

        'electronic_order_id' => 'electronic_order_id|int|false||购买电子券时的订单id',

        'on_line' => 'on_line|int|false||线上 1-支持 2-不支持',

        'offline' => 'offline|int|false||线下 1-支持 2-不支持',

        'is_postage' => 'is_postage|int|false||是否包邮 1-否 2-是',

        'is_voucher' => 'is_voucher|int|false||代金券 1-否 2-是',

        'img' => 'img|string|false||电子券二维码图片路径',

        'comment' => 'comment|string|false||备注',

        'create_time' => 'create_time|string|false||创建时间',
        
        'modified_time' => 'modified_time|string|false||修改时间',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|20|每页数据条数'

      ),

      'queryCount' => array(

        'id' => 'id|string|false||表序号',

        'serial_number' => 'serial_number|string|false||序列号',

        'heading_code' => 'heading_code|string|false||识别码',

        'coupons_code' => 'coupons_code|string|false||提领码',
      
        'type' => 'type|int|false|1|种类 1-提领券 2-电子券',
        
        'status' => 'status|int|false||状态 1-已激活 2-已注销 3-已停用 4-已过期 5-未激活',

        'start_time' => 'start_time|string|false||有效期开始时间，不传为无限制',

        'end_time' => 'end_time|string|false||过期时间，不传为无限制',

        'owner_id' => 'owner_id|int|false||当前拥有者',

        'member_id' => 'member_id|int|false||购买者',

        'user_id' => 'user_id|int|false||管理员id',

        'cancel_id' => 'cancel_id|int|false||核销码id',

        'cancel_after_verification' => 'cancel_after_verification|string|false||核销码',

        'cancel_time' => 'cancel_time|string|false||核销时间',

        'order_id' => 'order_id|int|false||兑换商品的订单id',

        'electronic_order_id' => 'electronic_order_id|int|false||购买电子券时的订单id',

        'on_line' => 'on_line|int|false||线上 1-支持 2-不支持',

        'offline' => 'offline|int|false||线下 1-支持 2-不支持',

        'is_postage' => 'is_postage|int|false||是否包邮 1-否 2-是',

        'is_voucher' => 'is_voucher|int|false||代金券 1-否 2-是',

        'img' => 'img|string|false||电子券二维码图片路径',

        'comment' => 'comment|string|false||备注',

        'create_time' => 'create_time|string|false||创建时间',
      
      ),

      'update' => array(

        'id' => 'id|string|true||表序号',

        'serial_number' => 'serial_number|string|false||序列号',

        'heading_code' => 'heading_code|string|false||识别码',

        'coupons_code' => 'coupons_code|string|false||提领码',
      
        'type' => 'type|int|false|1|种类 1-提领券 2-电子券',
        
        'status' => 'status|int|false||状态 1-已激活 2-已注销 3-已停用 4-已过期 5-未激活',

        'start_time' => 'start_time|string|false||有效期开始时间，不传为无限制',

        'end_time' => 'end_time|string|false||过期时间，不传为无限制',

        'owner_id' => 'owner_id|int|false||当前拥有者',

        'member_id' => 'member_id|int|false||购买者',

        'user_id' => 'user_id|int|false||管理员id',

        'cancel_id' => 'cancel_id|int|false||核销码id',

        'cancel_after_verification' => 'cancel_after_verification|string|false||核销码',

        'cancel_time' => 'cancel_time|string|false||核销时间',

        'order_id' => 'order_id|int|false||兑换商品的订单id',

        'electronic_order_id' => 'electronic_order_id|int|false||购买电子券时的订单id',

        'on_line' => 'on_line|int|false||线上 1-支持 2-不支持',

        'offline' => 'offline|int|false||线下 1-支持 2-不支持',

        'is_postage' => 'is_postage|int|false||是否包邮 1-否 2-是',

        'is_voucher' => 'is_voucher|int|false||代金券 1-否 2-是',

        'img' => 'img|string|false||电子券二维码图片路径',

        'comment' => 'comment|string|false||备注',

        'create_time' => 'create_time|string|false||创建时间',
        
        'modified_time' => 'modified_time|string|false||修改时间',
      
      ),

      'getDetail' => array(

        'way' => 'way|int|true|1|途径 1-前台（会员） 2-后台（管理员）',

        'token' => 'token|string|false||用户令牌',

        'id' => 'id|string|false||表序号',

        'serial_number' => 'serial_number|string|false||序列号',

        'heading_code' => 'heading_code|string|false||识别码',

        'coupons_code' => 'coupons_code|string|false||提领码',
      
        'type' => 'type|int|false|1|种类 1-提领券 2-电子券',
        
        'status' => 'status|int|false||状态 1-已激活 2-已注销 3-已停用 4-已过期 5-未激活',

        'start_time' => 'start_time|string|false||有效期开始时间，不传为无限制',

        'end_time' => 'end_time|string|false||过期时间，不传为无限制',

        'owner_id' => 'owner_id|int|false||当前拥有者',

        'member_id' => 'member_id|int|false||购买者',

        'user_id' => 'user_id|int|false||管理员id',

        'cancel_id' => 'cancel_id|int|false||核销码id',

        'cancel_after_verification' => 'cancel_after_verification|string|false||核销码',

        'cancel_time' => 'cancel_time|string|false||核销时间',

        'order_id' => 'order_id|int|false||兑换商品的订单id',

        'electronic_order_id' => 'electronic_order_id|int|false||购买电子券时的订单id',

        'on_line' => 'on_line|int|false||线上 1-支持 2-不支持',

        'offline' => 'offline|int|false||线下 1-支持 2-不支持',

        'is_postage' => 'is_postage|int|false||是否包邮 1-否 2-是',

        'is_voucher' => 'is_voucher|int|false||代金券 1-否 2-是',

        'img' => 'img|string|false||电子券二维码图片路径',

        'comment' => 'comment|string|false||备注',

        'create_time' => 'create_time|string|false||创建时间',
        
        'modified_time' => 'modified_time|string|false||修改时间',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',
      
      ),

      'cancelVerify' => array(

        'heading_code' => 'heading_code|string|true||识别码',

        'coupons_code' => 'coupons_code|string|true||提领码',

      ),

      'cancel' => array(

        'token' => 'token|string|true||用户令牌（后台管理员的）',

        'heading_code' => 'heading_code|string|true||识别码',

        'coupons_code' => 'coupons_code|string|true||提领码',

      ),

      'conversion' => array(

        'token' => 'token|string|true||用户令牌（前台会员的）',

        'address_id' => 'address_id|int|true||收货地址id',

        'heading_code' => 'heading_code|string|true||识别码',

        'coupons_code' => 'coupons_code|string|true||提领码',

      ),
      
    ));

  }

  /**
   * 提领券兑换下单
   * @desc 提领券兑换下单
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 结果集
   * @return boolean data.status true-成功 false-失败
   * @return int data.id 成功返回订单id
   * @return string data.sn 成功返回订单sn
   * @return string data.msg 失败的理由
   * @return string msg 错误提示
   */
  public function conversion() {

    $condition = $this->retriveRuleParams('conversion');

    $regulation = array(
      'token' => 'required',
      'address_id' => 'required',
      'heading_code' => 'required',
      'coupons_code' => 'required',
    );

    \App\Verification($condition, $regulation);

    return $this->dm->conversion($condition);
  
  }

  /**
   * 提领券核销验证
   * @desc 提领券核销验证
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 结果集
   * @return boolean data.status true-可用 false-不可用
   * @return string data.msg 不可用的理由
   * @return string msg 错误提示
   */
  public function cancelVerify() {

    $condition = $this->retriveRuleParams('cancelVerify');

    $regulation = array(
      'heading_code' => 'required',
      'coupons_code' => 'required',
    );

    \App\Verification($condition, $regulation);

    return $this->dm->cancelVerify($condition);
  
  }

  /**
   * 提领券核销
   * @desc cancel_after 和 uid 其中一个字段必填
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 结果集
   * @return boolean data.status true-成功 false-失败
   * @return string data.msg 失败的理由
   * @return string msg 错误提示
   */
  public function cancel() {

    $condition = $this->retriveRuleParams('cancel');

    $regulation = array(
      'token' => 'required',
      'heading_code' => 'required',
      'coupons_code' => 'required',
    );

    \App\Verification($condition, $regulation);

    if (!isset($condition['cancel_after']) && !isset($condition['uid'])) {

      throw new Exception('cancel_after 和 uid 其中一个字段必填', 1710000);

    }

    return $this->dm->cancel($condition);
  
  }

  /**
   * 新增提领券
   * @desc 在用户使用优惠券的时候调用
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 类型Id
   * @return string msg 错误提示
   */
  public function add() {

    $params = $this->retriveRuleParams('add');

    $regulation = array(
      'serial_number' => 'required',
      'heading_code' => 'required',
      'coupons_code' => 'required',
    );

    \App\Verification($params, $regulation);

    return $this->dm->add($params);
  
  }

  /**
   * 修改提领券
   * @desc 修改提领券
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 修改条数
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
   * 查询提领券详情
   * @desc 查询提领券列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.id 表序号
   * @return string data.serial_number 序列号
   * @return string data.heading_code 识别码
   * @return string data.coupons_code 提领码
   * @return int data.type 种类 1-提领券 2-电子券
   * @return int data.status 状态 1-已激活 2-已注销 3-已停用 4-已过期 5-未激活
   * @return string data.create_time 创建时间
   * @return string data.modified_time 修改时间
   * @return string data.start_time 有效期开始时间
   * @return string data.end_time 有效过期时间
   * @return int data.owner_id 当前拥有者
   * @return int data.member_id 购买者
   * @return int data.user_id 管理员id
   * @return int data.cancel_id 核销码id
   * @return string data.cancel_after_verification 核销码
   * @return string data.cancel_time 核销时间
   * @return int data.order_id 兑换商品的订单id
   * @return int data.electronic_order_id 购买电子券时的订单id
   * @return int data.on_line 线上 1-支持 2-不支持
   * @return int data.offline 线下 1-支持 2-不支持
   * @return int data.is_postage 是否包邮 1-否 2-是
   * @return int data.is_voucher 代金券 1-否 2-是
   * @return string data.img 电子券二维码图片路径
   * @return string data.comment 备注
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
   * 查询提领券列表
   * @desc 查询提领券列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.total 数据总条数
   * @return int data.page 当前页码
   * @return array data.list[] 提领券队列
   * @return int data.list[].id 表序号
   * @return string data.list[].serial_number 序列号
   * @return string data.list[].heading_code 识别码
   * @return string data.list[].coupons_code 提领码
   * @return int data.list[].type 种类 1-提领券 2-电子券
   * @return int data.list[].status 状态 1-已激活 2-已注销 3-已停用 4-已过期 5-未激活
   * @return string data.list[].create_time 创建时间
   * @return string data.list[].modified_time 修改时间
   * @return string data.list[].start_time 有效期开始时间
   * @return string data.list[].end_time 有效过期时间
   * @return int data.list[].owner_id 当前拥有者
   * @return int data.list[].member_id 购买者
   * @return int data.list[].user_id 管理员id
   * @return int data.list[].cancel_id 核销码id
   * @return string data.list[].cancel_after_verification 核销码
   * @return string data.list[].cancel_time 核销时间
   * @return int data.list[].order_id 兑换商品的订单id
   * @return int data.list[].electronic_order_id 购买电子券时的订单id
   * @return int data.list[].on_line 线上 1-支持 2-不支持
   * @return int data.list[].offline 线下 1-支持 2-不支持
   * @return int data.list[].is_postage 是否包邮 1-否 2-是
   * @return int data.list[].is_voucher 代金券 1-否 2-是
   * @return string data.list[].img 电子券二维码图片路径
   * @return string data.list[].comment 备注
   * @return string data.list[].goods_id 兑换的商品id
   * @return string data.list[].price 兑换的商品价格
   * @return string data.list[].picture 兑换的商品图片
   * @return string data.list[].goods_name 兑换的商品名称
   * @return string msg 错误提示
   */
  public function queryList() {

    $conditions = $this->retriveRuleParams('queryList');

    $regulation = array();

    \App\Verification($conditions, $regulation);

    return $this->dm->queryList($conditions);

  }

  /**
   * 查询提领券数量
   * @desc 查询提领券数量
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
