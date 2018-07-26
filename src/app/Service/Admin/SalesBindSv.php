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

      $binded = self::findOne(array('account' => $data['account'], 'sales_phone' => $mobile));

      if (!$binded) {

        $newBinding = array(
        
          'account' => $data['account'],

          'sales_phone' => $mobile,

          'created_at' => date('Y-m-d H:i:s')
        
        );
    
        array_push($newBindings, $newBinding);

      }
    
    }

    return self::batchAdd($newBindings);
  
  }

  public function unbind($data) {
  
    $bind = self::findOne(array('account' => $data['account'], 'sales_phone' => $data['sales_phone']));
  
    return self::remove($bind['id']);
  
  }

}
