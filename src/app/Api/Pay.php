<?php
namespace App\Api;

use PhalApi\Api;
use App\Domain\PayDm;

/**
 * 16.1 支付通知处理接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-01
 */

class Pay extends BaseApi {
    
    public function getRules() {
      return $this->rules(array(
          'wechatPay' => array(

          ),

      ));
    }
    
    /**
     * 处理微信支付回调接口
     * @desc 
     * @return int ret 操作状态：200表示成功
     * @return string data Xml格式字符串
     * @return string msg 错误提示
     */
    public function wechatPayNotify() {

      $data = file_get_contents("php://input");

      return $this->dm->wechatPayNotify($data);

    }

}
