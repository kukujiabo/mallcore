<?php
namespace App\Api;

/**
 * 27.1 系统定义活动
 *
 * @author: Meroc Chen <398515393@qq.com> 2017-12-22
 */
class Activity extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
    
      'createActivity' => array(

        'activity_name' => 'activity_name|string|true||活动名称',

        'activity_code' => 'activity_code|string|true||活动编码',

        'activity_shops' => 'activity_shops|string|false||活动门店',

        'start_date' => 'start_date|string|false||开始时间',

        'end_date' => 'end_date|string|false||结束时间',

        'priority' => 'priority|string|true||优先级',

        'description' => 'description|string|false||活动图文详情',

        'coupons' => 'coupons|string|false||活动配置优惠券',

        'exchange' => 'exchange|string|false||活动配置积分',

        'points' => 'points|string|false||活动配置积分',

        'type' => 'type|int|false||活动类型',

        'last_long' => 'last_long|int|false|0|是否长期有效：0，否；1，是',

        'all_shops' => 'all_shops|int|false|0|是否所有门店：0，否；1，是'

      ),

      'queryList' => array(

        'activity_name' => 'activity_name|string|false||活动名称',

        'activity_code' => 'activity_code|string|false||活动编码',

        'activity_shops' => 'activity_shops|string|false||活动门店',

        'page' => 'page|int|true|1|页码',

        'pageSize' => 'pageSize|int|true|20|每页数据条数'
      
      ),

      'testShareActivity' => array(
      
        'share_code' => 'share_code|string|false||分享码'
      
      ),

      'enable' => array(
      
        'id' => 'id|int|true||活动id'
      
      ),

      'disable' => array(
      
        'id' => 'id|int|true||活动id'
      
      )
    
    ));
  
  }

  /**
   * 添加活动
   * @desc 添加活动
   *
   * @return int ret 操作状态：200表示成功
   * @return array data
   * @return string msg 错误提示
   */
  public function createActivity() {
  
    return $this->dm->createActivity($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 查询活动列表
   * @desc 查询活动列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data
   * @return string msg 错误提示
   */
  public function queryList() {
  
    return $this->dm->queryList($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 测试分享活动接口
   * @desc 测试分享活动接口
   *
   * @return int ret
   */
  public function testShareActivity() {
  
    return $this->dm->testShareActivity($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 启用活动
   *
   * @desc 启用活动
   *
   * @return
   */
  public function enable() {
  
    return $this->dm->enable($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 停用活动
   *
   * @desc 停用活动
   *
   * @return
   */
  public function disable() {
  
    return $this->dm->disable($this->retriveRuleParams(__FUNCTION__));
  
  }

}

