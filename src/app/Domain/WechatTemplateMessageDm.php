<?php
namespace App\Domain;

use App\Service\Wechat\WechatTemplateMessageSv;

/**
 * 微信模版消息类
 * 
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-12-01
 */
class WechatTemplateMessageDm {

  /**
   * 添加微信消息模版
   */
  public function add($data) {
  
    return WechatTemplateMessageSv::addTemplate($data);
  
  }

  /**
   * 公众号消息推送
   */
  public function generalMessage($params) {
      
    return WechatTemplateMessageSv::generalMessage($params);

  }

  /**
   * 获取所有消息模版
   */
  public function getAllTemplates() {
  
    return WechatTemplateMessageSv::getAllTemplates();
  
  }

  /**
   * 获取消息模版id
   */
  public function getTemplateId($data) {
  
    return WechatTemplateMessageSv::getTemplateId($data['short_id']);
  
  }

  /**
   * 获取模版id列表
   */
  public function getList() {
  
    return WechatTemplateMessageSv::getList();
  
  }

}

