<?php

namespace App\Domain;

use App\Service\System\ShortMessageSv;

/**
 * 短信发送接口类
 * 
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-09-25
 */
class ShortMessageDm {
  
    /**
     * 短信发送
     */
    public function send($data){

        return ShortMessageSv::send($data);

    }

    /**
     * 短信验证
     */
    public function sendVerification($data){

        return ShortMessageSv::sendVerification($data);

    }

}