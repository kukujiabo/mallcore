<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use App\Model\CouponGrantLogUnion;
use Core\Service\CurdSv;

/**
 * 【视图】优惠券发放日志联合信息
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-27
 */
class CouponGrantLogUnionSv extends BaseService {

  use CurdSv;

  /**
   * 查询日志列表
   *
   * @param array $params
   *
   * @return array $list
   */
  public function getList($params) {
  
    $page = $params['page'];

    $pageSize = $params['pageSize'];

    $fields = $params['fields'];

    $order = $params['order'];

    $conditions = array();

    $params['member_name'] ? $conditions['member_name'] = $params['member_name'] : '';

    $params['mobile'] ? $conditions['mobile'] = $params['mobile'] : '';

    $params['coupon_code'] ? $conditions['coupon_code'] = $params['coupon_code'] : '';

    $params['sequence'] ? $conditions['sequence'] = $params['sequence'] : '';

    $params['coupon_name'] ? $conditions['coupon_name'] = $params['coupon_name'] : '';

    $params['rule_id'] ? $conditions['rule_id'] = $params['rule_id'] : '';

    if ($params['start_time'] && $params['end_time']) {
    
      $conditions['created_at'] = "eg|{$params['start_time']};el|{$params['end_time']}";
    
    } elseif ($params['start_time']) {

      $conditions['created_at'] = "eg|{$params['start_time']}";
    
    } elseif ($params['end_time']) {

      $conditions['created_at'] = "el|{$params['end_time']}";
    
    }
    
    return self::queryList($conditions, $fields, $order, $page, $pageSize);

  }


}
