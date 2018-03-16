<?php
namespace App\Domain;

use App\Service\Message\MemberMessageSv;

/**
 * 会员消息服务
 * 
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2018-01-09
 */
class MemberMessageDm {

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return MemberMessageSv::getLists($condition);
  
  }

}
