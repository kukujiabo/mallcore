<?php
namespace App\Service\Admin;

use App\Service\BaseService;
use Core\Service\CurdSv;
use App\Service\Crm\UserSv;
use App\Serivce\Takeaway\OrderTakeOutUnionSv;

/**
 *
 *
 */
class SalesListSv extends BaseService {

  use CurdSv;

  public function getList($data) {
  
    $query = [];

    if ($data) {
    
      $query['account'] = $data['manager_account'];
    
    }

    $salesBinding = SalesBindSv::queryList($query, $data['fields'], $data['order'], $data['page'], $data['page_size']);

    $salesPhones = array();

    foreach($salesBinding['list'] as $sale) {
    
      array_push($salesPhones, $sale['sales_phone']);
    
    }
  
    $salesUsers = UserSv::all(array('user_tel' => implode(',', $salesPhones)));

    foreach($salesUsers as $key => $salesUser) {

      $orders = OrderTakeOutUnionSv::all(array('buyer_id' => $saleUser['uid']), '*', null, "recommend_phone = {$saleUser['user_tel']}"); 
    
      $saleUsers[$key]['order'] = $orders;

    }

    $salesBinding['list'] = $salesUsers

    return $salesBinding;
  
  }

}
