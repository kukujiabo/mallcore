<?php
namespace App\Service\Transport;

use App\Service\BaseService;
use Core\Service\CurdSv;

class TransSv extends BaseService {

  use CurdSv;

  public function pushLocation() {
  
    $data = file_get_contents('php://input');
      
    $params = json_decode($data, true);

    $newLocation = array(
    
      'lon' => $params['loc']['lon'],

      'lat' => $params['loc']['lat'],
    
      'order_id' => $params['uid'],

      'created_at' => date('Y-m-d H:i:s')
    
    );

    self::add($newLocation);
  
  }

}
