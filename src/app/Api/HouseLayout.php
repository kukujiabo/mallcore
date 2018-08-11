<?php
namespace App\Api;

/**
 * 房屋布局接口
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class HouseLayout extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(

      'create' => array(
      
        'layout_name' => 'layout_name|string|true||布局名称',

        'info' => 'info|string|false||布局备注',

        'attrs' => 'attrs|string|false||布局属性'
      
      ),
    
      'getAll' => array(
      
      
      ),

      'getDetail' => array(

        'id' => 'id|int|true||获取布局详情'
      
      ),

      'updateLayout' => array(
      
        'id' => 'id|int|true||获取布局详情',
      
        'layout_name' => 'layout_name|string|true||布局名称',

        'info' => 'info|string|false||布局备注',

        'attrs' => 'attrs|string|false||布局属性'
      
      )
    
    ));
  
  }

  /**
   * 创建布局
   * @desc 创建布局
   *
   * @return int id
   */
  public function create() {

    return $this->dm->create($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 查询全部布局
   * @desc 查询全部布局
   *
   */
  public function getAll() {
  
    return $this->dm->getAll($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 查询详情
   * @desc 查询详情
   *
   * @return array data
   */
  public function getDetail() {
  
    return $this->dm->getDetail($this->retriveRuleParams(__FUNCTION__));
  
  }

  public function updateLayout() {
  
    return $this->dm->updateLayout($this->retriveRuleParams(__FUNCTION__)); 
  
  }

}
