<?php
namespace App\Service\Wechat; 

use App\Service\BaseService;
use App\Interfaces\Wechat\IWechatSubscribeLog;
use PhalApi\Exception;
use App\Exception\WechatException;
use App\Exception\ErrorCode;
use App\Model\WechatSubscribeLog;
use Core\Service\CurdSv;

/**
 *
 * 微信关注记录接口类
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-12-09
 *
 */
class WechatSubscribeLogSv extends BaseService implements IWechatSubscribeLog {

    use CurdSv;

}
