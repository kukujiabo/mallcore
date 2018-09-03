<?php
namespace App\Domain;

use App\Service\Wechat\WechatResponseMessageSv;

class WechatResponseMessageDm {

  public function editResponseMessage($data) {
  
    return WechatResponseMessageSv::editResponseMessage($data);
  
  }

  public function getFocusResponse($data) {
  
    return WechatResponseMessageSv::getFocusResponse($data);
  
  }

  public function addKeywordResponse($data) {
  
    return WechatResponseMessageSv::addKeywordResponse($data);
  
  }

}
