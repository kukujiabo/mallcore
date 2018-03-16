<?php
namespace App\Api;

use PhalApi\Api;
use App\Exception\ErrorCode;
use PhalApi\Exception;

/**
 * 22.1 微信模版消息接口服务
 *
 * @author: Meroc Chen <398515393@qq.com> 2018-01-04
 */

class WechatTemplateMessage extends BaseApi {

  /**
   * 接口参数规则
   */
  public function getRules() {

    return $this->rules(array(

      'add' => array(
      
        'short_id' => 'short_id|string|true||模版短id',

        'icon' => 'icon|string|false||模版图标'
      
      ),

      'generalMessage' => array(

        'card_id' => 'card_id|string|false||会员线下卡号',

        'uid' => 'uid|string|false||会员线上uid',

        'mobile' => 'mobile|string|false||会员手机号',

        'openid' => 'openid|string|false||会员openid',

        'url' => 'url|string|false||模板跳转链接',

        'short_id' => 'short_id|string|false||模版编号',

        'miniappid' => 'miniappid|string|false|1|跳小程序所需数据，不需跳小程序可不用传该数据 1-不需要 2-需要',

        'minipage' => 'minipage|string|false||跳转小程序模版类型',

        'object_id' => 'object_id|string|false||相关单号',

        'topcolor' => 'topcolor|string|false|#ff0000|顶部颜色',

        'template_id' => 'template_id|string|false||推送模版id',

        'contents' => 'contents|string|false||通用参数字符串,eg:first$$积分消息||productType$$生鲜||name$$大龙虾||points$$10||date$$2018-01-04||remark$$快快分享吧！',
      
      ),

      'getAllTemplate' => array(
      
      
      ),

      'getTemplateId' => array(
      
        'short_id' => 'short_id|string|false||模版编号'
      
      )

    ));

  }

  /**
   * 添加微信消息模版
   * @desc 添加微信消息模版
   *
   * @return int ret 操作状态：200表示成功
   * @return boolean true/false 操作状态
   * @return string msg 错误提示
   */
  public function add() {
  
    return $this->dm->add($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 微信公众号推送
   * @desc url和miniprogram都是非必填字段，若都不传则模板无跳转。若都传，会优先跳转至小程序。当用户的微信客户端版本不支持跳小程序时，将会跳转至url。uid、card_id、openid、mobile其中一项必传。
   *
   * @return int ret 操作状态：200表示成功
   * @return int data 表序号
   * @return string msg 错误提示
   */
  public function generalMessage() {

    return $this->dm->generalMessage($params = $this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 获取公众号所有模版
   * @desc 拉取公众号所有模版
   *
   * @return int ret 操作状态：200表示成功
   * @return array list 模版列表
   * @return string msg 错误提示
   */
  public function getAllTemplates() {
  
    return $this->dm->getAllTemplates();
  
  }

  /**
   * 获取公众号模版消息id
   * @desc 获取公众号模版消息id
   *
   * @return int ret 操作状态：200表示成功
   * @return string template_id 模版id
   * @return string msg 错误提示
   */
  public function getTemplateId() {
  
    return $this->dm->getTemplateId($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 获取公众号已添加消息模版列表
   * @desc 获取公众号已添加消息模版列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array list 模版列表
   * @return string msg 错误提示
   */
  public function getList() {

    return $this->dm->getList();
  
  }

}
