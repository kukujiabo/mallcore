<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use Core\Service\CurdSv;

class MerchantSv extends BaseService {

  use CurdSv;

  public function create($data) {
  
    $newMerchant = array(
    
      'mcode' => $data['mcode'],
      'mname' => $data['mname'],
      'sales_id' => $data['sales_id'],
      'ext_1' => $data['ext_1'],
      'brief' => $data['brief'],
      'phone' => $data['phone'],
      'created_at' => date('Y-m-d H:i:s')
    
    );
  
  }

  public function listQuery($data) {
  
    $query = array();

    if ($data['mname']) {
    
      $query['mname'] => $data['mname'];
    
    }
    if ($data['ext_1']) {

      $query['ext_1'] => $data['ext_1'];

    }
  
    return self::queryList($query, $data['fields'], $data['order'], $data['page'], $data['page_size']);
  
  }

}
