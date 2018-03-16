<?php
namespace App\Api;

use PhalApi\Api;
use App\Domain\CouponDm;
use PhalApi\Exception\BadRequestException; 

/**
 * 12.1 七牛云存储管理接口
 *
 * @author Meroc Chen <398515393@qq.com>  2017-11-02
 */

class Qiniu extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(
    
      'getUploadToken' => array(

        'bucket' => 'bucket|string|false||存储空间'
      
      ),
    
    ));
  
  }

  /**
   * 获取上传凭证
   * @desc 获取七牛云存储上传文件凭证
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 上传凭证
   * @return array data.Status 1:操作成功;-1:操作出错
   */
  public function getUploadToken() {

    $data = $this->retriveRuleParams('getUploadToken');

    $bucket = $data['bucket'] ? $data['bucket'] : 'qiniu_bucket_coupon';
  
    return $this->dm->getUploadToken($bucket);
  
  }

}
