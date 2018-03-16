<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\UserGroupJurisdictionDm;

/**
 * 11.2 用户组权限操作接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-10-25
 */
class UserGroupJurisdiction extends BaseApi {

  /**
   * 接口参数规则
   */
  public function getRules() {

    return $this->rules(array(

      'add' => array(

        'group_id' => 'group_id|int|true||系统用户组id',

        'module_id' => 'module_id|int|true||系统模块id',

        'status' => 'status|int|true||状态 1-启用 2-禁用',

        'desc' => 'desc|string|false||描述',

      ),

      'queryList' => array(

        'id' => 'id|int|true||表序号',

        'group_id' => 'group_id|int|false||系统用户组id',

        'module_id' => 'module_id|int|false||系统模块id',

        'status' => 'status|int|false||状态 1-启用 2-禁用',

        'desc' => 'desc|string|false||描述',

        'created_at' => 'created_at|string|false||创建时间',

        'updated_at' => 'updated_at|string|false||更新时间',

        'deleted_at' => 'deleted_at|int|false||删除时间',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|20|每页数据条数'

      ),

      'update' => array(

        'id' => 'id|int|true||表序号',

        'group_id' => 'group_id|int|false||系统用户组id',

        'module_id' => 'module_id|int|false||系统模块id',

        'status' => 'status|int|false||状态 1-启用 2-禁用',

        'desc' => 'desc|string|false||描述',

        'created_at' => 'created_at|string|false||创建时间',

        'updated_at' => 'updated_at|string|false||更新时间',

        'deleted_at' => 'deleted_at|int|false||删除时间 1-删除',
      
      ),

      'getDetail' => array(

        'id' => 'id|int|true||表序号',
      
      ),
      
    ));

  }

  /**
   * 新增用户组权限操作
   * @desc 新增用户组权限操作
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 表序号
   * @return string msg 错误提示
   */
  public function add() {

    $regulation = array(
      'group_id' => 'required',
      'module_id' => 'required',
      'status' => 'required',
    );

    $params = $this->retriveRuleParams('add');

    \App\Verification($params, $regulation);

    return $this->dm->add($params);
  
  }

  /**
   * 修改用户组权限操作
   * @desc 修改用户组权限操作
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 修改成功的条数
   * @return string msg 错误提示
   */
  public function update() {

    $regulation = array(
      'id' => 'required',
    );

    $params = $this->retriveRuleParams('update');

    \App\Verification($params, $regulation);

    return $this->dm->update($params);
  
  }

  /**
   * 查询用户组权限操作详情
   * @desc 查询用户组权限操作详情
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return array data.id 表序号
   * @return array data.module_id 系统模块id
   * @return array data.group_id 系统用户组id
   * @return array data.status 状态：1-启用，2-禁用
   * @return array data.created_at 创建时间
   * @return array data.updated_at 更新时间
   * @return array data.deleted_at 删除时间
   * @return array data.desc 描述
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
   * 查询用户组权限操作列表
   * @desc 查询用户组权限操作列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return array data.total 数据总条数
   * @return array data.page 当前页码
   * @return array data.list[] 用户组权限队列
   * @return array data.list[].id 表序号
   * @return array data.list[].module_id 系统模块id
   * @return array data.list[].group_id 系统用户组id
   * @return array data.list[].status 状态：1-启用，2-禁用
   * @return array data.list[].created_at 创建时间
   * @return array data.list[].updated_at 更新时间
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
