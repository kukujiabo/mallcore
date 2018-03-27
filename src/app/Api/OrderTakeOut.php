<?php

namespace App\Api;

use PhalApi\Api;
use PhalApi\Exception;

/**
 * 6.1 外卖订单接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-11
 */
class OrderTakeOut extends BaseApi {

  public function getRules() {

    return $this->rules(array(

      'add' => array(
      
        'way' => 'way|int|true|1|途径 1-前台会员 2-后台管理员',

        'token' => 'token|string|false||用户令牌（way为1则必传）',

        'buyer_id' => 'buyer_id|int|false||用户id（way为2则必传）',

        'shop_id' => 'shop_id|int|true||卖家店铺id',

        'address_id' => 'address_id|int|true||收货地址id',

        'cart_id' => 'cart_id|string|true||购物车商品id（英文逗号隔开）',

        'user_money' => 'user_money|float|false||使用的余额',

        'point' => 'point|int|false||使用的积分',

        'buyer_message' => 'buyer_message|string|false||买家附言（备注）',

        'buyer_invoice' => 'buyer_invoice|string|false||买家发票信息',

        'coupon_id' => 'coupon_id|int|false||使用的优惠券id',

        'city_code' => 'city_code|int|false||城市编码'

      ),

      'purchase' => array(
      
        'way' => 'way|int|true|1|途径 1-前台会员 2-后台管理员',

        'token' => 'token|string|false||用户令牌（way为1则必传）',

        'buyer_id' => 'buyer_id|int|false||用户id（way为2则必传）',

        'shop_id' => 'shop_id|int|true||卖家店铺id',

        'address_id' => 'address_id|int|true||收货地址id',

        'goods_id' => 'goods_id|int|true||商品ID',

        'sku_id' => 'sku_id|int|false||商品skuID',

        'quantity' => 'quantity|int|true||商品数量',

        'user_money' => 'user_money|float|false||使用的余额',

        'point' => 'point|int|false||使用的积分',

        'buyer_message' => 'buyer_message|string|false||买家附言（备注）',

        'buyer_invoice' => 'buyer_invoice|string|false||买家发票信息',

        'coupon_id' => 'coupon_id|int|false||使用的优惠券id',

        'city_code' => 'city_code|int|false||城市编码'

      ),

      'queryList' => array(
      
        'way' => 'way|int|true|1|途径 1-前台会员 2-后台管理员',

        'token' => 'token|string|false||用户令牌（way为1则必传）',

        'order_id' => 'order_id|string|false||表序号',

        'sn' => 'sn|string|false||订单编号',

        'buyer_id' => 'buyer_id|string|false||用户id',

        'shop_id' => 'shop_id|int|false||卖家店铺id',
        
        'card_id' => 'card_id|string|false||会员卡号',
        
        'user_tel' => 'user_tel|string|false||手机号',
        
        'member_name' => 'member_name|string|false||用户名',
        
        'consigner' => 'consigner|string|false||收货人',

        'mobile' => 'mobile|string|false||收货人手机号',

        'order_status' => 'order_status|int|false||订单状态 1-未支付 2-已支付 3-已签收',

        'shipping_status' => 'shipping_status|int|false||订单配送状态 1-未配送 2-配送中 3-已配送',

        'create_time' => 'create_time|string|false||创建时间',
        
        'consign_time' => 'consign_time|string|false||发货时间',

        'sign_time' => 'sign_time|string|false||买家签收时间',

        'finish_time' => 'finish_time|string|false||完成时间',

        'pay_time' => 'pay_time|string|false||支付时间',
        
        'cancel_time' => 'cancel_time|string|false||取消时间',
        
        'shipping_time' => 'shipping_time|string|false||买家要求的配送时间',

        'goods_status' => 'goods_status|int|false|1|1-取订单商品 2-不取订单商品',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',

        'excel' => 'excel|int|false||是否导出excel',

        'is_pushed' => 'is_pushed|int|false||是否已推送',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|20|每页数据条数'

      ),

      'queryCount' => array(

        'order_id' => 'order_id|string|false||订单编号',

        'sn' => 'sn|string|false||订单编号',

        'buyer_id' => 'buyer_id|string|false||用户id',

        'shop_id' => 'shop_id|int|false||卖家店铺id',

        'order_status' => 'order_status|int|false||订单状态',

        'create_time' => 'create_time|string|false||创建时间',
        
        'consign_time' => 'consign_time|string|false||发货时间',
        
        'sign_time' => 'sign_time|string|false||买家签收时间',

        'finish_time' => 'finish_time|string|false||完成时间',

        'pay_time' => 'pay_time|string|false||支付时间',
        
        'cancel_time' => 'cancel_time|string|false||取消时间',
        
        'shipping_time' => 'shipping_time|string|false||买家要求的配送时间',
      
      ),

      'update' => array(
      
        'way' => 'way|int|true|1|途径 1-前台会员 2-后台管理员',

        'token' => 'token|string|false||用户令牌（way为1则必传）',

        'order_id' => 'order_id|string|true||订单编号',

        'shop_id' => 'shop_id|int|false||卖家店铺id',

        'order_status' => 'order_status|int|false||订单状态 1-未支付 2-已支付 3-已完成',
        
        'pay_status' => 'pay_status|int|false||订单付款状态 1-未付款 2-已付款',

        'shipping_status' => 'shipping_status|int|false||订单配送状态 1-未配送 2-配送中 3-已签收',

        'driver_name' => 'driver_name|string|false||驾驶员名称',

        'driver_phone' => 'driver_phone|string|false||驾驶员手机号',

        'sign_time' => 'sign_time|string|false||签收时间',

        'finish_time' => 'finish_time|string|false||完成时间',

        'consign_time' => 'consign_time|string|false||配送时间',

        'pay_time' => 'pay_time|string|false||支付时间',
        
        'cancel_time' => 'cancel_time|string|false||取消时间',
      
      ),

      'getDetail' => array(
      
        'way' => 'way|int|true|1|途径 1-前台会员 2-后台管理员',

        'token' => 'token|string|false||用户令牌（way为1则必传）',

        'order_id' => 'order_id|string|true||订单编号',
      
      ),

      'payOrderTakeOut' => array(

        'token' => 'token|string|true||用户令牌',

        'sn' => 'sn|string|true||单号',

        'device_info' => 'device_info|string|false||设备信息',
      
      ),

      'cancelOrder' => array(

        'order_sn' => 'order_sn|string|true||订单编号',

        'comment' => 'comment|string|true||备注',
      
      ),
      
      'setPushed' => array(
      
        'ids' => 'ids|string|true||订单id'
      
      ),

      'updateOrderStatusByOrderNo' => array(

        'order_sn' => 'order_sn|string|true||订单编号',

        'status' => 'status|int|true||修改状态'
      
      ),

      'getOrderTakeOut' => array(

        'order_sn' => 'order_sn|string|false||订单编号',

        'status' => 'status|int|false|1|订单状态 1-已付款 2-接单 3-配送中 4-签收 5-取消'

      ),

      'updateOrderTakeOut' => array(

        'order_sn' => 'order_sn|string|true||订单编号',

        'status' => 'status|int|true||修改状态 2-已接单 3-配送中 4-已签收'

      ),

      'orderList' => array(

        'way' => 'way|int|true|1|途径 1-前台会员 2-后台管理员',
      
        'token' => 'token|string|true||用户令牌',

        'keyword' => 'keyword|string|true||关键字',

        'order_status' => 'order_status|int|false||订单状态',

        'page' => 'page|int|false|1|页码',

        'page_size' => 'page_size|int|false|10|每页条数'
      
      ),

      'rebuyOrder' => array(
      
        'token' => 'token|string|true||用户令牌',

        'city_code' => 'city_code|int|true||定位',

        'order_id' => 'order_id|string|true||订单id'
      
      ),

      'exportExcel' => array(
      
      
      )

    ));

  }
    
  /**
   * pos请求修改外卖订单状态
   * @desc pos请求修改外卖订单状态
   * @return int ret 操作状态：200表示成功
   * @return int data 修改条数
   * @return string msg 错误提示
   */
   
  public function updateOrderTakeOut(){

    $params = $this->retriveRuleParams(__FUNCTION__);

    $regulation = array(
      'order_sn' => 'required',
      'status' => 'required',
    );

    \App\Verification($params, $regulation);

    return $this->dm->updateOrderTakeOut($params);

  }
    
  /**
   * pos获取外卖订单信息
   * @desc pos获取外卖订单信息
   * @return int ret 操作状态：200表示成功
   * @return array  data[] 结果集
   * @return string data[].card_id 会员卡号
   * @return string data[].order_sn 单号
   * @return string data[].status 订单状态 1-已付款 2-已接单 3-配送中 4-已签收
   * @return string data[].create_time 下单时间
   * @return string data[].pay_time 支付时间
   * @return string data[].goods[] 商品
   * @return string data[].goods[].goods_category_name 档口名称
   * @return string data[].goods[].goods_name 商品名称
   * @return float  data[].goods[].packet_fee_money 餐盒费
   * @return string data[].goods[].num 数量
   * @return float  data[].goods[].price 单价
   * @return string data[].goods[].goods_no_code pos商品编号
   * @return string data[].goods[].stalls_no_code pos档口编号
   * @return float  data[].shipping_money 配送费
   * @return float  data[].promotion_money 优惠金额
   * @return float  data[].goods_money 商品总金额
   * @return float  data[].code_money 储值卡支付金额
   * @return float  data[].customary_number 储值卡原余额
   * @return string data[].phone 会员手机号
   * @return string data[].pos_id pos会员主键
   * @return float  data[].money 在线支付金额
   * @return float  data[].total_packet_fee_money 餐盒费总金额
   * @return string data[].address 配送地址
   * @return string data[].name 收货人
   * @return string data[].mobile 联系方式
   * @return string data[].buyer_message 买家附言
   * @return string msg 错误提示
   */
   
  public function getOrderTakeOut(){

    $conditions = $this->retriveRuleParams(__FUNCTION__);

    return $this->dm->getOrderTakeOut($conditions);

  }
    
  /**
   * 取消外卖订单接口服务
   * @desc 取消外卖订单接口服务
   * @return int ret 操作状态：200表示成功
   * @return int data 修改条数
   * @return string msg 错误提示
   */
   
  public function cancelOrder(){

    $params = $this->retriveRuleParams(__FUNCTION__);

    $regulation = array(
      'order_sn' => 'required',
      'comment' => 'required',
    );

    \App\Verification($params, $regulation);

    return  $this->dm->cancelOrder($params);

  }
    
  /**
   * 立即购买下单接口服务
   * @desc 立即购买下单接口服务
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.id 表序号
   * @return string data.sn 单号
   * @return string msg 错误提示
   */
   
  public function purchase(){

    $params = $this->retriveRuleParams(__FUNCTION__);

    return  $this->dm->purchase($params);

  }

  /**
   * 外卖订单支付
   * @desc 
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return array data.timeStamp 当前的时间戳
   * @return array data.nonceStr 随机字符串，长度为32个字符以下
   * @return array data.package 统一下单接口返回的prepay_id参数值，提交格式如：prepay_id=*
   * @return array data.signType 签名算法，暂支持 MD5
   * @return array data.paySign 签名
   * @return string msg 错误提示
   */
  public function payOrderTakeOut() {

    $params = $this->retriveRuleParams('payOrderTakeOut');

    $regulation = array(

      'token' => 'required',

      'sn' => 'required',

    );

    \App\Verification($params, $regulation);

    return $this->dm->payOrderTakeOut($params);
  
  }

  /**
   * 新增外卖订单
   * @desc 
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.id 表序号
   * @return string data.sn 单号
   * @return string msg 错误提示
   */
  public function add() {

    $params = $this->retriveRuleParams('add');

    return $this->dm->add($params);
  
  }

  /**
   * 修改外卖订单
   * @desc 修改外卖订单
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 修改条数
   * @return string msg 错误提示
   */
  public function update() {

    $params = $this->retriveRuleParams('update');

    $regulation = array(

      'order_id' => 'required',

    );

    \App\Verification($params, $regulation);
    
    return $this->dm->update($params);
  
  }

  /**
   * 查询外卖订单详情
   * @desc 查询外卖订单详情
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.id 表序号
   * @return string data.sn 订单编号
   * @return string data.out_trade_no 外部交易号
   * @return int data.payment_type 支付类型。取值范围：WEIXIN (微信自由支付) WEIXIN_DAIXIAO (微信代销支付) ALIPAY (支付宝支付)
   * @return int data.shipping_type 订单配送方式：1-快递配送，2-自提
   * @return int data.shipping_company_id 配送物流公司ID
   * @return string data.order_from 订单来源
   * @return int data.buyer_id 买家id
   * @return string data.user_name 买家会员名称
   * @return string data.buyer_ip 买家ip
   * @return string data.buyer_message 买家附言
   * @return string data.buyer_invoice 买家发票信息
   * @return string data.shipping_time 买家要求配送时间
   * @return string data.sign_time 买家签收时间
   * @return string data.pay_time 订单付款时间
   * @return int data.shop_id 卖家店铺id
   * @return string data.shop_name 卖家店铺名称
   * @return string data.shop_logo 卖家店铺logo
   * @return int data.seller_star 卖家对订单的标注星标：1-标，0-未标
   * @return string data.seller_memo 卖家对订单的备注
   * @return string data.consign_time 卖家发货时间
   * @return int data.consign_time 卖家延迟发货时间（时间戳）
   * @return float data.goods_money 商品总价（单位：元）
   * @return float data.tax_money 税费（单位：元）
   * @return float data.order_money 订单总价（单位：元）
   * @return int data.point 订单消耗积分
   * @return float data.point_money 订单消耗积分抵多少钱（单位：元）
   * @return int data.coupon_id 订单代金券id
   * @return float data.coupon_money 订单代金券支付金额
   * @return float data.user_money 订单余额支付金额
   * @return float data.user_platform_money 用户平台余额支付
   * @return float data.promotion_money 订单优惠活动金额
   * @return float data.shipping_money 订单运费
   * @return float data.pay_money 订单实付金额
   * @return float data.refund_money 订单退款金额
   * @return float data.coin_money 购物币金额
   * @return int data.give_point 订单赠送积分
   * @return float data.give_coin 订单成功之后返购物币
   * @return int data.order_status 订单状态：1-未支付，2-已支付，3-已签收
   * @return int data.pay_status 订单付款状态：1-未付款，2-已付款
   * @return int data.pay_status 订单配送状态：1-未配送，2-配送中，3-已配送
   * @return string data.create_time 创建时间
   * @return string data.finish_time 订单完成时间
   * @return int data.address_id 地址id
   * @return string data.consigner 收货人名称
   * @return string data.mobile 手机号
   * @return string data.phone 固定电话
   * @return int data.province 省id
   * @return int data.city 市id
   * @return int data.district 区id
   * @return string data.address 详细地址
   * @return int data.zip_code 邮编
   * @return string data.province_name 省名称
   * @return string data.city_name 市名称
   * @return string data.district_name 区/县名称
   * @return array data.goods_list[] 订单商品数据
   * @return int data.goods_list[].goods_id 订单商品id
   * @return string data.goods_list[].goods_name 商品名称
   * @return int data.goods_list[].sku_id skuID
   * @return string data.goods_list[].sku_name sku名称
   * @return float data.goods_list[].price 商品价格
   * @return float data.goods_list[].cost_price 商品成本价
   * @return int data.goods_list[].num 购买数量
   * @return float data.goods_list[].goods_money 商品总价
   * @return string data.goods_list[].goods_picture 商品图片
   * @return int data.goods_list[].shop_id 店铺id
   * @return string msg 错误提示
   */
  public function getDetail() {

    $conditions = $this->retriveRuleParams('getDetail');

    $regulation = array(

      'way' => 'required',

      'order_id' => 'required',

    );

    \App\Verification($conditions, $regulation);

    return $this->dm->getDetail($conditions);

  }

  /**
   * 查询外卖订单列表
   * @desc 查询外卖订单列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.total 数据条数
   * @return int data.page 页码
   * @return int data.list[] 数据列表
   * @return int data.list[].id 表序号
   * @return string data.list[].sn 订单编号
   * @return string data.list[].out_trade_no 外部交易号
   * @return int data.list[].payment_type 支付类型。取值范围：WEIXIN (微信自由支付) WEIXIN_DAIXIAO (微信代销支付) ALIPAY (支付宝支付)
   * @return int data.list[].shipping_type 订单配送方式：1-快递配送，2-自提
   * @return int data.list[].shipping_company_id 配送物流公司ID
   * @return string data.list[].order_from 订单来源
   * @return int data.list[].list[].buyer_id 买家id
   * @return string data.list[].user_name 买家会员名称
   * @return string data.list[].buyer_ip 买家ip
   * @return string data.list[].buyer_message 买家附言
   * @return string data.list[].buyer_invoice 买家发票信息
   * @return string data.list[].shipping_time 买家要求配送时间
   * @return string data.list[].sign_time 买家签收时间
   * @return string data.list[].pay_time 订单付款时间
   * @return int data.list[].shop_id 卖家店铺id
   * @return string data.list[].shop_name 卖家店铺名称
   * @return string data.list[].shop_logo 卖家店铺logo
   * @return int data.list[].seller_star 卖家对订单的标注星标：1-标，0-未标
   * @return string data.list[].seller_memo 卖家对订单的备注
   * @return string data.list[].consign_time 卖家发货时间
   * @return int data.list[].consign_time 卖家延迟发货时间（时间戳）
   * @return float data.list[].goods_money 商品总价（单位：元）
   * @return float data.list[].tax_money 税费（单位：元）
   * @return float data.list[].order_money 订单总价（单位：元）
   * @return int data.list[].point 订单消耗积分
   * @return float data.list[].point_money 订单消耗积分抵多少钱（单位：元）
   * @return int data.list[].coupon_id 订单代金券id
   * @return float data.list[].coupon_money 订单代金券支付金额
   * @return float data.list[].user_money 订单余额支付金额
   * @return float data.list[].user_platform_money 用户平台余额支付
   * @return float data.list[].promotion_money 订单优惠活动金额
   * @return float data.list[].shipping_money 订单运费
   * @return float data.list[].pay_money 订单实付金额
   * @return float data.list[].refund_money 订单退款金额
   * @return float data.list[].coin_money 购物币金额
   * @return int data.list[].give_point 订单赠送积分
   * @return float data.list[].give_coin 订单成功之后返购物币
   * @return int data.list[].order_status 订单状态：1-未支付，2-已支付，3-已签收
   * @return int data.list[].pay_status 订单付款状态：1-未付款，2-已付款
   * @return int data.list[].pay_status 订单配送状态：1-未配送，2-配送中，3-已配送
   * @return string data.list[].create_time 创建时间
   * @return string data.list[].finish_time 订单完成时间
   * @return array data.list[].goods_list[] 订单商品数据
   * @return int data.list[].goods_list[].goods_id 订单商品id
   * @return string data.list[].goods_list[].goods_name 商品名称
   * @return int data.list[].goods_list[].sku_id skuID
   * @return string data.list[].goods_list[].sku_name sku名称
   * @return float data.list[].goods_list[].price 商品价格
   * @return float data.list[].goods_list[].cost_price 商品成本价
   * @return int data.list[].goods_list[].num 购买数量
   * @return float data.list[].goods_list[].goods_money 商品总价
   * @return string data.list[].goods_list[].goods_picture 商品图片
   * @return int data.list[].goods_list[].shop_id 店铺id
   * @return string msg 错误提示
   */
  public function queryList() {

    $conditions = $this->retriveRuleParams('queryList');

    return $this->dm->queryList($conditions);

  }

  /**
   * 查询外卖订单数量
   * @desc 查询外卖订单数量
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
   * 查询新的外卖订单，并发出提醒
   * @desc 查询新的外卖订单，并发出提醒
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 条数
   * @return string msg 错误提示
   */
  public function setPushed() {
  
    return $this->dm->setPushed($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 根据订单号更新订单状态
   * @desc 根据订单号更新订单状态
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 条数
   * @return string msg 错误提示
   */
  public function updateOrderStatusByOrderNo() {
  
    return $this->dm->updateOrderStatusByOrderNo($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 查询订单列表
   * @desc 订单列表
   *
   * @return array list
   */
  public function orderList() {
  
    return $this->dm->orderList($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 重新下单
   * @desc 重新下单
   *
   * @return 
   */
  public function rebuyOrder() {
  
    return $this->dm->rebuyOrder($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 导出excel
   * @desc 导出excel
   *
   * @return
   */
  public function exportExcel() {
  
    return $this->dm->exportExcel($this->retriveRuleParams(__FUNCTION__));
  
  }

}
