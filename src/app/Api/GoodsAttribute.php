<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\GoodsAttributeDm;

/**
 * 8.3 商品属性接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-12-27
 */
class GoodsAttribute extends BaseApi {

    /**
     * 接口参数规则
     */
    public function getRules() {

        return $this->rules(array(

            'add' => array(

                'goods_id' => 'goods_id|int|true||商品ID',

                'shop_id' => 'shop_id|int|true||店铺id',

                'attr_value_id' => 'attr_value_id|int|true||属性值id',

                'attr_value' => 'attr_value|string|true||属性值名称',

                'attr_value_name' => 'attr_value_name|string|true||属性值对应数据值',

                'active' => 'active|int|false||是否有效 1-有效 2-无效',

                'sort' => 'sort|int|false||排序',

            ),

            'getAll' => array(

                'attr_id' => 'attr_id|int|false||表序号',

                'goods_id' => 'goods_id|int|false||商品ID',

                'shop_id' => 'shop_id|int|false||店铺id',

                'attr_value_id' => 'attr_value_id|int|false||属性值id',

                'attr_value' => 'attr_value|string|false||属性值名称',

                'attr_value_name' => 'attr_value_name|string|false||属性值对应数据值',

                'active' => 'active|int|false||是否有效 1-有效 2-无效',

                'sort' => 'sort|int|false||排序',
                
                'create_time' => 'create_time|string|false||创建时间',

            ),

            'queryList' => array(

                'attr_id' => 'attr_id|int|false||表序号',

                'goods_id' => 'goods_id|int|false||商品ID',

                'shop_id' => 'shop_id|int|false||店铺id',

                'attr_value_id' => 'attr_value_id|int|false||属性值id',

                'attr_value' => 'attr_value|string|false||属性值名称',

                'attr_value_name' => 'attr_value_name|string|false||属性值对应数据值',

                'active' => 'active|int|false||是否有效 1-有效 2-无效',

                'sort' => 'sort|int|false||排序',
                
                'create_time' => 'create_time|string|false||创建时间',

                'fields' => 'fields|string|false|*|查询字段',

                'order' => 'order|string|false||排序',

                'page' => 'page|int|true|1|页码',

                'page_size' => 'page_size|int|true|20|每页数据条数'

            ),

            'queryCount' => array(

                'attr_id' => 'attr_id|int|false||表序号',

                'goods_id' => 'goods_id|int|false||商品ID',

                'shop_id' => 'shop_id|int|false||店铺id',

                'attr_value_id' => 'attr_value_id|int|false||属性值id',

                'attr_value' => 'attr_value|string|false||属性值名称',

                'attr_value_name' => 'attr_value_name|string|false||属性值对应数据值',

                'active' => 'active|int|false||是否有效 1-有效 2-无效',

                'sort' => 'sort|int|false||排序',
                
                'create_time' => 'create_time|string|false||创建时间',

            ),

            'update' => array(

                'attr_id' => 'attr_id|int|true||表序号',

                'goods_id' => 'goods_id|int|false||商品ID',

                'shop_id' => 'shop_id|int|false||店铺id',

                'attr_value_id' => 'attr_value_id|int|false||属性值id',

                'attr_value' => 'attr_value|string|false||属性值名称',

                'attr_value_name' => 'attr_value_name|string|false||属性值对应数据值',

                'active' => 'active|int|false||是否有效 1-有效 2-无效',

                'sort' => 'sort|int|false||排序',
                
                'create_time' => 'create_time|string|false||创建时间',

            ),

            'getDetail' => array(

                'attr_id' => 'attr_id|int|true||表序号',

                'goods_id' => 'goods_id|int|false||商品ID',

                'shop_id' => 'shop_id|int|false||店铺id',

                'attr_value_id' => 'attr_value_id|int|false||属性值id',

                'attr_value' => 'attr_value|string|false||属性值名称',

                'attr_value_name' => 'attr_value_name|string|false||属性值对应数据值',

                'active' => 'active|int|false||是否有效 1-有效 2-无效',

                'sort' => 'sort|int|false||排序',
                
                'create_time' => 'create_time|string|false||创建时间',

            ),
          
        ));

    }

    /**
     * 新增商品属性
     * @desc 新增商品属性
     *
     * @return int ret 操作状态：200表示成功
     * @return int data 表序号
     * @return string msg 错误提示
     */
    public function add() {

        $regulation = array(
            'goods_id' => 'required',
            'shop_id' => 'required',
            'attr_value_id' => 'required',
            'attr_value' => 'required',
            'attr_value_name' => 'required',
        );

        $params = $this->retriveRuleParams(__FUNCTION__);

        \App\Verification($params, $regulation);

        return $this->dm->add($params);
  
    }

    /**
     * 修改商品属性
     * @desc 修改商品属性
     *
     * @return int ret 操作状态：200表示成功
     * @return int data 修改的条数
     * @return string msg 错误提示
     */
    public function update() {

        $regulation = array(
            'attr_id' => 'required',
        );

        $params = $this->retriveRuleParams(__FUNCTION__);

        \App\Verification($params, $regulation);

        return $this->dm->update($params);
  
    }

    /**
     * 查询商品属性详情
     * @desc 查询商品属性详情
     *
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function getDetail() {

        $regulation = array(
            'attr_id' => 'required',
        );

        $conditions = $this->retriveRuleParams(__FUNCTION__);

        \App\Verification($conditions, $regulation);

        return $this->dm->getDetail($conditions);
  
    }

    /**
     * 获取全部的商品属性
     * @desc 获取全部的商品属性
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
     * 查询商品属性列表
     * @desc 查询商品属性列表
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
     * 查询商品属性数量
     * @desc 查询商品属性数量
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
