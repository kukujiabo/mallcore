<?php
namespace App\Service\Takeaway;

use Core\Service\CurdSv;
use App\Service\BaseService;

/**
 * 退单
 *
 * @author Meroc Chen <398515393@qq.com> 2018-06-05
 */
class OrderTakeOutReturnSv extends BaseService {

  use CurdSv;

  /**
   * 新建退单
   * @desc 新建退单
   *
   * @param array data
   *
   * @return int id
   */
  public function createOrder($data) {
  
    $orderGoods = json_decode($data['goods']);

    unset($data['goods']);

    $order = $data['order'];

    $order['created_at'] = date('Y-m-d H:i:s');

    $id = self::add($order);

    foreach($orderGoods as $key => $good) {
    
      $orderGoods[$key]['return_id'] = $id;
    
    }

    OrderReturnGoodsSv::batchAdd($orderGoods);

    return $id
  
  }


}
