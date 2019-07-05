<?php
namespace App\Service\Admin;

use App\Service\BaseService;
use Core\Service\CurdSv;
use App\Service\Crm\UserSv;
use App\Service\Crm\MemberSv;

class SalesBindSv extends BaseService {

  use CurdSv;

  public function addBindings($data) {
  
    $mobiles = explode(' ', $data['mobiles']);

    $newBindings = array();
  
    foreach($mobiles as $mobile) {

      $binded = self::findOne(array('account' => $data['account'], 'sales_phone' => $mobile));

      if (!$binded) {

        $user = MemberSv::findOne(array( 'user_tel' => $mobile ));

        if ($user) {

          $newBinding = array(
          
            'account' => $data['account'],

            'real_name' => $user['member_name'],

            'sales_phone' => $mobile,

            'created_at' => date('Y-m-d H:i:s')
          
          );
    
          array_push($newBindings, $newBinding);

        }

      }
    
    }

    return self::batchAdd($newBindings);
  
  }

  public function unbind($data) {

    $user = UserSv::findOne(array('instance_id' => $data['account']));

    $bind = self::findOne(array('account' => $user['uid'], 'sales_phone' => $data['sales_phone']));

    return self::remove($bind['id']);
  
  }

}
