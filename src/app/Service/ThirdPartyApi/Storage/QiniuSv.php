<?php
namespace App\Service\ThirdPartyApi\Storage;

use Core\Service\Service;
use App\Interfaces\ThirdPartyApi\IStorage;
use App\Service\BaseService;
use App\Service\System\ConfigSv as C;
use Qiniu\Auth;

/**
 * 七牛云存储api
 *
 * @author Meroc Chen <398515393@qq.com> 2017-10-20
 */
class QiniuSv extends BaseService implements IStorage {

  protected static $_auth;

  public static function getAuth() {

    if (!self::$_auth) {
 
      $accessKey = C::getConfigValueByKey('qiniu_access_key');
  
      $secretKey = C::getConfigValueByKey('qiniu_access_secret');

      self::$_auth = new Auth($accessKey, $secretKey);

    }

    return self::$_auth;

  }

  /**
   * 获取七牛的上传凭证
   *
   * @param string $bucketName  存储空间名称
   *
   * @return string $token
   */
  public function getUploadToken($bucket = 'qiniu_bucket_coupon') {

    $expire = C::getConfigValueBykey('qiniu_token_expire_time');
    
    $bucketName = C::getConfigValueByKey($bucket);

    $returnBody = array(
    
      'key' => "$(key)",

      'hash' => "$(etag)",

      'bucket' => "$(bucket)",

      'name' => "$(x:name)"
    
    );

    $policy = array(
    
      'returnBody' => json_encode($returnBody)
    
    );

    return self::getAuth()->uploadToken($bucketName, null, $expire, $policy, true);
  
  }

}
