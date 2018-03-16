<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use App\Interfaces\Crm\ICouponGrantLog;
use App\Model\CouponGrantLog;
use Core\Service\CurdSv;

/**
 *
 * 优惠券发放记录
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-18
 *
 */
class CouponGrantLogSv extends BaseService implements ICouponGrantLog {

  use CurdSv;

  /**
   * 获取发放日志联合信息
   *
   * @param array $params
   *
   * @return array $list
   */
  public function couponGrantUnionLog($params) {
  
    return CouponGrantLogUnionSv::getList($params);
  
  }

}
