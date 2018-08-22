<?php

namespace App\Service\Admin;

use App\Service\BaseService;
use App\Service\Crm\UserSv;
use App\Interfaces\Admin\IUserAdmin;
use App\Model\UserAdmin;
use Core\Service\CurdSv;

/**
 * 后台管理员操作接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-25
 */
class UserAdminSv extends BaseService implements IUserAdmin {

  use CurdSv;

  /**
   * 管理员登录
   *
   * @param array $data
   * @param string $data.username 管理员账号
   * @param string $data.password 管理员密码
   *
   * @return string $token 管理员令牌
   */
  public function login($data) {

    $data['type'] = 1;

    $data['module'] = 2;

    $token = UserSv::userLogin($data);

    return array( 'token' => $token );

  }

  /**
   * 查询管理员信息
   *
   * @return array data
   */
  public function getAdminInfo($id) {

    $info = UserAdminSv::findOne($condition['uid']);

    if (in_array('provider', $info['admin_group'])) {
    
      $provider = ProviderSv::findOne(array('account' => $info['user_name']));

      $info['provider_id'] = $provider['id'];
    
    }
  
    return $info;
  
  }

  /**
   * 添加账号
   *
   * @return int id
   */
  public function addAcct($data) {

    $newAdmin = array(
    
      'admin_name' => $data['account'],

      'group_id_array' => 1,

      'is_admin' => 1,

      'admin_status' => 1
    
    );

    $adminId = self::add($newAdmin);
  
    $newUser = array(
    
      'instance_id' => $adminId,

      'user_name' => $data['account'],

      'user_password' => md5($data['password']),

      'user_status' => 1,

      'is_system' => 1,

      'status' => 1
    
    );
  
    $uid = UserSv::add($newUser);

    $newAdminGroup = array(
    
      'uid' => $uid,

      'status' => 1,

      'created_at' => date('Y-m-d H:i:s')
    
    );

    switch($data['auth']) {
    
      case 1:

        $newAdminGroup['group_id'] = 4;

        $newAdminGroup['city_code'] = $data['city_code'];

        break;

      case 2:

        $newAdminGroup['group_id'] = 5;

        $newAdminGroup['city_code'] = $data['city_code'];

        break;

      case 3:

        $newAdminGroup['group_id'] = 2;

        break;

    }

    $relatId = UserAdminGroupSv::add($newAdminGroup); 

    return $uid;
  
  }

  public function getSysAdminList($params) {

    $query = array();

    if ($params['user_name']) {

      $query['user_name'] = $params['user_name'];

    }
    if ($params['city_code']) {

      $query['city_code'] = $params['city_code'];
      
    }
    if ($params['auth']) {

      $query['group_id'] = $params['auth'];
      
    }

    return VSysAdminSv::queryList($query, $params['fields'], $params['order'], $params['page'], $params['page_size']);

  }


  public function getSalesManager() {
  
    return VSalesManagerSv::all();
  
  }

}
