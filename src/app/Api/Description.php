<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\DescriptionDm;

/**
 * 15.1 网站说明接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-10-18
 */
class Description extends BaseApi {

  /**
   * 网站说明接口参数规则
   */
  public function getRules() {

    return $this->rules(array(

      'add' => array(

        'title' => 'title|string|true||标题',
      
        'content' => 'content|string|true||说明内容',

        'status' => 'status|int|true||状态 1-可用 2-禁用',
        
        'type' => 'type|int|true||类型 1-充值说明',

        'shop_id' => 'shop_id|int|false||店铺id',

      ),

      'queryList' => array(

        'title' => 'title|string|false||标题',
      
        'content' => 'content|string|false||说明内容',

        'status' => 'status|int|false||状态 1-可用 2-禁用',
        
        'type' => 'type|int|false||类型 1-充值说明',

        'shop_id' => 'shop_id|int|false||店铺id',

        'created_at' => 'created_at|string|false||创建时间',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|20|每页数据条数'

      ),

      'update' => array(

        'id' => 'id|int|true||序号',

        'title' => 'title|string|false||标题',
      
        'content' => 'content|string|false||说明内容',

        'status' => 'status|int|false||状态 1-可用 2-禁用',
        
        'type' => 'type|int|false||类型 1-充值说明',

        'shop_id' => 'shop_id|int|false||店铺id',
      
      ),

      'getDetails' => array(

        'id' => 'id|int|false||序号',

        'title' => 'title|string|false||标题',
      
        'content' => 'content|string|false||说明内容',

        'status' => 'status|int|false||状态 1-可用 2-禁用',
        
        'type' => 'type|int|false||类型 1-充值说明',

        'shop_id' => 'shop_id|int|false||店铺id',

      ),

      'enable' => array(

        'id' => 'id|int|true||规则id',
      
      ),

      'disable' => array(

        'id' => 'id|int|true||规则id',
      
      ),
      
    ));

  }

  /**
   * 网站说明启用
   * @desc 网站说明启用
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 返回修改结果条数
   * @return string msg 错误提示
   */
  public function enable() {

    $regulation = array(
      'id' => 'required',
    );

    $conditions = $this->retriveRuleParams('enable');

    \App\Verification($conditions, $regulation);

    return $this->dm->enable($conditions);
  
  }

  /**
   * 网站说明禁用
   * @desc 网站说明禁用
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 返回修改结果条数
   * @return string msg 错误提示
   */
  public function disable() {

    $regulation = array(
      'id' => 'required',
    );

    $conditions = $this->retriveRuleParams('disable');

    \App\Verification($conditions, $regulation);

    return $this->dm->disable($conditions);
  
  }

  /**
   * 新增网站说明
   * @desc 
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 表序号
   * @return string msg 错误提示
   */
  public function add() {

    $regulation = array(
      'title' => 'required',
      'content' => 'required',
      'status' => 'required',
      'type' => 'required',
    );

    $params = $this->retriveRuleParams('add');

    \App\Verification($params, $regulation);

    return $this->dm->add($params);
  
  }

  /**
   * 查询网站说明列表
   * @desc 获取网站说明
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return array data.total 数据总条数
   * @return array data.page 当前页码
   * @return array data.list[] 数据队列
   * @return array data.list[].id 表序号
   * @return array data.list[].title 标题
   * @return array data.list[].content 内容
   * @return array data.list[].status 状态：1-可用，2-禁用
   * @return array data.list[].created_at 创建时间
   * @return array data.list[].updated_at 更新时间
   * @return array data.list[].type 类型 1-充值说明
   * @return array data.list[].shop_id 店铺id
   * @return string msg 错误提示
   */
  public function queryList() {

    return $conditions = $this->retriveRuleParams('queryList');

    $regulation = array();

    \App\Verification($conditions, $regulation);

    return $this->dm->queryList($conditions);

  }

  /**
   * 查询网站说明详情
   * @desc 
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return array data.id 表序号
   * @return array data.title 标题
   * @return array data.content 内容
   * @return array data.status 状态：1-可用，2-禁用
   * @return array data.created_at 创建时间
   * @return array data.updated_at 更新时间
   * @return array data.type 类型 1-充值说明
   * @return array data.shop_id 店铺id
   * @return string msg 错误提示
   */
  public function getDetails() {

    $conditions = $this->retriveRuleParams('getDetails');
  
    $regulation = array();

    \App\Verification($conditions, $regulation);

    return $this->dm->getDetails($conditions);
  
  }

  /**
   * 编辑网站说明
   * @desc 
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 返回修改结果条数
   * @return string msg 错误提示
   */
  public function update() {

    $conditions = $this->retriveRuleParams('update');
  
    $regulation = array();

    \App\Verification($conditions, $regulation);

    return $this->dm->update($conditions);
  
  }

}
