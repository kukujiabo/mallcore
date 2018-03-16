<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use Core\Service\CurdSv;

/**
 * 用户联合信息
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-09
 */
class MemberUnionInfoSv extends BaseService {

  use CurdSv;

  public function getList($data) {

    $query = array();

    if ($data['member_name']) {
    
      $query['member_name'] = $data['member_name'];
    
    }
    if ($data['user_tel']) {
    
      $query['user_tel'] = $data['user_tel'];
    
    }
    if ($data['card_id']) {
    
      $query['card_id'] = $data['card_id'];
    
    }
    if ($data['status']) {
    
      $query['status'] = $data['status'];
    
    }
    if ($data['reg_start_time']) {
    
      $query['reg_time'] = "eg|{$data['reg_start_time']}";
    
    }
    if ($data['reg_end_time']) {
    
      $query['reg_time'] = strlen($query['reg_time']) ? "{$query['reg_time']};el|{$data['reg_end_time']}" : "el|{$data['reg_end_time']}";
    
    }

    $query['is_system'] = 0;

    $fields = $data['fields'] ? $data['fields'] : '*';

    $order = $data['order'] ? $data['order'] : 'uid desc';

    return self::queryList($query, $fields, $order, $data['page'], $data['pageSize']);
  
  }

}
