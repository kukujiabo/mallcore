<?php
namespace App\Service\Market;

use App\Service\BaseService;
use Core\Service\CurdSv;

class AdverSv extends BaseService {

  use CurdSv;

  public function save($data) {

    $newAd = array();
  
    if ($data['img_path']) {
    
      $newAd['img_path']  = $data['img_path'];
    
    }

    if ($data['object_id']) {
    
      $newAd['object_id'] = $data['object_id'];
    
    }

    return self::update($data['id'], $newAd);
  
  }

  public function getDetail($data) {
  
    return self::findOne($data['id']);
  
  }

}
