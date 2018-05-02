<?php
namespace App\Api;

/**
 * 会员等级接口
 * @desc 会员等级接口
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class MemberLevel extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
    
      'add' => array(
      
        'level_name' => 'level_name|string|true||等级名称',
        'icon' => 'icon|string|true||等级图标',
        'card_url' => 'card_url|string|true||会员卡图片链接',
        'level_num' => 'level_num|int|true||等级级别',
        'state' => 'state|int|true||状态',
        'desc' => 'desc|string|true||等级描述'
      
      ),

      'findOne' => array(
      
        'level_id' => 'level_id|int|true||等级id'
      
      ),

      'update' => array(
      
        'level_id' => 'level_id|int|true||等级id',
        'level_name' => 'level_name|string|true||等级名称',
        'icon' => 'icon|string|true||等级图标',
        'card_url' => 'card_url|string|true||会员卡图片链接',
        'level_num' => 'level_num|int|true||等级级别',
        'state' => 'state|int|true||状态',
        'desc' => 'desc|string|true||等级描述'
      
      ),

      'getAll' => array(
      
        'level_name' => 'level_name|string|true||等级名称',
        'state' => 'state|int|true||状态'
      
      ),

      'remove' => array(
      
        'level_id' => 'level_id|int|true||等级id'
      
      )
    
    ));
  
  }

  /**
   * 新增会员等级
   * @desc 新增会员等级
   *
   * @return int id
   */
  public function add() {
  
    return $this->dm->add($this->retriveRuleParams(__FUNCTION__)); 
  
  }

  /**
   * 查询等级详情
   * @desc 查询等级详情
   *
   * @return array data
   */
  public function findOne() {
  
    return $this->dm->add($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 更新等级信息
   * @desc 更新等级信息
   *
   * @return int num
   */
  public function update() {
  
    return $this->dm->update($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 查询全部等级信息
   * @desc 查询全部等级信息
   *
   * @return array data
   */
  public function getAll() {
  
    return $this->dm->getAll($this->dm->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 删除等级
   * @desc 删除等级
   *
   * @return int num
   */
  public function remove() {
  
    return $this->dm->remove($this->retriveRuleParams(__FUNCTION__));
  
  }


}
