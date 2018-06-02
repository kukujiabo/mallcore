<?php
namespace App\Service\Admin;

use App\Service\BaseService;
use App\Service\Crm\UserSv;
use Core\Service\CurdSv;

/**
 * 供应商服务类
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class ProviderSv extends BaseService {

  use CurdSv;

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
      'user_password' => md5($data['password']),
      'is_system' => 1,
      'reg_time' => date('Y-m-d H:i:s'), 'status' => 1,
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
      'admin_id' => $uid,
      'account' => $data['account'],
      'created_at' => date('Y-m-d H:i:s')
    );

    self::add($newProvider); 

    return $uid;
  
  }

  /**
   * 读取供应商列表
   *
   * @param array query
   *
   * @return array list
   */
  public function getList($data) {

    $order = $data['order'];
    $page = $data['page'];
    $pageSize = $data['page_size'];

    unset($data['order']);
    unset($data['page']);
    unset($data['page_size']);
  
    return self::queryList($data, '*', $order, $page, $pageSize);
  
  }

  /**
   * 根据id获取单条记录详情
   *
   * @param array params
   *
   * @return array object
   */
  public function getDetail($params) {
  
    $query = array( 'id' => $params['id'] );
      
    $providerInfo = self::findOne($query);

    $accountInfo = UserSv::findOne(array('user_name' => $providerInfo['account']));

    $providerInfo['thumbnail'] = $accountInfo['user_headimg'];

    return $providerInfo;
  
  }

  /**
   * 更新装修公司信息
   * @desc 更新装修公司信息
   *
   * @param array params
   *
   * @return int num
   */
  public function edit($params) {
  
    $id = $params['id'];

    $providerInfo = self::findOne($id);

    if ($params['password']) {
    
      $user = UserSv::findOne(array('user_name' => $providerInfo['account']));

      UserSv::update($user['uid'], md5($params['password']));
    
      unset($params['password']);

    }

    unset($params['id']);
     
    return self::update($id, $params);
  
  }

}
