<?php
namespace App\Service\Crm; 

use App\Service\BaseService;
use App\Service\Crm\CouponSv;
use App\Interfaces\Crm\ICouponType;
use App\Model\CouponType;
use Core\Service\CurdSv;
use PhalApi\Exception;

/**
 *
 * 优惠券种类接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-18
 *
 */
class CouponTypeSv extends BaseService implements ICouponType {
  
  use CurdSv;


  /**
   * 1.禁用优惠券种类
   *
   * @param int $id
   *
   * @return boolean true/false
   */
  public function disable($id) {
    $data['status'] = 2;
    $data['update_time'] = date("Y-m-d H:i:s");
    return CouponType::update($id, $data);
  }

  /**
   * 2.启用优惠券种类
   *
   * @param int $id
   *
   * @return boolean true/false
   */
  public function enable($id) {
    $data['status'] = 1;
    $data['update_time'] = date("Y-m-d H:i:s");
    return CouponType::update($id, $data);
  }

  /**
   * 验证优惠券类型是否有效
   * @param int $id 优惠券类型Id
   * @return array 
   */
  public function findActiveOne($id) {

    $time = date("Y-m-d H:i:s");

    $info = self::findOne($id);

    if (!$info) {

      throw new Exception('未找到优惠券类型', 7401);

    } elseif ($info['status'] != 1) {

      throw new Exception('该优惠券类型已失效', 7402);

    } elseif (!$info['last_long']) {
    
      if ($info['term_type'] == 1) {
      
        if ($info['start_time'] > $time) {

        throw new Exception('该优惠券类型还未开始', 7403);

        } elseif ($info['end_time'] < $time) {

        throw new Exception('该优惠券类型已过期', 7404);
      
        }
    
      }

    } elseif ($info['count'] > 0) {

      $where['coupon_type_id'] = $id;

      $count = CouponSv::queryCount($where);

      if ($count >= $info['count']) {

        throw new Exception('该优惠券类型已发放完毕', 7405);

      }

    }

    return $info;

  }

  /**
   * 创建优惠券类型
   *
   * @param array $data
   *
   * @return boolean true/false
   */
  public function createCouponType($data) {

    $newct = array(

      'coupon_name' => $data['coupon_name'],

      'sequence' => $data['coupon_code'],

      'coupon_image' => $data['coupon_image'],

      'deduction_type' => $data['deduction_type'],

      'need_user_level' => $data['need_user_level'],

      'all_shops' => $data['all_shops'],

      'last_long' => $data['last_long'],

      'term_type' => $data['term_type'],

      'status' => $data['status'],

      'count' => $data['count'],

      'max_fetch' => $data['max_fetch'],

      'create_time' => date('Y-m-d H:i:s'),

      'at_least' => $data['at_least'],

      'ext_1' => $data['ext_1'],

      'ext_2' => $data['ext_2'],

      'online_type' => $data['online_type'],

    );

    /**
     * 判断使用门店
     */
    if ($data['all_shops'] == 1) {
    
      $newct['all_shops'] = 1;

      $newct['shop_id'] = 0;

    } else {
    
      $newct['all_shops'] = 0;

      $newct['shop_id'] = $data['shop_id'];
    
    }

    /**
     * 判断有效期类型
     */
    if ($data['term_type'] == 2) {

      if ($data['last_long']) {

        $newct['last_long'] = 1;
      
      } else {
      
        $newct['valid_days'] = ($data['years'] ? $data['years'] : 0) * 365 + ($data['months'] ? $data['months'] : 0) * 30 + ($data['days'] ? $data['days'] : 0);
      
      }

    } else {
    
      $newct['start_time'] = $data['start_time'];

      $newct['end_time'] = $data['end_time'];
    
    }

    /**
     * 判断折扣类型
     */

    if ($data['deduction_type'] == 1) {
    
      $newct['percentage'] = $data['percentage'];
    
    } else {
    
      $newct['money'] = $data['money'];
    
    }

    return self::add($newct);
  
  }

}
