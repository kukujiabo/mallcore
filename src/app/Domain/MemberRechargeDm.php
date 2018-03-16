<?php
namespace App\Domain;

use App\Service\Crm\MemberRechargeSv;

/**
 * 用户充值
 *
 * @author Meroc Chen <398515393@qq.com> 2017-11-27
 */
class MemberRechargeDm {

  /**
   * 小程序充值
   */
  public function miniRecharge($data) {

    return MemberRechargeSv::doRecharge($data);
  
  }

}
