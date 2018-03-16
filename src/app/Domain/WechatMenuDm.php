<?php
namespace App\Domain;

use App\Service\Wechat\WechatMenuSv;

/**
 * 微信菜单操作
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-17
 */
class WechatMenuDm {

  /**
   * 创建菜单
   */
  public function create($data) {
  
    return WechatMenuSv::create($data);
  
  }

  /**
   * 拉取微信菜单信息
   */
  public function getMenu() {
  
    return WechatMenuSv::getMenu();
  
  }

}
