<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use Core\Service\CurdSv;

class NewBounSv extends BaseService {
  
  use CurdSv;

  public function create($data) {

    $coupons = json_decode($data['coupons'], true);

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

  public function removeBoun($data) {
  
    return self::remove($data['id']); 
  
  }

  public function grantNew($data) {
  
    $coupons = self::getAll(array()); 

    $user = UserSv::getUserByToken($data['token']);

    $fetched = NewBounFetchedSv::findOne(array( 'member_id' => $user['uid'] ));

    if ($fetched) {
    
      return false;
    
    }

    $couTypeIds = array();

    $result = 0;

    foreach($coupons as $coupon) {
    
      $result += CouponSv::grant($coupon['coupon_type_id'], $user['uid']);
    
    }


    if ($result > 0) {

      $newFetched = array(
      
        'member_id' => $user['uid'],

        'created_at' => date('Y-m-d H:i:s')
      
      );
    
      NewBounFetchedSv::add($newFetched);
    
    }

    return $result;
  
  }

  public function checkFetched($data) {

    $user = UserSv::getUserByToken($data['token']);
  
    $fetched = NewBounFetchedSv::findOne(array( 'member_id' => $user['uid'] ));

    if ($fetched) {
    
      return true;
    
    } else {
    
      return false;

    }
  
  }

}
