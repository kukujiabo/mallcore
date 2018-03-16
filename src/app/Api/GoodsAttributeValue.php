<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\GoodsAttributeValueDm;

/**
 * 8.4 商品规格值模版接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-12-27
 */
class GoodsAttributeValue extends BaseApi {

    /**
     * 接口参数规则
     */
    public function getRules() {

        return $this->rules(array(

            'add' => array(

                'attr_id' => 'attr_id|int|true||商品属性ID',

                'attr_value' => 'attr_value|string|true||值名称',

                'goods_id' => 'goods_id|int|false||商品ID',

                'is_visible' => 'is_visible|int|false||是否可视 1-是 2-否',

                'active' => 'active|int|false||是否有效 1-有效 2-无效',

                'sort' => 'sort|int|false||排序',

            ),

            'getAll' => array(

                'attr_value_id' => 'attr_value_id|int|false||表序号',

                'goods_id' => 'goods_id|int|false||商品ID',

                'attr_id' => 'attr_id|int|false||商品属性ID',

                'attr_value' => 'attr_value|string|false||值名称',

                'is_visible' => 'is_visible|int|false||是否可视 1-是 2-否',

                'active' => 'active|int|false||是否有效 1-有效 2-无效',

                'sort' => 'sort|int|false||排序',
                
                'create_time' => 'create_time|string|false||创建时间',

            ),

            'queryList' => array(

                'attr_value_id' => 'attr_value_id|int|false||表序号',

                'goods_id' => 'goods_id|int|false||商品ID',

                'attr_id' => 'attr_id|int|false||商品属性ID',

                'attr_value' => 'attr_value|string|false||值名称',

                'is_visible' => 'is_visible|int|false||是否可视 1-是 2-否',

                'active' => 'active|int|false||是否有效 1-有效 2-无效',

                'sort' => 'sort|int|false||排序',
                
                'create_time' => 'create_time|string|false||创建时间',

                'fields' => 'fields|string|false|*|查询字段',

                'order' => 'order|string|false||排序',

                'page' => 'page|int|true|1|页码',

                'page_size' => 'page_size|int|true|20|每页数据条数'

            ),

            'queryCount' => array(

                'attr_value_id' => 'attr_value_id|int|false||表序号',

                'attr_id' => 'attr_id|int|false||商品属性ID',

                'attr_value' => 'attr_value|string|false||值名称',

                'is_visible' => 'is_visible|int|false||是否可视 1-是 2-否',

                'active' => 'active|int|false||是否有效 1-有效 2-无效',

                'sort' => 'sort|int|false||排序',
                
                'create_time' => 'create_time|string|false||创建时间',

            ),

            'update' => array(

                'attr_value_id' => 'attr_value_id|int|true||表序号',

                'attr_id' => 'attr_id|int|false||商品属性ID',

                'attr_value' => 'attr_value|string|false||值名称',

                'is_visible' => 'is_visible|int|false||是否可视 1-是 2-否',

                'active' => 'active|int|false||是否有效 1-有效 2-无效',

                'sort' => 'sort|int|false||排序',
                
                'create_time' => 'create_time|string|false||创建时间',

            ),

            'getDetail' => array(

                'attr_value_id' => 'attr_value_id|int|true||表序号',

                'attr_id' => 'attr_id|int|false||商品属性ID',

                'attr_value' => 'attr_value|string|false||值名称',

                'is_visible' => 'is_visible|int|false||是否可视 1-是 2-否',

                'active' => 'active|int|false||是否有效 1-有效 2-无效',

                'sort' => 'sort|int|false||排序',
                
                'create_time' => 'create_time|string|false||创建时间',

            ),
          
        ));

    }

    /**
     * 新增商品规格值模版
     * @desc 新增商品规格值模版
     *
     * @return int ret 操作状态：200表示成功
     * @return int data 表序号
     * @return string msg 错误提示
     */
    public function add() {

        $regulation = array(
            'attr_id' => 'required',
            'attr_value' => 'required',
        );

        $params = $this->retriveRuleParams(__FUNCTION__);

        \App\Verification($params, $regulation);

        return $this->dm->add($params);
  
    }

    /**
     * 修改商品规格值模版
     * @desc 修改商品规格值模版
     *
     * @return int ret 操作状态：200表示成功
     * @return int data 修改的条数
     * @return string msg 错误提示
     */
    public function update() {

        $regulation = array(
            'attr_value_id' => 'required',
        );

        $params = $this->retriveRuleParams(__FUNCTION__);

        \App\Verification($params, $regulation);

        return $this->dm->update($params);
  
    }

    /**
     * 查询商品规格值模版详情
     * @desc 查询商品规格值模版详情
     *
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function getDetail() {

        $regulation = array(
            'attr_value_id' => 'required',
        );

        $conditions = $this->retriveRuleParams(__FUNCTION__);

        \App\Verification($conditions, $regulation);

        return $this->dm->getDetail($conditions);
  
    }

    /**
     * 获取全部的商品规格值模版
     * @desc 获取全部的商品规格值模版
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
     * 查询商品规格值模版列表
     * @desc 查询商品规格值模版列表
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
     * 查询商品规格值模版数量
     * @desc 查询商品规格值模版数量
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
