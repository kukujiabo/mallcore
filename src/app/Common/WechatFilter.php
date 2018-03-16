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
class WechatFilter implements Filter {

    public function check() {

       if ($this->whiteList(\PhalApi\DI()->request->get('service'))) {
       
         return;
       
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

      $whiteList = \PhalApi\DI()->config->get('app.wechat_whitelist');

      return in_array($service, $whiteList);
    
    }
}
