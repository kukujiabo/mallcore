<?php
namespace App\Service\Wechat;

use App\Service\BaseService;
use App\Library\Http;
use App\Service\Wechat\WechatUtilsSv;

/**
 * 获取微信素材服务
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-12-20
 */
class WechatArticleSv extends BaseService {

  /**
   * 拉取微信公众号素材
   *
   * @return array list
   */
  public function getMaterial($data) {
  
    $accessToken = WechatUtilsSv::getAccessToken();

    $url = str_replace('{ACCESS_TOKEN}', $accessToken, \PhalApi\DI()->config->get('wechat.GET_MATERIAL'));

    $info = Http::httpPost($url, json_encode($data));
    
    return json_decode($info, true);
  
  }

}
