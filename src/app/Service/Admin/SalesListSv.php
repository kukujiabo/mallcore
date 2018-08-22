<?php
namespace App\Service\Admin;

use App\Service\BaseService;
use Core\Service\CurdSv;
use App\Service\Crm\UserSv;
use App\Service\Crm\MemberUnionInfoSv;
use App\Service\Takeaway\OrderTakeoutUnionSv;

/**
 *
 *
 */
class SalesListSv extends BaseService {

  use CurdSv;

  public function getList($data) {
  
    $query = [];

    if ($data['manager_account']) {
    
      $user = UserSv::findOne(array('instance_id' => $data['manager_account']));

      $query['account'] = $user['uid'];
      
      $salesBinding = SalesBindSv::queryList($query, $data['fields'], $data['order'], $data['page'], $data['page_size']);
    
    } else {
    
      $salesBinding = SalesBindSv::all(array());
    
    }


    $salesUsers = array();

    if ($data['user_tel']) {

      $salesUsers = MemberUnionInfoSv::all(array('user_tel' => $data['user_tel']));

    } else {
    
      $salesPhones = array();

      foreach($salesBinding['list'] as $sale) {
      
        array_push($salesPhones, $sale['sales_phone']);
      
      }
  
      $salesUsers = MemberUnionInfoSv::all(array('user_tel' => implode(',', $salesPhones)));
    
    }

    foreach($salesUsers as $key => $salesUser) {

      $orders = OrderTakeoutUnionSv::all(array('buyer_id' => $saleUser['uid']), null, null, "recommend_phone = {$salesUser['user_tel']}"); 
 
      $users = UserSv::all(array('reference' => $salesUser['uid']));

      /**
       * 计算今日订单
       */
      $tOrderCnt = 0;

      $mOrderCnt = 0;

      $hOrderCnt = 0;

      $today = strtotime(date('Y-m-d'));

      $month = strtotime(date('Y-m-01'));

      foreach ($orders as $order) {
      
        if (strtotime($order['created_at']) > $today && $order['order_status'] > 1) {
        
          $toOrderCnt++; 
        
        }

        if (strtotime($order['created_at']) > $month && $order['order_status'] > 1) {
        
          $mOrderCnt++;
        
        }

        if ($order['order_status'] > 1) {
        
          $hOrderCnt++;
        
        }
      
      }

      $tUserCnt = 0;

      $mUserCnt = 0;

      foreach($users as $user) {
      
        if (strtotime($user['reg_time']) > $today) {
        
          $tUserCnt++;    
        
        }

        if (strtotime($user['reg_time']) > $month) {
        
          $mUserCnt++;
        
        }

      }

      $salesUsers[$key]['mototal'] = $mOrderCnt; 

      $salesUsers[$key]['tototal'] = $tOrderCnt;

      $salesUsers[$key]['hototal'] = $hOrderCnt;

      $salesUsers[$key]['mutotal'] = $mUserCnt;

      $salesUsers[$key]['tutotal'] = $tUserCnt;

      $salesUsers[$key]['hutotal'] = count($users);

    }

    $salesBinding['list'] = $salesUsers;

    return $salesBinding;
  
  }

}
