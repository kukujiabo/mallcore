<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\MemberDm;
use App\Exception\MemberException;
use App\Exception\ErrorCode;

/**
 * 2.8 会员接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-15
 */
class Member extends BaseApi {

  public function getRules() {

    return $this->rules(array(

      'login' => array(

        'code' => 'code|string|true||微信的code',

      ),

      'add' => array(

        'way' => 'way|int|true|1|途径 1-前台（会员） 2-后台（管理员）',

        'token' => 'token|string|false||用户令牌',

        'uid' => 'uid|int|false||用户uid',

        'member_name' => 'member_name|string|false||前台用户名',
      
        'member_level' => 'member_level|int|false||会员等级',
        
        'memo' => 'memo|string|false||备注',

      ),

      'queryList' => array(

        'way' => 'way|int|true|1|途径 1-前台（会员） 2-后台（管理员）',

        'token' => 'token|string|false||用户令牌',

        'uid' => 'uid|string|false||用户uid',

        'member_name' => 'member_name|string|false||前台用户名',
      
        'member_level' => 'member_level|string|false||会员等级',

        'reg_time' => 'reg_time|string|false||注册时间',
        
        'memo' => 'memo|string|false||备注',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|20|每页数据条数'

      ),

      'queryCount' => array(

        'uid' => 'uid|string|false||用户uid',

        'member_name' => 'member_name|string|false||前台用户名',
      
        'member_level' => 'member_level|string|false||会员等级',

        'reg_time' => 'reg_time|string|false||注册时间',
        
        'memo' => 'memo|string|false||备注',
      
      ),

      'update' => array(

        'way' => 'way|int|true|1|途径 1-前台（会员） 2-后台（管理员）',

        'token' => 'token|string|false||用户令牌',

        'uid' => 'uid|string|false||用户uid',

        'member_name' => 'member_name|string|false||前台用户名',
      
        'member_level' => 'member_level|string|false||会员等级',

        'reg_time' => 'reg_time|string|false||注册时间',
        
        'memo' => 'memo|string|false||备注',
        
        'user_name'  => array('name' => 'user_name', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '帐号（手机号码）'),
        'user_password'  => array('name' => 'user_password', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '密码明文'),
        'user_headimg'  => array('name' => 'user_headimg', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '用户头像'),
        'real_name'  => array('name' => 'real_name', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '真实姓名'),
        'nick_name'  => array('name' => 'nick_name', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '昵称'),
        'birthday'  => array('name' => 'birthday', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '生日'),
        'location'  => array('name' => 'location', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '所在地'),
        'sex'  => array('name' => 'sex', 'type' => 'int', 'require' => false, 'default' => '', 'desc' => '性别 0-保密 1-男 2-女'),
      
      ),

      'getDetail' => array(

        'way' => 'way|int|true|1|途径 1-前台（会员） 2-后台（管理员）',

        'token' => 'token|string|false||用户令牌',

        'uid' => 'uid|string|false||用户uid',

        'member_name' => 'member_name|string|false||前台用户名',
      
        'member_level' => 'member_level|string|false||会员等级',

        'reg_time' => 'reg_time|string|false||注册时间',
        
        'memo' => 'memo|string|false||备注',
        
        'status' => 'status|int|false|2|是否合并返回会员数据 1-否 2-是（本字段没有token无效）',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',
      
      ),

      'register' => array(

        'token' => 'token|string|true||用户令牌',
      
        'nickName' => 'nickName|string|true||用户昵称',

        'avatarUrl' => 'avatarUrl|string|true||用户头像',
        
        'gender' => 'gender|int|true||用户的性别，值为1时是男性，值为2时是女性，值为0时是未知',

        'city' => 'city|string|false||用户所在城市',

        'province' => 'province|string|false||用户所在省份',

        'country' => 'country|string|false||用户所在国家',

        'language' => 'language|string|true||用户的语言，简体中文为zh_CN',

        'encryptedData' => 'encryptedData|string|true||加密数据（会员手机号）',

        'iv' => 'iv|string|true||加密算法的初始向量（会员手机号）',

        'session_key' => 'session_key|string|true||会员密钥',

        'member_name' => 'member_name|string|false||用户姓名',

        'shop_id' => 'shop_id|int|false||店铺id',
      
      ),

      'decryptData' => array(

        'encryptedData' => 'encryptedData|string|true||加密数据',

        'iv' => 'iv|string|true||加密算法的初始向量',

        'session_key' => 'session_key|string|true||会员密钥',

        'appid' => 'appid|string|false||小程序appid',
      
      ),

      'getQrCode' => array(

        'token' => 'token|string|true||用户令牌',
      
      ),

      'memberUnionInfo' => array(

        'token' => 'token|string|true||用户令牌',

        'member_name' => 'member_name|string|false||会员名称',

        'member_level' => 'member_level|string|false||会员等级',

        'user_tel' => 'user_tel|string|false||会员手机号',

        'card_id' => 'card_id|string|false||会员卡号',

        'reg_start_time' => 'reg_start_time|string|false||注册起始时间',

        'reg_end_time' => 'reg_end_time|string|false||注册结束时间',

        'page' => 'page|string|false||页码',

        'pageSize' => 'pageSize|string|false||每页条数'

      ),


      'getFansList' => array(

        'token' => 'token|string|true||用户令牌',

        'order' => 'order|string|false||排序',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|20|每页数据条数'

      ),

      'memberIncrease' => array(

        'reg_date' => 'reg_date|string|true||日期（例：eg|2018-01-14;el|2018-01-15）',

      ),
      
    ));

  }

  /**
   * 会员每日新增统计表
   * @desc 会员每日新增统计表
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果集
   * @return int data[].num 新增数量
   * @return string data[].reg_date 日期
   * @return string msg 错误提示
   */
  public function memberIncrease() {

    $conditions = $this->retriveRuleParams('memberIncrease');

    $regulation = array(

      'reg_date' => 'required',
        
    );

    \App\Verification($conditions, $regulation);

    return $this->dm->memberIncrease($conditions);

  }

  /**
   * 获取用户粉丝列表
   * @desc 获取用户粉丝列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果集
   * @return string data.user_headimg 粉丝头像
   * @return string data.nick_name 粉丝昵称
   * @return string data.reg_time 关注时间
   * @return string msg 错误提示
   */
  public function getFansList() {

    $condition = $this->retriveRuleParams('getFansList');

    $regulation = array(

      'token' => 'required',

      'page' => 'required',

      'page_size' => 'required',

    );

    \App\Verification($condition, $regulation);

    return $this->dm->getFansList($condition);
  
  }

  /**
   * 获取会员动态二维码
   * @desc 获取会员动态二维码
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果集
   * @return string data.card_id_qr_code 二维码图片路径
   * @return string data.valid_time 二维码有效时间（秒）
   * @return string data.created_at 二维码创建时间戳
   * @return string msg 错误提示
   */
  public function getQrCode() {

    $condition = $this->retriveRuleParams('getQrCode');

    $regulation = array(

      'token' => 'required',

    );

    \App\Verification($condition, $regulation);

    return $this->dm->getQrCode($condition);
  
  }

  /**
   * 小程序加密数据解密
   * @desc 小程序加密数据解密
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果集
   * @return string phoneNumber 用户绑定的手机号（国外手机号会有区号）
   * @return string purePhoneNumber 没有区号的手机号
   * @return string countryCode 区号
   * @return string msg 错误提示
   */
  public function decryptData() {

    $condition = $this->retriveRuleParams('decryptData');

    $regulation = array(

      'encryptedData' => 'required',

      'iv' => 'required',

      'session_key' => 'required',

    );

    \App\Verification($condition, $regulation);

    return $this->dm->decryptData($condition);
  
  }

  /**
   * 会员注册
   * @desc 会员注册
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果集
   * @return boolean status true-成功 false-失败
   * @return string phone 手机号（成功的时候有手机号就返回）
   * @return string msg 错误提示
   */
  public function register() {

    $condition = $this->retriveRuleParams('register');

    $regulation = array(

      'token' => 'required',

      'nickName' => 'required',

      'avatarUrl' => 'required',

      'gender' => 'required',

      'language' => 'required',

      'encryptedData' => 'required',

      'iv' => 'required',

      'session_key' => 'required',

    );

    \App\Verification($condition, $regulation);

    return $this->dm->register($condition);
  
  }

  /**
   * 会员小程序登录
   * @desc 会员小程序登录
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 结果数据集
   * @return string data.session_key 小程序会话密钥
   * @return string data.expires_in key的有效时间（秒）
   * @return string data.mobile 用户绑定的手机号
   * @return string data.token 用户令牌
   * @return string msg 错误提示
   */
  public function login() {

    $condition = $this->retriveRuleParams('login');

    return $this->dm->login($condition);
  
  }

  /**
   * 新增会员
   * @desc 新增会员
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 类型Id
   * @return string msg 错误提示
   */
  public function add() {

    $params = $this->retriveRuleParams('add');

    $regulation = array(

      'way' => 'required',

    );

    \App\Verification($params, $regulation);

    if ($params['way'] == 2 && !isset($params['uid'])) {

      throw new MemberException(ErrorCode::MemberSv['ADD_PARAM_RETURN_MSG'], ErrorCode::MemberSv['ADD_PARAM_RETURN_CODE']);

    }

    return $this->dm->add($params);
  
  }

  /**
   * 修改会员
   * @desc 修改会员
   *
   * @return int ret 操作状态：200表示成功
   * @return int data 修改条数
   * @return string msg 错误提示
   */
  public function update() {

    $params = $this->retriveRuleParams('update');

    $regulation = array(

      'way' => 'required',

    );

    \App\Verification($params, $regulation);

    return $this->dm->update($params);
  
  }

  /**
   * 查询会员详情
   * @desc 查询会员详情
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.uid 会员uid
   * @return string data.member_name 前台用户名
   * @return int data.member_level 会员等级 
   * @return string data.reg_time 注册时间
   * @return string data.memo 备注
   * @return string data.card_url 会员卡图片
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
   * 查询会员列表
   * @desc 查询会员列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.total 数据总条数
   * @return int data.page 当前页码
   * @return array data.list[] 数据队列
   * @return int data.list[].uid 会员uid
   * @return string data.list[].member_name 前台用户名
   * @return int data.list[].member_level 会员等级 
   * @return string data.list[].reg_time 注册时间
   * @return string data.list[].memo 备注
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
   * 查询会员数量
   * @desc 查询会员数量
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
   * 查询会员联合信息
   * @desc 查询会员联合信息
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 条数
   * @return string msg 错误提示
   */
  public function memberUnionInfo() {
  
    $data = $this->retriveRuleParams('memberUnionInfo');

    return $this->dm->memberUnionInfo($data);
  
  }

}
