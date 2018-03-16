<?php
namespace App\Domain;

use App\Service\Wechat\WechatMiniSv;

/**
 * 微信小程序服务
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-28
 */
class WechatMiniDm {

  /**
   * 添加小程序
   */
  public function add($params) {
  
    return WechatMiniSv::add($params);
  
  }

  /**
   * 查询小程序列表
   */
  public function queryList() {
  
    return WechatMiniSv::getList($params);
  
  }

  /**
   * 更新小程序信息
   */
  public function update($params) {
  
    return WechatMiniSv::edit($params); 

  }

}
