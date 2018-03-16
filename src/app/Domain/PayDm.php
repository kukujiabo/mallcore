<?php

namespace App\Domain;

use App\Service\Pay\PaySv;
use PhalApi\Exception;
use App\Service\System\ConfigSv;

/**
 * 支付回调处理类
 * 
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-01
 */
class PayDm {
  
    /**
     * 微信支付回调处理
     */
    public function wechatPayNotify($data){
        //$wechat_replay = $data;
        return PaySv::wechatPayNotify($data);
        /*$wechat_replay ='<xml><appid><![CDATA[wx45b719fc9668e176]]></appid>
        <attach><![CDATA[1-oT44N0WR85iFbY1t9gpy9zZiCMWQ]]></attach>
        <bank_type><![CDATA[CFT]]></bank_type>
        <cash_fee><![CDATA[100]]></cash_fee>
        <device_info><![CDATA[WEB]]></device_info>
        <fee_type><![CDATA[CNY]]></fee_type>
        <is_subscribe><![CDATA[Y]]></is_subscribe>
        <mch_id><![CDATA[1368043902]]></mch_id>
        <nonce_str><![CDATA[f442d33fa06832082290ad8544a8da27]]></nonce_str>
        <openid><![CDATA[o7KufwZVBghY5KjnZ2lJ4iO4jZM8]]></openid>
        <out_trade_no><![CDATA[201704290202081357154]]></out_trade_no>
        <result_code><![CDATA[SUCCESS]]></result_code>
        <return_code><![CDATA[SUCCESS]]></return_code>
        <sign><![CDATA[E16C43F2B11B88547670F7A7CA3A8084]]></sign>
        <time_end><![CDATA[20170429020225]]></time_end>
        <total_fee>10000</total_fee>
        <trade_type><![CDATA[JSAPI]]></trade_type>
        <transaction_id><![CDATA[4005632001201704298741045130]]></transaction_id>
        </xml>';*/

        /*
        $wechat_replay_result = json_decode(json_encode(simplexml_load_string($wechat_replay, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

        if ($wechat_replay_result['result_code'] == 'SUCCESS') {
            //验证签名
            $signure = $wechat_replay_result['sign'];
            unset($wechat_replay_result['sign']);
            ksort($wechat_replay_result);
            if($wechat_replay_result['trade_type'] == 'JSAPI' ){
                $wechat_replay_result['key'] = ConfigSv::getConfigValueByKey('ruixuan_mini_pay_key');
            }
            if($wechat_replay_result['trade_type'] == 'NATIVE' ){
                $wechat_replay_result['key'] = ConfigSv::getConfigValueByKey('ruixuan_mini_pay_key');
            }
            if($wechat_replay_result['trade_type'] == 'APP' ){
                $wechat_replay_result['key'] = ConfigSv::getConfigValueByKey('ruixuan_mini_pay_key');
            }
            $sign_str = '';
            foreach ($wechat_replay_result as $key => $val) {
                $sign_str .= $key . '=' . $val . '&';
            }
            $sign_str = substr($sign_str, 0, strlen($sign_str) - 1);
            $local_sign = strtoupper(md5($sign_str));
            $replay_array = array();
            if ($local_sign != $signure) {
                $replay_array['return_code'] = 'FAIL';
                $replay_array['return_msg'] = 'different sign';
            } else {                                               //签名通过
                $replay_array['return_code'] = 'SUCCESS';
                $replay_array['return_msg'] = 'OK';
                PaySv::wechatPay($wechat_replay_result);
            }
        } else {
            $replay_array['return_code'] = 'SUCCESS';
        }

        $xml = PaySv::_createXml($replay_array);
         */

        //return $xml;

    }


}
