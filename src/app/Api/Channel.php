<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\ChannelDm;

/**
 * 26.1 渠道服务接口
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-12-12
 */
class Channel extends BaseApi {

  public function getRules() {

    return $this->rules(array(

      'add' => array(

        'type' => 'type|int|true||渠道类型id',
      
        'name' => 'name|string|true||名称',
        
        'action_name' => 'action_name|string|true||二维码类型，QR_SCENE为临时的整型参数值，QR_STR_SCENE为临时的字符串参数值，QR_LIMIT_SCENE为永久的整型参数值，QR_LIMIT_STR_SCENE为永久的字符串参数值',

        'scene_str' => 'scene_str|string|true||场景值ID',

        'expire_seconds' => 'expire_seconds|int|false||该二维码有效时间，以秒为单位。最大不超过2592000（即30天）',

        'entity' => 'entity|string|false||渠道实体ID',

      ),

      'queryList' => array(

        'id' => 'id|int|false||渠道Id',

        'type' => 'type|int|false||渠道类型id',
      
        'name' => 'name|string|false||名称',
        
        'action_name' => 'action_name|string|false||二维码类型，QR_SCENE为临时的整型参数值，QR_STR_SCENE为临时的字符串参数值，QR_LIMIT_SCENE为永久的整型参数值，QR_LIMIT_STR_SCENE为永久的字符串参数值',

        'scene_str' => 'scene_str|string|false||场景值ID',

        'expire_seconds' => 'expire_seconds|int|false||该二维码有效时间，以秒为单位。最大不超过2592000（即30天）',

        'created_at' => 'created_at|string|false||创建时间',
        
        'update_time' => 'update_time|string|false||修改时间',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|20|每页数据条数'

      ),

      'queryCount' => array(

        'id' => 'id|int|false||渠道Id',

        'type' => 'type|int|false||渠道类型id',
      
        'name' => 'name|string|false||名称',
        
        'action_name' => 'action_name|string|false||二维码类型，QR_SCENE为临时的整型参数值，QR_STR_SCENE为临时的字符串参数值，QR_LIMIT_SCENE为永久的整型参数值，QR_LIMIT_STR_SCENE为永久的字符串参数值',

        'scene_str' => 'scene_str|string|false||场景值ID',

        'expire_seconds' => 'expire_seconds|int|false||该二维码有效时间，以秒为单位。最大不超过2592000（即30天）',

        'created_at' => 'created_at|string|false||创建时间',
        
        'update_time' => 'update_time|string|false||修改时间',
      
      ),

      'update' => array(

        'id' => 'id|int|true||渠道Id',

        'type' => 'type|int|false||渠道类型id',
      
        'name' => 'name|string|false||名称',
        
        'action_name' => 'action_name|string|false||二维码类型，QR_SCENE为临时的整型参数值，QR_STR_SCENE为临时的字符串参数值，QR_LIMIT_SCENE为永久的整型参数值，QR_LIMIT_STR_SCENE为永久的字符串参数值',

        'scene_str' => 'scene_str|string|false||场景值ID',

        'scene_str' => 'scene_str|string|false||场景值ID',

        'is_temporary' => 'is_temporary|int|false||1-临时 2-永久',

        'qr_code' => 'qr_code|string|false||渠道带参二维码',

        'expire_seconds' => 'expire_seconds|int|false||该二维码有效时间，以秒为单位。最大不超过2592000（即30天）',

        'ticket' => 'ticket|string|false||获取的二维码ticket，凭借此ticket可以在有效时间内换取二维码',

        'url' => 'url|string|false||二维码图片解析后的地址，开发者可根据该地址自行生成需要的二维码图片',
      
      ),

      'getDetail' => array(

        'id' => 'id|int|true||渠道Id',
      
      ),

      'getActiveOneByScene' => array(
      
        'scene_str' => 'scene_str|string|true||场景值',
      
        'type' => 'type|int|false|2|场景值类型'
      
      )
      
    ));

  }

  /**
   * 新增渠道服务
   * @desc 在用户使用优惠券的时候调用
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 类型Id
   * @return string msg 错误提示
   */
  public function add() {

    $params = $this->retriveRuleParams('add');

    $regulation = array(
      'type' => 'required',
      'name' => 'required',
      'action_name' => 'required',
      'scene_str' => 'required',
    );

    \App\Verification($params, $regulation);

    return $this->dm->add($params);
  
  }

  /**
   * 修改渠道服务
   * @desc 修改渠道服务
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
   * 查询渠道服务详情
   * @desc 查询渠道服务详情
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.id 表序号
   * @return int data.type 渠道类型id
   * @return string data.name 名称
   * @return int data.scene_str 场景值ID 临时二维码时为32位非0整型，永久二维码时最大值为100000
   * @return string data.scene_str 场景值ID（字符串形式的ID），字符串类型，长度限制为1到64
   * @return int data.is_temporary 1-临时 2-永久
   * @return string data.action_name 二维码类型，QR_SCENE为临时的整型参数值，QR_STR_SCENE为临时的字符串参数值，QR_LIMIT_SCENE为永久的整型参数值，QR_LIMIT_STR_SCENE为永久的字符串参数值
   * @return string data.qr_code 渠道带参二维码
   * @return int data.expire_seconds 该二维码有效时间，以秒为单位。 最大不超过2592000（即30天），此字段如果不填，则默认有效期为30秒
   * @return string data.ticket 获取的二维码ticket，凭借此ticket可以在有效时间内换取二维码
   * @return string data.url 二维码图片解析后的地址，开发者可根据该地址自行生成需要的二维码图片
   * @return string data.created_at 创建时间
   * @return string data.updated_at 修改时间
   * @return string msg 错误提示
   */
  public function getDetail() {

    $conditions = $this->retriveRuleParams('getDetail');

    $regulation = array(

      'id' => 'required',

    );

    \App\Verification($conditions, $regulation);

    return $this->dm->getDetail($conditions);

  }

  /**
   * 查询渠道服务列表
   * @desc 查询渠道服务列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.total 数据总条数
   * @return int data.page 当前页码
   * @return array data.list[] 渠道服务队列
   * @return int data.list[].id 表序号
   * @return int data.list[].type 渠道类型id
   * @return string data.list[].name 名称
   * @return int data.list[].scene_str 场景值ID 临时二维码时为32位非0整型，永久二维码时最大值为100000
   * @return string data.list[].scene_str 场景值ID（字符串形式的ID），字符串类型，长度限制为1到64
   * @return int data.list[].is_temporary 1-临时 2-永久
   * @return string data.list[].action_name 二维码类型，QR_SCENE为临时的整型参数值，QR_STR_SCENE为临时的字符串参数值，QR_LIMIT_SCENE为永久的整型参数值，QR_LIMIT_STR_SCENE为永久的字符串参数值
   * @return string data.list[].qr_code 渠道带参二维码
   * @return int data.list[].expire_seconds 该二维码有效时间，以秒为单位。 最大不超过2592000（即30天），此字段如果不填，则默认有效期为30秒
   * @return string data.list[].ticket 获取的二维码ticket，凭借此ticket可以在有效时间内换取二维码
   * @return string data.list[].url 二维码图片解析后的地址，开发者可根据该地址自行生成需要的二维码图片
   * @return string data.list[].created_at 创建时间
   * @return string data.list[].updated_at 修改时间
   * @return string msg 错误提示
   */
  public function queryList() {

    $conditions = $this->retriveRuleParams('queryList');

    $regulation = array();

    \App\Verification($conditions, $regulation);

    return $this->dm->queryList($conditions);

  }

  /**
   * 查询渠道服务数量
   * @desc 查询渠道服务数量
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
   * 根据场景id查询一个有效的渠道
   * @desc 查询有效的渠道
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 条数
   * @return string msg 错误提示
   */
  public function getActiveOneByScene() {

    $condition = $this->retriveRuleParams('getActiveOneByScene');

    return $this->dm->getActiveOneByScene($condition);
  
  }

}
