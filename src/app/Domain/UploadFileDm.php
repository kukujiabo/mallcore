<?php

namespace App\Domain;

use App\Service\Crm\UploadFileSv;

/**
 * 上传文件处理
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-11-09
 */
class UploadFileDm {

  /**
   * 上传文件处理
   */
  public function fileDispose($data) {

    return UploadFileSv::fileDispose($data['path'], $data['type']);
  
  }

}
