<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\OrderTakeOutGoodsDm;

/**
 * 6.2 外卖订单商品接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-11
 */
class OrderTakeOutGoods extends BaseApi {

  public function getRules() {

    return $this->rules(array(

      'add' => array(

        'order_take_out_id' => 'order_take_out_id|int|true||外卖订单id 表order_take_out的id',
      
        'uid' => 'uid|int|true||用户id',

        'goods_id' => 'goods_id|int|true||商品ID',
        
        'goods_name' => 'goods_name|string|true||商品名称',

        'sku_id' => 'sku_id|int|false||skuID',

        'sku_name' => 'sku_name|string|false||sku名称',

        'price' => 'price|float|true||商品价格',

        'cost_price' => 'cost_price|float|false||商品成本价',

        'num' => 'num|int|true||购买数量',

        'goods_money' => 'goods_money|float|true||商品总价',

        'goods_picture' => 'goods_picture|string|true||商品图片',

        'shop_id' => 'shop_id|int|true||店铺ID',

      ),

      'queryList' => array(

        'id' => 'id|int|false||表序号Id',

        'order_take_out_id' => 'order_take_out_id|int|false||外卖订单id 表order_take_out的id',
      
        'uid' => 'uid|int|false||用户id',

        'goods_id' => 'goods_id|int|false||商品ID',
        
        'goods_name' => 'goods_name|string|false||商品名称',

        'sku_id' => 'sku_id|int|false||skuID',

        'sku_name' => 'sku_name|string|false||sku名称',

        'price' => 'price|float|false||商品价格',

        'cost_price' => 'cost_price|float|false||商品成本价',

        'num' => 'num|int|false||购买数量',

        'goods_money' => 'goods_money|float|false||商品总价',

        'goods_picture' => 'goods_picture|string|false||商品图片',

        'shop_id' => 'shop_id|int|false||店铺ID',

      ),

      'queryCount' => array(

        'id' => 'id|int|false||表序号Id',

        'order_take_out_id' => 'order_take_out_id|int|false||外卖订单id 表order_take_out的id',
      
        'uid' => 'uid|int|false||用户id',

        'goods_id' => 'goods_id|int|false||商品ID',
        
        'goods_name' => 'goods_name|string|false||商品名称',

        'sku_id' => 'sku_id|int|false||skuID',

        'sku_name' => 'sku_name|string|false||sku名称',

        'price' => 'price|float|false||商品价格',

        'cost_price' => 'cost_price|float|false||商品成本价',

        'num' => 'num|int|false||购买数量',

        'goods_money' => 'goods_money|float|false||商品总价',

        'goods_picture' => 'goods_picture|string|false||商品图片',

        'shop_id' => 'shop_id|int|false||店铺ID',
      
      ),
      
    ));

  }

  /**
   * 新增外卖订单商品
   * @desc 
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 类型Id
   * @return string msg 错误提示
   */
  public function add() {

    $params = $this->retriveRuleParams('add');

    $regulation = array(
      'order_take_out_id' => 'required',
      'uid' => 'required',
      'goods_id' => 'required',
      'goods_name' => 'required',
      'price' => 'required',
      'num' => 'required',
      'goods_money' => 'required',
      'goods_picture' => 'required',
      'shop_id' => 'required',
    );

    \App\Verification($params, $regulation);

    return $this->dm->add($params);
  
  }

  /**
   * 查询外卖订单商品列表
   * @desc 查询外卖订单商品列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data[].id 表序号Id
   * @return int data[].order_take_out_id 外卖订单id 表order_take_out的id
   * @return int data[].uid 用户id
   * @return int data[].goods_id 商品ID
   * @return string data[].goods_name 商品名称
   * @return int data[].sku_id skuId
   * @return string data[].sku_name sku名称
   * @return float data[].price 商品价格
   * @return float data[].cost_price 商品成本价
   * @return int data[].num 购买数量
   * @return float data[].goods_money 商品总价
   * @return string data[].goods_picture 商品图片
   * @return int data[].shop_id 店铺ID
   * @return string msg 错误提示
   */
  public function queryList() {

    $conditions = $this->retriveRuleParams('queryList');

    $regulation = array();

    \App\Verification($conditions, $regulation);

    return $this->dm->queryList($conditions);

  }

  /**
   * 查询外卖订单商品数量
   * @desc 查询外卖订单商品数量
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
