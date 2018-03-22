<?php

namespace App\Api;

use PhalApi\Api;
use PhalApi\Exception;

/**
 * 14.1 外卖购物车接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-15
 */
class CartTakeOut extends BaseApi {

  public function getRules() {

    return $this->rules(array(

      'add' => array(
      
        'way' => 'way|int|true|1|途径 1-前台会员 2-后台管理员',

        'token' => 'token|string|false||用户令牌（way为1则必传）',

        'buyer_id' => 'buyer_id|int|false||用户id',

        'shop_id' => 'shop_id|int|false||卖家店铺id',

        'shop_name' => 'shop_name|string|false||店铺名称',

        'goods_id' => 'goods_id|int|true||商品id',

        'goods_name' => 'goods_name|string|false||商品名称',

        'sku_id' => 'sku_id|int|false||商品的skuid',

        'sku_name' => 'sku_name|string|false||商品的sku名称',

        'price' => 'price|float|false||商品价格',
        
        'num' => 'num|int|true||商品数量',

        'goods_picture' => 'goods_picture|string|false||商品图片',

        'bl_id' => 'bl_id|int|false||组合套装ID',

        'city_code' => 'city_code|int|false||城市编码'

      ),

      'queryList' => array(
      
        'way' => 'way|int|true|1|途径 1-前台会员 2-后台管理员',

        'token' => 'token|string|false||用户令牌（way为1则必传）',

        'cart_id' => 'cart_id|string|false||购物车id',

        'buyer_id' => 'buyer_id|string|false||用户id',

        'shop_id' => 'shop_id|string|false||卖家店铺id',

        'shop_name' => 'shop_name|string|false||店铺名称',

        'goods_id' => 'goods_id|string|false||商品id',

        'goods_name' => 'goods_name|string|false||商品名称',

        'sku_id' => 'sku_id|string|false||商品的skuid',

        'sku_name' => 'sku_name|string|false||商品的sku名称',

        'price' => 'price|string|false||商品价格',
        
        'num' => 'num|string|false||商品数量',

        'goods_picture' => 'goods_picture|string|false||商品图片',

        'bl_id' => 'bl_id|string|false||组合套装ID',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序'

      ),

      'queryCount' => array(
      
        'way' => 'way|int|true|1|途径 1-前台会员 2-后台管理员',

        'token' => 'token|string|false||用户令牌（way为1则必传）',

        'cart_id' => 'cart_id|string|false||购物车id',

        'buyer_id' => 'buyer_id|string|false||用户id',

        'shop_id' => 'shop_id|string|false||卖家店铺id',

        'shop_name' => 'shop_name|string|false||店铺名称',

        'goods_id' => 'goods_id|string|false||商品id',

        'goods_name' => 'goods_name|string|false||商品名称',

        'sku_id' => 'sku_id|string|false||商品的skuid',

        'sku_name' => 'sku_name|string|false||商品的sku名称',

        'price' => 'price|string|false||商品价格',
        
        'num' => 'num|string|false||商品数量',

        'goods_picture' => 'goods_picture|string|false||商品图片',
      
      ),

      'update' => array(
      
        'way' => 'way|int|true|1|途径 1-前台会员 2-后台管理员',

        'token' => 'token|string|false||用户令牌（way为1则必传）',

        'cart_id' => 'cart_id|string|true||购物车id',

        'buyer_id' => 'buyer_id|string|false||用户id',

        'shop_id' => 'shop_id|string|false||卖家店铺id',

        'shop_name' => 'shop_name|string|false||店铺名称',

        'goods_id' => 'goods_id|string|false||商品id',

        'goods_name' => 'goods_name|string|false||商品名称',

        'sku_id' => 'sku_id|string|false||商品的skuid',

        'sku_name' => 'sku_name|string|false||商品的sku名称',

        'price' => 'price|string|false||商品价格',
        
        'num' => 'num|int|false||商品数量（最终数量）',

        'totalizer_num' => 'totalizer_num|int|false||商品数量（累加数量）',

        'goods_picture' => 'goods_picture|string|false||商品图片'

      ),

      'getDetail' => array(
      
        'way' => 'way|int|true|1|途径 1-前台会员 2-后台管理员',

        'token' => 'token|string|false||用户令牌（way为1则必传）',

        'cart_id' => 'cart_id|string|false||购物车id',

        'buyer_id' => 'buyer_id|string|false||用户id',

        'shop_id' => 'shop_id|string|false||卖家店铺id',

        'shop_name' => 'shop_name|string|false||店铺名称',

        'goods_id' => 'goods_id|string|false||商品id',

        'goods_name' => 'goods_name|string|false||商品名称',

        'sku_id' => 'sku_id|string|false||商品的skuid',

        'sku_name' => 'sku_name|string|false||商品的sku名称',

        'price' => 'price|string|false||商品价格',
        
        'num' => 'num|string|false||商品数量',

        'goods_picture' => 'goods_picture|string|false||商品图片',

        'bl_id' => 'bl_id|string|false||组合套装ID',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',
      
      ),

      'cartEmpty' => array(
      
        'way' => 'way|int|true|1|途径 1-前台会员 2-后台管理员',

        'token' => 'token|string|false||用户令牌（way为1则必传）',

        'buyer_id' => 'buyer_id|string|false||用户id',
      
      ),

      'remove' => array(
      
        'token' => 'token|string|false||用户令牌',

        'cart_id' => 'cart_id|int|true||购物车id'
      
      )
      
    ));

  }

  /**
   * 清空外卖购物车
   * @desc 
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 类型Id
   * @return string msg 错误提示
   */
  public function cartEmpty() {

    $condition = $this->retriveRuleParams('cartEmpty');

    $regulation = array(
      'way' => 'required',
    );

    \App\Verification($condition, $regulation);

    return $this->dm->cartEmpty($condition);
  
  }

  /**
   * 新增外卖购物车
   * @desc 
   *
   * @return int ret 操作状态：200表示成功
   * @return boolean data true-成功 false-失败
   * @return string msg 错误提示
   */
  public function add() {

    $params = $this->retriveRuleParams('add');

    $regulation = array(
      'way' => 'required',
      'goods_id' => 'required',
      'num' => 'required',
    );

    \App\Verification($params, $regulation);

    return $this->dm->add($params);
  
  }

  /**
   * 修改外卖购物车
   * @desc 修改外卖购物车
   *
   * @return int ret 操作状态：200表示成功
   * @return int data 修改条数
   * @return string msg 错误提示
   */
  public function update() {

    $params = $this->retriveRuleParams('update');

    $regulation = array(

      'way' => 'required',

      'cart_id' => 'required',

    );

    \App\Verification($params, $regulation);

    return $this->dm->update($params);
  
  }

  /**
   * 查询外卖购物车详情
   * @desc 查询外卖购物车列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.cart_id 表序号
   * @return int data.buyer_id 买家id
   * @return int data.shop_id 店铺id
   * @return string data.shop_name 店铺名称
   * @return int data.goods_id 商品id
   * @return string data.goods_name 商品名称
   * @return int data.sku_id 商品的skuid
   * @return string data.sku_name 商品的sku名称
   * @return float data.price 商品价格
   * @return int data.num 购买商品数量
   * @return string data.goods_picture 商品图片
   * @return int data.bl_id 组合套装ID
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
   * 查询外卖购物车列表
   * @desc 查询外卖购物车列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.total 数据条数
   * @return int data.page 页码
   * @return array data.list[] 数据列表
   * @return int data.list[].cart_id 表序号
   * @return int data.list[].buyer_id 买家id
   * @return int data.list[].shop_id 店铺id
   * @return string data.list[].shop_name 店铺名称
   * @return int data.list[].goods_id 商品id
   * @return string data.list[].goods_name 商品名称
   * @return int data.list[].sku_id 商品的skuid
   * @return string data.list[].sku_name 商品的sku名称
   * @return float data.list[].price 商品价格
   * @return int data.list[].num 购买商品数量
   * @return string data.list[].goods_picture 商品图片
   * @return int data.list[].bl_id 组合套装ID
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
   * 查询外卖购物车数量
   * @desc 查询外卖购物车数量
   *
   * @return int ret 操作状态：200表示成功
   * @return int data 条数
   * @return string msg 错误提示
   */
  public function queryCount() {

    $conditions = $this->retriveRuleParams('queryCount');
  
    $regulation = array();

    \App\Verification($conditions, $regulation);

    return $this->dm->queryCount($conditions);
  
  }

  /**
   * 删除购物车商品
   * @desc 删除购物车商品
   *
   * @return int
   */
  public function remove() {
  
    $condition = $this->retriveRuleParams(__FUNCTION__);

    return $this->dm->remove($condition);
  
  }

}
