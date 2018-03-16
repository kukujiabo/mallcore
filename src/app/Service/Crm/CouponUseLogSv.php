<?php 
namespace App\Service\Crm; 

use App\Service\BaseService;
use App\Interfaces\Crm\ICouponUseLog;
use App\Model\CouponUseLog;
use Core\Service\CurdSv;

/**
 *
 * 优惠券使用日志
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-18
 *
 */
class CouponUseLogSv extends BaseService implements ICouponUseLog {

  use CurdSv;

}
