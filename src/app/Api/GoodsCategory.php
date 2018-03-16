<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\GoodsCategoryDm;

/**
 * 8.2 商品分类接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-15
 */
class GoodsCategory extends BaseApi {

    /**
    * 接口参数规则
    */
    public function getRules() {

        return $this->rules(array(

            'add' => array(

                'category_name' => 'category_name|string|true||商品分类名称',

                'short_name' => 'short_name|string|false||商品分类简称',

                'pid' => 'pid|int|false|0|父级id',

                'level' => 'level|int|false|1|分类等级',

                'is_visible' => 'is_visible|int|false|1|是否显示  1 显示 0 不显示',

                'attr_id' => 'attr_id|int|false||关联商品类型ID',

                'attr_name' => 'attr_name|string|false||关联类型名称',

                'keywords' => 'keywords|string|false||关键词',

                'description' => 'description|string|false||描述',

                'sort' => 'sort|int|false||种类',

                'index_show' => 'index_show|int|false||首页展示',

                'category_pic' => 'category_pic|string|false||商品分类图片'

            ),

            'getAll' => array(

                'category_id' => 'category_id|string|false||表序号',

                'category_name' => 'category_name|string|false||商品分类名称',

                'short_name' => 'short_name|string|false||商品分类简称',

                'pid' => 'pid|string|false||父级id',

                'level' => 'level|string|false||分类等级',

                'is_visible' => 'is_visible|string|false||是否显示  1 显示 0 不显示',

                'attr_id' => 'attr_id|string|false||关联商品类型ID',

                'attr_name' => 'attr_name|string|false||关联类型名称',

                'keywords' => 'keywords|string|false||关键词',

                'description' => 'description|string|false||描述',

                'sort' => 'sort|string|false||种类',

                'index_show' => 'index_show|int|false||首页展示',

                'category_pic' => 'category_pic|string|false||商品分类图片',

                'is_subclass' => 'is_subclass|int|false|2|是否显示子类别 1-是 2-否',

                'fields' => 'fields|string|false|*|查询字段',

                'order' => 'order|string|false||排序',

            ),

            'queryList' => array(

                'category_id' => 'category_id|string|false||表序号',

                'category_name' => 'category_name|string|false||商品分类名称',

                'short_name' => 'short_name|string|false||商品分类简称',

                'pid' => 'pid|string|false||父级id',

                'level' => 'level|string|false||分类等级',

                'is_visible' => 'is_visible|string|false||是否显示  1 显示 0 不显示',

                'attr_id' => 'attr_id|string|false||关联商品类型ID',

                'attr_name' => 'attr_name|string|false||关联类型名称',

                'keywords' => 'keywords|string|false||关键词',

                'description' => 'description|string|false||描述',

                'sort' => 'sort|string|false||种类',

                'no_code' => 'no_code|string|false||erp档口编号',

                'category_pic' => 'category_pic|string|false||商品分类图片',

                'is_subclass' => 'is_subclass|int|false|2|是否显示子类别 1-是 2-否',

                'fields' => 'fields|string|false|*|查询字段',

                'order' => 'order|string|false||排序',

                'index_show' => 'index_show|int|false||首页展示',

                'page' => 'page|int|true|1|页码',

                'page_size' => 'page_size|int|true|20|每页数据条数'

            ),

            'queryCount' => array(

                'category_id' => 'category_id|string|false||表序号',

                'category_name' => 'category_name|string|false||商品分类名称',

                'short_name' => 'short_name|string|false||商品分类简称',

                'pid' => 'pid|string|false||父级id',

                'level' => 'level|string|false||分类等级',

                'is_visible' => 'is_visible|string|false||是否显示  1 显示 0 不显示',

                'attr_id' => 'attr_id|string|false||关联商品类型ID',

                'attr_name' => 'attr_name|string|false||关联类型名称',

                'keywords' => 'keywords|string|false||关键词',

                'index_show' => 'index_show|int|false||首页展示',

                'description' => 'description|string|false||描述',

                'sort' => 'sort|string|false||种类',

                'category_pic' => 'category_pic|string|false||商品分类图片',

            ),

            'update' => array(

                'category_id' => 'category_id|string|true||表序号',

                'category_name' => 'category_name|string|false||商品分类名称',

                'short_name' => 'short_name|string|false||商品分类简称',

                'pid' => 'pid|string|false||父级id',

                'level' => 'level|string|false||分类等级',

                'is_visible' => 'is_visible|string|false||是否显示  1 显示 0 不显示',

                'attr_id' => 'attr_id|string|false||关联商品类型ID',

                'attr_name' => 'attr_name|string|false||关联类型名称',

                'keywords' => 'keywords|string|false||关键词',

                'description' => 'description|string|false||描述',

                'sort' => 'sort|string|false||种类',

                'index_show' => 'index_show|int|false||首页展示',

                'category_pic' => 'category_pic|string|false||商品分类图片',

            ),

            'getDetail' => array(

                'category_id' => 'category_id|string|false||表序号',

                'category_name' => 'category_name|string|false||商品分类名称',

                'short_name' => 'short_name|string|false||商品分类简称',

                'pid' => 'pid|string|false||父级id',

                'level' => 'level|string|false||分类等级',

                'is_visible' => 'is_visible|string|false||是否显示  1 显示 0 不显示',

                'attr_id' => 'attr_id|string|false||关联商品类型ID',

                'attr_name' => 'attr_name|string|false||关联类型名称',

                'keywords' => 'keywords|string|false||关键词',

                'description' => 'description|string|false||描述',

                'sort' => 'sort|string|false||种类',

                'no_code' => 'no_code|string|false||erp档口编号',

                'category_pic' => 'category_pic|string|false||商品分类图片',

                'fields' => 'fields|string|false|*|查询字段',

                'order' => 'order|string|false||排序',

            ),

            'remove' => array(

              'category_id' => 'category_id|int|true||商品分类id'
            
            )

        ));

    }

    /**
     * 新增商品分类
     * @desc 新增商品分类
     *
     * @return int ret 操作状态：200表示成功
     * @return int data 表序号
     * @return string msg 错误提示
     */
    public function add() {

        $params = $this->retriveRuleParams('add');

        return $this->dm->add($params);

    }

    /**
     * 修改商品分类
     * @desc 修改商品分类
     *
     * @return int ret 操作状态：200表示成功
     * @return int data 修改结果条数
     * @return string msg 错误提示
     */
    public function update() {

        $params = $this->retriveRuleParams('update');

        $regulation = array(

            'category_id' => 'required',

        );

        \App\Verification($params, $regulation);

        return $this->dm->update($params);

    }

    /**
     * 查询商品分类详情
     * @desc 查询商品分类详情
     *
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return int data.category_id 表序号
     * @return string data.category_name 分类名称
     * @return string data.short_name 商品分类简称
     * @return int data.pid 父级id
     * @return int data.level 分类等级
     * @return int data.is_visible 是否显示  1 显示 0 不显示
     * @return int data.attr_id 关联商品类型ID
     * @return arstringray data.attr_name 关联类型名称
     * @return string data.keywords 关键词
     * @return string data.description 描述
     * @return int data.sort 种类
     * @return string data.category_pic 商品分类图片
     * @return string msg 错误提示
     */
    public function getDetail() {

        $conditions = $this->retriveRuleParams('getDetail');

        \App\Verification($conditions, $regulation);

        $regulation = array();

        return $this->dm->getDetail($conditions);

    }

    /**
     * 查询商品分类列表
     * @desc 查询商品分类列表
     *
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return int data.total 数据总条数
     * @return int data.page 当前页码
     * @return array data.list[] 结果列表
     * @return int data.list[].category_id 表序号
     * @return string data.list[].category_name 分类名称
     * @return string data.list[].short_name 商品分类简称
     * @return int data.list[].pid 父级id
     * @return int data.list[].level 分类等级
     * @return int data.list[].is_visible 是否显示  1 显示 0 不显示
     * @return int data.list[].attr_id 关联商品类型ID
     * @return string data.list[].attr_name 关联类型名称
     * @return string data.list[].keywords 关键词
     * @return string data.list[].description 描述
     * @return int data.list[].sort 种类
     * @return string data.list[].category_pic 商品分类图片
     * @return string data.list[].subclass[] 子类（字段同上）
     * @return string msg 错误提示
     */
    public function queryList() {

        $conditions = $this->retriveRuleParams('queryList');

        $regulation = array();

        \App\Verification($conditions, $regulation);

        return $this->dm->queryList($conditions);

    }

    /**
     * 查询商品分类数量
     * @desc 查询商品分类数量
     *
     * @return int ret 操作状态：200表示成功
     * @return int data 总体条数
     * @return string msg 错误提示
     */
    public function queryCount() {

        $conditions = $this->retriveRuleParams('queryCount');

        $regulation = array();

        \App\Verification($conditions, $regulation);

        return $this->dm->queryCount($conditions);

    }

    /**
     * 查询商品分类全部列表
     * @desc 查询商品分类全部列表
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
     * 删除商品分类
     * @desc 删除商品分类
     *
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function remove() {
    
      return $this->dm->remove($this->retriveRuleParams(__FUNCTION__));
    
    }

}
