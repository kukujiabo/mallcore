<?php
namespace App\Service\CouponExchange;

use App\Service\BaseService;
use App\Interfaces\CouponExchange\ICouponVerificationLog;
use App\Model\CouponVerificationLog;
use Core\Service\CurdSv;
use App\Exception\CouponVerificationLogException;
use PhalApi\Exception;
use App\Exception\ErrorCode;

/**
 * 提领券核销记录接口
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-12-04
 */
class CouponVerificationLogSv extends BaseService implements ICouponVerificationLog {

  use CurdSv;

}
