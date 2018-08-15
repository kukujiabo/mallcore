<?php
namespace App\Service\Market;

use App\Service\BaseService;
use Core\Service\CurdSv;

class AdverSv extends BaseService {

  use CurdSv;

  public function save($data) {
  
    $newAd = array(
    
      'img_path' => $data['img_path'],

      'object_id' => $data['object_id']
    
    );
  
    return self::add($data['id'], $newAd);
  
  }

  public function getDetail($data) {
  
    return self::findOne($data['id']);
  
  }

}
