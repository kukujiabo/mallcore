<?php

namespace App\Api;

use PhalApi\Api;
use PhalApi\Exception; 
/**
 * 7.1 优惠券实例接口
 *
 * @author: Meroc Chen <398515393@qq.com> 2017-10-11
 */
class Coupon extends BaseApi {

  /**
   * 配置接口参数规则
   */
  public function getRules() {

    return $this->rules(array(

      //新增优惠券 
      'add' => array(

        'coupon_code' => 'coupon_code|string|true|0|优惠券编码',

        'coupon_type_id' => 'coupon_type_id|string|true||优惠券类型id',

        'shop_id' => 'shop_id|string|true||店铺id|',

        'uid' => 'uid|string|true||用户id|',

        'state' => 'state|int|true||优惠券状态 1已领取（未使用） 2已使用 3已过期',

        'coupon_type_id' => 'coupon_type_id|string|true||优惠券类型id',

        'fetch_time' => 'fetch_time|date|true||领取时间',

        'start_time' => 'start_time|string|true||有效期开始时间',

        'end_time' => 'end_time|string|true||有效期结束时间',

        'wx_bind' => 'wx_bind|string|true||微信是否绑定',

        'coupon_name' => 'coupon_name|string|true||优惠券名称',

        'deduction_type' => 'deduction_type|int|true||抵扣类型：1 折扣，2 现金，3 包邮',

        'percentage' => 'percentage|float|true||折扣',

        'at_least' => 'at_least|float|true||满多少元使用 0代表无限制',

        'online_type' => 'online_type|int|false|3|线上线下使用类型：1，线上；2，线下；3，通用',

        'ext_1' => 'ext_1|string|false||商品大类字段',

        'ext_2' => 'ext_2|string|false||商品单品字段'

      ),

      //设置优惠券状态为已用
      'posUseCoupon' => array(
      
        'code' => 'code|string|true||优惠券编码',

        'shopId' => 'shopId|string|true||门店编号',

        'money' => 'money|string|true||消费金额',

        'orderNo' => 'orderNo|string|true||会员消费单号',

        'phone' => 'phone|string|true||会员手机号'

      ),

      //查询优惠券列表
      'queryList' => array(
      
        'way' => 'way|int|true|1|途径 1-前台（会员） 2-后台（管理员）',
      
        'token' => 'token|string|false||用户令牌',

        'coupon_code' => 'coupon_code|string|false||优惠券编码',
      
        'uid' => 'uid|string|false||用户id',

        'use_order_id' => 'use_order_id|string|false||相关订单id',

        'state' => 'state|string|false||优惠券状态',

        'coupon_type_id' => 'coupon_type_id|string|false||优惠券类型id',

        'fetch_time' => 'fetch_time|string|false||最早领取时间',

        'start_time' => 'start_time|string|false||有效期开始时间',

        'end_time' => 'end_time|string|false||有效期结束时间',

        'wx_bind' => 'wx_bind|string|false||微信是否绑定',

        'coupon_name' => 'coupon_name|string|false||优惠券名称',

        'is_relevance' => 'is_relevance|int|false||是否关联类型表 1-是',

        'order' => 'order|string|false||排序方式',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|20|每页数据条数'

      ),

      'queryCount' => array(
      
        'way' => 'way|int|true|1|途径 1-前台（会员） 2-后台（管理员）',
      
        'token' => 'token|string|false||用户令牌',
      
        'coupon_code' => 'coupon_code|string|false||优惠券编码',
      
        'uid' => 'uid|string|false||用户id|',

        'use_order_id' => 'use_order_id|string|false||相关订单id',

        'state' => 'state|string|false||优惠券状态',

        'coupon_type_id' => 'coupon_type_id|string|false||优惠券类型id',

        'fetch_time' => 'fetch_time|string|false||最早领取时间',

        'start_time' => 'start_time|string|false||有效期开始时间',

        'end_time' => 'end_time|string|false||有效期结束时间',

        'wx_bind' => 'wx_bind|string|false||微信是否绑定',

        'coupon_name' => 'coupon_name|string|false||优惠券名称',
      
      ),

      'adminBatchAdd' => array(
      
        'coupons' => 'coupons|string|true||优惠券数据',
      
        'member_name' => 'member_name|string|false||会员名称',

        'user_tel' => 'user_tel|string|false||会员手机号',

        'card_id' => 'card_id|string|false||会员卡号',

        'sequence' => 'sequence|string|true||流水号',

        'remark' => 'remark|string|false||发放备注'
      
      ),

      'getCouponQrCode' => array(
      
        'token' => 'token|string|true||用户令牌',

        'coupon_code' => 'coupon_code|string|true||优惠券编码',
      
      ),

      'getAvailableCoupon' => array(
      
        'token' => 'token|string|true||用户令牌',

        'shop_id' => 'shop_id|int|true||门店id',

        'type' => 'type|int|true|1|下单类型 1-购物车下单 2-立即购买',

        'cart_id' => 'cart_id|string|false||购物车id（多个用英文逗号隔开）',

        'goods_id' => 'goods_id|int|false||商品id',

        'sku_id' => 'sku_id|int|false||sku商品id',

        'num' => 'num|int|false||商品购买数量',
      
      ),

      'posQueryAvailableCoupons' => array(
      
        'phone' => 'phone|string|false||用户手机号',

        'card_id' => 'card_id|string|false||用户会员卡号',

        'money' => 'money|float|true||消费金额',

        'shop_id' => 'shop_id|float|true||门店id,'
      
      )
      
    ));

  }

  /**
   * 获取满足条件的优惠券
   * @desc 获取满足条件的优惠券。如果typr 为1则 cart_id 必传，为2 goods_id 和 num 必传
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 参数集
   * @return int data[].coupon_id 优惠券id
   * @return int data[].coupon_type_id 优惠券类型id
   * @return int data[].shop_id 店铺Id
   * @return syting data[].coupon_code 优惠券编码
   * @return int data[].uid 领用人
   * @return int data[].use_order_id 优惠券使用订单id
   * @return int data[].create_order_id 创建订单id
   * @return float data[].money 面额
   * @return string data[].fetch_time 领取时间
   * @return string data[].use_time 使用时间
   * @return int data[].state 优惠券状态：0未领用，1已领取（未使用），2已使用，3已过期
   * @return string data[].start_time 有效期开始时间
   * @return string data[].end_time 有效期结束时间
   * @return int data[].get_type 获取方式1订单2.首页领取
   * @return int data[].wx_bind 是否绑定了微信卡券:0-否，1-是
   * @return string data[].coupon_name 优惠券名称
   * @return int data[].deduction_type 抵扣类型：1-折扣，2-现金，3-包邮
   * @return float data[].percentage 折扣
   * @return int data[].at_least 满多少元使用，0代表无限制
   * @return int data[].all_store 所有门店可用
   * @return int data[].last_long 是否长期有效：0，否；1，是
   * @return int data[].qr_code 优惠券二维码
   * @return string msg 错误提示
   */
  public function getAvailableCoupon() {

    $regulation = array(

      'token' => 'required',

      'shop_id' => 'required',

      'type' => 'required',
    
    );

    $conditions = $this->retriveRuleParams(__FUNCTION__);

    \App\Verification($conditions, $regulation);

    if ($conditions['type'] == 1 && !isset($conditions['cart_id'])) {

      throw new Exception("cart_id必传", 710101);

    } elseif ($conditions['type'] == 2 && (!isset($conditions['goods_id']) || !isset($conditions['num']))) {

      throw new Exception("goods_id和num必传", 710102);
      
    }
  
    return $this->dm->getAvailableCoupon($conditions);
  
  }

  /**
   * 获取优惠券二维码
   * @desc 获取优惠券二维码
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 参数集
   * @return string data.qr_code 二维码地址
   * @return string msg 错误提示
   */
  public function getCouponQrCode() {

    $regulation = array(

      'token' => 'required',

      'coupon_code' => 'required',
    
    );

    $conditions = $this->retriveRuleParams(__FUNCTION__);

    \App\Verification($conditions, $regulation);
  
    return $this->dm->getCouponQrCode($conditions);
  
  }

  /**
   * 新增优惠券
   * @desc 新增优惠券接口
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 参数集
   * @return array data.Status 1:操作成功;-1:操作出错
   * @return array data.Description 错误信息
   * @return string msg 错误提示
   */
  public function add() {

    $regulation = array(

    
    );

    $params = $this->retriveRuleParams('add');

    \App\Verification($params, $regulation);
  
    return $this->dm->add($params);
  
  }

  /**
   * 查询优惠券列表
   * @desc 查询优惠券列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 参数集
   * @return int data.total 数据总条数
   * @return int data.page 当前页码
   * @return array data.list[] 优惠券列表
   * @return int data.list[].coupon_id 优惠券id
   * @return int data.list[].coupon_type_id 优惠券类型id
   * @return int data.list[].shop_id 店铺Id
   * @return syting data.list[].coupon_code 优惠券编码
   * @return int data.list[].uid 领用人
   * @return int data.list[].use_order_id 优惠券使用订单id
   * @return int data.list[].create_order_id 创建订单id
   * @return float data.list[].money 面额
   * @return string data.list[].fetch_time 领取时间
   * @return string data.list[].use_time 使用时间
   * @return int data.list[].state 优惠券状态：0未领用，1已领取（未使用），2已使用，3已过期
   * @return string data.list[].start_time 有效期开始时间
   * @return string data.list[].end_time 有效期结束时间
   * @return int data.list[].get_type 获取方式1订单2.首页领取
   * @return int data.list[].wx_bind 是否绑定了微信卡券:0-否，1-是
   * @return string data.list[].coupon_name 优惠券名称
   * @return int data.list[].deduction_type 抵扣类型：1-折扣，2-现金，3-包邮
   * @return float data.list[].percentage 折扣
   * @return int data.list[].at_least 满多少元使用，0代表无限制
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
   * 查询优惠券数量
   * @desc 查询优惠券数量
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 参数集
   * @return array data.Status 1:操作成功;-1:操作出错
   * @return array data.Description 错误信息
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
   * POS核销优惠券
   * @desc POS核销优惠券
   *
   * @param string $id
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 参数集
   * @return array data.Status 1:操作成功;-1:操作出错
   * @return array data.Description 错误信息
   * @return string msg 错误提示
   */
  public function posUseCoupon() {
  
    $data = $this->retriveRuleParams(__FUNCTION__);

    return $this->dm->posUseCoupon($data);
  
  }

  /**
   * 后台管理员批量添加优惠券
   * @desc 后台管理员批量添加优惠券
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 参数集
   * @return array data.Status 1:操作成功;-1:操作出错
   * @return array data.Description 错误信息
   * @return string msg 错误提示
   */
  public function adminBatchAdd() {
  
    return $this->dm->adminBatchAdd($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * pos查询可用户可用优惠券
   * @desc pos查询可用户可用优惠券
   *
   */
  public function posQueryAvailableCoupons() {
  
    return $this->dm->posQueryAvailableCoupons($this->retriveRuleParams(__FUNCTION__));
  
  }
  

}
