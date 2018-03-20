<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\GoodsSkuDm;

/**
 * 8.5 SKU商品接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-12-27
 */
class GoodsSku extends BaseApi {

    /**
     * 接口参数规则
     */
    public function getRules() {

        return $this->rules(array(

            'add' => array(

                'shop_id' => 'shop_id|int|true||店铺id',

                'goods_id' => 'goods_id|int|true||商品编号',

                'sku_name' => 'sku_name|string|true||SKU名称',

                'attr_value_items' => 'attr_value_items|string|false||属性和属性值 id串 attribute + attribute value 表ID分号分隔',

                'attr_value_items_format' => 'attr_value_items_format|string|true||属性和属性值id串组合json格式',

                'market_price' => 'market_price|float|false||市场价',

                'price' => 'price|float|true||价格',

                'promote_price' => 'promote_price|float|false||促销价格',

                'cost_price' => 'cost_price|float|false||成本价',

                'stock' => 'stock|int|true||库存',

                'picture' => 'picture|string|false||如果是第一个sku编码，可以加图片',

                'code' => 'code|string|false||商家编码',

                'QRcode' => 'QRcode|string|false||商品二维码',

                'active' => 'active|int|false||是否有效 1-有效 2-无效',

            ),

            'queryList' => array(

                'city_code' => 'city_code|int|false||城市代码',

                'user_level' => 'user_level|int|false||用户等级',

                'sku_id' => 'sku_id|int|false||表序号',

                'shop_id' => 'shop_id|int|false||店铺id',

                'goods_id' => 'goods_id|int|false||商品编号',

                'sku_name' => 'sku_name|string|false||SKU名称',

                'attr_value_items' => 'attr_value_items|string|false||属性和属性值 id串 attribute + attribute value 表ID分号分隔',

                'attr_value_items_format' => 'attr_value_items_format|string|false||属性和属性值id串组合json格式',

                'market_price' => 'market_price|float|false||市场价',

                'price' => 'price|float|false||价格',

                'promote_price' => 'promote_price|float|false||促销价格',

                'cost_price' => 'cost_price|float|false||成本价',

                'stock' => 'stock|int|false||库存',

                'picture' => 'picture|string|false||如果是第一个sku编码，可以加图片',
                
                'code' => 'code|string|false||商家编码',

                'QRcode' => 'QRcode|string|false||商品二维码',

                'active' => 'active|int|false||是否有效 1-有效 2-无效',
                
                'create_date' => 'create_date|string|false||创建时间',
                
                'update_date' => 'update_date|string|false||修改时间',

                'fields' => 'fields|string|false|*|查询字段',

                'order' => 'order|string|false||排序',

                'page' => 'page|int|true|1|页码',

                'page_size' => 'page_size|int|true|20|每页数据条数'

            ),

            'getAll' => array(

                'city_code' => 'city_code|int|false||城市代码',

                'user_level' => 'user_level|int|false||用户等级',

                'sku_id' => 'sku_id|int|false||表序号',

                'shop_id' => 'shop_id|int|false||店铺id',

                'goods_id' => 'goods_id|int|false||商品编号',

                'sku_name' => 'sku_name|string|false||SKU名称',

                'attr_value_items' => 'attr_value_items|string|false||属性和属性值 id串 attribute + attribute value 表ID分号分隔',

                'attr_value_items_format' => 'attr_value_items_format|string|false||属性和属性值id串组合json格式',

                'market_price' => 'market_price|float|false||市场价',

                'price' => 'price|float|false||价格',

                'promote_price' => 'promote_price|float|false||促销价格',

                'cost_price' => 'cost_price|float|false||成本价',

                'stock' => 'stock|int|false||库存',

                'picture' => 'picture|string|false||如果是第一个sku编码，可以加图片',
                
                'code' => 'code|string|false||商家编码',

                'QRcode' => 'QRcode|string|false||商品二维码',

                'active' => 'active|int|false||是否有效 1-有效 2-无效',
                
                'create_date' => 'create_date|string|false||创建时间',
                
                'update_date' => 'update_date|string|false||修改时间',

            ),

            'queryCount' => array(

                'sku_id' => 'sku_id|int|false||表序号',

                'shop_id' => 'shop_id|int|false||店铺id',

                'goods_id' => 'goods_id|int|false||商品编号',

                'sku_name' => 'sku_name|string|false||SKU名称',

                'attr_value_items' => 'attr_value_items|string|false||属性和属性值 id串 attribute + attribute value 表ID分号分隔',

                'attr_value_items_format' => 'attr_value_items_format|string|false||属性和属性值id串组合json格式',

                'market_price' => 'market_price|float|false||市场价',

                'price' => 'price|float|false||价格',

                'promote_price' => 'promote_price|float|false||促销价格',

                'cost_price' => 'cost_price|float|false||成本价',

                'stock' => 'stock|int|false||库存',

                'picture' => 'picture|string|false||如果是第一个sku编码，可以加图片',
                
                'code' => 'code|string|false||商家编码',

                'QRcode' => 'QRcode|string|false||商品二维码',

                'active' => 'active|int|false||是否有效 1-有效 2-无效',
                
                'create_date' => 'create_date|string|false||创建时间',
                
                'update_date' => 'update_date|string|false||修改时间',

            ),

            'update' => array(

                'sku_id' => 'sku_id|int|true||表序号',

                'shop_id' => 'shop_id|int|false||店铺id',

                'goods_id' => 'goods_id|int|false||商品编号',

                'sku_name' => 'sku_name|string|false||SKU名称',

                'attr_value_items' => 'attr_value_items|string|false||属性和属性值 id串 attribute + attribute value 表ID分号分隔',

                'attr_value_items_format' => 'attr_value_items_format|string|false||属性和属性值id串组合json格式',

                'market_price' => 'market_price|float|false||市场价',

                'price' => 'price|float|false||价格',

                'promote_price' => 'promote_price|float|false||促销价格',

                'cost_price' => 'cost_price|float|false||成本价',

                'stock' => 'stock|int|false||库存',

                'picture' => 'picture|string|false||如果是第一个sku编码，可以加图片',
                
                'code' => 'code|string|false||商家编码',

                'active' => 'active|int|false||是否有效 1-有效 2-无效',

                'QRcode' => 'QRcode|string|false||商品二维码',
                
                'create_date' => 'create_date|string|false||创建时间',

            ),

            'getDetail' => array(

                'city_code' => 'city_code|int|false||城市代码',

                'user_level' => 'user_level|int|false||用户等级',

                'sku_id' => 'sku_id|int|true||表序号',

                'shop_id' => 'shop_id|int|false||店铺id',

                'goods_id' => 'goods_id|int|false||商品编号',

                'sku_name' => 'sku_name|string|false||SKU名称',

                'attr_value_items' => 'attr_value_items|string|false||属性和属性值 id串 attribute + attribute value 表ID分号分隔',

                'attr_value_items_format' => 'attr_value_items_format|string|false||属性和属性值id串组合json格式',

                'market_price' => 'market_price|float|false||市场价',

                'price' => 'price|float|false||价格',

                'promote_price' => 'promote_price|float|false||促销价格',

                'cost_price' => 'cost_price|float|false||成本价',

                'stock' => 'stock|int|false||库存',

                'picture' => 'picture|string|false||如果是第一个sku编码，可以加图片',
                
                'code' => 'code|string|false||商家编码',

                'QRcode' => 'QRcode|string|false||商品二维码',

                'active' => 'active|int|false||是否有效 1-有效 2-无效',
                
                'create_date' => 'create_date|string|false||创建时间',
                
                'update_date' => 'update_date|string|false||修改时间',

            ),
          
        ));

    }

    /**
     * 新增SKU商品
     * @desc 新增SKU商品
     *
     * @return int ret 操作状态：200表示成功
     * @return int data 表序号
     * @return string msg 错误提示
     */
    public function add() {

        $regulation = array(
            'shop_id' => 'required',
            'goods_id' => 'required',
            'sku_name' => 'required',
            'attr_value_items_format' => 'required',
            'price' => 'required',
            'stock' => 'required',
        );

        $params = $this->retriveRuleParams(__FUNCTION__);

        \App\Verification($params, $regulation);

        return $this->dm->add($params);
  
    }

    /**
     * 修改SKU商品
     * @desc 修改SKU商品
     *
     * @return int ret 操作状态：200表示成功
     * @return int data 修改的条数
     * @return string msg 错误提示
     */
    public function update() {

        $regulation = array(
            'sku_id' => 'required',
        );

        $params = $this->retriveRuleParams(__FUNCTION__);

        \App\Verification($params, $regulation);

        return $this->dm->update($params);
  
    }

    /**
     * 查询SKU商品详情
     * @desc 查询SKU商品详情
     *
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function getDetail() {

        $conditions = $this->retriveRuleParams(__FUNCTION__);

        return $this->dm->getDetail($conditions);
  
    }

    /**
     * 查询SKU商品列表
     * @desc 查询SKU商品列表
     *
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function queryList() {

        $conditions = $this->retriveRuleParams(__FUNCTION__);

        return $this->dm->queryList($conditions);

    }

    /**
     * 获取全部的SKU商品
     * @desc 获取全部的SKU商品
     *
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function getAll() {

        $conditions = $this->retriveRuleParams(__FUNCTION__);

        return $this->dm->getAll($conditions);

    }

    /**
     * 查询SKU商品数量
     * @desc 查询SKU商品数量
     *
     * @return int ret 操作状态：200表示成功
     * @return int data 总数量
     * @return string msg 错误提示
     */
    public function queryCount() {

        $conditions = $this->retriveRuleParams(__FUNCTION__);
      
        $regulation = array();

        \App\Verification($conditions, $regulation);

        return $this->dm->queryCount($conditions);
  
    }

}
