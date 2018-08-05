<?php
namespace App\Service\Commodity;

use App\Service\BaseService;
use Core\Service\CurdSv;

/**
 *
 *
 *
 */
class HotGoodsSv extends BaseService {

  use CurdSv;

  public function create($data) {
  
    $newHot = array(
    
      'goods_id' => $data['goods_id'],

      'city_code' => $data['city_code'],

      'created_at' => date('Y-m-d H:i:s')
    
    );

    return self::add($newHot);
  
  }

  public function getList($data) {
  
    $query = array();

    if ($data['city_code']) {
    
      $query['hot_city'] = $data['city_code'];
    
    }
  
    return VHotGoodsSv::queryList($query, $data['fields'], $data['order'], $data['page'], $data['page_size']);
  
  }


}
