<?php
namespace App\Service\Transport;

use App\Service\BaseService;
use Core\Service\CurdSv;

class OrderSignImageSv extends BaseService {

  use CurdSv;

  public function create($data) {
  
    $newImage = array(
    
      'path' => $data['path'],

      'order_id' => $data['order_id'],

      'driver_id' => $data['driver_id'],

      'created_at' => date('Y-m-d H:i:s')
    
    );
  
    return self::add($newImage);
  
  }

  public function getAllByOrderId($data) {
  
    $query['order_id'] = $data['order_id'];

    return self::all($query);
  
  }

}
