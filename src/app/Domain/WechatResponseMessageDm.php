<?php
namespace App\Domain;

use App\Service\Wechat\WechatResponseMessageSv;

class WechatResponseMessageDm {

  public function editDefaultMessage($data) {
  
    return WechatResponseMessageSv::editDefaultMessage($data);
  
  }

  public function getDefaultMessage($data) {
  
    return WechatResponseMessageSv::getDefaultMessage($data);
  
  }

  public function editResponseMessage($data) {
  
    return WechatResponseMessageSv::editResponseMessage($data);
  
  }

  public function getFocusResponse($data) {
  
    return WechatResponseMessageSv::getFocusResponse($data);
  
  }

  public function addKeywordResponse($data) {
  
    return WechatResponseMessageSv::addKeywordResponse($data);
  
  }

  public function getKeywordList($data) {
  
    return WechatResponseMessageSv::getKeywordList($data);
  
  }

  public function deleteKeyword($data) {
  
    return WechatResponseMessageSv::deleteKeyword($data);
  
  }

}
