<?php
namespace App\Domain;

use App\Service\Crm\ShareRecordSv;

/**
 * 分享记录
 * 
 * @author Meroc Chen <398515393@qq.com> 2017-11-20
 */
class ShareRecordDm {

  public function add($data) {
  
    return ShareRecordSv::add($data);
  
  }

}
