<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\UserObtainPointsRuleDm;

/**
 * 2.4 用户获取积分规则接口
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-10-24
 */
class UserObtainPointsRule extends BaseApi {

  /**
   * 接口参数规则
   */
  public function getRules() {

    return $this->rules(array(

      'add' => array(

        'name' => 'name|string|true||规则名称',

        'point_rule_code' => 'point_rule_code|string|true||规则编码',

        'points' => 'points|int|true||积分额度',

        'priority' => 'priority|int|true||优先级，数字越小，优先级越高，0为最高优先级',

        'status' => 'status|int|true||规则状态：1 有效，0 无效',

        'term_type' => 'term_type|int|true||有效期类型',

        'last_long' => 'last_long|int|true||是否长期有效',

        'start_date' => 'start_date|string|false||有效期起始日, 0为一直有效',
        
        'expire_date' => 'expire_date|string|false||有效期截止日, 0为一直有效',

        'valid_days' => 'valid_days|int|false||有效时长（日）'

      ),

      'queryList' => array(

        'name' => 'name|string|false||规则名称',

        'point_rule_code' => 'point_rule_code|string|false||规则编码',

        'status' => 'status|int|false||规则状态',

        'term_type' => 'term_type|int|false||有效期类型',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|20|每页数据条数'

      ),

      'update' => array(

        'id' => 'id|int|true||规则id',

        'name' => 'name|string|false||规则名称',

        'operator' => 'operator|int|false||创建人',

        'channel_type' => 'channel_type|int|false||使用渠道类型：0 全渠道，1 门店，2 线上消费',

        'channel' => 'channel|int|false||使用渠道id: 0 全部，门店id， 线上商城：9999',

        'action' => 'action|string|false||请求操作',

        'points' => 'points|int|false||积分额度',

        'priority' => 'priority|int|false||优先级，数字越小，优先级越高，0为最高优先级',

        'status' => 'status|int|false||规则状态：1 有效，0 无效',

        'start_date' => 'start_date|int|false||有效期起始日, 0为一直有效',
        
        'expire_date' => 'expire_date|int|false||有效期截止日, 0为一直有效',

        'deleted_at' => 'deleted_at|int|false||删除时间 1-删除',
      
      ),

      'getDetail' => array(

        'id' => 'id|int|true||规则id',
      
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
   * 新增获取积分规则
   * @desc 新增用户获取积分规则
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function add() {

    $regulation = array(
      'name' => 'required',
      'points' => 'required',
      'priority' => 'required',
    );

    $params = $this->retriveRuleParams('add');

    \App\Verification($params, $regulation);

    return $this->dm->add($params);
  
  }

  /**
   * 修改获取积分规则
   * @desc 修改用户获取积分规则
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function update() {

    $regulation = array(
      'id' => 'required',
    );

    $params = $this->retriveRuleParams('update');

    \App\Verification($params, $regulation);

    return $this->dm->update($params);
  
  }

  /**
   * 查询获取积分规则详情
   * @desc 查询用户获取积分规则详情
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function getDetail() {

    $regulation = array(
      'id' => 'required',
    );

    $conditions = $this->retriveRuleParams('getDetail');

    \App\Verification($conditions, $regulation);

    return $this->dm->getDetail($conditions);
  
  }

  /**
   * 获取积分规则启用
   * @desc 用户获取积分规则启用
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
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
   * 获取积分规则禁用
   * @desc 用户获取积分规则禁用
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
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
   * 查询获取积分规则列表
   * @desc 查询用户获取积分规则列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function queryList() {

    $conditions = $this->retriveRuleParams('queryList');

    return $this->dm->queryList($conditions);

  }

}
