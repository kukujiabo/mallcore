<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use Core\Service\CurdSv;

class NewBounSv extends BaseService {
  
  use CurdSv;

  public function create($data) {

    $coupons = json_decode($data['coupons']);

    $newBouns = array();

    foreach($coupons as $coupon) {
  
      $newBoun = array(
      
        'coupon_type_id' => $coupon['coupon_type_id'],
        'coupon_name' => $coupon['coupon_name'],
        'sequence' => $coupon['sequence'],
        'money' => $coupon['money'],
        'at_least' => $coupon['at_least'],
        'created_at' => date('Y-m-d H:i:s'),
        'end_time' => $coupon['end_time'],
        'start_time' => $coupon['start_time']
      
      );

      array_push($newBouns, $newBoun);

    }

    return self::batchAdd($newBouns);
  
  }

  public function getAll($data) {
  
    return self::all(array());
  
  }

}
