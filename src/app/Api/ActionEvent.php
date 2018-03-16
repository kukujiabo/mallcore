<?php
namespace App\Api;

/**
 * 18.1 操作事件接口
 *
 * @author: Meroc Chen <398515393@qq.com> 2017-10-11
 */
class ActionEvent extends BaseApi {

  /**
   * 配置接口参数规则
   */
  public function getRules() {
  
    return $this->rules(array(
    
      'queryList' => array(
      
        'action_name' => 'actionName|string|false||操作名称',

        'action_code' => 'actionCode|string|false||操作编号',

        'event_name' => 'eventName|string|false||事件名称',

        'event_code' => 'eventCode|string|false||事件编号',

        'operation' => 'operation|string|false||操作路径',
        
        'event_service' => 'eventService|string|false||事件路径',

        'active' => 'active|string|false||状态',
        
        'module' => 'module|string|false||模块',

        'validate_start' => 'validateStart|string|false||有效期开始',

        'validate_end' => 'validateEnd|string|false||有效期结束',

        'fields' => 'fields|string|false|*|查询列',

        'order' => 'order|string|false||排序',

        'page' => 'page|int|false|1|分页页码',

        'page_size' => 'pageSize|int|false|20|单页数量'
      
      ),
    
    ));
  
  
  }

  /**
   * 查询操作事件列表
   * @desc 操作事件列表接口
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 参数集
   * @return array data.Status 1:操作成功;-1:操作出错
   * @return array data.Description 错误信息
   * @return string msg 错误提示
   */
  public function queryList() {
  
    $regulation = array();

    $params = $this->retriveRuleParams('queryList');

    \App\Verification($params, $regulation);
  
    return $this->dm->queryList($params);
  
  }


}
