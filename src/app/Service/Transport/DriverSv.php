<?php
namespace App\Service\Transport;

use App\Service\BaseService;
use Core\Service\CurdSv;
use App\Service\Takeaway\OrderTakeoutUnionSv;
use App\Service\Takeaway\OrderTakeOutGoodsSv;

/**
 * 司机账号管理
 *
 *
 */
class DriverSv extends BaseService {

  use CurdSv;

  public function create($data) {

    $user = self::findOne(array('account' => $data['account']));

    if ($user) {
    
      return null;
    
    }
  
    $newDriver = [
      
      'account' => $data['account'],

      'name' => $data['name'],
    
      'password' => md5($data['password']),

      'city_code' => $data['city_code'],

      'remark' => $data['remark'],

      'created_at' => date('Y-m-d H:i:s')
    
    ];
  
    return self::add($newDriver);
  
  }

  public function getList($data) {

    $query = array();
  
    if ($data['account']) {
    
      $query['account'] = $data['account'];
    
    }
    if ($data['name']) {
    
      $query['name'] = $data['name'];
    
    }
    if ($data['city_code']) {
    
      $query['city_code'] = $data['city_code'];
    
    }

    return self::queryList($query, $data['fields'], $data['order'], $data['page'], $data['page_size']); 
  
  }

  public function login($data) {
  
    $auth = array(
    
      'account' => $data['account'],
    
      'password' => md5($data['password'])
    
    );
  
    $user = self::findOne($auth);

    if ($user) {
    
      return $user; 
    
    } else {
    
      return null;
    
    }
  
  }

  /**
   *
   *
   */
  public function getOrderList($data) {

    $query = array();     

    if (!$data['phone']) {
    
      return array();
    
    }

    if ($data['trans']) {
    
      $query['trans'] = $data['trans'];
    
    }

    $query['driver_phone'] = $data['phone'];
    
    $orders = OrderTakeoutUnionSv::queryList($query, $data['fields'], $data['order'], $data['page'], $data['page_size']);


    return $orders;
  
  }

}
