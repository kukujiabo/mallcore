<?php
namespace App\Api;

/** 
 * 11.8 图片配置接口
 *
 * @author Meroc Chen <398515393@qq.com> 2018-02-28
 */
class ConfigImage extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
    
      'addImage' => array(

        'module' => 'module|int|true||图片所属模块',
      
        'type' => 'type|int|true||图片业务类型',

        'url' => 'url|string|true||图片链接'
      
      ),
    
      'editImage' => array(
      
        'id' => 'id|int|false||图片id',

        'module' => 'module|int|false||图片所属模块',
      
        'type' => 'type|int|false||图片业务类型',

        'url' => 'url|string|false||图片链接',

        'link_type' => 'link_type|int|false||跳转类型',

        'link' => 'link|int|false||跳转对象',

        'state' => 'state|int|false||图片状态',

        'display_order' => 'display_order|int|false||排序'
      
      ),

      'getList' => array(
      
        'module' => 'module|int|false||所属模块',

        'type' => 'type|int|false||所属类型',

        'state' => 'state|int|false||图片状态'
      
      ),

      'remove' => array(
      
        'id' => 'id|int|false||图片id'
      
      ),
    
    ));
  
  }

  /**
   * 添加图片
   *
   * @return int id
   */
  public function addImage() {
  
    return $this->dm->addImage($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 编辑图片
   *
   * @return int id
   */
  public function editImage() {
  
    return $this->dm->editImage($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 查询列表
   *
   * @return int id
   */
  public function getList() {
  
    return $this->dm->getList($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 删除图片
   *
   * @return int num
   */
  public function remove() {
  
    return $this->dm->remove($this->retriveRuleParams(__FUNCTION__));
  
  }


}
