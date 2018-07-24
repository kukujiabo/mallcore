<?php
namespace App\Service\Admin;

use App\Service\BaseService;
use Core\Service\CurdSv;

class SalesBindSv extends BaseService {

  use CurdSv;

  public function addBindings($data) {
  
    $mobiles = explode(' ', $data['mobiles']);

    $newBindings = array();
  
    foreach($mobiles as $mobile) {

      $newBinding = array(
      
        'account' => $data['account'],

        'mobile' => $mobile,

        'created_at' => date('Y-m-d H:i:s')
      
      );
    
      array_push($newBinding, $newBindings);
    
    }

    return self::batchAdd($newBindings);
  
  }

}
