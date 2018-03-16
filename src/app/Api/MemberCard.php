<?php
namespace App\Api;

/**
 * 2.11 会员卡接口
 *
 * @author: Meroc Chen <398515393@qq.com> 2017-10-11
 */
class MemberCard extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
    
      'add' => array(
      
        'card_name' => 'card_name|string|true||卡片名称',
      
        'card_code' => 'card_code|string|false||卡片编码',

        'card_seq' => 'card_seq|string|false||卡片识别码',

        'img_url' => 'img_url|string|true||卡片地址',

        'card_type' => 'card_type|int|false||卡片类型：1，通用卡片，2，指定卡片'
      
      ),
    
      'getCount' => array(

        'id' => 'id|string|false||卡片id',
      
        'card_name' => 'card_name|string|false||卡片名称',
      
        'card_code' => 'card_code|string|false||卡片编码',

        'card_seq' => 'card_seq|string|false||卡片识别码',
        
        'img_url' => 'img_url|string|false||卡片地址',

        'card_type' => 'card_type|int|false||卡片类型'
      
      ),
    
      'getList' => array(

        'id' => 'id|string|false||卡片id',
      
        'card_name' => 'card_name|string|false||卡片名称',
      
        'card_code' => 'card_code|string|false||卡片编码',

        'card_seq' => 'card_seq|string|false||卡片识别码',
        
        'img_url' => 'img_url|string|false||卡片地址',

        'card_type' => 'card_type|int|false||卡片类型'
      
      ),
    
      'update' => array(

        'id' => 'id|string|true||卡片id',
      
        'card_name' => 'card_name|string|false||卡片名称',
      
        'card_code' => 'card_code|string|false||卡片编码',

        'card_seq' => 'card_seq|string|false||卡片识别码',
        
        'img_url' => 'img_url|string|false||卡片地址',

        'card_type' => 'card_type|int|false||卡片类型'
      
      ),
    
      'getDetail' => array(

        'id' => 'id|string|true||卡片id',
      
        'card_name' => 'card_name|string|false||卡片名称',
      
        'card_code' => 'card_code|string|false||卡片编码',

        'card_seq' => 'card_seq|string|false||卡片识别码',
        
        'img_url' => 'img_url|string|false||卡片地址',

        'card_type' => 'card_type|int|false||卡片类型'
      
      ),
    
    ));
  
  }

  /**
   * 添加会员卡
   * @desc 添加会员卡
   *
   * @return int ret 操作状态：200表示成功
   * @return int data 表序号
   * @return string msg 错误提示
   */
  public function add() {

    $params = $this->retriveRuleParams('add');

    $regulation = array(
      
      'card_name' => 'required',
      
      'img_url' => 'required',

    );

    \App\Verification($params, $regulation);

    return $this->dm->add($params);
  
  }

  /**
   * 修改会员卡信息
   * @desc 修改会员卡信息
   *
   * @return int ret 操作状态：200表示成功
   * @return int data 修改条数
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
   * 获取会员卡详情
   * @desc 获取会员卡详情
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果集
   * @return string msg 错误提示
   */
  public function getDetail() {

    $params = $this->retriveRuleParams('getDetail');

    $regulation = array(
      
      'id' => 'required',

    );

    \App\Verification($params, $regulation);

    return $this->dm->getDetail($params);
  
  }

  /**
   * 获取会员卡列表
   * @desc 获取会员卡列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果集
   * @return string msg 错误提示
   */
  public function getList() {

    $params = $this->retriveRuleParams('getList');

    $regulation = array(

    );

    \App\Verification($params, $regulation);

    return $this->dm->getList($params);
  
  }

  /**
   * 获取会员卡总数
   * @desc 获取会员卡总数
   *
   * @return int ret 操作状态：200表示成功
   * @return int data 总条数
   * @return string msg 错误提示
   */
  public function getCount() {

    $params = $this->retriveRuleParams('getCount');

    $regulation = array(

    );

    \App\Verification($params, $regulation);

    return $this->dm->getCount($params);
  
  }

}
