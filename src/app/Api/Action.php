<?php
namespace App\Api;

/**
 * 1.1 系统定义操作接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-10-20
 */
class Action extends BaseApi {

  /**
   * 接口参数规则
   */
  public function getRules() {

    return $this->rules(array(

      'add' => array(

        'action_code' => 'action_code|string|true||操作编号',

        'action_name' => 'action_name|string|true||操作名',

        'operation' => 'operation|string|true||服务名称',

        'icon' => 'icon|string|true||图标地址',

        'default_data' => 'default_data|string|false||默认参数（json格式）'

      ),

      'queryList' => array(

        'action_code' => 'action_code|string|false||操作编号',

        'action_name' => 'action_name|string|false||操作名',

        'service_name' => 'service_name|string|false||服务名称',

        'method' => 'method|string|false||方法',
        
        'default_data' => 'default_data|string|false||默认参数（json格式）',

        'operator_id' => 'operator_id|int|false||操作员id',

        'created_at' => 'created_at|string|false||创建时间',

        'updated_at' => 'updated_at|string|false||更新时间',

        'deleted_at' => 'deleted_at|int|false||删除时间',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|20|每页数据条数'

      ),

      'queryCount' => array(

        'action_code' => 'action_code|string|false||操作编号',

        'action_name' => 'action_name|string|false||操作名',

        'service_name' => 'service_name|string|false||服务名称',

        'method' => 'method|string|false||方法',
        
        'default_data' => 'default_data|string|false||默认参数（json格式）',

        'operator_id' => 'operator_id|int|false||操作员id',

        'created_at' => 'created_at|string|false||创建时间',

        'updated_at' => 'updated_at|string|false||更新时间',

        'deleted_at' => 'deleted_at|int|false||删除时间',
      
      ),

      'update' => array(

        'id' => 'id|int|true||表序号',

        'action_code' => 'action_code|string|false||操作编号',

        'action_name' => 'action_name|string|false||操作名',

        'operation' => 'operation|string|false||操作路径',

        'icon' => 'icon|string|false||图标',
        
        'default_data' => 'default_data|string|false||默认参数（json格式）'
      
      ),

      'getDetail' => array(

        'id' => 'id|int|true||表序号',
      
      ),
      
    ));

  }

  /**
   * 新增系统定义操作
   * @desc 新增系统定义操作
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function add() {

    $params = $this->retriveRuleParams('add');

    return $this->dm->add($params);
  
  }

  /**
   * 修改系统定义操作
   * @desc 修改系统定义操作
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function update() {

    $params = $this->retriveRuleParams('update');

    return $this->dm->update($params);
  
  }

  /**
   * 查询系统定义操作详情
   * @desc 查询系统定义操作详情
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function getDetail() {

    $regulation = array(
      'id' => 'required',
    );

    $conditions = $this->retriveRuleParams('getDetail');

    \App\Verification($conditions, $regulation);

    return $this->dm->getDetail($conditions);
  
  }

  /**
   * 查询系统定义操作列表
   * @desc 查询系统定义操作列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function queryList() {

    $conditions = $this->retriveRuleParams('queryList');

    $regulation = array();

    \App\Verification($conditions, $regulation);

    return $this->dm->queryList($conditions);

  }

  /**
   * 查询系统定义操作数量
   * @desc 查询系统定义操作数量
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function queryCount() {

    $conditions = $this->retriveRuleParams('queryCount');
  
    $regulation = array();

    \App\Verification($conditions, $regulation);

    return $this->dm->queryCount($conditions);
  
  }

}
