<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\UserGroupDm;

/**
 * 11.1 系统用户组操作接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-10-25
 */
class UserGroup extends BaseApi {

  /**
   * 接口参数规则
   */
  public function getRules() {

    return $this->rules(array(

      'add' => array(

        'group_name' => 'group_name|string|true||用户组名称',

        'group_status' => 'group_status|int|true||用户组状态 1-启用 2-禁用',

        'desc' => 'desc|string|false||描述',

        'instance_id' => 'instance_id|int|false||实例ID',

        'is_system' => 'is_system|int|false||是否是系统用户组',

        'module_id_array' => 'module_id_array|string|false||系统模块ID组，用，隔开',

      ),

      'queryList' => array(

        'group_id' => 'group_id|int|true||表序号',

        'group_name' => 'group_name|string|false||用户组名称',

        'group_status' => 'group_status|int|false||用户组状态 1-启用 2-禁用',

        'desc' => 'desc|string|false||描述',

        'instance_id' => 'instance_id|int|false||实例ID',

        'is_system' => 'is_system|int|false||是否是系统用户组',

        'module_id_array' => 'module_id_array|string|false||系统模块ID组，用，隔开',

        'create_time' => 'create_time|string|false||创建时间',

        'modify_time' => 'modify_time|string|false||更新时间',

        'deleted_at' => 'deleted_at|int|false||删除时间',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|20|每页数据条数'

      ),

      'update' => array(

        'group_id' => 'group_id|int|true||表序号',

        'group_name' => 'group_name|string|false||用户组名称',

        'group_status' => 'group_status|int|false||用户组状态 1-启用 2-禁用',

        'desc' => 'desc|string|false||描述',

        'instance_id' => 'instance_id|int|false||实例ID',

        'is_system' => 'is_system|int|false||是否是系统用户组',

        'module_id_array' => 'module_id_array|string|false||系统模块ID组，用，隔开',

        'create_time' => 'create_time|string|false||创建时间',

        'modify_time' => 'modify_time|string|false||更新时间',

        'deleted_at' => 'deleted_at|int|false||删除时间 1-删除',
      
      ),

      'getDetail' => array(

        'group_id' => 'group_id|int|true||表序号',
      
      ),
      
    ));

  }

  /**
   * 新增系统用户组操作
   * @desc 新增系统用户组操作
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 表序号
   * @return string msg 错误提示
   */
  public function add() {

    $regulation = array(
      'group_name' => 'required',
      'group_status' => 'required',
    );

    $params = $this->retriveRuleParams('add');

    \App\Verification($params, $regulation);

    return $this->dm->add($params);
  
  }

  /**
   * 修改系统用户组操作
   * @desc 修改系统用户组操作
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 修改成功的条数
   * @return string msg 错误提示
   */
  public function update() {

    $regulation = array(
      'group_id' => 'required',
    );

    $params = $this->retriveRuleParams('update');

    \App\Verification($params, $regulation);

    return $this->dm->update($params);
  
  }

  /**
   * 查询系统用户组操作详情
   * @desc 查询系统用户组操作详情
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return array data.group_id 表序号
   * @return array data.instance_id 实例ID
   * @return array data.group_name 用户组名称
   * @return array data.group_status 用户组状态：1-启用，2-禁用
   * @return array data.is_system 是否是系统用户组
   * @return array data.module_id_array 系统模块ID组，用，隔开
   * @return array data.create_time 创建时间
   * @return array data.modify_time 更新时间
   * @return array data.deleted_at 删除时间
   * @return array data.desc 描述
   * @return string msg 错误提示
   */
  public function getDetail() {

    $regulation = array(
      'group_id' => 'required',
    );

    $conditions = $this->retriveRuleParams('getDetail');

    \App\Verification($conditions, $regulation);

    return $this->dm->getDetail($conditions);
  
  }

  /**
   * 查询系统用户组操作列表
   * @desc 查询系统用户组操作列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return array data.total 数据总条数
   * @return array data.page 当前页码
   * @return array data.list[] 系统用户组队列
   * @return array data.list[].group_id 表序号
   * @return array data.list[].instance_id 实例ID
   * @return array data.list[].group_name 用户组名称
   * @return array data.list[].group_status 用户组状态：1-启用，2-禁用
   * @return array data.list[].is_system 是否是系统用户组
   * @return array data.list[].module_id_array 系统模块ID组，用，隔开
   * @return array data.list[].create_time 创建时间
   * @return array data.list[].modify_time 更新时间
   * @return array data.list[].deleted_at 删除时间
   * @return array data.list[].desc 描述
   * @return string msg 错误提示
   */
  public function queryList() {

    $conditions = $this->retriveRuleParams('queryList');

    $regulation = array();

    \App\Verification($conditions, $regulation);

    return $this->dm->queryList($conditions);

  }

}
