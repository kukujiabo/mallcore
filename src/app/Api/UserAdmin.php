<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\UserAdminDm;

/**
 * 11.4 后台管理员操作接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-10-25
 */
class UserAdmin extends BaseApi {

  /**
   * 接口参数规则
   */
  public function getRules() {

    return $this->rules(array(

      'add' => array(

        'uid' => 'uid|string|true||用户ID',

        'admin_name' => 'admin_name|string|true||用户姓名',

        'admin_status' => 'admin_status|int|true||状态',

        'desc' => 'desc|string|false||附加信息',

        'is_admin' => 'is_admin|int|false||是否是系统管理员组',

        'group_id_array' => 'group_id_array|string|false||系统用户组',

      ),

      'queryList' => array(

        'uid' => 'uid|string|false||用户ID',

        'admin_name' => 'admin_name|string|false||用户姓名',

        'admin_status' => 'admin_status|int|false||状态',

        'desc' => 'desc|string|false||附加信息',

        'is_admin' => 'is_admin|int|false||是否是系统管理员组',

        'group_id_array' => 'group_id_array|string|false||系统用户组',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|20|每页数据条数'

      ),

      'update' => array(

        'uid' => 'uid|string|true||用户ID',

        'admin_name' => 'admin_name|string|false||用户姓名',

        'admin_status' => 'admin_status|int|false||状态',

        'desc' => 'desc|string|false||附加信息',

        'is_admin' => 'is_admin|int|false||是否是系统管理员组',

        'group_id_array' => 'group_id_array|string|false||系统用户组',
      
      ),

      'getDetail' => array(

        'uid' => 'uid|int|true||表序号',
      
      ),

      'login' => array(

        'username' => 'username|string|true||登录帐号',
        
        'password' => 'password|string|true||登录密码',
      
      ),

      'getAdmin' => array(

        'token' => 'token|string|true||后台管理员令牌',
      
      ),
      
    ));

  }

  /**
   * 获取管理员信息
   * @desc 获取管理员信息
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 结果数据集
   * @return string msg 错误提示
   */
  public function getAdmin() {

    $condition = $this->retriveRuleParams('getAdmin');

    $regulation = array(

      'token' => 'required',

    );

    \App\Verification($condition, $regulation);

    return $this->dm->getAdmin($condition);
  
  }

  /**
   * 管理员登录
   * @desc 管理员登录
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 结果数据集
   * @return string data.token 用户令牌
   * @return string msg 错误提示
   */
  public function login() {

    $condition = $this->retriveRuleParams('login');

    $regulation = array(

      'username' => 'required',

      'password' => 'required',

    );

    \App\Verification($condition, $regulation);

    return $this->dm->login($condition);
  
  }

  /**
   * 新增后台管理员操作
   * @desc 新增后台管理员操作
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 表序号
   * @return string msg 错误提示
   */
  public function add() {

    $regulation = array(
    );

    $params = $this->retriveRuleParams('add');

    \App\Verification($params, $regulation);

    return $this->dm->add($params);
  
  }

  /**
   * 修改后台管理员操作
   * @desc 修改后台管理员操作
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 修改成功的条数
   * @return string msg 错误提示
   */
  public function update() {

    $regulation = array(
      'uid' => 'required',
    );

    $params = $this->retriveRuleParams('update');

    \App\Verification($params, $regulation);

    return $this->dm->update($params);
  
  }

  /**
   * 查询后台管理员操作详情
   * @desc 查询后台管理员操作详情
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return array data.uid 用户ID
   * @return array data.admin_name 用户姓名
   * @return array data.group_id_array 系统用户组
   * @return array data.is_admin 是否是系统管理员组
   * @return array data.admin_status 状态：1-启用，2-禁用
   * @return array data.desc 附加信息
   * @return string msg 错误提示
   */
  public function getDetail() {

    $regulation = array(
      'uid' => 'required',
    );

    $conditions = $this->retriveRuleParams('getDetail');

    \App\Verification($conditions, $regulation);

    return $this->dm->getDetail($conditions);
  
  }

  /**
   * 查询后台管理员操作列表
   * @desc 查询后台管理员操作列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return array data.total 数据总条数
   * @return array data.page 当前页码
   * @return array data.list[] 后台管理员
   * @return array data.list[].uid 用户ID
   * @return array data.list[].admin_name 用户姓名
   * @return array data.list[].group_id_array 系统用户组
   * @return array data.list[].is_admin 是否是系统管理员组
   * @return array data.list[].admin_status 状态：1-启用，2-禁用
   * @return array data.list[].desc 附加信息
   * @return string msg 错误提示
   */
  public function queryList() {

    $conditions = $this->retriveRuleParams('queryList');

    $regulation = array();

    \App\Verification($conditions, $regulation);

    return $this->dm->queryList($conditions);

  }

}
