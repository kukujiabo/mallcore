<?php namespace App\Api;

use PhalApi\Api;
use App\Domain\MemberMessageDm;

/**
 * 2.12 会员消息服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2018-01-09
 */
class MemberMessage extends BaseApi {

  public function getRules() {

    return $this->rules(array(

      'queryList' => array(

        'way' => 'way|int|true|1|途径 1-前台（会员） 2-后台（管理员）',

        'token' => 'token|string|false||用户令牌',

        'id' => 'id|string|false||表序号',

        'uid' => 'uid|string|false||用户id',
      
        'msgid' => 'msgid|string|false||消息编号',

        'module' => 'module|string|false||所属模块',

        'url' => 'url|string|false||跳转链接',
        
        'title' => 'title|string|false||标题',

        'content' => 'content|string|false||内容',

        'icon' => 'icon|string|false||小程序页面url',

        'ext' => 'ext|string|false||内容',

        'created_at' => 'created_at|string|false||创建时间',

        'pagepath' => 'pagepath|string|false||',

        'appid' => 'appid|string|false||',

        'fields' => 'fields|string|false|*|查询字段',

        'order' => 'order|string|false||排序',

        'page' => 'page|int|true|1|页码',

        'page_size' => 'page_size|int|true|4|每页数据条数'

      ),
      
    ));

  }

  /**
   * 查询会员消息列表
   * @desc 查询会员消息列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return int data.total 数据总条数
   * @return int data.page 当前页码
   * @return array data.list[] 数据队列
   * @return int data.list[].id 表序号
   * @return int data.list[].uid 用户id
   * @return string data.list[].msgid 消息编号
   * @return string data.list[].module 所属模块
   * @return string data.list[].url 跳转链接
   * @return string data.list[].title 标题
   * @return string data.list[].content 内容
   * @return string data.list[].icon 小程序页面url
   * @return string data.list[].ext 内容
   * @return string data.list[].created_at 创建时间
   * @return string data.list[].pagepath 
   * @return string data.list[].appid 
   * @return string msg 错误提示
   */
  public function queryList() {

    $conditions = $this->retriveRuleParams(__FUNCTION__);

    $regulation = array(
    
      'way' => 'required',
    
      'page' => 'required',

      'page_size' => 'required',

    );

    \App\Verification($conditions, $regulation);

    return $this->dm->queryList($conditions);

  }

}
