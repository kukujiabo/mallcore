<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\MemberSignDm;

/**
 * 2.9 会员签到接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-15
 */
class MemberSign extends BaseApi {

  public function getRules() {

    return $this->rules(array(

      'add' => array(

        'token' => 'token|string|true||用户令牌',

        'remark' => 'remark|string|false||备注',
      
        'ip_address' => 'ip_address|string|false||签到ip地址',

        'lat' => 'lat|float|false||纬度',

        'lng' => 'lng|float|false||经度',
        
        'relat_id' => 'relat_id|int|false||签到关联id',

        'relat_module' => 'relat_module|string|false||关联模块',

      ),

      'queryList' => array(

        'way' => 'way|int|true|1|途径 1-前台（会员） 2-后台（管理员）',

        'token' => 'token|string|false||用户令牌',

        'id' => 'id|string|false||表序号',

        'uid' => 'uid|string|false||用户id',

        'sign_time' => 'sign_time|string|false||签到时间戳',

        'remark' => 'remark|string|false||备注',
      
        'ip_address' => 'ip_address|string|false||签到ip地址',

        'lat' => 'lat|string|false||纬度',

        'lng' => 'lng|string|false||经度',
        
        'relat_id' => 'relat_id|string|false||签到关联id',

        'relat_module' => 'relat_module|string|false||关联模块',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|20|每页数据条数'

      ),

      'queryCount' => array(

        'id' => 'id|string|false||表序号',

        'uid' => 'uid|string|false||用户id',

        'sign_time' => 'sign_time|string|false||签到时间戳',

        'remark' => 'remark|string|false||备注',
      
        'ip_address' => 'ip_address|string|false||签到ip地址',

        'lat' => 'lat|string|false||纬度',

        'lng' => 'lng|string|false||经度',
        
        'relat_id' => 'relat_id|string|false||签到关联id',

        'relat_module' => 'relat_module|string|false||关联模块',
      
      ),

      'update' => array(

        'id' => 'id|string|true||表序号',

        'uid' => 'uid|string|false||用户id',

        'sign_time' => 'sign_time|string|false||签到时间戳',

        'remark' => 'remark|string|false||备注',
      
        'ip_address' => 'ip_address|string|false||签到ip地址',

        'lat' => 'lat|string|false||纬度',

        'lng' => 'lng|string|false||经度',
        
        'relat_id' => 'relat_id|string|false||签到关联id',

        'relat_module' => 'relat_module|string|false||关联模块',
      
      ),

      'getDetail' => array(

        'way' => 'way|int|true|1|途径 1-前台（会员） 2-后台（管理员）',

        'token' => 'token|string|false||用户令牌',

        'id' => 'id|string|false||表序号',

        'uid' => 'uid|string|false||用户id',

        'sign_time' => 'sign_time|string|false||签到时间戳',

        'remark' => 'remark|string|false||备注',
      
        'ip_address' => 'ip_address|string|false||签到ip地址',

        'lat' => 'lat|string|false||纬度',

        'lng' => 'lng|string|false||经度',
        
        'relat_id' => 'relat_id|string|false||签到关联id',

        'relat_module' => 'relat_module|string|false||关联模块',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',
      
      ),

      'getSignRewards' => array(
      
        'token' => 'token|string|true||用户token'
      
      )
      
    ));

  }

  /**
   * 会员签到
   * @desc 在用户使用优惠券的时候调用
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 类型Id
   * @return string msg 错误提示
   */
  public function add() {

    $params = $this->retriveRuleParams('add');

    $regulation = array(

      'token' => 'required',

    );

    \App\Verification($params, $regulation);

    return $this->dm->add($params);
  
  }

  /**
   * 修改会员签到
   * @desc 修改会员签到
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 修改条数
   * @return string msg 错误提示
   */
  public function update() {

    $params = $this->retriveRuleParams('update');

    $regulation = array(
      'id' => 'required',
    );

    \App\Verification($params, $regulation);

    return $this->dm->update($params);
  
  }

  /**
   * 查询会员签到详情
   * @desc 查询会员签到列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.id 表序号
   * @return int data.uid 会员uid
   * @return int data.sign_time 签到时间戳
   * @return string data.remark 签到备注 
   * @return string data.ip_address 签到ip地址
   * @return float data.lat 纬度
   * @return float data.lng 经度
   * @return int data.relat_id 签到关联id
   * @return string data.relat_module 关联模块
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
   * 查询会员签到列表
   * @desc 查询会员签到列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.total 数据总条数
   * @return int data.page 当前页码
   * @return array data.list[] 数据队列
   * @return int data.list[].id 表序号
   * @return int data.list[].uid 会员uid
   * @return int data.list[].sign_time 签到时间戳
   * @return string data.list[].remark 签到备注 
   * @return string data.list[].ip_address 签到ip地址
   * @return float data.list[].lat 纬度
   * @return float data.list[].lng 经度
   * @return int data.list[].relat_id 签到关联id
   * @return string data.list[].relat_module 关联模块
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
   * 查询会员签到数量
   * @desc 查询会员签到数量
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
   * 获取会员签到奖励
   * @desc 获取会员签到奖励
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 条数
   * @return string msg 错误提示
   */
  public function getSignRewards() {

    $data = $this->retriveRuleParams('getSignRewards');
  
    return $this->dm->getSignRewards($data);
  
  }

}
