<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\UploadFileDm;

/**
 * 4.2 文件处理接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-09
 */
class UploadFile extends BaseApi {

  public function getRules() {

    return $this->rules(array(

      'fileDispose' => array(

        'path' => 'path|string|true||上传文件保存路径',
        'type' => 'type|int|true|1|排列方式 1-纵向队列 2-横向队列',

      ),
      
    ));

  }

  /**
   * 上传文件处理
   * @desc 
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果数据
   * @return array data.total 数据总条数
   * @return array data.list[] 数据队列
   * @return string msg 错误提示
   */
  public function fileDispose() {

    $params = $this->retriveRuleParams('fileDispose');

    $regulation = array(
      'path' => 'required',
      'type' => 'required',
    );

    \App\Verification($params, $regulation);

    return $this->dm->fileDispose($params);
  
  }

}
