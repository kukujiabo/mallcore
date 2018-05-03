<?php
namespace App\Service\Admin;

use App\Service\BaseService;
use App\Service\Crm\UserSv;

/**
 * 供应商服务类
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class ProviderSv extends BaseService {

  /**
   * 新增供应商
   *
   * @param array data
   *
   * @return int id
   */
  public function addProvider($data) {

    $uid = rand(100000000, 999999999);

    $newAccount = array(
      'uid' => $uid,
      'user_name' => $data['account'],
      'password' => md5($data['password']),
      'is_system' => 1,
      'reg_time' => date('Y-m-d H:i:s'),
      'status' => 1,
      'user_headimg' => $data['thumbnail'],
      'user_status' => 1
    );

    $uid = $newAccount['uid'];

    UserSv::add($newAccount);

    $newSysAdmin = array(
      'uid' => $uid,
      'admin_name' => $data['account'],
      'group_id_array' => 1,
      'is_admin' => 1,
      'admin_status' => 1
    );

    UserAdminSv::add($newSysAdmin);

    $newSysAdminGroup = array(
      'id' => rand(100000000, 999999999),
      'uid' => $uid,
      'group_id' => 2,
      'status' => 1,
      'created_at'  => date('Y-m-d H:i:s')
    );

    UserAdminGroupSv::add($newSysAdminGroup);
  
    $newProvider = array(
      'pname' => $data['pname'],
      'address' => $data['address'],
      'contact' => $data['contact'],
      'phone' => $data['phone'],
      'province' => $data['province'],
      'city' => $data['city'],
      'introduction' => $data['introduction'],
      'thumbnail' => $data['thumbnail'],
      'status' => $data['status'],
      'address' => $data['address'],
      'admin_id' => $uid,
      'created_at' => date('Y-m-d H:i:s')
    );

    $id = self::add($newProvider); 

    return $id;
  
  }


}