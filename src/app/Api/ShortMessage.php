<?php
namespace App\Api;

use PhalApi\Api;
use App\Domain\ShortMessageDm;
use PhalApi\Exception;

/**
 * 5.1 短信接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-09-25
 */

class ShortMessage extends BaseApi {

    public function getRules() {

        return $this->rules(array(

            'send' => array(

                'phone'  => array('name' => 'phone', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '手机号码'),

                'type'  => array('name' => 'type', 'type' => 'int', 'require' => true, 'default' => '', 'desc' => '类型 1-绑定手机 2-修改绑定手机 3-注册 4-修改密码 5-找回密码 6-短信验证登录'),

            ),

            'sendVerification' => array(

                'phone'  => array('name' => 'phone', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '手机号码'),

                'code'  => array('name' => 'code', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '短信验证码'),

                'type'  => array('name' => 'type', 'type' => 'int', 'require' => true, 'default' => '', 'desc' => '类型 1-绑定手机 2-修改绑定手机 3-注册 4-修改密码 5-找回密码 6-短信验证登录'),

            ),

        ));

    }
    
    /**
     * 短信发送接口服务
     * @desc 
     * @return int ret 操作状态：200表示成功
     * @return boolean data true-成功 false-失败
     * @return string msg 错误提示
     */
    public function send() {

        $params = $this->retriveRuleParams('send');

        $regulation['phone'] = 'required|phone';

        \App\Verification($params, $regulation);

        return $this->dm->send($params);

    }
    
    /**
     * 短信验证接口服务
     * @desc 
     * @return int ret 操作状态：200表示成功
     * @return boolean data true-验证通过 false-验证失败
     * @return string msg 错误提示
     */
    public function sendVerification() {

        $params = $this->retriveRuleParams('sendVerification');

        $regulation['phone'] = 'required|phone';

        $regulation['code'] = 'required';

        \App\Verification($params, $regulation);

        return $this->dm->sendVerification($params);

    }

}
