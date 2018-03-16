<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use Core\Service\CurdSv;

/**
 * 会员领取优惠券列表
 *
 * @author Meroc Chen <398515393@qq.com> 2018-01-28
 */
class CouponGetListSv extends BaseService {

  use CurdSv;

  /**
   * 查询优惠券领取列表
   *
   * @param array   $data
   * @param int     $data.coupon_type_id      优惠券类型id
   * @param string  $data.coupon_name
   * @param string  $data.coupon_code
   * @param string  $data.member_name
   * @param string  $data.user_tel
   * @param string  $data.state
   * @param string  $data.last_long
   * @param string  $data.online_type
   * @param string  $data.get_start_date
   * @param string  $data.get_end_date
   * @param string  $data.use_start_date
   * @param string  $data.use_end_date
   * @param string  $data.validate_start_date
   * @param string  $data.validate_end_date
   * @param int $page
   * @param int $page_size
   *
   * @return array $list
   */
  public function getList($data, $page, $page_size) {
  
    return self::queryList($data, '*', 'id desc', $page, $page_size);
  
  }

}
