<?php
namespace App\Domain;

use App\Service\ThirdPartyApi\Storage\QiniuSv;

class QiniuDm {

  public function getUploadToken($bucket) {

    return QiniuSv::getUploadToken($bucket);
  
  }

}
