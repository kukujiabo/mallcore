<?php
namespace App\Api;

use PhalApi\Api;
use App\Domain\CouponTypeDm;

/**
 * 7.4 优惠券种类接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-10-18
 */
class CouponType extends BaseApi {

  public function getRules() {

    return $this->rules(array(

      'add' => array(

        'shop_id' => 'shop_id|string|true||店铺ID，为0则表示所有门店',
      
        'deduction_type' => 'deduction_type|int|false||抵扣类型：1 折扣，2 现金，3 包邮',
        
        'coupon_name' => 'coupon_name|string|true||优惠券类型名称',

        'money' => 'money|int|false||发放面额',

        'percentage' => 'percentage|float|false|0|折扣',

        'count' => 'count|int|false|0|发放数量，0为无限制',

        'max_fetch' => 'max_fetch|int|false|0|每人最大领取个数 0无限制',

        'at_least' => 'at_least|float|false|0|满多少元使用 0代表无限制',

        'need_user_level' => 'need_user_level|int|false|0|领取人会员等级',

        'range_type' => 'range_type|int|false|1|使用范围0部分产品使用 1全场产品使用',

        'start_time' => 'start_time|string|false||有效日期开始时间',

        'end_time' => 'end_time|string|false||有效日期结束时间',

        'need_bind' => 'need_bind|int|false|0|是否需要绑定用户', 'status' => 'status|int|false|1|状态：1 可用，2 失效',

        'is_show' => 'is_show|int|false|0|是否允许首页显示:0 不显示，1 显示',

        'description' => 'description|string|false||',

        'term_type' => 'term_type|int|false||有效期类型：1.固定有效期，2.灵活有效期',

        'valid_days' => 'valid_days|int|false||有效期长，当term_type为2时有效，用于动态计算优惠券实例的有效期',

        'coupon_image' => 'coupon_image|string|false||',

        'last_long' => 'last_long|int|false||是否长期有效',

        'all_shops' => 'all_shops|int|false|0|是否门店通用',

        'online_type' => 'online_type|int|false|3|线上，线下：1，线上；2，线下；3，通用'

      ),

      'queryList' => array(

        'coupon_type_id' => 'coupon_type_id|int|false||优惠券类型Id',

        'shop_id' => 'shop_id|int|false||店铺ID，为0则表示所有门店',
      
        'operator_id' => 'operator_id|int|false||操作员id',

        'deduction_type' => 'deduction_type|int|false||抵扣类型：1 折扣，2 现金，3 包邮',
        
        'coupon_name' => 'coupon_name|string|false||优惠券类型名称',

        'money' => 'money|int|false||发放面额',

        'percentage' => 'percentage|float|false||折扣',

        'count' => 'count|int|false||发放数量，0为无限制',

        'max_fetch' => 'max_fetch|int|false||每人最大领取个数 0无限制',

        'at_least' => 'at_least|float|false||满多少元使用 0代表无限制',

        'need_user_level' => 'need_user_level|int|false||领取人会员等级',

        'range_type' => 'range_type|int|false||使用范围0部分产品使用 1全场产品使用',

        'start_time' => 'start_time|string|false||有效日期开始时间',

        'end_time' => 'end_time|string|false||有效日期结束时间',

        'need_bind' => 'need_bind|int|false||是否需要绑定用户',

        'status' => 'status|int|false||状态：1 可用，2 失效',

        'is_show' => 'is_show|int|false||是否允许首页显示:0 不显示，1 显示',

        'created_at' => 'created_at|string|false||创建时间',
        
        'update_time' => 'update_time|string|false||修改时间',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|20|每页数据条数'

      ),

      'queryCount' => array(

        'coupon_type_id' => 'coupon_type_id|int|false||优惠券类型Id',

        'shop_id' => 'shop_id|int|false||店铺ID，为0则表示所有门店',
      
        'operator_id' => 'operator_id|int|false||操作员id',

        'deduction_type' => 'deduction_type|int|false||抵扣类型：1 折扣，2 现金，3 包邮',
        
        'coupon_name' => 'coupon_name|string|false||优惠券类型名称',

        'money' => 'money|int|false||发放面额',

        'percentage' => 'percentage|float|false||折扣',

        'count' => 'count|int|false||发放数量，0为无限制',

        'max_fetch' => 'max_fetch|int|false||每人最大领取个数 0无限制',

        'at_least' => 'at_least|float|false||满多少元使用 0代表无限制',

        'need_user_level' => 'need_user_level|int|false||领取人会员等级',

        'range_type' => 'range_type|int|false||使用范围0部分产品使用 1全场产品使用',

        'start_time' => 'start_time|string|false||有效日期开始时间',

        'end_time' => 'end_time|string|false||有效日期结束时间',

        'need_bind' => 'need_bind|int|false||是否需要绑定用户',

        'status' => 'status|int|false||状态：1 可用，2 失效',

        'is_show' => 'is_show|int|false||是否允许首页显示:0 不显示，1 显示',

        'created_at' => 'created_at|string|false||创建时间',
        
        'update_time' => 'update_time|string|false||修改时间',
      
      ),

      'update' => array(

        'coupon_type_id' => 'coupon_type_id|int|true||优惠券类型Id',

        'shop_id' => 'shop_id|int|false||店铺ID，为0则表示所有门店',
      
        'operator_id' => 'operator_id|int|false||操作员id',

        'deduction_type' => 'deduction_type|int|false||抵扣类型：1 折扣，2 现金，3 包邮',
        
        'coupon_name' => 'coupon_name|string|false||优惠券类型名称',

        'money' => 'money|int|false||发放面额',

        'percentage' => 'percentage|float|false||折扣',

        'count' => 'count|int|false||发放数量，0为无限制',

        'max_fetch' => 'max_fetch|int|false||每人最大领取个数 0无限制',

        'at_least' => 'at_least|float|false||满多少元使用 0代表无限制',

        'need_user_level' => 'need_user_level|int|false||领取人会员等级',

        'range_type' => 'range_type|int|false||使用范围0部分产品使用 1全场产品使用',

        'start_time' => 'start_time|string|false||有效日期开始时间',

        'end_time' => 'end_time|string|false||有效日期结束时间',

        'need_bind' => 'need_bind|int|false||是否需要绑定用户',

        'status' => 'status|int|false||状态：1 可用，2 失效',

        'is_show' => 'is_show|int|false||是否允许首页显示:0 不显示，1 显示',
      
      ),

      'enable' => array(

        'coupon_type_id' => 'coupon_type_id|int|true||种类id',
      
      ),

      'disable' => array(

        'coupon_type_id' => 'coupon_type_id|int|true||种类id',
      
      ),

      'createCouponType' => array(
      
        'coupon_name' => 'coupon_name|string|true||优惠券名称',

        'coupon_code' => 'coupon_code|string|true||优惠券编码',

        'coupon_image' => 'coupon_image|string|true||优惠券图片',

        'deduction_type' => 'deduction_type|int|true||抵扣类型:1.折扣，2.抵扣',

        'all_shops' => 'all_shops|int|true|1|是否通用:1.通用，0.不通用',

        'need_user_level' => 'need_user_level|int|true|0|用户等级',

        'last_long' => 'last_long|int|true|0|是否长期有效',

        'status' => 'status|int|true|1|启用状态：1.可用，2.停用',

        'term_type' => 'term_type|int|true|2|使用日期类型:1.固定有效期，2.灵活有效期',

        'money' => 'money|int|false||抵扣金额',

        'percentage' => 'percentage|int|false||折扣',

        'shop_id' => 'shop_id|string|false||店铺id',

        'start_time' => 'start_time|string|false||有效期开始事件',

        'end_time' => 'end_time|string|false||有效期结束事件',

        'years' => 'years|int|false|0|有效期（年）',

        'months' => 'months|int|false|0|有效期（月）',

        'days' => 'days|int|false|0|有效期（日）',

        'max_fetch' => 'max_fetch|int|false|0|每人最多领取数量',

        'count' => 'count|int|false|0|发放数量',

        'at_least' => 'at_least|int|false|0|消费满额',

        'online_type' => 'online_type|int|false|3|线上线下：1，线上；2，线下；3，通用',

        'ext_1' => 'ext_1|string|false||商品大类字段',

        'ext_2' => 'ext_2|string|false||商品单品字段'
      
      )
      
    ));

  }

  /**
   * 新增优惠券种类
   * @desc 新增优惠券种类
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 类型Id
   * @return string msg 错误提示
   */
  public function add() {

    $params = $this->retriveRuleParams('add');

    $regulation = array(
      'shop_id' => 'required',
      'coupon_name' => 'required',
      'start_time' => 'required',
      'end_time' => 'required',
    );

    \App\Verification($params, $regulation);

    return $this->dm->add($params);
  
  }

  /**
   * 修改优惠券种类
   * @desc 修改优惠券种类
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 修改条数
   * @return string msg 错误提示
   */
  public function update() {

    $params = $this->retriveRuleParams('update');

    $regulation = array(
      'coupon_type_id' => 'required',
    );

    \App\Verification($params, $regulation);

    return $this->dm->update($params);
  
  }

  /**
   * 优惠券种类启用
   * @desc 优惠券种类启用
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 修改条数
   * @return string msg 错误提示
   */
  public function enable() {

    $conditions = $this->retriveRuleParams('enable');

    $regulation = array(
      'coupon_type_id' => 'required',
    );

    \App\Verification($conditions, $regulation);

    return $this->dm->enable($conditions);
  
  }

  /**
   * 优惠券种类禁用
   * @desc 优惠券种类禁用
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 修改条数
   * @return string msg 错误提示
   */
  public function disable() {

    $conditions = $this->retriveRuleParams('disable');

    $regulation = array(
      'coupon_type_id' => 'required',
    );

    \App\Verification($conditions, $regulation);

    return $this->dm->disable($conditions);
  
  }

  /**
   * 查询优惠券种类详情
   * @desc 查询优惠券种类详情
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.coupon_type_id 优惠券类型Id
   * @return int data.shop_id 店铺ID，为0则表示所有门店
   * @return int data.operator_id 
   * @return int data.deduction_type 抵扣类型：1 折扣，2 现金，3 包邮
   * @return string data.coupon_name 优惠券名称
   * @return float data.money 发放面额（单位：元）
   * @return int data.percentage 折扣
   * @return int data.count 发放数量，0为无限制
   * @return int data.max_fetch 每人最大领取个数，0无限制
   * @return float data.at_least 满多少元使用，0代表无限制
   * @return int data.need_user_level 领取人会员等级
   * @return int data.range_type 使用范围0部分产品使用，1全场产品使用
   * @return string data.start_time 有效日期开始时间
   * @return string data.end_time 有效日期结束时间
   * @return int data.need_bind 是否需要绑定用户:0-否，1-是
   * @return int data.status 状态：1 可用，2 失效
   * @return string data.create_time 创建时间
   * @return string data.update_time 修改时间
   * @return int data.is_show 是否允许首页显示0不显示1显示
   * @return string data.description
   * @return int data.term_type 有效期类型：1.固定有效期，2.灵活有效期
   * @return int data.valid_days 有效期长，当term_type为2时有效，用于动态计算优惠券实例的有效期
   * @return string data.coupon_image
   * @return int data.last_long 是否长期有效
   * @return string msg 错误提示
   */
  public function getDetail() {

    $conditions = $this->retriveRuleParams('getDetail');

    $regulation = array(

      'coupon_type_id' => 'required',

    );

    \App\Verification($conditions, $regulation);

    return $this->dm->getDetail($conditions);

  }

  /**
   * 查询优惠券种类列表
   * @desc 查询优惠券种类列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.total 数据总条数
   * @return int data.page 当前页码
   * @return array data.list[] 优惠券种类队列
   * @return int data.list[].coupon_type_id 优惠券类型Id
   * @return int data.list[].shop_id 店铺ID，为0则表示所有门店
   * @return int data.list[].operator_id 
   * @return int data.list[].deduction_type 抵扣类型：1 折扣，2 现金，3 包邮
   * @return string data.list[].coupon_name 优惠券名称
   * @return float data.list[].money 发放面额（单位：元）
   * @return int data.list[].percentage 折扣
   * @return int data.list[].count 发放数量，0为无限制
   * @return int data.list[].max_fetch 每人最大领取个数，0无限制
   * @return float data.list[].at_least 满多少元使用，0代表无限制
   * @return int data.list[].need_user_level 领取人会员等级
   * @return int data.list[].range_type 使用范围0部分产品使用，1全场产品使用
   * @return string data.list[].start_time 有效日期开始时间
   * @return string data.list[].end_time 有效日期结束时间
   * @return int data.list[].need_bind 是否需要绑定用户:0-否，1-是
   * @return int data.list[].status 状态：1 可用，2 失效
   * @return string data.list[].create_time 创建时间
   * @return string data.list[].update_time 修改时间
   * @return int data.list[].is_show 是否允许首页显示0不显示1显示
   * @return string data.list[].description
   * @return int data.list[].term_type 有效期类型：1.固定有效期，2.灵活有效期
   * @return int data.list[].valid_days 有效期长，当term_type为2时有效，用于动态计算优惠券实例的有效期
   * @return string data.list[].coupon_image
   * @return int data.list[].last_long 是否长期有效
   * @return string msg 错误提示
   */
  public function queryList() {

    $conditions = $this->retriveRuleParams('queryList');

    $regulation = array();

    \App\Verification($conditions, $regulation);

    return $this->dm->queryList($conditions);

  }

  /**
   * 查询优惠券种类数量
   * @desc 查询优惠券种类数量
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
   * 创建优惠券种类
   * @desc 创建优惠券种类接口
   *
   * @return int ret 操作状态：200表示成功
   * @return int data 状态：1 创建成功，0 创建失败
   * @return string msg 错误提示
   */
  public function createCouponType() {
  
    $data = $this->retriveRuleParams(__FUNCTION__);
  
    return $this->dm->createCouponType($data);
  
  }

}
