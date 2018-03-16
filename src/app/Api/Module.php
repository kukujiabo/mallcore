<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\ModuleDm;

/**
 * 11.6 系统模块接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-10-23
 */
class Module extends BaseApi {

  /**
   * 接口参数规则
   */
  public function getRules() {

    return $this->rules(array(

      'add' => array(

        'module_name' => 'module_name|string|true||模块标题',

        'module' => 'module|string|true||项目名',

        'controller' => 'controller|string|true||控制器名',

        'method' => 'method|string|true||方法名',

        'pid' => 'pid|int|true||上级模块ID',

        'level' => 'level|int|true||深度等级',

        'url' => 'url|string|true||链接地址',
        
        'is_menu' => 'is_menu|int|true||是否是菜单',
        
        'is_dev' => 'is_dev|int|true||是否仅开发者模式可见',
        
        'sort' => 'sort|int|true||排序（同级有效）',

        'desc' => 'desc|string|true||模块描述',
        
        'module_picture' => 'module_picture|string|true||模块图片',

        'icon_class' => 'icon_class|string|true||矢量图class',

        'is_control_auth' => 'is_control_auth|int|true||是否控制权限',

      ),

      'queryList' => array(

        'module_name' => 'module_name|string|false||模块标题',

        'module' => 'module|string|false||项目名',

        'controller' => 'controller|string|false||控制器名',

        'method' => 'method|string|false||方法名',

        'pid' => 'pid|int|false||上级模块ID',

        'level' => 'level|int|false||深度等级',

        'url' => 'url|string|false||链接地址',
        
        'is_menu' => 'is_menu|int|false||是否是菜单',
        
        'is_dev' => 'is_dev|int|false||是否仅开发者模式可见',
        
        'sort' => 'sort|int|false||排序（同级有效）',

        'desc' => 'desc|string|false||修改时间',
        
        'module_picture' => 'module_picture|string|false||模块图片',

        'icon_class' => 'icon_class|string|false||矢量图class',

        'is_control_auth' => 'is_control_auth|int|false||是否控制权限',

        'create_time' => 'create_time|string|false||创建时间',

        'modify_time' => 'modify_time|string|false||更新时间',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|20|每页数据条数'

      ),

      'queryCount' => array(

        'module_name' => 'module_name|string|false||模块标题',

        'module' => 'module|string|false||项目名',

        'controller' => 'controller|string|false||控制器名',

        'method' => 'method|string|false||方法名',

        'pid' => 'pid|int|false||上级模块ID',

        'level' => 'level|int|false||深度等级',

        'url' => 'url|string|false||链接地址',
        
        'is_menu' => 'is_menu|int|false||是否是菜单',
        
        'is_dev' => 'is_dev|int|false||是否仅开发者模式可见',
        
        'sort' => 'sort|int|false||排序（同级有效）',

        'desc' => 'desc|string|false||修改时间',
        
        'module_picture' => 'module_picture|string|false||模块图片',

        'icon_class' => 'icon_class|string|false||矢量图class',

        'is_control_auth' => 'is_control_auth|int|false||是否控制权限',

        'create_time' => 'create_time|string|false||创建时间',

        'modify_time' => 'modify_time|string|false||更新时间',
      
      ),

      'update' => array(

        'module_id' => 'module_id|int|true||模块ID',

        'module_name' => 'module_name|string|false||模块标题',

        'module' => 'module|string|false||项目名',

        'controller' => 'controller|string|false||控制器名',

        'method' => 'method|string|false||方法名',

        'pid' => 'pid|int|false||上级模块ID',

        'level' => 'level|int|false||深度等级',

        'url' => 'url|string|false||链接地址',
        
        'is_menu' => 'is_menu|int|false||是否是菜单',
        
        'is_dev' => 'is_dev|int|false||是否仅开发者模式可见',
        
        'sort' => 'sort|int|false||排序（同级有效）',

        'desc' => 'desc|string|false||修改时间',
        
        'module_picture' => 'module_picture|string|false||模块图片',

        'icon_class' => 'icon_class|string|false||矢量图class',

        'is_control_auth' => 'is_control_auth|int|false||是否控制权限',

        'create_time' => 'create_time|string|false||创建时间',

        'modify_time' => 'modify_time|string|false||更新时间',
      
      ),

      'getDetail' => array(

        'module_id' => 'module_id|int|false||模块ID',
      
      ),

      'crmModList' => array(

        'token' => 'token|string|false||用户令牌',
      
      )
      
    ));

  }

  /**
   * 新增系统模块
   * @desc 新增系统模块
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function add() {

    $regulation = array(
      'module_name' => 'required',
      'module' => 'required',
      'controller' => 'required',
      'method' => 'required',
      'pid' => 'required',
      'level' => 'required',
      'url' => 'required',
      'is_menu' => 'required',
      'is_dev' => 'required',
      'sort' => 'required',
      'module_picture' => 'required',
      'icon_class' => 'required',
      'is_control_auth' => 'required',
    );

    $params = $this->retriveRuleParams('add');

    \App\Verification($params, $regulation);

    return $this->dm->add($params);
  
  }

  /**
   * 修改系统模块
   * @desc 修改系统模块
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function update() {

    $regulation = array(
      'module_id' => 'required',
    );

    $params = $this->retriveRuleParams('update');

    \App\Verification($params, $regulation);

    return $this->dm->update($params);
  
  }

  /**
   * 查询系统模块详情
   * @desc 查询系统模块详情
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function getDetail() {

    $regulation = array(
      'module_id' => 'required',
    );

    $conditions = $this->retriveRuleParams('getDetail');

    \App\Verification($conditions, $regulation);

    return $this->dm->getDetail($conditions);
  
  }

  /**
   * 查询系统模块列表
   * @desc 查询系统模块列表
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
   * 查询系统模块数量
   * @desc 查询系统模块数量
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

  /**
   * 查询crm前端模块
   * @desc 查询crm前端模块
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function crmModList() {
   
    $queryOptions = $this->retriveRuleParams('crmModList');
  
    return $this->dm->crmModList($queryOptions);
  
  }

}
