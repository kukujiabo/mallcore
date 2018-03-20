<?php
namespace App\Common;

use PhalApi\Filter;
use App\Exception\AuthException;
use App\Library\RedisClient;
use App\Exception\ErrorCode;

/**
 * 请求鉴权过滤器
 *
 * @author Meroc chen <398515393@qq.com> 2017-12-02
 */
class AuthFilter implements Filter {

    public function check() {

       $token = \PhalApi\DI()->request->get('token');

       $way = \PhalApi\DI()->request->get('way');

       if ($this->whiteList(\PhalApi\DI()->request->get('service')) || $way != 1) {
       
         return;
       
       }

       //if (empty($token) && $way == 1) {

       //   throw new AuthException(ErrorCode::Auth['TOKEN_MISSED_MSG'], ErrorCode::Auth['TOKEN_MISSED_CODE']);
       //               
       //}

       $member = RedisClient::get('member_info', $token);

       if (empty($member)) {
       
         throw new AuthException(ErrorCode::Auth['TOKEN_EXPIRED_MSG'], ErrorCode::Auth['TOKEN_EXPIRED_CODE']);
       
       }
            
    }

    /**
     * 检查白名单，白名单接口放行
     *
     * @param string $service
     *
     * @return boolean true/false
     */
    protected function whiteList($service) {

      $whiteList = \PhalApi\DI()->config->get('app.service_whitelist');

      return in_array($service, $whiteList);
    
    }

}

