<?php
namespace App\Service\Takeaway;

use App\Service\BaseService;
use Core\Service\CurdSv;

class DataManagerSv extends BaseService {

  use CurdSv;

  /**
   * 新增数据员
   *
   */
  public function create($data) {

    /**
     * 检验手机号
     */
    $user = self::findOne(array( 'mobile' => $data['mobile'] ));

    if ($user) {

      return 0;
    
    }
  
    $newData = array(
    
      'name' => $data['name'],

      'mobile' => $data['mobile'],

      'city_code' => $data['city_code'],

      'created_at' => date('Y-m-d H:i:s')
    
    );
     
    return self::add($newData);
  
  }

  /**
   * 查询数据员列表
   *
   */
  public function getList($data) {

    $query = array();

    if ($data['name']) {
    
      $query['name'] = $data['name'];
    
    }
    if ($data['mobile']) {

      $query['mobile'] = $data['mobile'];
    
    }
    if ($data['city_code']) {
    
      $query['city_code'] = $data['city_code'];
    
    }
  
    return self::queryList($query, $data['fields'], $data['order'], $data['page'], $data['page_size']);
  
  }

}
